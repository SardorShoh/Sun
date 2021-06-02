<?php
declare(strict_types=1);
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

  // POST methodlik router linkni qo'shish
  public function post(string $path, callable $callback) {
    $this->router->post($path, $callback);
  }

  // PUT methodlik router linkni qo'shish
  public function put(string $path, callable $callback) {
    $this->router->put($path, $callback);
  }

  // DELETE methodlik router linkni qo'shish
  public function delete(string $path, callable $callback) {
    $this->router->delete($path, $callback);
  }

  // PATCH methodlik router linkni qo'shish
  public function patch(string $path, callable $callback) {
    $this->router->patch($path, $callback);
  }

  // OPTIONS methodlik router linkni qo'shish
  public function options(string $path, callable $callback) {
    $this->router->options($path, $callback);
  }

  // HEAD methodlik router linkni qo'shish
  public function head(string $path, callable $callback) {
    $this->router->head($path, $callback);
  }

  // COPY methodlik router linkni qo'shish
  public function copy(string $path, callable $callback) {
    $this->router->copy($path, $callback);
  }

  // LINK methodlik router linkni qo'shish
  public function link(string $path, callable $callback) {
    $this->router->link($path, $callback);
  }

  // Applicationni ishga tushirib yuboruvchi funksiya
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