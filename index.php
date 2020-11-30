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
$conf->caseSensitive = true;
$conf->strictRouting = true;
$conf->serverHeader = 'App server';
$app = new App($conf);

$app->get('/login/:hdhdh/', function ($ctx) {
  $ctx->send($ctx->params('hdhdh'));
});

$app->post('/login', function ($ctx) {
  $ctx->json(['hello' => 'world']);
});

$app->run();