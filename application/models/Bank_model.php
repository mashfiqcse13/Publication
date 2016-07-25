<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bank_model
 *
 * @author sonjoy
 */
class Bank_model extends CI_Model{
    //put your code here
     function bank_transection($bank_account = '', $transaction_type = '', $amount = '', $check_num = '') {
        
        $userid = $_SESSION['user_id'];
        $insert_query = 'INSERT INTO `bank_management`(`id_account`, `id_transaction_type`, `transaction_date`, `amount_transaction`, `id_user`,`check_number`) VALUES (' . $bank_account . ',' . $transaction_type . ',' . date('Y-m-d') . ',' . $amount . ',' . $userid . ',' . $check_num . ')';
        $this->db->query($insert_query);
        $bank_management = $this->db->insert_id();

        $insert_status = 'INSERT INTO `bank_management_status`(`approval_status`, `id_bank_management`, `action_date`, `approved_by`) VALUES (3,' . $bank_management . ',' . date('Y-m-d') . ',' . $userid . ')';
        $this->db->query($insert_status);
    }
}
