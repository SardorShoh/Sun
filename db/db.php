<?php
namespace script\db;
use PDOException;
use PDO;

class PgConnect {

  private static $instance = null;
  private $conn;

  private function __construct() {
    $config = $this->getConfig();
    try {
      $this->conn = new PDO("pgsql:dbname={$config['DBNAME']};host={$config['HOST']};username={$config['DBUSER']};password={$config['DBPWD']}");
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  protected function getConfig(): Array {
    $fl = file_get_contents('.env');
    $conf = explode("\n", $fl);
    $arr = [];
    foreach ($conf as $c) {
      $c = explode('=', $c);
      array_push([$c[0] => $c[1]]);
    }
    return $arr;
  }

  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function connect() {
    return $this->conn;
  }

  public function __clone () {
    throw new Exeption("Can't clone a singletone Object");
  }

}