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
       
    }
    
    function index(){
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage salary';
        
        $this->load->view($this->config->item('ADMIN_THEME').'income/income_dashboard', $data);
    }
    
    function income() {
        $crud = new grocery_CRUD();
        $crud->set_table('income');
        $crud->display_as('id_name_income','Income Name');
        $crud->set_relation('id_name_income', 'income_name', 'name_expense');
         //$crud->field_type('date_income', 'hidden');
        $crud->callback_add_field('date_income', function () {
            return '<input id="field-date_income" name="date_income" type="text" value="'.date('Y-m-d h:i:u').'" >'
                   . '<style>div#date_income_field_box{display: none;}</style>';
            
        });
        
        $crud->callback_before_insert(array($this, 'cash_add'));
        $crud->callback_before_delete(array($this, 'cash_delete'));
        //$crud->callback_before_update(array($this, 'cash_update'));
        
        $crud->unset_edit();
        
        
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Income';
        $this->load->view($this->config->item('ADMIN_THEME') . 'income/income', $data);
    }
        function cash_add($post_array){
        
        $this->load->model('misc/cash');
        $values = $this->input->post('amount_income');        
           
            $this->cash->add($values);
            return true;
        }
        function cash_update($post_array,$primary_key){
        
            $this->load->model('misc/cash');
            $amount_income = $this->input->post('amount_income'); 
            $this->db->where('id_income',$primary_key);
            $value=$this->db->get('income');
            
            foreach($value->result() as $row){
                $values=$row->amount_income;
            }
            
            $this->cash->reduce($values);                 
           
            $this->cash->add($amount_income);
            return true;
        }
        function cash_delete($primary_key){
        
            $this->load->model('misc/cash');
            $this->db->where('id_income',$primary_key);
            $value=$this->db->get('income');
            foreach($value->result() as $row){
                $values=$row->amount_income;
            }
            $this->cash->reduce($values);

            return true;
        }
    
    function income_name() {
        $crud = new grocery_CRUD();
        $crud->set_table('income_name');
        
         $crud->callback_add_field('status_name_expense', function () {
        return '<input type="radio" value="1" name="status_name_expense" checked> Yes '
            . '<input type="radio" value="2" name="status_name_expense"> No'
            .  '<style>div#status_name_expense_field_box {display: none;}</style>'  ;
        });
    
    
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Income Name';
        $this->load->view($this->config->item('ADMIN_THEME') . 'income/income_name', $data);
    }
    
    
}
