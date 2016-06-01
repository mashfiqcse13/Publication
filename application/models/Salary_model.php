<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Salary_model
 *
 * @author MD. Mashfiq
 */
class Salary_model extends CI_Model {

    //put your code here
    function select_all($tbl_name) {
        $this->db->select('*');
        $this->db->from($tbl_name);
        $query = $this->db->get();
        return $query->result();
    }

    function save_info($tbl_name, $data) {
        $this->db->insert($tbl_name, $data);
        return $this->db->insert_id();
    }

    function select_salary_payment_by_salary_id($id) {
        $this->db->select('*');
        $this->db->from('salary_payment');
        $this->db->join('salary_bonus', 'salary_payment.id_salary_payment = salary_bonus.id_salary_payment');
        $this->db->where('id_employee', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function select_all_salary_info($id) {
        $this->db->select('*');
        $this->db->from('employee_salary_info');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function select_all_employee() {
        $this->db->select('*');
        $this->db->from('employee');
        $this->db->join('employee_salary_info', 'employee.id_employee = employee_salary_info.id_employee');
        $query = $this->db->get();
        return $query->result();
    }
    
    function update_info($tbl_name, $data, $id){
        $this->db->where('id_employee',$id);
        $this->db->update($tbl_name,$data);
    }
    
    function select_employee_salary($id){
         $sql = $this->db->query('SELECT  (SUM(basic)+SUM(medical)+SUM(house_rent)+SUM(transport_allowance)+SUM(lunch)) AS Total
 FROM employee_salary_info WHERE id_employee='.$id);
        return $sql->result();
    }
    
    function announce($id){
        $this->db->select('id_employee');
        $this->db->from('salary_payment');
        $this->db->where('id_employee', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function select_bonus_amount($id){
         $this->db->select('amount');
        $this->db->from('bonus_amount');
        $this->db->where('id_salary_bonus_type', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function  employee_info(){
        $this->db->select('id_employee');
        $this->db->from('salary_payment');
        $query = $this->db->get();
        return $query->result();
    }
//    p

}
