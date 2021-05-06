<?php
namespace lib;

use \lib\{Router, Request, Response, Config, Context};

class App {
  
  protected Router $router;
  protected Config $config;
  protected Context $ctx;
  protected Cors $cors;

  public function __construct(Config $config, Cors $cors = null) {
    if (!is_null($cors))  $this->cors   = $cors;
    $this->config = $config;
    $this->router = new Router;
    $this->ctx    = new Context;

    Headers::remove('X-Powered-By');
    if ($this->config->server_header !== '') {
      Headers::set('Server', $this->config->server_header);
    }
  }

  // GET methodlik router linkni qo'shish
  public function get(string $path, callable $callback) {
    $this->router->get($path, $callback);
  }

  public function post(string $path, callable $callback) {
    $this->router->post($path, $callback);
  }

  public function put(string $path, callable $callback) {
    $this->router->put($path, $callback);
  }

  public function delete(string $path, callable $callback) {
    $this->router->delete($path, $callback);
  }

  public function patch(string $path, callable $callback) {
    $this->router->patch($path, $callback);
  }

  public function options(string $path, callable $callback) {
    $this->router->options($path, $callback);
  }

  public function head(string $path, callable $callback) {
    $this->router->head($path, $callback);
  }

  public function copy(string $path, callable $callback) {
    $this->router->copy($path, $callback);
  }

  public function link(string $path, callable $callback) {
    $this->router->link($path, $callback);
  }

  public function run () {
    $path   = Request::path();
    $method = Request::method();
    $routes = $this->router->get_routes();

    if ($this->config->get_only && $method !== 'get') {
      return $this->ctx->status(404)->send('Not Found');
    }
    foreach ($routes[$method] as $route) {
      if ($route['is_nested']) {
        $this->ctx->route = explode('/', $route['path']);
        $real = $dynamic = [];
        if ($this->config->strict_routing) {
          $real = $this->router->real_to_array();
          $dynamic = $this->router->dynamic_to_array($route['path']);
        } else {
          $real = array_filter($this->router->real_to_array());
          $dynamic = array_filter($this->router->dynamic_to_array($route['path']));
        }
        if (count($real) !== count($dynamic)) continue;
        $check = false;
        foreach ($dynamic as $key => $val) {
          if (strpos($val, ':') === false) {
            if ($this->config->case_sensitive) {
              if (strtolower($real[$key]) === strtolower($val)) {
                $check = true;
              }
            } else {
              if ($real[$key] === $val) {
                $check = true;
              }
            }
          }
        }
        if (!$check) continue;
      } else {
        if ($this->config->case_sensitive) {
          if ($this->config->strict_routing) {
            if ($path !== $route['path']) continue;
          } else {
            if (trim($path, '/') !== trim($route['path'], '/')) continue;
          }
        } else {
          if ($this->config->strict_routing) {
            if (strtolower($path) !== strtolower($route['path'])) continue;
          } else {
            if (strtolower(trim($path, '/')) !== strtolower(trim($route['path'], '/'))) continue;
          }
        }
      }
      return $route['callable']($this->ctx);
    }
    return $this->ctx->status(404)->send('Not Found');
  }
}