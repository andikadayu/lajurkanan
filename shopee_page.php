<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lajur Kanan Official</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/datatable/DataTables-1.10.25/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/datatable/datatables.min.js"></script>
    <script src="assets/datatable/DataTables-1.10.25/js/dataTables.bootstrap5.min.js"></script>
</head>
<?php
include 'config.php';
session_start();
if ($_SESSION['isLogin'] == false) {
    header("location:index.php");
}
?>

<body>
    <?php require_once 'component/navbar.php'; ?>


    <div class="container-fluid">
        <div class="row" style="margin-top: 25px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Scrap Shopee
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Single Scrap</button>
                                <button type="button" class="btn btn-md btn-success">Export</button>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="datatables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Scrap Date</th>
                                            <th>Count</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($_SESSION['role'] == 'user') {
                                            $sql = mysqli_query($conn, "SELECT sc.tgl_scrap,user.name,sc.counts,sc.id_scrap FROM tb_scrap as sc INNER JOIN tb_user as user ON user.id_user = sc.id_user WHERE sc.id_commerce=1 AND sc.id_user='" . $_SESSION['id_user'] . "'");
                                        } else {
                                            $sql = mysqli_query($conn, "SELECT sc.tgl_scrap,user.name,sc.counts,sc.id_scrap FROM tb_scrap as sc INNER JOIN tb_user as user ON user.id_user = sc.id_user WHERE sc.id_commerce=1 ");
                                        }
                                        $no = 1;

                                        while ($d = mysqli_fetch_assoc($sql)) { ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo date_format(date_create($d['tgl_scrap']), 'D,d-M-Y H:i:s'); ?></td>
                                                <td><?php echo $d['counts']; ?></td>
                                                <td><?php echo $d['name']; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-success btn-float rounded-circle" onclick="cetakExcel(<?php echo $d['id_scrap']; ?>)" data-bs-toggle="modal" data-bs-target="#modalExport"><i class="fa fa-file-excel"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-dialog-scrollable fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Scrap per Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="controller/pro_shopee.php" method="POST" autocomplete="off" aria-autocomplete="none">
                    <div class="modal-body">
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                        <label for="">Number Link</label>
                        <input type="number" id="countsLink" name="counts" class="form-control" onchange="addInput()" min='1' max='50' required>
                        <div id="linksss"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Scrap Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal modal-dialog-scrollable fade" id="modalExport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Scrap per Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" autocomplete="off" aria-autocomplete="none">
                    <div class="modal-body">
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                        <label for="">Number Link</label>
                        <input type="number" id="countsLink" name="counts" class="form-control" onchange="addInput()" min='1' max='50' required>
                        <div id="linksss"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Scrap Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#datatables').DataTable();
        });

        function addInput() {
            let countsLink = $('#countsLink').val();
            console.log(countsLink);
            $('#linksss').empty();
            for (let index = 0; index < countsLink; index++) {
                $('#linksss').append(`<div class='form-group'><label>Links item ${index+1}</label><input type='text' name='links[${index}]' class='form-control' required></div>`);
            }
        }
    </script>
</body>

</html>