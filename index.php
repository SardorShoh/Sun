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
// $conf->caseSensitive = true;
// $conf->strictRouting = true;
$conf->server_header = 'App server';
$app = new App($conf);

$app->get('/login/:name/:date/:time', function ($ctx) {
  $ctx->json($ctx->params());
});

$app->post('/login', function ($ctx) {
  $ctx->status(404)->json(['hello' => 'world']);
});

$app->get('/api/test', function($ctx){
  $ctx->status(404)->html('<b>Hello</b>');
});

$app->run();

// print_r(preg_split("/[-.\/]+/", 'kdfhskd/jdjdjdj/dkkdkd-kkdkdk', PREG_SPLIT_OFFSET_CAPTURE));