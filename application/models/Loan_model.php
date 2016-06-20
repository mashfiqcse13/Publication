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
        $this->db->join('loan_payment', 'loan.id_loan = loan_payment.id_loan', 'left');
        $this->db->where('id_employee', $id);
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
    
    function loan_info_by_date($from,$to){
        $this->db->select('*');
        $this->db->from('loan');
        $this->db->join('employee', 'loan.id_employee = employee.id_employee', 'left');
        $this->db->where('date_taken_loan >=', $from);
        $this->db->where('date_taken_loan <=', $to);
        $query = $this->db->get();
        return $query->result();
    }
    
    function employee_loan_by_range($date) {
        $condition = "date_taken_loan BETWEEN " . "'" . $date['date1'] . "'" . " AND " . "'" . $date['date2'] . "'";;
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
   

}
