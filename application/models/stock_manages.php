<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stock_manages extends CI_Model {

    function book_details_by_id($id) {
        $query = $this->db->query("SELECT * FROM pub_books WHERE book_ID='$id'");
        foreach ($query->result_array() as $rowid => $rowdata) {
            $data[$rowid] = $rowdata;
        }
        return $data;
    }

    function contact_details_by_type($id) {
        $query = $this->db->query("SELECT * FROM pub_contacts WHERE contact_ID='$id'");
        foreach ($query->result_array() as $contactsid => $contact) {
            $data[$contactsid] = $contact;
        }
        return $data;
    }

    function find_contactsid_by_type($type1 = '', $type2 = '') {
        $query = $this->db->query("SELECT contact_ID FROM pub_contacts WHERE contact_type=='$type1' && contact_type=='$type2'");
        foreach ($query->result_array() as $contactsid => $contact) {
            $data[$contactsid] = $contact;
        }
        return $data;
    }

    function get_stock_table($contact_type = 'Printing Press') {
        $this->load->library('table');
        $db_tables = $this->config->item('db_tables');
        $this->db->select(
                'stock_id,'
                . $db_tables['pub_books'] . '.name as book_name,'
                . $db_tables['pub_contacts'] . '.name as contact_name,'
//                . 'contact_type,'
                . 'Quantity');
//        $this->db->select('*');
        $this->db->from($db_tables['pub_stock']);
        $this->db->join("{$db_tables['pub_books']}", "{$db_tables['pub_books']}.book_ID = {$db_tables['pub_stock']}.book_ID");
        $this->db->join("{$db_tables['pub_contacts']}", "{$db_tables['pub_contacts']}.contact_ID = {$db_tables['pub_stock']}.printing_press_ID");
        $this->db->where('contact_type', $contact_type);
        $query = $this->db->get();
        $db_rows = $query->result_array();

//        setting table settings

        $this->table->set_heading('#', 'Book Name', 'Press', 'Quantity', 'Action');
        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-bordered">',
            'heading_cell_start' => '<th class="success">'
        );
        $this->table->set_template($tmpl);
        $table_rows = $db_rows;
        foreach ($db_rows as $index => $row) {
            $table_rows[$index]['stock_id'] = $index + 1;
            $table_rows[$index]['action'] = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-stock-id="' . $index . '" data-target="#myModal"><span class="glyphicon glyphicon-transfer"></span></button>';
        }

        return $this->table->generate($table_rows);
    }

}
