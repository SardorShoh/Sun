<?php

namespace lib;
use \lib\Headers;

class Response {

  public function json($arr) : void {
    Headers::set('Content-Type', 'application/json;charset=utf-8');
    echo json_encode($arr);
    
  }

  public function sendString($res) : void {
    Headers::set('Content-Type', 'text/plain;charset=utf-8');
    echo (string)$res;
  }

  public function html($html) : void {
    Headers::set('Content-Type', 'text/html');
    echo $html;
  }

}