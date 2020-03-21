<?php

require_once "NodeList.php";

class Parser {

	//O'zgarmas qiymatlar>>
	protected const ATTR_BEGIN = '{';
	protected const ATTR_END = '}';
	protected const TEXT_BEGIN = '[';
	protected const TEXT_END = ']';
	protected const ATTR_DEL = ',';
	protected const SEPARATOR = ':';
	//<<
	//Ba'zi bir o'zgaruvhchilar>>
	protected $parent;
	protected $text;
	protected $attrs;
	protected $tag;
	protected $text_open_position;
	protected $text_close_position;
	//<<
	private static $instance;
	protected $content;
	protected $spaces = [];
	protected $html = [];

	public static function parse(string $path) {
		if (!(self::$instance instanceof self)) {
			self::$instance = new self($path);
		}
		return self::$instance;
	}

	private function __construct($path) {
		$info = pathinfo($path);
		if ($info['extension'] == 'sml') {
			$this->content = file_get_contents($path);
		} else {
			throw new Exception("Please, select only sml type file");
		}
	}

	protected function space(string $str): int{
		$count = 0;
		$str = str_split($str);
		foreach ($str as $value) {
			$chr = ord($value);
			if ($chr == 32) {
				$count++;
			} elseif ($chr == 9) {
				$count += 2;
			}
			if ($chr !== 32) {
				if ($chr !== 9) {
					break;
				}
			}
		}
		$this->spaces[] = $count;
		return $count;
	}

	protected function trimArr() {
		$arr = explode("\n", $this->content);
		if (!empty($arr)) {
			return array_filter($arr, function ($item) {
				return $item != "";
			});
		}
	}

	protected function hasNode(string $el): bool {
		return isset(NodeList::HTML[$el]);
	}

	protected function tagName(string $str): string{
		$str = trim($str);
		$sep = $this->pos($str, self::SEPARATOR);
		$begin = $this->pos($str, self::ATTR_BEGIN);
		if ($sep && $begin) {
			if ($sep > $begin) {
				return substr($str, 0, $begin);
			} else {
				return substr($str, 0, $sep);
			}
		}
		if ($sep && !$begin) {
			return substr($str, 0, $sep);
		}
		if ($begin && !$sep) {
			return substr($str, 0, $begin);
		}
		if ($str) {
			return $str;
		}
		return '';
	}

	protected function pos(string $str, string $char): int{
		$pos = strpos($str, $char);
		return $pos != 0 ? $pos : false;
	}

	protected function attrs(array $line, string $str) {
		$attrs = null;
		$begin = $this->pos($str, self::ATTR_BEGIN);
		$end = $this->pos($str, self::ATTR_END);
		if ($begin && $end) {
			$length = ($end - $begin) - 1;
			$str = substr($str, ($begin + 1), $length);
			$spl = explode(self::ATTR_DEL, trim($str));
			if (!empty($spl)) {
				foreach ($spl as $value) {
					$atr = explode(self::SEPARATOR, trim($value));
					if (!empty($atr) && $atr[0] != "") {
						if (!isset($atr[1])) {
							$atr = [trim($atr[0]) => ""];
						} else {
							$atr = [trim($atr[0]) => trim($atr[1])];
						}
						if ($attrs == null) {
							$attrs = $atr;
						} else {
							$attrs = array_merge($attrs, $atr);
						}
					}
				}
			}
		}
		return $attrs;
	}

	protected function textNode(string $str) {
		$text = null;
		$begin = $this->pos($str, self::TEXT_BEGIN);
		$end = $this->pos($str, self::TEXT_END);
		if ($begin && $end) {
			$length = ($end - $begin) - 1;
			$text = substr($str, ($begin + 1), $length);
		}
		return $text;
	}

	protected function parseLine(string $line) {
		$tag = null;
		$childs = [];
		$str = str_split(trim($line));
		if (empty($str)) {
			return;
		}
		$space = $this->space($line);
		if ($this->hasNode($this->tagName($line))) {
			$tag = $this->tagName($line);
		} else {
			throw new Exception("xatolik mavjud");
		}
		$attrs = $this->attrs($str, $line);
		$text = $this->textNode($line);
		$html = [
			'tag' => $tag,
			'text' => $text,
			'attrs' => $attrs,
			'childs' => $childs,
		];
		$this->html[] = $html;
	}

	public function out() {
		$arr = $this->trimArr();
		if (!empty($arr)) {
			$parent = null;
			$space = null;
			foreach ($arr as $key => $value) {
				if (trim($value)) {
					$this->parseLine($value);
				}
			}
		}
		print_r($this->spaces);
	}
}

$b = microtime(true);
Parser::parse('main.sml')->out();
$e = microtime(true);
echo $e - $b . "\n";