<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Production_process_model
 *
 * @author MD. Mashfiq
 */
class Production_process_model extends CI_Model {

    function add_process_step($id_processes, $id_vendor, $id_step_name) {
        if ($this->get_process_status($id_processes) != 1) {
            return FALSE;
        }
        $last_process_step_id = $this->last_process_step_id($id_processes);
        if ($last_process_step_id > 0) {
            $order_quantity = 0;
        } else {
            $order_quantity = $this->get_order_quantity($id_processes);
        }

        $data_to_insert_in_process_steps = array(
            'id_processes' => $id_processes,
            'id_step_name' => $id_step_name,
            'order_amount' => $order_quantity,
            'transfered_amount' => 0,
            'id_previous_step' => $last_process_step_id,
            'reject_amount' => 0,
            'damaged_amount' => 0,
            'missing_amount' => 0,
            'id_vendor' => $id_vendor,
            'date_created' => date('Y-m-d h:i:u')
        );
        $this->db->insert('process_steps', $data_to_insert_in_process_steps);
        return TRUE;
    }

    function delete_process_step($id_process_steps) {
        if ($this->get_process_status($id_processes) != 1) {
            return FALSE;
        }
        $id_previous_step = $this->previous_process_step_id($id_process_steps);
        $sql = "DELETE FROM `process_steps` WHERE `id_process_steps` = $id_process_steps and `order_amount`= 0 ";
        $this->db->query($sql);
        $step_details = $this->get_step_info_by($id_process_steps);
        $next_process_step_id = $this->next_process_step_id($id_process_steps);
        if ($next_process_step_id != FALSE && $step_details == FALSE) {  // $step_details == FALSE means step is deleted
            $sql = "UPDATE `process_steps` SET `id_previous_step` = '$id_previous_step' WHERE `id_process_steps` = $next_process_step_id ";
            $this->db->query($sql);
        }
    }

    function is_transferable_amount_in_step($id_process_steps, $amount_transfered) {
        $transferable_amount = $this->get_transferable_amount_in_step($id_process_steps);
        if ($amount_transfered <= $transferable_amount && $amount_transfered > 0) {
            return TRUE;
        } else {
            return false;
        }
    }

    function get_transferable_amount_in_step($id_process_steps) {
        $sql = "SELECT `order_amount`-(`reject_amount`+ `damaged_amount`+ `missing_amount`) 
            as transferable_amount FROM `process_steps` where `id_process_steps` = $id_process_steps";
        $result = $this->db->query($sql)->result();
        if (empty($result[0])) {
            return 0;
        } else {
            return $result[0]->transferable_amount;
        }
    }

