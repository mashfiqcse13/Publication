<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Report_model
 *
 * @author sonjoy
 */
class Report_model extends CI_Model {

    //put your code here
    function total_sales($from, $to) {
        $this->db->select('sum(total_amount) as total_amount,sum(total_paid) as total_paid,sum(total_due) as total_due');
        $this->db->from('sales_total_sales');
        if ($from != '') {
            $condition = "DATE(issue_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        return $this->db->get()->row();
    }
    
    function customer_payemnt($from, $to){
        $this->db->select('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status IS NULL');
        $this->db->where('id_payment_method',1);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        return $this->db->get()->row();
    }
    function bank_payment($from, $to){
        $this->db->select('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status IS NULL');
        $this->db->where('id_payment_method',3);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        return $this->db->get()->row();
    }
    function due_payment($from, $to){
        $this->db->select('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status',1);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        return $this->db->get()->row();
    }
    function advance_payment($from, $to){
        $this->db->select('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status IS NULL');
        $this->db->where('id_payment_method',2);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        return $this->db->get()->row();
    }
    
    function opening($from, $to){
        $this->db->select('*');
        $this->db->from('master_reconcillation');
        if ($from != '') {
            $condition = "DATE(date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        return $this->db->get()->row();
    }
    function closing($from, $to){
        $this->db->select('*');
        $this->db->from('master_reconcillation');
        $this->db->order_by('id_master_reconcillation','desc');
        if ($from != '') {
            $condition = "DATE(date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        return $this->db->get()->row();
    }

}
