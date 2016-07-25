<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Accounting
 *
 * @author MD. Mashfiq
 */
class Bank extends CI_Controller {

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
        $this->load->model('Bank_model');
        //$this->load->library('session');
        $this->load->library("pagination");
    }

    function index() {
        $crud = new grocery_CRUD();
        $crud->set_table('bank_balance');
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();

        // $crud->set_relation('id_account', 'bank_account', $related_title_field)
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Bank Balance';
        $this->load->view($this->config->item('ADMIN_THEME') . 'bank/bank_balance', $data);
    }

    function bank() {
        $crud = new grocery_CRUD();
        $crud->set_table('bank');

        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Bank Management';
        $this->load->view($this->config->item('ADMIN_THEME') . 'bank/bank', $data);
    }

    function bank_management() {
        $crud = new grocery_CRUD();
        $crud->set_table('bank_management');
        $crud->display_as('id_account', 'Account Name');
        $crud->display_as('id_transaction_type', 'Transaction type');
        $crud->display_as('media_link', 'Upload Document');
        //$crud->set_relation('id_account', 'bank_account', 'id_bank_account');
        $crud->set_relation('id_user', 'users', 'username');
        $crud->required_fields('id_account', 'amount_transaction');
        $crud->order_by('id_bank_management', 'desc');



        $crud->callback_add_field('id_user', function() {
            $userid = $_SESSION['user_id'];
            //$userid=$this->session->userdata('id');
            $username = $this->session->userdata('username');
            return $username . '<input id="field-id_user" class="form-control" name="id_user" type="hidden" value="' . $userid . '">';
        });

        $crud->callback_add_field('id_account', array($this->Bank_model, 'get_account_dropdown'));

        $crud->set_relation('id_transaction_type', 'bank_transaction_type', 'name_trnsaction_type');

        $crud->callback_column('id_account', array($this, '_bank_name_id'));

        $crud->set_field_upload('media_link', 'assets/uploads/files');

        $crud->callback_after_insert(array($this, 'add_status'));

//        $crud->callback_after_insert(array($this, 'balance_add'));
//        $crud->callback_before_delete(array($this,'balance_delete'));
        //$crud->unset_edit();
        $crud->unset_delete();

        $this->load->model('misc/bank_balance');

        $this->bank_balance->create_transaction_type();

        $data['transaction_type_dropdown'] = $this->bank_balance->transaction_type_dropdown();

        $data['account_dropdown'] = $this->bank_balance->account_dropdown();
        $data['user_dropdown'] = $this->bank_balance->user_dropdown();

        $date_range = $this->input->post('date_range');
        $user_id = $this->input->post('id');
        $bank_account = $this->input->post('id_bank_account');
        $transaction_type = $this->input->post('id_transaction_type');
        $btn = $this->input->post('btn_submit');
//        if ($date_range != '' || $user_id != '' || $bank_account != '' || $transaction_type != '') {
        if (isset($btn)) {
            $data['report'] = $this->bank_balance->bank_report($date_range, $user_id, $bank_account, $transaction_type);
        } else {
            $output = $crud->render();
            $data['glosary'] = $output;
        }






        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Bank Management';
        $this->load->view($this->config->item('ADMIN_THEME') . 'bank/bank_management', $data);
    }

    function bank_balance() {
        $crud = new grocery_CRUD();
        $crud->set_table('bank_balance');
        $crud->display_as('id_account', 'Account Name');

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();

        $crud->callback_column('id_account', array($this, '_bank_balance_name_id'));
        // $crud->set_relation('id_account', 'bank_account', $related_title_field)
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Bank Balance';
        $this->load->view($this->config->item('ADMIN_THEME') . 'bank/bank_balance', $data);
    }

    function _bank_balance_name_id($value, $row) {
        $sql = $this->db->query("SELECT name_bank,account_number FROM `bank_account` LEFT JOIN bank ON 
bank.id_bank=bank_account.id_bank where id_bank_account=$row->id_account");
        foreach ($sql->result() as $row) {
            return $row->name_bank . ' - ' . $row->account_number;
        }
    }

    function _bank_name_id($value, $row) {
        $sql = $this->db->query("SELECT name_bank,account_number FROM `bank_account` LEFT JOIN bank ON 
bank.id_bank=bank_account.id_bank where id_bank_account=$row->id_account");
        foreach ($sql->result() as $row) {
            return $row->name_bank . '-' . $row->account_number;
        }
    }

    function add_status($post_array, $primary_key) {

        $this->db->query("INSERT INTO `bank_management_status`(`id_bank_management`) VALUES ('$primary_key')");

        return true;
    }

//        
//     function balance_delete($primary_key){
//        
//        $this->load->model('misc/bank_balance');
//        $this->db->where('id_bank_management',$primary_key);
//        $value=$this->db->get('bank_management');
//        
//        foreach($value->result() as $row){
//            $amount=$row->amount_transaction;
//            $id=$row->id_account;
//            $transaction_type=$row->id_transaction_type;
//        }
//        
//        if($transaction_type==1){
//            $this->bank_balance->add_reverse($id,$amount);
//        }
//        if($transaction_type==2){
//            $this->bank_balance->reduce_reverse($id,$amount);
//        }
//        $this->db->query("DELETE FROM `bank_management_status` WHERE id_bank_management=$primary_key");
//        
//        return true;
//        }


    function bank_account() {
        $crud = new grocery_CRUD();
        $crud->set_table('bank_account');
        $crud->set_relation('id_bank', 'bank', 'name_bank');
        $crud->set_relation('id_account_type', 'bank_account_type', 'name_bank_account_type');
        $crud->display_as('id_bank', 'Bank Name');
        $crud->display_as('id_account_type', 'Account type');


        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Bank Account';
        $this->load->view($this->config->item('ADMIN_THEME') . 'bank/bank_account', $data);
    }

    function bank_account_type() {
        $crud = new grocery_CRUD();
        $crud->set_table('bank_account_type');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Bank Account Type';
        $this->load->view($this->config->item('ADMIN_THEME') . 'bank/bank_account_type', $data);
    }

    function bank_management_status() {
        $this->load->model('misc/bank_balance');

        $config = array();
        $config["base_url"] = base_url() . "index.php/bank/bank_management_status";
        $config["total_rows"] = $this->bank_balance->record_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';




        $this->load->model('misc/bank_balance');

        $data['transaction_type_dropdown'] = $this->bank_balance->transaction_type_dropdown();
        $data['account_dropdown'] = $this->bank_balance->account_dropdown();
        $data['user_dropdown'] = $this->bank_balance->user_dropdown();
        // $data['main_content'] = $this->bank_balance->list_bank_status();       

        $date_range = $this->input->post('date_range');
        $user_id = $this->input->post('id');
        $status_type = $this->input->post('status_type');
        $btn = $this->input->post('btn_submit');
        if (isset($btn)) {
            $data['report'] = $this->bank_balance->bank_status_report($date_range, $user_id, $status_type);
        } else {
            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["main_content"] = $this->bank_balance->
                    list_bank_status($config["per_page"], $page);
            $data["links"] = $this->pagination->create_links();
        }


        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Bank management status';
        $this->load->view($this->config->item('ADMIN_THEME') . 'bank/bank_management_status', $data);
    }

    function bank_transaction_type() {
        $crud = new grocery_CRUD();
        $crud->set_table('bank_transaction_type');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Bank Transaction Type';
        $this->load->view($this->config->item('ADMIN_THEME') . 'bank/bank_transaction_type', $data);
    }

    function balance_update($id, $amount, $transaction_type) {

        $this->load->model('misc/bank_balance');


        if ($transaction_type == 1) {
            $data = $this->bank_balance->add($id, $amount);
        } elseif ($transaction_type == 2) {
            $data = $this->bank_balance->reduce($id, $amount);
        }

        if ($data == true) {
            return true;
        } else {
            return false;
        }
    }

    function update_status() {
        $id = $this->input->post('id_management_status');
        $account_number = $this->input->post('account_number');
        $approved_by = $_SESSION['user_id'];
        $status = $this->input->post('approval_status');
        $amount = $this->input->post('amount_transaction');
        $transaction_type = $this->input->post('transaction_type');


        $car_date = date('Y-m-d h:i');
        $sql = $this->db->query("UPDATE `bank_management_status` "
                . "SET "
                . "`approval_status`='$status',"
                . "action_date='$car_date',"
                . "`approved_by`=$approved_by "
                . "WHERE `id_bank_management_status`=$id");


        if ($status == 1) {
            $return_data = $this->balance_update($account_number, $amount, $transaction_type);
            if ($return_data == true) {
                $data = '<span style="color:green">Approved</span>';
            } else {
                $status = '3';
                $sql = $this->db->query("UPDATE `bank_management_status` "
                        . "SET "
                        . "`approval_status`='$status',"
                        . "action_date='$car_date',"
                        . "`approved_by`=$approved_by "
                        . "WHERE `id_bank_management_status`=$id");

                $data = '<span style="color:red">Current Balance is less then withdraw amount</span>';
            }
        } elseif ($status == 2) {
            $data = '<span style="color:red">Canceled</span>';
        } else {
            $data = 'Pending';
        }
        echo json_encode($data);
    }

}
