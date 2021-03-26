<?php

namespace lib;
use lib\Headers;

class Cors {

  public string  $allowOrigin     = '*';
  public string  $allowMethods    = 'GET,POST,PUT,HEAD,DELETE,PATCH';
  public string  $allowHeaders    = '';
  public bool    $allowCredential = false;

  public static function open() {
    $self = new static;
    $arr = [
      'Access-Control-Allow-Origin'  => $self->allowOrigin,
      'Access-Control-Allow-Headers' => $self->allowHeaders,
      'Access-Control-Allow-Methods' => $self->allowMethods
    ];
    if ($self->allowCredential) {
      $arr['Access-Control-Allow-Credentials'] = true;
    }
    return Headers::setArray($arr);
  }

}