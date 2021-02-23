<?php

namespace lib\database;

use Exception;

class Config {
  //Ma'lumotlar bazasiga ulanish hosti
  public $host;

  //Ma'lumotlar bazasining ishlayotgan porti
  public $port;

  //Ma'lumotlar bazasi driverining nomi
  public $driver;

  //Ma'lumotlar bazasi foydalanuvchisi nomi
  public $dbuser;

  //Ma'lumotlar bazasiga ulanish paroli
  public $dbpassword;

  //Ma'lumotlar bazasida yaratilgan bazaning nomi
  public $dbname;

  //SQLITE va Firebird va shunga o'xshash bazalar uchun ma'lumotlar bazasining joylashgan joyi
  public $dbpath;

  //Ma'lumotlar bazasining kodirovkasi
  public $charset;

  //Ma'lumotlar bazasining parameterlarini arraydan shakllantirish
  public function fromArray(array $config): void {
    if (!$config['host'] || $config['host'] === '') {
      throw new Exception('Database host not found');
    }
    if (!$config['driver'] || $config['driver'] === '') {
      throw new Exception('Database driver not found');
    }
    $this->host       = $config['host'];
    $this->port       = $config['port'];
    $this->driver     = $config['driver'];
    $this->dbpath     = $config['dbpath'];
    $this->dbname     = $config['dbname'];
    $this->dbuser     = $config['dbuser'];
    $this->dbpassword = $config['dbpassword'];
    $this->charset    = $config['charset'];
  }

  //Ma'lumotlar bazasiga ulanish parameterlarini JSON fayldan yuklab olish
  public function fromJSON(string $path): void {
    $json = file_get_contents($path);
    if ($json === '' || !$json) {
      throw new Exception('JSON file is empty');
    }
    $config = json_decode($json, true);
    $this->host       = $config['host'];
    $this->port       = $config['port'];
    $this->driver     = $config['driver'];
    $this->dbpath     = $config['dbpath'];
    $this->dbname     = $config['dbname'];
    $this->dbuser     = $config['dbuser'];
    $this->dbpassword = $config['dbpassword'];
    $this->charset    = $config['charset'];
  }

  //Ma'lumotlar bazasiga ulanish parameterlarini INI fayldan yuklab olish
  public function fromIni(string $path): void {
    $ini = parse_ini_file($path);
    if ($ini === '' || !$ini) {
      throw new Exception('INI file is empty');
    }
    $this->host       = $ini['host'];
    $this->port       = $ini['port'];
    $this->driver     = $ini['driver'];
    $this->dbpath     = $ini['dbpath'];
    $this->dbname     = $ini['dbname'];
    $this->dbuser     = $ini['dbuser'];
    $this->dbpassword = $ini['dbpassword'];
    $this->charset    = $ini['charset'];
  }

  //Ma'lumotlar bazasiga ulanish parameterlarini ENV fayldan yuklab olish
  public function fromEnv(string $path): void {
    $env = file_get_contents($path);
    if ($env === '' || !$env) {
      throw new Exception('.env file is empty');
    }
    $env = explode("\n", $env);
    $config = [];
    foreach ($env as $n) {
      $f = explode('=', $n);
      $config[trim($f[0])] = trim($f[1]);
    }
    $this->host       = $config['host'];
    $this->port       = $config['port'];
    $this->driver     = $config['driver'];
    $this->dbpath     = $config['dbpath'];
    $this->dbname     = $config['dbname'];
    $this->dbuser     = $config['dbuser'];
    $this->dbpassword = $config['dbpassword'];
    $this->charset    = $config['charset'];
  }
}