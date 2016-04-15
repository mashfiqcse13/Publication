<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SalesReturn
 *
 * @author MD. Mashfiq
 */
class SalesReturn extends CI_Controller{
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
    
    function current_sates_return_insert(){
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Add returned book';
        $data['base_url'] = base_url();
        $this->load->view($this->config->item('ADMIN_THEME') . 'current_sates_return_insert', $data);
    }
}
