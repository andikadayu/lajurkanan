<?php
include 'config.php';

use Goutte\Client;

$client = new Client;
$url = 'https://shopee.co.id/shop/161305257/search';
$crawler = $client->request('GET', $url);
echo "<textarea>url: $url </textarea> <br>";


var_dump($crawler->filter("#main > div > div._193wCc > div > div > div.shop-search-page__right-section > div > div.shop-search-result-view > div"));
