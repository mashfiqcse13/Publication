<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Advance_payment_model
 *
 * @author MD. Mashfiq
 */
class Advance_payment_model extends CI_Model {

    function payment_add($id_customer, $amount, $id_method) {
        // If this user have previous due
        $this->load->model('misc/Customer_due');
        $this->load->model('misc/Customer_due_payment');
        $current_total_due = $this->Customer_due->current_total_due($id_customer);
        if ($current_total_due > 0) {
            if ($current_total_due >= $amount) {
                $this->Customer_due_payment->add($id_customer, $amount);
                return TRUE;
            } else {
                $amount -= $current_total_due;
                $this->Customer_due_payment->add($id_customer, $current_total_due);
            }
        }

        if ($id_method == 1) {
            $this->load->model('misc/Cash');
            $this->Cash->add($amount);
        }

        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('party_advance')
                        ->where('id_customer', $id_customer)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `party_advance` 
                    (`id_customer`, `total_in`, `total_out`, `balance`)
                    VALUES ( '$id_customer', '0', '0', '0');");

        $sql = "UPDATE `party_advance` SET 
                `total_in` = `total_in`+'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `party_advance`.`id_customer` = $id_customer;";
        $this->db->query($sql);

        $this->payment_register($id_customer, $id_method, $amount);

        return TRUE;
    }

    function payment_reduce($id_customer, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('party_advance')
                        ->where('id_customer', $id_customer)
                        ->get()->result() or
                $this->db->query("INSERT INTO `party_advance` 
                    (`id_customer`, `total_in`, `total_out`, `balance`)
                    VALUES ( '$id_customer', '0', '0', '0');");

        $current = $this->current_payment_info($id_customer) or die("Failed to get current info");
        if ($current->balance >= $amount) {
            $sql = "UPDATE `party_advance` SET 
                `total_out` = `total_out`+'$amount', 
                `balance` = `balance`- '$amount' 
            WHERE `party_advance`.`id_customer` = $id_customer;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function payment_register($id_customer, $id_payment_method, $amount_paid) {
        $current_date = date('Y-m-d H:i:s');
        $register = "INSERT INTO `party_advance_payment_register`
            (`id_customer`, `id_payment_method`, `amount_paid`, `date_payment`)
            VALUES ('$id_customer','$id_payment_method','$amount_paid','$current_date')";
        $this->db->query($register);
    }

    // get current customer due all data as a db row object
    function current_payment_info($id_customer) {
        $current = $this->db->select('*')
                        ->from('party_advance')
                        ->where('id_customer', $id_customer)
                        ->get()->result();
        if (empty($current[0])) {
            return FALSE;
        }
        return $current[0];
    }

    function get_payment_method_dropdown() {
        $items = $this->db->get('payment_method')->result();

        $data = array();
        foreach ($items as $item) {
            $data[$item->id_payment_method] = $item->name_payment_method;
        }
        return form_dropdown('id_payment_method', $data, '', ' class="select2" ');
    }

    function get_all_advance_payment_balance() {
        $customers = $this->db->query("SELECT id_customer,balance
                            FROM party_advance
                            WHERE balance > 0 ")->result();

        $data = array();
        foreach ($customers as $customer) {
            $data[$customer->id_customer] = $customer->balance;
        }
        return $data;
    }

    function get_advance_payment_balance_by($id_customer) {
        $all_advance_payment_balance = $this->get_all_advance_payment_balance();
        if (empty($all_advance_payment_balance[$id_customer])) {
            return 0;
        } else {
            return $all_advance_payment_balance[$id_customer];
        }
    }

}
