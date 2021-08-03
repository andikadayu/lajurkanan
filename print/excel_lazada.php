<?php
include '../config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



$id_scrap = $_POST['id_scrap'];
$nama_file = $_POST['nama_file'];

$imgd = "Masukkan alamat website (link) foto produk
                Untuk upload:
                1. Upload ke https://imgur.com/upload
    
                Untuk dapatkan URL Gambar:
                1. Di Google Chrome, klik kanan pada gambar
                2. Klik 'Open Link in a New Tab'
                3. Copy link untuk kemudian dimasukan pada kolom ini";
$vidurl = "Tambahkan video untuk menjelaskan spesifikasi dan cara menggunakan produk yang kamu jual.
                Hanya boleh URL dari Youtube";



$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
//header space 1
$sheet->setCellValue('A2', 'Error Message');
$sheet->setCellValue('B2', 'Nama Produk*');
$sheet->setCellValue('C2', 'Deskripsi Produk');
$sheet->setCellValue('D2', 'Kategori Kode*');
$sheet->setCellValue('E2', 'Berat* (Gram)');
$sheet->setCellValue('F2', 'Minimum Pemesanan*');
$sheet->setCellValue('G2', 'Nomor Etalase');
$sheet->setCellValue('H2', 'Waktu Proses Preorder');
$sheet->setCellValue('I2', 'Kondisi*');
$sheet->setCellValue('J2', 'Gambar 1*');
$sheet->setCellValue('K2', 'Gambar 2');
$sheet->setCellValue('L2', 'Gambar 3');
$sheet->setCellValue('M2', 'Gambar 4');
$sheet->setCellValue('N2', 'Gambar 5');
$sheet->setCellValue('O2', 'URL Video Produk 1');
$sheet->setCellValue('P2', 'URL Video Produk 2');
$sheet->setCellValue('Q2', 'URL Video Produk 3');
$sheet->setCellValue('R2', 'SKU Name');
$sheet->setCellValue('S2', 'Status*');
$sheet->setCellValue('T2', 'Jumlah Stok*');
$sheet->setCellValue('U2', 'Harga (Rp)*');
$sheet->setCellValue('V2', 'Asuransi Pengiriman');
//line 2 for description
$sheet->setCellValue('A3', 'Abaikan kolom ini. Kolom ini akan berisi pesan kesalahan jika ada setelah kamu melakukan proses upload');
$sheet->setCellValue('B3', "Masukkan nama produk (maks. 70 karakter).\n Catatan: Nama produk hanya bisa diubah jika produk ini belum terjual.\nNama harus unik untuk setiap produk.\n Untuk produk dengan varian, nama produk harus diisi sama untuk semua varian.");
$sheet->setCellValue('C3', 'Masukkan deskripsi produk dengan lengkap dan jelas (maks. 2000 karakter).');
$sheet->setCellValue('D3', 'Pilih kategori kode dari daftar kategori.');
$sheet->setCellValue('E3', 'Masukan berat produk dengan angka tanpa menggunakan koma dan titik.');
$sheet->setCellValue('F3', 'Tentukan jumlah minimum pemesanan Jika tidak diisi atau mengandung sesuatu di luar 1 hingga 9999 maka otomatis 1');
$sheet->setCellValue('G3', '(Opsional) Kelompokan produk dalam Etalase agar mudahkan pembeli mencari produkmu.Dapatkan kode etalase dari sheet Daftar Etalase dan masukkan salah satu kode etalase toko pilihanmu.Jika tidak diisi, maka produk akan otomatis masuk ke dalam etalase draft.');
$sheet->setCellValue('H3', "(Opsional) Masukkan jumlah hari PreOrder.\nJika kamu mengaktifkan fitur PreOrder, kamu harus menulis jumlah hari proses PreOrder antara 3 hingga 90 hari.\nJika kolom tidak diisi atau mengandung sesuatu di luar 3 hingga 90 maka otomatis 'Tidak' ada PreOrder");
$sheet->setCellValue('I3', "Pilih salah satu kondisi produk: Baru atau Bekas \n Jika kolom tidak diisi atau mengandung sesuatu di luar baru atau bekas maka otomatis baru");
$sheet->setCellValue('J3', $imgd);
$sheet->setCellValue('K3', $imgd);
$sheet->setCellValue('L3', $imgd);
$sheet->setCellValue('M3', $imgd);
$sheet->setCellValue('N3', $imgd);
$sheet->setCellValue('O3', $vidurl);
$sheet->setCellValue('P3', $vidurl);
$sheet->setCellValue('Q3', $vidurl);
$sheet->setCellValue('R3', '(Opsional) Masukkan SKU maks. 50 karakter. SKU bisa diubah jika produk ini belum terjual.');
$sheet->setCellValue('S3', 'Pilih status produk: Aktif atau Nonaktif.Jika kolom tidak diisi atau mengandung sesuatu di luar aktif atau nonaktif maka otomatis aktif');
$sheet->setCellValue('T3', "Isi jumlah stok yang tersedia dalam format angka tanpa menggunakan koma dan titik.\nStok akan berkurang ketika pembayaran dari pembeli telah diverifikasi.\nJumlah stok tidak ditampilkan kepada pembeli.\nJika kolom tidak diisi atau mengandung sesuatu di luar 1 hingga 999999 maka otomatis 1");
$sheet->setCellValue('U3', 'Masukkan harga produk. Harga dalam rupiah tanpa menggunakan koma dan titik. Harga harus min 100');
$sheet->setCellValue('V3', "Aktifkan jaminan kerugian kerusakan & kehilangan atas pengiriman produk ini.\n Pilih: ya atau opsional.Jika kolom tidak diisi atau mengandung sesuatu di luar ya atau opsional maka otomatis ya");


