<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {
  private $name;
  private $organization;
  private $email;
  private $root;

  public function __construct($name, $email, $organization) {
    $this->name = $name;
    $this->email = $email;
    $this->organization = $organization;

    $this->root = $_SERVER['DOCUMENT_ROOT'];
  }

  public function send() {
    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = $_ENV['MAIL_USERNAME'];                     //SMTP username
      $mail->Password   = $_ENV['MAIL_USER_PASSWORD'];                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = $_ENV['MAIL_PORT'];
      //Recipients
      $mail->setFrom('bavary1515@gmail.com', 'yosri mhamdi');
      $mail->addAddress($this->email, $this->name);

      //Attachments
      $test = str_replace(' ', '-', $this->name .  '-' . $this->organization);
      $mail->addAttachment($this->root . "/pki/certs/$test/$test.p12", "$test.p12");    //Optional name;

      //Content
      $mailTemplate = file_get_contents($this->root . '/mail/template.html');

      $mail->isHTML(true);
      $mail->Subject = 'P12 Authentication File';
      $mail->Body    = $mailTemplate;
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();
      echo 'Message has been sent';
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}
