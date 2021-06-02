<?php
declare(strict_types=1);
namespace lib;

class Headers {
  
  public static function get_response_headers() : ?array {
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

  public static function get_request_headers(): ?array {
    return getallheaders();
  }

  public static function remove(string $key): void {
    header_remove($key);
  }

  public static function set(string $key, string $value) : void {
    header("{$key}: {$value}", true);
  }

  public static function set_array(array $headers) : void {
    if (empty($headers) || is_null($headers)) return;
    foreach ($headers as $key => $val) {
      header("{$key}: {$val}", true);
    }
    return;
  }

  public static function get(string $key): ?string {
    if (!array_key_exists($key, self::getRequestHeaders()))
      return null;
    return self::getRequestHeaders()[$key];
  }

}