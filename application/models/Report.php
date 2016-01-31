<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of report
 *
 * @author MD. Mashfiq
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Model {
    private $range ;

    //put your code here
    function sold_book_today($range = false) {

        $this->load->library('table');

        if ($range) {
            $range = "BETWEEN $range";
        } else {
            $date = date('Y-m-d');
            $range = "=DATE('$date')";
        }
        $this->range=$range;

        $sql = "SELECT pub_memos_selected_books.book_ID,name,sum(quantity) as quantity
            FROM `pub_memos_selected_books`
            JOIN `pub_memos` ON `pub_memos_selected_books`.memo_ID = `pub_memos`.memo_ID
            JOIN `pub_books` on `pub_memos_selected_books`.`book_ID` = `pub_books`.`book_ID`
            WHERE DATE(issue_date) $range
            GROUP BY `pub_memos_selected_books`.`book_ID`";

        $data = $this->db->query($sql)->result_array();

        $table_data = array();
        foreach ($data as $rowIndex => $rowValue) {
            $have_speciment_book_copy = $this->get_book_quantity($rowValue["book_ID"]);
            if ($have_speciment_book_copy > 0) {
                $quantity = "{$rowValue["quantity"]} - {$have_speciment_book_copy} = "
                        . ( $rowValue["quantity"] - $have_speciment_book_copy);
            } else {
                $quantity = $rowValue["quantity"];
            }

            array_push($table_data, array(
                $rowValue["name"], $quantity
            ));
        }

//- interval 2 day
        $table_template = array(
            'table_open' => '<table class="table table-bordered table-striped move-tk-to-right-for-soldbook">',
            'heading_cell_start' => '<th class="success" >'
        );
        $this->table->set_template($table_template);

        $this->table->set_heading("বইয়ের নাম", array('data' => " (সর্বমোট - সৌজন্য) = বিক্রিত সংখ্যা",
            'style' => "text-align: right;"
        ));


        if ($data != array()) {
            return $this->table->generate($table_data);
        } else {
            return "আজ কোন মেমো তৈরী হয়নি ।";
        }
    }

    function dateformatter($range_string, $formate = 'Mysql') {
        $date = explode(' - ', $range_string);
        $date[
                0] = explode('/', $date[0]);
        $date[1] = explode('/', $date[1]);

        if ($formate == 'Mysql')
            return "'{$date[0][2]}-{$date[0][0]}-{$date[0][1]}' and '{$date[1][2]}-{$date[1][0]}-{$date[1][1]}'";
        else
            return $date;
    }

    function get_book_quantity($book_ID, $speciment_contact_id = FALSE) {
        if (!$speciment_contact_id)
            $speciment_contact_id = $this->config->item('speciment_contact_id');

        $sql = "SELECT pub_memos_selected_books.book_ID,
                        pub_memos.contact_ID,sum(quantity) as quantity
                    FROM `pub_memos_selected_books`
                    JOIN `pub_memos` ON `pub_memos_selected_books`.memo_ID = `pub_memos`.memo_ID
                    WHERE pub_memos_selected_books.`book_ID`= {$book_ID} and 
                         DATE(issue_date) {$this->range} and
                        pub_memos.contact_ID in ({$speciment_contact_id})";
        return $this->db->query($sql)->result_array()[0]["quantity"];
    }

}
