<?php

namespace Auth;

class Generator {
  private $name;
  private $organization;
  private $organization_unit;
  private $validity;
  private $password;
  private $mail;
  private $country;
  private $serial;

  private $authority;
  private $files = [];

  function __construct($name, $organization, $organization_unit, $validity, $password, $mail, $country, $serial, $authority) {
    $this->name = $name;
    $this->organization = $organization;
    $this->organization_unit = $organization_unit;
    $this->validity = $validity;
    $this->password = $password;
    $this->mail = $mail;
    $this->country = $country;
    $this->serial = $serial;
    $this->authority = $authority;
  }

  public function genCertsDir() {
    $path = $_SERVER['DOCUMENT_ROOT'] . '/pki/certs';

    if (!file_exists($path)) {
      mkdir($path);
    }
  }

  public function genFiles() {
    $this->files = array_merge($this->files, ['keyPair' => $this->getKeyPair()]);
    $this->files = array_merge($this->files, ['privateKey' => $this->getPrivateKey()]);
    $this->files = array_merge($this->files, ['publicKey' => $this->getPublicKey()]);
    $this->files = array_merge($this->files, ['request' => $this->getRequest()]);
    $this->files = array_merge($this->files, ['requestContent' => $this->getRequestContent()]);
    $this->files = array_merge($this->files, ['certificate' => $this->getCertificate()]);
    $this->files = array_merge($this->files, ['certificateContent' => $this->getCertificateContent()]);
  }

  private function getKeyPair() {
    return openssl_pkey_new([
      'digest_alg'   => $_ENV['DIGEST_ALGO'],
      'private_key_type'   => $_ENV['CIPHER_ALGO'],
      'private_key_bits'   => $_ENV['KEY_SIZE']
    ]);
  }

  private function getPrivateKey() {
    openssl_pkey_export($this->files['keyPair'], $private, $this->password);

    return $private;
  }

  private function getPublicKey() {
    return openssl_pkey_get_details($this->files['keyPair'])['key'];
  }

  private function getRequest() {
    $userConfig = [
      'countryName' => $this->country,
      'organizationName' => $this->organization,
      'organizationalUnitName' => $this->organization_unit,
      'commonName' => $this->name,
      'emailAddress' => $this->mail
    ];

    return openssl_csr_new($userConfig, $this->files['keyPair']);
  }

  private function getRequestContent() {
    return openssl_csr_export($this->files['request'], $requestContent);

    return $requestContent;
  }

  private function getCertificate() {
    return openssl_csr_sign(
      $this->files['request'],
      $this->authority->certificate,
      $this->authority->key,
      $this->validity,
      ['digest_alg' => $_ENV['DIGEST_ALGO']],
      $this->serial
    );
  }

  private function getCertificateContent() {
    openssl_x509_export($this->files['certificate'], $certificateContent);

    return $certificateContent;
  }

  public function getFiles() {
    return $this->files;
  }
}
