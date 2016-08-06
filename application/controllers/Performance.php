<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Performance extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('performance_model');
        
    }

    public function index() {
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Dashboard';
        $data['base_url'] = base_url();
        $this->load->view($this->config->item('ADMIN_THEME') . 'starter', $data);
//		$this->load->view('welcome_message');
    }
    
       public function technician() {
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Technician Performance';
        $data['technician_dropdown']=$this->performance_model->get_technician_dropdown();
        $data['base_url'] = base_url();
        $this->load->view($this->config->item('ADMIN_THEME') . 'performance_technician', $data);
//		$this->load->view('welcome_message');
    } 
}
