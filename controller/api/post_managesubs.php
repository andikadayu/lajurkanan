<?php
include '../../config.php';
include 'InvoiceMaker.php';
include 'senderEmail.php';

if ($_POST['purpose'] == 'activate') {
    $id = $_POST['id_subscribe'];
    $harga_subscribe = $_POST['harga_subscribe'];
    $name_client = $_POST['name_client'];
    $active_date = $_POST['active_date'];
    $count_date = $_POST['count_date'];
    $email_client = $_POST['email_client'];

    $sql = mysqli_query($conn, "UPDATE tb_manage SET harga_subscribe='$harga_subscribe' WHERE id_subscribe='$id'");
    if ($sql) {
        $sendEmail = new senderMail();
        $inm = new InvoiceMaker();
        $pdf = $inm->create_invoice("Perpanjangan Aplikasi SIMAKET", $id, $name_client, $active_date, $count_date, $harga_subscribe, "belum", 'email');
        $pdfv = $inm->create_invoice("Perpanjangan Aplikasi SIMAKET", $id, $name_client, $active_date, $count_date, $harga_subscribe, "belum", 'cetak');
        $hasil = $sendEmail->send_email($email_client, $pdf);
        if ($hasil['success'] == 1) {
            echo "<script>alert('" . $hasil['msg'] . "');</script>";
            return $pdfv;
        } else {
            echo "<script>alert('" . $hasil['msg'] . "');location.href='../../subs.php'</script>";
        }
    } else {
        echo "<script>alert('failed');location.href='../../subs.php'</script>";
    }
}

if ($_POST['purpose'] == 'activate_lunas') {
    $id = $_POST['id_subscribe'];
    $harga_subscribe = $_POST['harga_subscribe'];
    $name_client = $_POST['name_client'];
    $active_date = $_POST['active_date'];
    $count_date = $_POST['count_date'];
    $email_client = $_POST['email_client'];
    $active_from = $_POST['active_from'];
    $active_until = $_POST['active_until'];


    $ids = 0;

    $sqls = mysqli_query($conn, "SELECT id_user FROM tb_manage WHERE id_subscribe = '$id'");
    while ($is = mysqli_fetch_assoc($sqls)) {
        $ids = $is['id_user'];
    }

    if ($ids != 0) {
        $sqln = mysqli_query($conn, "UPDATE tb_user_old SET active_from = '$active_from',active_until = '$active_until' WHERE id_user='$ids'");
        if ($sqln) {
            $sql = mysqli_query($conn, "UPDATE tb_manage SET status = 1 WHERE id_subscribe = '$id'");
            if ($sql) {
                $sendEmail = new senderMail();
                $inm = new InvoiceMaker();
                $pdf = $inm->create_invoice("Perpanjangan Aplikasi SIMAKET", $id, $name_client, $active_date, $count_date, $harga_subscribe, "lunas", 'email');
                $pdfv = $inm->create_invoice("Perpanjangan Aplikasi SIMAKET", $id, $name_client, $active_date, $count_date, $harga_subscribe, "lunas", 'cetak');
                $hasil = $sendEmail->send_email($email_client, $pdf);
                if ($hasil['success'] == 1) {
                    echo "<script>alert('" . $hasil['msg'] . "');'</script>";
                    return $pdfv;
                } else {
                    echo "<script>alert('" . $hasil['msg'] . "');location.href='../../subs.php'</script>";
                }
            } else {
                echo "<script>alert('failed');location.href='../../subs.php'</script>";
            }
        } else {
            echo "<script>alert('failed');location.href='../../subs.php'</script>";
        }
    } else {
        echo "<script>alert('failed');location.href='../../subs.php'</script>";
    }
}

if ($_POST['purpose'] == 'cetak') {
    $id = $_POST['id_user'];
    $harga_regis = $_POST['harga_regis'];
    $name_client = $_POST['name_client'];
    $active_date = $_POST['active_date'];
    $count_date = $_POST['count_date'];
    $email_client = $_POST['email_client'];
    $lunas = $_POST['invoice'];

    $inm = new InvoiceMaker();
    $pdf = $inm->create_invoice("Perpanjangan Aplikasi SIMAKET", $id, $name_client, $active_date, $count_date, $harga_regis, $lunas, 'cetak');
    return $pdf;
}


$conn->close();
