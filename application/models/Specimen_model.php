<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Specimen_model
 *
 * @author MD. Mashfiq
 */
class Specimen_model extends CI_Model {
     function __construct() {
        parent::__construct();
         $this->load->model('Common');
    }

    function get_agent_dropdown() {
        $customers = $this->db->get('specimen_agent')->result();

        $data = array();
        $data[''] = 'Select Agent/Marketing Officer by name or code';
        foreach ($customers as $customer) {
            $data[$customer->id_agent] = $customer->id_agent . " ( ". $this->Common->en2bn($customer->id_agent) . ") - " . $customer->name;
        }
        return form_dropdown('id_agent', $data, NULL, ' class="select2" required');
    }
    
    

    function get_agent_dropdown_who_have_taken_specimen() {
        $sql = "SELECT distinct(`id_agent`), `name` FROM `specimen_total` natural join `specimen_agent`";
        $customers = $this->db->query($sql)->result();

        $data = array();
        $data[''] = 'Select Agent/Marketing Officer by name or code';
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
        } else if ($action == 'save_and_print') {
            $response['msg'] = "The sales is successfully done . \n Specimen Issue: $id_specimen_total";
            $response['next_url'] = site_url('specimen/memo/'.$id_specimen_total);
        }
        echo json_encode($response);
    }
    
    function get_report_table_issue($id_agent = '', $id_item = '', $date_range = ''){
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
        $sql = $this->db->query("SELECT items.id_item as id_item,items.name as item_name,sum(amount_copy) as issue_quantity FROM specimen_total
                                            left JOIN specimen_items ON specimen_total.id_specimen_total=specimen_items.id_specimen_total
                                            left JOIN specimen_agent ON specimen_agent.id_agent=specimen_total.id_agent
                                            left JOIN items ON specimen_items.id_item=items.id_item 
                                            where $where
                                            GROUP BY items.id_item order by  items.id_item ASC")->result();
        return $sql;
    }
    function get_report_table_return($id_agent = '', $id_item = '', $date_range = '') {
        $where = array();
        if (!empty($id_agent)) {
            array_push($where, "specimen_return_total.id_agent = $id_agent");
        }
        if (!empty($id_item)) {
            array_push($where, "specimen_return_items.id_item = $id_item");
        }
        if (!empty($date_range)) {
            array_push($where, "date(date_entry) BETWEEN" . $this->Common->convert_date_range_to_mysql_between($date_range));
        }
        if (empty($where) && sizeof($where) == 0) {
            $where = 1;
        } else {
            $where = implode(' AND ', $where);
        }
        
         $sql= $this->db->query("SELECT items.id_item as id_item,items.name as item_name,sum(amount_copy) as return_quantity FROM specimen_return_total
                    left JOIN specimen_return_items ON specimen_return_total.id_specimen_total=specimen_return_items.specimen_return_items_id
                    left JOIN specimen_agent ON specimen_agent.id_agent=specimen_return_total.id_agent
                    left JOIN items ON specimen_return_items.id_item=items.id_item 
                    where $where 
                    GROUP BY items.id_item order by  items.id_item ASC  ")->result();
        return $sql;
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

    function specimen_memo_header_details($id_specimen_total) {
        $sql = "SELECT specimen_agent.name as agent_name,
            specimen_agent.district,
            specimen_agent.address,
            specimen_agent.phone,
            specimen_agent.id_agent,
            specimen_total.id_specimen_total,
            specimen_total.date_entry
            FROM specimen_total
            natural join specimen_agent
            where specimen_total.id_specimen_total ='$id_specimen_total'";
        $data = $this->db->query($sql)->result_array();
        Return $data[0];
    }

    function memo_body_table($id_specimen_total) {
        $this->load->library('table');
        // setting up the table design
        $tmpl = array(
            'table_open' => '<table class="table table-bordered table-striped text-right-for-money">',
            'heading_row_start' => '<tr class="success">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td >',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td >',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Quantity', 'Item Name & Code', 'Regular Price', 'Sales Price', 'Total Price');
        //Getting the data form the sales table in db
        $sql = "SELECT `id_item`,`amount_copy` as quantity,`items`.`name`, `items`.`regular_price`,`sale_price`,`amount_copy`* `sale_price` as sub_total 
                    FROM `specimen_items`
                    natural join `items`
                    WHERE `id_specimen_total` = $id_specimen_total";
        $rows = $this->db->query($sql)->result();
        $total_quantity = 0;
        $total_price = 0;
        foreach ($rows as $row) {
            $total_quantity += $row->quantity;
            $total_price += $row->sub_total;
            $this->table->add_row($row->quantity, $row->id_item . " - " . $row->name, $row->regular_price, $row->sale_price, $row->sub_total);
        }
        // Showing total book amount
        $separator_row = array(
            'class' => 'separator'
        );

        
        $this->table->add_row($total_quantity, '(Total Book ) ', array(
            'data' => 'বই মূল্য : ',
            'class' => 'left_separator',
            'colspan' => 2
                ), $this->Common->taka_format($total_price));
        $this->table->add_row(array(
            'data' => '<strong>কথায় : </strong> ',
            'colspan' => 1
                ), array(
            'data' => $this->Common->convert_number($total_price),
            'colspan' => 4
        ));
        return $this->table->generate();
    }
    
    
    
    
    
    function get_item_details_from_specimen_items($memo_id) {
        $items = $this->db->query("SELECT id_agent,specimen_items.id_item as id_item, name ,amount_copy FROM `specimen_items` LEFT JOIN specimen_total ON specimen_total.id_specimen_total=specimen_items.id_specimen_total
LEFT JOIN items ON items.id_item=specimen_items.id_item WHERE specimen_items.id_specimen_total= $memo_id")->result();

        $data = array();
        foreach ($items as $item) {
            $data[$item->id_item] = array(
                'id_agent' => $item->id_agent,
                'id_item' => $item->id_item,
                'name' => $item->name,
                'total_in_hand' => $item->amount_copy,
            );
        }
        return $data;
    }
    
   function get_specimen_dropdown() {
        $specimens = $this->db->order_by('id_specimen_total','desc')->get('specimen_total')->result();

        $data = array();
        $data[''] = 'Select Specimen Memo Number';
        foreach ($specimens as $specimen) {
            $data[$specimen->id_specimen_total] = $specimen->id_specimen_total  ." ( ". $this->Common->en2bn($specimen->id_specimen_total) . ") ";
        }
        return form_dropdown('id_specimen_total', $data, NULL, ' class="select2" required');
    }
      function get_available_specimen_item_dropdown($id) {

        $items = $this->db->query("SELECT specimen_items.id_item as id_item, name ,amount_copy FROM `specimen_items` LEFT JOIN specimen_total ON specimen_total.id_specimen_total=specimen_items.id_specimen_total
LEFT JOIN items ON items.id_item=specimen_items.id_item
            WHERE `amount_copy` > 0 AND specimen_total.id_specimen_total=$id  ")->result(); 

        $data = array();
        $data[''] = 'Select items by name or code';
        foreach ($items as $item) {
            $data[$item->id_item] = $item->id_item . " - " . $item->name;
        }
        return form_dropdown('id_item', $data, '', ' class="select2" ');
    }
    
    
    function processing_return_specimen() {
        $this->load->model('misc/Stock_perpetual');
        $this->load->model('Stock_model');

        $id_agent = $this->input->post('id_agent');
        $memo_id = $this->input->post('memo_id');

        $data = array(
            'id_agent' => $id_agent,
            'date_entry' => date('Y-m-d h:i:u'),
            'id_employee' => $_SESSION['user_id']
        );

        $this->db->insert('specimen_return_total', $data) or die('failed to insert data on specimen_return_total');


        $id_specimen_total = $this->db->insert_id() or die('failed to insert data on specimen_return_total');

        $item_selection = $this->input->post('item_selection');
        $data_sales = array();
        foreach ($item_selection as $value) {
            if (empty($value)) {
                continue;
            }
            $tmp_data_sales = array(
                'id_specimen_return_total' => $id_specimen_total,
                'id_item' => $value['item_id'],
                'amount_copy' => $value['item_quantity']
            );
            
            //update 
            $this->db->query("UPDATE `specimen_items` SET `amount_copy`=amount_copy - ".$value['item_quantity']." 
                                            WHERE id_item = ".$value['item_id']. " AND id_specimen_total=$memo_id " );
            
            array_push($data_sales, $tmp_data_sales);
            $this->Stock_perpetual->Stock_perpetual_register($value['item_id'], $value['item_quantity'], 5);
            $this->Stock_model->stock_add($value['item_id'], $value['item_quantity']);
        }


        $this->db->insert_batch('specimen_return_items', $data_sales) or die('failed to insert data on specimen_return_items');
        $action = $this->input->post('action');
        if ($action == 'save_and_reset') {
            $response['msg'] = "The specimen return issue is successfully done . \n Specimen Issue: $id_specimen_total";
            $response['next_url'] = site_url('specimen/specimen_return');
        } else if ($action == 'save_and_back_to_list') {
            $response['msg'] = "The sales is successfully done . \n Specimen Issue: $id_specimen_total";
            $response['next_url'] = site_url('specimen/specimen_return_list');
        } else if ($action == 'save_and_print') {
            $response['msg'] = "The sales is successfully done . \n Specimen Issue: $id_specimen_total";
            $response['next_url'] = site_url('specimen/return_memo/'.$id_specimen_total);
        }
        echo json_encode($response);
    }
    
    
    function get_agent_dropdown_by_id($id) {
        $sql = $this->db->get_where('specimen_agent',array('id_agent ' => $id))->result();

        $data = array();
         $data = '<select id="field-id_account" name="id_agent" class="select2 chosen-select chzn-done" data-placeholder="Select Memo Number" required>';
        $data.='<option value="">Select Memo Number</option>';
        foreach ($sql as $row) {
            $data.='<option selected value="' . $row->id_agent . '">' . $row->name . '</option>';
        }
        $data.='</select>';
        
        
        return $data;
    }
    
    
    function return_memo_body_table($id_specimen_total) {
        $this->load->library('table');
        // setting up the table design
        $tmpl = array(
            'table_open' => '<table class="table table-bordered table-striped text-right-for-money">',
            'heading_row_start' => '<tr class="success">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td >',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td >',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Quantity', 'Item Name & Code', 'Regular Price', 'Sales Price', 'Total Price');
        //Getting the data form the sales table in db
        $sql = "SELECT `id_item`,`amount_copy` as quantity,`items`.`name`, `items`.`regular_price`,`sale_price`,`amount_copy`* `sale_price` as sub_total 
                    FROM `specimen_return_items`
                    natural join `items`
                    WHERE `id_specimen_return_total` = $id_specimen_total";
        $rows = $this->db->query($sql)->result();
        $total_quantity = 0;
        $total_price = 0;
        foreach ($rows as $row) {
            $total_quantity += $row->quantity;
            $total_price += $row->sub_total;
            $this->table->add_row($row->quantity, $row->id_item . " - " . $row->name, $row->regular_price, $row->sale_price, $row->sub_total);
        }
        // Showing total book amount
        $separator_row = array(
            'class' => 'separator'
        );

   
        $this->table->add_row($total_quantity, '(Total Book ) ', array(
            'data' => 'বই মূল্য : ',
            'class' => 'left_separator',
            'colspan' => 2
                ), $this->Common->taka_format($total_price));
        $this->table->add_row(array(
            'data' => '<strong>কথায় : </strong> ',
            'colspan' => 1
                ), array(
            'data' => $this->Common->convert_number($total_price),
            'colspan' => 4
        ));
        return $this->table->generate();
    }
    
    function return_specimen_memo_header_details($id_specimen_total) {
        $sql = "SELECT specimen_agent.name as agent_name,
            specimen_agent.district,
            specimen_agent.address,
            specimen_agent.phone,
            specimen_agent.id_agent,
            specimen_return_total.id_specimen_total,
            specimen_return_total.date_entry
            FROM specimen_return_total
            natural join specimen_agent
            where specimen_return_total.id_specimen_total ='$id_specimen_total'";
        $data = $this->db->query($sql)->result_array();
        Return $data[0];
    }

}
