<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Employee_model
 *
 * @author sonjoy
 */
class Customer_model extends CI_Model {

    function select_all() {
        $this->db->select('*');
        $this->db->from('employee');
        $query = $this->db->get();
        return $query->result();
    }

    function sales_info() {
        $this->db->select('*');
        $this->db->from('pub_memos');
        $this->db->where('due!=', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function save_info($data) {
        $this->db->insert('customer_payment', $data);
    }

    function update_customer_due($id, $amount) {
        $current = $this->db->select('*')
                ->from('customer_due')
                ->where('id_customer', $id)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->total_due >= $amount) {
            $this->db->query('UPDATE `customer_due` SET `total_due` = `total_due` - ' . $amount . ' WHERE `id_customer` =' . $id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function update_cash($amount) {
        $current = $this->db->select('*')
                ->from('cash')
                ->where('id_cash', 1)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `cash` SET 
                `total_out` = `total_out`+'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `cash`.`id_cash` = 1;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function update_pub_memo($id, $amount) {
        $current = $this->db->select('*')
                ->from('pub_memos')
                ->where('memo_ID', $id)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->due >= $amount) {
            $this->db->query('UPDATE `pub_memos` SET `cash` =`cash` + ' . $amount . ',`due` = `due` - ' . $amount . ' WHERE `memo_ID` =' . $id);
            return TRUE;
        } else {
            return FALSE;
        }
//        
    }

}
