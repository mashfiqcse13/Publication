<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Cash
 *
 * @author MD. Mashfiq
 */
class Stationary_stock extends CI_Model {
    /*
     * This will add cash amount to the database table 'Customer_due'
     */

    function add($id_name_expense, $quantity) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('stationary_stock')
                        ->where('id_name_expense', $id_name_expense)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `stationary_stock` 
                    (`id_stationary_stock`, `id_name_expense`, `total_in`, `total_out`, `total_balance`)
                    VALUES (NULL, '$id_name_expense', '0', '0', '0');");

        $sql = "UPDATE `stationary_stock` SET 
                `total_in` = `total_in`+'$quantity', 
                `total_balance` = `total_balance`+'$quantity' 
            WHERE `stationary_stock`.`id_name_expense` = $id_name_expense;";
        $this->db->query($sql);
        return TRUE;
    }

    function reduce($id_name_expense, $quantity) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('stationary_stock')
                        ->where('id_name_expense', $id_name_expense)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `stationary_stock` 
                    (`id_stationary_stock`, `id_name_expense`, `total_in`, `total_out`, `total_balance`)
                    VALUES (NULL, '$id_name_expense', '0', '0', '0');");
        
        $current = $this->db->select('*')
                ->from('stationary_stock')
                ->where('id_name_expense', $id_name_expense)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->total_balance >= $quantity) {
            $sql = "UPDATE `stationary_stock` SET 
                `total_out` = `total_out`+'$quantity', 
                `total_balance` = `total_balance`-'$quantity' 
            WHERE `stationary_stock`.`id_name_expense` = $id_name_expense;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
