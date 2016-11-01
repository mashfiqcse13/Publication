<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is used for testing purpose only
 *
 * @author MD. Mashfiq
 */
class Test extends CI_Controller {

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
        $this->load->model('misc/Cash');
//        $this->Cash->add(1000);
//        $this->Cash->reduce(3000) or die("Not enough balance");
        $this->load->model('misc/Customer_due');
        $this->load->model('sales/Sales_edit_model');
      
        
//        $this->Customer_due->add(4, 1000);
//        $this->Customer_due->reduce(4, 1000) or die("Not enough due");
        $this->load->model('sales/Sales_edit_model');
       
//        $data['existing_memo'] = $this->db->get_where( ' sales_total_sales ' , '`id_total_sales`=70 ')->result();
        
//        SELECT * FROM `sales` WHERE `id_total_sales`=70
                
//        $data['existing_items'] =  $this->db->get_where('sales' , ' `id_total_sales`=70 ')->result();
        
//        
        $grab_data = $this->Sales_edit_model->test_data();
//        $sales_update = $this->Sales_edit_model->sales_update($grab_data);
        $result = array_diff($array1, $array2);

        print_r($result);   
        
        echo '<pre>';
        print_r($grab_data); 
//        echo '</pre>';

        
        
    }

}
