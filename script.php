<?php include_once 'vendor/autoload.php' ?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$NAME         = $_POST['np'];
$ORGANIZATION     = $_POST['org'];
$ORGANIZATION_UNIT     = $_POST['dept'];
$VALIDITY      = $_POST['validite'];
$PASSWORD       = $_POST['mp'];
$MAIL         = $_POST['mail'];

// CONSTANTS DECLARATION
define('CIPHER_ALGO', OPENSSL_KEYTYPE_RSA);
define('DIGEST_ALGO', 'sha256');
define('KEY_SIZE', 2048);
$PATH_TO_CA_CERTIFICATE   = "pki/ca/fsb.crt";
$PATH_TO_CA_KEY     = "pki/ca/fsb.key";

// VARIABLE DECLARATION
$COUNTRY      = "TN";
$SERIAL        = "12345678";

$KEY_USER_DETAILS = [
  'digest_alg'   => DIGEST_ALGO,
  'private_key_type'   => CIPHER_ALGO,
  'private_key_bits'   => KEY_SIZE
];

$USER_DN = [
  "countryName"     => $COUNTRY,
  "organizationName"     => $ORGANIZATION,
  "organizationalUnitName"   => $ORGANIZATION_UNIT,
  "commonName"       => $NAME,
  "emailAddress"       => $MAIL
];

$CA_CERTIFICATE   = file_get_contents($PATH_TO_CA_CERTIFICATE);
$CA_PRIVATE_KEY   = [file_get_contents($PATH_TO_CA_KEY), "azerty"];

$P12_ARRAY = [
  'extracerts'       => $CA_CERTIFICATE,
  'friendly_name'     => $NAME
];

$CLIENT_KEY_PAIR = openssl_pkey_new($KEY_USER_DETAILS);  // GENERATE 2048 RSA PRIVATE KEY
openssl_pkey_export($CLIENT_KEY_PAIR, $PRIVATE_KEY, $PASSWORD);  // EXTRACT AND PROTECT PRIVATE KEY WITH PASSWORD
$RESULT = openssl_pkey_get_details($CLIENT_KEY_PAIR);        // EXTRACT KEY DETAILS
$PUBLIC_KEY = $RESULT["key"];                                                       // EXTRACT PUBLIC KEY
$USER_REQUEST = openssl_csr_new($USER_DN, $CLIENT_KEY_PAIR);  // USER REQUEST CREATION
$USER_CERTIFICATE = openssl_csr_sign($USER_REQUEST, $CA_CERTIFICATE, $CA_PRIVATE_KEY, $VALIDITY, ['digest_alg' => DIGEST_ALGO], $SERIAL);  // SIGNE USER REQUEST / CERTIFICATE GENERATION

$NAME_DIR = $_SERVER['DOCUMENT_ROOT'] . "/pki/certs/" . $NAME . "-" . $ORGANIZATION; // FOLDER AND FILE CREATION
$NAME_DIR = str_replace(' ', '-', $NAME_DIR);

$NAME_FILE = str_replace(" ", "-", $NAME);

if (!file_exists($NAME_DIR)) {
  mkdir($NAME_DIR);
}

file_put_contents($NAME_DIR . "/" . $NAME_FILE . ".private.key", $PRIVATE_KEY);
file_put_contents($NAME_DIR . "/" . $NAME_FILE . ".public.key", $PUBLIC_KEY);
openssl_csr_export($USER_REQUEST, $REQ_CONTENT);
file_put_contents($NAME_DIR . "/" . $NAME_FILE . ".req", $REQ_CONTENT);
openssl_x509_export($USER_CERTIFICATE, $USER_CERTIFICATE_CONTENT);
file_put_contents($NAME_DIR . "/" . $NAME_FILE . ".crt", $USER_CERTIFICATE_CONTENT);
openssl_pkcs12_export_to_file($USER_CERTIFICATE, $NAME_DIR . "/" . $NAME_FILE . ".p12", $CLIENT_KEY_PAIR, $PASSWORD, $P12_ARRAY);


// header('Location: /success.html');

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
  //Server settings
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host       = 'smtp.mandrillapp.com';                     //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = 'yosri';                     //SMTP username
  $mail->Password   = 'xXPuZzGURNY58UfDVoVUfQ';                               //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
  $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

  //Recipients
  $mail->setFrom('from@example.com', 'Mailer');
  $mail->addAddress('bavary1515@gmail.com', 'Joe User');     //Add a recipient

  //Attachments
  $mail->addAttachment($NAME_DIR . '/' . $NAME_FILE . '.p12');         //Add attachments

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Here is the subject';
  $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  $mail->send();
  echo 'Message has been sent';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
