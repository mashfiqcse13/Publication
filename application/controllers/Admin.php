<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author MD. Mashfiq
 */
//define('DASHBOARD', "$baseurl");


class Admin extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');

        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }

        $this->load->library('grocery_CRUD');
    }

    function index() {

        $this->load->model('account/account');
        $data['account_today'] = $this->account->today();
        $data['account_monthly'] = $this->account->monthly();
        $data['total'] = $this->account->total();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Dashboard';
        $this->load->view($this->config->item('ADMIN_THEME') . 'dashboard', $data);
    }

    function manage_book() {

        $crud = new grocery_CRUD();
        $crud->set_table('pub_books')->set_subject('Book');
        $crud->callback_add_field('catagory', function () {
            return form_dropdown('catagory', $this->config->item('book_categories'), '0');
        });
        $crud->callback_add_field('storing_place', function () {
            return form_dropdown('storing_place', $this->config->item('storing_place'));
        });
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Book';
        $this->load->view($this->config->item('ADMIN_THEME') . 'manage_book', $data);
    }

    function manage_contact() {

        $crud = new grocery_CRUD();
        $crud->set_table('pub_contacts')->set_subject('Contact');
        $crud->callback_add_field('contact_type', function () {
            return form_dropdown('contact_type', $this->config->item('contact_type'));
        });
        $crud->callback_edit_field('contact_type', function ($value, $primary_key) {
            return form_dropdown('contact_type', $this->config->item('contact_type'), $value);
        });
        $output = $crud->render();
        $data['glosary'] = $output;



        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Contact';


        $this->load->view($this->config->item('ADMIN_THEME') . 'manage_contact', $data);
    }

    function manage_stock() {

        $crud = new grocery_CRUD();
        $crud->set_table('pub_stock')->set_subject('Stock');

        $crud->set_relation('book_ID', 'pub_books', 'name');
        $crud->set_relation('printing_press_ID', 'pub_contacts', 'name');
        $crud->set_relation('binding_store_ID', 'pub_contacts', 'name');
        $crud->set_relation('sales_store_ID', 'pub_contacts', 'name');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Book';
        $this->load->view($this->config->item('ADMIN_THEME') . 'stock_manage', $data);
    }

    function account() {
//        $this->load->model('custom/stock_manage');

        $this->load->model('account/account');
        // $data['todaysell']=$this->account->todaysell();
        // $data['monthly_sell']=$this->account->monthlysell();
        // $data['today_due']=$this->account->today_due();
        // $data['monthly_due']=$this->account->monthly_due();
        // $data['total_cash_paid']=$this->account->total_cash_paid();
        // $data['total_bank_pay']=$this->account->total_bank_pay();
        // $data['total_due']=$this->account->total_due();
        // $data['total_sell']=$this->account->totalsell();
        $data['account_today'] = $this->account->today();
        $data['account_monthly'] = $this->account->monthly();
        $data['total'] = $this->account->total();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Account Information';
        $data['base_url'] = base_url();

        $this->load->view($this->config->item('ADMIN_THEME') . 'account', $data);
    }

    function memo($momo_id) {
        $this->load->model('Memo');

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Memo Generation';
        $data['base_url'] = base_url();

        $data['Book_selection_table'] = $this->Memo->memogenerat($momo_id);

        //$data['memo']=$this->Memo->memogenerat();
        //var_dump($data['memo']);
        //$this->Memo->memogenerat();

        $this->load->view($this->config->item('ADMIN_THEME') . 'memo', $data);
    }

    function memo_management($cmd=false,$primary_id=false) {
        $crud = new grocery_CRUD();

        $crud->set_table('pub_memos')
                ->set_subject('Memo')
                ->display_as('contact_ID', 'Party Name');
        $crud->set_relation('contact_ID', 'pub_contacts', 'name');
        $crud->callback_add_field('memo_serial', function () {
            $unique_id = uniqid();
            return '<label>' . $unique_id . '</label><input type="hidden" maxlength="50" value="' . $unique_id . '" name="memo_serial" >';
        });
        $crud->callback_add_field('sub_total', array($this, 'add_book_selector_table'));
        $crud->callback_edit_field('sub_total', array($this, 'edit_book_selector_table'));

        $crud->callback_after_insert(array($this, 'after_adding_memo'));
        $crud->callback_after_update(array($this, 'after_editing_memo'));
        $crud->callback_before_insert(array($this, 'before_adding_or_updating_memo'));
        $crud->callback_before_update(array($this, 'before_adding_or_updating_memo'));

        $crud->add_action('Print', '', site_url('admin/memo/1'), 'fa fa-print', function ($primary_key, $row) {
            return site_url('admin/memo/' . $row->memo_ID);
        });
            
        if($cmd=='success') $AutoPrintPageOpenCommandJS = 'window.open("'.site_url('admin/memo/' . $primary_id).'");';
        else $AutoPrintPageOpenCommandJS = '';
        
        $addContactButtonContent = anchor('admin/manage_contact/add', '<i class="fa fa-plus-circle"></i> Add New Contact', 'class="btn btn-default" style="margin-left: 15px;"');
        $data['scriptInline'] = ""
                . "<script>"
                . "$AutoPrintPageOpenCommandJS"
                . "var addContactButtonContent = '$addContactButtonContent';\n "
                . "var CurrentDate = '" . date("m/d/Y") . "';"
                . "var previousDueFinderUrl = '" . site_url("admin/previousDue/") . "';"
                . "</script>\n"
                . '<script type="text/javascript" src="' . base_url() . $this->config->item('ASSET_FOLDER') . 'js/Custom-main.js"></script>';

        $output = $crud->render();

//        $this->grocery_crud->set_table('pub_memos')->set_subject('Memo');
//        $output =  $this->grocery_crud->render();

        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Memo Management';
        $data['base_url'] = base_url();

        $this->load->view($this->config->item('ADMIN_THEME') . 'memo_management', $data);
    }

    function add_book_selector_table() {
        $this->load->library('table');
        // Getting Data
        $query = $this->db->query("SELECT * FROM `pub_books`");
        $data = array();
        foreach ($query->result_array() as $index => $row) {
            array_push($data, [$row['name'],
                $row['price'],
                '<input style="width: 100px;" data-index="' . $index . '" data-price="' . $row['price'] . '" name="quantity[' . $row['book_ID'] . ']" value="0" class="numeric form-control" type="number">'
                . '     <input name="price[' . $row['book_ID'] . ']" value="' . $row['price'] . '" type="hidden">'
            ]);
        }
        $this->table->set_heading('Book Name', 'Price', 'Quantity');

        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-bordered table-striped">',
            'heading_cell_start' => '<th class="success">'
        );
        $this->table->set_template($tmpl);

        $output = '<label>Select Book Quantity:</label><div style="overflow-y:scroll;max-height:200px;">
                    ' . $this->table->generate($data) . '</div>
                   <label>Sub Total :</label><span id="sub_total">0</span><span>Tk</span> <input type="hidden" maxlength="50  " name="sub_total">';
        return $output;
    }

    function edit_book_selector_table($value, $primary_key) {
        $this->load->library('table');
        // Getting Data
        $where = array('memo_ID' => $primary_key);
        $book_selection_query = $this->db->get_where('pub_memos_selected_books', $where);
        $book_selection = $book_selection_query->result_array();

        foreach ($book_selection as $index => $row) {
            $book_ID = $row['book_ID'];
            $quantity = $row['quantity'];
            $book_quantity_by_id[$book_ID] = $quantity;
        }

        $query = $this->db->query("SELECT * FROM `pub_books`");
        $data = array();
        foreach ($query->result_array() as $index => $row) {
            array_push($data, [$row['name'],
                $row['price'],
                '<input style="width: 100px;" data-index="' . $index . '" data-price="' . $row['price'] . '" name="quantity[' . $row['book_ID'] . ']" value="' . $book_quantity_by_id[$row['book_ID']] . '" class="numeric form-control" type="number">'
                . '     <input name="price[' . $row['book_ID'] . ']" value="' . $row['price'] . '" type="hidden">'
            ]);
        }
        $this->table->set_heading('Book Name', 'Price', 'Quantity');

        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-bordered table-striped">',
            'heading_cell_start' => '<th class="success">'
        );
        $this->table->set_template($tmpl);

        $output = '<label>Select Book Quantity:</label><div style="overflow-y:scroll;max-height:200px;">
                    ' . $this->table->generate($data) . '</div>
                   <label>Sub Total :</label><span id="sub_total">' . $value . '</span><span>Tk</span> <input type="hidden" maxlength="50" value="' . $value . '" name="sub_total">';
        $output.=""
                . "<script>"
                . "var memo_ID='" . $primary_key . "';"
                . "</script>\n";
        return $output;
    }

    function after_adding_memo($post_array, $primary_key) {
        foreach ($post_array['quantity'] as $index => $value) {
            $book_ordered_quantity_insert = array(
                "memo_ID" => $primary_key,
                "book_ID" => $index,
                "quantity" => $value,
                "price_per_book" => $post_array['price'][$index],
                "total" => $value * $post_array['price'][$index]
            );

            $this->db->insert('pub_memos_selected_books', $book_ordered_quantity_insert);
        }
        echo ""
        . "<script>\n"
                . 'window.open("http://www.w3schools.com");'
        . "</script>\n";
        return TRUE;
    }

    function before_adding_or_updating_memo($post_array, $primary_key = false) {
        $data = array(
            'dues_unpaid' => 0
        );

        $this->db->where('contact_ID', $post_array['contact_ID']);
        $this->db->update($this->config->item('db_tables')['pub_memos'], $data);
    }

    //    Getting the previous due and make other row's due 0
    function previousDue($contact_ID = 2, $memo_ID = 1) {
//        echo site_url("admin/previousDue/$id");
        $this->db->select_sum('due');
        $where_conditions = array(
            'contact_ID' => $contact_ID,
            'memo_ID <' => $memo_ID
        );
        $this->db->where($where_conditions);
        $query = $this->db->get($this->config->item('db_tables')['pub_memos']);
        echo $query->result_array()[0]['due'];
    }

    //    Getting the previous due and make other row's due 0
    function previousDueTest($contact_ID = 2, $memo_ID = 1) {
        $this->load->library('table');
//        echo site_url("admin/previousDue/$id");
//        $this->db->select_sum('due');
        $where_conditions = array(
            'contact_ID' => $contact_ID,
            'memo_ID !=' => $memo_ID
        );
        $this->db->where($where_conditions);
        $query = $this->db->get($this->config->item('db_tables')['pub_memos']);
        //print_r($query->result_array());
        echo "<br>";
        echo $this->table->generate($query->result_array());
    }

}
