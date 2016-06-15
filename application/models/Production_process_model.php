<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Production_process_model
 *
 * @author MD. Mashfiq
 */
class Production_process_model extends CI_Model {

    function add_process_step($id_processes, $id_vendor, $transfered_amount, $amount_billed, $amount_paid, $reject_amount = 0, $damaged_amount = 0, $missing_amount = 0) {
        $last_process_step_id = $this->last_process_step_id($id_processes);
        $order_amount = $this->get_remaining_order($id_processes);
        if ($order_amount < $transfered_amount) {
            return FALSE;
        }

        $data_to_insert_in_process_steps = array(
            'id_processes' => $id_processes,
            'order_amount' => $order_amount,
            'transfered_amount' => $transfered_amount,
            'id_previous_step' => $last_process_step_id,
            'reject_amount' => $reject_amount,
            'damaged_amount' => $damaged_amount,
            'missing_amount' => $missing_amount,
            'id_vendor' => $id_vendor
        );
        $this->db->insert('process_steps', $data_to_insert_in_process_steps);
        $insert_id_of_process_steps = $this->db->insert_id();
        $data_to_insert_in_process_step_transfer_log = array(
            'id_process_step_from' => $last_process_step_id,
            'id_process_step_to' => $insert_id_of_process_steps,
            'amount_transfered' => $transfered_amount,
            'date_transfered' => date('Y-m-d h:i:u')
        );
        $this->db->insert('process_step_transfer_log', $data_to_insert_in_process_step_transfer_log);
        $insert_id_of_process_step_transfer_log = $this->db->insert_id();
        $data_to_insert_in_process_step_transfer_billing = array(
            'id_process_step_transfer_log' => $insert_id_of_process_step_transfer_log,
            'id_process_steps' => $insert_id_of_process_steps,
            'amount_billed' => $amount_billed,
            'amount_paid' => $amount_paid
        );
        $this->db->insert('process_step_transfer_billing', $data_to_insert_in_process_step_transfer_billing);

        $sql = "UPDATE `processes` 
            SET `actual_quantity` = `actual_quantity` + $transfered_amount,
            `total_damaged_item` =`total_damaged_item` + $damaged_amount, 
            `total_reject_item` =`total_reject_item`+ $reject_amount,
            `total_missing_item` = `total_missing_item` + $missing_amount
            WHERE `id_processes` = $id_processes;";
        if ($order_amount == $transfered_amount) {
            $current_date = date('Y-m-d h:i:u');
            $sql = "UPDATE `processes` 
            SET `actual_quantity` = `actual_quantity` + $transfered_amount, `total_damaged_item` =`total_damaged_item` + $damaged_amount, 
            `total_reject_item` =`total_reject_item`+ $reject_amount, `total_missing_item` = `total_missing_item` + $missing_amount, 
            `date_finished` = '$current_date' , `process_status` = 2
            WHERE `id_processes` = $id_processes;";
        }
        $result = $this->db->query($sql);
    }

    function get_remaining_order($id_processes) {
        $sql = "SELECT `order_quantity`-(`actual_quantity`+ `total_damaged_item`+ `total_reject_item`+ `total_missing_item`) 
            as remaining_order_amount FROM `processes` where `id_processes` = $id_processes";
        $result = $this->db->query($sql)->result();
        if (empty($result[0])) {
            return 0;
        } else {
            return $result[0]->remaining_order_amount;
        }
    }

    function last_process_step_id($id_processes) {
        $sql = "SELECT max(`id_process_steps`) as last_process_step_id FROM `process_steps` WHERE `id_processes` = $id_processes";
        $result = $this->db->query($sql)->result();
        if (empty($result[0]) || $result[0]->last_process_step_id == '') {
            return 0;
        } else {
            return $result[0]->last_process_step_id;
        }
    }

    function get_steps($id_processes) {
        $sql = "SELECT  `process_steps`.`id_vendor` ,
                `contact_vendor`.`name`,
                `process_steps`.`order_amount`, 
                `process_steps`.`transfered_amount`,
                `process_steps`.`reject_amount`, 
                `process_steps`.`damaged_amount`, 
                `process_steps`.`missing_amount`,
                `process_step_transfer_billing`.`amount_billed`,
                `process_step_transfer_billing`.`amount_paid` ,
                `process_step_transfer_log`.`date_transfered`
                FROM `process_steps`
                left join `process_step_transfer_log` on `process_steps`.`id_process_steps`=`process_step_transfer_log`.`id_process_step_to`
                left join `process_step_transfer_billing`on `process_step_transfer_billing`.`id_process_steps` = `process_steps`.`id_process_steps`
                left join `contact_vendor`on `process_steps`.`id_vendor` = `contact_vendor`.`id_vendor`
                WHERE `id_processes`= $id_processes";
        $result = $this->db->query($sql)->result();
        if (empty($result)) {
            return FALSE;
        } else {
            return $result;
        }
    }

