<?php

namespace lib;

class Cookie {

  public static function get_cookies() : ?array {
    if (!empty($_COOKIE))
      return $_COOKIE;
    return null;
  }

  public static function get_cookie(string $key = null) : ?string {
    if (!is_null(self::get_cookies())) {
      if (array_key_exists($key, self::get_cookies())) {
        return self::get_cookies()[$key];
      }
    }
    return null;
  }

  public static function set_cookie (...$args) : void {
    setcookie(...$args);
    return;
  }

}