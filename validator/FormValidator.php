<?php
class FormValidator extends Validators {
  private $config;

  public function __construct($config) {
    session_start();

    $_SESSION['errors'] = [];
    $_SESSION['values'] = [];

    $this->config = $config;
  }

  public function validate() {
    foreach ($this->config as $validator => $config) {
      foreach ($config['inputs'] as $input) {
        $this->validateInput(
          $input,
          array($this, $validator),
          $config['errMessage']
        );
      }
    }

    $this->redirect();
  }

  private function validateInput($input, $validator, $errMessage) {
    $value = $_POST[$input];

    if (!$validator($value)) {
      $_SESSION['errors'][$input] = $errMessage;
    }

    $_SESSION['values'][$input] = $value;
  }

  private function redirect() {
    if (!empty($_SESSION['errors'])) {
      header('Location: /');

      exit();
    }
  }
}
