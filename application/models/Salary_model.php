<?php

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
}
