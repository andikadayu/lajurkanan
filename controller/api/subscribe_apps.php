<?php
include '../../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $active_from = $_POST['active_from'];
    $active_until = $_POST['active_until'];

    $check = mysqli_query($conn, "SELECT id_user FROM tb_user_old WHERE email = '$email' AND password='$password'");

    $ids = 0;

    if (mysqli_num_rows($check) > 0) {
        while ($d = mysqli_fetch_assoc($check)) {
            $ids = $d['id_user'];
        }

        $sqlnew  = mysqli_query($conn, "INSERT INTO tb_manage VALUES(NULL,'$ids','$active_from','$active_until',0,0)");
        if ($sqlnew) {
            $response['status'] = 'OK';
            $response['msg'] = 'Add Subscription Successfull';
        } else {
            $response['status'] = 'ERROR';
            $response['msg'] = 'Subscribe ERROR';
        }
    } else {
        $response['status'] = 'ERROR';
        $response['msg'] = 'User Not Found';
    }

    $conn->close();
    echo json_encode($response, JSON_PRETTY_PRINT);
}
