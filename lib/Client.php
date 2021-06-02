<?php 
declare(strict_types=1);
namespace lib;

class Client {
	
	private static $instance;
	private $curl;
  public $urls;
	
	public function __construct () {
		$this->curl = curl_init();
	}

	// Yangi client instance yaratish
	public static function create() {

	}

	// Ko'rsatilgan URL ga GET so'rovi yuborish funksiyasi
	public function get(string $url) {

	}

	// Ko'rsatilgan URL ga POST so'rovi yuborish funksiyasi
	public function post(string $url) {

	}

	// Ko'rsatilgan URL ga PUT so'rovi yuborish funksiyasi
	public function put(string $url) {

	}

	// Ko'rsatilgan URL ga DELETE so'rovi yuborish funksiyasi
	public function delete(string $url) {

	}

	// Ko'rsatilgan URL ga OPTIONS so'rovi yuborish funksiyasi
	public function options(string $url) {

	}

	// Ko'rsatilgan URL ga HEAD so'rovi yuborish funksiyasi
	public function head(string $url) {

	}

	// Ko'rsatilgan URL ga COPY so'rovi yuborish funksiyasi
	public function copy(string $url) {

	}

	// Ko'rsatilgan URL ga LINK so'rovi yuborish funksiyasi
	public function link(string $url) {

	}

}