<?php

namespace lib;
use \lib\Headers;

class Response {

  //data encode to JSON and send to client
  public static function json(string $data) {
    Headers::set('Content-Type', 'application/json;charset=utf-8');
    echo json_encode($data);
    return;
  }

  //send string data to the client 
  public static function send_string(string $res) {
    Headers::set('Content-Type', 'text/plain;charset=utf-8');
    echo (string)$res;
    return;
  }

  //send HTML data to the client
  public static function html(string $html) {
    Headers::set('Content-Type', 'text/html;charset=utf-8');
    echo $html;
    return;
  }

  //send XML data to the client
  public static function xml(string $data) {
    Headers::set('Content-Type', 'application/xml;charset=utf-8');
    echo $data;
    return;
  }

  // send view to the client
  public static function view(string $path) {
    Headers::set('Content-Type', 'text/html;charset=utf-8');
    if (file_exists($path)) {
      ob_start();
      require($path);
      echo ob_get_clean();
    }
    return;
  }

}