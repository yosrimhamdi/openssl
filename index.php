<?php require 'vendor/autoload.php' ?>
<?php session_start();

$name = 'np';
$name = [
  FormValidator::getClassName($name),
  FormValidator::getValue($name),
  FormValidator::getError($name),
];

$password = 'mp';
$password = [
  FormValidator::getClassName($password),
  FormValidator::getValue($password),
  FormValidator::getError($password),
];

$organization = 'org';
$organization = [
  FormValidator::getClassName($organization),
  FormValidator::getValue($organization),
  FormValidator::getError($organization),
];

$departement = 'dept';
$departement = [
  FormValidator::getClassName($departement),
  FormValidator::getValue($departement),
  FormValidator::getError($departement),
];

$email = 'email';
$email = [
  FormValidator::getClassName($email),
  FormValidator::getValue($email),
  FormValidator::getError($email),
];

session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>p12 authentication</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="assets/main.css" />
  </head>
  <body>
    <div class="registration-form">
      <form action="/script.php" method="POST">
        <div class="form-icon">
          <span><i class="icon icon-user"></i></span>
        </div>
        <div class="form-group">
          <input
            type="text"
            class="<?php echo $name[0] ?>"
            name="np"
            placeholder="Username"
            value="<?php echo $name[1] ?>"
          />
          <div class="invalid-feedback"><?php echo $name[2] ?></div>
        </div>
        <div class="form-group">
          <input
            type="text"
            class="<?php echo $organization[0] ?>"
            name="org"
            placeholder="Organization"
            value="<?php echo $organization[1] ?>"
          />
          <div class="invalid-feedback"><?php echo $organization[2] ?></div>
        </div>
        <div class="form-group">
          <input
            type="text"
            class="<?php echo $departement[0] ?>"
            name="dept"
            placeholder="Department"
            value="<?php echo $departement[1] ?>"
          />
          <div class="invalid-feedback"><?php echo $departement[2] ?></div>
        </div>
        <div class="form-group">
          <select
            class="form-select item select"
            aria-label="Default select example"
            name="validite"
          >
            <option value="365" selected>Validite: one year</option>
            <option value="730">Validite: two years</option>
            <option value="1095">Validite: three years</option>
          </select>
        </div>
        <div class="form-group">
          <input
            type="password"
            class="<?php echo $password[0] ?>"
            name="mp"
            placeholder="Password"
            value="<?php echo $password[1] ?>"
          />
          <div class="invalid-feedback"><?php echo $password[2] ?></div>
        </div>
        <div class="form-group">
          <input
            type="text"
            class="<?php echo $email[0] ?>"
            name="email"
            placeholder="Email"
            value="<?php echo $email[1] ?>"
          />
          <div class="invalid-feedback"><?php echo $email[2] ?></div>
        </div>
        <div class="form-group">
          <input
            name="submit"
            type="submit"
            value="Receive p12 file"
            class="btn btn-block create-account"
          />
        </div>
      </form>
    </div>
  </body>
</html>
