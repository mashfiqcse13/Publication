<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User_access_model
 *
 * @author sonjoy
 */
class User_access_model extends ci_model {

    //put your code here
    private $user_access_buffer = array();
    public function __construct() {
        parent::__construct();
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_access_area_permission', 'users.id = user_access_area_permission.user_id', 'left');
        $this->db->join('user_access_group', 'user_access_area_permission.id_user_access_group = user_access_group.id_user_access_group', 'left');
        $this->db->join('user_group_elements', 'user_access_group.id_user_access_group = user_group_elements.id_user_access_group', 'left');
        $this->db->join('user_access_area', 'user_group_elements.id_user_access_area = user_access_area.id_user_access_area', 'left');
        $this->user_access_buffer = $this->db->get()->result();
    }

    function generate_buffer() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_access_area_permission', 'users.id = user_access_area_permission.user_id', 'left');
        $this->db->join('user_access_group', 'user_access_area_permission.id_user_access_group = user_access_group.id_user_access_group', 'left');
        $this->db->join('user_group_elements', 'user_access_group.id_user_access_group = user_group_elements.id_user_access_group', 'left');
        $this->db->join('user_access_area', 'user_group_elements.id_user_access_area = user_access_area.id_user_access_area', 'left');
        $this->user_access_buffer = $this->db->get()->result();
//        foreach ($results as $result) {
//            $this->user_access_buffer['user_id'] = $result->user_id;
//            $this->user_access_buffer['access_area_id'] = $result->id_user_access_area;
////            return $this->user_access_buffer;
//        }
        echo '<pre>';
        print_r($results);
        exit();
        
        $check = $this->generate_buffer($this->user_access_buffer['user_id'], $this->user_access_buffer['access_area_id']);
        if (isset($check)) {
            return true;
        } else {
            redirect('admin/memo_management');
        }
//        return $this->user_access_buffer;
    }

    function if_user_has_permission($access_id) {
//        for($i = 0 ; $i < count($user_id);$i++){
        $id = $_SESSION['user_id'];
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_access_area_permission', 'users.id = user_access_area_permission.user_id', 'left');
        $this->db->join('user_access_group', 'user_access_area_permission.id_user_access_group = user_access_group.id_user_access_group', 'left');
        $this->db->join('user_group_elements', 'user_access_group.id_user_access_group = user_group_elements.id_user_access_group', 'left');
        $this->db->join('user_access_area', 'user_group_elements.id_user_access_area = user_access_area.id_user_access_area', 'left');
        $this->db->where('user_access_area.id_user_access_area',$access_id);
        $this->db->where('id',$id);
        return $results = $this->db->get()->result(); 
    }

}
