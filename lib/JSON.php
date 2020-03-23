<?php

namespace lib;

use lib\Arr;
use Exception;

class JSON {

	//json string
	protected $json;
	protected $type;

	public function __construct($json){
		$this->type = gettype($json);
		$this->json = $json;
	}

	public function encode(): string {
		return json_encode($this->json);
	}

	public function decode(): Arr {
		if ($this->type == "string")
			return new Arr(json_decode($this->json, true));
		throw new Exception("this is not a json format");
	}

}