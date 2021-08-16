<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proccess</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/datatable/DataTables-1.10.25/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/datatable/datatables.min.js"></script>
    <script src="../assets/datatable/DataTables-1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <style>
        #loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-right: 16px solid green;
            border-bottom: 16px solid red;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row" style="margin-top: 25px;">
            <div class="col-12">
                <div class="card" style="background-color: white; height: 30vh;">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group" id="process" style="display:block;">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped active" id="pr_bar" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                    <label id="percentages"></label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div id="loader"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include '../config.php';

    use Goutte\Client;
    use Curl\Curl;

    $client = new Client;
    $curl = new Curl();

    $curl->disableTimeout();

    $id = $_POST['id_user'];
    $dates = date('Y-m-d H:i:s');
    $shop_ids = $_POST['shop_id'];

    $items = array();
    $data = array();
    $c = 0;
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

    $sho = explode(',', $shop_ids);
    $c = count($sho);

    $sql1 = mysqli_query($conn, "INSERT INTO tb_scrap VALUES(NULL,'$dates',1,'$id')");
    $ids = mysqli_insert_id($conn);
    $versionshop = 4;
    $versionitem = 4;
    if ($sql1) {
        foreach ($sho as $key => $value) {
            $curl->get("https://shopee.co.id/api/v2/search_items/?match_id=" . $value . "&order=desc&page_type=shop&limit=100&version=" . $versionshop);
            $versionshop++;

            if ($curl->error) {
                echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
            } else {
                $res =  $curl->response;
                $items = $res->items;
                foreach ($items as $key => $value) {
                    $data[] = ["shopid" => $value->shopid, "itemid" => $value->itemid];
                }

                foreach ($data as $key => $value) {
                    $curls = new Curl();
                    $curls->get("https://shopee.co.id/api/v4/item/get?itemid=" . $value['itemid'] . "&shopid=" . $value['shopid'] . "&version=" . $versionitem);
                    $versionitem++;
                    if ($curls->error) {
                        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
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

                        $sq = mysqli_query($conn, "INSERT INTO tb_shopee VALUES(NULL,'$ids','$linkss','$nama','$deskripsi','$catid','$berat','$min','$etalase','$preorder','$kondisi','$gambar1','$video1','$sku','$kondisi','$stok','$harga','$asuransi')");
                        if ($sq) {
                        } else {
                            var_dump(mysqli_error($conn));
                        }
                    }
                }
            }
            $i++;
            $perc = $i / $c * 100;
            echo "<script>
                            $('#pr_bar').css('width','$perc%');$('#percentages').text('$perc%');if ($perc >= 100) {alert('Scrap Data Done');location.href='../shopee_page.php';}</script>";
        }
    }

    $conn->close();
    ?>

</body>

</html>