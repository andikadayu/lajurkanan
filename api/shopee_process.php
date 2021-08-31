<?php
include '../config.php';

use Curl\Curl;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

    $accesskey = $_POST['accesskey'];
    $links = $_POST['links'];
    $rem = [];
    for ($i = 0; $i < 30; $i++) {
        array_push($rem, "?position=$i");
    }
    $replacelink = str_replace($rem, "", $links);
    $alls = explode(',', $replacelink);

    $cek = mysqli_query($conn, "SELECT id_user FROM tb_user WHERE accesskey='$accesskey'");

    $id_user = 0;
    $ids = 0;

    $c = count($alls);

    if (mysqli_num_rows($cek) > 0) {
        while ($d = mysqli_fetch_assoc($cek)) {
            $id_user = $d['id_user'];
        }
        $dates = date('Y-m-d H:i:s');
        $sql1 = mysqli_query($conn, "INSERT INTO tb_scrap VALUES(NULL,'$dates',1,'$id')");
        $ids = mysqli_insert_id($conn);
        $versionitem = 4;
        if ($sql1) {
            foreach ($alls as $key => $values) {
                $param = explode('-i.', $values);
                $params = explode('.', $param[1]);
                $shop_id = $params[0];
                $item_id = $params[1];

                $curls = new Curl();
                $curls->get("https://shopee.co.id/api/v4/item/get?itemid=" . $itemid . "&shopid=" . $shopid . "&version=" . $this->versionitem);
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

                    $sq = mysqli_query($this->conn, "INSERT INTO tb_shopee VALUES(NULL,'$this->ids','$linkss','$nama','$deskripsi','$catid','0','1','0','1','Baru','$gambar1','$video1','','Aktif','$stok','$harga','optional')");
                    if ($sq) {
                    } else {
                        $response['status'] = mysqli_error($this->conn);
                    }
                }
                if ($key == $c - 1) {
                    $response['status'] = "OK";
                }
            }
        } else {
            $response['status'] = "ERROR";
        }
    } else {
        $response['status'] = "ERROR";
    }
    echo json_encode($response, JSON_PRETTY_PRINT);
    $conn->close();
}
