<?php

namespace lib;

class Request {
  
  // Foydalanuvchi so'rov yuborgan manzilning faqat direktoriya ko'rinishidagi qismini olish
  public static function path () : ?string {
    $path = $_SERVER['REQUEST_URI'];
    $position = strpos($path, '?');
    if ($position === false) {
      return $path;
    }
    return substr($path, 0, $position);
  }

  // Foydalanuvchi yuborgan so'rovning metodi. Masalan: GET, POST, PUT ...
  public static function method () : ?string {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }

  // 
  public static function params (array $route, string $key) : ?string {
    if (!empty($route)) {
      $r = explode('/', $route['path']);
      foreach ($r as $i => $param) {
        if (strpos($param, ':') !== false) {
          $name = ltrim($param, ':');
          if ($name === $key) {
            $path = self::path();
            $path = explode('/', $path);
            return $path[$i];
          }
        }
      }
    }
    return null;
  }

  // 
  public static function query(string $key = null) : array|string {
    $query = $_SERVER['QUERY_STRING'];
    if (!$query) {
      return [];
    }
    $query = explode('&', $query);
    $queries = [];
    foreach ($query as $value) {
      $params = explode('=', $value);
      if (!empty($params)) {
        if (array_key_exists($params[0], $queries)) {
          if (is_array($queries[$params[0]])) {
            $queries[$params[0]] = [...$queries[$params[0]], htmlspecialchars($params[1], ENT_QUOTES, 'UTF-8')];
          } else {
            $queries[$params[0]] = [$queries[$params[0]], htmlspecialchars($params[1], ENT_QUOTES, 'UTF-8')];
          }
        } else {
          $queries[$params[0]] = htmlspecialchars($params[1], ENT_QUOTES, 'UTF-8');
        }
      }
    }
    if (!is_null($queries)) {
      if (!is_null($key)) {
        return $queries[$key];
      }
      return $queries;
    }
    return [];
  }

  // 
  public static function ip() : ?string {
    return $_SERVER['REMOTE_ADDR'];
  }

  // 
  public static function body() : ?array {
    if (self::is('multipart/form-data') || self::is('application/x-www-form-urlencoded')) {
      switch (self::method()) {
        case 'get':
          return $_GET;
        case 'post':
          return $_POST;
        default:
          return $_REQUEST;
      }
    }
    if (self::is('application/json')) {
      $body = file_get_contents('php://input');
      return json_decode($body, true);
    }
    return null;
  }

  // 
  public static function is(string $type) : bool {
    $content = Headers::getRequestHeaders()['Content-Type'];
    if (strpos(strtolower($content), (ltrim(strtolower($type), '.'))) === false) {
      return false;
    }
    return true;
  }

  // Haqiqiy so'rov kelgan manzilni arrayga o'tkazish
  public static function path_to_array(): ?array {
    return explode('/', self::path());
  }
  
}