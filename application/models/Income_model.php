<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Income_model extends CI_Model {

    function income_report($date) {
        $date = $this->dateformatter($date);

        $range_query = $this->db->query("SELECT name_expense,CONCAT('TK ',amount_income),DATE(date_income),description_income FROM `income` 
LEFT JOIN income_name on income_name.id_name_income=income.id_name_income 
WHERE date_income BETWEEN $date");

        $this->load->library('table');
        $this->table->set_heading(array('Income Name', 'Ammount', 'Date', 'Description'));
        $tmpl = array(
            'table_open' => '<table class="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0">',
            'heading_row_start' => '<tr>',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="text-center">',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );

        $this->table->set_template($tmpl);
        $this->table->set_caption('<h4><span class="pull-left">Date Range:' . $this->datereport($date) . '</span>'
                . '<span class="pull-right">Report Date: ' . date('Y-m-d h:i') . '</span></h4>'
                . '<style>td:nth-child(2) {    text-align: right;}</style>');
        return $this->table->generate($range_query);
    }

    function add_income($id, $amount) {
        $data = array(
            'id_name_income' => $id,
            'amount_income' => $amount,
            'date_income' => date('Y-m-d h:i:u')
        );
        $this->db->insert('income', $data) or die('failed to insert data on income');

        return true;
    }

    function dateformatter($range_string, $formate = 'Mysql') {
        $date = explode(' - ', $range_string);
        $date[0] = explode('/', $date[0]);
        $date[1] = explode('/', $date[1]);

        if ($formate == 'Mysql')
            return "'{$date[0][2]}-{$date[0][0]}-{$date[0][1]}' and '{$date[1][2]}-{$date[1][0]}-{$date[1][1]}'";
        else
            return $date;
    }

    function datereport($date) {
        $date = str_replace("'", ' ', $date);
        $date = str_replace('and', 'to', $date);
        return $date;
    }

}
