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
        $crud = new grocery_CRUD();
        $crud->set_table('processes')
                ->set_subject('Production Process')
                ->columns('id_processes', 'id_process_type', 'id_item', 'date_created', 'date_finished', 'order_quantity', 'actual_quantity', 'total_damaged_item', 'total_reject_item', 'total_missing_item', 'process_type_id_process_type')
                ->set_relation('id_item', 'items', 'name')->set_relation('id_process_type', 'process_type', 'process_type')
                ->order_by('id_processes', 'desc')->add_fields('id_process_type', 'id_item', 'order_quantity')
                ->unset_edit()
                ->unset_delete();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Sales';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/manage_list', $data);
    }

    function type() {
        $crud = new grocery_CRUD();
        $crud->set_table('process_type')
                ->set_subject('Production type');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Production type';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/manage_list', $data);
    }

    function vendor() {
        $crud = new grocery_CRUD();
        $crud->set_table('contact_vendor')
                ->set_subject('Vendor')->callback_add_field('division', array($this->Common, 'dropdown_division'))
                ->callback_edit_field('division', array($this->Common, 'dropdown_division'))
                ->callback_add_field('district', array($this->Common, 'dropdown_district'))
                ->callback_edit_field('district', array($this->Common, 'dropdown_district'))
                ->callback_add_field('upazila', array($this->Common, 'dropdown_upazila'))
                ->callback_edit_field('upazila', array($this->Common, 'dropdown_upazila'));
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Vendor';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/manage_list', $data);
    }

}
