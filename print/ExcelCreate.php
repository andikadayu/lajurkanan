<?php

include '../config.php';
include 'RumusHarga.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelCreate
{
    public $sheet;
    public $spreadsheet;

    public $imgd = "Masukkan alamat website (link) foto produk
                Untuk upload:
                1. Upload ke https://imgur.com/upload
    
                Untuk dapatkan URL Gambar:
                1. Di Google Chrome, klik kanan pada gambar
                2. Klik 'Open Link in a New Tab'
                3. Copy link untuk kemudian dimasukan pada kolom ini";
    public $vidurl = "Tambahkan video untuk menjelaskan spesifikasi dan cara menggunakan produk yang kamu jual.
                Hanya boleh URL dari Youtube";

    public function __construct($sheet, Spreadsheet $spreadsheet)
    {
        $this->sheet = $sheet;
        $this->spreadsheet = $spreadsheet;
    }

    public function create_header()
    {
        $this->sheet->setCellValue('A2', 'Error Message');
        $this->sheet->setCellValue('B2', 'Nama Produk*');
        $this->sheet->setCellValue('C2', 'Deskripsi Produk');
        $this->sheet->setCellValue('D2', 'Kategori Kode*');
        $this->sheet->setCellValue('E2', 'Berat* (Gram)');
        $this->sheet->setCellValue('F2', 'Minimum Pemesanan*');
        $this->sheet->setCellValue('G2', 'Nomor Etalase');
        $this->sheet->setCellValue('H2', 'Waktu Proses Preorder');
        $this->sheet->setCellValue('I2', 'Kondisi*');
        $this->sheet->setCellValue('J2', 'Gambar 1*');
        $this->sheet->setCellValue('K2', 'Gambar 2');
        $this->sheet->setCellValue('L2', 'Gambar 3');
        $this->sheet->setCellValue('M2', 'Gambar 4');
        $this->sheet->setCellValue('N2', 'Gambar 5');
        $this->sheet->setCellValue('O2', 'URL Video Produk 1');
        $this->sheet->setCellValue('P2', 'URL Video Produk 2');
        $this->sheet->setCellValue('Q2', 'URL Video Produk 3');
        $this->sheet->setCellValue('R2', 'SKU Name');
        $this->sheet->setCellValue('S2', 'Status*');
        $this->sheet->setCellValue('T2', 'Jumlah Stok*');
        $this->sheet->setCellValue('U2', 'Harga (Rp)*');
        $this->sheet->setCellValue('V2', 'Asuransi Pengiriman');
        //line 2 for description
        $this->sheet->setCellValue('A3', 'Abaikan kolom ini. Kolom ini akan berisi pesan kesalahan jika ada setelah kamu melakukan proses upload');
        $this->sheet->setCellValue('B3', "Masukkan nama produk (maks. 70 karakter).\n Catatan: Nama produk hanya bisa diubah jika produk ini belum terjual.\nNama harus unik untuk setiap produk.\n Untuk produk dengan varian, nama produk harus diisi sama untuk semua varian.");
        $this->sheet->setCellValue('C3', 'Masukkan deskripsi produk dengan lengkap dan jelas (maks. 2000 karakter).');
        $this->sheet->setCellValue('D3', 'Pilih kategori kode dari daftar kategori.');
        $this->sheet->setCellValue('E3', 'Masukan berat produk dengan angka tanpa menggunakan koma dan titik.');
        $this->sheet->setCellValue('F3', 'Tentukan jumlah minimum pemesanan Jika tidak diisi atau mengandung sesuatu di luar 1 hingga 9999 maka otomatis 1');
        $this->sheet->setCellValue('G3', '(Opsional) Kelompokan produk dalam Etalase agar mudahkan pembeli mencari produkmu.Dapatkan kode etalase dari sheet Daftar Etalase dan masukkan salah satu kode etalase toko pilihanmu.Jika tidak diisi, maka produk akan otomatis masuk ke dalam etalase draft.');
        $this->sheet->setCellValue('H3', "(Opsional) Masukkan jumlah hari PreOrder.\nJika kamu mengaktifkan fitur PreOrder, kamu harus menulis jumlah hari proses PreOrder antara 3 hingga 90 hari.\nJika kolom tidak diisi atau mengandung sesuatu di luar 3 hingga 90 maka otomatis 'Tidak' ada PreOrder");
        $this->sheet->setCellValue('I3', "Pilih salah satu kondisi produk: Baru atau Bekas \n Jika kolom tidak diisi atau mengandung sesuatu di luar baru atau bekas maka otomatis baru");
        $this->sheet->setCellValue('J3', $this->imgd);
        $this->sheet->setCellValue('K3', $this->imgd);
        $this->sheet->setCellValue('L3', $this->imgd);
        $this->sheet->setCellValue('M3', $this->imgd);
        $this->sheet->setCellValue('N3', $this->imgd);
        $this->sheet->setCellValue('O3', $this->vidurl);
        $this->sheet->setCellValue('P3', $this->vidurl);
        $this->sheet->setCellValue('Q3', $this->vidurl);
        $this->sheet->setCellValue('R3', '(Opsional) Masukkan SKU maks. 50 karakter. SKU bisa diubah jika produk ini belum terjual.');
        $this->sheet->setCellValue('S3', 'Pilih status produk: Aktif atau Nonaktif.Jika kolom tidak diisi atau mengandung sesuatu di luar aktif atau nonaktif maka otomatis aktif');
        $this->sheet->setCellValue('T3', "Isi jumlah stok yang tersedia dalam format angka tanpa menggunakan koma dan titik.\nStok akan berkurang ketika pembayaran dari pembeli telah diverifikasi.\nJumlah stok tidak ditampilkan kepada pembeli.\nJika kolom tidak diisi atau mengandung sesuatu di luar 1 hingga 999999 maka otomatis 1");
        $this->sheet->setCellValue('U3', 'Masukkan harga produk. Harga dalam rupiah tanpa menggunakan koma dan titik. Harga harus min 100');
        $this->sheet->setCellValue('V3', "Aktifkan jaminan kerugian kerusakan & kehilangan atas pengiriman produk ini.\n Pilih: ya atau opsional.Jika kolom tidak diisi atau mengandung sesuatu di luar ya atau opsional maka otomatis ya");
    }

    public function create_excel($conn, $sq, $nama_file, $hapus_kata, $preorders, $stok, $markups, $metode_markup, $nilai_markup, $rumus, $nama_awal, $nama_akhir, $deskripsi_awal, $deskripsi_akhir, $kategori, $berat, $min_pesan, $etalase, $f, $shop)
    {
        // call header 
        $this->create_header();

        $rumusHarga = new RumusHarga();

        // create row
        $i = 5;

        $st_re = explode(",", $hapus_kata); // pemisah kata

        $preorder = "Tidak";
        $gam = "";
        $items = array();
        $vid = "";
        $itemss = array();
        $nog = 0;

        if ($preorders == '0') {
            $preorder = "Tidak";
        } else {
            $preorder = $preorders;
        }

        $harga = 0;
        $tambah = 0;
        //Content XLSX

        while ($rs = mysqli_fetch_assoc($sq)) {
            //Penghapus Kata
            $row = str_replace($st_re, " ", $rs);
            //Penghitung Rumus


            if ($markups == 'metode') {
                if ($metode_markup == '%') {
                    $tambah = $row['harga'] * $nilai_markup / 100;
                    $harga = $row['harga'] + $tambah;
                } else {
                    $harga = $row['harga'] + $nilai_markup;
                }
            } else {
                $harga = $rumusHarga->getHarga($row['harga'], $rumus);
            }

            //Random URL
            if ($row['gambar1'] != "") {
                $items = json_decode($row['gambar1'], true);
                $nog = count($items);
            } else {
                $gam = "";
            }

            if (
                $row['video1'] != ""
            ) {
                $vid = "";
            } else {
                $vid = "";
            }

            $this->sheet->setCellValue(
                'A' . $i,
                mysqli_error($conn)
            );
            $this->sheet->setCellValue(
                'B' . $i,
                $nama_awal . " " . $row['nama_produk'] . " " . $nama_akhir
            );
            $this->sheet->setCellValue(
                'C' . $i,
                $deskripsi_awal . " " . $row['deskripsi'] . " " . $deskripsi_akhir
            );
            $this->sheet->setCellValue(
                'D' . $i,
                $kategori
            );
            $this->sheet->setCellValue(
                'E' . $i,
                $berat
            );
            $this->sheet->setCellValue(
                'F' . $i,
                $min_pesan
            );
            $this->sheet->setCellValue(
                'G' . $i,
                $etalase
            );
            $this->sheet->setCellValue(
                'H' . $i,
                $preorder
            );
            $this->sheet->setCellValue(
                'I' . $i,
                $row['kondisi']
            );
            if ($shop == 'shopee') {
                $this->sheet->setCellValue(
                    'J' . $i,
                    ($nog >= 1 ? "https://cf.shopee.co.id/file/" . $items["img" . random_int(0, $nog - 1)] : '')
                );
                $this->sheet->setCellValue(
                    'K' . $i,
                    ($nog >= 2 ? "https://cf.shopee.co.id/file/" . $items["img" . random_int(0, $nog - 1)] : '')
                );
                $this->sheet->setCellValue(
                    'L' . $i,
                    ($nog >= 3 ? "https://cf.shopee.co.id/file/" . $items["img" . random_int(0, $nog - 1)] : '')
                );
                $this->sheet->setCellValue(
                    'M' . $i,
                    ($nog >= 4 ? "https://cf.shopee.co.id/file/" . $items["img" . random_int(0, $nog - 1)] : '')
                );
                $this->sheet->setCellValue(
                    'N' . $i,
                    ($nog >= 5 ? "https://cf.shopee.co.id/file/" . $items["img" . random_int(0, $nog - 1)] : '')
                );
            } else {
                $this->sheet->setCellValue(
                    'J' . $i,
                    ($nog >= 1 ? $items[random_int(1, $nog)] : '')
                );
                $this->sheet->setCellValue(
                    'K' . $i,
                    ($nog >= 2 ? $items[random_int(1, $nog)] : '')
                );
                $this->sheet->setCellValue(
                    'L' . $i,
                    ($nog >= 3 ? $items[random_int(1, $nog)] : '')
                );
                $this->sheet->setCellValue(
                    'M' . $i,
                    ($nog >= 4 ? $items[random_int(1, $nog)] : '')
                );
                $this->sheet->setCellValue(
                    'N' . $i,
                    ($nog >= 5 ? $items[random_int(1, $nog)] : '')
                );
            }
            $this->sheet->setCellValue(
                'O' . $i,
                $vid
            );
            $this->sheet->setCellValue(
                'P' . $i,
                $vid
            );
            $this->sheet->setCellValue(
                'Q' . $i,
                $vid
            );
            $this->sheet->setCellValue(
                'R' . $i,
                $row['sku_name']
            );
            $this->sheet->setCellValue(
                'S' . $i,
                $row['status']
            );
            $this->sheet->setCellValue(
                'T' . $i,
                ($shop == 'shopee') ? $row['jumlah_stok'] : $stok
            );
            $this->sheet->setCellValue(
                'U' . $i,
                round($harga)
            );
            $this->sheet->setCellValue(
                'V' . $i,
                $row['asuransi']
            );
            $i++;
        }

        $this->spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(40, 'px');
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($nama_file . '-' . $f . '.xlsx');
    }
}
