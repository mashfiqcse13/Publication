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
    
    
    function  get_list(){
        $this->load->library('table');
        
        $query=$this->db->query("SELECT * FROM `bank_management_status` "
                . "LEFT JOIN bank_management ON "
                . "bank_management.id_bank_management=bank_management_status.id_bank_management"
                . " ORDER BY bank_management_status.id_bank_management DESC")
                ->result_array();
        
         $tmpl = array (
                    'table_open'          => '<table class="table table-bordered table-striped">',

                    'heading_row_start'   => '<tr>',
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
            $this->table->set_heading('Date', 'Bank Name', 'Account No.', 'Amount', 'Transaction Type', 'User Entered','Approval Status');

            return $this->table->generate($query);
    }
        
   

}
