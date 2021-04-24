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

  public $keyPair;
  public $privateKey;
  public $publicKey;
  public $request;
  public $requestContent;
  public $certificate;
  public $certificateContent;

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
    $root = $_SERVER['DOCUMENT_ROOT'];

    if (!file_exists($root . '/pki/certs')) {
      mkdir($root . '/pki/certs');
    }
  }

  public function genFiles() {
    $this->keyPair = $this->getKeyPair();
    $this->privateKey = $this->getPrivateKey();
    $this->publicKey = $this->getPublicKey();
    $this->request = $this->getRequest();
    $this->requestContent = $this->getRequestContent();
    $this->certificate = $this->getCertificate();
    $this->certificateContent = $this->getCertificateContent();
  }

  private function getKeyPair() {
    return openssl_pkey_new([
      'digest_alg'   => $_ENV['DIGEST_ALGO'],
      'private_key_type'   => $_ENV['CIPHER_ALGO'],
      'private_key_bits'   => $_ENV['KEY_SIZE']
    ]);
  }

  private function getPrivateKey() {
    openssl_pkey_export($this->keyPair, $private, $this->password);

    return $private;
  }

  private function getPublicKey() {
    return openssl_pkey_get_details($this->keyPair)['key'];
  }

  private function getRequest() {
    $userConfig = [
      'countryName' => $this->country,
      'organizationName' => $this->organization,
      'organizationalUnitName' => $this->organization_unit,
      'commonName' => $this->name,
      'emailAddress' => $this->mail
    ];

    return openssl_csr_new($userConfig, $this->keyPair);
  }

  private function getRequestContent() {
    return openssl_csr_export($this->request, $requestContent);

    return $requestContent;
  }

  private function getCertificate() {
    return openssl_csr_sign(
      $this->request,
      $this->authority->certificate,
      $this->authority->key,
      $this->validity,
      ['digest_alg' => $_ENV['DIGEST_ALGO']],
      $this->serial
    );
  }

  private function getCertificateContent() {
    openssl_x509_export($this->certificate, $certificateContent);

    return $certificateContent;
  }
}
