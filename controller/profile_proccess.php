<?php
include '../config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$no_telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];
$password = md5($_POST['password']);

$sql = mysqli_query($conn, "UPDATE tb_user SET name='$name',no_telp='$no_telp',alamat='$alamat',password='$password' WHERE email='$email'");
if ($sql) {
    echo "<script> alert('Update Profile Success, Please login again');location.href='logout.php' </script>";
} else {
    echo "<script> alert('Failed');location.href='../profile.php' </script>";
}

$conn->close();
