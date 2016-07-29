<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Master_reconcillation_model
 *
 * @author MD. Mashfiq
 */
class Master_reconcillation_model extends CI_Model {

    function initialize() {
        $id_master_reconcillation = $this->id_today_row();
        if ($id_master_reconcillation == FALSE) {
            $id_master_reconcillation = $this->start_today_row();
        }
        return $id_master_reconcillation;
    }

    function id_today_row() {
        $where = array(
            'date' => date('Y-m-d')
        );
        $result = $this->db->select('id_master_reconcillation')
                        ->from('master_reconcillation')
                        ->where($where)
                        ->get()->result();
        if (empty($result[0])) {
            return FALSE;
        }
        return $result[0]->id_master_reconcillation;
    }

    function start_today_row() {
        $this->load->model('misc/Cash');
        $this->load->model('misc/Customer_due');
        $this->load->model('misc/Bank_balance');
        $cash_in_hand = $this->Cash->cash_in_hand();
        $total_due = $this->Customer_due->total_due();
        $total_bank_balance = $this->Bank_balance->total_bank_balance();
        $data_to_insert = array(
            'total_sales' => 0,
            'opening_cash' => $cash_in_hand,
            'ending_cash' => $cash_in_hand,
            'opening_due' => $total_due,
            'ending_due' => $total_due,
            'opening_bank_balance' => $total_bank_balance,
            'closing_bank_balance' => $total_bank_balance,
            'date' => date('Y-m-d')
        );

        $this->db->insert('master_reconcillation', $data_to_insert);

        return $this->id_today_row();
    }

    function add_total_sale($amount) {
        $id_master_reconcillation = $this->initialize();
        $sql = "UPDATE `master_reconcillation` SET `total_sales`=`total_sales`+ $amount  WHERE `id_master_reconcillation` = $id_master_reconcillation";
        $this->db->query($sql);
    }

    function add_cash($amount) {
        $id_master_reconcillation = $this->initialize();
        $sql = "UPDATE `master_reconcillation` SET `ending_cash`=`ending_cash`+ $amount  WHERE `id_master_reconcillation` = $id_master_reconcillation";
        $this->db->query($sql);
    }
    
    function reduce_cash($amount) {
        $id_master_reconcillation = $this->initialize();
        $sql = "UPDATE `master_reconcillation` SET `ending_cash`=`ending_cash`- $amount  WHERE `id_master_reconcillation` = $id_master_reconcillation";
        $this->db->query($sql);
    }

    function add_due($amount) {
        $id_master_reconcillation = $this->initialize();
        $sql = "UPDATE `master_reconcillation` SET `ending_due`=`ending_due`+ $amount  WHERE `id_master_reconcillation` = $id_master_reconcillation";
        $this->db->query($sql);
    }
    function reduce_due($amount) {
        $id_master_reconcillation = $this->initialize();
        $sql = "UPDATE `master_reconcillation` SET `ending_due`=`ending_due`- $amount  WHERE `id_master_reconcillation` = $id_master_reconcillation";
        $this->db->query($sql);
    }

    function add_bank_balance($amount) {
        $id_master_reconcillation = $this->initialize();
        $sql = "UPDATE `master_reconcillation` SET `closing_bank_balance`=`closing_bank_balance`+ $amount  WHERE `id_master_reconcillation` = $id_master_reconcillation";
        $this->db->query($sql);
    }
    
    function reduce_bank_balance($amount) {
        $id_master_reconcillation = $this->initialize();
        $sql = "UPDATE `master_reconcillation` SET `closing_bank_balance`=`closing_bank_balance`- $amount  WHERE `id_master_reconcillation` = $id_master_reconcillation";
        $this->db->query($sql);
    }

}
