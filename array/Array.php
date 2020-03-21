<?php

class Arr {

	protected $arr;
	public $length;

	public function __construct() {
		$arr = func_get_args();
		$length = func_num_args();
		if ($length == 1 && gettype($arr[0]) == 'array') {
			$this->arr = $arr[0];
			$this->length = count($arr[0]);
		} elseif ($length > 1) {
			$this->arr = func_get_args();
			$this->length = func_num_args();
		} else {
			$this->arr = [];
			$this->length = 0;
		}
	}

	public function push(...$p) {
		$size = count($p);
		foreach ($p as $l) {
			$this->arr[] = $l;
		}
		$this->length += $size;
	}

	public function pop() {
		array_pop($this->arr);
		$this->length -= 1;
	}

	public function shift() {
		array_shift($this->arr);
		$this->length -= 1;
	}

	public function unshift(...$a) {
		$size = count($a);
		for ($i = ($size - 1); $i >= 0; $i--) {
			array_unshift($this->arr, $a[$i]);
		}
		$this->length += $size;
	}

	public function merge(...$args) {
		$nums = count($args);
		if ($nums > 0) {
			foreach ($args as $arg) {
				if (gettype($arg) == 'array' && !empty($arg)) {
					$this->arr = array_merge($this->arr, $arg);
				}

			}
		}
		$this->length = count($this->arr);
	}

	public function keys($search = null): array {
		if ($search != null) {
			return array_keys($this->arr, $search, true);
		}
		return array_keys($this->arr);
	}

	public function values(): array {
		return array_values($this->arr);
	}

	public function map(callable $call): array {
		return array_map($call, $this->arr);
	}

	public function get(): array {
		return $this->arr;
	}

	public function toJSON(): string {
		return json_encode($this->arr);
	}

	public function __toString(): string {
		$out = '';
		foreach ($this->arr as $val) {
			$out .= $val . ',';
		}
		return rtrim($out, ',');
	}

	public function removeByKey($key) {
		unset($this->arr[$key]);
		$this->length = count($this->arr);
	}

	public function removeByValue($val = '') {
		foreach ($this->arr as $i => $v) {
			if ($val === $v) {
				unset($this->arr[$i]);
			}
		}
		$this->length = count($this->arr);
	}

	public function out() {
		print_r($this->arr);
	}

	public function __destruct() {
		$this->arr = null;
		$this->length = null;
	}
}

$a = new Arr(['ha' => 'hey', 'gdg' => true, 'ss' => 'new']);
$a->removeByValue(true);
echo $a->length;