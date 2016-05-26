<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author MD. Mashfiq
 */
class Items extends CI_Controller {

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
        $crud = new grocery_CRUD();
        $crud->set_table('items')->set_subject('Items')->order_by('id_item', 'desc')->display_as('sale_price', 'Sale Price');
        $crud->callback_add_field('catagory', function () {
            return form_dropdown('catagory', $this->config->item('book_categories'), '0');
        });
        $crud->callback_column('name', function ($value, $row) {
            return $row->name;
        });
        $crud->callback_add_field('storing_place', function () {
            return form_dropdown('storing_place', $this->config->item('storing_place'));
        });
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Products';
        $this->load->view($this->config->item('ADMIN_THEME') . 'items/dashboard', $data);
    }

}
