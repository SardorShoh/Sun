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
    $method = $this->ctx->method();
    $routes = $this->router->getRoutes()[$method];
    echo '<pre>';
    print_r($routes);
  }
}