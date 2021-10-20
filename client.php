<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Home Lajur Kanan">
    <title>Lajur Kanan Official</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <!-- <link rel="stylesheet" href="assets/datatable/DataTables-1.10.25/css/dataTables.bootstrap5.min.css"> -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <!-- <script src="assets/js/jquery-3.6.0.min.js"></script>
 -->
    <!-- <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <!-- <script src="assets/datatable/datatables.min.js"></script>
    <script src="assets/datatable/DataTables-1.10.25/js/dataTables.bootstrap5.min.js"></script> -->
    <script src="assets/js/client.min.js"></script>
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


    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Management Client</div>
                    </div>
                    <div class="card-body">

                        <div class="row" style="margin-top: 10px;">
                            <div class="table-responsive justify-content-center">
                                <table class="table table-hover table-bordered" id="datatables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 12%;">Name</th>
                                            <th style="width: 10%;">Email</th>
                                            <th style="width: 10%;">Telp</th>
                                            <th style="width: 15%;">Alamat</th>
                                            <th style="width: 4%;">Status</th>
                                            <th style="width: 15%;">Active Date</th>
                                            <th style="width: 5%;">Harga</th>
                                            <th style="width: 9%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $sql = mysqli_query($conn, "SELECT id_user,name,email,role,harga_regis,is_active,no_telp,alamat,active_from,active_until FROM tb_user_old Where role='client'");
                                        $no = 1;
                                        while ($user = mysqli_fetch_assoc($sql)) { ?>

                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $user['name']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td><?php echo $user['no_telp']; ?></td>

                                                <td><?php echo $user['alamat']; ?></td>
                                                <td><?php if ($user['is_active'] == 0) {
                                                        echo "<span class='badge bg-danger'>Inacive</span>";
                                                    } else {
                                                        echo "<span class='badge bg-success'>Active</span>";
                                                    }  ?></td>

                                                <td>
                                                    <?php
                                                    echo date_format(date_create($user['active_from']), 'd-M-Y') . ' s/d <br>' . date_format(date_create($user['active_until']), 'd-M-Y');
                                                    ?>

                                                </td>
                                                <td>Rp.<?php echo number_format($user['harga_regis']); ?></td>
                                                <td>
                                                    <?php if ($user['role'] == 'superadmin') { ?>
                                                        <button class="btn btn-sm btn-warning btn-float rounded-circle" aria-label="get" title="Edit" onclick="getData(<?php echo $user['id_user']; ?>)"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-sm btn-danger btn-float rounded-circle" aria-label="delete" title="Delete" onclick="deleteData(<?php echo $user['id_user']; ?>)"><i class="fa fa-trash"></i></button>
                                                    <?php } else { ?>
                                                        <?php if ($user['is_active'] != 1) { ?>
                                                            <button class="btn btn-sm btn-success btn-float rounded-circle" aria-label="activate" title="set lunas and send invoice" onclick="activate(<?php echo $user['id_user']; ?>)"><i class="fa fa-check"></i></button>
                                                            <button class="btn btn-sm btn-info btn-float rounded-circle" aria-label="Invoice" title="terbitkan invoice tagihan" onclick="invoicebill(<?php echo $user['id_user']; ?>)"><i class="fa fa-tags"></i></button>
                                                        <?php } else { ?>
                                                            <button class="btn btn-sm btn-danger btn-float rounded-circle" aria-label="deactivate" title="deactivate" onclick="deactivate(<?php echo $user['id_user']; ?>)"><i class="fa fa-ban"></i></button>
                                                        <?php } ?>
                                                        <button class="btn btn-sm btn-warning btn-float rounded-circle" aria-label="get" title="edit" onclick="getData(<?php echo $user['id_user']; ?>)"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-sm btn-danger btn-float rounded-circle" aria-label="delete" title="Delete" onclick="deleteData(<?php echo $user['id_user']; ?>)"><i class="fa fa-trash"></i></button>
                                                        <button type="button" class="btn btn-sm btn-primary btn-float rounded-circle" aria-label="CETAK" title="Cetak Invoice" onclick="cetakInvoice(<?php echo $user['id_user']; ?>)"><i class="fa fa-file-pdf"></i></button>
                                                    <?php } ?>
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

        <div class="modal fade" id="updateAdmin" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" action="controller/api/post_manageadmin.php" method="POST">
                            <input type="hidden" name="purpose" value="update">
                            <input type="hidden" name="id_user" id="update_id_user" required>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="update_name" class="form-control" required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="update_email" class="form-control" required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="no_telp">No Telp</label>
                                <input type="text" name="no_telp" id="update_no_telp" maxlength="14" class="form-control" required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="update_alamat" cols="5" rows="5" class="form-control" required aria-required="true"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="name">Password</label>
                                <input type="password" name="password" id="update_password" class="form-control" required aria-required="true">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="activateClient" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Send Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" action="controller/api/post_manageadmin.php" method="POST">
                            <input type="hidden" name="purpose" value="activate">
                            <input type="hidden" name="id_user" id="update_id_activate" required>
                            <div class="form-group">
                                <label for="name_client">Name Client</label>
                                <input type="text" name="name_client" id="name_client" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="email_client">Email Client</label>
                                <input type="email" name="email_client" id="email_client" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="active_date">Active date</label>
                                <input type="text" name="active_date" id="active_date" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="count_date">Date Count</label>
                                <input type="text" name="count_date" id="count_date" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="harga_regis">Register Cost</label>
                                <input type="text" name="harga_regis" id="harga_regis" class="form-control" required aria-required="true">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save and Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lunas  -->
        <div class="modal fade" id="activateClientLunas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Send Invoice Paid Off</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" action="controller/api/post_manageadmin.php" method="POST">
                            <input type="hidden" name="purpose" value="activate_lunas">
                            <input type="hidden" name="id_user" id="update_id_activate_lunas" required>
                            <div class="form-group">
                                <label for="name_client">Name Client</label>
                                <input type="text" name="name_client" id="name_client_lunas" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="email_client">Email Client</label>
                                <input type="email" name="email_client" id="email_client_lunas" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="active_date">Active date</label>
                                <input type="text" name="active_date" id="active_date_lunas" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="count_date">Date Count</label>
                                <input type="text" name="count_date" id="count_date_lunas" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="harga_regis">Register Cost</label>
                                <input type="text" name="harga_regis" id="harga_regis_lunas" class="form-control" readonly required aria-required="true">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Activate and Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cetak Purpose  -->
        <div class="modal fade" id="activateClientInvoice" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Cetak Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" action="controller/api/post_manageadmin.php" method="POST">
                            <input type="hidden" name="purpose" value="cetak">
                            <input type="hidden" name="id_user" id="update_id_activate_invoice" required>
                            <div class="form-group">
                                <label for="name_client">Name Client</label>
                                <input type="text" name="name_client" id="name_client_invoice" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="email_client">Email Client</label>
                                <input type="email" name="email_client" id="email_client_invoice" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="active_date">Active date</label>
                                <input type="text" name="active_date" id="active_date_invoice" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="count_date">Date Count</label>
                                <input type="text" name="count_date" id="count_date_invoice" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="harga_regis">Register Cost</label>
                                <input type="text" name="harga_regis" id="harga_regis_invoice" class="form-control" readonly required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="pilih">Invoice Coice</label>
                                <br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="invoice" value="belum" class="custom-control-input" required>
                                    <label class="custom-control-label" for="customRadioInline1">Belum Lunas</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="invoice" value="lunas" class="custom-control-input" required>
                                    <label class="custom-control-label" for="customRadioInline2">Lunas</label>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>


</body>

</html>