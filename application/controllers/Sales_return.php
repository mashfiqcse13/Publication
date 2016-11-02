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
class Sales_return extends CI_Controller {

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
        $this->load->model('Sales_return_m');
        $this->load->model('Memo');
        $this->load->model('Sales_model');
        $this->load->library('session');
        $this->load->model('User_access_model');
        redirect('sales');
        $this->User_access_model->check_user_access(20);
    }

    function index() {

        $this->sales_current_sales_return();
    }

    function sales_return_dashboard() {
        $crud = new grocery_CRUD();
        $crud->set_table('sales_current_sales_return')->order_by('selection_ID', 'desc');
        $crud->columns('selection_ID', 'memo_ID', 'book_ID', 'stock_ID', 'quantity', 'total');
        $crud->display_as('book_ID', 'Book Name');
        $crud->set_relation('book_ID', 'items', 'name');
        $crud->order_by('selection_ID', 'desc');
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Sales Return Dashboard  ';
        $data['get_all_return_item'] = $this->Sales_return_m->get_all_return_item();
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales_return/sales_return_dashboard', $data);
    }

    function sales_current_sales_return() {


        $data['memo_dropdown'] = $this->Sales_return_m->memo_dropdown();

        if ($this->input->get('search_memo') == true) {
            $total_sales_id = $this->input->get('memo_id');
            $data['search_memo'] = $this->Sales_return_m->get_memos($total_sales_id);

            if ($data['search_memo'] == true) {
                $data['memo_header_details'] = $this->Sales_model->memo_header_details($total_sales_id);
                //$data['get_book_list'] = $this->Sales_model->memo_body_table($total_sales_id);


                $data['get_book_list'] = $this->Sales_return_m->get_book_list($total_sales_id);
                // $data['Book_selection_table'] = $this->Memo->memogenerat($memo_id);           
            }
        }

        $sales_return = $this->input->post('sales_return');

        if (isset($sales_return)) {

            $data['return_price'] = $this->Sales_return_m->insert_return_item($_POST);

            //$this->session->userdata('return_book_list')=$data['return_price'];    

            if ($data['return_price'] == True) {

                $id = $data['return_price'];
                $first_id = array_shift($id);
                $last_id = array_pop($id);

                if (empty($last_id)) {
                    $last_id = $first_id;
                }
                $data['list_item'] = $this->Sales_return_m->list_return_item($first_id, $last_id);
            }
        }




        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Current Sales Return';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales_return/sales_current_sales_return', $data);
    }

    function sales_current_total_sales_return() {
        $crud = new grocery_CRUD();
        $crud->set_table('sales_current_total_sales_return');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Current Total Sales Return';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales_return/sales_current_total_sales_return', $data);
    }

}
