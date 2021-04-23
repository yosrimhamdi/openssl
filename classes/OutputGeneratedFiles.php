<?php
class OutputGeneratedFiles {
  private $objectName;
  private $organization;
  private $password;
  private $generator;
  private $authority;

  private $certsFolderPath;
  private $dirName;
  private $fileName;

  function __construct($objectName, $organization, $password, $generator, $authority) {
    $this->certsFolderPath = $_SERVER['DOCUMENT_ROOT'] . '/pki/certs/';
    $this->objectName = $objectName;
    $this->organization = $organization;
    $this->password = $password;
    $this->generator = $generator;
    $this->authority = $authority;

    $this->constructOutputFolderName();
    $this->constructFileName();
    $this->mkdir();
    $this->save();
  }

  private function constructFileName() {
    $this->fileName = $this->objectName . '-' . $this->organization;
    $this->fileName = str_replace(' ', '-', $this->fileName);
  }

  private function constructOutputFolderName() {
    $this->dirName = $this->certsFolderPath . $this->objectName . '-' . $this->organization;
    $this->dirName = str_replace(' ', '-', $this->dirName);
  }

  private function mkdir() {
    if (!file_exists($this->dirName)) {
      mkdir($this->dirName);
    }
  }

  private function save() {
    file_put_contents($this->dirName . '/' . $this->fileName . '.private.key', $this->generator->privateKey);
    file_put_contents($this->dirName . '/' . $this->fileName . '.public.key', $this->generator->publicKey);
    file_put_contents($this->dirName . '/' . $this->fileName . '.req', $this->generator->requestContent);
    file_put_contents($this->dirName . '/' . $this->fileName . '.crt', $this->generator->certificateContent);

    openssl_pkcs12_export_to_file($this->generator->certificate, $this->dirName . '/' . $this->fileName . '.p12', $this->generator->keyPair, $this->password, [
      'extracerts'       => $this->authority->certificate,
      'friendly_name'     => $this->objectName
    ]);
  }
}
