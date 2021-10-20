<?php

include '../../config.php';

if ($_GET['purpose'] == 'getData') {
    $id = $_GET['id'];
    $res = [];

    $sql = mysqli_query($conn, "SELECT * FROM tb_user_old WHERE id_user = '$id'");

    while ($s = mysqli_fetch_assoc($sql)) {
        $res[] = $s;
    }

    echo json_encode($res, JSON_PRETTY_PRINT);
}

if ($_GET['purpose'] == 'deleteData') {
    $id = $_GET['id'];

    $sql = mysqli_query($conn, "DELETE FROM tb_user_old WHERE id_user = '$id'");
    if ($sql) {
        echo 'success';
    } else {
        echo 'failed';
    }
}

if ($_GET['purpose'] == 'activateData') {
    $id = $_GET['id'];
    $accesskey = "MKT-" . md5($id);
    $sql = mysqli_query($conn, "UPDATE tb_user_old SET is_active = 1 WHERE id_user='$id'");
    $nsq = mysqli_query($conn, "UPDATE tb_user_old SET accesskey = '$accesskey' WHERE id_user = '$id'");
    if ($sql) {
        echo 'success';
    } else {
        echo 'failed';
    }
}

if ($_GET['purpose'] == 'deactivateData') {
    $id = $_GET['id'];

    $sql = mysqli_query($conn, "UPDATE tb_user_old SET is_active = 0 WHERE id_user='$id'");
    if ($sql) {
        echo 'success';
    } else {
        echo 'failed';
    }
}

if ($_GET['purpose'] == 'getbill') {
    $id = $_GET['id'];
    $response = [];
    $sql = mysqli_query($conn, "SELECT name,active_from,active_until,harga_regis,email FROM tb_user_old WHERE id_user='$id'");
    while ($d = mysqli_fetch_assoc($sql)) {
        $datefrom = new DateTime($d['active_from']);
        $dateuntil = new DateTime($d['active_until']);
        $subs = $datefrom->diff($dateuntil);

        $response['name'] = $d['name'];
        $response['active_date'] = $d['active_from'] . " s/d " . $d['active_until'];
        $response['count_date'] = $subs->days;
        $response['harga_regis'] = $d['harga_regis'];
        $response['email'] = $d['email'];
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}

if ($_GET['purpose'] == 'getbillsub') {
    $id = $_GET['id'];
    $response = [];
    $sql = mysqli_query($conn, "SELECT name,request_from,request_until,harga_subscribe,email FROM tb_manage as subscribe INNER JOIN tb_user_old as users ON users.id_user = subscribe.id_user WHERE subscribe.id_subscribe='$id'");
    while ($d = mysqli_fetch_assoc($sql)) {
        $datefrom = new DateTime($d['request_from']);
        $dateuntil = new DateTime($d['request_until']);
        $subs = $datefrom->diff($dateuntil);

        $response['name'] = $d['name'];
        $response['active_date'] = $d['request_from'] . " s/d " . $d['request_until'];
        $response['count_date'] = $subs->days;
        $response['harga_regis'] = $d['harga_subscribe'];
        $response['email'] = $d['email'];
        $response['active_from'] = $d['request_from'];
        $response['active_until'] = $d['request_until'];
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}

$conn->close();
