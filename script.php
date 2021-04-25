<?php require 'vendor/autoload.php' ?>
<?php

if (!isset($_POST['submit'])) {
  header('Location: /');

  exit();
}

$name = $_POST['np'];
$organization = $_POST['org'];
$organization_unit = $_POST['dept'];
$validity = $_POST['validite'];
$password = $_POST['mp'];
$mail = $_POST['mail'];
$country = 'TN';
$serial = '12345678';

new ImportEnv();

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

$generator->genCertsDir();
$generator->genFiles();

new OutputGeneratedFiles($name, $organization, $password, $generator, $authority);

header('Location: /success.html');

$userController = new UsersController();

$userController->addUser(
  $name,
  $organization,
  $organization_unit,
  $validity,
  $password,
  $mail,
  $country
);

$mail = new Mail($name, $organization);
$mail->send();
