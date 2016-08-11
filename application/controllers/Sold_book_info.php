<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of sold book info
 *
 * @author rokibul
 */
class Sold_book_info extends CI_Controller {

     public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('Common');
        $this->load->model('Sales_model');
    }
    
    function index(){
                        
        $date_range = $this->input->post('date_range');  
        $btn=$this->input->post('btn_submit');
        
       $id_customer=$this->input->post('id_customer');
        
        
        if (isset($btn)) {
            $data['sold_info'] = $this->Sales_model->accurate_sale( $id_customer,$date_range);
            $data['old_book'] = $this->Sales_model->old_book_quantity($id_customer,$date_range);

            if($id_customer!=''){
                $data['id_customer']=$id_customer;
            }
            $data['date_range']=$date_range;
            
        }else{
            $date_range=date('m/d/Y').' - '.date('m/d/Y');
            
            $data['sold_info_today'] = $this->Sales_model->accurate_sale( $id_customer,$date_range);
            $data['old_book'] = $this->Sales_model->old_book_quantity($id_customer,$date_range);
//            echo '<pre>';
//            print_r($data['old_book']);
//            print_r($data['sold_info_today']);
            
            
        }
        $data['customer_dropdown'] = $this->Sales_model->get_party_dropdown_as_customer();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Sold Book Info';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/sold_book_info', $data);
    }
    
    
    
}
