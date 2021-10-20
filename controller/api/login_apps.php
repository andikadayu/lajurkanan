<?php
include '../../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $date = date('Y-m-d');

    $response = [];

    // $sql = mysqli_query($conn, "SELECT id_user,name,email,no_telp,alamat FROM tb_user WHERE email='$email' AND password='$password' AND is_active=1 AND active_from <= '$date' AND active_until >= '$date'");
    $sql = mysqli_query($conn, "SELECT id_user,name,email,no_telp,alamat FROM tb_user_old WHERE email='$email' AND password='$password' AND is_active=1 AND active_from <= '$date'");

    if (mysqli_num_rows($sql) > 0) {
        while ($user = mysqli_fetch_assoc($sql)) {
            $response['status'] = 'OK';
            $response['name'] = $user['name'];
            $response['email']  = $user['email'];
            $response['no_telp'] = $user['no_telp'];
            $response['alamat'] = $user['alamat'];
        }
    } else {
        $response['status'] = 'ERROR';
        $response['name'] = 'ERROR';
        $response['email']  = 'ERROR';
    }

    $conn->close();
    echo json_encode($response, JSON_PRETTY_PRINT);
}
