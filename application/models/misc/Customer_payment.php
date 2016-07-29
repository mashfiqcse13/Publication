<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Customer_payment
 *
 * @author MD. Mashfiq
 */
class Customer_payment extends CI_Model {

    function due_payment($customer_id, $payment_amount, $id_payment_method = 1) {
        $this->load->model('misc/Customer_due');
        $this->Customer_due->reduce($customer_id, $payment_amount) or die('Addtional ammount can not be processed');
        if ($id_payment_method == 1) {
            $this->load->model('misc/Cash');
            $this->Cash->add($payment_amount) or die('Failed to add cash to the cash box');
        }
        $result_total_sates_details = $this->Customer_due->details_from_total_sales($customer_id);
        $data_to_update_in_total_sales = array();
        $data_to_insert_in_due_payment = array();
        foreach ($result_total_sates_details as $key => $row) {
            if ($payment_amount <= 0) {
                break;
            }
            $data_to_update_in_total_sales[$key]['id_total_sales'] = $row->id_total_sales;
            $data_to_insert_in_due_payment[$key]['id_total_sales'] = $row->id_total_sales;
            $data_to_insert_in_due_payment[$key]['id_customer'] = $row->id_customer;
            $data_to_insert_in_due_payment[$key]['payment_date'] = date('Y-m-d h:i:u');
            $data_to_insert_in_due_payment[$key]['paid_amount'] = $payment_amount;
            $data_to_insert_in_due_payment[$key]['id_payment_method'] = $id_payment_method;      //cash only

            if ($payment_amount > $row->total_due) {
                // transfering total due to cash and total_paid
                $data_to_update_in_total_sales[$key]['total_paid'] = $row->total_paid + $row->total_due;
                // setting the rest of money to payment amount for the due payment of next payment
                $payment_amount = $payment_amount - $row->total_due;
                $data_to_update_in_total_sales[$key]['total_due'] = 0;
            } else if ($row->total_due >= $payment_amount) {
                // reducing form total_due and sending to( cash and total_paid)  about $payment_amount 
                $data_to_update_in_total_sales[$key]['total_paid'] = $row->total_paid + $payment_amount;
                $data_to_update_in_total_sales[$key]['total_due'] = $row->total_due - $payment_amount;
                $payment_amount = 0;
            }
//                $data_to_update_in_total_sales[$key]['payment_amount'] = $payment_amount;

            $data_to_insert_in_due_payment[$key]['paid_amount'] -= $payment_amount;
        }
        $this->db->update_batch('sales_total_sales', $data_to_update_in_total_sales, 'id_total_sales');
        $this->db->insert_batch('customer_payment', $data_to_insert_in_due_payment);
    }

    function payment_register($id_customer, $amount, $id_total_sales, $id_payment_method) {
        $data_to_insert = array(
            'id_customer' => $id_customer,
            'paid_amount' => $amount,
            'id_total_sales' => $id_total_sales,
            'payment_date' => date('Y-m-d h:i:u'),
            'id_payment_method' => $id_payment_method
        );
        $this->db->insert('customer_payment', $data_to_insert);
    }

    /*
     * $id_payment_method = 1(cash) or 3 (bank) see payment_method_table
     */

    function today_collection($id_payment_method = 1) {
        $sql = "SELECT sum(`paid_amount`) as today_collection FROM `customer_payment` WHERE `id_payment_method`= $id_payment_method and date(`payment_date`) = DATE(NOW())";
        $result = $this->db->query($sql)->result();
        if (empty($result[0]->today_collection)) {
            return 0;
        } else {
            return $result[0]->today_collection;
        }
    }

}
