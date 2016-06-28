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
    private $cost = 0;

    function today($date = '') {

        $todaysell = 0;

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
        }
        $data['todaysell'] = $todaysell;
        $data['today_due'] = $this->today_due($date);
        return $data;
    }

    function get_due($date_from, $date_to, $return_type = 1) {
        $this->load->library('table');
        $sql = "SELECT contact_ID,name,due_billed_this_range,0 as dues_unpaid FROM (
	SELECT `contact_ID`, pub_contacts.name,
	sum(`sub_total`) as sum_sub_total,
	sum( `discount`)as sum_discount,
	sum( `book_return`)as sum_book_return,
	sum( `cash`)as sum_cash,
	sum( `bank_pay`)as sum_bank_pay ,
	(sum(`sub_total`)-sum( `discount`)-sum( `book_return`)-sum( `cash`)-sum( `bank_pay`)-sum( `bank_pay`)) as due_billed_this_range
	FROM `pub_memos` natural join pub_contacts
	WHERE date(`issue_date`) between '$date_from' and '$date_to'
	and
	contact_ID in(
		select contact_ID 
		FROM `pub_memos` 
		where memo_ID in(
			select max(memo_ID)
			from (
				SELECT * 
				FROM `pub_memos` 
				where date(`issue_date`) between '$date_from' and '$date_to'
			) AS TBL1
			group by contact_ID
		) and due > 0
	)
	group by `contact_ID`
) as adfasdfasdf
where adfasdfasdf.due_billed_this_range > 0

union

select contact_ID,name,0 as due_billed_this_range, dues_unpaid
	FROM `pub_memos` natural join pub_contacts
	where memo_ID in(
		select min(memo_ID)
		from (
			SELECT * 
			FROM `pub_memos` 
			where date(`issue_date`) between '$date_from' and '$date_to'
		) AS TBL1
		group by contact_ID
	) and contact_ID in(
		select contact_ID 
		FROM `pub_memos` 
		where memo_ID in(
			select max(memo_ID)
			from (
				SELECT * 
				FROM `pub_memos` 
				where date(`issue_date`) between '$date_from' and '$date_to'
			) AS TBL1
			group by contact_ID
		) and due > 0
	) and `dues_unpaid` < 0";
