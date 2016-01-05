<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Model {

    private $todaysell = 0;
    private $monthlysell = 0;
    private $today_due = 0;
    private $monthly_due = 0;
    private $total_cash_paid = 0;
    private $total_bank_pay = 0;
    private $total_due = 0;
    private $total_sell = 0;

    function today($date = '') {

        $todaysell = 0;
        $today_due = 0;

        if (empty($date)) {
            $date = date('Y-m-d');
        }

        $query = $this->db->query("SELECT * FROM pub_memos WHERE DATE(issue_date)=DATE('$date')");
//        print_r($query->result_array());
//        exit;
        $data['cash_paid'] = 0;
        $data['bank_pay'] = 0;
        foreach ($query->result() as $value) {
            $todaysell+=$value->sub_total - $value->discount - $value->book_return;

            $data['cash_paid'] += $value->cash;

            $data['bank_pay'] += $value->bank_pay;

            $due = $value->due - $value->dues_unpaid;
            $today_due+=$due;
        }
        $data['todaysell'] = $todaysell;
        $data['today_due'] = $today_due;
        return $data;
    }

    function today_due($date = '') {
        if (empty($date)) {
            $date = date('Y-m-d');
        }

        $this->load->model('Memo');
//        $last_memo_ID_of_each_contact_ID = implode(',', $this->Memo->last_memo_ID_of_each_contact_ID());

        $query = $this->db->query("SELECT * FROM pub_memos WHERE issue_date=DATE('$date')");
//        print_r($query->result_array());
//        exit;
        foreach ($query->result() as $value) {
            $today_due = $value->total - $value->cash - $value->bank_pay - $value->dues_unpaid;
            if ($today_due > 0) {
                $this->today_due+=$today_due;
            }
        }
        return $this->today_due;
    }

    function monthly() {
        $this->load->model('Memo');

        $query = $this->db->query("SELECT * FROM pub_memos "
                . "WHERE "
                . "issue_date BETWEEN "
                . "(LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH) "
                . "AND (LAST_DAY(CURDATE()) + INTERVAL 1 DAY)");

        $data['cash_paid'] = 0;
        $data['bank_pay'] = 0;
        foreach ($query->result() as $value) {
            $this->monthlysell+=$value->sub_total - $value->discount - $value->book_return;
            $data['cash_paid'] += $value->cash;
            $data['bank_pay'] += $value->bank_pay;
        }
        $data['monthlysell'] = $this->monthlysell;
        $data['monthly_due'] = $this->monthly_due();
        return $data;
    }

// function today_due(){
// 	$query=$this->db->query("SELECT due FROM pub_memos WHERE issue_date=DATE(NOW())");
// 	foreach ($query->result() as $value) {
// 		$this->today_due+=$value->due;
// 	}
// 	return $this->today_due;
// }
// function monthly_due(){
// 	$query=$this->db->query("SELECT due FROM pub_memos WHERE issue_date BETWEEN DATE_ADD(now(),INTERVAL -1 MONTH) AND NOW()");
// 	foreach ($query->result() as $value) {
// 		$this->monthly_due+=$value->due;
// 	}
// 	return $this->monthly_due;
// }
    function total() {
        $data['total_cash_paid'] = 0;
        $data['total_bank_pay'] = 0;
        $query = $this->db->query("SELECT cash,bank_pay,due FROM pub_memos");
        foreach ($query->result() as $value) {
            $data['total_cash_paid']+=$value->cash;
            $data['total_bank_pay']+=$value->bank_pay;
        }
        $data['total_due'] = $this->total_due();
        $data['total_sell'] = $data['total_cash_paid'] + $data['total_bank_pay'] + $data['total_due'];
        return $data;
    }

    function total_due() {
        $this->load->model('Memo');
        $last_memo_ID_of_each_contact_ID = implode(',', $this->Memo->last_memo_ID_of_each_contact_ID());
        $query = $this->db->select_sum('due')
                        ->from('pub_memos')
                        ->where('memo_ID in', '(' . $last_memo_ID_of_each_contact_ID . ')', false)
                        ->where('due >', '0')->get()->result_array();
        return $query[0]['due'];
    }

    function monthly_due() {

        $this->load->model('Memo');
        $last_memo_ID_of_each_contact_ID = implode(',', $this->Memo->last_memo_ID_of_each_contact_ID());

        if ($last_memo_ID_of_each_contact_ID === '') {
            die("<script>alert('কোন মেমো ডাটাবেজে নেই । দয়া করে মেমো যোগ করুন । ');"
                    . "window.location.assign( '" . site_url('admin/memo_management/add') . "');</script>");
        }

        $query = $this->db->query("SELECT * FROM pub_memos "
                . "WHERE "
                . "issue_date BETWEEN "
                . "(LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH) "
                . "AND (LAST_DAY(CURDATE()) + INTERVAL 1 DAY)"
//                . "and "
//                . "memo_ID in ($last_memo_ID_of_each_contact_ID)"
                . "");
//        print_r($query->result_array());
//        exit;
        foreach ($query->result() as $value) {
            $monthly_due = $value->total - $value->cash - $value->bank_pay - $value->dues_unpaid;
            $this->monthly_due+=$monthly_due;
        }
        return $this->monthly_due;
    }

    function total_account_detail_table() {
        $this->load->library('table');
        $total = $this->total();
        $this->table->set_heading('Description', 'Amount(Tk)');
        $data = array(
            array('Total Cash Paid:', $total['total_cash_paid']),
            array('Total Bank Pay:', $total['total_bank_pay']),
            array('Total Due:', $total['total_due']),
            array('<strong>Total Sale:<strong>', "<strong>{$total['total_sell']}<strong>")
        );
        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-striped">',
            'heading_cell_start' => '<th class="success">'
        );
        $this->table->set_template($tmpl);
        return $this->table->generate($data);
    }

    function today_monthly_account_detail_table() {

        $this->load->library('table');

        $account_today = $this->account->today();
        $account_monthly = $this->account->monthly();
        $total = $this->total();

        $this->table->set_heading('Description', 'Amount(Tk)');
        $data = array(
            array('Today Cash Paid:', $account_today['cash_paid']),
            array('Today Bank Pay:', $account_today['bank_pay']),
            array('Monthly Cash Paid:', $account_monthly['cash_paid']),
            array('Monthly Bank Pay:', $account_monthly['bank_pay'])
        );
        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-striped">',
            'heading_cell_start' => '<th class="success">'
        );
        $this->table->set_template($tmpl);
        return $this->table->generate($data);
    }

    function today_detail_table($range) {

        $this->load->library('table');
        $t_t_s = 0;
        $t_t_d = 0;
        $t_t_c = 0;
        $t_t_b = 0;

        $account_today = $this->account->today();
        $account_monthly = $this->account->monthly();
        $total = $this->total();

        $this->table->set_heading('Date', 'Sell', 'Cash Paid', 'Bank Paid', 'Due');

        $query = $this->db->query("SELECT DATE(issue_date) as issue_date FROM pub_memos WHERE DATE(issue_date) BETWEEN $range GROUP BY(DATE(issue_date))");

        foreach ($query->result() as $value) {
            $data = $this->today($value->issue_date);

            $today_sell = $data['todaysell'];
            $t_t_s+=$today_sell;

            $today_due = $data['today_due'];
            $t_t_d+=$today_due;

            $today_cash_pay = $data['cash_paid'];
            $t_t_c+=$today_cash_pay;

            $today_bank_pay = $data['bank_pay'];
            $t_t_b+=$today_bank_pay;

            $this->table->add_row($value->issue_date, $today_sell, $today_cash_pay, $today_bank_pay, $today_due);
        }
        $cell = array('data' => '', 'class' => 'info', 'colspan' => 5);
        $this->table->add_row($cell);
        $this->table->add_row('<strong class="pull-right">Total: </strong>', $t_t_s, $t_t_c, $t_t_b, $t_t_d);


        // $data = array(
        //     array('Today Cash Paid:', $account_today['cash_paid']),
        //     array('Today Bank Pay:', $account_today['bank_pay']),
        //     array('Monthly Cash Paid:', $account_monthly['cash_paid']),
        //     array('Monthly Bank Pay:', $account_monthly['bank_pay'])
        // );
        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-striped">',
            'heading_cell_start' => '<th class="success">'
        );
        $this->table->set_template($tmpl);
        return $this->table->generate();
    }

// function total_bank_pay(){
// 	$query=$this->db->query("SELECT bank_pay FROM pub_memos");
//  foreach ($query->result() as $value) {
//  	$this->total_bank_pay+=$value->bank_pay;
//  }
//  return $this->total_bank_pay;
// }
// function total_due(){
// 	$query=$this->db->query("SELECT due FROM pub_memos");
//  foreach ($query->result() as $value) {
//  	$this->total_due+=$value->due;
//  }
//  return $this->total_due;
// }
// function totalsell(){
// 	$bankdue=$this->total_bank_pay;
// 	$cashpaid=$this->total_cash_paid;
// 	$totaldue=$this->total_due;
//  	$totalsell=$bankdue+$cashpaid+$totaldue;
//  	return $totalsell;
// }
}
