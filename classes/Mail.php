<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {
  private $userName;
  private $organization;
  private $mail;
  private $root;

  public function __construct($userName, $organization) {
    $this->userName = $userName;
    $this->organization = $organization;
    $this->mail = new PHPMailer(true);
    $this->root = $_SERVER['DOCUMENT_ROOT'];
  }

  public function send() {
    try {
      //Server settings
      $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $this->mail->isSMTP();                                            //Send using SMTP
      $this->mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
      $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $this->mail->Username   = $_ENV['MAIL_USERNAME'];                     //SMTP username
      $this->mail->Password   = $_ENV['MAIL_USER_PASSWORD'];                               //SMTP password
      $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $this->mail->Port       = $_ENV['MAIL_PORT'];
      //Recipients
      $this->mail->setFrom('test@gmail.com', 'yosri mhamdi');
      $this->mail->addAddress('bavary1515@gmail.com', 'Joe User');

      //Attachments
      $test = str_replace(' ', '-', $this->userName .  '-' . $this->organization);
      // $this->mail->addAttachment($this->root . "/pki/certs/$test/$test.p12", "$test.p12");    //Optional name;

      //Content
      $this->mail->isHTML(true);
      $this->mail->Subject = 'Here is the subject';
      $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
      $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $this->mail->send();
      echo 'Message has been sent';
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    }
  }
}
