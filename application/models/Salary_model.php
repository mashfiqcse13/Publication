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
        $this->db->from('salary_payment','salary_advance');
        $this->db->join('salary_bonus', 'salary_payment.id_salary_payment = salary_bonus.id_salary_payment', 'left');
        $this->db->join('salary_advance', 'salary_payment.id_employee = salary_advance.id_employee', 'left');
        $this->db->join('loan', 'salary_payment.id_employee = loan.id_employee', 'left');
        $this->db->where('salary_payment.id_employee', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
//    function select_salary_advance_by_salary_id($id){
//        $this->db->select('*');
//        $this->db->from('salary_advance');
//        $this->db->where('id_employee', $id);
//        $query = $this->db->get();
//        return $query->result();
//    }

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
    
    function update_info($tbl_name, $condition ,$data, $id,$return_id){
        $this->db->where($condition,$id);
        $this->db->update($tbl_name,$data);
        $this->db->select($return_id);
        $this->db->from($tbl_name);
        $this->db->where($condition,$id);
        $query = $this->db->get();
        return $query->row();
        
    }
    
    function deduction_update($tbl_name, $condition ,$data, $id,$amount,$column,$return_id){
        $this->db->set($column,$amount);
        $this->db->where($condition,$id);
        $this->db->update($tbl_name,$data);
        $this->db->select($return_id);
        $this->db->from($tbl_name);
        $this->db->where($condition,$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function select_employee_salary($id){
         $sql = $this->db->query('SELECT  (SUM(basic)+SUM(medical)+SUM(house_rent)+SUM(transport_allowance)+SUM(lunch)) AS Total
 FROM employee_salary_info WHERE id_employee='.$id);
        return $sql->result();
    }
    
    function announce($id){
        $this->db->select('*');
        $this->db->from('salary_payment');
        $this->db->where('id_employee', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function bonus($id){
        $this->db->select('*');
        $this->db->from('salary_bonus');
        $this->db->where('id_salary_payment', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function select_bonus_amount($id){
         $this->db->select('amount');
        $this->db->from('salary_bonus_announce');
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
    
    function update_cash($tbl_name,$value){
        $this->db->query('UPDATE `cash` SET `balance`= `balance`-'.$value.', `total_out`=`total_out`+'.$value.' WHERE `id_cash`='. 1);
    }
    
    function  current_salary($month){
        $this->db->select('*');
        $this->db->from('salary_payment','salary_advance');
        $this->db->join('employee','employee.id_employee = salary_payment.id_employee','left');
        $this->db->join('salary_bonus', 'salary_payment.id_salary_payment = salary_bonus.id_salary_payment', 'left');
        $this->db->join('salary_advance', 'salary_payment.id_employee = salary_advance.id_employee', 'left');
        $this->db->where('month_salary_payment',$month);
        $query = $this->db->get();
        return $query->result();
    }
    
    function select_all_salary_of_employee(){
        $this->db->select('*');
        $this->db->from('salary_payment');
        $this->db->join('employee','employee.id_employee = salary_payment.id_employee','left');
        $query = $this->db->get();
        return $query->result();
    }
    
    function salary_advance_with_employee(){
        $this->db->select('*');
        $this->db->from('salary_advance');
        $this->db->join('employee','employee.id_employee = salary_advance.id_employee','left');
        $query = $this->db->get();
        return $query->result();
    }
//    search employee
    function salary_advance_by_employee_id($employee){
        $this->db->select('*');
        $this->db->from('salary_advance');
        $this->db->join('employee','employee.id_employee = salary_advance.id_employee','left');
        $this->db->where('salary_advance.id_employee',$employee);
        $query = $this->db->get();
        return $query->result();
    }
    function Salary_advance_by_date($from, $to){
        $this->db->select('*');
        $this->db->from('salary_advance');
        $this->db->join('employee','employee.id_employee = salary_advance.id_employee','left');
        $this->db->where('date_given_salary_advance >=', $from);
        $this->db->where('date_given_salary_advance <=', $to);
        $query = $this->db->get();
        return $query->result();
    }
    
    function select_all_paid_salary(){
     $sql =  $this->db->query('SELECT *, SUM(`amount_salary_payment`) AS total FROM `salary_payment` LEFT JOIN `employee`
ON `salary_payment`.`id_employee`=`employee`.`id_employee` WHERE `status_salary_payment` = 2 GROUP BY `date_salary_payment`');
//        $this->db->select('*','SUM(amount_salary_payment) AS total_salary');
//        $this->db->from('salary_payment');
//        $this->db->join('employee','employee.id_employee = salary_payment.id_employee','left');
//        $this->db->where('status_salary_payment',2);
//        $this->db->group_by('date_salary_payment');
//        $this->db->where('month_salary_payment','month_salary_payment');
        return $sql->result();
//        $query = $this->db->get();
//        return $query->result();
    }

}
