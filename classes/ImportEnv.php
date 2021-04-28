<?php
class ImportEnv { 
  public function __construct() {
    if (!isset($_ENV['PHP_ENV'])) {
      $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
      $dotenv->load();
    }
  }
}
