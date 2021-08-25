<?php

include '../config.php';

use Curl\Curl;

class ShopProccess
{

    public $conn;
    public $ids;
    public $shopid;
    public $itemid;
    public $versionitem;

    public function __construct($conn, $ids, $shopid, $itemid, $versionitem)
    {
        $this->conn = $conn;
        $this->ids = $ids;
        $this->shopid = $shopid;
        $this->itemid = $itemid;
        $this->versionitem = $versionitem;
    }

    public function proccess_insert()
    {
        $curls = new Curl();
        $curls->get("https://shopee.co.id/api/v4/item/get?itemid=" . $this->itemid . "&shopid=" . $this->shopid . "&version=" . $this->versionitem);
        $this->versionitem++;
        if ($curls->error) {
            echo 'Error: ' . $curls->errorCode . ': ' . $curls->errorMessage . "\n";
        } else {
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
                var_dump(mysqli_error($this->conn));
            }
        }
    }
}
