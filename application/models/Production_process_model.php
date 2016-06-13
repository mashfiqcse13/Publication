<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Production_process_model
 *
 * @author MD. Mashfiq
 */
class Production_process_model extends CI_Model {
    
    function get_wearhouse_dropdown() {
        $this->db->select('*');
        $this->db->from('stock_warehouse');
        $this->db->order_by('warehouse_type', "desc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        foreach ($db_rows as $index => $row) {
            $options[$row['stock_warehouse_id']] = $row['name'] . "('{$row['warehouse_type']}')";
        }

        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('to_contact_id', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"');
    }

    function get_wearhouse_table($warehouse_type = 'Printing Press') {
        $this->load->library('table');
        $this->db->select('warehouse_stock_id, items.name as item_name, stock_warehouse.name as warehouse_name,'
//                . 'contact_type,'
                . 'quantity');
//        $this->db->select('*');
        $this->db->from('stock_warehouse_stock');
        $this->db->join("items", "items.id_item = stock_warehouse_stock.id_item");
        $this->db->join("stock_warehouse", "stock_warehouse.stock_warehouse_id = stock_warehouse_stock.stock_warehouse_id");
        $this->db->where('warehouse_type', $warehouse_type)
                ->order_by('stock_warehouse_stock.id_item', 'ASC');
        $query = $this->db->get();
        $db_rows = $query->result_array();

//        setting table settings

        $this->table->set_heading('#', 'Book Name', 'Store Name', 'Quantity', 'Action');
        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-bordered">',
            'heading_cell_start' => '<th class="bg-primary" style="vertical-align: top;">'
        );
        $this->table->set_template($tmpl);
        $table_rows = $db_rows;
        foreach ($db_rows as $index => $row) {
            $table_rows[$index]['warehouse_stock_id'] = $index + 1;
            $table_rows[$index]['action'] = '<button id="buttonTransfer" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-StockId="' . $db_rows[$index]['warehouse_stock_id'] . '" data-maxQuantity="' . $db_rows[$index]['quantity'] . '" data-target="#myModal"><span class="glyphicon glyphicon-transfer"></span></button>';
        }

        return $this->table->generate($table_rows);
    }
}
