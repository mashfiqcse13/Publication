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

    function index() {

        $date_range = $this->input->post('date_range');
        $btn = $this->input->post('btn_submit');

        $id_customer = $this->input->post('id_customer');
        $filter_district = $this->input->post('filter_district');


        if (isset($btn)) {
            $data['sold_book_info'] = $this->Sales_model->sold_book_info($id_customer, $date_range, $filter_district);

//            echo '<pre>';
//            print_r($data['table'] );
//            exit();

            if ($id_customer != '') {
                $data['name'] = $this->Sales_model->get_customer_name($id_customer);
            }
            $data['date_range'] = $date_range;
            $data['report_title'] = "বিক্রিত বইসমুহ";
        } else {
            $date_range = date('m/d/Y') . ' - ' . date('m/d/Y');
            $data['report_title'] = "আজকের বিক্রিত বইসমুহ";

            $data['sold_book_info'] = $this->Sales_model->sold_book_info($id_customer, $date_range);
        }
//        $data['customer_dropdown'] = $this->Sales_model->get_party_dropdown_as_customer();
        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();
        
        
        $districts = $this->config->item('districts_english');
        $districts[''] = "Select a district";
        $data['district_dropdown'] = form_dropdown('filter_district', $districts, $filter_district, 'class="form-control select2"');

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Sold Book Info';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sold_book_info/sold_book_info', $data);
    }

}
