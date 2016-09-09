<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Party_advance
 *
 * @author sonjoy
 */
class Party_advance extends CI_Controller {

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
        $this->User_access_model->check_user_access(13);
    }

    function index() {
        $this->dashboard();
    }
    
    function dashboard(){
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Party Advance Dashboard';
        $this->load->view($this->config->item('ADMIN_THEME') . 'party_advance/party_advance_dashboard', $data);
    }

    function party_advnce_payment_register() {
        $crud = new grocery_CRUD();
        $crud->set_table('party_advance_payment_register');
        $crud->display_as('id_customer', 'Name Customer');
        $crud->set_relation('id_customer', 'customer', 'name');
        $crud->display_as('id_payment_method', 'Payment Method');
        $crud->set_relation('id_payment_method', 'payment_method', 'name_payment_method');
        $crud->callback_add_field('date_payment', function () {
            return '<input id="field-date_payment" name="date_payment" type="text" value="' . date('Y-m-d h:i:u') . '" >'
                    . '<style>div#date_payment_field_box{display: none;}</style>';
        });

        $crud->callback_before_insert(array($this, 'party_advance_add'));
        $crud->callback_before_delete(array($this, 'party_advance_delete'));
//        $crud->callback_before_update(array($this, 'party_advance_update'));
        $crud->unset_edit();
//        $crud->add_action('Add payment', '', '', 'fa fa-credit-card', function ($primary_key, $row) {
//                    if ($row->amount_paid > 0) {
//                        return site_url('due/make_payment/' . $row->id_customer);
//                    } else {
//                        return '#';
//                    }
//                });

        $output = $crud->render();
        $data['glosary'] = $output;
        
//        print_r($data);exit();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Party Advance Payment Register';
        $this->load->view($this->config->item('ADMIN_THEME') . 'party_advance/party_advance', $data);
    }

    function party_advance_add($post_array) {

        $this->load->model('party_advance_model');
        $values = $this->input->post('amount_paid');
        $customer_id = $this->input->post('id_customer');

        $this->party_advance_model->add($values,$customer_id);
        return true;
    }

    function party_advance_update($post_array, $primary_key) {

        $this->load->model('party_advance_model');
        $amount_income = $this->input->post('amount_paid');
        $customer_id = $this->input->post('id_customer');
        $this->db->where('id_party_advance_payment_register', $primary_key);
        $value = $this->db->get('party_advance_payment_register');
//        print_r($value);exit();
        foreach ($value->result() as $row) {
            $values = $row->amount_paid;
        }
        echo $values;
//        $this->party_advance_model->add($amount_income,$customer_id);
        
        $this->party_advance_model->reduce($values,$customer_id);

        
        return true;
    }

    function party_advance_delete($primary_key) {

        $this->load->model('party_advance_model');
        $this->db->where('id_party_advance_payment_register', $primary_key);
        $value = $this->db->get('party_advance_payment_register');
        foreach ($value->result() as $row) {
            $values = $row->amount_paid;
            $id_customer = $row->id_customer;
        }
        $this->party_advance_model->add_revert($values,$id_customer);

        return true;
    }

    function payment_method() {
        $crud = new grocery_CRUD();
        $crud->set_table('payment_method');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Payment Method';
        $this->load->view($this->config->item('ADMIN_THEME') . 'party_advance/payment_method', $data);
    }

}
