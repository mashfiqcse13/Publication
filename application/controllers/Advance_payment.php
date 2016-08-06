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
    
    function index(){
        $id_customer = $this->input->post('id_customer');
        $amount = $this->input->post('amount');
//        print_r($amount);exit();
        if (!empty($id_customer) && !empty($amount)) {
            $this->Advance_payment_model->payment_add($id_customer, $amount,1) or die('failed');
            redirect("advance_payment/payment_log");
            die();
        }

        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();

        $crud = new grocery_CRUD();
        $crud->set_table('party_advance')
                ->set_subject('Party Advance')->display_as('id_customer','Customer name')
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
    
    function payment_log(){
        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();

        $crud = new grocery_CRUD();
        $crud->set_table('party_advance_payment_register')
                ->columns('id_party_advance_payment_register', 'id_customer', 'id_payment_method', 'amount_paid', 'date_payment')
                ->display_as('id_party_advance_payment_register',"Transaction ID")
                ->set_subject('Payment Log')->display_as('id_customer','Customer name')->display_as('id_payment_method','Payment method')
                ->set_relation('id_customer', 'customer', 'name')
                ->set_relation('id_payment_method', 'payment_method', 'name_payment_method')
                ->order_by('id_customer', 'asc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Advance payment log';
        $this->load->view($this->config->item('ADMIN_THEME') . 'advance_payment/payment_log', $data);
    }
    
    function test($id_customer, $amount){
            $this->Advance_payment_model->payment_reduce($id_customer, $amount) or die('failed');
    }

}
