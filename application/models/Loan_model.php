<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Loan_model
 *
 * @author sonjoy
 */
class Loan_model extends CI_Model {

    //put your code here
    function select_all($tbl_name) {
        $this->db->select('*');
        $this->db->from($tbl_name);
        $query = $this->db->get();
        return $query->result();
    }

    function select_loan_by_loan_id($id) {
        $this->db->select('*');
        $this->db->from('loan');
        $this->db->join('employee', 'loan.id_employee = employee.id_employee', 'left');
        $this->db->join('loan_payment', 'loan.id_loan = loan_payment.id_loan', 'left');

        $this->db->where('loan.id_employee', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function employee_loan() {
        $this->db->select('*');
        $this->db->from('loan');
        $this->db->join('employee', 'loan.id_employee = employee.id_employee', 'left');
        $this->db->join('loan_payment', 'loan.id_loan = loan_payment.id_loan', 'left');
        $this->db->where('loan.id_employee !=', null);
        $query = $this->db->get();
        return $query->result();
    }

    function loan_info() {
        $this->db->select('*');
        $this->db->from('loan');
        $this->db->join('employee', 'loan.id_employee = employee.id_employee', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function loan_info_by_status($status) {
        $this->db->select('*');
        $this->db->from('loan');
        $this->db->join('employee', 'loan.id_employee = employee.id_employee', 'left');
        $this->db->where('loan.status', $status);
        $query = $this->db->get();
        return $query->result();
    }

    function loan_info_by_employee($employee) {
        $this->db->select('*');
        $this->db->from('loan');
        $this->db->join('employee', 'loan.id_employee = employee.id_employee', 'left');
        $this->db->where('employee.id_employee', $employee);
        $query = $this->db->get();
        return $query->result();
    }

    function loan_info_by_date($from, $to) {
        $this->db->select('*');
        $this->db->from('loan');
        $this->db->join('employee', 'loan.id_employee = employee.id_employee', 'left');
        $this->db->where('date_taken_loan >=', $from);
        $this->db->where('date_taken_loan <=', $to);
        $query = $this->db->get();
        return $query->result();
    }

    function employee_loan_by_range($date) {
        $condition = "date_taken_loan BETWEEN " . "'" . $date['date1'] . "'" . " AND " . "'" . $date['date2'] . "'";
        ;
        $this->db->select('*');
        $this->db->from('loan');
        $this->db->join('employee', 'loan.id_employee = employee.id_employee', 'left');
        $this->db->join('loan_payment', 'loan.id_loan = loan_payment.id_loan', 'left');
        $this->db->where('loan.id_employee !=', null);
        $this->db->where($condition);
//        $this->db->where('date_taken_loan >=', $from);
//        $this->db->where('date_taken_loan <=', $to);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_employee_dropdown() {
        $items = $this->db->get('employee')->result();

        $data = array();
        $data[''] = 'Select Employee name';
        foreach ($items as $item) {
            $data[$item->id_employee] = $item->name_employee;
        }
        return form_dropdown('id_employee', $data, '', ' class="select2" ');
    }
    
    function save_loan($post_array){
         $current_month = date('m');
        $current_year = date('Y');
        $data['id_employee'] = $post_array['id_employee'];
        $data['title_loan'] = $post_array['title_loan'];
        $data['amount_loan'] = $post_array['amount_loan'];
        $amount = $data['amount_loan'];
        $data['date_taken_loan'] = date('Y-m-d H:i:s');
        $data['installment_amount_loan'] = $post_array['installment_amount_loan'];
        $data['status'] = 'paid';
        $data['dead_line_loan'] = date('Y-m-d H:i:s',strtotime($post_array['dead_line_loan']));
        $sql = 'SELECT * FROM `loan` WHERE `id_employee`= ' . $data['id_employee'] . ' AND MONTH(date_taken_loan) = ' . $current_month . ' AND YEAR(date_taken_loan) = ' . $current_year;
        $result = $this->db->query($sql)->result();
        if (empty($result)) {
            $this->db->insert('loan', $data);
            return true;
        } else {
            $id = $result[0]->id_loan;
            $update = "UPDATE `loan` SET `amount_loan` = `amount_loan` + $amount  WHERE `id_loan` = $id";
            $this->db->query($update);
            return true;
        }
    }

}
