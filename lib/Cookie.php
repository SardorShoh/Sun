<?php

namespace lib;

class Cookie {

  public function getCookies() : ?array {
    if (!empty($_COOKIE))
      return $_COOKIE;
    return null;
  }

  public function getCookie(string $key) : ?string {
    if (!is_null($this->getCookies())) {
      if (array_key_exists($key, $this->getCookies())) {
        return $this->getCookies()[$key];
      }
    }
    return null;
  }
  
}