<?php
include '../config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$no_telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];
$password = md5($_POST['password']);


$sql = mysqli_query($conn, "INSERT INTO tb_user VALUES(NULL,'$name','$no_telp','$alamat','$email','$password','user',0,NULL,NULL)");

if ($sql) {
    echo "<script>alert('Register Successfull, wait for approval');location.href = '../index.php';</script>";
} else {
    echo "<script>alert('Error Register');location.href = '../register.php';</script>";
}

$conn->close();
