<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Model {

    function int_to_bangla_int($int) {
        $bangla_int_char = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
        $product = '';
        if (is_int($int)) {
//           for(i=)
            return $product;
        } else
            return 'FALSE';
    }

    function taka_format($amount = 0) {
        $tmp = explode(".", $amount);       // for float or double values
        $strMoney = "";
        $amount = $tmp[0];
        $strMoney .= substr($amount, -3, 3);
        $amount = substr($amount, 0, -3);
        while (strlen($amount) > 0) {
            $strMoney = substr($amount, -2, 2) . "," . $strMoney;
            $amount = substr($amount, 0, -2);
        }
        if (isset($tmp[1])) {         // if float and double add the decimal digits here.
            $tmp[1] = number_format($tmp[1], 2, '.', '');
            return $strMoney . "." . $tmp[1];
        }
        return $strMoney;
    }

    function convert_number($number) {

        if (($number < 0) || ($number > 999999999)) {

            throw new Exception("Number is out of range");
        }

        $Gn = floor($number / 1000000);

        /* Millions (giga) */

        $number -= $Gn * 1000000;

        $kn = floor($number / 1000);

        /* Thousands (kilo) */

        $number -= $kn * 1000;

        $Hn = floor($number / 100);

        /* Hundreds (hecto) */

        $number -= $Hn * 100;

        $Dn = floor($number / 10);

        /* Tens (deca) */

        $n = $number % 10;

        /* Ones */

        $res = "";

        if ($Gn) {

            $res .= $this->convert_number($Gn) . "Million";
        }

        if ($kn) {

            $res .= (empty($res) ? "" : " ") . $this->convert_number($kn) . " Thousand";
        }

        if ($Hn) {

            $res .= (empty($res) ? "" : " ") . $this->convert_number($Hn) . " Hundred";
        }

        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");

        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

        if ($Dn || $n) {

            if (!empty($res)) {

                $res .= " and ";
            }

            if ($Dn < 2) {

                $res .= $ones[$Dn * 10 + $n];
            } else {

                $res .= $tens[$Dn];

                if ($n) {

                    $res .= "-" . $ones[$n];
                }
            }
        }

        if (empty($res)) {

            $res = "zero";
        }

        return $res;
    }

}
