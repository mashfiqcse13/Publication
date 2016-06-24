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
        $this->load->library('table');
    }

    function index() {
        $this->new_entry();
    }

    function ajax_url() {
//        echo json_encode($_POST);
        $this->Specimen_model->processing_new_specimen();
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

    function report() {
        $data['agent_dropdown'] = $this->Specimen_model->get_agent_dropdown_who_have_taken_specimen();
        $data['item_dropdown'] = $this->Specimen_model->get_item_dropdown_who_are_given_as_specimen();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Speciment Report';

        $data['id_agent'] = $this->input->post('id_agent');
        $data['id_item'] = $this->input->post('id_item');
        $data['date_range'] = $this->input->post('date_range');
        $data['report_asked'] = $this->input->post('report_asked');

        if (!empty($data['report_asked'])) {
            $data['report'] = $this->Specimen_model->get_report_table($data['id_agent'], $data['id_item'], $data['date_range']);
            $data['agent_name'] = $this->Specimen_model->get_agent_name_by($data['id_agent']) or
                    $data['agent_name'] = 'Any';
            $data['item_name'] = $this->Common->get_item_name_by($data['id_item']) or
                    $data['item_name'] = 'Any';
            $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/report_page', $data);
        } else {
            $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/report_filter', $data);
        }
    }

}