    function get_order_quantity($id_processes) {
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

    function next_process_step_id($current_id_process_steps) {
        $sql = "SELECT id_process_steps FROM `process_steps` WHERE `id_previous_step` = $current_id_process_steps";
        $result = $this->db->query($sql)->result();
        if (empty($result[0]) || $result[0]->id_process_steps == '') {
            return false;
        } else {
            return $result[0]->id_process_steps;
        }
    }

    function previous_process_step_id($id_process_steps) {
        $step_details = $this->get_step_info_by($id_process_steps);
        if ($step_details == FALSE) {
            return FALSE;
        }
        return $step_details->id_previous_step;
    }

    function step_transfer($id_process_step_from, $amount_transfered, $amount_billed, $amount_paid) {
        $id_process_step_to = $this->next_process_step_id($id_process_step_from);
        if (!$id_process_step_to || !$this->is_transferable_amount_in_step($id_process_step_from, $amount_transfered) || $this->get_process_status($id_processes) != 1) {
            return FALSE;
        }
        $sql = "UPDATE `process_steps` 
            SET `transfered_amount` = `transfered_amount` + $amount_transfered
            WHERE `id_process_steps` = $id_process_step_from";
        $this->db->query($sql);
        $sql = "UPDATE `process_steps` 
            SET `order_amount` = `order_amount` + $amount_transfered
            WHERE `id_process_steps` = $id_process_step_to";
        $this->db->query($sql);
        $id_process_step_transfer_log = $this->add_transfer_log($id_process_step_from, $id_process_step_to, $amount_transfered);
        $this->add_step_transfer_billing($id_process_step_transfer_log, $id_process_step_from, $amount_billed, $amount_paid);
        return TRUE;
    }

    function add_transfer_log($id_process_step_from, $id_process_step_to, $amount_transfered) {
        $data = array(
            'id_process_step_from' => $id_process_step_from,
            'id_process_step_to' => $id_process_step_to,
            'amount_transfered' => $amount_transfered,
            'date_transfered' => date('Y-m-d h:i:u')
        );
        $this->db->insert('process_step_transfer_log', $data);
        return $this->db->insert_id();
    }

    function add_step_transfer_billing($id_process_step_transfer_log, $id_process_step_from, $amount_billed, $amount_paid) {
        $data = array(
            'id_process_step_transfer_log' => $id_process_step_transfer_log,
            'id_process_steps' => $id_process_step_from,
            'amount_billed' => $amount_billed,
            'amount_paid' => $amount_paid
        );
        $this->db->insert('process_step_transfer_billing', $data);
        return $this->db->insert_id();
    }

    function get_steps_info($id_processes) {
        $sql = "SELECT  `contact_vendor`.`name` as vendor_name,`process_step_name`.`step_name`, `process_steps`.*,
                    `order_amount`-(`reject_amount`+ `damaged_amount`+ `missing_amount`) as transferable_amount
                    FROM `process_steps`
                    left join `contact_vendor`on `process_steps`.`id_vendor` = `contact_vendor`.`id_vendor`
                    left join `process_step_name`on `process_steps`.`id_step_name` = `process_step_name`.`id_step_name`
                WHERE `id_processes`= $id_processes";
        $result = $this->db->query($sql)->result();
        if (empty($result)) {
            return FALSE;
        } else {
            return $result;
        }
    }

    function get_step_info_by($id_process_steps) {
        $sql = "SELECT  * FROM `process_steps` WHERE `id_process_steps`= $id_process_steps";
        $result = $this->db->query($sql)->result();
        if (empty($result[0])) {
            return FALSE;
        } else {
            return $result[0];
        }
    }

    function process_steps_table($id_processes) {
        $this->load->library('table');
        $process_steps = $this->get_steps_info($id_processes);
        if ($process_steps == FALSE) {
            return FALSE;
        }
        foreach ($process_steps as $index => $each_step) {
            $action_btn = "";
            if ($each_step->transferable_amount > 0 && $this->next_process_step_id($each_step->id_process_steps)) {
                $action_btn .= "<button data-toggle=\"modal\" data-target=\"#modalStepToStepTransfer\" 
                    class=\"btn btn-xs btn-success btnStepToStepTransfer\" data-id_process_steps=\"{$each_step->id_process_steps}\" 
                        data-transferable_amount=\"{$each_step->transferable_amount}\">Transfer</button> ";
            }
            if ($each_step->order_amount == 0) {
                $delet_url = site_url('production_process/delete_step/' . $each_step->id_processes . '/' . $each_step->id_process_steps);
                $action_btn .= "<a href=\"$delet_url\" class=\"btn btn-xs btn-warning\" data-id_process_steps=\"{$each_step->id_process_steps}\">Delete</a> ";
            }
            $process_status = $this->get_process_status($id_processes);
            if ($process_status == 1) {
                $this->table->add_row(
                        $each_step->vendor_name, $each_step->step_name, $each_step->order_amount, $each_step->transfered_amount, $each_step->reject_amount, $each_step->damaged_amount, $each_step->missing_amount, $each_step->date_created, $action_btn
                );
            } else {
                $this->table->add_row(
                        $each_step->vendor_name, $each_step->step_name, $each_step->order_amount, $each_step->transfered_amount, $each_step->reject_amount, $each_step->damaged_amount, $each_step->missing_amount, $each_step->date_created
                );
            }
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
        if ($process_status == 1) {
            $this->table->set_heading('Vendor Name', 'Step Name', "Order amount", 'Transfered', 'Rejected', 'Damaged', 'Missing', 'Date Created', 'Action');
        } else {
            $this->table->set_heading('Vendor Name', 'Step Name', "Order amount", 'Transfered', 'Rejected', 'Damaged', 'Missing', 'Date Created');
        }
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

    function get_process_status($id_processes) {
        $process_details = $this->get_process_details($id_processes);
        if ($process_details == FALSE) {
            return FALSE;
        }
        return $process_details->process_status;
    }

    function stop_process($id_processes) {
        if (empty($id_processes)) {
            return FALSE;
        }
        $sql = "UPDATE `processes` SET process_status = '2'  WHERE `id_processes` = $id_processes ";
        $this->db->query($sql);
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

    function get_step_name_dropdown() {
        $items = $this->db->get('process_step_name')->result();

        $data = array();
        $data[''] = 'Select Step name';
        foreach ($items as $item) {
            $data[$item->id_step_name] = $item->step_name;
        }
        return form_dropdown('id_step_name', $data, '', ' class="select2" ');
    }

}
