<?php

namespace lib;

class Cookie {

  public static function getCookies() : ?array {
    if (!empty($_COOKIE))
      return $_COOKIE;
    return null;
  }

  public static function getCookie(string $key = null) : ?string {
    if (!is_null(self::getCookies())) {
      if (array_key_exists($key, self::getCookies())) {
        return self::getCookies()[$key];
      }
    }
    return null;
  }

  public static function setCookie (...$args) : void {
    setcookie(...$args);
    return;
  }

}