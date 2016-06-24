<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Customer
 *
 * @author sonjoy
 */
class Contacts extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('misc/Cash', 'cash_model');
        $this->load->model('Contacts_model');
    }

    function index() {
        $this->customer();
    }

    function customer() {
        $crud = new grocery_CRUD();
        $crud->set_table('customer')->columns('id_customer', 'name', 'division', 'district', 'upazila', 'address', 'phone')
                ->display_as('id_customer', 'ID')->order_by('id_customer', 'desc')->display_as('name', 'Customer Name')->set_subject('Customer');

        $crud->callback_add_field('division', function () {
            return form_dropdown('division', $this->config->item('division'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('division', function ($value, $primary_key) {
            return form_dropdown('division', $this->config->item('division'), $value, 'class="form-control select2 dropdown-width" ');
        });
        $crud->callback_add_field('district', function () {
            return form_dropdown('district', $this->config->item('districts_english'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('district', function ($value, $primary_key) {
            return form_dropdown('district', $this->config->item('districts_english'), $value, 'class="form-control select2 dropdown-width" ');
        });

        $crud->callback_add_field('upazila', function () {
            return form_dropdown('upazila', $this->config->item('upazila_english'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('upazila', function ($value, $primary_key) {
            return form_dropdown('upazila', $this->config->item('upazila_english'), $value, 'class="form-control select2 dropdown-width" ');
        });

        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Customer';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

    function teacher() {
        $crud = new grocery_CRUD();
        $crud->set_table('contact_teacher')->columns('id_contact_teacher', 'name', 'division', 'district', 'upazila', 'address', 'designation', 'institute_name', 'subject', 'phone')
                ->display_as('id_contact_teacher', 'ID')->order_by('id_contact_teacher', 'desc')->set_subject('Teachers');

        $crud->callback_add_field('division', function () {
            return form_dropdown('division', $this->config->item('division'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('division', function ($value, $primary_key) {
            return form_dropdown('division', $this->config->item('division'), $value, 'class="form-control select2 dropdown-width" ');
        });
        $crud->callback_add_field('district', function () {
            return form_dropdown('district', $this->config->item('districts_english'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('district', function ($value, $primary_key) {
            return form_dropdown('district', $this->config->item('districts_english'), $value, 'class="form-control select2 dropdown-width" ');
        });

        $crud->callback_add_field('upazila', function () {
            return form_dropdown('upazila', $this->config->item('upazila_english'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('upazila', function ($value, $primary_key) {
            return form_dropdown('upazila', $this->config->item('upazila_english'), $value, 'class="form-control select2 dropdown-width" ');
        });


        $crud->callback_add_field('subject', function () {
            return form_dropdown('subject', $this->config->item('teacher_subject'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('subject', function ($value, $primary_key) {
            return form_dropdown('subject', $this->config->item('teacher_subject'), $value, 'class="form-control select2 dropdown-width" ');
        });


        $crud = $this->Contacts_model->set_filter($crud);
        $data['filter_elements'] = $this->Contacts_model->filter_elements();


        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Teachers';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_contact', $data);
    }

    function agents() {
        $crud = new grocery_CRUD();
        $crud->set_table('specimen_agent')->columns('id_agent', 'name', 'division', 'district', 'upazila', 'address', 'phone')
                ->display_as('id_agent', 'ID')->order_by('id_agent', 'desc')->display_as('name', 'Agent Name')->set_subject('Agents');


        $crud->callback_add_field('division', function () {
            return form_dropdown('division', $this->config->item('division'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('division', function ($value, $primary_key) {
            return form_dropdown('division', $this->config->item('division'), $value, 'class="form-control select2 dropdown-width" ');
        });
        $crud->callback_add_field('district', function () {
            return form_dropdown('district', $this->config->item('districts_english'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('district', function ($value, $primary_key) {
            return form_dropdown('district', $this->config->item('districts_english'), $value, 'class="form-control select2 dropdown-width" ');
        });

        $crud->callback_add_field('upazila', function () {
            return form_dropdown('upazila', $this->config->item('upazila_english'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('upazila', function ($value, $primary_key) {
            return form_dropdown('upazila', $this->config->item('upazila_english'), $value, 'class="form-control select2 dropdown-width" ');
        });

        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Agents';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

    function marketing_officer() {
        $crud = new grocery_CRUD();
        $crud->set_table('contact_marketing_officer')->columns('id_marketing_officer', 'name', 'division', 'district', 'upazila', 'address', 'phone')
                ->display_as('id_marketing_officer', 'ID')->order_by('id_marketing_officer', 'desc')->display_as('name', 'Officer Name')->set_subject('Officer');


        $crud->callback_add_field('division', function () {
            return form_dropdown('division', $this->config->item('division'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('division', function ($value, $primary_key) {
            return form_dropdown('division', $this->config->item('division'), $value, 'class="form-control select2 dropdown-width" ');
        });
        $crud->callback_add_field('district', function () {
            return form_dropdown('district', $this->config->item('districts_english'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('district', function ($value, $primary_key) {
            return form_dropdown('district', $this->config->item('districts_english'), $value, 'class="form-control select2 dropdown-width" ');
        });

        $crud->callback_add_field('upazila', function () {
            return form_dropdown('upazila', $this->config->item('upazila_english'), '', 'class="form-control select2 dropdown-width" ');
        })->callback_edit_field('upazila', function ($value, $primary_key) {
            return form_dropdown('upazila', $this->config->item('upazila_english'), $value, 'class="form-control select2 dropdown-width" ');
        });

        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Marketing Officer';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

}
