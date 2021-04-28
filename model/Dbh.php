<?php
class Dbh {
  protected $pdo;

  public function __construct() {
    $this->pdo = new PDO(
      "mysql:dbname=$_ENV[DB_NAME];host=$_ENV[DB_HOST]",
      $_ENV['DB_USER'],
      $_ENV['DB_PASSWORD']
    );

    $this->pdo->setAttribute(
      PDO::ATTR_DEFAULT_FETCH_MODE,
      PDO::FETCH_ASSOC
    );
  }
}
