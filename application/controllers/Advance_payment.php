<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Advance_payment
 *
 * @author MD. Mashfiq
 */
class Advance_payment extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('Common');
        $this->load->model('Advance_payment_model');
        //$this->load->library('session');
        $this->load->library("pagination");
    }

    function index() {
        $id_customer = $this->input->post('id_customer');
        $amount = $this->input->post('amount');
//        print_r($amount);exit();
        if (!empty($id_customer) && !empty($amount)) {
            $id = $this->Advance_payment_model->payment_add($id_customer, $amount, 1) or die('failed');
            redirect("advance_payment/add_advance_payment/".$id);
            die();
        }

        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();

        $crud = new grocery_CRUD();
        $crud->set_table('party_advance')
                ->set_subject('Party Advance')->display_as('id_customer', 'Customer name')
                ->set_relation('id_customer', 'customer', 'name')
                ->order_by('id_customer', 'asc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Advance Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'advance_payment/dashboard', $data);
    }

    function add_advance_payment($id) {
        $data['party_advance'] = $this->Advance_payment_model->get_all_party_advance_register_info($id);
//        print_r($data);exit();
        $current = date('Y-m-d');
        $crud = new grocery_CRUD();
        $crud->set_table('party_advance_payment_register')
                ->set_subject('Advance Payment')->display_as('id_customer', 'Customer name')->display_as('id_payment_method', 'Payment Method')
                ->set_relation('id_customer', 'customer', 'name')
                ->callback_add_field('date_payment', function () {
                    return '<input id="field-date_payment" name="date_payment" type="text" value="' . date('Y-m-d H:i:s') . '" >'
                            . '<style>div#date_payment_field_box{display: none;}</style>';
                })
                ->set_relation('id_payment_method', 'payment_method', 'name_payment_method')
                ->order_by('id_customer', 'asc')
                ->where('DATE(date_payment)', $current)
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['date_range'] = $this->input->get('date_range');
        $customer_id = $this->input->get('id_customer');
        $date = explode('-', $data['date_range']);
        if ($data['date_range'] != '' || !empty($customer_id)) {
            $data['get_all_cash_to_bank_info'] = $this->Advance_payment_model->get_all_party_advance_register($date[0], $date[1],$customer_id);
        }

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Advance Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'advance_payment/add_advance_payment', $data);
    }

    function payment_log() {
        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();
        $data['method_dropdown'] = $this->Advance_payment_model->get_payment_method_dropdown();

        $crud = new grocery_CRUD();
        $crud->set_table('party_advance_payment_register')
                ->columns('id_party_advance_payment_register', 'id_customer', 'id_payment_method', 'amount_paid', 'date_payment')
                ->display_as('id_party_advance_payment_register', "Transaction ID")
                ->set_subject('Payment Log')->display_as('id_customer', 'Customer name')->display_as('id_payment_method', 'Payment method')
                ->set_relation('id_customer', 'customer', 'name')
                ->set_relation('id_payment_method', 'payment_method', 'name_payment_method')
                ->order_by('id_customer', 'asc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['date_range'] = $this->input->get('date_range');
        $dates = explode(' - ', $data['date_range']);
        $customer_id = $this->input->get('id_customer');
        $payment_method_id = $this->input->get('id_payment_method');
        $btn = $this->input->get('btn_submit');

        if ($data['date_range'] != '' || !empty($customer_id) || !empty($payment_method_id)) {
            $data['search_report'] = $this->Advance_payment_model->get_search_report($dates[0],$dates[1], $customer_id, $payment_method_id);
        }

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Advance Payment Log';
        $this->load->view($this->config->item('ADMIN_THEME') . 'advance_payment/payment_log', $data);
    }

    function test($id_customer, $amount) {
        $this->Advance_payment_model->payment_reduce($id_customer, $amount) or die('failed');
    }

}
