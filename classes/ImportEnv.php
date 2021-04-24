<?php
class ImportEnv {
  public function __construct() {
    if (!isset($_ENV['PHP_ENV'])) {
      $dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
      $dotenv->load();
    }
  }
}
