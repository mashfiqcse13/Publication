<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Cash
 *
 * @author MD. Mashfiq
 */
class Bank_balance extends CI_Model {
    /*
     * This will add cash amount to the database table 'Customer_due'
     */

    
    function add($id_account, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('bank_balance')
                        ->where('id_account', $id_account)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `bank_balance` 
                    (`id_bank_balance`, `id_account`, `total_in`, `total_out`, `balance`)
                    VALUES (NULL, '$id_account', '0', '0', '0');");

        $sql = "UPDATE `bank_balance` SET 
                `total_in` = `total_in`+'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `bank_balance`.`id_account` = $id_account;";
        $this->db->query($sql);
        return TRUE;
    }
    
    function add_reverse($id_account, $amount) {
                
        $current = $this->db->select('*')
                ->from('bank_balance')
                ->where('id_account', $id_account)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `bank_balance` SET 
                `total_in` = `total_in`-'$amount', 
                `balance` = `balance`-'$amount' 
            WHERE `bank_balance`.`id_account` = $id_account;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    
        function reduce_reverse($id_account, $amount) {
                
        $current = $this->db->select('*')
                ->from('bank_balance')
                ->where('id_account', $id_account)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `bank_balance` SET 
                `total_out` = `total_out`-'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `bank_balance`.`id_account` = $id_account;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    

    function reduce($id_account, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('bank_balance')
                        ->where('id_account', $id_account)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `bank_balance` 
                    (`id_bank_balance`, `id_account`, `total_in`, `total_out`, `balance`)
                    VALUES (NULL, '$id_account', '0', '0', '0');");
        
        $current = $this->db->select('*')
                ->from('bank_balance')
                ->where('id_account', $id_account)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `bank_balance` SET 
                `total_out` = `total_out`+'$amount', 
                `balance` = `balance`-'$amount' 
            WHERE `bank_balance`.`id_account` = $id_account;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function record_count() {
        return $this->db->count_all("bank_management_status");
    }
    
    function list_bank_status($limit,$start){
        $query=$this->db->query("select "
                . "transaction_date,name_bank, account_number,amount_transaction,name_trnsaction_type, username,approval_status,id_bank_management_status"
                . " from "
                . "`bank_management_status`,`bank_management`, `bank_transaction_type`,`bank_account`, `users`,`bank`"
                . " where "
                . "bank_management_status.id_bank_management=bank_management.id_bank_management "
                . "and bank_management.id_account=bank_account.id_bank_account "
                . "and bank_management.id_transaction_type=bank_transaction_type.id_trnsaction_type "
                . "and bank_account.id_bank=bank.id_bank "
                . "and bank_management.id_user=users.id"
                . " ORDER BY bank_management_status.id_bank_management DESC LIMIT $start,$limit");
                
        
        return $query;
    }
    
    
    
   

}
