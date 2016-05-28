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
class Expense extends CI_Controller {
            
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
        $data['Title'] = 'Expense';
        
        $this->load->view($this->config->item('ADMIN_THEME').'expense/expense_dashboard', $data);
    }
    
    function expense() {
        $crud = new grocery_CRUD();
        $crud->set_table('expense');
        $crud->display_as('id_name_expense','Expense Name');
        $crud->set_relation('id_name_expense', 'expense_name', 'name_expense');
        
        
           
       
        $crud->unset_edit();
            $crud->callback_after_insert(array($this, 'cash_delete'));
            $crud->callback_before_delete(array($this,'cash_add'));
            
            
        
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Expense';
        $this->load->view($this->config->item('ADMIN_THEME') . 'expense/expense', $data);
    }
    
    function cash_delete($post_array){
        
        $this->load->model('misc/cash');
        $values = $this->input->post('amount_expense');        
           
            $this->cash->reduce($values);
            return true;
        }
        
     function cash_add($primary_key){
        
        $this->load->model('misc/cash');
        $this->db->where('id_expense',$primary_key);
        $value=$this->db->get('expense');
        foreach($value->result() as $row){
            $values=$row->amount_expense;
        }
        $this->cash->add($values);
        
        return true;
        }
    

        
    function expense_name() {
        $crud = new grocery_CRUD();
        $crud->set_table('expense_name');
        $crud->display_as('id_category_expense','Expense category');
        $crud->set_relation('id_category_expense', 'expense_category', 'name_category_expense');
        $crud->field_type('is_stock_item','enum',array('Yes','No'));
        $crud->field_type('status_name_expense','enum',array('Yes','No'));
        
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Expense Name';
        $this->load->view($this->config->item('ADMIN_THEME') . 'expense/expense_name', $data);
    }
    
    function expense_category() {
        $crud = new grocery_CRUD();
        $crud->set_table('expense_category');
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Expense Category';
        $this->load->view($this->config->item('ADMIN_THEME') . 'expense/expense_category', $data);
    }
    
}
