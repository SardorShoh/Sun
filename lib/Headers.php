<?php

namespace lib;

class Headers {
  
  public static function getResponseHeaders() : ?array {
    $list = headers_list();
    $headers = [];
    if (!empty($list)) {
      foreach ($list as $val) {
        $head = explode(':', $val);
        $headers[trim($head[0])] = trim($head[1]);
      }
    }
    if (!empty($headers))
      return $headers;
    return null;
  }

  public static function getRequestHeaders(): ?array {
    return getallheaders();
  }

  public static function remove(string $key): void {
    header_remove($key);
  }

  public static function set(string $key, string $value) : void {
    header("{$key}: {$value}", true);
  }

}