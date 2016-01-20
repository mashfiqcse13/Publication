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
        $this->db->where('contact_type', $contact_type)->order_by($db_tables['pub_books'] . '.book_ID', 'ASC');
        $query = $this->db->get();
        $db_rows = $query->result_array();

//        setting table settings

        $this->table->set_heading('#', 'Book Name', 'Store Name', 'Quantity', 'Action');
        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-bordered">',
            'heading_cell_start' => '<th class="bg-primary" style="vertical-align: top;">'
        );
        $this->table->set_template($tmpl);
        $table_rows = $db_rows;
        foreach ($db_rows as $index => $row) {
            $table_rows[$index]['stock_id'] = $index + 1;
            $table_rows[$index]['action'] = '<button id="buttonTransfer" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-StockId="' . $db_rows[$index]['stock_id'] . '" data-maxQuantity="' . $db_rows[$index]['Quantity'] . '" data-target="#myModal"><span class="glyphicon glyphicon-transfer"></span></button>';
        }

        return $this->table->generate($table_rows);
    }

    function append_new_stock($book_id, $printingpress_id, $quantity) {
        $destination_stock_details = $this->get_stock_details_by($book_id, $printingpress_id);

        // checking if we have a blank destination stock
        $destination_stock_details = (sizeof($destination_stock_details) < 1) ? false : $destination_stock_details;

        if ($destination_stock_details) {       //if we have existing destination stock , we update the stock
            $destination_stock_id = $destination_stock_details[0]['stock_id'];
            $this->increase_stock($destination_stock_id, $quantity);
        } else {        //if we have a blank destination stock , we insert new stock
            $this->insert_stock($book_id, $printingpress_id, $quantity);
        }
    }

    function transfer_stock() {
        $from_stock_id = $this->input->post('stock_id_from');
        $to_contact_id = $this->input->post('to_contact_id');
        $Quantity = $this->input->post('Quantity');

        if (!$from_stock_id) {
            return 0;
        }
        $source_stock_details = $this->get_stock_details($from_stock_id)[0];
        /* @var $destination_stock_details array */
        $destination_stock_details = $this->get_stock_details_by($source_stock_details['book_ID'], $to_contact_id);

        // checking if we have a blank destination stock
        $destination_stock_details = (sizeof($destination_stock_details) < 1) ? false : $destination_stock_details;

        if ($destination_stock_details) {       //if we have existing destination stock , we update the stock
            $destination_stock_id = $destination_stock_details[0]['stock_id'];
            $this->reduce_stock($from_stock_id, $Quantity);
            $this->increase_stock($destination_stock_id, $Quantity);
        } else {        //if we have a blank destination stock , we insert new stock
            $this->reduce_stock($from_stock_id, $Quantity);
            $this->insert_stock($source_stock_details['book_ID'], $to_contact_id, $Quantity);
        }
        $this->remove_null_stock();
    }

    function remove_null_stock() {
        $db_tables = $this->config->item('db_tables');
        $this->db->delete($db_tables['pub_stock'], array('Quantity<=' => 0));
    }

    function reduce_stock($stock_id, $Quantity) {
        $db_tables = $this->config->item('db_tables');
        $sql = "UPDATE `{$db_tables['pub_stock']}` SET `Quantity`=`Quantity` - $Quantity WHERE `stock_id` = $stock_id";
        $this->db->query($sql);
    }

    function increase_stock($stock_id, $Quantity) {
        $db_tables = $this->config->item('db_tables');
        $sql = "UPDATE `{$db_tables['pub_stock']}` SET `Quantity`=`Quantity` + $Quantity WHERE `stock_id` = $stock_id";
        $this->db->query($sql);
    }

    function marge_insert_book($post_array, $primary_key) {

        $contact_ID = $post_array['contact_ID'];
        $book_ID = $post_array['book_ID'];



        $this->db->select_sum('quantity');
        $this->db->where('contact_ID', $contact_ID);
        $this->db->where('book_ID', $book_ID);
        $new_quantity = $this->db->get('pub_books_return')->result_array()[0]['quantity'];
//        die($new_quantity);
        $this->db->where('contact_ID', $contact_ID);
        $this->db->where('book_ID', $book_ID);
        $this->db->delete('pub_books_return');

        $data = array(
            'contact_ID' => $contact_ID,
            'book_ID' => $book_ID,
            'quantity' => $new_quantity
        );


        $this->db->insert('pub_books_return', $data);

        return TRUE;
    }

    function insert_stock($book_ID, $printing_press_ID, $Quantity) {
        $db_tables = $this->config->item('db_tables');
        $data = array(
            'book_ID' => $book_ID,
            'printing_press_ID' => $printing_press_ID,
            'Quantity' => $Quantity
        );

        $this->db->insert($db_tables['pub_stock'], $data);
    }

    function get_stock_details($stock_id) {
        $db_tables = $this->config->item('db_tables');
        $this->db->select('*');
        $this->db->from($db_tables['pub_stock']);
        $this->db->where('stock_id', $stock_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_stock_details_by($book_ID, $printing_press_ID) {
        $db_tables = $this->config->item('db_tables');
        $this->db->select('*');
        $this->db->from($db_tables['pub_stock']);
        $where = array(
            'book_ID' => $book_ID,
            'printing_press_ID' => $printing_press_ID
        );
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_contact_dropdown() {
        $db_tables = $this->config->item('db_tables');
        $this->db->select('*');
        $this->db->from($db_tables['pub_contacts']);
        $this->db->where_in('contact_type', array('Printing Press', 'Binding Store', 'Sales Store',));
        $this->db->order_by('contact_type', "desc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        foreach ($db_rows as $index => $row) {
            $options[$row['contact_ID']] = $row['name'] . "('{$row['contact_type']}')";
        }

        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('to_contact_id', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"');
    }

    function get_bookid_dropdown() {
        $db_tables = $this->config->item('db_tables');
        $this->db->select('*');
        $this->db->from($db_tables['pub_books']);

        $query = $this->db->get();
        $db_rows = $query->result_array();
        foreach ($db_rows as $index => $row) {
            $options[$row['book_ID']] = $row['name'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('book_id', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"');
    }

    function get_buyer_dropdown() {
        $db_tables = $this->config->item('db_tables');
        $this->db->select('*');
        $this->db->from($db_tables['pub_contacts']);
        $this->db->where_in('contact_type', array('Buyer'));
        $this->db->order_by('contact_type', "asc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        $options['Select'] = "Select Party Name";
        foreach ($db_rows as $index => $row) {
            $options[$row['contact_ID']] = $row['name'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('buyer_id', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"');
    }

    function get_book_returned_dropdown() {
        $db_tables = $this->config->item('db_tables');
        $this->db->select('*');
        $this->db->from($db_tables['pub_books']);
        $this->db->join($db_tables['pub_books_return'], 'pub_books.book_ID = pub_books_return.book_ID');
        $this->db->order_by('name', "asc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        $options['Select'] = "Select Book Name";
        foreach ($db_rows as $index => $row) {
            $options[$row['book_ID']] = $row['name'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('returned_book_ID', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"');
    }

    function get_due_holder_dropdown() {
        $db_tables = $this->config->item('db_tables');
        $this->db->select('*');
        $this->db->from($db_tables['pub_contacts']);
        $this->db->join('pub_memos', 'pub_contacts.contact_ID = pub_memos.contact_ID');
        $this->db->where_in('contact_type', array('Buyer'))
                ->where('due >', 0);
        $this->db->order_by('contact_type', "asc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        $options['Select'] = "Select Party Name";
        foreach ($db_rows as $index => $row) {
            $options[$row['contact_ID']] = $row['name'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('buyer_id', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"');
    }

    function get_printingpress_dropdown() {
        $db_tables = $this->config->item('db_tables');
        $this->db->select('*');
        $this->db->from($db_tables['pub_contacts']);
        $this->db->where_in('contact_type', array('Printing Press'));
        $this->db->order_by('contact_type', "asc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        foreach ($db_rows as $index => $row) {
            $options[$row['contact_ID']] = $row['name'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('printingpress_id', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"');
    }

//    function get_max_sales_stock($book_ID) {
//        $db_tables = $this->config->item('db_tables');
//        $this->db->select(
//                'stock_id,'
//                . $db_tables['pub_books'] . '.name as book_name,'
//                . $db_tables['pub_contacts'] . '.name as contact_name,'
////                . 'contact_type,'
//                . 'Quantity');
////        $this->db->select('*');
//        $this->db->from($db_tables['pub_stock']);
//        $this->db->join("{$db_tables['pub_books']}", "{$db_tables['pub_books']}.book_ID = {$db_tables['pub_stock']}.book_ID");
//        $this->db->join("{$db_tables['pub_contacts']}", "{$db_tables['pub_contacts']}.contact_ID = {$db_tables['pub_stock']}.printing_press_ID");
//        $this->db->where('contact_type', $contact_type);
//        $query = $this->db->get();
//
//        $db_rows = $query->result_array();
//    }
    function get_max_sales_stock($book_ID) {
        $db_tables = $this->config->item('db_tables');
        $this->db->select('Quantity');
        $db_rows = $this->db->from($db_tables['pub_stock'])
                        ->join("{$db_tables['pub_contacts']}", "{$db_tables['pub_contacts']}.contact_ID = {$db_tables['pub_stock']}.printing_press_ID")
                        ->where('contact_type', 'Sales Store')
                        ->where('book_ID', $book_ID)
                        ->get()->result_array();
        return isset($db_rows[0]['Quantity']) ? $db_rows[0]['Quantity'] : false;
    }

    function total_book_returned() {
        $db_tables = $this->config->item('db_tables');
        $db_rows = $this->db->select_sum('quantity')->from($db_tables['pub_books_return'])
                        ->get()->result_array();

        return isset($db_rows[0]['quantity']) ? $db_rows[0]['quantity'] : 0;
    }

}
