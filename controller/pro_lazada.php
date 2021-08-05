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


    $client = new Client;

    $c = $_POST['counts'];
    $id = $_POST['id_user'];
    $dates = date('Y-m-d H:i:s');

    $sql1 = mysqli_query($conn, "INSERT INTO tb_scrap VALUES(NULL,'$dates',2,'$id','$c')");
    $ids = mysqli_insert_id($conn);

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
    $sku = "";
    $status = "Aktif";
    $stok = 12;
    $harga = 12000;
    $asuransi = "optional";
    $i = 0;

    if ($sql1) {
        foreach ($_POST['links'] as $key => $value) {


            $crawler = $client->request('GET', $value);
            $gambar = array();
            $crawler->filter('#module_product_title_1 > div > div > h1')->each(function ($node) use (&$nama) {
                $nama = $node->text();
            });

            $crawler->filter('#module_product_price_1 > div > div > span')->each(function ($node) use (&$harga) {
                $harga = str_replace(['Rp', '.'], '', $node->text());
            });

            $crawler->filter('#module_item_gallery_1 > div div.next-slick.next-slick-outer.next-slick-horizontal.item-gallery-slider > div > div.next-slick-list > div.next-slick-track div:nth-child(1)')->each(function ($node) use (&$gambar) {
                $gambar[] = $node->children()->filter('img')->eq(0)->attr('src');
            });
            unset($gambar[0]);

            $gambar1 = json_encode($gambar);


            $crawler->filter('body > script:nth-child(6)')->each(function ($node) use (&$deskripsi, &$sku) {

                $st = $node->text();

                $js = json_decode($st);

                $deskripsi = str_replace("'", '', $js->description);
                $sku = $js->sku;
            });
            $crawler->filterXPath('//script[contains(.,"pdpTrackingData")]')->each(function ($node) use (&$catid) {
                $sts = json_encode($node->text());
                $ste = explode(";", $sts);
                $stes = explode(" = ", $ste[1]);
                $stfs = json_decode(stripslashes($stes[1]));
                $jssa = json_decode($stfs);
                // $catid = $jssa->page->regCategoryId;
            });

            $sq = mysqli_query($conn, "INSERT INTO tb_lazada VALUES(NULL,'$ids','$value','$nama','$deskripsi','$catid','$berat','$min','$etalase','$preorder','$kondisi','$gambar1','$video1','$sku','$kondisi','$stok','$harga','$asuransi')");
            if ($sq) {
            } else {
                var_dump(mysqli_error($conn));
            }
            $i++;
            $perc = $i / $c * 100;
            echo "<script>
                                $('#pr_bar').css('width','$perc%');$('#percentages').text('$perc%');if ($perc >= 100) {alert('Scrap Data Done');location.href='../lazada_page.php';}</script>";
        }
    } else {
        echo 'error';
    }
    ?>

</body>

</html>