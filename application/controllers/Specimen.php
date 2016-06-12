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

    function index() {
        $this->new_entry();
    }

    function ajax_url() {
//        echo json_encode($_POST);
        $this->Specimen_model->processing_new_sales();
    }

    function new_entry() {
        $data['agent_dropdown'] = $this->Specimen_model->get_agent_dropdown();
        $data['item_dropdown'] = $this->Sales_model->get_available_item_dropdown();
        $data['item_details'] = $this->Sales_model->get_item_details();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New specimen entry';
        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/new_entry_form', $data);
    }

    function items($id_specimen_total = '') {
        $crud = new grocery_CRUD();
        $crud->set_table('specimen_items')
                ->set_subject('Specimen Items')
                ->display_as('specimen_items_id', 'ID')
                ->set_relation('id_item', 'items', 'name')
                ->order_by('specimen_items_id', 'desc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        if (!empty($id_specimen_total)) {
            $crud->where('id_specimen_total', $id_specimen_total);
        }

        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Teachers';
        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/manage_list', $data);
    }

    function tolal() {
        $crud = new grocery_CRUD();
        $crud->set_table('specimen_total')
                ->display_as('id_specimen_total', 'Specimen Total ID')
                ->display_as('id_agent', 'Customer Name')
                ->display_as('id_employee', 'Approved by')
                ->set_subject('Total speciment')
                ->display_as('id_agent', 'Customer Name')
                ->set_relation('id_agent', 'specimen_agent', 'name')
                ->set_relation('id_employee', 'users', 'username')
                ->order_by('id_specimen_total', 'desc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add()
                ->add_action('Print Memo', '', '', 'fa fa-print', function ($primary_key, $row) {
                    return site_url('specimen/items/' . $primary_key);
                });
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Total speciment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/manage_list', $data);
    }

}
