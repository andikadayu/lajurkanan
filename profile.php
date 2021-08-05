<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lajur Kanan Official</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/datatable/DataTables-1.10.25/css/dataTables.bootstrap5.min.css">
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
            <div class="d-flex justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Profile</div>
                        </div>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = '" . $_SESSION['id_user'] . "'");
                        while ($data = mysqli_fetch_assoc($sql)) {
                        ?>
                            <form action="controller/profile_proccess.php" method="POST">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Name</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" name="name" value="<?php echo $data['name']; ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-3">
                                            <label for="">Email</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="email" name="email" value="<?php echo $data['email']; ?>" class="form-control" readonly required>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-3">
                                            <label for="">No Telp</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="number" name="no_telp" value="<?php echo $data['no_telp']; ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-3">
                                            <label for="">Alamat</label>
                                        </div>
                                        <div class="col-9">
                                            <textarea name="alamat" id="alamat" cols="3" rows="3" class="form-control" required><?php echo $data['alamat']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-3">
                                            <label for="">Password</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <small>*Retype your password if you don't want to change</small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <input type="submit" class="btn btn-success" value="Update">
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>

    </script>
</body>

</html>