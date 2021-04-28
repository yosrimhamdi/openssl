<?php
class Validators {
  protected function hasValue($value) {
    return !empty($value);
  }

  protected function isEmail($email) {
    return voku\helper\EmailCheck::isValid($email, true);
  }

  protected function isPassword($password) {
    return strlen($password) >= 8;
  }
}
