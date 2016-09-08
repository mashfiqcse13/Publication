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
class Accounting extends CI_Controller {
            
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
        $super_user_id = $this->config->item('super_user_id');
        if($super_user_id != $_SESSION['user_id'] || $this->User_access_model->if_user_has_permission(1)){
            redirect();
            return 0;
        }
       
    }
    
    function index(){
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Accounting';
        
        $this->load->view($this->config->item('ADMIN_THEME').'accounting/accounting-dashboard', $data);
    }
}
