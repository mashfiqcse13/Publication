<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Case_to_bank_model
 *
 * @author sonjoy
 */
class Cash_to_bank_model extends CI_Model {

    //put your code here
    function get_all_bank_info() {
        $this->db->select('*');
        $this->db->from('bank');
        $this->db->join('bank_account', 'bank.id_bank = bank_account.id_bank', 'left');
        return $this->db->get()->result();
    }

    function get_all_expense_info() {
        $today_date = date('Y-m-d');
        $this->db->select_sum('amount_expense');
        $this->db->from('expense')->where("date(date_expense) = date('$today_date')");
        $result = $this->db->get()->row();
        return empty($result->amount_expense) ? 0 : $result->amount_expense;
    }

    function get_all_cash_to_bank_info_by_date($from, $to) {
        $date_from = date('Y-m-d H:i:s', strtotime($from));
        $date_to = date('Y-m-d H:i:s', strtotime($to));
        $this->db->select('*');
        $this->db->from('cash_to_bank_register');
        $this->db->join('bank_account', 'bank_account.id_bank_account = cash_to_bank_register.id_bank_account', 'left');
        $this->db->join('bank', 'bank.id_bank = bank_account.id_bank', 'left');
        $date_range = "DATE(cash_to_bank_register.date) BETWEEN '$date_from' AND '$date_to'";
        $this->db->where($date_range);
        return $this->db->get()->result();
    }

    function get_all_cash_to_owner_info_by_date($from, $to) {
        $date_from = date('Y-m-d H:i:s', strtotime($from));
        $date_to = date('Y-m-d H:i:s', strtotime($to));
        $this->db->select('*');
        $this->db->from('cash_to_owner_register');
        $date_range = "DATE(transfer_date) BETWEEN '$date_from' AND '$date_to'";
        $this->db->where($date_range);
        return $this->db->get()->result();
    }

    function get_all_cash_to_expense_info_by_date($from, $to) {
        $date_from = date('Y-m-d H:i:s', strtotime($from));
        $date_to = date('Y-m-d H:i:s', strtotime($to));
        $this->db->select('*');
        $this->db->from('cash_to_expense_adjustment');
        $date_range = "DATE(date) BETWEEN '$date_from' AND '$date_to'";
        $this->db->where($date_range);
        return $this->db->get()->result();
    }

    function bank_name($value) {
        $this->db->select('*');
        $this->db->from('bank');
        $this->db->join('bank_account', 'bank.id_bank = bank_account.id_bank', 'left');
        $this->db->where('id_bank_account', $value);
        return $this->db->get()->row();
    }

    function get_all_cash_info() {
        $this->db->select('*');
        $this->db->from('cash');
        return $this->db->get()->row();
    }

    function save_info($post_array) {
        $this->load->model('misc/cash', 'cash');
        $this->load->model('misc/bank_balance', 'bank');
        $amount = $post_array['transfered_amount'];
        $id_acount = $post_array['id_bank_account'];
        $data['id_bank_account'] = $id_acount;
        $data['transfered_amount'] = $amount;
        $data['date'] = date('Y-m-d H:i:s');
        $this->db->insert('cash_to_bank_register', $data);
//        bank Management
        $bank['id_account'] = $id_acount;
        $bank['id_transaction_type'] = 1;
        $bank['transaction_date'] = date('Y-m-d H:i:s');
        $bank['amount_transaction'] = $amount;
        $bank['id_user'] = $this->session->userdata('user_id');
        $this->db->insert('bank_management', $bank);
        $id_bank_management = $this->db->insert_id();

//        bank management status

        $status['approval_status'] = 1;
        $status['id_bank_management'] = $id_bank_management;
        $status['approved_by'] = $_SESSION['user_id'];
        $status['action_date'] = date('Y-m-d H:i:s');
        $this->db->insert('bank_management_status', $status);

        $this->cash->reduce($amount);
        $this->bank->add($id_acount, $amount);

        return true;
    }

    function save_expense_info($post_array) {
        $this->load->model('misc/cash', 'cash');
        $amount = $post_array['transfered_amount'];
        $data['transfered_amount'] = $amount;
        $data['date'] = date('Y-m-d H:i:s');
        $this->db->insert('cash_to_expense_adjustment', $data);

        $this->cash->reduce($amount);
        return true;
    }

    function save_info_for_owner($post_array) {
        $this->load->model('misc/cash', 'cash');

        $amount = $post_array['transfered_amount'];
        $data['cash_amount'] = $amount;
        $data['transfer_date'] = date('Y-m-d H:i:s');
        $this->db->insert('cash_to_owner_register', $data);

//        bank management status
        $this->cash->reduce($amount);

        return true;
    }

}