    function process_steps_table($id_processes) {
        $this->load->library('table');
        $process_steps = $this->get_steps($id_processes);
        if ($process_steps == FALSE) {
            return $process_steps;
        }
        foreach ($process_steps as $each_step) {
            $this->table->add_row(
                    $each_step->name, $each_step->order_amount, $each_step->transfered_amount, $each_step->reject_amount, $each_step->damaged_amount, $each_step->missing_amount, $each_step->amount_billed, $each_step->amount_paid, $each_step->date_transfered
            );
        }
        $tmpl = array(
            'table_open' => '<table class="table table-hover table-bordered">',
            'heading_row_start' => '<tr>',
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
        $this->table->set_heading('Vendor Name', "Order amount", 'Transfered', 'Rejected', 'Damaged', 'Missing', 'Amount billed', 'Amount paid', 'Transfer Date');
        return $this->table->generate();
    }

    function get_process_details($id_processes) {
        $result = $this->db->select("`id_processes`, `process_type`, processes.id_item, `name` as item_name, `date_created`, `date_finished`, `order_quantity`, `actual_quantity`, `total_damaged_item`, `total_reject_item`, `total_missing_item`, `process_status`")
                        ->join('items', 'items.id_item = processes.id_item')->join('process_type', 'process_type.id_process_type = processes.id_process_type')
                        ->where('id_processes', $id_processes)->get('processes')->result();
        if (empty($result[0])) {
            return FALSE;
        } else {
            return $result[0];
        }
    }

    function process_detail_table($id_processes) {
        $this->load->library('table');
        $process_details = $this->get_process_details($id_processes);
        $progress_in_percent = $process_details->actual_quantity / $process_details->order_quantity * 100;
        $progress_bar = $this->progress_bar($progress_in_percent);
        $output = '';


        $tmpl = array(
            'table_open' => '<table id="process_detail_table" class="table table-hover table-bordered">',
            'heading_row_start' => '<tr>',
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

        $this->table->add_row($process_details->id_processes, $process_details->process_type, $process_details->item_name, $process_details->date_created, $process_details->date_finished);
        $this->table->set_heading('ID', 'Process type', 'Item name', 'Creating Date', 'Finishing Date');
        $output .= $this->table->generate();
        $this->table->add_row($process_details->order_quantity, $process_details->actual_quantity, $process_details->total_damaged_item, $process_details->total_reject_item, $process_details->total_missing_item);
        $this->table->set_heading('Ordered', 'Found', 'Damaged', 'Rejected', 'Missing');
        $output .= ' <h4>Item quantity details :</h4>';
        $output .= $this->table->generate();
        $this->table->set_heading('Status', 'Progress ');
        $this->table->add_row($this->process_status_decoder($process_details->process_status), $progress_bar['progress'] . $progress_bar['bar']);
        $output .= ' <h4>Process details :</h4>';
        $output .= $this->table->generate();
        return $output;
    }

    function process_status_decoder($value, $row = FALSE) {
        if ($value == 1) {
            return '<span class="label label-warning">Ongoing</span>';
        } else if ($value == 2) {
            return '<span class="label label-success">Stopped</span>';
        } else if ($value == 3) {
            return '<span class="label label-danger">Rejected</span>';
        }
    }

    function progress_bar($progress_in_percent) {
        if ($progress_in_percent > 80) {
            $data = array('progress' => 'green', 'bar' => 'success');
        } else if ($progress_in_percent > 60) {
            $data = array('progress' => 'yellow', 'bar' => 'yellow');
        } else if ($progress_in_percent > 40) {
            $data = array('progress' => 'blue', 'bar' => 'primary');
        } else {
            $data = array('progress' => 'red', 'bar' => 'danger');
        }
        return array(
            'progress' => '<span class="badge bg-' . $data['progress'] . '">' . $progress_in_percent . '%</span>',
            'bar' => '<div class="progress progress-striped active">
                      <div style="width: ' . $progress_in_percent . '%" class="progress-bar progress-bar-' . $data['bar'] . '"></div>
                    </div>');
    }

    function get_vendor_dropdown() {
        $items = $this->db->get('contact_vendor')->result();

        $data = array();
        $data[''] = 'Select vendor by name or code';
        foreach ($items as $item) {
            $data[$item->id_vendor] = $item->id_vendor . " - " . $item->name . " ( {$item->type} ) ";
        }
        return form_dropdown('id_vendor', $data, '', ' class="select2" ');
    }

}
