<?php
declare(strict_types=1);
namespace lib;

use \lib\Request;
/**
 * Router class for read GET, POST, PUT, DELETE, HEAD, PATCH and other requests
 */
class Router {

	private $routes = [];
	private $allowed = [
		'GET',
		'POST',
		'PUT',
		'DELETE',
		'PATCH',
		'OPTIONS',
		'HEAD',
		'COPY',
		'LINK',
		'GROUP',
	];
	private static $instance;


	// Singleton Router obyektini yaratish
	public static function create() {
		if (!self::$instance instanceof self) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	// Dinamik router parameterlari borligini aniqlash
	private function is_nested(string $path): bool {
		return strpos($path, ':') === false ? false : true;
	}

	// So'rovlarni bazaviy ro'yxatga olish
	private function base_register(string $method, string $path, callable $callback) {
		$arr = ['path' => $path, 'callable' => $callback];
		$this->is_nested($path) ? $arr['is_nested'] = true : $arr['is_nested'] = false;
		$this->routes[$method][] = $arr;
		return;
	}

	// GET so'rovlarini ro'yxatga olish
	public function get(string $path, callable $callback) {
		return $this->base_register('get', $path, $callback);
	}

	// POST so'rovlarini ro'yxatga olish
	public function post(string $path, callable $callback) {
		return $this->base_register('post', $path, $callback);
	}

	// PUT so'rovlarini ro'yxatga olish
	public function put(string $path, callable $callback) {
		return $this->base_register('put', $path, $callback);
	}

	// DELETE so'rovlarini ro'yxatga olish
	public function delete(string $path, callable $callback) {
		return $this->base_register('delete', $path, $callback);
	}

	// PATCH so'rovlarini ro'yxatga olish
	public function patch(string $path, callable $callback) {
		return $this->base_register('patch', $path, $callback);
	}

	// OPTIONS so'rovlarini ro'yxatga olish
	public function options(string $path, callable $callback) {
		return $this->base_register('options', $path, $callback);
	}

	// HEAD so'rovlarini ro'yxatga olish
	public function head(string $path, callable $callback) {
		return $this->base_register('head', $path, $callback);
	}

	// COPY so'rovlarini ro'yxatga olish
	public function copy(string $path, callable $callback) {
		return $this->base_register('copy', $path, $callback);
	}

	// LINK so'rovlarini ro'yxatga olish
	public function link(string $path, callable $callback) {
		return $this->base_register('link', $path, $callback);
	}

	public function group(string $path) {
		if ($this->isNested($path)) {
			$this->routes['group'][] = ['is_nested' => true, 'path' => $path];
		} else {
			$this->routes['group'][] = ['is_nested' => false, 'path' => $path];
		}
	}

	// Barcha routelar ro'yxatini olish
	public function get_routes() : ?array {
		return $this->routes;
	}

	// real route ni arrayga ajratish
	public function real_to_array(): ?array {
		return explode('/', Request::path());
	}

	// dinamik routelarni arrayga ajratish
	public function dynamic_to_array(string $path): ?array {
		return explode('/', $path);
	}

}
