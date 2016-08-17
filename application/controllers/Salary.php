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
//        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
//        $data['base_url'] = base_url();
//        $data['Title'] = 'Manage salary';
//
//        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_dashboard', $data);
        redirect('salary/current_salary_payment');
    }

    function employee_salary() {
        $id = $this->input->post('id_employee');
        $data['edit_salary'] = $this->Salary_model->select_salary_payment_by_salary_id($id);
//        echo '<pre>';print_r($data['edit_salary']);exit();
        echo json_encode($data);

//        return $data['salary_info'];
    }

    function salary_payment() {
        $crud = new grocery_CRUD();
        $crud->set_table('salary_payment')
                ->set_subject('Salary Payment')
                ->display_as("id_employee", 'Employee Name')
                ->display_as("amount_salary_payment", 'Total Amount of Salary')
                ->unset_delete()
                ->unset_edit()
                ->unset_read()
                ->callback_column('status_salary_payment', array($this, 'set_value'))
                ->callback_column('month_salary_payment', array($this, 'set_month'))
                ->set_relation('id_employee', 'employee', "name_employee")
                ->order_by('id_salary_payment', 'desc');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Payment';

//      
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $data['month'] = $month;
        $data['year'] = $year;
        if (isset($month) && isset($year)) {
            $data['all_salary_info'] = $this->Salary_model->select_all_info_by_month($month, $year);
        } else {
            $data['all_salary_info'] = $this->Salary_model->select_all_info();
        }

        $data['salary_payment'] = $this->Salary_model->select_all('salary_payment');
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/payment', $data);
    }

    function set_status_advance_salary($value) {
        if ($value == 1) {
            return'<b>Partial Paid</b>';
        }
        if ($value == 2) {
            return'<b>Full PAID</b>';
        }
    }

    function set_value($value) {
        if ($value == 1) {
            return'<b>ANNOUNCED</b>';
        }
        if ($value == 2) {
            return'<b>PAID</b>';
        }
        if ($value == 3) {
            return'<b>Error</b>';
        }
    }

    function set_month($value) {
        if ($value == 1) {
            return'<b>January</b>';
        }
        if ($value == 2) {
            return'<b>February</b>';
        }
        if ($value == 3) {
            return'<b>March</b>';
        }
        if ($value == 4) {
            return'<b>April</b>';
        }
        if ($value == 5) {
            return'<b>May</b>';
        }
        if ($value == 6) {
            return'<b>June</b>';
        }
        if ($value == 7) {
            return'<b>July</b>';
        }
        if ($value == 8) {
            return'<b>August</b>';
        }
        if ($value == 9) {
            return'<b>September</b>';
        }
        if ($value == 10) {
            return'<b>October</b>';
        }
        if ($value == 10) {
            return'<b>October</b>';
        }
        if ($value == 11) {
            return'<b>November</b>';
        }
        if ($value == 12) {
            return'<b>December</b>';
        }
    }

    function paid_salary_payment() {
//        echo '<pre>'; print_r($_POST);exit();
        $this->load->model('misc/cash', 'cash_model');
        $status = array();
        $status = $this->input->post('status');
        $count = max(array_keys($status));
        $salary = $this->input->post('amount_salary_payment');

        $loan_id = $this->input->post('id_loan');
        $advance_id = $this->input->post('id_salary_advance');
        $loan_payment = $this->input->post('paid_amount_loan_payment');
        $advance_amount = $this->input->post('amount_paid_salary_advance');


        $id = $this->input->post('id_employee');
//         echo '<pre>'; print_r($status);exit();
        for ($i = 0; $i <= $count; $i++) {
            if (!empty($status[$i])) {
//                echo '<pre>'; print_r($status[$i]);exit();
                for ($j = 0; $j < count($id); $j++) {

                    if ($status[$i] == $id[$j]) {
//        payment update
                        $data['date_salary_payment'] = date('Y-m-d H:i:s', now());
                        $data['status_salary_payment'] = 2;
                        $amount_salary = $salary[$j];
                        $payment_id = $this->Salary_model->deduction_update('salary_payment', 'id_employee', $data, $id[$j], $amount_salary, 'amount_salary_payment', 'id_salary_payment');
//                        $this->cash_model->add_revert($amount_salary);
//        bonus update
                        $bonus['status_bonus_payment'] = 2;
                        $bonus_id = $this->Salary_model->update_info('salary_bonus', 'id_salary_payment', $bonus, $payment_id->id_salary_payment, 'id_salary_bonus');
//        loan payment insert
//                     echo '<pre>'; print_r($loan_payment[$j]);exit();


                        if (!empty($loan_payment[$j])) {
                            $loan['id_loan'] = $loan_id[$j];
                            $loan['paid_amount_loan_payment'] = $loan_payment[$j];
                            $loan['payment_date_loan_payment'] = date('Y-m-d H:i:s', now());
                            $this->Salary_model->save_info('loan_payment', $loan);
                        }

                        if (!empty($advance_id[$j])) {
                            
                        }

                        if (!empty($advance_id[$j])) {
                            $advance_payment['id_salary_advance'] = $advance_id[$j];
                            $advance_payment['payment_date_salary_advance_payment'] = date('Y-m-d H:i:s', now());
                            $advance_payment['paid_amount_salary_advance_payment'] = $advance_amount[$j];
                            $this->Salary_model->save_info('salary_advance_payment', $advance_payment);
//                        update salary advance
                            $update_advance['amount_paid_salary_advance'] = $advance_amount[$j];
                            $update_advance['status_salary_advance'] = '2';
                            $this->Salary_model->update_advance($update_advance, $advance_amount[$j], $advance_id[$j]);

                            $this->Salary_model->advance_reduce($advance_amount[$j], $id[$j]);
                        }

                        if (empty($loan_payment[$j]) || empty($advance_id[$j])) {
//                            redirect('Salary/salary_payment');
                            break;
                        }
                    }
                }
            }
        }

        redirect('Salary/salary_payment');
    }

    function salary_announced($id = null) {
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $data['month'] = $month;
        $data['year'] = $year;
//        if (isset($month) && isset($year)) {
//            $data['employees'] = $this->Salary_model->select_all_employee_by_month_year($month, $year);
//        } else {
        $data['employees'] = $this->Salary_model->select_all_employee();
//        }
//        echo '<pre>';print_r($data['employees']);exit();
        $salary = $data['employees'];
        $data['bonus_type'] = $this->Salary_model->bonus_type();
//        echo '<pre>';print_r($data);exit();
//        after insert
        $data['edit_salary'] = $this->Salary_model->select_salary_payment_by_salary_id($id);

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Announcement';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_announced_list', $data);
    }

    //    save salary payment
    public function save_announced() {
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $announced = $this->input->post('status_salary_payment');
        $employee = $this->input->post('id_employee');
        $basic = $this->input->post('amount_salary_payment');
        $bonus = $this->input->post('bonus_type');
//        print_r($bonus);exit();
        for ($i = 0; $i < count($announced); $i++) {
            for ($j = 0; $j < count($employee); $j++) {
                if ($employee[$j] == $announced[$i]) {
                    $data['id_employee'] = $employee[$j];
                    $data['month_salary_payment'] = $month;
                    $data['year_salary_payment'] = $year;
                    $data['issue_salary_payment'] = date('Y-m-d H:i:s', now());
                    $data['amount_salary_payment'] = $basic[$j];
                    $data['status_salary_payment'] = 1;
                    $payment_id = $this->Salary_model->save_info('salary_payment', $data);

                    if ($bonus[$j] == 0) {
                        $info['id_salary_bonus_type'] = $bonus[$j];
                        $info['amount_salary_bonus'] = 0;
                        $info['id_salary_payment'] = $payment_id;
                        $this->Salary_model->save_info('salary_bonus', $info);
                    } else {
                        $amount = $this->Salary_model->select_bonus_amount($bonus[$j]);

                        if ($amount != null) {
                            $info['id_salary_bonus_type'] = $bonus[$j];
                            $info['amount_salary_bonus'] = $amount[0]->amount;
                            $info['id_salary_payment'] = $payment_id;
                            $this->Salary_model->save_info('salary_bonus', $info);
                        }
                    }
                }
            }
        }
        $sdata = array();
        $sdata['message'] = '<div class = "alert alert-success" id="msg"><button type = "button" class = "close" data-dismiss = "alert"><i class = " fa fa-times"></i></button><p><strong><i class = "ace-icon fa fa-check"></i></strong> Your Data is successfully Saved</p></div>';
        $this->session->set_userdata($sdata);
        redirect('Salary/salary_announced');
    }

    function salary_advanced() {
        $crud = new grocery_CRUD();
        $crud->set_table('salary_advance')
                ->set_subject('Salary Advanced')
                ->display_as("id_employee", 'Employee Name')
                ->display_as("status_salary_advance", 'Status of Salary')
                ->set_relation('id_employee', 'employee', "name_employee")
                ->callback_edit_field('date_given_salary_advance', function () {
                    return '<input id="field-date_given_salary_advance" name="date_given_salary_advance" type="text" value="' . date('Y-m-d h:i:u', now()) . '" >'
                            . '<style>div#date_given_salary_advance_field_box{display: none;}</style>';
                })->callback_edit_field('status_salary_advance', function () {
                    return '<select name="status_salary_advance">'
                            . '<option value="1">Active</option>'
                            . '<option value="2">Inactive</option>'
                            . '</select>';
//                    return '<input id="field-date_given_salary_advance" name="date_given_salary_advance" type="text" value="' . date('Y-m-d h:i:u', now()) . '" >'
//                            . '<style>div#date_given_salary_advance_field_box{display: none;}</style>';
                })->callback_column('status_salary_advance', array($this, 'set_status_advance_salary'))
                ->order_by('id_salary_advance', 'desc')
                ->unset_fields('amount_paid_salary_advance');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['employee_name'] = $this->Salary_model->get_employee_dropdown();
        $btn = $this->input->post('btn_submit');
        if (isset($btn)) {
            $this->Salary_model->save_advance($_POST);
            $sdata['message'] = '<div class = "alert alert-success" id="message"><button type = "button" class = "close" data-dismiss = "alert"><i class = " fa fa-times"></i></button><p><strong><i class = "ace-icon fa fa-check"></i></strong> Data is Successfully Updated!</p></div>';
            $this->session->set_userdata($sdata);
            redirect('salary/salary_advanced');
        }

//        employee search
        $employee = $this->input->get('employee');

//        date range
        $range = $this->input->get('date_range');
        $part = explode("-", $range . '-');
        $from = date('Y-m-d', strtotime($part[0]));
        $to = date('Y-m-d', strtotime($part[1]));
//        ---------------

        if ($employee != null) {
            $data['salaries_search'] = $this->Salary_model->salary_advance_by_employee_id($employee);
        } else if ($from != "1970-01-01") {

            $data['salaries_search'] = $this->Salary_model->Salary_advance_by_date($from, $to);
////            print_r($data);
        } else {
            $data['salaries'] = $this->Salary_model->salary_advance_with_employee();
        }

        $data['date_range'] = $range;
        $data['employee_info'] = $employee;
        $data['employees'] = $this->Salary_model->select_employee_salary_advance();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Advance';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_advanced', $data);
    }

    function salary_bonus_type() {
        $crud = new grocery_CRUD();
        $crud->set_table('salary_bonus_type')
                ->set_subject('Salary Bouns Type')
                ->order_by('id_salary_bonus_type', 'desc');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Bonus type';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_bonus_type', $data);
    }

    function salary_bonus_announcement() {
        $crud = new grocery_CRUD();
        $crud->set_table('salary_bonus_announce')
                ->set_subject('Salary Bonus Announce')
                ->display_as("id_salary_bonus_type", 'Bonus Type')
                ->set_relation('id_salary_bonus_type', 'salary_bonus_type', "name_salary_bonus_type")
                ->order_by('id_bonus_announce', 'desc');
        $crud->callback_add_field('date_announce', function () {
            return '<input id="field-date_announce" name="date_annouce" type="text" value="' . date('Y-m-d h:i:u', now()) . '" >'
                    . '<style>div#date_announce_field_box{display: none;}</style>';
        });
        $crud->callback_add_field('status', function () {
            return '<select name="status"> '
                    . '<option value="1">Active</option> '
                    . '<option value="2">Inctive</option> '
                    . '</select>';
        });
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Bonus Announce';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/salary_bonus_announce', $data);
    }

    function current_salary_payment() {
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $data['month'] = $month;
        $data['year'] = $year;
        if (isset($month)) {
            $data['all_salary_info'] = $this->Salary_model->select_all_info_by_month($month, $year);
        } else {
            $data['all_salary_info'] = $this->Salary_model->select_all_info();
        }

//        $data['current_salary'] = $this->Salary_model->current_salary($month);
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Salary Payslip';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/current_salary', $data);
    }

    function total_employee_paid() {
        $data['total_paid'] = $this->Salary_model->select_all_salary_of_employee();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Total Employee Salary';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/total_employee_paid', $data);
    }

    function total_salary_paid() {

//        date range
        $range = $this->input->get('date_range');
        $part = explode("-", $range . '-');
        $from = date('Y-m-d', strtotime($part[0]));
        $to = date('Y-m-d', strtotime($part[1]));
//        --------------
        if ($from != "1970-01-01") {

            $data['totals'] = $this->Salary_model->total_info_by_date($from, $to);
////            print_r($data);
        } else {
            $data['total_paid_salary'] = $this->Salary_model->select_all_paid_salary();
        }
        $data['date_range'] = $range;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Total Salary Paid';
        $this->load->view($this->config->item('ADMIN_THEME') . 'salary/total_salary_paid', $data);
    }

}
