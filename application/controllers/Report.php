<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Report
 *
 * @author MD. Mashfiq
 */
class Report extends CI_Controller {

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
//        $this->load->model('Report_model');
    }

    function index() {
        $this->cash_box();
    }

    function cash_box() {
        $data['cash'] = $this->db->get('cash')->result();
        $data['cash'] = $data['cash'][0];
//        die(print_r($data));
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Cash in Hand';
        $this->load->view($this->config->item('ADMIN_THEME') . 'report/cash_box', $data);
    }

}
