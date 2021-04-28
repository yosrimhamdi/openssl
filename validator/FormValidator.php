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

    $this->next();
  }

  private function validateInput($input, $validator, $errMessage) {
    $value = $_POST[$input];

    if (!$validator($value)) {
      $_SESSION['errors'][$input] = $errMessage;
    }

    $_SESSION['values'][$input] = $value;
  }

  private function next() {
    if (empty($_SESSION['errors'])) {
      session_close();
    } else {
      redirect('/');
    }
  }
}
