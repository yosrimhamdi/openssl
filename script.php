<?php require 'vendor/autoload.php' ?>
<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  redirect('/');
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$name = $_POST['np'];
$organization = $_POST['org'];
$organization_unit = $_POST['dept'];
$validity = $_POST['validite'];
$password = $_POST['mp'];
$email = $_POST['email'];
$country = 'TN';
$serial = '12345678';

$config = [
  'hasValue' => [
    'inputs' => ['np', 'org', 'dept'],
    'errMessage' => 'cannot be empty'
  ],
  'isEmail' => [
    'inputs' => ['email'],
    'errMessage' => 'invalid email'
  ],
  'isPassword' => [
    'inputs' => ['mp'],
    'errMessage' => 'passwrod must be at least 8 chars'
  ]
];

$validator = new FormValidator($config);
$validator->validate();

$authority = new Authority();

$generator = new Pki\Generator(
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

header('Location: /success.html');

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
