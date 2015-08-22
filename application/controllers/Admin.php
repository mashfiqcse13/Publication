<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author MD. Mashfiq
 */

//define('DASHBOARD', "$baseurl");



class Admin extends CI_Controller{
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
    }
    
    function index(){
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $data['theme_asset_url'] = base_url(). $this->config->item('THEME_ASSET');
        $data['base_url']=base_url();
        $data['Title']='Dashboard';
        $this->load->view($this->config->item('ADMIN_THEME').'dashboard',$data);
    }
    
    function manage_book(){
        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['base_url']=base_url();
        $data['Title']='Manage Book';
        $this->load->view($this->config->item('ADMIN_THEME').'manage_book',$data);
    }
    
    function manage_contact(){
        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['base_url']=base_url();
        $data['Title']='Manage Contact';
        
        
        $this->load->view($this->config->item('ADMIN_THEME').'manage_contact',$data);
    }
    
    function manage_stock(){
        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['Title']='Manage Stock';
        $data['base_url']=base_url();
        
        $this->load->view($this->config->item('ADMIN_THEME').'manage_stock',$data);
    }


    function memo_generation(){
        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['Title']='Memo Generation';
        $data['base_url']=base_url();
        
        $this->load->view($this->config->item('ADMIN_THEME').'memo_generation',$data);
    }

     function memo_management(){
        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['Title']='Memo Management';
        $data['base_url']=base_url();
        
        $this->load->view($this->config->item('ADMIN_THEME').'memo_management',$data);
    }
    
}
