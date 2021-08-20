<?php
include '../config.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$reader = new Xlsx();
$spreadsheet = $reader->load('templetes.xlsx');

$sheet = $spreadsheet->getActiveSheet();


for ($i = 4; $i < 10; $i++) {
    $sheet->setCellValue(
        'A' . $i,
        "ERROR"
    );
    $sheet->setCellValue(
        'B' . $i,
        "2"
    );
    $sheet->setCellValue(
        'C' . $i,
        "3"
    );
    $sheet->setCellValue(
        'D' . $i,
        "4"
    );
}

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save("file2.xlsx");
