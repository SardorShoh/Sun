<?php 

class csv {
    
  protected function __construct() {}
  protected function __clone() {}
    
  public finally static function getFile(string $file) {
    $file = file_get_contents(realpath($file));
    return $file;
  }

  protected function parseCSV() {
    
  }
    
  public finally function toArray() {
    return [];
  }
    
  public finally function toObject() {
        
  }
}