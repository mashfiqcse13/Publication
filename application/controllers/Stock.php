<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stock
 *
 * @author sonjoy
 */
class Stock extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('Common');
        $this->load->model('Stock_model');
    }

    function index() {
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Stock';

        $this->load->view($this->config->item('ADMIN_THEME') . 'stock/stock_dashboard', $data);
    }

    function stock_perpetual($cmd = false) {
        $data['stock_info'] = $this->Stock_model->select_stock();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Stock';

        $data['date_range'] = $this->input->post('date_range');
        $date = explode('-', $data['date_range']);
        if ($data['date_range'] != '') {
            $this->session->set_userdata('date_range', $data['date_range']);
            $data['stock_info'] = $this->Stock_model->search_item($date[0], $date[1]);
        }
        if ($cmd == 'reset_date_range') {
            $this->session->unset_userdata('date_range');
            redirect("stock/stock_perpetual");
        }


        $this->load->view($this->config->item('ADMIN_THEME') . 'stock/stock_perpetual', $data);
    }

    function final_stock() {
        $id_item = $this->input->post('id_item');
        $amount = $this->input->post('amount');
        if (!empty($id_item) && !empty($amount)) {
            $this->Stock_model->stock_add($id_item, $amount) or die('failed');
            redirect(current_url(), 'refresh');
        }

        $data['item_dropdown'] = $this->Common->get_item_dropdown();

        $crud = new grocery_CRUD();
        $crud->set_table('stock_final_stock')
                ->set_subject('Final stock')
                ->set_relation('id_item', 'items', 'name')
                ->order_by('id_item', 'desc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Final stock';
        $this->load->view($this->config->item('ADMIN_THEME') . 'stock/final_stock', $data);
    }

    function test($id_item, $amount) {
//        $this->db->select('')
//        $this->load->model('misc/Customer_due_payment');
//        $this->Customer_due_payment->add($customer_id, $payment_amount);
//        $this->load->model('misc/Stock_perpetual');
//        $this->Stock_perpetual->Stock_perpetual_register($id_item, $amount, $type_code) or die('Unknown Type code');
//        $this->Stock_model->stock_add($id_item, $amount) or die('failed');
        $this->Stock_model->stock_reduce($id_item, $amount) or die('failed');
    }

}
