<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Customer_due_payment
 *
 * @author MD. Mashfiq
 */
class Customer_due_payment extends CI_Model {

    function add($customer_id, $payment_amount) {
        $this->load->model('misc/Customer_due');
        $this->Customer_due->reduce($customer_id, $payment_amount) or die('Addtional ammount can not be processed');

//        echo "Customer ID :$customer_id" . "<br>\n"
//        . "Due payment amount : $payment_amount" . "<br>\n"
//        . "Current due amount : {$this->Customer_due->current_total_due($customer_id) }" . "<br>\n";

        $result_total_sates_details = $this->Customer_due->details_from_total_sales($customer_id);
//        print_r($result_total_sates_details);
        $data_to_update_in_total_sales = array();
        $data_to_insert_in_due_payment = array();
        foreach ($result_total_sates_details as $key => $row) {
            if ($payment_amount <= 0) {
                break;
            }
            $data_to_update_in_total_sales[$key]['id_total_sales'] = $row->id_total_sales;
//                $data_to_update_in_total_sales[$key]['id_customer'] = $row->id_customer;
//                $data_to_update_in_total_sales[$key]['total_amount'] = $row->total_amount;

            $data_to_insert_in_due_payment[$key]['id_total_sales'] = $row->id_total_sales;
            $data_to_insert_in_due_payment[$key]['id_customer'] = $row->id_customer;
            $data_to_insert_in_due_payment[$key]['payment_date'] = date('Y-m-d h:i:u');
            $data_to_insert_in_due_payment[$key]['paid_amount'] = $payment_amount;

            if ($payment_amount > $row->total_due) {
                // transfering total due to cash and total_paid
                $data_to_update_in_total_sales[$key]['cash'] = $row->cash + $row->total_due;
                $data_to_update_in_total_sales[$key]['total_paid'] = $row->total_paid + $row->total_due;
                // setting the rest of money to payment amount for the due payment of next payment
                $payment_amount = $payment_amount - $row->total_due;
                $data_to_update_in_total_sales[$key]['total_due'] = 0;
            } else if ($row->total_due >= $payment_amount) {
                // reducing form total_due and sending to( cash and total_paid)  about $payment_amount 
                $data_to_update_in_total_sales[$key]['cash'] = $row->cash + $payment_amount;
                $data_to_update_in_total_sales[$key]['total_paid'] = $row->total_paid + $payment_amount;
                $data_to_update_in_total_sales[$key]['total_due'] = $row->total_due - $payment_amount;
                $payment_amount = 0;
            }
//                $data_to_update_in_total_sales[$key]['payment_amount'] = $payment_amount;

            $data_to_insert_in_due_payment[$key]['paid_amount'] -= $payment_amount;
        }
//        print_r($data_to_update_in_total_sales);
//        print_r($data_to_insert_in_due_payment);


        $this->db->update_batch('sales_total_sales', $data_to_update_in_total_sales, 'id_total_sales');
        $this->db->insert_batch('customer_payment', $data_to_insert_in_due_payment);
    }

}
