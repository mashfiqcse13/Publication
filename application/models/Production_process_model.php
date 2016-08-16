<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Production_process_model
 *
 * @author MD. Mashfiq
 */
class Production_process_model extends CI_Model {

    private $callback_process_buffer_id_vendor;

    function add_process_step($id_processes, $id_vendor, $id_step_name, $current_process_step_id = FALSE) {
        if ($this->get_process_status_by_process_id($id_processes) != 1) {
            return FALSE;
        }
        if ($current_process_step_id) {
            $order_quantity = 0;
        } else {
            $current_process_step_id = 0;
            $order_quantity = $this->get_order_quantity($id_processes);
        }

        $data_to_insert_in_process_steps = array(
            'id_processes' => $id_processes,
            'id_step_name' => $id_step_name,
            'order_amount' => $order_quantity,
            'transfered_amount' => 0,
            'id_previous_step' => $current_process_step_id,
            'reject_amount' => 0,
            'damaged_amount' => 0,
            'missing_amount' => 0,
            'id_vendor' => $id_vendor,
            'date_created' => date('Y-m-d h:i:u')
        );
        $this->db->insert('process_steps', $data_to_insert_in_process_steps);
        return $this->last_process_step_id($id_processes);
    }

    function delete_process_step($id_process_steps) {
        if ($this->get_process_status_by_process_step_id($id_process_steps) != 1) {
            return FALSE;
        }
        $sql1 = "DELETE FROM `process_steps` WHERE `id_process_steps` = $id_process_steps and `order_amount`= 0 ";
        $this->db->query($sql1);
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
        $sql = "SELECT `order_amount`-(`transfered_amount` + `reject_amount`+ `damaged_amount`+ `missing_amount`) 
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

    function next_process_step_id($id_process_steps) {
        $sql = "SELECT * FROM `process_steps` WHERE `id_previous_step` = $id_process_steps";
        $result = $this->db->query($sql)->result();
        $next_process_step_id = array();
        $count = 0;
        foreach ($result as $key => $value) {
            array_push($next_process_step_id, $value->id_process_steps);
            $count++;
        }
        if ($count == 0) {
            return FALSE;
        } else if ($count == 1) {
            return $next_process_step_id[0];
        } else {
            return $next_process_step_id;
        }
    }

    function previous_process_step_id($id_process_steps) {
        $step_details = $this->get_step_info_by($id_process_steps);
        if ($step_details == FALSE) {
            return FALSE;
        }
        return $step_details->id_previous_step;
    }

    function step_transfer($id_process_step_from, $id_process_step_to, $amount_transfered, $rejected_amount, $damaged_amount, $missing_amount, $amount_billed, $amount_paid) {
        $total_amount_to_be_transferred = $amount_transfered + $rejected_amount + $damaged_amount + $missing_amount;
        if (!$this->is_transferable_amount_in_step($id_process_step_from, $total_amount_to_be_transferred) || $this->get_process_status_by_process_step_id($id_process_step_from) != 1) {
            return FALSE;
        }
        $sql = "UPDATE `process_steps` 
            SET `transfered_amount` = `transfered_amount` + $amount_transfered,
             `reject_amount` = `reject_amount` + $rejected_amount,
             `damaged_amount` = `damaged_amount` + $damaged_amount,
             `missing_amount` = `missing_amount` + $missing_amount
            WHERE `id_process_steps` = $id_process_step_from";
        $this->db->query($sql);



        $process_step_details = $this->get_step_info_by($id_process_step_from);
        $id_processes = $process_step_details->id_processes;

        if ($id_process_step_to != false) {
            $sql = "UPDATE `process_steps` 
            SET `order_amount` = `order_amount` + $amount_transfered
            WHERE `id_process_steps` = $id_process_step_to";
            $this->db->query($sql);
            $id_process_step_transfer_log = $this->add_transfer_log($id_process_step_from, $id_process_step_to, $amount_transfered);
            $this->update_process_total_production_fault($id_processes);
        } else {
            $process_step_details = $this->get_step_info_by($id_process_step_from);
            $this->step_transfer_to_final_process($id_processes, $amount_transfered);
            $id_process_step_transfer_log = $this->add_transfer_log($id_process_step_from, 0, $amount_transfered);
        }
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
                    `order_amount`-(`transfered_amount`+`reject_amount`+ `damaged_amount`+ `missing_amount`) as transferable_amount
                    FROM `process_steps`
                    left join `contact_vendor`on `process_steps`.`id_vendor` = `contact_vendor`.`id_vendor`
                    left join `process_step_name`on `process_steps`.`id_step_name` = `process_step_name`.`id_step_name`
                WHERE `id_processes`= $id_processes
                ORDER BY `process_steps`.`id_previous_step`,`process_steps`.id_process_steps";
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
            $action_btn = array();
            if ($each_step->order_amount == 0 && $this->next_process_step_id($each_step->id_process_steps) == FALSE) {
                $delet_url = site_url('production_process/delete_step/' . $each_step->id_processes . '/' . $each_step->id_process_steps);
                $tmp_action_btn = "<a href=\"$delet_url\" class=\"btn btn-xs btn-warning\" data-id_process_steps=\"{$each_step->id_process_steps}\">Delete</a>";
                array_push($action_btn, $tmp_action_btn);
            }
            if ($each_step->transferable_amount > 0) {
                $tmp_action_btn = "<button data-toggle=\"modal\" data-target=\"#modalStepToStepTransfer\" 
                    class=\"btn btn-xs btn-success btnStepToStepTransfer\" data-id_process_steps=\"{$each_step->id_process_steps}\" 
                        data-transferable_amount=\"{$each_step->transferable_amount}\">Transfer</button>";
                array_push($action_btn, $tmp_action_btn);
                $tmp_action_btn = "<button class=\"btn btn-xs btn-primary btnAddStepFromStep\"  data-toggle=\"modal\" data-id_process_steps=\"{$each_step->id_process_steps}\"  
                    data-target=\"#modalAddStep\" >Add step</button>";
                array_push($action_btn, $tmp_action_btn);
                if ($each_step->order_amount != 0 && $this->next_process_step_id($each_step->id_process_steps) == FALSE) {
                    $tmp_action_btn = "<button data-toggle=\"modal\" data-target=\"#modalStepToStepTransfer\" 
                    class=\"btn btn-xs btn-danger btnStepToStepTransfer\" data-id_process_steps=\"{$each_step->id_process_steps}\" 
                        data-transferable_amount=\"{$each_step->transferable_amount}\">Final Transfer</button>";
                    array_push($action_btn, $tmp_action_btn);
                }
            }
            $link_step_id = "";
            $next_process_step_id = $this->next_process_step_id($each_step->id_process_steps);
            if (is_array($next_process_step_id)) {
                $link_step_id = implode(", ", $this->next_process_step_id($each_step->id_process_steps));
            } else if ($next_process_step_id != FALSE) {
                $link_step_id = $this->next_process_step_id($each_step->id_process_steps);
            }
            $action_btn = implode("<br>", $action_btn);
            $process_status = $this->get_process_status_by_process_id($id_processes);
            if ($process_status == 1) {
                $this->table->add_row(
                        $each_step->id_process_steps, $each_step->vendor_name, $each_step->step_name, $each_step->order_amount, $each_step->transfered_amount, $each_step->reject_amount, $each_step->damaged_amount, $each_step->missing_amount, $each_step->date_created, $link_step_id, $action_btn
                );
            } else {
                $this->table->add_row(
                        $each_step->id_process_steps, $each_step->vendor_name, $each_step->step_name, $each_step->order_amount, $each_step->transfered_amount, $each_step->reject_amount, $each_step->damaged_amount, $each_step->missing_amount, $each_step->date_created, $link_step_id
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
            $this->table->set_heading("ID", 'Vendor Name', 'Step Name', "Order amount", 'Transfered', 'Rejected', 'Damaged', 'Missing', 'Date Created', 'Linked Step ID', 'Action');
        } else {
            $this->table->set_heading("ID", 'Vendor Name', 'Step Name', "Order amount", 'Transfered', 'Rejected', 'Damaged', 'Missing', 'Date Created', 'Linked Step ID');
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

    function get_process_status_by_process_step_id($id_process_steps) {
        $process_step_details = $this->get_step_info_by($id_process_steps);
        $id_processes = $process_step_details->id_processes;
        return $this->get_process_status_by_process_id($id_processes);
    }

    function get_process_status_by_process_id($id_processes) {
        $process_details = $this->get_process_details($id_processes);
        if ($process_details == FALSE) {
            return FALSE;
        }
        return $process_details->process_status;
    }

    function get_total_production_fault($id_processes) {
        $sql = "SELECT SUM(`reject_amount`) as total_reject_item, SUM(`damaged_amount`) as total_damaged_item, 
            SUM(`missing_amount`) as total_missing_item FROM `process_steps` WHERE `id_processes` = $id_processes ";
        $total_production_fault = $this->db->query($sql)->result();
        if (empty($total_production_fault[0])) {
            return FALSE;
        } else {
            return $total_production_fault[0];
        }
    }

    function stop_process($id_processes) {
        $total_production_fault = $this->get_total_production_fault($id_processes);
        $last_process_step_id = $this->last_process_step_id($id_processes);
        $last_process_step_details = $this->get_step_info_by($last_process_step_id);
        if (empty($id_processes) || $total_production_fault == FALSE || $last_process_step_details == FALSE || $last_process_step_details->order_amount < 1) {
            return FALSE;
        }
        $sql = "UPDATE `processes` SET `actual_quantity` = {$last_process_step_details->order_amount},
            `total_damaged_item` = {$total_production_fault->total_damaged_item},
            `total_reject_item` = {$total_production_fault->total_reject_item},
            `total_missing_item` = {$total_production_fault->total_missing_item},
            process_status = '2'  WHERE `id_processes` = $id_processes ";
        $this->db->query($sql);
    }

    function step_transfer_to_final_process($id_processes, $amount_transfered) {
        $total_production_fault = $this->get_total_production_fault($id_processes);
        $process_details = $this->get_process_details($id_processes);
        if (empty($id_processes) || $total_production_fault == FALSE || $process_details == FALSE) {
            return FALSE;
        }

        // adding to final stock and stock perpitual
        $this->load->model('misc/Stock_perpetual');
        $this->load->model('Stock_model');
        $id_item = $process_details->id_item;
        $this->Stock_perpetual->Stock_perpetual_register($id_item, $amount_transfered, 0);
        $this->Stock_model->stock_add($id_item, $amount_transfered);

        $sql = "UPDATE `processes` SET `actual_quantity` = `actual_quantity` +  '$amount_transfered',
            `total_damaged_item` = {$total_production_fault->total_damaged_item},
            `total_reject_item` = {$total_production_fault->total_reject_item},
            `total_missing_item` = {$total_production_fault->total_missing_item}  WHERE `id_processes` = $id_processes ";
        $this->db->query($sql);
    }

    function update_process_total_production_fault($id_processes) {
        $total_production_fault = $this->get_total_production_fault($id_processes);
        if (empty($id_processes) || $total_production_fault == FALSE) {
            return FALSE;
        }
        $sql = "UPDATE `processes` SET 
            `total_damaged_item` = {$total_production_fault->total_damaged_item},
            `total_reject_item` = {$total_production_fault->total_reject_item},
            `total_missing_item` = {$total_production_fault->total_missing_item}  
             WHERE `id_processes` = $id_processes ";
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

        if ($process_details->process_status == 1) {
            $stop_url = site_url("production_process/change_status/$id_processes/2");
            $reject_url = site_url("production_process/change_status/$id_processes/3");
            $process_status_btn = "&nbsp; &nbsp;<a href=\"$stop_url\" class=\"btn btn-xs btn-success show_confirmation\" data-onfimation_msg=\"Do you want to finish this project ?\">Stop</a>&nbsp; &nbsp;
            <a href=\"$reject_url\" class=\"btn btn-xs btn-danger show_confirmation\" data-onfimation_msg=\"Do you want to reject this project ?\">Reject</a> ";
            $this->table->set_heading('Status', 'Progress ', "Action");
            $this->table->add_row($this->process_status_decoder($process_details->process_status), $progress_bar['progress'] . $progress_bar['bar'], $process_status_btn);
        } else {
            $this->table->set_heading('Status', 'Progress ');
            $this->table->add_row($this->process_status_decoder($process_details->process_status), $progress_bar['progress'] . $progress_bar['bar']);
        }
        $output .= ' <h4>Process details :</h4>';
        $output .= $this->table->generate();
        return $output;
    }

    function process_status_decoder($value, $row = FALSE) {
        if ($value == 1) {
            return '<span class="label label-warning">Ongoing</span>';
        } else if ($value == 2) {
            return '<span class="label label-success">Finished</span>';
        } else if ($value == 3) {
            return '<span class="label label-danger">Rejected</span>';
        }
    }

    function process_status_change($id_processes, $status_code) {
        $current_time = date('Y-m-d h:i:u');
        $sql = "UPDATE `processes` SET `process_status` = '$status_code',
            `date_finished` = '$current_time'
            WHERE `processes`.`id_processes` = $id_processes";
        $this->db->query($sql);
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

    function get_vendor_dropdown($data_only = FALSE, $type = FALSE) {
        if ($type) {
            $this->db->where('type', $type);
        }
        $items = $this->db->get('contact_vendor')->result();
        $data = array();
        $data[''] = 'Select vendor by name or code';
        foreach ($items as $item) {
            $data[$item->id_vendor] = $item->id_vendor . " - " . $item->name . " ( {$item->type} ) ";
        }
        if ($data_only) {
            return $data;
        } else {
            return form_dropdown('id_vendor', $data, '', ' class="select2" ');
        }
    }

    function get_vendor_dropdown_unused($id_processes = FALSE, $data_only = FALSE, $type = FALSE) {
        if ($type) {
            $this->db->where('type', $type);
        }
        if ($id_processes) {
            $this->db->where("`id_vendor` not in (SELECT `id_vendor` FROM `process_steps` WHERE `id_processes` = $id_processes)");
        }
        $items = $this->db->get('contact_vendor')->result();
        $data = array();
        $data[''] = 'Select vendor by name or code';
        foreach ($items as $item) {
            $data[$item->id_vendor] = $item->id_vendor . " - " . $item->name . " ( {$item->type} ) ";
        }
        if ($data_only) {
            return $data;
        } else {
            return form_dropdown('id_vendor', $data, '', ' class="select2" ');
        }
    }

    function get_vendor_dropdown_used_only($id_process_steps) {
        $sql = "SELECT * FROM `view_process_step_child_list` where `id_process_steps` = $id_process_steps";
        $items = $this->db->query($sql)->result();
        $data = array();
        $data[''] = 'Select vendor by name or code';
        foreach ($items as $item) {
            $data[$item->child_id_process_steps] = $item->child_id_vendor . " - " . $item->child_vendor_name . " ( {$item->child_vendor_type} ) ";
        }
        if (empty($data)) {
            return FALSE;
        } else {
            return form_dropdown('id_process_step_to', $data, '', ' class="select2" ');
        }
    }

    function get_vendor_dropdown_used_only_list($id_processes) {
        $sql = "SELECT DISTINCT `id_process_steps` as id_process_steps FROM `view_process_step_child_list` where `id_processes` = $id_processes";
        $items = $this->db->query($sql)->result();
        $data = array();
        foreach ($items as $item) {
            $data[$item->id_process_steps] = $this->get_vendor_dropdown_used_only($item->id_process_steps);
        }
        if (empty($data)) {
            return FALSE;
        } else {
            return $data;
        }
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

    function callback_process_before_process_insert($post_array) {
        $this->callback_process_buffer_id_vendor = $post_array['id_vendor'];
        unset($post_array['id_vendor']);
        return $post_array;
    }

    function callback_process_after_process_insert($post_array, $primary_key) {
        $date_created = date('Y-m-d h:i:u');
        $this->db->query("UPDATE `processes` SET id_process_type = 2 , `date_created` = '$date_created' WHERE `processes`.`id_processes` = $primary_key;");
        $this->add_process_step($primary_key, $this->callback_process_buffer_id_vendor, 1);
    }

}
