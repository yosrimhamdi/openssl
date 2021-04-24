<?php
class Users extends Dbh {
  protected function addUser(
    $name,
    $organization,
    $organization_unit,
    $validity,
    $password,
    $mail,
    $country
  ) {
    $sql  = "INSERT INTO users(name, ";
    $sql .= "                  organization, ";
    $sql .= "                  organization_unit, ";
    $sql .= "                  validity, ";
    $sql .= "                  password, ";
    $sql .= "                  email, ";
    $sql .= "                  country ";
    $sql .= "                  ) ";
    $sql .= "VALUES(?, ?, ?, ?, ?, ?, ?)";


    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      $name,
      $organization,
      $organization_unit,
      $validity,
      $password,
      $mail,
      $country
    ]);
  }
}
