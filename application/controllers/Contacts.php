<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Customer
 *
 * @author sonjoy
 */
class Contacts extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->model('Customer_model');
        $this->load->model('misc/Cash', 'cash_model');
        $this->load->library('grocery_CRUD');
    }

    function index() {
        $this->customer();
    }

    function teacher() {
        $crud = new grocery_CRUD();
        $crud->set_table('contact_teacher')
                ->set_subject('Teachers');
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Teachers';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

    function customer() {
        $crud = new grocery_CRUD();
        $crud->set_table('customer')
                ->set_subject('Customer');
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Customer';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

    function agents() {
        $crud = new grocery_CRUD();
        $crud->set_table('specimen_agent')
                ->set_subject('Agents');
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Agents';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

    function warehouses() {
        $crud = new grocery_CRUD();
        $crud->set_table('stock_warehouse')
                ->set_subject('Warehouses');
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Warehouses';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

}
