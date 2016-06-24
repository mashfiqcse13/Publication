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
        $data[''] = 'Select agent by name or code';
        foreach ($customers as $customer) {
            $data[$customer->id_agent] = $customer->id_agent . " - " . $customer->name;
        }
        return form_dropdown('id_agent', $data, NULL, ' class="select2" required');
    }

    function get_agent_dropdown_who_have_taken_specimen() {
        $sql = "SELECT distinct(`id_agent`), `name` FROM `specimen_total` natural join `specimen_agent`";
        $customers = $this->db->query($sql)->result();

        $data = array();
        $data[''] = 'Select agent by name or code';
        foreach ($customers as $customer) {
            $data[$customer->id_agent] = $customer->id_agent . " - " . $customer->name;
        }
        return form_dropdown('id_agent', $data, NULL, ' class="select2"');
    }

    function get_item_dropdown_who_are_given_as_specimen() {

        $items = $this->db->query("SELECT distinct(`id_item`), `name` FROM `items` natural join `specimen_items`")->result();

        $data = array();
        $data[''] = 'Select items by name or code';
        foreach ($items as $item) {
            $data[$item->id_item] = $item->id_item . " - " . $item->name;
        }
        return form_dropdown('id_item', $data, '', ' class="select2" ');
    }

    function processing_new_specimen() {
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
            $this->Stock_perpetual->Stock_perpetual_register($value['item_id'], $value['item_quantity'], 2);
            $this->Stock_model->stock_reduce($value['item_id'], $value['item_quantity']);
        }


        $this->db->insert_batch('specimen_items', $data_sales) or die('failed to insert data on sales');
        $action = $this->input->post('action');
        if ($action == 'save_and_reset') {
            $response['msg'] = "The specimen issue is successfully done . \n Specimen Issue: $id_specimen_total";
            $response['next_url'] = site_url('specimen/new_entry');
        } else if ($action == 'save_and_back_to_list') {
            $response['msg'] = "The sales is successfully done . \n Specimen Issue: $id_specimen_total";
            $response['next_url'] = site_url('specimen/tolal');
        }
        echo json_encode($response);
    }

    function get_report_table($id_agent = '', $id_item = '', $date_range = '') {
        $where = array();
        if (!empty($id_agent)) {
            array_push($where, "specimen_total.id_agent = $id_agent");
        }
        if (!empty($id_item)) {
            array_push($where, "specimen_items.id_item = $id_item");
        }
        if (!empty($date_range)) {
            array_push($where, "date(date_entry) BETWEEN" . $this->Common->convert_date_range_to_mysql_between($date_range));
        }
        if (empty($where) && sizeof($where) == 0) {
            $where = 1;
        } else {
            $where = implode(' AND ', $where);
        }
        $sql = "SELECT 
                    id_item,
                    item_name,
                    SUM(amount_copy) as total_quantity
                    FROM(
                            SELECT specimen_total.id_agent, specimen_agent.name as agent_name, specimen_items.id_item,
                            items.name as item_name, amount_copy, date_entry
                            FROM  `specimen_total`  NATURAL JOIN  `specimen_items` NATURAL JOIN  `items` 
                            JOIN  `specimen_agent` on specimen_total.id_agent= specimen_agent.id_agent
                            where $where
                    ) AS report
                    GROUP BY id_item ORDER BY  `id_item` ASC  ";
        $this->table->set_heading(array('Item ID', 'Item Name', 'Total Amount'));
        $tmpl = array(
            'table_open' => '<table class="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0">',
            'heading_row_start' => '<tr style="background:#ddd">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($tmpl);
        $table_data = $this->db->query($sql)->result_array();
        return $this->table->generate($table_data);
    }

    function get_agent_name_by($id_agent) {
        if (empty($id_agent)) {
            return false;
        }
        $sql = "SELECT * FROM specimen_agent where id_agent = $id_agent";
        $agent_details = $this->db->query($sql)->result();
        if (empty($agent_details[0]->name)) {
            return false;
        } else {
            return $agent_details[0]->name;
        }
    }

}
