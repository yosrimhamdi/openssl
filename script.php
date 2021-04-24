<?php require 'vendor/autoload.php' ?>

<?php
if (!file_exists('./pki/certs')) {
  mkdir('./pki/certs');
}

$name = $_POST['np'];
$organization = $_POST['org'];
$organization_unit = $_POST['dept'];
$validity = $_POST['validite'];
$password = $_POST['mp'];
$mail = $_POST['mail'];
$country = 'TN';
$serial = '12345678';

$authority = new Authority();

$generator = new Auth\Generator(
  $name,
  $organization,
  $organization_unit,
  $validity,
  $password,
  $mail,
  $country,
  $serial,
  $authority
);

$generator->genFiles();

new OutputGeneratedFiles($name, $organization, $password, $generator, $authority);

$mail = new Mail($name, $organization);
$mail->send();

// header('Location: /success.html');