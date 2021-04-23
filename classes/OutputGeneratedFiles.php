<?php
class OutputGeneratedFiles {
  private $certFolderPath;
  private $objectName;
  private $organization;
  private $generator;
  private $dirName;
  private $fileName;

  function __construct($objectName, $organization, $generator) {
    $this->certFolderPath = $_SERVER['DOCUMENT_ROOT'] . '/pki/certs/';
    $this->objectName = $objectName;
    $this->organization = $organization;
    $this->generator = $generator;

    $this->constructOutputFolderName();
    $this->constructFileName();
    $this->mkdir();
    $this->save();
  }

  private function constructFileName() {
    $this->fileName = $this->objectName . $this->organization;
    $this->fileName = str_replace(' ', '-', $this->fileName);
  }

  private function constructOutputFolderName() {
    $this->dirName = $this->certFolderPath . $this->objectName . $this->organization;
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

    // openssl_pkcs12_export_to_file($generator->getCertificate(), $dirName . '/' . $name_file . '.p12', $generator->keyPair, $password, [
    //   'extracerts'       => $authority->certificate,
    //   'friendly_name'     => $name
    // ]);
  }
}
