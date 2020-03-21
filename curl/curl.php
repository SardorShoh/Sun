<?php 

class curl {
	
	protected $curl;
  public $urls;
	
	public function __construct () {
		$this->curl = curl_init();
	}
	
}