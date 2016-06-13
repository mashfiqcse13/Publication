<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Production_process
 *
 * @author MD. Mashfiq
 */
class Production_process extends CI_Controller {

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
        $this->load->model('Production_process_model');
    }

    function index() {
        $this->all_details();
    }

    function all_details($transfer = false) {
        $crud = new grocery_CRUD();
        $crud->set_table('pub_stock')->set_subject('Stock');
        $crud->set_relation('book_ID', 'pub_books', 'name');
        $crud->set_relation('printing_press_ID', 'pub_contacts', 'name');
//        $crud->set_relation('binding_store_ID', 'pub_contacts', 'name');
//
//        $crud->set_relation('sales_store_ID', 'pub_contacts', 'name');
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage production process';

        $data['scriptInline'] = '<script>
            jQuery(\'[data-StockId]\').click(function () {
                var stock_id = $(this).attr("data-StockId");
                var maxQuantity = $(this).attr("data-maxQuantity");
                //console.log(stock_id);
                jQuery(\'[name="stock_id_from"]\').val(stock_id);
                jQuery(\'[name="Quantity"]\').attr("max",maxQuantity);
            });
        </script>';
        $data['wearhouse_dropdown'] = $this->Production_process_model->get_wearhouse_dropdown();


        $data['printing_table'] = $this->Production_process_model->get_wearhouse_table();
        $data['binding_table'] = $this->Production_process_model->get_wearhouse_table('Binding Store');
        $data['store_table'] = $this->Production_process_model->get_wearhouse_table('Sales Store');
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/all_details', $data);
    }

    function add_stock($process = false) {
//         $crud = new grocery_CRUD();
//         $crud->set_table('pub_stock')->set_subject('Stock');
//         $crud->set_relation('book_ID', 'pub_books', 'name');
//         $crud->set_relation('printing_press_ID', 'pub_contacts', 'name');
// //        $crud->set_relation('binding_store_ID', 'pub_contacts', 'name');
// //        $crud->set_relation('sales_store_ID', 'pub_contacts', 'name');
//         $output = $crud->render();
//         $data['glosary'] = $output;
        //  'admin/ass_stock/true' aso ?

        $this->load->model('stock_manages');

        if ($process) {
            $book_id = $this->input->post('book_id');
            $printingpress_id = $this->input->post('printingpress_id');
            $quantity = $this->input->post('quantity');
            $this->stock_manages->append_new_stock($book_id, $printingpress_id, $quantity);
            redirect('admin/manage_stocks');
        }


        $data['bookname'] = $this->stock_manages->get_bookid_dropdown();
        $data['printingpress'] = $this->stock_manages->get_printingpress_dropdown();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Book';
        $this->load->view($this->config->item('ADMIN_THEME') . 'stock_manage', $data);
    }

}
