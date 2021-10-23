<?php

include '../config.php';

use Curl\Curl;

$response = [];

$nama = NULL;
$deskripsi = NULL;
$catid = 0;
$berat = 0;
$min = 1;
$etalase = NULL;
$preorder = 1;
$kondisi = "Baru";
$gambar1 = NULL;
$video1 = NULL;
$sku = NULL;
$status = "Aktif";
$stok = 12;
$harga = 12000;
$asuransi = "optional";
$video = array();
$image = array();
$linkss;
$version = rand(7, 99999999);


$shop_id = $_POST['shop_id'];
$item_id = $_POST['item_id'];
$ids = $_POST['id_scrap'];

$curl = new Curl();

$curl->get("https://shopee.co.id/api/v4/item/get?itemid=" . $item_id . "&shopid=" . $shop_id . "&version=" . $version);

if ($curl->error) {
    $response['status'] = "ERROR";
    $response['statusCode'] = $curl->errorCode;
    $response['msg'] = $curl->errorMessage;
} else {
    $js = $curl->response;

    foreach ($js->data->images as $key => $value) {
        $image["img$key"] = $value;
    };
    $gambar1 = json_encode($image);
    $harga = substr($js->data->price_max, 0, -5);
    $stok = $js->data->stock;
    $nama = str_replace("'", "", $js->data->name);
    $catid = $js->data->catid;
    $deskripsi = str_replace("'", "", $js->data->description);
    if ($js->data->video_info_list != '') {
        $video = $js->data->video_info_list;
        $video1 = json_encode($video);
    } else {
        $video1 = null;
    }

    $linkss = "https://shopee.co.id/" . str_replace(" ", "-", $nama) . "-i." . $js->data->shopid . "." . $js->data->itemid;
    $sq = mysqli_query($conn, "INSERT INTO tb_shopee VALUES(NULL,'$ids','$linkss','$nama','$deskripsi','$catid','$berat','$min','$etalase','$preorder','$kondisi','$gambar1','$video1','$sku','$status','$stok','$harga','$asuransi')");
    if ($sq) {
        $response['status'] = "OK";
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
