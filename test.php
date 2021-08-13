<?php
header("Access-Control-Allow-Origin: *");
include 'config.php';

use Goutte\Client;

$response;
$client = new Client;
$url = "https://www.lazada.co.id/products/helm-bogo-retro-dewasa-bogo-garis-classic-cod-good-quality-hitam-glossy-set-kaca-cembung-i2998856031-s10947800292.html?spm=a2o4j.home.just4u.9.46f87838STwfdc&scm=1007.17519.217310.0&pvid=d503f12c-8e4e-4fc3-8cf3-ad705f8f0ed0&search=jfy&clickTrackInfo=tcsceneid%3AHPJFY%3Bbuyernid%3Ax8pp5AgBCSoD8vxrP0YvXsZLvbZV2CID%3Btctags%3A458814850%3Btcboost%3A0%3Bpvid%3Ad503f12c-8e4e-4fc3-8cf3-ad705f8f0ed0%3Bchannel_id%3A0000%3Bmt%3Ahot%3Bitem_id%3A2998856031%3Bself_ab_id%3A217310%3Bself_app_id%3A7519%3Blayer_buckets%3A6008.28455_3650.16539_5437.25242_955.3634_6059.28891_4944.22703_6008.28452_955.7331_4944.22702%3Bpos%3A8%3B";

$crawler = $client->request('GET', $url);
$gambar = array();

echo $crawler->filter('html')->html();
