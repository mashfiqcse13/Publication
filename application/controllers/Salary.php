<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Accounting
 *
 * @author MD. Mashfiq
 */
class Salary extends CI_Controller {

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
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage salary';

        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_dashboard', $data);
    }

    function salary_payment() {
        $crud = new grocery_CRUD();
        $crud->set_table('salary_payment')
                ->set_subject('Salary Payment')
                ->display_as("id_employee", 'Employee Name')
                ->set_relation('id_employee', 'employee', "name_employee");
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_payment', $data);
    }

    function salary_advanced() {
        $crud = new grocery_CRUD();
        $crud->set_table('salary_advance')
                ->set_subject('Salary Advanced')
                ->display_as("id_employee", 'Employee Name')
                ->set_relation('id_employee', 'employee', "name_employee");
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Advance';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_advanced', $data);
    }

    function salary_bonus() {
        $crud = new grocery_CRUD();
        $crud->set_table('salary_bonus')
                ->set_subject('Salary Bonus')
                ->set_relation('id_salary_bonus_type', 'salary_bonus_type', "name_salary_bonus_type")
                ->set_relation('id_salary_payment', 'salary_payment', "id_salary_payment");
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Bonus';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_bonus', $data);
    }

    function salary_bonus_type() {
        $crud = new grocery_CRUD();
        $crud->set_table('salary_bonus_type')
                ->set_subject('Salary Bouns Type');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Bonus type';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_bonus_type', $data);
    }

}
