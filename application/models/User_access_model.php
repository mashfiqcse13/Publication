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
    
    function get_user_access_area(){
        $query=$this->db->get('user_access_area')->result();
        $check='<table class="">';
        foreach($query as $row){
            $check.="<tr><td><div class='checkbox'><label><input type='checkbox' name='access_area[]' value='".$row->id_user_access_area."'>".$row->user_access_area_title."</label></div></td></tr>";
        }
        $check.="</table>";
    return $check;    
    }
    
    
    function insert_access_group($data){
        
        $this->load->library('session');
        
        
        $group_title=$this->input->post('access_group_title');
        $group_description=$this->input->post('description');
        if(!empty($group_title)){
        
        $data=array(
          'user_access_group_title'=>$group_title,
            'user_access_group_description' => $group_description
        );
        $this->db->insert('user_access_group',$data);
        $insert_id = $this->db->insert_id();
        
        $message=$this->insert_group_element($insert_id,$_POST);
        
        if($message==true){
            $this->session->set_userdata('user_access_message','<p class="text-green">Data Insert Success</p>');
            redirect('Users_info/user_access_group_list');
        }else{
            $this->session->set_userdata('user_access_message','<p class="text-error">Data Insert Faild</p>');
            redirect('Users_info/user_access_group_list');
        }
        
        } 
        
    }
    
    
    function insert_group_element($insert_id,$access_area){
        $access_area=$this->input->post('access_area');
        
        
        foreach($access_area as $key => $val){
            $data=array(
              'id_user_access_group' => $insert_id,
              'id_user_access_area' => $access_area[$key]
            );
            
            $this->db->insert('user_group_elements', $data);

        }
        
        return true;
    }

}
