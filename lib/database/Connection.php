<?php

namespace lib\database;

use PDO;
use PDOException;
use lib\database\Config;

class Connection {
  
  //Singleton obyekt yasash uchun xususiy o'zgaruvchi
  private static $instance;
  //Bazaga ulanishni ta'minlovchi o'zgaruvchi
  public $conn;
  //Bazaga ulanish konfiguratsiyalari
  private Config $c;

  /*
  * Ma'lumotlar bazasiga ulanish konstruktori
  ^ mysql, maria -> MySQL va MariaDB ma'lumotlar bazalariga ulanish driverlarini yoqish
  ^ pgsql, postgres, postgresql -> PostgrSQL ma'lumotlar bazasiga ulanish driverini yoqish
  ^ sqlite -> SQLite ma'lumotlar bazasiga ulanish driverini yoqish
  ^ firebird -> FirebirdSQL ma'lumotlar bazasiga ulanish driverini yoqish
  ^ oci, oracle -> Oracle ma'lumotlar bazasiga ulanish driverini yoqish
  ^ mssql, sqlserver, sqlsrv -> Microsoft SQLServer ma'lumotlar bazasiga ulanish driverini yoqish
  */
  private function __construct() {
    try {
      switch (strtolower($this->driver)) {
        case 'mysql':
        case 'maria':
          $dsn = "mysql:host={$this->c->host};dbname={$this->c->dbname}";
          if ($this->c->port) {
            $dsn = "mysql:host={$this->c->host};port={$this->c->port};dbname={$this->c->dbname}";
          }
          if ($this->c->charset) {
            $dsn .= ";charset={$this->c->charset}";
          }
          $this->conn = new PDO($dsn, $this->c->dbuser, $this->c->dbpassword);
          break;
        case 'pgsql':
        case 'postgres':
        case 'postgresql':
          $dsn = "pgsql:host={$this->c->host};dbname={$this->c->dbname};user={$this->c->dbuser};password={$this->c->dbpassword}";
          if ($this->c->port) {
            $dsn = "pgsql:host={$this->c->host};port={$this->c->port};dbname={$this->c->dbname};user={$this->c->dbuser};password={$this->c->dbpassword}";
          }
          $this->conn = new PDO($dsn);
          break;
        case 'sqlite':
          $this->conn = new PDO($this->c->dbpath);
          break;
        case 'firebird':
          $dsn = "firebird:dbname={$this->c->host}:{$this->c->dbpath}";
          if ($this->c->port) {
            $dsn = "firebird:dbname={$this->c->host}/{$this->c->port}:{$this->c->dbpath}";
          }
          if ($this->c->charset) {
            $dsn .= ";charset={$this->c->charset}";
          }
          $this->conn = new PDO($dsn, $this->c->dbuser, $this->c->dbpassword);
          break;
        case 'oci':
        case 'oracle':
          $dsn = "oci:dbname={$this->c->host}/{$this->c->dbpath}";
          if ($this->c->port) {
            $dsn = "oci:dbname={$this->c->host}:{$this->c->port}/{$this->c->dbpath}";
          }
          if ($this->c->charset) {
            $dsn .= ";charset={$this->c->charset}";
          }
          $this->conn = new PDO($dsn, $this->c->dbuser, $this->c->dbpassword);
          break;
        case 'mssql':
        case 'sqlserver':
        case 'sqlsrv':
          $dsn = "sqlsrv:Server={$this->c->host};Database={$this->c->dbpath}";
          if ($this->c->port) {
            $dsn = "sqlsrv:Server={$this->c->host},{$this->c->port};Database={$this->c->dbpath}";
          }
          $this->conn = new PDO($dsn, $this->c->dbuser, $this->c->dbpassword);
          break;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public static function create(Config $c) {
    $this->c = $c;
    if (!(self::$instance instanceof self)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function connect () {
    return $this->conn;
  }
}