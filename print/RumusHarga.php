<?php
class RumusHarga
{

    public function getHarga($harga, $rumus)
    {
        $profit = 0;
        if ($harga >= 0 && $harga <= 5000) {
            if ($rumus == 'Murah') {
                $profit = 29900;
            } else if ($rumus == 'Sedang') {
                $profit = 34900;
            } else if ($rumus == 'Mahal') {
                $profit = 39900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 5001 && $harga <= 10000) {
            if ($rumus == 'Murah') {
                $profit = 34900;
            } else if ($rumus == 'Sedang') {
                $profit = 39900;
            } else if ($rumus == 'Mahal') {
                $profit = 44900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 10001 && $harga <= 15000) {
            if ($rumus == 'Murah') {
                $profit = 39900;
            } else if ($rumus == 'Sedang') {
                $profit = 44900;
            } else if ($rumus == 'Mahal') {
                $profit = 49900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 15001 && $harga <= 20000) {
            if ($rumus == 'Murah') {
                $profit = 44900;
            } else if ($rumus == 'Sedang') {
                $profit = 49900;
            } else if ($rumus == 'Mahal') {
                $profit = 54900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 20001 && $harga <= 25000) {
            if ($rumus == 'Murah') {
                $profit = 49900;
            } else if ($rumus == 'Sedang') {
                $profit = 54900;
            } else if ($rumus == 'Mahal') {
                $profit = 59900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 25001 && $harga <= 30000) {
            if ($rumus == 'Murah') {
                $profit = 54900;
            } else if ($rumus == 'Sedang') {
                $profit = 59900;
            } else if ($rumus == 'Mahal') {
                $profit = 64900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 30001 && $harga <= 35000) {
            if ($rumus == 'Murah') {
                $profit = 59900;
            } else if ($rumus == 'Sedang') {
                $profit = 64900;
            } else if ($rumus == 'Mahal') {
                $profit = 69900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 35001 && $harga <= 40000) {
            if ($rumus == 'Murah') {
                $profit = 64900;
            } else if ($rumus == 'Sedang') {
                $profit = 69900;
            } else if ($rumus == 'Mahal') {
                $profit = 74900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 40001 && $harga <= 45000) {
            if ($rumus == 'Murah') {
                $profit = 69900;
            } else if ($rumus == 'Sedang') {
                $profit = 74900;
            } else if ($rumus == 'Mahal') {
                $profit = 79900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 45001 && $harga <= 50000) {
            if ($rumus == 'Murah') {
                $profit = 74900;
            } else if ($rumus == 'Sedang') {
                $profit = 79900;
            } else if ($rumus == 'Mahal') {
                $profit = 84900;
            } else {
                $profit = 0;
            }
        } else if ($harga >= 50001) {
            if ($rumus == 'Murah') {
                $profit = $harga * 75 / 100;
            } else if ($rumus == 'Sedang') {
                $profit = $harga * 80 / 100;
            } else if ($rumus == 'Mahal') {
                $profit = $harga * 85 / 100;
            } else {
                $profit = 0;
            }
        } else {
            $profit = 0;
        }

        return $harga + $profit;
    }
}
