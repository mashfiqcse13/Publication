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

    function convert_date_range_to_mysql_between($data_picker_date_range) {
        $dates = explode(' - ', $data_picker_date_range);
        $from = date('Y-m-d', strtotime($dates[0]));
        $to = date('Y-m-d', strtotime($dates[1]));
        return " '$from' and '$to' ";
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

    function get_item_dropdown() {
        $items = $this->db->get('items')->result();

        $data = array();
        $data[''] = 'Select items by name or code';
        foreach ($items as $item) {
            $data[$item->id_item] = $item->id_item . " - " . $item->name;
        }
        return form_dropdown('id_item', $data, '', ' class="select2" ');
    }

    function dropdown_subject($value = '', $primary_key) {
        return form_dropdown('subject', $this->config->item('teacher_subject'), $value, 'class="form-control select2 dropdown-width" ');
    }

    function dropdown_upazila($value = '', $primary_key) {
        return form_dropdown('upazila', $this->config->item('upazila_english'), $value, 'class="form-control select2 dropdown-width" ');
    }

    function dropdown_division($value = '', $primary_key) {
        return form_dropdown('division', $this->config->item('division'), $value, 'class="form-control select2 dropdown-width" ');
    }

    function dropdown_district($value = '', $primary_key) {
        return form_dropdown('district', $this->config->item('districts_english'), $value, 'class="form-control select2 dropdown-width" ');
    }

    function dropdown_contact_type($value = '', $primary_key) {
        return form_dropdown('contact_type', $this->config->item('contact_type'), $value, 'class="form-control select2 dropdown-width" ');
    }

    function get_item_name_by($id_item) {
        if (empty($id_item)) {
            return false;
        }
        $sql = "SELECT * FROM items where id_item = $id_item";
        $item_details = $this->db->query($sql)->result();
        if (empty($item_details[0]->name)) {
            return false;
        } else {
            return $item_details[0]->name;
        }
    }

}
