<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Cash
 *
 * @author MD. Mashfiq
 */
class Customer_due extends CI_Model {
    /*
     * This will add cash amount to the database table 'Customer_due'
     */

    function add($id_customer, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('customer_due')
                        ->where('id_customer', $id_customer)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `customer_due` 
                    (`id_customer_due`, `id_customer`, `total_due_billed`, `total_paid`, `total_due`)
                    VALUES (NULL, '$id_customer', '0', '0', '0');");

        $sql = "UPDATE `customer_due` SET 
                `total_due_billed` = `total_due_billed`+'$amount', 
                `total_due` = `total_due`+'$amount' 
            WHERE `customer_due`.`id_customer` = $id_customer;";
        $this->db->query($sql);
        return TRUE;
    }

    function reduce($id_customer, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('customer_due')
                        ->where('id_customer', $id_customer)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `customer_due` 
                    (`id_customer_due`, `id_customer`, `total_due_billed`, `total_paid`, `total_due`)
                    VALUES (NULL, '$id_customer', '0', '0', '0');");

        $current = $this->current_due_info($id_customer);
        if ($current->total_due >= $amount) {
            $sql = "UPDATE `customer_due` SET 
                `total_paid` = `total_paid`+'$amount', 
                `total_due` = `total_due`-'$amount' 
            WHERE `customer_due`.`id_customer` = $id_customer;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // get current customer due all data as a db row object
    function current_due_info($id_customer) {
        $current = $this->db->select('*')
                ->from('customer_due')
                ->where('id_customer', $id_customer)
                ->get()
                ->result();
        return $current[0];
    }

    // get current customer due
    function current_total_due($id_customer) {
        return $this->current_due_info($id_customer)->total_due;
    }

    // this will get information of customer due from total_sales table
    function details_from_total_sales($customer_id) {
        $sql = "SELECT `id_total_sales`,`id_customer`, `total_amount`, `cash`, `bank_pay`, `total_paid`, `total_due`
            FROM `sales_total_sales` 
            WHERE `id_customer`= $customer_id and `total_due`> 0";
        return $this->db->query($sql)->result();
    }

    function due_detail_table($customer_id) {
        $sql = "SELECT `id_total_sales`, `issue_date`, `discount_amount`, `sub_total`, `total_amount`, `total_paid`, `total_due`
            FROM `sales_total_sales` 
            WHERE `id_customer`= $customer_id and `total_due`> 0";
        $table_data = $this->db->query($sql)->result_array();
        $this->load->library('table');

        $this->table->set_heading('Memo No', 'Sales Date', 'Discount', 'Sub total', 'Total', 'Total Paid', 'Due');
        $template = array(
            'table_open' => '<table class="table table-bordered table-hover">',
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

        $this->table->set_template($template);
        $output = $this->table->generate($table_data);
        return $output;
    }

}
