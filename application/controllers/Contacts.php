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
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(4);
    }

    function index() {
        $super_user_id = $this->config->item('super_user_id');
        if ($super_user_id == $_SESSION['user_id']) {
            redirect('contacts/customer');
        } else if ($this->User_access_model->if_user_has_permission(29)) {
            redirect('contacts/customer');
        } else if ($this->User_access_model->if_user_has_permission(28)) {
            redirect('contacts/teacher');
        } else if ($this->User_access_model->if_user_has_permission(30)) {
            redirect('contacts/agents');
        } else if ($this->User_access_model->if_user_has_permission(31)) {
            redirect('contacts/marketing_officer');
        } else {
            redirect();
        }
    }

    function customer() {
        $this->User_access_model->check_user_access(29, 'contacts');
        $crud = new grocery_CRUD();
        $crud->set_table('customer')->columns('id_customer', 'name', 'division', 'district', 'upazila', 'address', 'phone')->unset_delete()
                ->display_as('id_customer', 'ID')->order_by('id_customer', 'desc')->display_as('name', 'Customer Name')->set_subject('Customer');

        $crud->callback_add_field('division', function () {
            return form_dropdown('division', $this->config->item('division'), '', 'class="form-control select2 dropdown-width" id="division"');
        })->callback_edit_field('division', function ($value, $primary_key) {
            return form_dropdown('division', $this->config->item('division'), $value, 'class="form-control select2 dropdown-width" id="division" ');
        });
        $crud->callback_add_field('district', function () {
            return form_dropdown('district', $this->config->item('districts_english'), '', 'class="form-control select2 dropdown-width district" id="dist"', 'equip_status_id');
        })->callback_edit_field('district', function ($value, $primary_key) {
            return form_dropdown('district', $this->config->item('districts_english'), $value, 'class="form-control select2 dropdown-width district" id="dist" ', 'equip_status_id');
        });

        $crud->callback_add_field('upazila', function () {
            return form_dropdown('upazila', $this->config->item('upazila_english'), '', 'class="form-control select2 dropdown-width upazila" ');
        })->callback_edit_field('upazila', function ($value, $primary_key) {
            return form_dropdown('upazila', $this->config->item('upazila_english'), $value, 'class="form-control select2 dropdown-width upazila" ');
        });

        //$crud->unset_add_fields('upazila');
        // $crud->unset_edit_fields('upazila');
//        $crud->unset_columns('upazila');

        $output = $crud->render();
        $data['glosary'] = $output;
        //$data['print']=$output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Customer';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

    function teacher() {
        $this->User_access_model->check_user_access(28, 'contacts');
        $crud = new grocery_CRUD();
        $crud->set_table('contact_teacher')->columns('id_contact_teacher', 'name', 'division', 'district', 'upazila', 'address', 'designation', 'institute_name', 'id_contact_teacher_sucject', 'phone')
                ->set_relation('id_contact_teacher_sucject', 'contact_teacher_sucject', 'subject_name')->unset_delete()
                ->display_as('id_contact_teacher', 'ID')->display_as('id_contact_teacher_sucject', 'Subject')->order_by('id_contact_teacher', 'desc')->set_subject('Teachers');

        $crud->callback_add_field('division', function () {
            return form_dropdown('division', $this->config->item('division'), '', 'class="form-control select2 dropdown-width" id="division" ');
        })->callback_edit_field('division', function ($value, $primary_key) {
            return form_dropdown('division', $this->config->item('division'), $value, 'class="form-control select2 dropdown-width" id="division"');
        });
        $crud->callback_add_field('district', function () {
            return form_dropdown('district', $this->config->item('districts_english'), '', 'class="form-control select2 dropdown-width district" ', 'equip_status_id');
        })->callback_edit_field('district', function ($value, $primary_key) {
            return form_dropdown('district', $this->config->item('districts_english'), $value, 'class="form-control select2 dropdown-width district" ', 'equip_status_id');
        });

        $crud->callback_add_field('upazila', function () {
            return form_dropdown('upazila', $this->config->item('upazila_english'), '', 'class="form-control select2 dropdown-width upazila" ');
        })->callback_edit_field('upazila', function ($value, $primary_key) {
            return form_dropdown('upazila', $this->config->item('upazila_english'), $value, 'class="form-control select2 dropdown-width upazila" ');
        });

        $crud = $this->Contacts_model->set_filter($crud);
        $data['filter_elements'] = $this->Contacts_model->filter_elements();

        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Teachers';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_contact_teacher', $data);
    }

    function teacher_sucject() {
        $this->User_access_model->check_user_access(28, 'contacts');
        $crud = new grocery_CRUD();
        $crud->set_table('contact_teacher_sucject')->unset_delete()->set_subject('Teacher Subject');


        $output = $crud->render();
        $data['glosary'] = $output;
        //$data['print']=$output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Teacher Subject';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

    function agents() {
        $this->User_access_model->check_user_access(30, 'contacts');
        $crud = new grocery_CRUD();
        $crud->set_table('specimen_agent')->columns('id_agent', 'name', 'division', 'district', 'upazila', 'address', 'phone')->where('type', 'Agent')
                ->display_as('id_agent', 'ID')->display_as('name', 'Agent Name')->set_subject('Agents')->order_by('id_agent', 'desc')->unset_delete()
                ->callback_before_insert(array($this->Contacts_model, 'agent_type_setter_post_array'))
                ->callback_before_update(array($this->Contacts_model, 'agent_type_setter_post_array'));


        $crud->callback_add_field('division', function () {
            return form_dropdown('division', $this->config->item('division'), '', 'class="form-control select2 dropdown-width" id="division"');
        })->callback_edit_field('division', function ($value, $primary_key) {
            return form_dropdown('division', $this->config->item('division'), $value, 'class="form-control select2 dropdown-width" id="division"');
        });
        $crud->callback_add_field('district', function () {
            return form_dropdown('district', $this->config->item('districts_english'), '', 'class="form-control select2 dropdown-width district" ', 'equip_status_id');
        })->callback_edit_field('district', function ($value, $primary_key) {
            return form_dropdown('district', $this->config->item('districts_english'), $value, 'class="form-control select2 dropdown-width district" ', 'equip_status_id');
        });

        $crud->callback_add_field('upazila', function () {
            return form_dropdown('upazila', $this->config->item('upazila_english'), '', 'class="form-control select2 dropdown-width upazila" ');
        })->callback_edit_field('upazila', function ($value, $primary_key) {
            return form_dropdown('upazila', $this->config->item('upazila_english'), $value, 'class="form-control select2 dropdown-width upazila" ');
        })->callback_add_field('type', function () {
            return "Agent";
        })->callback_edit_field('type', function ($value, $primary_key) {
            return "Agent";
        });


        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Agents';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

    function marketing_officer() {
        $this->User_access_model->check_user_access(31, 'contacts');
        $crud = new grocery_CRUD();
        $crud->set_table('specimen_agent')->columns('id_agent', 'name', 'division', 'district', 'upazila', 'address', 'phone')->where('type', 'Marketing Officer')
                ->display_as('id_agent', 'ID')->display_as('name', 'Officer Name')->set_subject('Officer')->order_by('id_agent', 'desc')->unset_delete()
                ->callback_before_insert(array($this->Contacts_model, 'marketing_officer_type_setter_post_array'))
                ->callback_before_update(array($this->Contacts_model, 'marketing_officer_type_setter_post_array'));

        $crud->callback_add_field('division', function () {
            return form_dropdown('division', $this->config->item('division'), '', 'class="form-control select2 dropdown-width" id="division"');
        })->callback_edit_field('division', function ($value, $primary_key) {
            return form_dropdown('division', $this->config->item('division'), $value, 'class="form-control select2 dropdown-width" id="division"');
        });
        $crud->callback_add_field('district', function () {
            return form_dropdown('district', $this->config->item('districts_english'), '', 'class="form-control select2 dropdown-width district" ', 'equip_status_id');
        })->callback_edit_field('district', function ($value, $primary_key) {
            return form_dropdown('district', $this->config->item('districts_english'), $value, 'class="form-control select2 dropdown-width district" ', 'equip_status_id');
        });

        $crud->callback_add_field('upazila', function () {
            return form_dropdown('upazila', $this->config->item('upazila_english'), '', 'class="form-control select2 dropdown-width upazila" ');
        })->callback_edit_field('upazila', function ($value, $primary_key) {
            return form_dropdown('upazila', $this->config->item('upazila_english'), $value, 'class="form-control select2 dropdown-width upazila" ');
        })->callback_add_field('type', function () {
            return "Marketing Office";
        })->callback_edit_field('type', function ($value, $primary_key) {
            return "Marketing Office";
        });


        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Marketing Officer';
        $this->load->view($this->config->item('ADMIN_THEME') . 'contacts/manage_list', $data);
    }

}
