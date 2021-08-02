<?php

include '../config.php';

if ($_POST['purpose'] == 'update') {
    $id = $_POST['id_user'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $password = md5($_POST['password']);

    $sql = mysqli_query($conn, "UPDATE tb_user SET name='$name',email='$email',password='$password',alamat='$alamat',no_telp='$no_telp' WHERE id_user='$id'");

    if ($sql) {
        echo "<script>alert('success');location.href='../manage_admin.php'</script>";
    } else {
        echo "<script>alert('failed');location.href='../manage_admin.php'</script>";
    }
}


$conn->close();
