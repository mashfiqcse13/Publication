<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of Salary_model
 *
 * @author MD. Mashfiq
 */
class Salary_model extends CI_Model{
    //put your code here
    function select_all($tbl_name){
        $this->db->select('*');
        $this->db->from($tbl_name);
        $query = $this->db->get();
        return $query->result();
    }
    
    function save_info($tbl_name,$data){
        $this->db->insert($tbl_name,$data);
        return $this->db->insert_id();
    }
    
    function sum_salary($id){
        $sql = $this->db->query('SELECT  (SUM(basic)+SUM(medical)+SUM(house_rent)+SUM(transport_allowance)+SUM(lunch)) AS Total
 FROM employee_salary_info WHERE id='.$id);
//        $this->db->select_sum('basic','medical','house_rent'.'transport_allowance','lunch');
//        $this->db->from('employee_salary_info');
//        $this->db->where('id',$id);
//        $query = $this->db->get();
        return $sql->result();
    }
}
