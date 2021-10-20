<?php
include '../../config.php';
include 'numberRoman.php';

use Mpdf\Mpdf;

class InvoiceMaker
{
    public function create_invoice($purpose, $id, $client, $activedate, $countdate, $harga, $statbayar, $option)
    {
        $mpdf = new Mpdf(['format' => 'A5', 'orientation' => 'L', 'default_font' => 'times', 'default_font_size' => 11]);
        $date  = date('dmY');
        $randint = "12200" . $id;
        $roman = new numberRoman();
        $rommonth = $roman->numberToRomanRepresentation(date('m'));
        $romyear = $roman->numberToRomanRepresentation(date('y'));
        $datenow = date_format(date_create(date('Y-m-d')), 'd F Y');
        $nm_file = 'invoice-simaket.pdf';



        if ($statbayar == 'lunas') {
            $lunas =  "<div style='color:green;font-weight:bold;font-size:14px;'>Lunas</div>";
            $invo = "<h4 class='text-center' style='text-decoration: underline;font-size:18px;font-weight:bold;'>INVOICE PELUNASAN</h4>";
        } else {
            $lunas = "<div style='color:red;font-weight:bold;font-size:14px;'>Belum Lunas</div>";
            $invo = "<h4 class='text-center' style='text-decoration: underline;font-size:18px;font-weight:bold;'>INVOICE PENAGIHAN</h4>";
        }


        $header = "
            <br><br><br><br><br>
            $invo
            <table class='table table-sm table-borderless' style='font-size:12px'>
            <tr>
            <td><p style='font-size:12px;'>Invoice Number</p></td>
            <td><p style='font-size:12px;'>INV/$date/$romyear/$rommonth/$randint</p></td>
            </tr>
            <tr>
            <td style='width: 18%;'><p style='font-size:12px;'>Nama Client</p></td>
            <td><p style='font-size:12px;'>$client</p></td>
            </tr>
            <tr>
            <td><p style='font-size:12px;'>Tanggal</p></td>
            <td><p style='font-size:12px;'>$datenow</p></td>
            </tr>
            </table>
        ";

        $table = "<table style='font-size:12px;' class='table table-bordered table-lg'>
                <thead>
                <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah Hari</th>
                <th>Tanggal Berlangganan</th>
                <th>Harga</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td>1</td>
                <td>$purpose</td>
                <td>$countdate</td>
                <td>$activedate</td>
                <td>Rp. " . number_format($harga) . "</td>
                </tr>
                <tbody>
                <tfoot>
                <tr>
                <th colspan='4'>Sub Total</th>
                <th>Rp. " . number_format($harga) . "</th>
                </tr>
                </tfoot>
            </table>";

        $bayar = "
            <div class='d-flex justify-content-start'>
            <div style='width:200px;'>
            <table class='table table-bordered' style='font-size:12px;'>
            <thead>
            <tr>
            <th>Status Pembayaran</th>
            </thead>
            <tbody>
            <tr>
            <td>
            $lunas
            </td>
            </tr>
            </tbody>
            </table></div></div>";

        $mpdf->displayDefaultOrientation = true;
        $mpdf->AddPage('L');

        $pagecount =  $mpdf->setSourceFile("../../assets/img/templete.pdf");
        $tplId = $mpdf->ImportPage($pagecount);
        $mpdf->UseTemplate($tplId);
        $mpdf->SetFont("Times New Roman");
        $mpdf->SetWatermarkImage('../../assets/img/LOGOCVGS.V3.png', '0.1', 'P');
        $mpdf->showWatermarkImage = true;
        $stylesheet = file_get_contents("https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css");
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($header);
        $mpdf->WriteHTML($table);
        $mpdf->WriteHTML($bayar);

        // I:preview D:download S:string F:savetoserver

        if ($option == 'cetak') {
            $pdf = $mpdf->Output($nm_file, 'I');
        } else {
            $att = $mpdf->Output($nm_file, 'S');
            $pdf = array($att => $nm_file);
        }

        return $pdf;
    }
}
