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
                            Scrap Lazada
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Single Scrap</button>
                                <button type="button" class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#scrapToko">Scrap Shop</button>
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
                                            $sql = mysqli_query($conn, "SELECT sc.tgl_scrap,user.name,sc.counts,sc.id_scrap FROM tb_scrap as sc INNER JOIN tb_user as user ON user.id_user = sc.id_user WHERE sc.id_commerce=2 AND sc.id_user='" . $_SESSION['id_user'] . "' ORDER BY sc.tgl_scrap DESC");
                                        } else {
                                            $sql = mysqli_query($conn, "SELECT sc.tgl_scrap,user.name,sc.counts,sc.id_scrap FROM tb_scrap as sc INNER JOIN tb_user as user ON user.id_user = sc.id_user WHERE sc.id_commerce=2 ORDER BY sc.tgl_scrap DESC");
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
                <form action="controller/pro_lazada.php" method="POST" autocomplete="off" aria-autocomplete="none">
                    <div class="modal-body">
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                        <label for="">Number Link</label>
                        <input type="number" id="countsLink" name="counts" class="form-control" onchange="addInput()" min='1' max='50' required>
                        <div id="linksss"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="scBtn">Scrap Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-dialog-scrollable fade" id="scrapToko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Scrap per Shop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="controller/pro_lazada.php" method="POST" autocomplete="off" aria-autocomplete="none">
                    <div class="modal-body">
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                        <input type="hidden" id="countslinkshop" name="counts" class="form-control" onchange="addInput()" min='1' max='50' required>
                        <label for="">Shop Link</label>

                        <div class="row">
                            <div class="col-11">
                                <input type="text" id="shop_link" name="shoplink" class="form-control" required>
                            </div>
                            <div class="col">
                                <button type="button" id="getShop" class="btn btn-sm btn-success" onclick="getShops()">Get</button>
                            </div>
                        </div>
                        <div id="linksssp"></div>
                        <span class='badge bg-danger' id="labellink">Get Shop Link First</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="scBtn1">Scrap Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal modal-dialog-scrollable fade" id="modalExport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Export XLSX</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="print/excel_lazada.php" method="POST" autocomplete="off" aria-autocomplete="none">
                    <div class="modal-body">
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>" required>
                        <input type="hidden" name="id_scrap" id="ex_id_scrap" required>
                        <div class="row">
                            <div class="col-4">
                                <h5>Optimasi Konten</h5>
                                <div class="form-group">
                                    <label for="nama_awal">Awal Nama Produk</label>
                                    <input type="text" name="nama_awal" id="nama_awal" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="nama_akhir">Akhir Nama Produk</label>
                                    <input type="text" name="nama_akhir" id="nama_akhir" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi_awal">Awal Deskripsi</label>
                                    <textarea name="deskripsi_awal" id="deskripsi_awal" cols="2" rows="2" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi_akhir">Akhir Deksripsi</label>
                                    <textarea name="deskripsi_akhir" id="deskripsi_akhir" cols="2" rows="2" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="hapus_kata">Hapus Kata-kata ini (pisahkan dengan koma , )</label>
                                    <input type="text" name="hapus_kata" id="hapus_kata" class="form-control">
                                </div>
                            </div>
                            <div class="col-8">
                                <h5>Export</h5>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="checkbox" onclick="if(this.checked == false){document.getElementById('preorder').value = 0;document.getElementById('preorder').readOnly = true;}else{document.getElementById('preorder').readOnly = false;}" value="preorder_check" aria-label="Radio button for following text input">Preorder
                                            </div>
                                            <input type="number" class="form-control" name="preorder" id="preorder" value="0" aria-label="Text input with radio button" placeholder="Hari" readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-default">Etalase</span>
                                            <input type="number" class="form-control" name="etalase" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="Etalase">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-default">Kategori</span>
                                            <input type="text" name="kategori" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="123">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="radio" name="markups" value="metode" onclick="checkMarkups(this.value)" aria-label="Radio button for following text input">Markup
                                            </div>
                                            <input type="number" name="nilai_markup" id="nilai_markup" class="form-control" aria-label="Text input with radio button" disabled>
                                            <div class="input-group-text">
                                                <select name="metode_markup" id="metode_markup" class="form-select form-select-sm" disabled>
                                                    <option value="%">%</option>
                                                    <option value="RP">RP</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="radio" name="markups" value="rumus" onclick="checkMarkups(this.value)" aria-label="Radio button for following text input">Harga
                                            </div>
                                            <select name="rumus" id="rumus" class="form-select form-select-sm" disabled>
                                                <option value="Murah">Rumus Murah</option>
                                                <option value="Sedang">Rumus Sedang</option>
                                                <option value="Mahal">Rumus Mahal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 15px;">
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroup-sizing-default">Berat</span>
                                                <input type="number" name="berat" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="123">
                                                <span class="input-group-text">g</span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroup-sizing-default">Min Pesan</span>
                                                <input type="number" name="min_pesan" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="123">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroup-sizing-default">Stok</span>
                                                <input type="number" name="stok" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="123">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 15px;">
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroup-sizing-default">Save As</span>
                                                <input type="text" class="form-control" name="nama_file" aria-label="Sizing example input" required aria-describedby="inputGroup-sizing-default" placeholder="Nama Toko">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Export XLSX</button>
                        </div>
                </form>
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

            function getShops() {
                let re = $('#shop_link').val();
                $('#linksssp').empty();
                $.ajax({
                    url: 'controller/getShopLazada.php',
                    method: "get",
                    data: {
                        url: re
                    },
                    dataType: 'json'
                }).done(function(data) {
                    let json = JSON.parse(data);
                    let list = json['mods']['listItems'];
                    let i = 0;
                    let links;
                    let cleanlinks;
                    list.forEach(element => {
                        links = element['productUrl'];
                        cleanlinks = links.replace('//', 'https://');
                        $('#linksssp').append(`<div class='form-group'><input type='hidden' name='links[${i}]' value='${cleanlinks}' class='form-control' required></div>`);
                        i++;
                    });
                    $('#countslinkshop').val(i);
                    $('#labellink').removeClass('bg-danger');
                    $('#labellink').addClass('bg-success');
                    $('#labellink').text("Get Shop Product Done, Go to Scrap");

                });
            }

            function checkMarkups(nm) {
                if (nm == 'rumus') {
                    $('#rumus').attr('disabled', false);
                    $('#metode_markup').attr('disabled', true);
                    $('#nilai_markup').attr('disabled', true);
                } else {
                    $('#rumus').attr('disabled', true);
                    $('#metode_markup').attr('disabled', false);
                    $('#nilai_markup').attr('disabled', false);
                }
            }

            function cetakExcel(id) {
                $('#ex_id_scrap').val(id);
            }
        </script>

</body>

</html>