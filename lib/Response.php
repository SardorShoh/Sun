<?php

namespace lib;
use \lib\Headers;

class Response {

  public function json(array $arr) : void {
    Headers::set('Content-Type', 'application/json;charset=utf-8');
  }

  public function sendString(string $res) : void {
    Headers::set('Content-Type', 'text/plain;charset=utf-8');
  }

  public function html(string $html) : void {
    Headers::set('Content-Type', 'text/html');
  }

}