<?php
include '../config.php';

$response = [];

$email = $_POST['email'];
$password = md5($_POST['password']);

$sql = mysqli_query($conn, "SELECT id_user,name,email,role,no_telp FROM tb_user WHERE email='$email' AND password='$password' AND is_active=1");

if (mysqli_num_rows($sql) > 0) {
    while ($user = mysqli_fetch_assoc($sql)) {
        $response['status'] = "OK";
        $response['email'] = $user['email'];
        $response['name'] = $user['name'];
    }
} else {
    $response['status'] = "ERROR";
    $response['email'] = "ERROR";
    $response['name'] = "ERROR";
}

echo json_encode($response, JSON_PRETTY_PRINT);
