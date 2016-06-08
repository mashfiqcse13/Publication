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

    function test($type_code, $amount, $id_item) {
//        $this->db->select('')
//        $this->load->model('misc/Customer_due_payment');
//        $this->Customer_due_payment->add($customer_id, $payment_amount);
        $this->load->model('misc/Stock_perpetual');
        $this->Stock_perpetual->Stock_perpetual_register($id_item, $amount, $type_code) or die('Unknown Type code');
    }

}
