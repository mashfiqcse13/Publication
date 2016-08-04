<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_access_model extends CI_Model{
    
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
        
        
        $data=array(
          'user_access_group_title'=>$group_title,
            'user_access_group_description' => $group_description
        );
        $this->db->insert('user_access_group',$data);
        $insert_id = $this->db->insert_id();
        
        $message=$this->insert_group_element($insert_id,$_POST);
        
        if($message==true){
            $this->session->set_userdata('user_access_message','Data Insert Success');
            redirect('Users_info/user_access_group');
        }else{
            $this->session->set_userdata('user_access_message','Data Insert Faild');
            redirect('Users_info/user_access_group');
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