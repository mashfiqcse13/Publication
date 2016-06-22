<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of party_advance_model
 *
 * @author sonjoy
 */
class party_advance_model extends CI_Model{
    //put your code here
    function add($amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('party_advance')
                        ->where('id_party_advance', 1)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `party_advance` 
                    (`id_party_advance`, `total_in`, `total_out`, `balance`) 
                    VALUES (1, '0', '0', '0');");

        $sql = "UPDATE `party_advance` SET 
                `total_in` = `total_in`+'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `party_advance`.`id_party_advance` = 1;";
        $this->db->query($sql);
        return TRUE;
    }
    
    function reduce($amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('party_advance')
                        ->where('id_party_advance', 1)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `party_advance` 
                    (`id_party_advance`, `total_in`, `total_out`, `balance`) 
                    VALUES (1, '0', '0', '0');");

        $current = $this->db->select('*')
                ->from('party_advance')
                ->where('id_party_advance', 1)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `party_advance` SET 
                `total_out` = `total_out`+'$amount', 
                `balance` = `balance`-'$amount' 
            WHERE `party_advance`.`id_party_advance` = 1;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function add_revert($amount) {
       $current = $this->db->select('*')
                ->from('party_advance')
                ->where('id_party_advance', 1)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `party_advance` SET 
                `total_in` = `total_in`-'$amount', 
                `balance` = `balance`-'$amount' 
            WHERE `party_advance`.`id_party_advance` = 1;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    
    function reduce_revert($amount) {
       $current = $this->db->select('*')
                ->from('party_advance')
                ->where('id_party_advance', 1)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `party_advance` SET 
                `total_out` = `total_out`-'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `party_advance`.`id_party_advance` = 1;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
