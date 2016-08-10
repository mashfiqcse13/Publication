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
           
//            if($id_type!=''){
//                $data['id_type']=$id_type;
//            }
            $data['date_range']=$date_range;
            
        }
        $data['customer_dropdown'] = $this->Sales_model->get_party_dropdown_as_customer();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Sold Book Info';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/sold_book_info', $data);
    }
    
    
    
}
