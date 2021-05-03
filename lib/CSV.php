<?php 
namespace lib;

use lib\Arr;

class CSV {

  public static function parse_from_file(string $path, string $delimiter = ";", string $newline = "\n"): Arr {
    $file = file_get_contents(realpath($path));
    $arr = new Arr();
    $rows = explode($newline, $file);
    if (count($rows) > 0) {
      foreach ($rows as $row) {
        $els = explode($delimiter, $row);
        $arr->push($els);
      }
    }
    return $arr;
  }
}