<?php
include '../config.php';

if ($_GET['shop'] == 'lazada') {
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "DELETE FROM tb_lazada WHERE id_scrape='$id'");
    $sql1 = mysqli_query($conn, "DELETE FROM tb_scrap WHERE id_scrap='$id'");
    if ($sql && $sql1) {
        echo "success";
    } else {
        echo "failed";
    }
}

if ($_GET['shop'] == 'shopee') {
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "DELETE FROM tb_shopee WHERE id_scrape='$id'");
    $sql1 = mysqli_query($conn, "DELETE FROM tb_scrap WHERE id_scrap='$id'");
    if ($sql && $sql1) {
        echo "success";
    } else {
        echo "failed";
    }
}

$conn->close();
