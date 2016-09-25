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
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(26);
    }
    
    function index(){
                        
        $date_range = $this->input->post('date_range');  
        $btn=$this->input->post('btn_submit');
        
       $id_customer=$this->input->post('id_customer');
        
        
        if (isset($btn)) {
            $data['sold_info'] = $this->Sales_model->accurate_sale( $id_customer,$date_range);
            $data['return_book']=$this->Sales_model->return_book($id_customer,$date_range);
            $data['old_book'] = $this->Sales_model->old_book_quantity($id_customer,$date_range);
            $data['table'] = $this->marge_report_sale_return_old($data['sold_info'],$data['return_book'] ,$data['old_book']  );
            
//            echo '<pre>';
//            
//            print_r($data['table'] );
//            print_r($data['return_book']);
//            print_r($data['marge']);

            if($id_customer!=''){
                $data['name']=$this->Sales_model->get_customer_name($id_customer);
            }
            $data['date_range']=$date_range;
            
        }else{
            $date_range=date('m/d/Y').' - '.date('m/d/Y');
            
            $data['sold_info'] = $this->Sales_model->accurate_sale( $id_customer,$date_range);
            $data['return_book']=$this->Sales_model->return_book($id_customer,$date_range);
            $data['old_book'] = $this->Sales_model->old_book_quantity($id_customer,$date_range);
            
            $data['table_today'] = $this->marge_report_sale_return_old($data['sold_info'],$data['return_book'] ,$data['old_book']  );
            
//            echo '<pre>';
//            print_r($data['old_book']);
//            print_r($data['sold_info_today']);
            
            
        }
        $data['customer_dropdown'] = $this->Sales_model->get_party_dropdown_as_customer();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Sold Book Info';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sold_book_info/sold_book_info', $data);
    }
    
    function marge_report_sale_return_old( $sold_info,$return_book,$old_book){
        $data['sold_info'] = $sold_info;
        $data['return_book'] = $return_book;
        $data['old_book'] =$old_book; 
        $table=array();
            
            foreach($data['sold_info'] as $key1 => $val1){   
                        $table[$key1] ['id_item'] = $val1->id_item;
                        $table[$key1]['name'] = $val1->name;
                        $table[$key1]['sale_quantity'] = $val1->sales_quantity;
                        $table[$key1]['return_quantity'] = 0;
                        $table[$key1]['old_quantity'] = 0;
              
                        foreach($data['return_book'] as $key2 => $val2){

                                                foreach($data['old_book'] as $key3 => $val3){
                                                        if($val1->id_item==$val3->id_item){                         
                                                                 $table[$key1]['old_quantity'] = $val3->old_quantity;
                                                        }else{
                                                                $table[$key1]['old_quantity'] = 0;
                                                        }                       

                                                }

                                                if($val1->id_item==$val2->id_item){                                                           
                                                           $table[$key1]['return_quantity'] = $val2->return_quantity;
                                                }else{
                                                             $table[$key1]['return_quantity'] = 0;
                                                }
                        }
                        
                        
                        
            }
            
            
           return  $table;
    }
    
    
    
}
