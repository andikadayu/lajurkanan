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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include '../config.php';
    $c = $_POST['counts'];
    $id = $_POST['id_user'];
    $dates = date('Y-m-d H:i:s');

    $sql1 = mysqli_query($conn, "INSERT INTO tb_scrap VALUES(NULL,'$dates',1,'$id','$c')");
    $ids = mysqli_insert_id($conn);
    $curl = curl_init();
    $i = 0;

    if ($sql1) {
        foreach ($_POST['links'] as $key => $value) {
            # code...
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://advance-shopee.p.rapidapi.com/get_item_detail_by_url?URL=" . $value,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: advance-shopee.p.rapidapi.com",
                    "x-rapidapi-key: e901a17b66msh2c37104eadd65e3p12d306jsn96386c40c5ec"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $i++;
                $perc = $i / $c * 100;
                $s = json_encode($response);
                $ss = str_replace("'", " ", $s);
                $sds = mysqli_query($conn, "INSERT INTO tb_detail_scrap VALUES(NULL,'$ids','$value','$ss')");
                if ($sds) {
                    echo "<script>
                                $('#pr_bar').css('width','$perc%');$('#percentages').text('$perc%');if ($perc >= 100) {alert('Scrap Data Done');location.href='../shopee_page.php';}</script>";
                } else {
                    var_dump(mysqli_error($conn));
                }
            }
        }
    } else {
        echo 'error';
    }
    ?>

</body>

</html>