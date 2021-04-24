<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {
  const HOST = 'smtp-mail.outlook.com';
  const USER_NAME = 'yosrimhamdi@outlook.com';
  const PASSWORD = 'rp)(qV$u@_m_nb_f279_';
  const PORT = 587;

  private $mail;
  private $root;

  public function __construct() {
    $this->mail = new PHPMailer(true);
    $this->root = $_SERVER['DOCUMENT_ROOT'];
  }

  public function send() {
    try {
      //Server settings
      $this->mail->SMTPDebug  = SMTP::DEBUG_SERVER;
      $this->mail->isSMTP();
      $this->mail->Host       = self::HOST;
      $this->mail->SMTPAuth   = true;
      $this->mail->Username   = self::USER_NAME;
      $this->mail->Password   = self::PASSWORD;
      $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $this->mail->Port       = self::PORT;

      //Recipients
      $this->mail->setFrom(self::USER_NAME, 'yosri mhamdi');
      $this->mail->addAddress('bavary1515@gmail.com', 'Joe User');

      //Attachments
      // $this->mail->addAttachment($this->root . '/pki/certs/okayuit/okayuit.p12', 'okayuit.p12');    //Optional name

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
