<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {
  const HOST = 'smtp-mail.outlook.com';
  const USER_NAME = 'yosrimhamdi@outlook.com';
  const PASSWORD = 'rp)(qV$u@_m_nb_f279_';
  const PORT = 587;

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
      $this->mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
      $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $this->mail->Username   = 'yosrimhamdi@outlook.com';                     //SMTP username
      $this->mail->Password   = 'rp)(qV$u@_m_nb_f279_';                               //SMTP password
      $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $this->mail->Port       = 587;
      //Recipients
      $this->mail->setFrom(self::USER_NAME, 'yosri mhamdi');
      $this->mail->addAddress('bavary1515@gmail.com', 'Joe User');

      //Attachments
      $test = str_replace(' ', '-', $this->userName .  '-' . $this->organization);
      $this->mail->addAttachment($this->root . "/pki/certs/$test/$test.p12", "$test.p12");    //Optional name;

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
