<?php
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

$KEY_USER_DETAILS = array(
  'digest_alg'   => DIGEST_ALGO,
  'private_key_type'   => CIPHER_ALGO,
  'private_key_bits'   => KEY_SIZE
);

$USER_DN = array(
  "countryName"     => $COUNTRY,
  "organizationName"     => $ORGANIZATION,
  "organizationalUnitName"   => $ORGANIZATION_UNIT,
  "commonName"       => $NAME,
  "emailAddress"       => $MAIL
);

$CA_CERTIFICATE   = file_get_contents($PATH_TO_CA_CERTIFICATE);
$CA_PRIVATE_KEY   = array(file_get_contents($PATH_TO_CA_KEY), "azerty");

$P12_ARRAY = array(
  'extracerts'       => $CA_CERTIFICATE,
  'friendly_name'     => $NAME
);

$CLIENT_KEY_PAIR = openssl_pkey_new($KEY_USER_DETAILS);  // GENERATE 2048 RSA PRIVATE KEY
openssl_pkey_export($CLIENT_KEY_PAIR, $PRIVATE_KEY, $PASSWORD);  // EXTRACT AND PROTECT PRIVATE KEY WITH PASSWORD
$RESULT = openssl_pkey_get_details($CLIENT_KEY_PAIR);        // EXTRACT KEY DETAILS
$PUBLIC_KEY = $RESULT["key"];                                                       // EXTRACT PUBLIC KEY
$USER_REQUEST = openssl_csr_new($USER_DN, $CLIENT_KEY_PAIR);  // USER REQUEST CREATION
$USER_CERTIFICATE = openssl_csr_sign($USER_REQUEST, $CA_CERTIFICATE, $CA_PRIVATE_KEY, $VALIDITY, array('digest_alg' => DIGEST_ALGO), $SERIAL);  // SIGNE USER REQUEST / CERTIFICATE GENERATION

$NAME_DIR = "./pki/certs/" . $NAME . "-" . $ORGANIZATION; // FOLDER AND FILE CREATION
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


header('Location: /success.html');
