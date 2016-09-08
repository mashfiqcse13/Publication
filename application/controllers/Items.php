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
        $super_user_id = $this->config->item('super_user_id');
        if($super_user_id != $_SESSION['user_id'] || $this->User_access_model->if_user_has_permission(10)){
            redirect();
            return 0;
        }
    }

    function index() {
        $crud = new grocery_CRUD();
        $crud->set_table('items')->set_subject('Items')->order_by('id_item', 'desc')
                ->columns('id_item', 'name', 'id_items_category', 'regular_price', 'sale_price')->display_as('id_item', 'ID')
                ->display_as('sale_price', 'Sale Price')->display_as('id_items_category', 'Category')
                ->set_relation('id_items_category', 'items_category', 'name');
        $crud->callback_add_field('catagory', function () {
            return form_dropdown('catagory', $this->config->item('book_categories'), '0');
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
    
    function category() {
        $crud = new grocery_CRUD();
        $crud->set_table('items_category')->set_subject('Items Category');
        
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Products';
        $this->load->view($this->config->item('ADMIN_THEME') . 'items/dashboard', $data);
    }

}
