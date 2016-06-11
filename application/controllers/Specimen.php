<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Specimen
 *
 * @author MD. Mashfiq
 */
class Specimen extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('Sales_model');
        $this->load->model('Common');
        $this->load->model('Sales_model');
        $this->load->model('Specimen_model');
    }
    
    function index(){
        $this->new_entry();
    }
    
    function new_entry(){
        $data['customer_dropdown'] = $this->Sales_model->get_party_dropdown();
        $data['item_dropdown'] = $this->Sales_model->get_available_item_dropdown();
        $data['customer_due'] = $this->Sales_model->get_party_due();
        $data['item_details'] = $this->Sales_model->get_item_details();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New sale';
        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/new_entry_form', $data);
    }

}
