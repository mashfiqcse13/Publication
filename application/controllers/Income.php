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
class Income extends CI_Controller {

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
        $this->load->model('User_access_model');
        $super_user_id = $this->config->item('super_user_id');
        $this->User_access_model->check_user_access(9);
    }

    function index() {
        $this->income();
    }

    function income() {
        $crud = new grocery_CRUD();
        $crud->set_table('income');
        $crud->display_as('id_name_income', 'Income Name');
        $crud->set_relation('id_name_income', 'income_name', 'name_expense');
        $crud->display_as('amount_income', 'Amount Income');
        $crud->display_as('date_income', 'Date Income');
        $crud->display_as('description_income', 'Description Income');
        //$crud->field_type('date_income', 'hidden');
        $crud->callback_add_field('date_income', function () {
            return '<input id="field-date_income" name="date_income" type="text" value="' . date('Y-m-d h:i:u') . '" >'
                    . '<style>div#date_income_field_box{display: none;}</style>';
        });
        $crud->callback_add_field('amount_income', function () {
            return '<input id="field-amount_income" name="amount_income" type="text" value="" >'
                    . '<style>div#amount_income_field_box</style>';
        });
        $crud->order_by('id_income','desc');
        
        $crud->order_by('id_income','desc');
        
        $crud->callback_before_insert(array($this, 'cash_add'));
        $crud->callback_before_delete(array($this, 'cash_delete'));
        //$crud->callback_before_update(array($this, 'cash_update'));

        $crud->unset_edit();

        $this->load->model('income_model');
        $date_range = $this->input->post('date_range');
        $btn = $this->input->post('btn_submit');
        $data['date_range'] = $date_range;

        if (isset($btn)) {
           $data['income_report'] = $this->income_model->income_report($date_range);
                
//                $data['due']= $this->income_model->customer_due_report($date_range);
//                $data['sale_report'] = $this->income_model->sale_report($date_range);
//                $data['old_report'] = $this->income_model->old_report($date_range); 
                
                    
//            echo '<pre>';print_r($data['income_report'] );
        }else{
           $output = $crud->render();
            $data['glosary'] = $output;
        }



        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Income';
        $this->load->view($this->config->item('ADMIN_THEME') . 'income/income', $data);
    }

    function cash_add($post_array) { 
        
        $post_array['date_income'] = date('Y-m-d h:i:u');
        $this->load->model('misc/cash');
        $values = $this->input->post('amount_income');        
        $values = $this->Common->bn2enNumber ($values);
        $post_array['amount_income'] =  $values ;
        
        $this->cash->add($values);
//        print_r($post_array);exit();
        return $post_array;
    }

//        
    function cash_update($post_array, $primary_key) {

        $this->load->model('misc/cash');
        $amount_income = $this->input->post('amount_income');
        $this->db->where('id_income', $primary_key);
        $value = $this->db->get('income');

        foreach ($value->result() as $row) {
            $values = $row->amount_income;
        }

        $this->cash->reduce($values);

        $this->cash->add($amount_income);
        return true;
    }

    function cash_delete($primary_key) {

        $this->load->model('misc/cash');
        $this->db->where('id_income', $primary_key);
        $value = $this->db->get('income');
        foreach ($value->result() as $row) {
            $values = $row->amount_income;
        }
        $this->cash->add_revert($values);

        return true;
    }

    function income_name() {
        $crud = new grocery_CRUD();
        $crud->set_table('income_name');
        $crud->display_as('name_expense','Name Income');
        $crud->display_as('status_name_expense','Status Name Income');
        
         $crud->callback_add_field('status_name_expense', function () {
        return '<input type="radio" value="1" name="status_name_expense" checked> Yes '
            . '<input type="radio" value="2" name="status_name_expense"> No'
            .  '<style>div#status_name_expense_field_box {display: none;}</style>'  ;
        });
        $crud->order_by('id_name_income','desc');
        $crud->callback_column('status_name_expense',array($this,'_yes_no_for_income_name'));
        
        if ($this->uri->segment(4) == 1) {
            $crud->unset_delete()->unset_edit();
        }
        
        $crud->callback_column('status_name_expense', array($this, '_yes_no_for_income_name'));
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Income Name';
        $this->load->view($this->config->item('ADMIN_THEME') . 'income/income_name', $data);
    }

    function _yes_no_for_income_name($value, $row) {
        if ($row->status_name_expense == 1) {
            $value = 'yes';
        } else {
            $value = 'no';
        }
        return $value;
    }

}
