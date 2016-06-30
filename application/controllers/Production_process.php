<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->process();
    }

    function process() {
        $crud = new grocery_CRUD();
        $crud->set_table('processes')
                ->set_subject('Production Process')->display_as('id_process_type', 'Process type')->display_as('id_item', 'Item Name')
                ->columns('id_processes', 'id_process_type', 'id_item', 'date_created', 'date_finished', 'order_quantity', 'actual_quantity', 'total_damaged_item', 'total_reject_item', 'total_missing_item', 'process_status')
                ->set_relation('id_item', 'items', 'name')->set_relation('id_process_type', 'process_type', 'process_type')->order_by('id_processes', 'desc')->add_fields('id_process_type', 'id_item', 'order_quantity')->required_fields('id_process_type', 'id_item', 'order_quantity')
                ->add_action('Steps', 'asdfads', 'google.com', 'btn', function ($primary_key, $row) {
                    return site_url('production_process/steps/' . $primary_key);
                })->callback_after_insert(function ($post_array, $primary_key) {
            $date_created = date('Y-m-d h:i:u');
            $this->db->query("UPDATE `processes` SET `date_created` = '$date_created' WHERE `processes`.`id_processes` = $primary_key;");
        })->callback_column('process_status', array($this->Production_process_model, 'process_status_decoder'))->unset_edit()->unset_read()->unset_delete();
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Production process';
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

    function steps($id_processes) {
        $data['id_processes'] = $id_processes;
        $data['process_detail_table'] = $this->Production_process_model->process_detail_table($id_processes);
        $data['process_steps_table'] = $this->Production_process_model->process_steps_table($id_processes);
        $data['vendor_dropdown'] = $this->Production_process_model->get_vendor_dropdown();
        $data['step_name_dropdown'] = $this->Production_process_model->get_step_name_dropdown();
        $data['id_processes'] = $id_processes;
        $data['process_status'] = $this->Production_process_model->get_process_status_by_process_step_id($id_processes);

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Process steps';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/steps', $data);
    }

    function add_step() {
        $id_processes = $this->input->post('id_processes');
        $id_vendor = $this->input->post('id_vendor');
        $id_step_name = $this->input->post('id_step_name');

        if (!empty($id_processes) && !empty($id_vendor) && !empty($id_step_name)) {
            $this->Production_process_model->add_process_step($id_processes, $id_vendor, $id_step_name);
        }
        redirect('production_process/steps/' . $id_processes);
    }

    function delete_step($id_processes, $id_process_steps) {
        $this->Production_process_model->delete_process_step($id_process_steps);
        redirect('production_process/steps/' . $id_processes);
    }

    function step_transfer($id_processes) {
        $id_process_step_from = $this->input->post('id_process_step_from');
        $amount_transfered = $this->input->post('amount_transfered');
        $rejected_amount = $this->input->post('rejected_amount');
        $damaged_amount = $this->input->post('damaged_amount');
        $missing_amount = $this->input->post('missing_amount');
        $amount_billed = $this->input->post('amount_billed');
        $amount_paid = $this->input->post('amount_paid');
        if (!empty($id_process_step_from) && !empty($amount_transfered) && $amount_transfered > 0 && !empty($amount_billed) && !empty($amount_paid)) {
            $this->Production_process_model->step_transfer($id_process_step_from, $amount_transfered, $rejected_amount, $damaged_amount, $missing_amount, $amount_billed, $amount_paid);
        }
        redirect('production_process/steps/' . $id_processes);
    }

}
