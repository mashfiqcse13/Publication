<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Due
 *
 * @author MD. Mashfiq
 */
class Due_model extends CI_Model {
    /*
     * adding due pamente to the due 
     * 
     * @param int
     * @param int
     * @return void
     */

    function add_payment($memo_ID, $amount, $date) {
        $db_tables = $this->config->item('db_tables');
        $data = array(
            'momo_ID' => $memo_ID,
            'due_paid_amount' => $amount
        );
        $this->db->insert($db_tables['pub_due_payment_ledger'], $data);
    }

    /*
     * updating due pamente to the due 
     * 
     * @param int
     * @param int
     * @return void
     */

    function update_payment($memo_ID, $amount) {
        $db_tables = $this->config->item('db_tables');
        $data = array(
            'due_paid_amount' => $amount,
        );
        $this->db->where('momo_ID', $memo_ID);
        $this->db->update($db_tables['pub_due_payment_ledger'], $data);
    }

    function get_all_customers() {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->join('customer_due', 'customer.id_customer = customer_due.id_customer', 'left');
        $this->db->where('customer_due.total_due_billed !=', null);
        $query = $this->db->get();
        return $query->result();
    }

    function get_customer_due_info($customer_name) {
        $this->db->select('*');
        $this->db->from('customer_due');
        $this->db->join('customer', 'customer.id_customer = customer_due.id_customer', 'left');
        $this->db->where('customer_due.id_customer', $customer_name);
        $query = $this->db->get();
        return $query->result();
    }

    function get_customer_due_payment_info($from, $to, $customer_name) {
        $date_from = date('Y-m-d', strtotime($from));
        $date_to = date('Y-m-d', strtotime($to));

        $this->db->select('*');
        $this->db->from('customer_payment');
        $this->db->join('customer', 'customer.id_customer = customer_payment.id_customer', 'left');
        if(!empty($customer_name)) {
            $this->db->where('customer_payment.id_customer', $customer_name);
        }if ($date_from != '1970-01-01') {
            $condition = "DATE(customer_payment.payment_date) BETWEEN '$date_from'  AND  '$date_to'";
            $this->db->where($condition);
        }
        $query = $this->db->get();
        return $query->result();
    }

}

;
