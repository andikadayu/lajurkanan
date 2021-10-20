<?php

include '../../config.php';
include 'InvoiceMaker.php';
include 'senderEmail.php';

if ($_POST['purpose'] == 'update') {
    $id = $_POST['id_user'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $password = md5($_POST['password']);

    $sql = mysqli_query($conn, "UPDATE tb_user_old SET name='$name',email='$email',password='$password',alamat='$alamat',no_telp='$no_telp' WHERE id_user='$id'");

    if ($sql) {
        echo "<script>alert('success');location.href='../../client.php'</script>";
    } else {
        echo "<script>alert('failed');location.href='../../client.php'</script>";
    }
}

if ($_POST['purpose'] == 'activate') {
    $id = $_POST['id_user'];
    $harga_regis = $_POST['harga_regis'];
    $name_client = $_POST['name_client'];
    $active_date = $_POST['active_date'];
    $count_date = $_POST['count_date'];
    $email_client = $_POST['email_client'];
    $accesskey = "MKT-" . md5($id);

    $sql = mysqli_query($conn, "UPDATE tb_user_old SET accesskey='$accesskey',harga_regis='$harga_regis' WHERE id_user='$id'");
    if ($sql) {
        $sendEmail = new senderMail();
        $inm = new InvoiceMaker();
        $pdf = $inm->create_invoice("Berlangganan aplikasi baru SIMAKET", $id, $name_client, $active_date, $count_date, $harga_regis, "belum", 'email');
        $pdfv = $inm->create_invoice("Berlangganan aplikasi baru SIMAKET", $id, $name_client, $active_date, $count_date, $harga_regis, "belum", 'cetak');
        $hasil = $sendEmail->send_email($email_client, $pdf);
        if ($hasil['success'] == 1) {
            echo "<script>alert('" . $hasil['msg'] . "')</script>";
            return $pdfv;
        } else {
            echo "<script>alert('" . $hasil['msg'] . "');location.href='../../client.php'</script>";
        }
    } else {
        echo "<script>alert('failed');location.href='../../client.php'</script>";
    }
}

if ($_POST['purpose'] == 'activate_lunas') {
    $id = $_POST['id_user'];
    $harga_regis = $_POST['harga_regis'];
    $name_client = $_POST['name_client'];
    $active_date = $_POST['active_date'];
    $count_date = $_POST['count_date'];
    $email_client = $_POST['email_client'];

    $sql = mysqli_query($conn, "UPDATE tb_user_old SET is_active = 1 WHERE id_user = '$id'");
    if ($sql) {
        $sendEmail = new senderMail();
        $inm = new InvoiceMaker();
        $pdf = $inm->create_invoice("Berlangganan aplikasi baru SIMAKET", $id, $name_client, $active_date, $count_date, $harga_regis, "lunas", 'email');
        $pdfv = $inm->create_invoice("Berlangganan aplikasi baru SIMAKET", $id, $name_client, $active_date, $count_date, $harga_regis, "lunas", 'cetak');
        $hasil = $sendEmail->send_email($email_client, $pdf);
        if ($hasil['success'] == 1) {
            echo "<script>alert('" . $hasil['msg'] . "')</script>";
            return $pdfv;
        } else {
            echo "<script>alert('" . $hasil['msg'] . "');location.href='../../client.php'</script>";
        }
    } else {
        echo "<script>alert('failed');location.href='../../client.php'</script>";
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
    $pdf = $inm->create_invoice("Berlangganan aplikasi baru SIMAKET", $id, $name_client, $active_date, $count_date, $harga_regis, $lunas, 'cetak');
    return $pdf;
}


$conn->close();
