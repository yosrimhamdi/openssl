<?php
class UsersController extends Users {
  public function addUser(
    $name,
    $organization,
    $organization_unit,
    $validity,
    $password,
    $mail,
    $country
  ) {
    parent::addUser(
      $name,
      $organization,
      $organization_unit,
      $validity,
      $password,
      $mail,
      $country
    );
  }
}
