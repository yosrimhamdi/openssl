<?php
class UsersController extends Users {
  public function addUser(
    $name,
    $organization,
    $organization_unit,
    $validity,
    $password,
    $email,
    $country
  ) {
    $hashedPassword = $this->hashPassword($password);

    parent::addUser(
      $name,
      $organization,
      $organization_unit,
      $validity,
      $hashedPassword,
      $email,
      $country
    );
  }

  private function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);;
  }
}
