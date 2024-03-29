<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Scrap Shopee">
    <title>Lajur Kanan Official</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/datatable/DataTables-1.10.25/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/datatable/datatables.min.js"></script>
    <script src="assets/datatable/DataTables-1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/shopee_page.min.js"></script>
</head>
<?php
include 'config.php';
session_start();
if ($_SESSION['isLogin'] == false) {
    header("location:index.php");
}
?>

<body class="d-flex flex-column min-vh-100">
    <?php require_once 'component/navbar.php'; ?>

    <section>
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
                            <button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Single Scrap</button>
                            <button type="button" class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#shopModal">Scrap per Shop</button>
                            <button type="button" class="btn btn-md btn-secondary" data-bs-toggle="modal" data-bs-target="#betaModal">Scrap Item (Beta)</button>

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

                                            include 'controller/ViewShopee.php';

                                            $view = new ViewShopee($conn);

                                            echo $view->getRow();

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal modal-dialog-scrollable fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel1">Scrap per Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="controller/pro_shopee.php" method="POST" autocomplete="off" aria-autocomplete="none">
                            <div class="modal-body">
                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                                <div class="form-group">
                                    <label for="">Link</label> <span class="badge bg-danger" id="all_badge">Get Link First</span>
                                    <div class="row">
                                        <div class="col-11">
                                            <textarea name="all_link" id="all_link" rows="20" class="form-control" placeholder="Enter Product Link Separate by NewLine/Enter(↵)" required></textarea>
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="btn btn-success" onclick="getAllLink()">Get</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="linksss"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" disabled id="scBtn">Scrap Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal modal-dialog-scrollable fade" id="shopModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel2">Scrap per Shop <small>*Maximum get Data in shop 100 (maybe random product)</small></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="controller/pro_shop_shopee.php" method="POST" autocomplete="off" aria-autocomplete="none">
                            <div class="modal-body">
                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>" required aria-required="true">
                                <div class="from-group">
                                    <label for="shop_id">ID Toko</label>
                                    <textarea name="shop_id" id="shop_id" rows="5" class="form-control" placeholder="place id toko seperate by comma" required aria-required="true"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="scBtn1">Scrap Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal modal-dialog-scrollable fade" id="betaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel2">Scrap Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="controller/pro_shop_beta.php" method="POST" autocomplete="off" aria-autocomplete="none">
                            <div class="modal-body">
                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>" required aria-required="true">
                                <div class="from-group">
                                    <label for="link_beta">Link URL</label>
                                    <textarea name="link_beta" id="link_beta" rows="5" class="form-control" placeholder="place URL Product seperate by comma" required aria-required="true"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="scBtn1">Scrap Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal modal-dialog-scrollable fade" id="modalExport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel4">Export XLSX</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="print/excel_shopee.php" method="POST" autocomplete="off" aria-autocomplete="none">
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
                                                    <input type="text" name="kategori" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="123" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="checkbox" name="markups_perhar" value="yes" onclick="if(this.checked === false){document.getElementById('nilai_markup').disabled=true;document.getElementById('metode_markup').disabled=true;}else{document.getElementById('nilai_markup').disabled=false;document.getElementById('metode_markup').disabled=false;}" aria-label="Radio button for following text input">Markup
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
                                                        <input class="form-check-input mt-0" type="checkbox" name="markups_rumus" value="yes" onclick="if(this.checked === false){document.getElementById('rumus').disabled=true}else{document.getElementById('rumus').disabled=false}" aria-label="Radio button for following text input">Harga
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
                                                        <input type="number" name="berat" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="123" required>
                                                        <span class="input-group-text">g</span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">Min Pesan</span>
                                                        <input type="number" name="min_pesan" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="123" required>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">Min Stok</span>
                                                        <input type="number" name="stok" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="123">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 15px;">
                                                <div class="col">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">Min Harga</span>
                                                        <input type="number" name="min_harga" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="123">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">Save As</span>
                                                        <input type="text" class="form-control" name="nama_file" aria-label="Sizing example input" required aria-describedby="inputGroup-sizing-default" placeholder="Nama Toko (Min 3 letter)" required>
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
            </div>
        </div>
    </section>

    <?php include 'component/footer.php'; ?>

    <?php $conn->close(); ?>
</body>

</html>