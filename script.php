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
$email = $_POST['email'];
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
  $email,
  $country,
  $serial,
  $authority
);

$generator->genCertsDir();
$generator->genFiles();

new OutputGeneratedFiles($name, $organization, $password, $generator, $authority);

// header('Location: /success.html');

$userController = new UsersController();

$userController->addUser(
  $name,
  $organization,
  $organization_unit,
  $validity,
  $password,
  $email,
  $country
);

$email = new Mail($name, $email, $organization);
$email->send();
