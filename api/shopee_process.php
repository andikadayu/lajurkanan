<?php
include '../config.php';

use Curl\Curl;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

    $accesskey = $_POST['accesskey'];
    $links = $_POST['links'];
    $clears = str_replace("?position=", ".", $links);
    $alls = explode(',', $clears);

    $cek = mysqli_query($conn, "SELECT id_user FROM tb_user WHERE accesskey='$accesskey'");

    $id_user = 0;
    $ids = 0;
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
    $i = 0;
    $str_url;
    $origin;
    $param;
    $params;
    $shop_id;
    $item_id;
    $video = array();
    $image = array();
    $linkss;
    $gambar1;
    $video1;

    $c = count($alls);

    if (mysqli_num_rows($cek) > 0) {
        while ($d = mysqli_fetch_assoc($cek)) {
            $id_user = $d['id_user'];
        }
        $dates = date('Y-m-d H:i:s');
        $sql1 = mysqli_query($conn, "INSERT INTO tb_scrap VALUES(NULL,'$dates',1,'$id_user')");
        $ids = mysqli_insert_id($conn);
        $versionitem = 4;
        if ($sql1) {
            foreach ($alls as $key => $valued) {
                $values = stripslashes(str_replace('"', '', $valued));
                $param = explode('-i.', $values);
                $params = explode('.', $param[1]);
                $shop_id = $params[0];
                $item_id = $params[1];

                $curls = new Curl();
                $curls->get("https://shopee.co.id/api/v4/item/get?itemid=" . $item_id . "&shopid=" . $shop_id . "&version=" . $versionitem);
                if ($curls->error) {
                    $response['status'] = 'Error: ' . $curls->errorCode . ': ' . $curls->errorMessage . "\n";
                } else {
                    $versionitem++;
                    $js = $curls->response;
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

                    $sq = mysqli_query($conn, "INSERT INTO tb_shopee VALUES(NULL,'$ids','$linkss','$nama','$deskripsi','$catid','0','1','0','1','Baru','$gambar1','$video1','','Aktif','$stok','$harga','optional')");
                    if ($sq) {
                        if ($key == $c - 1) {
                            $response['status'] = "OK";
                        }
                    } else {
                        $response['status'] = mysqli_error($conn);
                    }
                }
            }
        } else {
            $response['status'] = "ERROR";
        }
    } else {
        $response['status'] = "ERROR";
    }
    $conn->close();
    echo json_encode($response, JSON_PRETTY_PRINT);
}
