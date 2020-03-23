<?php 
namespace lib;

class CURL {
	
	protected $curl;
  public $urls;
	
	public function __construct () {
		$this->curl = curl_init();
	}
	
}