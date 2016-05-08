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
class sales_return extends CI_Controller {
            
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
        $data['Title'] = 'Sales Return';
        
        $this->load->view($this->config->item('ADMIN_THEME').'sales_return/sales_return_dashboard', $data);
    }
    
    
    
    function sales_current_sales_return() {
        $crud = new grocery_CRUD();
        $crud->set_table('income_name');
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Loan Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales_return/sales_current_sales_return', $data);
    }
    
    
    function sales_current_total_sales_return() {
        $crud = new grocery_CRUD();
        $crud->set_table('income_name');
        $output = $crud->render();
        $data['glosary'] = $output;
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Loan Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales_return/sales_current_total_sales_return', $data);
    }
    
    
    
}