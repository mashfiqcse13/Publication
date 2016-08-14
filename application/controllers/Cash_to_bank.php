<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Case_to_bank
 *
 * @author sonjoy
 */
class Cash_to_bank extends CI_Controller{
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
        $this->load->model('Cash_to_bank_model');
    }
    
    function index(){
        $crud = new grocery_CRUD();
        $crud->set_table('cash_to_bank_register')
                ->set_subject('Cash to Bank Transaction')
                ->callback_column('id_bank_account',array($this,'bank_name'))
                ->unset_edit()
                ->unset_delete()
                ->unset_read();

        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['get_all_bank_info'] = $this->Cash_to_bank_model->get_all_bank_info();
        $data['get_all_cash_info'] = $this->Cash_to_bank_model->get_all_cash_info();
        $btn = $this->input->post('submit');
        if($btn){
            $this->Cash_to_bank_model->save_info($_POST);
            $sdata['message'] = '<div class = "alert alert-success" id="message"><button type = "button" class = "close" data-dismiss = "alert"><i class = " fa fa-times"></i></button><p><strong><i class = "ace-icon fa fa-check"></i></strong> Data is Successfully Inserted!</p></div>';
            $this->session->set_userdata($sdata);
            redirect('cash_to_bank');
        } 

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Cash to Bank Dashboard';
        $this->load->view($this->config->item('ADMIN_THEME') . 'cash_to_bank/dashboard', $data);
    }
    
    function bank_name($value){
       $bank = $this->Cash_to_bank_model->bank_name($value);
       return $bank->name_bank;
    }
    function cash_transfer(){
//        $crud = new grocery_CRUD();
//        $crud->set_table('cash_to_bank_register');
//
//        $output = $crud->render();
//        $data['glosary'] = $output;
        $data['get_all_bank_info'] = $this->Cash_to_bank_model->get_all_bank_info();
        $data['get_all_cash_info'] = $this->Cash_to_bank_model->get_all_cash_info();
        $btn = $this->input->post('submit');
        if($btn){
            $this->Cash_to_bank_model->save_info($_POST);
            $sdata['message'] = '<div class = "alert alert-success" id="message"><button type = "button" class = "close" data-dismiss = "alert"><i class = " fa fa-times"></i></button><p><strong><i class = "ace-icon fa fa-check"></i></strong> Data is Successfully Inserted!</p></div>';
            $this->session->set_userdata($sdata);
            redirect('cash_to_bank/cash_transfer');
        }        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Cash to Bank Transfer';
        $this->load->view($this->config->item('ADMIN_THEME') . 'cash_to_bank/cash_transfer', $data);
    }
}
