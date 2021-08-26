<?php
class testPrint
{
    public function deletePrint($namaFile)
    {
        foreach (glob("$namaFile-*.xlsx") as $filename) {
            unlink($filename);
        }
    }
}
