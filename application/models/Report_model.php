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
        $this->db->select('*')->from('master_reconcillation');
        if ($from != '') {
            $condition = "DATE(date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $opening = $this->db->get()->row();
        if (empty($opening)) {
            $opening = new stdClass();
        }
        $opening->opening_cash = (!empty($opening->opening_cash)) ? $opening->opening_cash : 0;
        $opening->opening_bank_balance = (!empty($opening->opening_bank_balance)) ? $opening->opening_bank_balance : 0;
        $opening->opening_due = (!empty($opening->opening_due)) ? $opening->opening_due : 0;
        return $opening;
    }

    function closing($from, $to) {
        $this->db->select('*')->from('master_reconcillation')->order_by('id_master_reconcillation', 'desc');
        if ($from != '') {
            $condition = "DATE(date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $closing = $this->db->get()->row();
        if (empty($closing)) {
            $closing = new stdClass();
        }
        $closing->ending_cash = (!empty($closing->ending_cash)) ? $closing->ending_cash : 0;
        $closing->closing_bank_balance = (!empty($closing->closing_bank_balance)) ? $closing->closing_bank_balance : 0;
        $closing->ending_due = (!empty($closing->ending_due)) ? $closing->ending_due : 0;
        return $closing;
    }

    function total_due_collection($from, $to, $payment_methode = "") {
        $this->db->select_sum('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status', 1);
        if (!empty($payment_methode) && $payment_methode == "Cash") {
            $this->db->where('id_payment_method', 1);
        } else if (!empty($payment_methode) && $payment_methode == "Bank") {
            $this->db->where('id_payment_method', 3);
        }
        if ($from != '') {
            $condition = "DATE(payment_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->paid_amount) ? 0 : $result->paid_amount;
    }

    function total_sale_against_due_collection($from, $to, $payment_methode = "") {
        $this->db->select_sum('paid_amount');
        $this->db->from('customer_payment');
        $this->db->where('due_payment_status', 1);
        if (!empty($payment_methode) && $payment_methode == "Cash") {
            $this->db->where('id_payment_method', 1);
        } else if (!empty($payment_methode) && $payment_methode == "Bank") {
            $this->db->where('id_payment_method', 3);
        }
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

    function total_advance_collection_without_book_sale($from, $to, $payment_methode = "") {
        $this->db->select_sum('amount_paid');
        $this->db->from('party_advance_payment_register');
        if (!empty($payment_methode) && $payment_methode == "Cash") {
            $this->db->where('id_payment_method', 1);
        } else if (!empty($payment_methode) && $payment_methode == "Bank") {
            $this->db->where('id_payment_method', 3);
        } else if (!empty($payment_methode) && $payment_methode == "Old Book Sell") {
            $this->db->where('id_payment_method', 4);
        }
        if ($from != '') {
            $condition = "DATE(date_payment) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->amount_paid) ? 0 : $result->amount_paid;
    }
    
    

    function total_cash_2_bank_trasfer($from, $to) {
        $this->db->select_sum('transfered_amount');
        $this->db->from('cash_to_bank_register');
        if ($from != '') {
            $condition = "DATE(date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->transfered_amount) ? 0 : $result->transfered_amount;
    }
    
    function total_cash_2_owner($from, $to) {
        $this->db->select_sum('cash_amount');
        $this->db->from('cash_to_owner_register');
        if ($from != '') {
            $condition = "DATE(transfer_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->cash_amount) ? 0 : $result->cash_amount;
    }

    function total_cash_2_expense_adjustment($from, $to) {
        $this->db->select_sum('transfered_amount');
        $this->db->from('cash_to_expense_adjustment');
        if ($from != '') {
            $condition = "DATE(date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->transfered_amount) ? 0 : $result->transfered_amount;
    }

    function total_bank_withdraw($from, $to) {
        $this->db->select_sum('amount_transaction');
        $this->db->from('bank_management')->join("bank_management_status", "bank_management.id_bank_management = bank_management_status.id_bank_management", "left");
        $this->db->where('id_transaction_type', 2)->where('bank_management_status.approval_status', 1);
        if ($from != '') {
            $condition = "DATE(transaction_date) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->amount_transaction) ? 0 : $result->amount_transaction;
    }

    function total_old_book_transfer($from, $to) {
        $this->db->select_sum('price');
        $this->db->from('old_book_transfer_total');
        $this->db->where('type_transfer', 1);
        if ($from != '') {
            $condition = "DATE(date_transfer) BETWEEN '$from' AND '$to'";
//            echo $condition; exit();
            $this->db->where($condition);
        }
        $result = $this->db->get()->row();
        return empty($result->price) ? 0 : $result->price;
    }

    function previous_due_collection($from, $to) {
        $sql = "SELECT sum(`paid_amount`) as previous_due_collection FROM `customer_payment` 
            where DATE(`payment_date`) BETWEEN '$from' AND  '$to' 
            and `due_payment_status` = 1
            and `id_total_sales` NOT in ( 
                    SELECT  `id_total_sales` 
                    FROM  `sales_total_sales` 
                    WHERE DATE(  `issue_date` ) BETWEEN '$from' AND  '$to' 
            )";
        $result = $this->db->query($sql)->row();
        return empty($result->previous_due_collection) ? 0 : $result->previous_due_collection;
    }

    function previous_due_collection_by_cash($from, $to) {
        $sql = "SELECT sum(`paid_amount`) as previous_due_collection_by_cash FROM `customer_payment` 
            where DATE(`payment_date`) BETWEEN '$from' AND  '$to' 
            and `due_payment_status` = 1 AND `id_payment_method` = 1
            and `id_total_sales` NOT in ( 
                    SELECT  `id_total_sales` 
                    FROM  `sales_total_sales` 
                    WHERE DATE(  `issue_date` ) BETWEEN '$from' AND  '$to' 
            )";
        $result = $this->db->query($sql)->row();
        return empty($result->previous_due_collection_by_cash) ? 0 : $result->previous_due_collection_by_cash;
    }

    function previous_due_collection_by_bank($from, $to) {
        $sql = "SELECT sum(`paid_amount`) as previous_due_collection_by_bank FROM `customer_payment` 
            where DATE(`payment_date`) BETWEEN '$from' AND  '$to' 
            and `due_payment_status` = 1 AND `id_payment_method` = 3
            and `id_total_sales` NOT in ( 
                    SELECT  `id_total_sales` 
                    FROM  `sales_total_sales` 
                    WHERE DATE(  `issue_date` ) BETWEEN '$from' AND  '$to' 
            )";
        $result = $this->db->query($sql)->row();
        return empty($result->previous_due_collection_by_bank) ? 0 : $result->previous_due_collection_by_bank;
    }

    function previous_due_collection_by_old_book_sell($from, $to) {
        $sql = "SELECT sum(`paid_amount`) as previous_due_collection_by_old_book_sell FROM `customer_payment` 
            where DATE(`payment_date`) BETWEEN '$from' AND  '$to' 
            and `due_payment_status` = 1 AND `id_payment_method` = 4
            and `id_total_sales` NOT in ( 
                    SELECT  `id_total_sales` 
                    FROM  `sales_total_sales` 
                    WHERE DATE(  `issue_date` ) BETWEEN '$from' AND  '$to' 
            )";
        $result = $this->db->query($sql)->row();
        return empty($result->previous_due_collection_by_old_book_sell) ? 0 : $result->previous_due_collection_by_old_book_sell;
    }
    
    function total_others_income($from, $to){
        $sql ="SELECT sum(amount_income) as income FROM `income` WHERE DATE(date_income) BETWEEN '$from' AND '$to' ";
        $result = $this->db->query($sql)->row();
        return empty($result->income) ? 0 : $result->income;
       
    }

    function sale_info($from, $to) {
        $sql = "SELECT SUM(`total_amount`) as `total_sale`, 
            SUM(`cash_paid`) as `sale_against_cash_collection`, 
            SUM(`bank_paid`) as `sale_against_bank_collection`, 
            SUM(`customer_advance_paid`) as `sale_against_advance_deduction`, 
            SUM(`customer_old_book_sell`) as `sale_against_due_deduction_by_old_book_sell`, 
            SUM(`total_due`) as `sale_against_due` 
            FROM `view_sales_total_sales_with_payment_details`
            WHERE DATE(  `issue_date` ) BETWEEN '$from' AND  '$to' ";
        $result = $this->db->query($sql)->row();
        $result->total_sale = empty($result->total_sale) ? 0 : $result->total_sale;
        $result->sale_against_cash_collection = empty($result->sale_against_cash_collection) ? 0 : $result->sale_against_cash_collection;
        $result->sale_against_bank_collection = empty($result->sale_against_bank_collection) ? 0 : $result->sale_against_bank_collection;
        $result->sale_against_advance_deduction = empty($result->sale_against_advance_deduction) ? 0 : $result->sale_against_advance_deduction;
        $result->sale_against_due_deduction_by_old_book_sell = empty($result->sale_against_due_deduction_by_old_book_sell) ? 0 : $result->sale_against_due_deduction_by_old_book_sell;
        $result->sale_against_due = empty($result->sale_against_due) ? 0 : $result->sale_against_due;
        $result->calculated_total_sale = $result->sale_against_cash_collection + $result->sale_against_bank_collection +
                $result->sale_against_advance_deduction + $result->sale_against_due_deduction_by_old_book_sell + $result->sale_against_due;
        return $result;
    }
    
    function sale_against_due_deduction_by_old_book_sell($from,$to){
         $sql = "SELECT sum(customer_payment.paid_amount) as total_amount FROM `customer_payment` 
                    LEFT JOIN sales_total_sales on sales_total_sales.id_total_sales=customer_payment.id_total_sales
                    where due_payment_status=1 and id_payment_method=4 and  DATE(payment_date) BETWEEN  '$from' AND '$to' and DATE(issue_date) BETWEEN  '$from' AND '$to' ";
            $result = $this->db->query($sql)->row();
            $result_report = empty($result->total_amount) ? 0 : $result->total_amount;
            return $result_report;
    }

}
