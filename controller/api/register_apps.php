<?php
include '../../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

    $name = $_POST['name'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $active_from = $_POST['active_from'];
    $active_until = $_POST['active_until'];
    $role = 'client';
    $harga_regis = 0;
    $sql = mysqli_query($conn, "INSERT INTO tb_user_old VALUES(NULL,'$name','$no_telp','$alamat','$email','$password','$role',0,NULL,NULL,'$active_from','$active_until','$harga_regis')");
    if ($sql) {
        $response['status'] = 'OK';
        $response['msg'] = "Register Successfull";
    } else {
        $response['status'] = 'ERROR';
        $response['msg'] = 'Register ERROR';
    }
    $conn->close();
    echo json_encode($response, JSON_PRETTY_PRINT);
}
