<?php
namespace lib;

use \lib\{Router, Request, Response, Config, Context};

class App {
  
  protected Router $router;
  protected Request $request;
  protected Response $response;
  protected Config $config;
  protected Context $ctx;

  public function __construct(Config $config) {
    $this->config = $config;
    $this->router = new Router;
    $this->ctx = new Context();
  }

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

  public function run () {
    Headers::remove('X-Powered-By');
    if (!empty($this->config->serverHeader)) {
      Headers::set('Server', $this->config->serverHeader);
    }
    $path = $this->ctx->path();
    $method = $this->ctx->method();
    if ($this->config->getOnly === true) {
      if ($method !== 'get') {
        $this->ctx->status(404);
        echo 'Not Found. Non GET method';
        return;
      }
    }
    $routes = $this->router->getRoutes()[$method];
    foreach ($routes as $route) {
      if ($route['is_nested']) {
        $this->ctx->route = $route;
        if ($this->config->caseSensitive) {
          if ($this->config->strictRouting) {
            $rts = explode('/', $route['path']);
            $realrts = explode('/', $path);
            if (count($rts) !== count($realrts)) {
              $this->ctx->status(404);
              echo 'Not Found';
              return;
            }
            $check = false;
            foreach ($rts as $k=>$v) {
              if (strpos($v, ":") === false) {
                if ($v === $realrts[$k]) {
                  $check = true;
                }
              }
            }
            if ($check === false) {
              $this->ctx->status(404);
              echo 'Not Found';
              return;
            }
            return $route['callable']($this->ctx);
          }
          $rts = explode(trim($route['path'], '/'), '/');
          $realrts = explode(trim($path, '/'), '/');
          if (count($rts) !== count($realrts)) {
            $this->ctx->status(404);
            echo 'Not Found';
            return;
          }
          $check = false;
          foreach($rts as $k=>$v) {
            if (strpos($v, ':') === false) {
              if ($v === $realrts[$k]) {
                $check = true;
              }
            }
          }
          if ($check === false) {
            $this->ctx->status(404);
            echo 'Not Found';
            return;
          }
          return $route['callable']($this->ctx);
        }
        if ($this->config->strictRouting) {
          $rts = explode('/', $route['path']);
          $realrts = explode('/', $path);
          if (count($rts) !== count($realrts)) {
            $this->ctx->status(404);
            echo 'Not Found';
            return;
          }
          $check = false;
          foreach ($rts as $k=>$v) {
            if (strpos($v, ":") === false) {
              if (strtolower($v) === strtolower($realrts[$k])) {
                $check = true;
              }
            }
          }
          if ($check === false) {
            $this->ctx->status(404);
            echo 'Not Found';
            return;
          }
          return $route['callable']($this->ctx);
        }
        $rts = explode(trim($route['path'], '/'), '/');
        $realrts = explode(trim($path, '/'), '/');
        if (count($rts) !== count($realrts)) {
          $this->ctx->status(404);
          echo 'Not Found';
          return;
        }
        $check = false;
        foreach($rts as $k=>$v) {
          if (strpos($v, ':') === false) {
            if (strtolower($v) === strtolower($realrts[$k])) {
              $check = true;
            }
          }
        }
        if ($check === false) {
          $this->ctx->status(404);
          echo 'Not Found';
          return;
        }
        return $route['callable']($this->ctx);
      } else {
        if ($this->config->caseSensitive) {
          if ($this->config->strictRouting) {
            if ($path === $route['path']) {
              return $route['callable']($this->ctx);
            }
            $this->ctx->status(404);
            echo 'Not Found';
            return;
          }
          if (trim($path, '/') === trim($route['path'], '/')) {
            return $route['callable']($this->ctx);
          }
          $this->ctx->status(404);
          echo 'Not Found';
          return;
        }
        if ($this->config->strictRouting) {
          if (strtolower($path) === strtolower($route['path'])) {
            return $route['callable']($this->ctx);
          }
          $this->ctx->status(404);
          echo 'Not Found';
          return;
        }
        if (strtolower(trim($path, '/')) === strtolower(trim($route['path'], '/'))) {
          return $route['callable']($this->ctx);
        }
        $this->ctx->status(404);
        echo 'Not Found';
        return;
      }
    }
  }
}