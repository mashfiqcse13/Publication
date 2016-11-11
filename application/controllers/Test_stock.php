<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is used for testing purpose only
 *
 * @author MD. Mashfiq
 */
class Test_stock extends CI_Controller {

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

    function index() {
        $this->load->model('Test_stock_model');
        
        $data['sales_item'] = $this->Test_stock_model->sales_item();
        $data['register_item'] = $this->Test_stock_model->stock_register_item();
        
        
        
        
        
        $this->load->view($this->config->item('ADMIN_THEME') . 'stock/test_stock', $data);

    }

}
