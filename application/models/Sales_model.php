<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Sales
 *
 * @author MD. Mashfiq
 */
class Sales_model extends CI_Model {

    //put your code here
    function get_party_dropdown() {
        $customers = $this->db->get('pub_contacts')->result();

//        die(print_r($customers));
        $data = array();
        foreach ($customers as $customer) {
            $data[$customer->contact_ID] = $customer->name;
        }
        return form_dropdown('id_contact', $data,'', ' class="select2" ');
    }

}
