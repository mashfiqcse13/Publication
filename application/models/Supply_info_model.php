<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Supply_info_model
 *
 * @author sonjoy
 */
class Supply_info_model extends ci_model{
    //put your code here
    function save_info($tbl_name,$data){
        $this->db->insert($tbl_name,$data);
        return $this->db->insert_id();
    }
    
    function update_info($tbl_name, $condition ,$data, $id){
        $this->db->where($condition,$id);
        $this->db->update($tbl_name,$data);
        $this->db->select($condition);
        $this->db->from($tbl_name);
        $this->db->where($condition,$id);
        $query = $this->db->get();
        return $query->row();
        
    }
            
    function select_all($tbl_name){
        $this->db->select('*');
        $this->db->from($tbl_name);
        $query = $this->db->get();
        return $query->result();
    }
    
    function select_all_user_id($user_id){
        $this->db->select('id_technician');
        $this->db->from('technician');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
        return $query->row();
    }
    function select_all_by_technician_id(){
        $id = $this->session->userdata('technician_id');
        $this->db->select('id_technician');
        $this->db->from('supply_style_no');
        $this->db->where('id_technician',$id);
        $query = $this->db->get();
        return $query->row();
    }
//    ajax search
    function select_fit_name_by_fit_id($id){
        $this->db->select('*');
        $this->db->from('supply_fit_name');
        $this->db->where('id_supply_fit_name',$id);
        $query = $this->db->get();
        return $query->result(); 
    }
    
    function supply_info_by_supply_id($supply_id){
        $this->db->select('*');
        $this->db->from('supply_info');
        $this->db->join('supply_fit_register','supply_info.id_supply_info = supply_fit_register.id_supply_info','left');
        $this->db->where('supply_info.id_supply_info',$supply_id);
        $query = $this->db->get();
        return $query->result();
    }
}
