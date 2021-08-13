<?php
include '../config.php';
include 'ExcelCreate.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$id_scrap = $_POST['id_scrap'];
$nama_file = $_POST['nama_file'];

$rumus = "";
if (!empty($_POST['rumus'])) {
    $rumus = $_POST['rumus'];
}

$spreadsheet;
$sheet;

$sql = mysqli_query($conn, "SELECT * FROM `tb_lazada` WHERE id_scrape = '$id_scrap'");
$counts = mysqli_num_rows($sql);
for ($f = 0; $f < $counts; $f++) {
    if ($f % 300 == 1) {
        $sq = mysqli_query($conn, "SELECT * FROM `tb_lazada` WHERE id_scrape = '$id_scrap' LIMIT 300 OFFSET " . $f);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $excel = new ExcelCreate($sheet, $spreadsheet);

        $excel->create_excel(
            $conn,
            $sq,
            $nama_file,
            $_POST['hapus_kata'],
            $_POST['preorder'],
            $_POST['stok'],
            $_POST['markups'],
            $_POST['metode_markup'],
            $_POST['nilai_markup'],
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
