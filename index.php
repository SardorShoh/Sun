<?php
require_once("autoload.php");
// $csv = \csv\CSV::parseCSV("xcheckstore.csv");
// $str = '{"hello": "hi"}';
// $json = new \lib\JSON($str);
// echo "<pre>";
// print_r($json->decode()->values());
// $req = new \lib\Headers;
// echo '<pre>';
// // print_r($req->query('name'));
// print_r($req->getCookie('hellol'));
use \lib\{App, Config};
$conf = new Config();
$app = new App($conf);

$app->get('/login', function () {
  echo 'App running';
});

$app->run();