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
                . "transaction_date,name_bank, account_number,CONCAT('TK ',amount_transaction),name_trnsaction_type, username,approval_status,id_bank_management_status"
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
    
    function bank_report($date){
        $date=$this->dateformatter($date);
        
        $range_query=$this->db->query("SELECT name_bank,account_number,name_trnsaction_type,transaction_date,CONCAT('TK ',amount_transaction),username,check_number,media_link FROM `bank_management`
LEFT JOIN bank_account on bank_account.id_bank_account=bank_management.id_account
LEFT join bank on bank.id_bank=bank_account.id_bank
left JOIN bank_transaction_type on bank_transaction_type.id_trnsaction_type=bank_management.id_transaction_type
left JOIN users on users.id=bank_management.id_user 
WHERE transaction_date BETWEEN $date");
        
        $this->load->library('table');
        $this->table->set_heading(array('Bank Name', 'Account Number', 'Transaction Type','Transaction Date','Amount','User','Check Number','Media Link'));
        $tmpl = array (
                    'table_open'          => '<table class="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr style="background:#ddd">',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
        
        $this->table->set_template($tmpl);
                $this->table->set_caption('<h2 class="text-center">Advanced Publication</h2><br>'
                . '<h4><span class="pull-left">Date Range:'.$this->datereport($date).'</span>'
                . '<span class="pull-right">Report Date: '.date('Y-m-d h:i').'</span></h4>'
                . '<style>td:nth-child(5) {    text-align: right;}</style>');
        return $this->table->generate($range_query);
        
        
    }
    
    
    
    
    function datereport($date){
        $date= str_replace("'", ' ', $date);
        $date=  str_replace('and', 'to', $date);
        return $date;
    }
    
    
    function dateformatter($range_string, $formate = 'Mysql') {
        $date = explode(' - ', $range_string);
        $date[0] = explode('/', $date[0]);
        $date[1] = explode('/', $date[1]);

        if ($formate == 'Mysql')
            return "'{$date[0][2]}-{$date[0][0]}-{$date[0][1]}' and '{$date[1][2]}-{$date[1][0]}-{$date[1][1]}'";
        else
            return $date;
    }
    
   

}
