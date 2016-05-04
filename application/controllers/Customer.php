<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Customer
 *
 * @author sonjoy
 */
class Customer extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->model('Customer_model');
        $this->load->library('grocery_CRUD');
    }
    function index(){
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Customer';
        
        $this->load->view($this->config->item('ADMIN_THEME').'customer/customer_dashboard', $data);
    }
    function customer_payment(){
//        $crud = new grocery_CRUD();
//        $crud->set_table('customer_due')
//                ->set_subject('Customer Payment');
//               // ->display_as("id_employee", 'Employee Name')
//                //->set_relation('id_employee', 'employee', "name_employee");
//        $output = $crud->render();
//        $data['glosary'] = $output;
        $data['employees'] = $this->Customer_model->select_all();
        $data['sales']=$this->Customer_model->sales_info();
      // echo '<pre>'; print_r($data['sales']);exit();
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Customer Payment';
        
        $this->load->view($this->config->item('ADMIN_THEME').'customer/customer_payment', $data);
    }
    
    function save_customer_payment(){
        $data['id_customer']=$this->input->post('id_customer');
        $data['paid_amount']=$this->input->post('paid_amount');
        $data['id_total_sales']=$this->input->post('id_total_sales');
        //echo '<pre>'; print_r($data);exit();
        $this->Customer_model->save_info($data);
        $this->Customer_model->update_customer_due($data['id_customer'],$data['paid_amount']);
        $this->Customer_model->update_cash($data['paid_amount']);
        $this->Customer_model->update_pub_memo($data['id_total_sales'],$data['paid_amount']);
        $sdata = array();
        $sdata['message'] = '<div class = "alert alert-success"><button type = "button" class = "close" data-dismiss = "alert"><i class = " fa fa-times"></i></button><p><strong><i class = "ace-icon fa fa-check"></i></strong> Your Data is successfully Saved</p></div>';
        $this->session->set_userdata($sdata);
        
        redirect('customer/customer_payment');
        
    }
}
