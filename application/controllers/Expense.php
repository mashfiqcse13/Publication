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
        $crud->fields('id_name_expense','amount_expense','date_expense','stock_memo','stock_quantity','description_expense');
        $crud->display_as('id_name_expense','Expense Name');
        $crud->set_relation('id_name_expense', 'expense_name', 'name_expense');
       
        
        $crud->callback_before_insert(array($this,'callback_before_insert_or_update_extra_field'));
        $crud->callback_before_update(array($this,'callback_before_insert_or_update_extra_field'));
       
        $crud->unset_columns('stock_memo','stock_quantity');  
       
        $crud->callback_add_field('date_expense', function(){
           return '<input id="field-date_expense" name="date_expense" type="text" value="'.date('Y-m-d h:i:u').'" >'
                   . '<style>div#date_expense_field_box {display: none;}</style>';
           
       });
       
       
        $crud->unset_edit();
        //$crud->unset_delete();
            $crud->callback_after_insert(array($this, 'cash_delete'));
            $crud->callback_before_delete(array($this,'cash_add'));
            //$crud->callback_before_update(array($this,'cash_update'));
            
          
        $crud->order_by('id_name_expense','desc');
        
        
        $this->load->model('expense_model');
        $date_range = $this->input->post('date_range');
        
        if ($date_range != '') {
            $data['report']=$this->expense_model->expense_report($date_range);
        }else{
           $output = $crud->render();
        $data['glosary'] = $output;
        }
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Expense';
        $this->load->view($this->config->item('ADMIN_THEME') . 'expense/expense', $data);
    }
    
    function callback_before_insert_or_update_extra_field($post_array, $primary_key = null){
        $this->load->model('misc/stationary_stock');
        
        $id_name_expense=$post_array['id_name_expense'];
        $amount=$post_array['amount_expense'];
        $memo=$post_array['stock_memo'];
        $quantity=$post_array['stock_quantity'];
        
        $this->db->where('id_name_expense',$id_name_expense);
        $check=$this->db->get('expense_name');
        foreach($check->result() as $row){
            $stock_item = $row->is_stock_item;
        }
                
        if($stock_item==1){ 
            $data=array(
                'id_name_expense' => $id_name_expense,
                'date_received' => date('Y-m-d h:i'),
                'memo_number' => $memo,
                'quantity' => $quantity
            );
            $this->db->insert('stationary_stock_register', $data); 
       }
        $this->stationary_stock->add($id_name_expense,$quantity);
       
        
        unset($post_array['stock_memo'],$post_array['stock_quantity']);
        
        return $post_array;
        }

        
    
    function cash_delete($post_array){
        
        $this->load->model('misc/cash');
        $values = $this->input->post('amount_expense');        
           
            $this->cash->reduce($values);
            return true;
        }
        
     function cash_add($primary_key){
        $this->load->model('misc/stationary_stock');
        $this->load->model('misc/cash');
        $this->db->where('id_expense',$primary_key);
        $value=$this->db->get('expense');
        foreach($value->result() as $row){
            $values=$row->amount_expense;
            $id_name_expense=$row->id_name_expense;
        }
        $this->cash->reduce_revert($values);
        $this->stationary_stock->add_revert($id_name_expense,$values);
        
        return true;
        }
    

        
    function expense_name() {
        $crud = new grocery_CRUD();
        $crud->set_table('expense_name');
        $crud->display_as('id_category_expense','Expense category');
        $crud->set_relation('id_category_expense', 'expense_category', 'name_category_expense');
        
        $crud->field_type('status_name_expense', 'hidden');
        
        $crud->callback_add_field('is_stock_item', function () {
        return '<input type="radio" value="1" name="is_stock_item"> Yes '
            . '<input type="radio" value="2" name="is_stock_item"> No';
    });
      $crud->callback_add_field('status_name_expense', function () {
        return '<input type="radio" value="1" name="status_name_expense" checked> Yes '
            . '<input type="radio" value="2" name="status_name_expense"> No';
    });
    $crud->callback_add_field('status_name_expense', function(){
           return '<style>div#status_name_expense_field_box {display: none;}</style>';
       });
        
       $crud->callback_column('is_stock_item',array($this,'_yes_no_for_stock_item'));
       
       $crud->unset_columns('status_name_expense');

        
        
        
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Expense Name';
        $this->load->view($this->config->item('ADMIN_THEME') . 'expense/expense_name', $data);
    }
    
    function _yes_no_for_stock_item($value,$row){
        if($row->is_stock_item==1){
            $value='yes';
        }else{
            $value='no';
        }
        return $value;
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
