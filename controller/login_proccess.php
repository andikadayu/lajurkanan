<?php

include '../config.php';

$email = $_POST['email'];
$password = md5($_POST['password']);
session_start();


$sql = mysqli_query($conn, "SELECT id_user,name,email,role,no_telp FROM tb_user WHERE email='$email' AND password='$password' AND is_active=1");

if (mysqli_num_rows($sql) > 0) {
    while ($user = mysqli_fetch_assoc($sql)) {
        $_SESSION['isLogin'] = true;
        $_SESSION['name'] = $user['name'];
        $_SESSION['email']  = $user['email'];
        $_SESSION['role']  = $user['role'];
        $_SESSION['no_telp']  = $user['no_telp'];
        $_SESSION['id_user'] = $user['id_user'];

        echo "<script> alert('Login Success');location.href='../scrap.php' </script>";
    }
} else {
    echo "<script> alert('email or password invalid or user inactive');location.href='../index.php' </script>";
}

$conn->close();
