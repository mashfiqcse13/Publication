<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Due
 *
 * @author MD. Mashfiq
 */
class Due extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('Due_model');
        $this->load->model('Common');
    }

    function index() {
        $this->customer_due();
    }

    function customer_due() {
        $crud = new grocery_CRUD();
        $crud->set_table('customer_due')
                ->display_as('id_customer', 'Customer Name')
                ->set_subject('Customer Due')
                ->set_relation('id_customer', 'customer', 'name')
                ->unset_edit()
                ->unset_delete()
                ->unset_add()
                ->add_action('Add payment', '', '', 'fa fa-credit-card', function ($primary_key, $row) {
                    if ($row->total_due > 0) {
                        return site_url('due/make_payment/' . $row->id_customer);
                    } else {
                        return '#';
                    }
                });
                
        $data['customer_id'] = $this->input->get('customer');
        if ($data['customer_id'] != '') {
            $data['customer_dues'] = $this->Due_model->get_customer_due_info($data['customer_id']);
        }else{
        $output = $crud->render();
        $data['glosary'] = $output;
        }
        
        
        $data['customers'] = $this->Due_model->get_all_customers();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Customer Due';
//        echo '<pre>';print_r($data);exit();
        $this->load->view($this->config->item('ADMIN_THEME') . 'due/customer_due_and_payment', $data);
    }

    function customer_payment() {
        $crud = new grocery_CRUD();
        $crud->set_table('customer_payment')
                ->display_as('id_total_sales', 'Memo No')
                ->display_as('id_customer', 'Customer Name')
                ->set_subject('Customer Payment')
                ->set_relation('id_customer', 'customer', 'name')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Customer Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'due/customer_due_and_payment', $data);
    }

    function make_payment($customer_id = FALSE) {
        if (!$customer_id) {
            redirect('due/customer_due');
        }
        $amount = $this->input->post('amount');
        if (!empty($amount) && $amount > 0) {
            $this->load->model('misc/Customer_due_payment');
            $this->Customer_due_payment->add($customer_id, $amount);
            redirect('due/make_payment/' . $customer_id);
            die();
        }

        $this->load->model('misc/Customer_due');
        $data['due_detail_table'] = $this->Customer_due->due_detail_table($customer_id);
        $data['customer_name'] = $this->db->select('name')->where('id_customer', $customer_id)->get('customer')->result();
        $data['customer_name'] = $data['customer_name'][0]->name;
        $data['customer_total_due'] = $this->Customer_due->current_total_due($customer_id);

        if ($data['customer_total_due'] < 1) {
            redirect('due');
            die();
        }


        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Make Due Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'due/make_payment', $data);
    }

}
