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
define('BOOK_MANAGEMENT', 'index.php/Admin/manage_book');
define('CONTACT_MANAGEMENT', 'index.php/Admin/manage_contact');
define('STOCK_MANAGEMENT', 'index.php/Admin/manage_stock');
define('PAYMENT_MANAGEMENT', 'index.php/Admin/manage_payment');
define('THEME_ASSET', 'asset/Admin_theme/AdminLTE/');


class Admin extends CI_Controller{
    //put your code here
    
    function index(){
        $data['theme_asset_url'] = base_url().THEME_ASSET;
        $data['base_url']=base_url();
        $this->load->view('Admin_theme/AdminLTE/dashboard',$data);
    }
    
    function manage_book(){
        $data['theme_asset_url'] = base_url().THEME_ASSET;
        $data['base_url']=base_url();
        $this->load->view('Admin_theme/AdminLTE/manage_book',$data);
    }
    
        function manage_contact(){
        $data['theme_asset_url'] = base_url().THEME_ASSET;
        $this->load->view('Admin_theme/AdminLTE/manage_contact',$data);
    }
    
        function manage_stock(){
        $data['theme_asset_url'] = base_url().THEME_ASSET;
        $this->load->view('Admin_theme/AdminLTE/manage_stock',$data);
    }
            
    function memo(){
        echo "memo";
    }
    
}
