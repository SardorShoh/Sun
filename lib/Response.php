<?php

namespace lib;
use \lib\Headers;

class Response {

  //data encode to JSON and send to client
  public function json($data) : void {
    Headers::set('Content-Type', 'application/json;charset=utf-8');
    echo json_encode($data);
  }

  //send string data to the client 
  public function sendString($res) : void {
    Headers::set('Content-Type', 'text/plain;charset=utf-8');
    echo (string)$res;
  }

  //send html data to the client
  public function html($html) : void {
    Headers::set('Content-Type', 'text/html');
    echo $html;
  }

}