$i = 4;

$st_re = explode(",", $_POST['hapus_kata']); // pemisah kata

$preorder = "Tidak";
$gam = "";
$items = array();
$vid = "";
$itemss = array();

if ($_POST['preorder'] == '0') {
    $preorder = "Tidak";
} else {
    $preorder = $_POST['preorder'];
}

$harga = 0;
$tambah = 0;
//Content XLSX
$sql = mysqli_query($conn, "SELECT * FROM `tb_lazada` WHERE id_scrape = '$id_scrap'");
while ($rs = mysqli_fetch_assoc($sql)) {
    //Penghapus Kata
    $row = str_replace($st_re, " ", $rs);
    //Penghitung Rumus
    if ($_POST['markups'] == 'metode') {
        if ($_POST['metode_markup'] == '%') {
            $tambah = $row['harga'] * $_POST['nilai_markup'] / 100;
            $harga = $row['harga'] + $tambah;
        } else {
            $harga = $row['harga'] + $_POST['nilai_markup'];
        }
    }

    //Random URL
    if ($row['gambar1'] != "") {
        $items = json_decode($row['gambar1'], true);
        $gam =  $items[array_rand($items)];
    } else {
        $gam = "";
    }
    if ($row['video1'] != "") {
        $itemss = json_decode($row['video1'], true);
        $vid =  $itemss[array_rand($itemss)];
    } else {
        $vid = "";
    }

    $sheet->setCellValue(
        'A' . $i,
        mysqli_error($conn)
    );
    $sheet->setCellValue(
        'B' . $i,
        $_POST['nama_awal'] . " " . $row['nama_produk'] . " " . $_POST['nama_akhir']
    );
    $sheet->setCellValue(
        'C' . $i,
        $_POST['deskripsi_awal'] . " " . $row['deskripsi'] . " " . $_POST['deskripsi_akhir']
    );
    $sheet->setCellValue(
        'D' . $i,
        $_POST['kategori']
    );
    $sheet->setCellValue(
        'E' . $i,
        $_POST['berat']
    );
    $sheet->setCellValue(
        'F' . $i,
        $_POST['min_pesan']
    );
    $sheet->setCellValue(
        'G' . $i,
        $_POST['etalase']
    );
    $sheet->setCellValue(
        'H' . $i,
        $preorder
    );
    $sheet->setCellValue(
        'I' . $i,
        $row['kondisi']
    );
    $sheet->setCellValue(
        'J' . $i,
        $gam
    );
    $sheet->setCellValue(
        'K' . $i,
        $gam
    );
    $sheet->setCellValue(
        'L' . $i,
        $gam
    );
    $sheet->setCellValue(
        'M' . $i,
        $gam
    );
    $sheet->setCellValue(
        'N' . $i,
        $gam
    );
    $sheet->setCellValue(
        'O' . $i,
        $vid
    );
    $sheet->setCellValue(
        'P' . $i,
        $vid
    );
    $sheet->setCellValue(
        'Q' . $i,
        $vid
    );
    $sheet->setCellValue(
        'R' . $i,
        $row['sku_name']
    );
    $sheet->setCellValue(
        'S' . $i,
        $row['status']
    );
    $sheet->setCellValue(
        'T' . $i,
        $_POST['stok']
    );
    $sheet->setCellValue(
        'U' . $i,
        $harga
    );
    $sheet->setCellValue(
        'V' . $i,
        $row['asuransi']
    );
    $i++;
}




//Print Excel
$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(40, 'px');
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . urlencode($nama_file) . '.xlsx"');
$writer->save('php://output');
