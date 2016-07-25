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
class Bank_model extends CI_Model {

//put your code here
    function bank_transection($id_account, $id_transaction_type, $amount, $check_num, $approval_status = 3) {

        $userid = $_SESSION['user_id'];
        $current_date = date('Y-m-d h:i:u');
        $insert_query = "INSERT INTO `bank_management`(`id_account`, `id_transaction_type`, `transaction_date`, `amount_transaction`, `id_user`,`check_number`) VALUES ( $id_account , $id_transaction_type,'$current_date','$amount','$userid','$check_num')";
        $this->db->query($insert_query);
        $id_bank_management = $this->db->insert_id();

        $insert_status = "INSERT INTO `bank_management_status`(`approval_status`, `id_bank_management`, `action_date`, `approved_by`) VALUES ('$approval_status','$id_bank_management','$current_date' ,'$userid' )";
        $this->db->query($insert_status);
        
        if($approval_status==1 && $id_transaction_type==1 ){
            $this->load->model('misc/Bank_balance');
            $this->Bank_balance->add($id_account,$amount);
        }
        
    }

    function get_account_dropdown() {
        $sql = $this->db->query("SELECT id_bank_account, name_bank, account_number FROM `bank_account` LEFT JOIN bank ON bank.id_bank = bank_account.id_bank");
        $data = array();
        $data = '<select id="field-id_account" name="id_account" class="select2 chosen-select chzn-done" data-placeholder="Select Account Name" required>';
        $data.='<option value="">Select Account Name</option>';
        foreach ($sql->result() as $row) {
            $data.='<option value="' . $row->id_bank_account . '">' . $row->name_bank . '-' . $row->account_number . '</option>';
        }
        $data.='</select>';
        return $data;
    }

}
