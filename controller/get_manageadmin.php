<?php

include '../config.php';

if ($_GET['purpose'] == 'getData') {
    $id = $_GET['id'];
    $res = [];

    $sql = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = '$id'");

    while ($s = mysqli_fetch_assoc($sql)) {
        $res[] = $s;
    }

    echo json_encode($res, JSON_PRETTY_PRINT);
}

if ($_GET['purpose'] == 'deleteData') {
    $id = $_GET['id'];

    $sql = mysqli_query($conn, "DELETE FROM tb_user WHERE id_user = '$id'");
    if ($sql) {
        echo 'success';
    } else {
        echo 'failed';
    }
}

if ($_GET['purpose'] == 'activateData') {
    $id = $_GET['id'];
    $accesskey = "LKO-" . md5($id);
    $sql = mysqli_query($conn, "UPDATE tb_user SET is_active = 1 WHERE id_user='$id'");
    $nsq = mysqli_query($conn, "UPDATE tb_user SET accesskey = '$accesskey' WHERE id_user = '$id'");
    if ($sql) {
        echo 'success';
    } else {
        echo 'failed';
    }
}

if ($_GET['purpose'] == 'deactivateData') {
    $id = $_GET['id'];

    $sql = mysqli_query($conn, "UPDATE tb_user SET is_active = 0 WHERE id_user='$id'");
    if ($sql) {
        echo 'success';
    } else {
        echo 'failed';
    }
}

$conn->close();
