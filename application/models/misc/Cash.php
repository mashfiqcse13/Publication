<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Cash
 *
 * @author MD. Mashfiq
 */
class Cash extends CI_Model {
    /*
     * This will add cash amount to the database table 'Cash'
     */

    function add($amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('cash')
                        ->where('id_cash', 1)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `cash` 
                    (`id_cash`, `total_in`, `total_out`, `balance`) 
                    VALUES (1, '0', '0', '0');");

        $sql = "UPDATE `cash` SET 
                `total_in` = `total_in`+'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `cash`.`id_cash` = 1;";
        $this->db->query($sql);
        return TRUE;
    }

    function reduce($amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('cash')
                        ->where('id_cash', 1)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `cash` 
                    (`id_cash`, `total_in`, `total_out`, `balance`) 
                    VALUES (1, '0', '0', '0');");

        $current = $this->db->select('*')
                ->from('cash')
                ->where('id_cash', 1)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `cash` SET 
                `total_out` = `total_out`+'$amount', 
                `balance` = `balance`-'$amount' 
            WHERE `cash`.`id_cash` = 1;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    
    function add_revert($amount) {
       $current = $this->db->select('*')
                ->from('cash')
                ->where('id_cash', 1)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `cash` SET 
                `total_in` = `total_in`-'$amount', 
                `balance` = `balance`-'$amount' 
            WHERE `cash`.`id_cash` = 1;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
        function reduce_revert($amount) {
       $current = $this->db->select('*')
                ->from('cash')
                ->where('id_cash', 1)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `cash` SET 
                `total_out` = `total_out`-'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `cash`.`id_cash` = 1;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    

}
