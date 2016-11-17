<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payment_log
 *
 * @author sonjoy
 */
class Payment_log extends CI_Controller {

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
        $this->load->model('Payment_log_model');
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(25);
    }

    function index() {
        $crud = new Grocery_CRUD();
        $crud->set_table('customer_payment')
                ->set_subject('customer_payment')
                ->set_relation('id_customer', 'customer', 'name')
                ->set_relation('id_customer_due_payment_register', 'customer_due_payment_register', 'tatal_paid_amount')
                ->set_relation('id_payment_method', 'payment_method', 'name_payment_method')
                ->columns('id_customer', 'id_total_sales', 'id_payment_method', 'paid_amount', 'id_customer_due_payment_register', 'payment_date')
                ->display_as('id_customer', 'Customer Name')
                ->display_as('id_total_sales', 'Memo No')
                ->display_as('id_customer_due_payment_register', 'Due payment')
                ->display_as('id_payment_method', 'Payment Method')
                ->display_as('paid_amount', 'Amount')->order_by('id_customer_payment', 'desc')
                ->unset_add()->unset_edit()->unset_read()->unset_delete();
        $crud->add_action('Print Memo', '', '', 'fa fa-print', function ($primary_key, $row) {
            return site_url('payment_log/log_slip/' . $primary_key);
        });

        $output = $crud->render();
        $data['glosary'] = $output;


        $btn = $this->input->get('btn_submit');
        $id_customer = $this->input->get('customer');
        $payment_method = $this->input->get('payment_method');
        $data['date_range'] = $this->input->get('date_range');
        if (isset($btn)) {
            $data['get_customer_payment_info'] = $this->Payment_log_model->get_customer_payment_info($id_customer, $payment_method, $data['date_range']);
        }

//        $data['customers'] = $this->db->get('customer')->result();
        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Payment Log';
        $this->load->view($this->config->item('ADMIN_THEME') . 'payment_log/payment_log', $data);
    }

    function log_slip($id) {
        $data['get_payment_log'] = $this->Payment_log_model->get_payment_log($id);
//        echo '<pre..>';print_r($data);exit();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Payment Log';
        $this->load->view($this->config->item('ADMIN_THEME') . 'payment_log/payment_slip', $data);
    }

}
