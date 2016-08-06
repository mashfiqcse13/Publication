<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Performance_model  extends CI_Model  {
    
    function get_technician_dropdown() {
        $technicians = $this->db->get('technician')->result();

        $data = array();
        $data[''] = 'Select Technician';
        foreach ($technicians as $technician) {
            $data[$technician->id_technician] = $technician->technician_name;
        }
        return form_dropdown('id_technician', $data, NULL, ' class="form-control select2" required');
    }
}
