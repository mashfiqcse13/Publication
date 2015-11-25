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

    //put your code here
    function sold_book_today() {
        $this->load->library('table');
        $date = date('Y-m-d');
        $data = $this->db->query("SELECT name,sum(quantity) as quantity
            FROM `pub_memos_selected_books`
            JOIN `pub_memos` ON `pub_memos_selected_books`.memo_ID = `pub_memos`.memo_ID
            JOIN `pub_books` on `pub_memos_selected_books`.`book_ID` = `pub_books`.`book_ID`
            WHERE issue_date=DATE('$date')
            GROUP BY `pub_memos_selected_books`.`book_ID`")->result_array();
//- interval 2 day
        $table_template = array(
            'table_open' => '<table class="table table-bordered table-striped">',
            'heading_cell_start' => '<th class="success" >'
        );
        $this->table->set_template($table_template);
        $this->table->set_heading("বইয়ের নাম", "পরিমাণ");

        if ($data != array())
            return $this->table->generate($data);
        else
            return "আজ কোন মেমো তৈরী হয়নি ।";
    }

}
