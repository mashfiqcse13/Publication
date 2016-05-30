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
        $this->load->model('Salary_model');
    }

    function index() {
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage salary';

        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_dashboard', $data);
    }

    function employee_salary() {
        $id = $this->input->post('id');
         $data['edit_salary'] = $this->Salary_model->select_salary_payment_by_salary_id($id);
        //echo '<pre>';print_r($data['salary_info']);exit();
        echo json_encode($data['edit_salary']);
//        return $data['salary_info'];
    }
    

    function salary_payment() {
        $crud = new grocery_CRUD();
        $crud->set_table('salary_payment')
        ->set_subject('Salary Payment')
        ->display_as("id_employee", 'Employee Name')
                ->callback_column('status_salary_payment',array($this,'set_value'))
                ->set_relation('id_employee', 'employee', "name_employee");
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Payment';

        $data['employees'] = $this->Salary_model->select_all('employee');

        // echo '<pre>';print_r($father[0]->father_name);exit();
        $id = $this->uri->segment(4);
        $data['edit_salary'] = $this->Salary_model->select_salary_payment_by_salary_id($id);
        
        //echo '<pre>';print_r($id);exit();
        $data['salary_payment'] = $this->Salary_model->select_all('salary_payment');
        //$data['salary_bonus'] = $this->Salary_model->select_all('salary_bonus_type');
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_payment', $data);
    }
    
   function set_value($value){
       if($value==1){
           return'<b>Announced</b>';
       }
       if($value==2){
           return'<b>Paid</b>';
       }
       if($value==3){
           return'<b>Error</b>';
       }
   }

    //    save salary payment
    public function save_announced() {
        
        $data['id_employee'] = $this->input->post('id_employee');
        //$data['salary_info'] = $this->Salary_model->sum_salary($data['id_employee']);
//        $salary = $data['salary_info'];
        $data['month_salary_payment'] = date('n',now());
        $data['year_salary_payment'] = date('Y',now());
        $data['issue_salary_payment'] = date('Y-m-d H:i:s',now());
        $data['amount_salary_payment'] = $this->input->post('amount_salary_payment')+$this->input->post('bonus_amount');
        $data['status_salary_payment'] = $this->input->post('status_salary_payment');
//        echo '<pre>';print_r($data);exit();
        $payment_id = $this->Salary_model->save_info('salary_payment', $data);

        $sdata = array();
        $sdata['message'] = '<div class = "alert alert-success" id="msg"><button type = "button" class = "close" data-dismiss = "alert"><i class = " fa fa-times"></i></button><p><strong><i class = "ace-icon fa fa-check"></i></strong> Your Data is successfully Saved</p></div>';
        $this->session->set_userdata($sdata);
        redirect('Salary/salary_announced');

//        $info['id_salary_bonus_type'] = $this->input->post('id_salary_bonus_type');
//        $info['id_salary_payment'] = $payment_id;
//        $info['amount_salary_bonus'] = $this->input->post('amount_salary_bonus');
//        if (!empty($info['id_salary_bonus_type']) && !empty($info['id_salary_payment']) && !empty($info['amount_salary_bonus'])) {
//            $this->Salary_model->save_info('salary_bonus', $info);
//        }
//
//        $sdata = array();
//        $sdata['message'] = '<div class = "alert alert-success"><button type = "button" class = "close" data-dismiss = "alert"><i class = " fa fa-times"></i></button><p><strong><i class = "ace-icon fa fa-check"></i></strong> Your Data is successfully Saved</p></div>';
//        $this->session->set_userdata($sdata);
//        redirect('Salary/salary_payment');
    }

    function paid_salary_payment(){
        $id = $this->input->post('id_salary_payment');
        $data['date_salary_payment'] = date('Y-m-d H:i:s',now());
        $data['status_salary_payment'] = 2;
        $payment_id = $this->Salary_model->update_info('salary_payment', $data, $id);
        redirect('Salary/salary_payment');
    }
    function update_salary_payment() {
        $id = $this->input->post('id_salary_payment');
        $data['date_salary_payment'] = date('y-m-d', strtotime($this->input->post('date_salary_payment')));
        $data['status_salary_payment'] = 2;
        $payment_id = $this->Salary_model->update_info('salary_payment', $data, $id);
        redirect('Salary/salary_payment');
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
    
    function salary_info() {
        $id = $this->input->post('id_employee');
         $data['info'] = $this->Salary_model->select_employee_salary($id);
         $salary = $data['info'];
        echo json_encode($salary[0]->Total);
    }
    
    function salary_announced($id = null){
        $data['employees'] = $this->Salary_model->select_all('employee');
        $data['salary_info'] = $this->Salary_model->select_all('employee_salary_info');
        $data['bonus_type'] = $this->Salary_model->select_all('salary_bonus_type');
//        echo '<pre>';print_r($data);exit();
        
        
//        after insert
        $data['edit_salary'] = $this->Salary_model->select_salary_payment_by_salary_id($id);
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Announced';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_announced_list', $data);
    }

}
