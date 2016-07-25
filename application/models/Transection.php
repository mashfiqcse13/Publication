<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transection
 *
 * @author sonjoy
 */
class Transection extends CI_Model {

    //put your code here
    function bank_transection($bank_account = '', $transaction_type = '', $amount = '', $check_num = '') {


        $bank_account = $bank_account;
        $amount = $amount;
        $transaction_type = $transaction_type;
        $check_num = $check_num;
        $userid = $_SESSION['user_id'];
        $insert_query = 'INSERT INTO `bank_management`(`id_account`, `id_transaction_type`, `transaction_date`, `amount_transaction`, `id_user`,`check_number`) VALUES (' . $bank_account . ',' . $transaction_type . ',' . date('Y-m-d') . ',' . $amount . ',' . $userid . ',' . $check_num . ')';
        $this->db->query($insert_query);
        $bank_management = $this->db->insert_id();

        $insert_status = 'INSERT INTO `bank_management_status`(`approval_status`, `id_bank_management`, `action_date`, `approved_by`) VALUES (3,' . $bank_management . ',' . date('Y-m-d') . ',' . $userid . ')';
        $this->db->query($insert_status);
        $bank_management_status = $this->db->insert_id();

        $query = 'SELECT * FROM `bank_management_status` WHERE `id_bank_management_status`= ' . $bank_management_status;
        $approved = $this->db->query($query)->row();

        if ($approved->approval_status == 1) {
            $this->load->model('misc/Bank_balance');
            $CI = & get_instance();
            $this->load->model('misc/Cash', 'cash');
            $CA = & get_instance();
            if ($transaction_type == 1) {
                $CI->Bank_balance->add($bank_account, $amount);
                $CA->cash->add($amount);
            }if ($transaction_type == 2) {
                $CI->Bank_balance->reduce($bank_account, $amount);
                $CA->cash->reduce($amount);
            }
        }
    }

}
