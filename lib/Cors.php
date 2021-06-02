<?php
declare(strict_types=1);
namespace lib;
use lib\Headers;

class Cors {

  public string  $allow_origin     = '*';
  public string  $allow_methods    = 'GET,POST,PUT,HEAD,DELETE,PATCH';
  public string  $allow_headers    = '';
  public bool    $allow_credential = false;
  public bool    $enabled          = true;

  public function open() {
    $arr = [
      'Access-Control-Allow-Origin'  => $this->allow_origin,
      'Access-Control-Allow-Headers' => $this->allow_headers,
      'Access-Control-Allow-Methods' => $this->allow_methods
    ];
    if ($this->allow_credential) {
      $arr['Access-Control-Allow-Credentials'] = true;
    }
    if ($this->enabled) {
      Headers::set_array($arr);
    }
  }

}