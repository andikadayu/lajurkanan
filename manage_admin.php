<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Management User Register">
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

<body class="d-flex flex-column min-vh-100">
    <?php require_once 'component/navbar.php'; ?>

    <!-- content -->
    <div class="container-fluid">
        <div class="row" style="margin-top: 25px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Management Admin</div>
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
                                            <th style="width: 5%;">Role</th>
                                            <th style="width: 15%;">Alamat</th>
                                            <th style="width: 4%;">Status</th>
                                            <th style="width: 9%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $sql = mysqli_query($conn, "SELECT id_user,name,email,role,is_active,no_telp,alamat FROM tb_user");
                                        $no = 1;
                                        while ($user = mysqli_fetch_assoc($sql)) { ?>

                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $user['name']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td><?php echo $user['no_telp']; ?></td>
                                                <td><?php echo $user['role']; ?></td>
                                                <td><?php echo $user['alamat']; ?></td>
                                                <td><?php if ($user['is_active'] == 0) {
                                                        echo "<span class='badge bg-danger'>Inacive</span>";
                                                    } else {
                                                        echo "<span class='badge bg-success'>Active</span>";
                                                    }  ?></td>
                                                <td>
                                                    <?php if ($user['role'] == 'superadmin') { ?>
                                                        <button class="btn btn-sm btn-warning btn-float rounded-circle" aria-label="get" onclick="getData(<?php echo $user['id_user']; ?>)"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-sm btn-danger btn-float rounded-circle" aria-label="delete" onclick="deleteData(<?php echo $user['id_user']; ?>)"><i class="fa fa-trash"></i></button>
                                                    <?php } else { ?>
                                                        <?php if ($user['is_active'] != 1) { ?>
                                                            <button class="btn btn-sm btn-success btn-float rounded-circle" aria-label="activate" onclick="activate(<?php echo $user['id_user']; ?>)"><i class="fa fa-check"></i></button>
                                                        <?php } ?>
                                                        <button class="btn btn-sm btn-danger btn-float rounded-circle" aria-label="deactivate" onclick="deactivate(<?php echo $user['id_user']; ?>)"><i class="fa fa-ban"></i></button>
                                                        <button class="btn btn-sm btn-warning btn-float rounded-circle" aria-label="get" onclick="getData(<?php echo $user['id_user']; ?>)"><i class="fa fa-edit"></i></button>
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

        <!-- Modal Update -->
        <div class="modal fade" id="updateAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" action="controller/post_manageadmin.php" method="POST">
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
    </div>
    <?php include 'component/footer.php'; ?>
    <script src="assets/js/manage_admin.min.js"></script>
</body>

</html>