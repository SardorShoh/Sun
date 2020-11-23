<?php

namespace lib;
use \lib\{ Request, Response, Headers, Cookie };

class Context {

  protected Request $request;
  protected Response $response;
  public array $route;

  public function __construct () {
    $this->request = new Request;
    $this->response = new Response;
  }

  public function method () : ?string {
    return $this->request->method();
  }

  public function path () : string {
    return $this->request->path();
  }

  public function params (string $key) : ?string {
    if (!empty($this->route))
      return $this->request->params($this->route, $key);
    return null;
  }

  public function query (string $key) : ?string {
    return $this->request->query($key);
  }

  public function ip () : ?string {
    return $this->request->ip();
  }

  public function body () : ?string {
    return $this->request->body();
  }

  public function is (string $type) : bool {
    return $this->request->is($type);
  }

  public function cookies () : ?array {
    return Cookie::getCookies();
  }

  public function cookie (string $key) : ?string {
    return Cookie::getCookie($key);
  }

  public function setCookie(...$args): void {
    Cookie::setCookie(...$args);
  }

  public function json ($data) : void {
    $this->response->json($data);
  }

  public function send ($data) : void {
    $this->response->sendString($data);
  }

  public function html ($data) : void {
    $this->response->html($data);
  }

  public function getHeader (string $key) : ?string {
    return Headers::get($key);
  }

  public function setHeader (string $key, string $value) : void {
    Headers::set($key, $value);
  }

  public function removeHeader (string $key) : void {
    Headers::remove($key);
  }

  public function hostname(): string {
    return $_SERVER['HTTP_HOST'];
  }

  public function status (int $code) : void {
    http_response_code($code);
  }
}