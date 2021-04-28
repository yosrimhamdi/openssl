<?php
class Getter  {
  public static function getValue($input) {
    if (isset($_SESSION['values'])) {
      return $_SESSION['values'][$input];
    }
  }

  public static function getError($input) {
    if (isset($_SESSION['errors']) && isset($_SESSION['errors'][$input])) {
      return $_SESSION['errors'][$input];
    }
  }

  public static function getClassName($input) {
    if (isset($_SESSION['errors'][$input])) {
      return 'form-control item is-invalid';
    } else {
      return 'form-control item';
    }
  }
}
