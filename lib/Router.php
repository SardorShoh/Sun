<?php
namespace lib;

use \lib\Request;
/**
 * Router class for read GET, POST, PUT, DELETE, HEAD, PATCH and other requests
 */
class Router {

	protected $path;
	protected $method;
	protected $routes = [];
	protected $allowed = [
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
	private Request $request;

	public static function create() {
		if (!self::$instance instanceof self) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->request = new Request;
		$this->path = rtrim($_SERVER['REQUEST_URI'], '/') === '' ? '/' : rtrim($_SERVER['REQUEST_URI'], '/');
		$this->method = $_SERVER['REQUEST_METHOD'];
	}

	protected function isNested(string $path): bool {
		if (strpos($path, ':') === false) {
			return false;
		}
		return true;
	}

	protected function staticAndDynamic(string $path): array{
		$params = array_filter(explode('/', $path));
		$static = [];
		$dynamic = [];
		foreach ($params as $i => $param) {
			if ($this->isNested($param)) {
				$dynamic[$i] = $param;
			} else {
				$static[$i] = $param;
			}
		}
		return [
			'static' => $static,
			'dynamic' => $dynamic,
		];
	}

	protected function realPathToArray():  ?array {
		$path = array_filter(explode('/', $this->path));
		if (empty($path)) {
			return null;
		}
		return $path;
	}

	protected function getArgs(string $path) :  ?array {
		$params = $this->realPathToArray();
		$pathcount = count(array_filter(explode('/', $path)));
		if (count($params) !== $pathcount) {
			return null;
		}
		$keys = array_keys($this->staticAndDynamic($path)['dynamic']);
		$args = [];
		foreach ($keys as $key) {
			$args[] = $params[$key];
		}
		return array_filter($args);
	}

	protected function isEqual(string $path) : bool {
		if (!$this->realPathToArray() && $path === '/') {
			return true;
		}
		$params = $this->realPathToArray();
		$pathcount = count(array_filter(explode('/', $path)));
		if (count($params) !== $pathcount) {
			return false;
		}
		$static = $this->staticAndDynamic($path)['static'];
		$keys = array_keys($static);
		$real = $this->realPathToArray();
		$realstatic = [];
		foreach ($keys as $key) {
			$realstatic[] = $real[$key];
		}
		$real = join('/', $realstatic);
		$static = join('/', $static);
		return $real == $static;
	}

	public function __call($method, $args) {
		$path = '/' . trim($args[0], '/') === '' ? '/' : '/' . trim($args[0], '/');
		$func = $args[1];
		$method = strtoupper($method);
		if (in_array($method, $this->allowed)) {
			if ($method === 'GROUP') {
				$this->routes[] = [
					'path' => $path,
					'isnested' => $this->isNested($path),
					'isequal' => $this->isEqual($path),
					'args' => $this->method,
					'func' => $func,
				];
				return;
			} else if ($method === $this->method) {
				$this->routes[] = [
					'path' => $path,
					'isnested' => $this->isNested($path),
					'isequal' => $this->isEqual($path),
					'args' => $this->getArgs($path),
					'func' => $func,
				];
				return;
			}
			return;
		}
		return;
	}

	public function run() {
		//print_r($this->routes);
		if (!empty($this->routes)) {
			foreach ($this->routes as $route) {
				if ($route['isequal']) {
					if ($route['isnested']) {
						return $route['func'](...$route['args']);
					}
					return $route['func']();
				}
			}
		}
		//Header::setcode(404);
		echo 'Bunday sahifa mavjud emas';
		return;
	}

	public function resolve () {
		$path = $this->request->getPath();
		$method = $this->request->getMethod();
		if (in_array($method, $this->allowed)) {
			$callback = $this->routes[$method][$path] ?? false;
			if (!$callback) {
				echo 'Not Found';
				return;
			}
		}
	}

}
?>
