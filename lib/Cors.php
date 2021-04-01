<?php

namespace lib;
use lib\Headers;

class Cors {

  public string  $allowOrigin     = '*';
  public string  $allowMethods    = 'GET,POST,PUT,HEAD,DELETE,PATCH';
  public string  $allowHeaders    = '';
  public bool    $allowCredential = false;
  public bool    $enabled         = true;

  public function __construct() {
    $arr = [
      'Access-Control-Allow-Origin'  => $this->allowOrigin,
      'Access-Control-Allow-Headers' => $this->allowHeaders,
      'Access-Control-Allow-Methods' => $this->allowMethods
    ];
    if ($this->allowCredential) {
      $arr['Access-Control-Allow-Credentials'] = true;
    }
    Headers::setArray($arr);
  }

}