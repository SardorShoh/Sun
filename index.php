<?php
require_once("autoload.php");
// $csv = \csv\CSV::parseCSV("xcheckstore.csv");
$str = '{"hello": "hi"}';
$json = new \lib\JSON($str);
echo "<pre>";
print_r($json->decode()->values());