<?php
header("Access-Control-Allow-Origin: *");
include '../config.php';

use Goutte\Client;

$response;
$client = new Client;
$url = $_GET['url'];

$crawler = $client->request('GET', $url);
$gambar = array();


$crawler->filterXPath('//script[contains(.,"window.pageData")]')->each(function ($node) use (&$response) {
    $gt = $node->html();
    $s = explode(" = ", $gt);
    $ss = json_encode($s[1], JSON_PRETTY_PRINT);
    $response = $ss;
});

echo str_replace(';', '', $response);
