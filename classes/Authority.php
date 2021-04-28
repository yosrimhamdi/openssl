<?php
class Authority {
  public $certificate;
  public $key;


  function __construct() {
    $root = $_SERVER['DOCUMENT_ROOT'];

    $this->key = [
      file_get_contents($root . '/pki/ca/fsb.key'),
      $_ENV['CA_PRRIVATE_KEY_PASS']
    ];
    $this->certificate = file_get_contents($root . '/pki/ca/fsb.crt');
  }
}
