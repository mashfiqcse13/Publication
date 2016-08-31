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
    private $user_access_buffer = False;

    public function __construct() {
        parent::__construct();
        if ($this->user_access_buffer == false) {
            $this->generate_buffer();
        }
    }

    function generate_buffer() {
        $sql = "SELECT  `user_id` ,  `id_user_access_area` 
                    FROM  `user_access_area_permission` 
                    NATURAL JOIN  `user_group_elements` ";
        $results = $this->db->query($sql)->result();
        $this->user_access_buffe = array();
        foreach ($results as $result) {
            $this->user_access_buffer[$result->user_id][$result->id_user_access_area] = TRUE;
        }
    }

    function if_user_has_permission($id_user_access_area, $user_id = "from_session") {
        if ($this->user_access_buffer == false) {
            $this->generate_buffer();
        }
        if ($user_id == 'from_session') {
            $user_id = $_SESSION['user_id'];
        }
        if (!empty($this->user_access_buffer[$user_id][$id_user_access_area]) && $this->user_access_buffer[$user_id][$id_user_access_area] == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_user_access_area() {
        $query = $this->db->get('user_access_area')->result();
        $check = '<table class="">';
        foreach ($query as $row) {
            $check.="<tr><td><div class='checkbox'><label><input type='checkbox' name='access_area[" . $row->id_user_access_area . "]' value='" . $row->id_user_access_area . "' class='check'>" . $row->user_access_area_title . "</label></div></td></tr>";
        }
        $check.="</table>";
        return $check;
    }
    

    function insert_access_group($data) {

        $this->load->library('session');


        $group_title = $this->input->post('access_group_title');
        $group_description = $this->input->post('description');
        if (!empty($group_title)) {

            $data = array(
                'user_access_group_title' => $group_title,
                'user_access_group_description' => $group_description
            );
            $this->db->insert('user_access_group', $data);
            $insert_id = $this->db->insert_id();

            $message = $this->insert_group_element($insert_id, $_POST);

            if ($message == true) {
                $this->session->set_userdata('user_access_message', '<p class="text-green">Data Insert Success</p>');
                redirect('Users_info/user_access_group_list');
            } else {
                $this->session->set_userdata('user_access_message', '<p class="text-error">Data Insert Faild</p>');
                redirect('Users_info/user_access_group_list');
            }
        }
    }

    function update_access_group($data) {
//        print_r($data);exit();
        $this->load->library('session');

        $id = $this->input->post('id_user_access_group');
        $group_title = $this->input->post('access_group_title');
        $group_description = $this->input->post('description');
        if (!empty($group_title)) {
            $data = array(
                'user_access_group_title' => $group_title,
                'user_access_group_description' => $group_description
            );
            $this->db->where('id_user_access_group', $id);
            $this->db->update('user_access_group', $data);
            $this->db->select('id_user_access_group');
            $this->db->from('user_access_group');
            $this->db->where('id_user_access_group', $id);
            $query = $this->db->get();
            $update_id = $query->row();
//            print_r($update_id->id_user_access_group);exit();
            $message = $this->update_group_element($update_id->id_user_access_group, $_POST);

            if ($message == true) {
                $this->session->set_userdata('user_access_message', '<p class="text-green">Data Update Success</p>');
                redirect('Users_info/user_access_group_list');
            } else {
                $this->session->set_userdata('user_access_message', '<p class="text-error">Data Update Faild</p>');
                redirect('Users_info/user_access_group_list');
            }
        }
    }

    function insert_group_element($insert_id, $access_area) {
        $access_area = $this->input->post('access_area');


        foreach ($access_area as $key => $val) {
            $data = array(
                'id_user_access_group' => $insert_id,
                'id_user_access_area' => $access_area[$key]
            );

            $this->db->insert('user_group_elements', $data);
        }

        return true;
    }

    function update_group_element($update_id, $access_area) {
        $id_user_group_elements = array();
        $access_area = $this->input->post('access_area');

        $id_user_group_elements = $this->input->post('id_user_group_elements');
        
        print_r($access_area);
        exit();
        if (empty($id_user_group_elements)) {
            $this->insert_group_element($update_id, $access_area);
        }

        foreach ($id_user_group_elements as $element => $value) {
            if (empty($access_area)) {
                $this->db->where('id_user_group_elements', $id_user_group_elements[$element]);
                $this->db->delete('user_group_elements');
            }
            if (!empty($access_area)) {
                $max_access_area = $this->db->query('SELECT MAX(`id_user_access_area`) FROM `user_access_area` ')->row();
                for($key = 0; $key< count($max_access_area->id_user_access_area); $key++){
//                foreach ($access_area as $key => $val) {
                    $data = array(
                        'id_user_access_group' => $update_id,
                        'id_user_access_area' => $access_area[$key]
                    );
                    $this->db->select('*');
                    $this->db->from('user_group_elements');
                    $this->db->where('id_user_access_area', $access_area[$key]);
                    $this->db->where('id_user_group_elements', $id_user_group_elements[$element]);
                    $result = $this->db->get()->result();

                    If (!empty($result)) {
                        $this->db->where('id_user_group_elements', $id_user_group_elements[$element]);
                        $this->db->update('user_group_elements', $data);
                    } else {
//                    print_r($access_area[$key]);
//                    exit();
//                        $this->db->select('*');
//                        $this->db->from('user_group_elements');
//                        $this->db->where('id_user_access_area !=', $access_area[$key]);
//                        $result2 = $this->db->get()->result();
////                    print_r($result2);
////                    exit();
//                        if (empty($result2)) {
//                            if (empty($id_user_group_elements[$element])) {
                                $this->db->insert('user_group_elements', $data);
//                            }

//                        $this->db->insert('user_group_elements', $data);
//                        $this->insert_group_element($update_id, $access_area);
//                    return false;
//                    }
//                        }
//                if(empty($id_user_group_elements[$element])){
//                    $this->db->insert('user_group_elements', $data);
                    }
                }
            }
        }

        return true;
    }

    function get_all_group_info_by_id($id) {
        $this->db->select('*');
        $this->db->from('user_access_group');
        $this->db->where('id_user_access_group', $id);
        return $this->db->get()->result();
    }

    function get_all_access_area_by_access_id($id_user_group) {
        $this->db->select('id_user_access_area,id_user_group_elements');
        $this->db->from('user_group_elements');
        $this->db->where('id_user_access_group', $id_user_group);
        return $this->db->get()->result();
    }

}
