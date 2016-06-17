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
class Sales_return extends CI_Controller {
            
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
        $this->load->model('Sales_return_m');
        $this->load->model('Memo');
        $this->load->model('Sales_model');
        
        
       
    }
    
    function index(){
        
        
        $crud = new grocery_CRUD();
        $crud->set_table('sales_current_sales_return')->order_by('selection_ID', 'desc');
        $crud->columns('selection_ID','memo_ID','book_ID','stock_ID','quantity','total'); 
         $crud->display_as('book_ID','Book Name');
         $crud->set_relation('book_ID','items','name');
         $crud->unset_add();
            $crud->unset_edit();
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Sales Return Dashboard  ';
        $data['get_all_return_item']=$this->Sales_return_m->get_all_return_item();
        $this->load->view($this->config->item('ADMIN_THEME').'sales_return/sales_return_dashboard', $data);
    }
    
    
    
    function sales_current_sales_return() {
        

        
        if($this->input->post('search_memo')==true){
           $total_sales_id=$this->input->post('memo_id');
           $data['search_memo']=$this->Sales_return_m->get_memos($total_sales_id);
           if($data['search_memo']==true){
                $data['memo_header_details'] = $this->Sales_model->memo_header_details($total_sales_id);
               //$data['get_book_list'] = $this->Sales_model->memo_body_table($total_sales_id);


                  $data['get_book_list']=$this->Sales_return_m->get_book_list($total_sales_id);
                 // $data['Book_selection_table'] = $this->Memo->memogenerat($memo_id);           
        }
        
           }
        
        if($this->input->post('sales_return')==true){
            
          $data['return_price'] =  $this->Sales_return_m->insert_return_item($_POST);
            
        }
        
        
        
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Current Sales Return';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales_return/sales_current_sales_return', $data);
    }
    

    
    function sales_current_total_sales_return() {
        $crud = new grocery_CRUD();
        $crud->set_table('sales_current_total_sales_return');
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Current Total Sales Return';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales_return/sales_current_total_sales_return', $data);
    }
    
    
    
}