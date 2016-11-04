<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sale_edit
 *
 * @author sonjoy
 */
class Sale_edit extends CI_Controller {

    //put your code here
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
        $this->load->model('Sales_model');
        $this->load->model('sales/Sales_edit_model');
        $this->load->model('Bank_model');
        $this->load->model('Advance_payment_model');
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(3);
    }

    function update_sales($id_total_sales) {
        $data['bank_account_dropdown'] = $this->Bank_model->get_account_dropdown();
        $data['customer_current_balance'] = $this->Advance_payment_model->get_all_advance_payment_balance();

        $data['customer_dropdown'] = $this->Sales_model->get_party_dropdown();
        $data['item_dropdown'] = $this->Sales_model->get_available_item_dropdown();
        $data['customer_due'] = $this->Sales_model->get_party_due();
        $data['item_details'] = $this->Sales_model->get_item_details();
        $data['grab_data'] = $this->Sales_edit_model->grab_data($id_total_sales);
//        echo '<pre>';print_r($data['grab_data']['existing_memo_items']);exit();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Update sale';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/sales_edit/update_sales_form', $data);
    }

}
