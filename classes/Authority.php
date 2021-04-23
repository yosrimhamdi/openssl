<?php
class Authority {
  const KEY_PATH = '/pki/ca/fsb.key';
  const CERT_PATH = '/pki/ca/fsb.crt';
  const PRRIVATE_KEY_PASS = 'azerty';

  public $certificate;
  public $key;


  function __construct() {
    $root = $_SERVER['DOCUMENT_ROOT'];

    $this->key = [
      file_get_contents($root . self::KEY_PATH),
      self::PRRIVATE_KEY_PASS
    ];
    $this->certificate = file_get_contents($root . self::CERT_PATH);
  }
}
