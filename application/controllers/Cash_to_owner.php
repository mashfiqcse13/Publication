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
class Cash_to_owner extends CI_Controller {

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
        $this->load->library('form_validation');
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(27);
    }

    function path_selector() {
        $super_user_id = $this->config->item('super_user_id');
        if ($super_user_id == $_SESSION['user_id']) {
            redirect('cash_to_bank');
        } else if ($this->User_access_model->if_user_has_permission(32)) {
            redirect('cash_to_bank');
        } else if ($this->User_access_model->if_user_has_permission(33)) {
            redirect('cash_to_bank/expense_adjustment');
        } else {
            redirect();
        }
    }

    function index() {
        $this->User_access_model->check_user_access(32, 'cash_to_bank/path_selector');
        $crud = new grocery_CRUD();
        $crud->set_table('cash_to_owner_register')
                ->set_subject('Cash to owner')->display_as('cash_amount', 'Transfered Amount')
                ->order_by('id_cash_to_owner_register', 'desc')
                ->unset_edit()
                ->unset_delete()
                ->unset_read();

        $output = $crud->render();
        $data['glosary'] = $output;


        $data['get_all_cash_info'] = $this->Cash_to_bank_model->get_all_cash_info();
        $btn = $this->input->post('submit');
        $amount = $this->input->post('transfered_amount');

        if ($btn && $amount > 0) {
            $this->Cash_to_bank_model->save_info_for_owner($_POST);

            $sdata['message'] = '<div class = "alert alert-success" id="message"><button type = "button" class = "close" data-dismiss = "alert"><i class = " fa fa-times"></i></button><p><strong><i class = "ace-icon fa fa-check"></i></strong> Transfer Complete!</p></div>';
            $this->session->set_userdata($sdata);
            redirect('cash_to_owner?message=success');
        }

        if ($btn && $amount == '') {
            $data['warning'] = 'Please Insert Amount';
        }

        $message = $this->input->get('message');
        if ($message) {
            $data['message'] = $message;
            $data['success'] = '<div class = "alert alert-success" id="message"><button type = "button" class = "close" data-dismiss = "alert"><i class = " fa fa-times"></i></button><p><strong><i class = "ace-icon fa fa-check"></i></strong> Transfer Complete!</p></div>';
        }


        $data['date_range'] = $this->input->get('date_range');
        $date = explode('-', $data['date_range']);
        if ($data['date_range'] != '') {
            $data['all_cash_to_owner_info_by_date'] = $this->Cash_to_bank_model->get_all_cash_to_owner_info_by_date($date[0], $date[1]);
//            echo '<pre>';
//            print_r($data['all_cash_to_owner_info_by_date']);
//            exit();
        }

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Cash to Owner';
        $this->load->view($this->config->item('ADMIN_THEME') . 'cash_to_bank/cash_to_owner', $data);
    }

}
