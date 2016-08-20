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
        $this->load->model('Bank_model');
    }

    function index() {
        $this->customer_due();
    }

    function customer_due() {
        $crud = new grocery_CRUD();
        $crud->set_table('customer_due')->set_subject('Customer Due')
                ->display_as('id_customer', 'Customer Name')->set_relation('id_customer', 'customer', 'name')
                ->unset_edit()->unset_delete()->unset_add()->unset_read()
                ->columns('Customer ID', 'id_customer', 'total_due_billed', 'total_paid', 'total_due')
                ->callback_column('Customer ID', function ($value, $row) {
                    return $row->id_customer;
                })->add_action('Add payment', base_url() . "asset/img/button/add payment btn.png", '#', '', function ($primary_key, $row) {
            if ($row->total_due > 0) {
                return site_url('due/make_payment/' . $row->id_customer);
            } else {
                return '#';
            }
        });

        $data['customer_id'] = $this->input->get('customer');
        if ($data['customer_id'] != '') {
            $data['customer_dues'] = $this->Due_model->get_customer_due_info($data['customer_id']);
        } else {
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
        
        $data['customer_id'] = $this->input->get('customer');
        $data['date_range'] = $this->input->get('date_range');
//        print_r($data);exit();
        $dates = explode(' - ', $data['date_range']);
        if ($data['date_range'] == '') {
            $dates[0] = '';
            $dates[1] = '';
        }
        if ($data['date_range'] != '' || $data['customer_id'] != '') {
            $data['customer_due_payment'] = $this->Due_model->get_customer_due_payment_info($dates[0], $dates[1], $data['customer_id']);
//            print_r($data);
//            exit();
        }
        $crud = new grocery_CRUD();
        $crud->set_table('customer_payment')->display_as('id_total_sales', 'Memo No')
                ->display_as('id_customer', 'Customer Name')->set_subject('Customer Payment')
                ->set_relation('id_customer', 'customer', 'name')
                ->columns('Customer ID', 'id_customer', 'paid_amount', 'id_total_sales', 'payment_date')
                ->unset_edit()->unset_delete()->unset_add()->unset_read()
                ->callback_column('Customer ID', function ($value, $row) {
                    return $row->id_customer;
                })
                ->where('due_payment_status',1)
                ->order_by('id_customer_payment','desc');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['customers'] = $this->Due_model->get_all_customers();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Customer Due Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'due/customer_due_payment_log', $data);
    }

    function make_payment($customer_id = FALSE) {
        if (!$customer_id) {
            redirect('due/customer_due');
        }
         $this->load->model('misc/Customer_due');
        $data['customer_total_due'] = $this->Customer_due->current_total_due($customer_id);
        
        $amount = $this->input->post('amount');
        $bank_account_id=$this->input->post('id_account');
        $bank_amount=$this->input->post('bank_payment');
        $bank_check_no=$this->input->post("check_no");
        
        $total_amount=$amount+$bank_amount;
        
        $btn=$this->input->post('btn_submit');
        if(isset($btn)){
            
            if($total_amount > $data['customer_total_due']){
                $data['report_message'] = '<p class="alert alert-danger">Customer Due is lase then Total Amoutn(Bank+ Cash)</p>'; 
            }else{
            
            $this->load->model('misc/Customer_payment');
        
                $id_cash=0;
                $id_bank=0;
                
                if (!empty($amount) && $amount > 0) {
                    
                    $id_cash = $this->Customer_payment->due_payment($customer_id, $amount);
                    
                }
                 if (!empty($bank_amount) && $bank_amount > 0 && !empty($bank_check_no)) {
                     
                    $this->Bank_model->bank_transection($bank_account_id, 1, $bank_amount, $bank_check_no, 1);
                    
                    $id_bank = $this->Customer_payment->due_payment($customer_id, $bank_amount, 3);
                    
                }
                
                if($id_bank!=0 || $id_cash!=0){
                
                         $data['due_report_list'] = $this->Customer_payment->generate_due_report($id_cash,$id_bank);
                }else{
                    $data['report_message'] = '<p class="alert alert-danger">Please Pay Using Cash or Bank otpion Carefully</p>';
                }
            }
                
                
                
        }

       
        $data['bank_account_dropdown'] = $this->Bank_model->get_account_dropdown();
        $data['due_detail_table'] = $this->Customer_due->due_detail_table($customer_id);
        $data['customer_name'] = $this->db->select('name')->where('id_customer', $customer_id)->get('customer')->result();
        $data['customer_name'] = $data['customer_name'][0]->name;
        $data['customer_code'] = $customer_id;
        

//        if ($data['customer_total_due'] < 1) {
//            redirect('due');
//            die();
//        } 


        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Make Due Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'due/make_payment', $data);
    }

}
