<?php
declare(strict_types=1);
namespace lib;
use \lib\{ Request, Response, Headers, Cookie };

class Context {

  public array $route;

  public function method () : ?string {
    return Request::method();
  }

  public function path () : ?string {
    return Request::path();
  }

  public function params () : ?array {
    if (!empty($this->route))
      return Request::params($this->route);
    return null;
  }

  public function param (string $key): ?string {
    if (!is_null($this->params()))
      return $this->params()[$key];
    return null;
  }

  public function query (string $key) : ?string {
    return Request::query($key);
  }

  public function ip () : ?string {
    return Request::ip();
  }

  public function body () : ?string {
    return Request::body();
  }

  public function is (string $type) : bool {
    return Request::is($type);
  }

  public function cookies () : ?array {
    return Cookie::get_cookies();
  }

  public function cookie (string $key) : ?string {
    return Cookie::get_cookie($key);
  }

  public function set_cookie(...$args): void {
    Cookie::set_cookie(...$args);
  }

  public function json (array $data) {
    return Response::json($data);
  }

  public function text (string $data) {
    return Response::send_string($data);
  }

  public function html (string $data) {
    return Response::html($data);
  }

  public function xml (string $data) {
    return Response::xml($data);
  }

  public function view (string $path) {
    return Response::view($path);
  }

  public function get_header (string $key) : ?string {
    return Headers::get($key);
  }

  public function set_header (string $key, string $value) : void {
    Headers::set($key, $value);
  }

  public function remove_header (string $key) : void {
    Headers::remove($key);
  }

  public function hostname(): string {
    return $_SERVER['HTTP_HOST'];
  }

  public function status (int $code) : Context {
    http_response_code($code);
    return $this;
  }

  public function send_status (int $code) : int {
    http_response_code($code);
    return 0;
  }
}