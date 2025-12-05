<?php

if (!function_exists('convertToIndianCurrency')) {
    function convertToIndianCurrency($number)
    {
        $decimal = round($number - floor($number), 2);
        $no = floor($number);
        $points = round($decimal * 100);
        $words = array(
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
            17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
            30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );

        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];
        $str = [];
        $i = 0;

        while ($no > 0) {
            $divider = ($i == 1) ? 10 : 100;
            $number = $no % $divider;
            $no = (int)($no / $divider);

            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;

                if ($number < 21) {
                    $str[] = $words[$number] . " " . $digits[$i] . $plural . $hundred;
                } else {
                    $str[] = $words[(int)($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$i] . $plural . $hundred;
                }
            }
            $i++;
        }

        $result = implode(' ', array_reverse($str));
        $rupees = trim($result) . ' Rupees';

        $paise = ($points > 0) ? " and " . $words[(int)($points / 10) * 10] . " " . $words[$points % 10] . ' Paise' : '';

        return $rupees . $paise;
    }
}


?>