//        die($sql);
        $result = $this->db->query($sql)->result();

        $sum_due_billed_this_range = 0;
        $sum_dues_unpaid = 0;
        foreach ($result as $key => $row) {
            $sum_due_billed_this_range+=$row->due_billed_this_range;
            $sum_dues_unpaid+=$row->dues_unpaid;
            if ($return_type == 2) {
                $this->table->add_row($row->contact_ID, $row->name, $row->due_billed_this_range, $row->dues_unpaid);
            }
        }
        $due = $sum_due_billed_this_range + $sum_dues_unpaid;

        if ($return_type == 1) {
            return $due;
        } else if ($return_type == 2) {
            $this->table->add_row('', '', $sum_due_billed_this_range, $sum_dues_unpaid, $due);
            $this->table->set_heading("Contact ID", "Customer Name", "Due billed in the last memo", "Dues Unpaid in the first value");
            return $this->table->generate();
        }
    }

    function today_due($date = '') {
        if (empty($date)) {
            $date = date('Y-m-d');
        }
        return $this->get_due($date, $date);
    }

    function monthly() {
        $this->load->model('Memo');

        $query = $this->db->query("SELECT * FROM pub_memos "
                . "WHERE "
//                . "issue_date BETWEEN "
//                . "(LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH) "
//                . "AND (LAST_DAY(CURDATE()) + INTERVAL 1 DAY)");
                . "MONTH(issue_date) = MONTH(CURDATE()) && YEAR(issue_date) = YEAR(CURDATE())");

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

        $from_date = date('Y-m-1');
        $to_date = date('Y-m-t');
        return $this->get_due($from_date, $to_date);
    }

    function total_account_detail_table() {
        $this->load->library('table');
        $total = $this->total();
        $this->table->set_heading('Description', '<span class="pull-right">(TK)Amount</span>');
        $data = array(
            array('Total Cash Collection:', $this->Common->taka_format($total['total_cash_paid'])),
            array('Total Bank Collection:', $this->Common->taka_format($total['total_bank_pay'])),
            array('Total Due:', $this->Common->taka_format($total['total_due'])),
            array('<strong>Total Collection:<strong>', "<strong>{$this->Common->taka_format($total['total_sell'])}<strong>")
        );
        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-striped right-text-for-account">',
            'heading_cell_start' => '<th class="success">'
        );
        $this->table->set_template($tmpl);
        return $this->table->generate($data);
    }

    function today_monthly_account_detail_table() {

        $this->load->library('table');
        $this->load->model('Office_cost');

        $today_cost = $this->Office_cost->today_office_cost();

        $monthly_cost = $this->Office_cost->monthly_office_cost();

        $account_today = $this->account->today();
        $account_monthly = $this->account->monthly();
        $total = $this->total();

//        calculation for cash minus cost for today and monthly

        $cash_cost = $this->Common->taka_format($account_today['cash_paid'] - $today_cost);
        $t_cash_t_cost = $this->Common->taka_format($account_monthly['cash_paid'] - $monthly_cost);


        $this->table->set_heading('Description', '<span class="pull-right">(TK)Amount</span>');
        $data = array(
            array('Today Cash Collection:', $this->Common->taka_format($account_today['cash_paid'])),
            array('Today Cash in Hand After Cost:', '(' . $this->Common->taka_format($account_today['cash_paid']) . '-' . $this->Common->taka_format($today_cost) . ')=' . ($cash_cost)),
            array('Today Bank Collection:', $this->Common->taka_format($account_today['bank_pay'])),
            array('Monthly Cash Collection:', $this->Common->taka_format($account_monthly['cash_paid'])),
            array('Monthly Cash in Hand After Cost:', '(' . $this->Common->taka_format($account_monthly['cash_paid']) . '-' . $this->Common->taka_format($monthly_cost) . ')=' . ($t_cash_t_cost)),
            array('Monthly Bank Collection:', $this->Common->taka_format($account_monthly['bank_pay']))
        );
        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-striped right-text-for-account">',
            'heading_cell_start' => '<th class="success heading-right-for-page">'
        );
        $this->table->set_template($tmpl);
        return $this->table->generate($data);
    }

    function today_detail_table($range) {
        $this->load->model('Office_cost');
        $date = str_replace("'", '', $range);
        $date = explode(" and ", $date);
        $date_from = $date[0];
        $date_to = $date[1];
//        var_dump($date);
//        die($range);
        //$today_cost=$this->Office_cost->today_office_cost();

        $this->load->library('table');
        $total_today_sell = 0;
        $total_today_due = 0;
        $total_today_cash_pay = 0;
        $total_today_bank_pay = 0;
        $total_office_cost = 0;

        $account_today = $this->account->today();
        $account_monthly = $this->account->monthly();
        $total = $this->total();

        $this->table->set_heading('Date', 'Sell', 'Cash Collection', 'Bank Collection', 'Due', 'Office Cost');



        $query = $this->db->query("SELECT DATE(issue_date) as issue_date FROM pub_memos WHERE DATE(issue_date) BETWEEN $range GROUP BY(DATE(issue_date))");

        foreach ($query->result() as $value) {
            $data = $this->today(date('Y-m-d',  strtotime($value->issue_date)));

            $today_sell = $data['todaysell'];
            $total_today_sell+=$today_sell;

            $today_due = $data['today_due'];
            $total_today_due+=$today_due;

            $today_cash_pay = $data['cash_paid'];
            $total_today_cash_pay+=$today_cash_pay;

            $today_bank_pay = $data['bank_pay'];
            $total_today_bank_pay+=$today_bank_pay;

            $cost = $this->Office_cost->today_office_cost($value->issue_date);
            $total_office_cost+=$cost;

            $this->table->add_row($value->issue_date, $this->Common->taka_format($today_sell), $this->Common->taka_format($today_cash_pay), $this->Common->taka_format($today_bank_pay), $this->Common->taka_format($today_due), $this->Common->taka_format($cost));
        }
        $cell = array('data' => '', 'class' => 'info pull-right', 'colspan' => 5);
        $this->table->add_row($cell);
        $this->table->add_row(
                '<strong>Last info of searched range of dates : </strong>', $this->Common->taka_format($total_today_sell), $this->Common->taka_format($total_today_cash_pay), $this->Common->taka_format($total_today_bank_pay), $this->Common->taka_format($this->get_due($date_from, $date_to)), $this->Common->taka_format($total_office_cost)
        );


        // $data = array(
        //     array('Today Cash Paid:', $account_today['cash_paid']),
        //     array('Today Bank Pay:', $account_today['bank_pay']),
        //     array('Monthly Cash Paid:', $account_monthly['cash_paid']),
        //     array('Monthly Bank Pay:', $account_monthly['bank_pay'])
        // );
        //Setting table template
        $tmpl = array(
            'table_open' => '<table class="table table-striped right-text-for-account">',
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
