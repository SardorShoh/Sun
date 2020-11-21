<?php

namespace lib;

class Request {
  
  public function path () {
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    $position = strpos($path, '?');
    if ($position === false) 
      return $path;
    return substr($path, 0, $position);
  }

  public function method () : ?string {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }

  public function params (array $routes, string $key) : ?string {
    if (!empty($routes)) {
      $routes = $routes[$this->method()];
      $routes = array_filter($routes, function($k, $v) {
        return $k == 'is_nested' && $v == true;
      }, ARRAY_FILTER_USE_BOTH);
    }
    return null;
  }

  public function queries() : ?array {
    $query = $_SERVER['QUERY_STRING'];
    if (!$query) {
      return null;
    }
    $query = explode('&', $query);
    $queries = [];
    foreach ($query as $value) {
      $params = explode('=', $value);
      if (!empty($params)) {
        if (array_key_exists($params[0], $queries)) {
          if (is_array($queries[$params[0]])) {
            $queries[$params[0]] = [...$queries[$params[0]], $params[1]];
          } else {
            $queries[$params[0]] = [$queries[$params[0]], $params[1]];
          }
        } else {
          $queries[$params[0]] = $params[1];
        }
      }
    }
    return $queries;
  }

  public function query(string $key) {
    if (!is_null($this->queries()))
      return $this->queries()[$key];
    return null;
  }

  public function ip() : ?string {
    return $_SERVER['REMOTE_ADDR'];
  }

  public function body() : ?string {
    if ($this->is('multipart/form-data')) {
      if (!empty($_POST)) {
        return $_POST;
      }
      return null;
    }
    $body = file_get_contents('php://input');
    if (!empty($body))
      return $body;
    return null;
  }

  public function is(string $type) : bool {
    $content = Headers::getRequestHeaders()['Content-Type'];
    if (is_null($this->body()))
      return false;
    if (strpos(strtolower($content), (ltrim(strtolower($type), '.'))) === false)
      return false;
    return true;
  }


}