<?php

namespace lib;
use \lib\Headers;

class Response {

  //data encode to JSON and send to client
  public static function json($data) : int {
    Headers::set('Content-Type', 'application/json;charset=utf-8');
    echo json_encode($data);
    return 0;
  }

  //send string data to the client 
  public static function sendString($res) : int {
    Headers::set('Content-Type', 'text/plain;charset=utf-8');
    echo (string)$res;
    return 0;
  }

  //send HTML data to the client
  public static function html($html) : int {
    Headers::set('Content-Type', 'text/html');
    echo $html;
    return 0;
  }

  //send XML data to the client
  public static function xml($data) : int {
    Headers::set('Content-Type', 'application/xml');
    echo $data;
    return 0;
  }

}