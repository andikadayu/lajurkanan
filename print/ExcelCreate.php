<?php

include '../config.php';
include 'RumusHarga.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelCreate
{
    public $sheet;
    public $spreadsheet;

    public $imgd = "Masukkan alamat website (link) foto produk
                Untuk upload:\n
                1. Upload ke https://imgur.com/upload\n
                \n
                Untuk dapatkan URL Gambar:\n
                1. Di Google Chrome, klik kanan pada gambar\n
                2. Klik 'Open Link in a New Tab'\n
                3. Copy link untuk kemudian dimasukan pada kolom ini";
    public $vidurl = "Tambahkan video untuk menjelaskan spesifikasi dan cara menggunakan produk yang kamu jual.
                Hanya boleh URL dari Youtube";


    public function __construct($sheet, Spreadsheet $spreadsheet)
    {
        $this->sheet = $sheet;
        $this->spreadsheet = $spreadsheet;
    }

    public function create_excel($conn, $sq, $nama_file, $hapus_kata, $preorders, $stok, $markups_perhar, $markups_rumus, $metode_markup, $nilai_markup, $rumus, $nama_awal, $nama_akhir, $deskripsi_awal, $deskripsi_akhir, $kategori, $berat, $min_pesan, $etalase, $f, $shop)
    {

        $rumusHarga = new RumusHarga();

        // create row
        $i = 5; //space 1

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
        $hargaperhar = 0;
        $hargarumus = 0;
        $hargascrap = 0;
        //Content XLSX

        while ($rs = mysqli_fetch_assoc($sq)) {
            //Penghapus Kata
            $rmdef = [
                "Octopus",
                "Vagina",
                "Penis",
                "Orico",
                "Knee",
                "Kpop",
                "Bt21",
                "Bts",
                "Exo",
                "Blackpink",
                "Xiaomi",
                "Spiral",
                "Hoonigan",
                "Ikea",
                "Sunnersta",
                "Imitasi",
                "Sunglasses",
                "ambilight",
                "pop socket",
                "celine",
                "ps4",
                "playstation",
                "rcm",
                "nintendo",
                "restaclat",
                "redragon",
                "hilfiger",
                "calvin klein",
                "kaws",
                "dior",
                "Huawei",
                "Rapid",
                "peppa pig",
                "Shopee",
                "Lazada",
                "Graco",
                "="
            ];
            $autoremove = str_replace($rmdef, "", $rs);
            $row = str_replace($st_re, "", $autoremove);

            //set harga
            $hargascrap = $row['harga'];

            // generator sku name
            $sku_shopee = "";
            $text = $row['nama_produk'];
            $cleanspace = str_replace(" ", '', $text);
            $characters = preg_replace("/[^A-Za-z ]/", '', $cleanspace);
            $charactersLength = strlen($characters);
            $randomString = '';
            $length = 7;
            for ($nos = 0; $nos < $length; $nos++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $sku_shopee = strtoupper($randomString) . rand(1111111, 9999999);


            $nama_produks = "";
            $deskripsi_produks = "";
            if ($nama_awal !== '' || $nama_akhir !== '') {
                $nama_produks = $nama_awal . " " . $row['nama_produk'] . " " . $nama_akhir;
            } else {
                $nama_produks = $row['nama_produk'];
            }
            if ($deskripsi_awal !== '' || $deskripsi_akhir !== '') {
                $deskripsi_produks = $deskripsi_awal . " " . $row['deskripsi'] . " " . $deskripsi_akhir;
            } else {
                $deskripsi_produks = $row['deskripsi'];
            }

            //Penghitung Rumus

            if ($markups_perhar == 'yes') {
                if ($metode_markup == '%') {
                    $tambah = $hargascrap * $nilai_markup / 100;
                    $hargaperhar = $hargascrap + $tambah;
                } else {
                    $hargaperhar = $hargascrap + $nilai_markup;
                }
            }
            if ($markups_rumus == 'yes') {
                $hargarumus = $rumusHarga->getHarga($hargascrap, $rumus);
            }

            // final harga;
            $harga = $hargaperhar + $hargarumus;

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
                substr($nama_produks, 0, 70)
            );
            $this->sheet->setCellValue(
                'C' . $i,
                substr($deskripsi_produks, 0, 2000)
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
                    ($nog >= 1 ? "https://f.shopee.co.id/file/" . $items["img0"] : '')
                );
                $this->sheet->setCellValue(
                    'K' . $i,
                    ($nog >= 2 ? "https://f.shopee.co.id/file/" . $items["img1"] : '')
                );
                $this->sheet->setCellValue(
                    'L' . $i,
                    ($nog >= 3 ? "https://f.shopee.co.id/file/" . $items["img2"] : '')
                );
                $this->sheet->setCellValue(
                    'M' . $i,
                    ($nog >= 4 ? "https://f.shopee.co.id/file/" . $items["img3"] : '')
                );
                $this->sheet->setCellValue(
                    'N' . $i,
                    ($nog >= 5 ? "https://f.shopee.co.id/file/" . $items["img" . random_int(4, $nog - 1)] : '')
                );
            } else {
                $this->sheet->setCellValue(
                    'J' . $i,
                    ($nog >= 1 ? $items[1] : '')
                );
                $this->sheet->setCellValue(
                    'K' . $i,
                    ($nog >= 2 ? $items[2] : '')
                );
                $this->sheet->setCellValue(
                    'L' . $i,
                    ($nog >= 3 ? $items[3] : '')
                );
                $this->sheet->setCellValue(
                    'M' . $i,
                    ($nog >= 4 ? $items[4] : '')
                );
                $this->sheet->setCellValue(
                    'N' . $i,
                    ($nog >= 5 ? $items[random_int(5, $nog)] : '')
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
            if ($shop == 'shopee') {

                $this->sheet->setCellValue(
                    'R' . $i,
                    $sku_shopee
                );
            } else {
                $this->sheet->setCellValue(
                    'R' . $i,
                    $row['sku_name']
                );
            }
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

        // Style Column Width
        $this->spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(35);

        // Set Alignment
        $this->sheet->getStyle('A4:V' . $i)->getAlignment()->setHorizontal('left');

        // Set Font All
        $this->spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');

        //Create File XLSX
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($nama_file . '-' . $f . '.xlsx');
    }
}
