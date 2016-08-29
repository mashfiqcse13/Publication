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


    function opening($from, $to) {
        $this->db->select('*');
        $this->db->from('master_reconcillation');
        if ($from != '') {
            $condition = "DATE(date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        return $this->db->get()->row();
    }

    function closing($from, $to) {
        $this->db->select('*');
        $this->db->from('master_reconcillation');
        $this->db->order_by('id_master_reconcillation', 'desc');
        if ($from != '') {
            $condition = "DATE(date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        return $this->db->get()->row();
    }

    function total_due_collection($from, $to) {
        $this->db->select_sum('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status', 1);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->paid_amount) ? 0 : $result->paid_amount;
    }

    function total_sale_against_due_collection($from, $to) {
        $this->db->select_sum('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status', 1);
        if ($from != '') {
            $condition = "`id_total_sales` in ( SELECT `id_total_sales` FROM `sales_total_sales` WHERE DATE(issue_date) BETWEEN '$from' AND '$to')";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->paid_amount) ? 0 : $result->paid_amount;
    }

    function total_sale_against_cash_collection($from, $to) {
        $this->db->select_sum('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status IS NULL');
        $this->db->where('id_payment_method', 1);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->paid_amount) ? 0 : $result->paid_amount;
    }

    function total_sale_against_bank_collection($from, $to) {
        $this->db->select_sum('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status IS NULL');
        $this->db->where('id_payment_method', 3);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->paid_amount) ? 0 : $result->paid_amount;
    }

    function total_sale_against_advance_deduction($from, $to) {
        $this->db->select_sum('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status IS NULL');
        $this->db->where('id_payment_method', 2);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->paid_amount) ? 0 : $result->paid_amount;
    }
    
    function total_cash_collection_from_customer_payment($from, $to) {
        $this->db->select_sum('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('id_payment_method', 1);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->paid_amount) ? 0 : $result->paid_amount;
    }

    function total_bank_collection_from_customer_payment($from, $to) {
        $this->db->select_sum('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('id_payment_method', 3);
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->paid_amount) ? 0 : $result->paid_amount;
    }

    function total_expence($from, $to) {
        $this->db->select_sum('amount_expense');
        $this->db->from('expense');
        if ($from != '') {
            $condition = "DATE(date_expense) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->amount_expense) ? 0 : $result->amount_expense;
    }


    function total_cash_collection_from_advance_payment($from, $to) {
        $this->db->select_sum('amount_paid');
        $this->db->from('party_advance_payment_register');
        $this->db->where('id_payment_method', 1);
        if ($from != '') {
            $condition = "DATE(date_payment) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->amount_paid) ? 0 : $result->amount_paid;
    }

    function total_bank_collection_from_advance_payment($from, $to) {
        $this->db->select_sum('amount_paid');
        $this->db->from('party_advance_payment_register');
        $this->db->or_where('id_payment_method', 3);
        if ($from != '') {
            $condition = "DATE(date_payment) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->amount_paid) ? 0 : $result->amount_paid;
    }
    

    function total_advance_collection_without_book_sale($from, $to) {
        $this->db->select_sum('amount_paid');
        $this->db->from('party_advance_payment_register');
        $this->db->where('id_payment_method !=', 4);
        if ($from != '') {
            $condition = "DATE(date_payment) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->amount_paid) ? 0 : $result->amount_paid;
    }
}
