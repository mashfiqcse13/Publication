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
            $check.="<tr><td><div class='checkbox'><label><input type='checkbox' name='access_area[]' value='" . $row->id_user_access_area . "'>" . $row->user_access_area_title . "</label></div></td></tr>";
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

}
