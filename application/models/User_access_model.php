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
        $check = '';
//        $i = 1;
        foreach ($query as $row) {
            $check.="<div class='checkbox col-lg-4'><label title=\"" . $row->user_access_area_description . "\"><input type='checkbox' name='access_area[]' value='" . $row->id_user_access_area . "' class='check'>" . $row->user_access_area_title . "</label></div>";
        }
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

        $id_user_access_group = $this->input->post('id_user_access_group');
        $group_title = $this->input->post('access_group_title');
        $group_description = $this->input->post('description');
        if (!empty($group_title)) {
            $data = array(
                'user_access_group_title' => $group_title,
                'user_access_group_description' => $group_description
            );
            $this->db->where('id_user_access_group', $id_user_access_group);
            $this->db->update('user_access_group', $data);

            $message = $this->update_group_element($id_user_access_group, $this->input->post('access_area'));
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

    function update_group_element($id_user_access_group, $user_selected_id_user_access_area) {
        $rows = $this->db->select('id_user_access_area')->from('user_group_elements')->where('id_user_access_group', $id_user_access_group)->get()->result();
        $current_selected_id_user_access_area = array();
        foreach ($rows as $row) {
            array_push($current_selected_id_user_access_area, $row->id_user_access_area);
        }
        if (empty($user_selected_id_user_access_area) > 0) {
            $unchangeable_id_user_access_area = array();
            $deletable_id_user_access_area = $current_selected_id_user_access_area;
            $insertable_id_user_access_area = array();
        } else {
            $unchangeable_id_user_access_area = array_intersect($current_selected_id_user_access_area, $user_selected_id_user_access_area);
            $deletable_id_user_access_area = array_diff($current_selected_id_user_access_area, $unchangeable_id_user_access_area);
            $insertable_id_user_access_area = array_diff($user_selected_id_user_access_area, $unchangeable_id_user_access_area);
        }
        if (sizeof($deletable_id_user_access_area) > 0) {
            $where = " `id_user_access_group` = $id_user_access_group and `id_user_access_area` in (" . implode(',', $deletable_id_user_access_area) . ")";
            $this->db->where($where)->delete('user_group_elements');
        }
        if (sizeof($insertable_id_user_access_area) > 0) {
            $data_to_insert = array();
            foreach ($insertable_id_user_access_area as $value) {
                array_push($data_to_insert, array(
                    'id_user_access_group' => $id_user_access_group,
                    'id_user_access_area' => $value
                ));
            }
            $this->db->insert_batch('user_group_elements', $data_to_insert);
        }
        return TRUE;
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

    function check_user_access($id_user_access_area) {
        return TRUE;
        $super_user_id = $this->config->item('super_user_id');
        if ($super_user_id != $_SESSION['user_id'] || $this->User_access_model->if_user_has_permission($id_user_access_area)) {
            redirect();
            return TRUE;
        }
    }

}
