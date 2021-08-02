<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="get">
        <textarea name="url" id="url" cols="10" rows="5"><?php if (!empty($_GET['url'])) echo $_GET['url']; ?></textarea>
        <button type="submit">Scrap</button>
    </form>
</body>

</html>
<?php
require __DIR__ . '/vendor/autoload.php';

use Goutte\Client;


$client = new Client;
if (empty($_GET['url'])) {
    $url = 'https://www.lazada.co.id/products/aplle-macbook-air-m1-mgn73-mgna3-mgne3-8-core-8gb-512gb-13inch-i5506502685-s10965954863.html?spm=a2o4j.searchlist.list.120.35ba7f50z5UoBY&search=1&freeshipping=1';
} else {
    $url = $_GET['url'];
}

$crawler = $client->request('GET', $url);
$gambar = array();
$i = 0;
$crawler->filter('#module_product_title_1 > div > div > h1')->each(function ($node) {
    echo "Nama : " . $node->text() . "<br>";
});

$crawler->filter('#module_product_price_1 > div > div > span')->each(function ($node) {
    echo "Harga : " . str_replace(['Rp', '.'], '', $node->text()) . "<br>";
});

$crawler->filter('#module_seller_info > div > div.seller-name-retail > div.seller-name__wrapper > div.seller-name__detail > a')->each(function ($node) {
    echo "Sold By : " . $node->text() . "<br>";
});


$crawler->filter('#module_item_gallery_1 > div div.next-slick.next-slick-outer.next-slick-horizontal.item-gallery-slider > div > div.next-slick-list > div.next-slick-track div:nth-child(1)')->each(function ($node) use (&$gambar) {
    $gambar[] = $node->children()->filter('img')->eq(0)->attr('src');
});
unset($gambar[0]);
echo "Jumlah Gambar: " . count($gambar) . "<br>";

echo "=====================================================<br>";
$crawler->filter('body > script:nth-child(6)')->each(function ($node) {
    // echo $node->html() . "<br>";
    // $strings = $node->text();
    $st = $node->html();

    $js = json_decode($st);

    // var_dump($js);

    echo "Descriptions : " . $js->description . "<br>";
    echo "SKU : " . $js->sku . "<br>";
});
echo "=====================================================<br>";
$crawler->filter('body > script:nth-child(7)')->each(function ($node) {
    echo $node->html() . "<br>";
});
echo "=====================================================<br>";
$crawler->filterXPath('//script[contains(.,"pdpTrackingData")]')->each(function ($node) {
    $sts = json_encode($node->text());
    $ste = explode(";", $sts);
    $stes = explode(" = ", $ste[1]);
    $stfs = json_decode(stripslashes($stes[1]));
    $jssa = json_decode($stfs);
    echo "Registration Cat Id : " . $jssa->page->regCategoryId . "<br>";
});
echo "=====================================================<br>";
echo "Cat ID : NULL" . "<br>";
