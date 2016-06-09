<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stock
 *
 * @author sonjoy
 */
class Stock_model extends CI_Model {

    //put your code here
    function select_stock() {
        $sql = "SELECT * FROM `stock_perpetual_stock_register` natural join `items`";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function search_item($start_date, $end_date) {
//        print_r($start_date);exit();
        $this->db->select('*');
        $this->db->from('stock_perpetual_stock_register');
        $this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" and "' . date('Y-m-d', strtotime($end_date)) . '"');
        $query = $this->db->get();
        return $query->result();
    }
    
     /*
     * This will add cash amount to the database table 'Customer_due'
     */

    function stock_add($id_item, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('stock_final_stock')
                        ->where('id_item', $id_item)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `stock_final_stock` 
                    (`id_final_stock`, `id_item`, `total_in`, `total_out`, `total_in_hand`)
                    VALUES (NULL, '$id_item', '0', '0', '0');");

        $sql = "UPDATE `stock_final_stock` SET 
                `total_in` = `total_in`+'$amount', 
                `total_in_hand` = `total_in_hand`+'$amount' 
            WHERE `stock_final_stock`.`id_item` = $id_item;";
        $this->db->query($sql);
        return TRUE;
    }

    function stock_reduce($id_item, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('stock_final_stock')
                        ->where('id_item', $id_item)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `stock_final_stock` 
                    (`id_final_stock`, `id_item`, `total_in`, `total_out`, `total_in_hand`)
                    VALUES (NULL, '$id_item', '0', '0', '0');");

        $current = $this->current_stock_info($id_item);
        if ($current->total_in_hand >= $amount) {
            $sql = "UPDATE `stock_final_stock` SET 
                `total_out` = `total_out`+'$amount', 
                `total_in_hand` = `total_in_hand`-'$amount' 
            WHERE `stock_final_stock`.`id_item` = $id_item;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    
    // get current customer due all data as a db row object
    function current_stock_info($id_item) {
        $current = $this->db->select('*')
                ->from('stock_final_stock')
                ->where('id_item', $id_item)
                ->get()
                ->result();
        if (empty($current[0])) {
            return FALSE;
        }
        return $current[0];
    }

    // get current customer due
    function current_total_in_hand($id_item) {
        $result = $this->current_stock_info($id_item);
        if ($result) {
            return $result->total_in_hand;
        } else {
            return 0;
        }
    }

}
