<?php
include '../config.php';
include 'ExcelCreate.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$id_scrap = $_POST['id_scrap'];
$nama_file = $_POST['nama_file'];

$rumus = "";
if (!empty($_POST['rumus'])) {
    $rumus = $_POST['rumus'];
}
$metode = "";
$nilai = "";
if (!empty($_POST['metode_markup']) && !empty($_POST['nilai_markup'])) {
    $metode = $_POST['metode_markup'];
    $nilai = $_POST['nilai_markup'];
}

$markups_perhar = "";
if (!empty($_POST['markups_perhar'])) {
    $markups_perhar = $_POST['markups_perhar'];
}
$markups_rumus = "";
if (!empty($_POST['markups_rumus'])) {
    $markups_rumus = $_POST['markups_rumus'];
}

$dates = date_create(date('2007-09-16 07:00:00'));
$date = date_timestamp_get($dates);

$min_harga = $_POST['min_harga'];

$spreadsheet;
$sheet;

$sql = mysqli_query($conn, "SELECT * FROM `tb_lazada` WHERE id_scrape = '$id_scrap' AND harga >= " . $min_harga . "");
$counts = mysqli_num_rows($sql);
for ($f = 0; $f < $counts; $f++) {
    if ($f % 299 == 0) { //limit 299
        $sq = mysqli_query($conn, "SELECT * FROM `tb_lazada` WHERE id_scrape = '$id_scrap' AND harga >= " . $min_harga . " LIMIT 299 OFFSET " . $f); //limit 299

        $reader = new Xlsx();
        $spreadsheet = $reader->load('sample.xlsx');
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setTitle("")
            ->setCreator("xuri")
            ->setCreated($date);

        $excel = new ExcelCreate($sheet, $spreadsheet);

        $excel->create_excel(
            $conn,
            $sq,
            $nama_file,
            $_POST['hapus_kata'],
            $_POST['preorder'],
            $_POST['stok'],
            $markups_perhar,
            $markups_rumus,
            $metode,
            $nilai,
            $rumus,
            $_POST['nama_awal'],
            $_POST['nama_akhir'],
            $_POST['deskripsi_awal'],
            $_POST['deskripsi_akhir'],
            $_POST['kategori'],
            $_POST['berat'],
            $_POST['min_pesan'],
            $_POST['etalase'],
            $f,
            "lazada"
        );
    }

    if ($f == $counts - 1) {

        $zip = new ZipArchive();
        $zip->open(__DIR__ . '/' . $nama_file . '.zip', ZIPARCHIVE::CREATE);
        $zip->addGlob($nama_file . '-*.xlsx');
        $zip->close();

        $file = $nama_file . '.zip';
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        header('Content-type: application/zip'); // Please check this, i just guessed
        header("Content-Transfer-Encoding: Binary");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));

        readfile($file);

        unlink($file);
        foreach (glob("$nama_file-*.xlsx") as $filename) {
            unlink($filename);
        }
    }
}
