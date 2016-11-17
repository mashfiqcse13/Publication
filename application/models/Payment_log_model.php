<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payment_log_model
 *
 * @author sonjoy
 */
class Payment_log_model extends CI_Model {

    //put your code here
    function get_payment_log($id) {
        $this->db->select('*,customer_payment.id_total_sales,customer_payment.payment_date as date');
        $this->db->from('customer_payment');
        $this->db->join('customer', 'customer_payment.id_customer = customer.id_customer', 'left');
//       
        $this->db->join('payment_method', 'customer_payment.id_payment_method = payment_method.id_payment_method', 'left');
        $this->db->join('customer_due_payment_register', 'customer_payment.id_customer_due_payment_register = customer_due_payment_register.id_customer_due_payment_register', 'left');
        $this->db->where('customer_payment.id_customer_payment', $id);
        return $this->db->get()->result();
    }

    function get_customer_payment_info($id_customer, $payment_method, $date_range) {
        $date = '';
        if ($date_range != '') {
            $date = $this->dateformatter($date_range);
        }
        $this->db->select('*,customer_payment.id_total_sales,customer_payment.payment_date as date');
        $this->db->from('customer_payment');
        $this->db->join('customer', 'customer_payment.id_customer = customer.id_customer', 'left');
//       
        $this->db->join('payment_method', 'customer_payment.id_payment_method = payment_method.id_payment_method', 'left');
        $this->db->join('customer_due_payment_register', 'customer_payment.id_customer_due_payment_register = customer_due_payment_register.id_customer_due_payment_register', 'left');
        if(!empty($id_customer)){
            $this->db->where('customer_payment.id_customer',$id_customer);
        }if(!empty($payment_method)){
            $this->db->where('customer_payment.id_payment_method',$payment_method);
        }if($date != ''){
            $condition = "DATE(customer_payment.payment_date) BETWEEN $date";
            $this->db->where($condition);
        }
        return $this->db->order_by("id_customer_payment",'desc')->get()->result();
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
