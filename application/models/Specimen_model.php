<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Specimen_model
 *
 * @author MD. Mashfiq
 */
class Specimen_model extends CI_Model {

    function get_agent_dropdown() {
        $customers = $this->db->get('specimen_agent')->result();

        $data = array();
        $data[''] = 'Select party by name or code';
        foreach ($customers as $customer) {
            $data[$customer->id_agent] = $customer->id_agent . " - " . $customer->name;
        }
        return form_dropdown('id_agent', $data, NULL, ' class="select2" required');
    }
    
    
    function processing_new_sales() {
        $this->load->model('misc/Stock_perpetual');
        $this->load->model('Stock_model');

        $id_agent = $this->input->post('id_agent');

        $data = array(
            'id_agent' => $id_agent,
            'date_entry' => date('Y-m-d h:i:u'),
            'id_employee' => $_SESSION['user_id']
        );

        $this->db->insert('specimen_total', $data) or die('failed to insert data on sales_total_sales');


        $id_specimen_total = $this->db->insert_id() or die('failed to insert data on sales_total_sales');

        $item_selection = $this->input->post('item_selection');
        $data_sales = array();
        foreach ($item_selection as $value) {
            if (empty($value)) {
                continue;
            }
            $tmp_data_sales = array(
                'id_specimen_total' => $id_specimen_total,
                'id_item' => $value['item_id'],
                'amount_copy' => $value['item_quantity']
            );
            array_push($data_sales, $tmp_data_sales);
            $this->Stock_perpetual->Stock_perpetual_register($value['item_id'], $value['item_quantity'],2);
            $this->Stock_model->stock_reduce($value['item_id'], $value['item_quantity']);
        }


        $this->db->insert_batch('specimen_items', $data_sales) or die('failed to insert data on sales');
        $action = $this->input->post('action');
        if ($action == 'save_and_reset') {
            $response['msg'] = "The sales is successfully done . \n Memo No: $id_specimen_total";
            $response['next_url'] = site_url('specimen/new_entry');
        } else if ($action == 'save_and_back_to_list') {
            $response['msg'] = "The sales is successfully done . \n Memo No: $id_specimen_total";
            $response['next_url'] = site_url('specimen/tolal');
        }
        echo json_encode($response);
    }


}
