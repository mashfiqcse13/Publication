<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Due
 *
 * @author MD. Mashfiq
 */
class Due extends CI_Controller {

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
        $this->customer_due();
    }

    function customer_due() {
        $crud = new grocery_CRUD();
        $crud->set_table('customer_due')
                ->set_subject('Customer Due')
                ->set_relation('id_customer', 'customer', 'name')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Customer Due';
        $this->load->view($this->config->item('ADMIN_THEME') . 'due/customer_due_and_payment', $data);
    }

    function customer_payment() {
        $crud = new grocery_CRUD();
        $crud->set_table('customer_payment')
                ->set_subject('Customer Payment')
                ->set_relation('id_customer', 'customer', 'name')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Customer Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'due/customer_due_and_payment', $data);
    }

}
