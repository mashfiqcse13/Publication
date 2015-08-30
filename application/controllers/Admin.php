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
        
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }

        $this->load->library('grocery_CRUD');
    }
    
    function index(){
        
        $data['theme_asset_url'] = base_url(). $this->config->item('THEME_ASSET');
        $data['base_url']=base_url();
        $data['Title']='Dashboard';
        $this->load->view($this->config->item('ADMIN_THEME').'dashboard',$data);
    }
    
    function manage_book(){
        
        $crud = new grocery_CRUD();
        $crud->set_table('pub_books')->set_subject('Book');
        $crud->callback_add_field('catagory', function () {
            return form_dropdown('catagory', $this->config->item('book_categories'),'0');
        });
        $crud->callback_add_field('storing_place', function () {
            return form_dropdown('storing_place', $this->config->item('storing_place'));
        });
        $output =  $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['base_url']=base_url();
        $data['Title']='Manage Book';
        $this->load->view($this->config->item('ADMIN_THEME').'manage_book',$data);
    }
    
    function manage_contact(){

        $crud = new grocery_CRUD();
        $crud->set_table('pub_contacts')->set_subject('Contact');
        $crud->callback_add_field('contact_type', function () {
            return form_dropdown('contact_type', $this->config->item('contact_type'));
        });
        $crud->callback_edit_field('contact_type', function ($value, $primary_key) {
            return form_dropdown('contact_type', $this->config->item('contact_type'),$value);
        });
        $output =  $crud->render();
        $data['glosary'] = $output;



        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['base_url']=base_url();
        $data['Title']='Manage Contact';
        
        
        $this->load->view($this->config->item('ADMIN_THEME').'manage_contact',$data);
    }


    function manage_stock(){
        
        $crud = new grocery_CRUD();
        $crud->set_table('pub_stock')->set_subject('Stock');
        
        $crud->set_relation('book_ID','pub_books','name');
        $crud->set_relation('printing_press_ID','pub_contacts','name');
        $crud->set_relation('binding_store_ID','pub_contacts','name');
        $crud->set_relation('sales_store_ID','pub_contacts','name');
        $output =  $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['base_url']=base_url();
        $data['Title']='Manage Book';
        $this->load->view($this->config->item('ADMIN_THEME').'stock_manage',$data);
    }
    

    function account(){
//        $this->load->model('custom/stock_manage');

        $this->load->model('account/account');
        $data['todaysell']=$this->account->todaysell();
        $data['monthly_sell']=$this->account->monthlysell();
        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['Title']='Account Information';
        $data['base_url']=base_url();
        
        $this->load->view($this->config->item('ADMIN_THEME').'account',$data);

 
    }




    function memo_generation(){
        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['Title']='Memo Generation';
        $data['base_url']=base_url();
        
        $this->load->view($this->config->item('ADMIN_THEME').'memo_generation',$data);
    }

     function memo_management(){
        $crud = new grocery_CRUD();

        $crud->set_table('pub_memos')
                ->set_subject('Memo')
                ->display_as('contact_ID','Party Name');
        $crud->set_relation('contact_ID','pub_contacts','name');
        $crud->callback_add_field('memo_serial', function () {
            $unique_id=uniqid();
            return '<label>'.$unique_id.'</label><input type="hidden" maxlength="50" value="'.$unique_id.'" name="memo_serial" >';
        });
        $crud->callback_add_field('sub_total', array($this,'add_book_selector_table'));
        $crud->callback_edit_field('sub_total', array($this,'edit_book_selector_table'));



        $crud->callback_after_insert(array($this, 'after_adding_memo'));
        

        $output = $crud->render();
        
//        $this->grocery_crud->set_table('pub_memos')->set_subject('Memo');
//        $output =  $this->grocery_crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url().$this->config->item('THEME_ASSET');
        $data['Title']='Memo Management';
        $data['base_url']=base_url();
        
        $this->load->view($this->config->item('ADMIN_THEME').'memo_management',$data);
    }

    function test(){

           $this->grocery_crud->set_table('pub_contacts');
        $output['some'] =  $this->grocery_crud->render();
        

        $this->load->view('Admin_theme/AdminLTE/test',$output);
    }
    
    function add_book_selector_table() {
            $this->load->library('table');
            // Getting Data
            $query = $this->db->query("SELECT * FROM `pub_books`");
            $data=array();
            foreach ($query->result_array() as $index => $row ){
                array_push($data, [$row['name'],
                            $row['price'],
                             '<input style="width: 100px;" data-index="'.$index.'" data-price="'.$row['price'].'" name="quantity['.$row['book_ID'].']" value="0" class="numeric form-control" type="number">'
                    . '     <input name="price['.$row['book_ID'].']" value="'.$row['price'].'" type="hidden">'
                            ]);
            }
            $this->table->set_heading('Book Name', 'Price', 'Quantity');

            //Setting table template
            $tmpl = array (
                'table_open'  => '<table class="table table-bordered table-striped">',
                'heading_cell_start'=>'<th class="success">'
            );
            $this->table->set_template($tmpl);

            $output ='<label>Select Book Quantity:</label><div style="overflow-y:scroll;max-height:200px;">
                    '.$this->table->generate($data).'</div>
                   <label>Sub Total :</label><span id="sub_total">0</span><span>Tk</span> <input type="hidden" maxlength="50  " name="sub_total">';
            return $output;
        }
        
    function edit_book_selector_table($value, $primary_key) {
            $this->load->library('table');
            // Getting Data
            $where = array('memo_ID' => $primary_key);
            $book_selection_query = $this->db->get_where('pub_memos_selected_books',$where );
            $book_selection = $book_selection_query->result_array();
            
            foreach ($book_selection as $index => $row ){
                $book_ID = $row['book_ID'];
                $quantity = $row['quantity'];
                $book_quantity_by_id[$book_ID] = $quantity ;
            }
            
            $query = $this->db->query("SELECT * FROM `pub_books`");
            $data=array();
            foreach ($query->result_array() as $index => $row ){
                array_push($data, [$row['name'],
                            $row['price'],
                             '<input style="width: 100px;" data-index="'.$index.'" data-price="'.$row['price'].'" name="quantity['.$row['book_ID'].']" value="'.$book_quantity_by_id[$row['book_ID']].'" class="numeric form-control" type="number">'
                    . '     <input name="price['.$row['book_ID'].']" value="'.$row['price'].'" type="hidden">'
                            ]);
            }
            $this->table->set_heading('Book Name', 'Price', 'Quantity');

            //Setting table template
            $tmpl = array (
                'table_open'  => '<table class="table table-bordered table-striped">',
                'heading_cell_start'=>'<th class="success">'
            );
            $this->table->set_template($tmpl);

            $output ='<label>Select Book Quantity:</label><div style="overflow-y:scroll;max-height:200px;">
                    '.$this->table->generate($data).'</div>
                   <label>Sub Total :</label><span id="sub_total">'.$value.'</span><span>Tk</span> <input type="hidden" maxlength="50  " name="sub_total">';
            return $output;
        }
        
        function after_adding_memo($post_array,$primary_key){
            foreach ($post_array['quantity'] as $index => $value){
                $book_ordered_quantity_insert = array(
                    "memo_ID" => $primary_key,
                    "book_ID" => $index,
                    "quantity" => $value,
                    "price_per_book" => $post_array['price'][$index],
                    "total" => $value * $post_array['price'][$index]
                );
    
                $this->db->insert('pub_memos_selected_books',$book_ordered_quantity_insert);
            }
            return TRUE;
        }

}
