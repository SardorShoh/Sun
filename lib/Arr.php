<?php

namespace lib;

use lib\JSON;

class Arr {

	//array 
	protected $arr;

	//length of array
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

	//push method for array
	public function push(...$p) {
		$size = count($p);
		foreach ($p as $l) {
			$this->arr[] = $l;
		}
		$this->length += $size;
	}

	// pop method of array
	public function pop() {
		array_pop($this->arr);
		$this->length -= 1;
	}

	//shift method of array
	public function shift() {
		array_shift($this->arr);
		$this->length -= 1;
	}

	//unshift method of array
	public function unshift(...$a) {
		$size = count($a);
		for ($i = ($size - 1); $i >= 0; $i--) {
			array_unshift($this->arr, $a[$i]);
		}
		$this->length += $size;
	}

	//merge any arrays to an array
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

	//get keys of array
	public function keys($search = null) {
		if ($search != null) {
			$this -> arr = array_keys($this->arr, $search, true);
		}
		$this -> arr = array_keys($this->arr);
	}

	//get values of array
	public function values() {
		$this -> arr = array_values($this->arr);
	}

	//map method for array
	public function map(callable $call): self {
		$this -> arr = array_map($call, $this->arr);
	}

	//filter method for array
	public function filter(callable $func) {
		if ($func) {
			$this -> arr = array_filter($this->arr, $func);
		}
		$this -> arr = array_filter($this->arr);
	}

	//inArray method for array
	public function inArray($needle): bool {
		return in_array($needle, $this->arr);
	}

	//this method for getting ready array
	public function get(): array {
		return $this->arr;
	}

	//this method for array to JSON converting
	public function toJSON(): string {
		return (new JSON($this->arr))->encode();
	}

	//this method for array to object converting
	public function toObject(): object {
		return (object) $this->arr;
	}

	// this method for array to string converting
	public function __toString(): string {
		$out = '';
		foreach ($this->arr as $val) {
			$out .= $val . ',';
		}
		return rtrim($out, ',');
	}

	//this method is remove array elements by keys
	public function removeByKey($key) {
		unset($this->arr[$key]);
		$this->length = count($this->arr);
	}

	//this method is remove array elements by values
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