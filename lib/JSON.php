<?php

namespace lib;

use lib\Arr;

class JSON {

	// Array yoki Object ko'rinishidagi ma'lumotlarni JSONga aylantirish
	public static function encode(mixed $data): string {
		return json_encode($data);
	}

	// JSON ko'rinishidagi ma'lumotlarni Arr obyektiga olish
	public static function decode(string $data): Arr {
		return new Arr(json_decode($data, true));
	}

	// Fayldan JSON ma'lumotlarni olish va uni Arr obyektiga o'tkazish
	public static function from_file(string $path): Arr {

	}

}