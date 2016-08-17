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

    private $combine_due_payment_register = FALSE;
    private $combine_id_customer_due_payment_register = FALSE;

    function set_combine_due_payment_register() {
        $this->combine_due_payment_register = TRUE;
    }

    function unset_combine_due_payment_register($id_total_sales) {
        $this->combine_due_payment_register = FALSE;
        if ($this->combine_id_customer_due_payment_register > 0) {
            $sql = "UPDATE  `customer_due_payment_register` SET  `id_total_sales` = $id_total_sales  WHERE `id_customer_due_payment_register` ={$this->combine_id_customer_due_payment_register};";
            $this->db->query($sql);
        }
    }

    function due_payment($customer_id, $payment_amount, $id_payment_method = 1) {
        $this->load->model('misc/Customer_due');
        $this->Customer_due->reduce($customer_id, $payment_amount) or die('Addtional ammount can not be processed'.". Customer ammount = $payment_amount");
        if ($id_payment_method == 1) {
            $this->load->model('misc/Cash');
            $this->Cash->add($payment_amount) or die('Failed to add cash to the cash box');
        }

        $last_id_customer_due_payment_register = $this->customer_due_payment_register($customer_id, $payment_amount);

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
            $data_to_insert_in_due_payment[$key]['due_payment_status'] = 1;
            $data_to_insert_in_due_payment[$key]['id_customer_due_payment_register'] = $last_id_customer_due_payment_register;

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
        return $last_id_customer_due_payment_register;
    } 
    
    function generate_due_report($id_cash,$id_bank){
        if($id_cash != 0){
            $con=" customer_due_payment_register.id_customer_due_payment_register = $id_cash ";
        }
        if($id_bank != 0){
            $con=" customer_due_payment_register.id_customer_due_payment_register = $id_bank ";
        }
        
        if($id_bank !=0 && $id_cash != 0){
            $con=" customer_due_payment_register.id_customer_due_payment_register BETWEEN $id_cash AND  $id_bank ";
        }
        
        $this->db->select('customer_payment.id_total_sales,customer_payment.paid_amount,payment_method.name_payment_method,customer_payment.payment_date')
                ->from('customer_due_payment_register')
                ->join('customer_payment','customer_due_payment_register.id_customer_due_payment_register=customer_payment.id_customer_due_payment_register' , 'left')
                ->join('payment_method' , ' payment_method.id_payment_method=customer_payment.id_payment_method' , 'left')
                ->where(" $con ");
               $query=$this->db->get()->result();
        
               return $query;       
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

    function customer_due_payment_register($id_customer, $tatal_paid_amount) {
        if ($this->combine_due_payment_register == TRUE && $this->combine_id_customer_due_payment_register > 0) {
            $this->customer_due_payment_register_addition($this->combine_id_customer_due_payment_register, $tatal_paid_amount);
            return $this->combine_id_customer_due_payment_register;
        } else {
            $data_to_insert = array(
                'id_customer' => $id_customer,
                'tatal_paid_amount' => $tatal_paid_amount,
                'payment_date' => date('Y-m-d h:i:u')
            );
            $this->db->insert('customer_due_payment_register', $data_to_insert);
            $sql = "SELECT MAX(id_customer_due_payment_register) as last_id_customer_due_payment_register FROM customer_due_payment_register WHERE id_customer = $id_customer";
            $result = $this->db->query($sql)->result();
            if ($this->combine_due_payment_register == TRUE) {
                $this->combine_id_customer_due_payment_register = $result[0]->last_id_customer_due_payment_register;
            }
            return $result[0]->last_id_customer_due_payment_register;
        }
    }

    function customer_due_payment_register_addition($previous_id_customer_due_payment_register, $tatal_paid_amount) {
        $sql = "UPDATE  `customer_due_payment_register` SET  `tatal_paid_amount` = `tatal_paid_amount` + $tatal_paid_amount  WHERE `id_customer_due_payment_register` =$previous_id_customer_due_payment_register;";
        $this->db->query($sql);
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
