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
class Admin extends CI_Controller{
    //put your code here
    
    function index(){
        $data['theme_asset_url'] = base_url().'asset/Admin_theme/AdminLTE/';
        $this->load->view('Admin_theme/AdminLTE/dashboard',$data);
    }
            
    function memo(){
        echo "memo";
    }
    
}
