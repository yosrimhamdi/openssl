<?php
class Getter  {
  public function __construct() {
    session_start();
  }

  public function get($ref, $input) {
    return $_SESSION[$ref][$input] ?? '';
  }

  public function getClass($input) {
    return isset($_SESSION['errors'][$input]) ? 'form-control item is-invalid' : 'form-control item';
  }
}
