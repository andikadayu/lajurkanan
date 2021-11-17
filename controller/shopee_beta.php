<?php

include '../config.php';

$response = [];

$json = $_POST['data'];

$jsons = json_decode($json);

foreach ($jsons as $key => $js) {
    $nama = $js->name;
    $deskripsi = $js->deskripsi;
    $catid = $js->catid;
    $berat = 0;
    $min = 1;
    $etalase = NULL;
    $preorder = 1;
    $kondisi = "Baru";
    $gambar1 = $js->gambar1;
    $video1 = $js->video1;
    $sku = NULL;
    $status = "Aktif";
    $stok = $js->stok;
    $harga = $js->harga;
    $asuransi = "optional";
    $itemid = $js->itemid;
    $shopid = $js->shopid;
    $linkss;


    $ids = $js->id_scrap;

    $linkss = "https://shopee.co.id/" . str_replace(" ", "-", $nama) . "-i." . $shopid . "." . $itemid;
    $sq = mysqli_query($conn, "INSERT INTO tb_shopee VALUES(NULL,'$ids','$linkss','$nama','$deskripsi','$catid','$berat','$min','$etalase','$preorder','$kondisi','$gambar1','$video1','$sku','$status','$stok','$harga','$asuransi')");
}

    
$response['status'] = "OK";

echo json_encode($response, JSON_PRETTY_PRINT);
