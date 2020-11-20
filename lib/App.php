<?php
namespace lib;

use \lib\{Router, Request, Response, Config};

class App {
  
  protected Router $router;
  protected Request $request;
  protected Response $response;
  protected Config $config;

  public function __construct(Config $config) {
    $this->config = $config;
    $this->request = new Request;
    $this->response = new Response;
    $this->router = new Router;
  }

  public function get(string $path, callable $callback) {
    $this->router->get($path);
  }

  public function post(string $path, callable $callback) {
    $this->router->post($path);
  }

  public function put(string $path, callable $callback) {
    $this->router->put($path);
  }

  public function delete(string $path, callable $callback) {
    $this->router->delete($path);
  }

  public function patch(string $path, callable $callback) {
    $this->router->patch($path);
  }

  public function options(string $path, callable $callback) {
    $this->router->options($path);
  }
}