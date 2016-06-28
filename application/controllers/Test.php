<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Test
 *
 * @author MD. Mashfiq
 */
class Test extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('Common');
    }

    function index($date_from, $date_to) {
        $this->load->library('table');
//        $date_from = '2016-05-01';
//        $date_to = '2016-05-31';
//        die("$date_from - $date_to");

        
        
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

        $this->table->set_heading("Contact ID", "Customer Name", "Due billed in the last memo", "Dues Unpaid in the first value");
        $sum_due_billed_this_range = 0;
        $sum_dues_unpaid = 0;
        foreach ($result as $key => $row) {
            $sum_due_billed_this_range+=$row->due_billed_this_range;
            $sum_dues_unpaid+=$row->dues_unpaid;
            $this->table->add_row($row->contact_ID, $row->name, $row->due_billed_this_range, $row->dues_unpaid);
        }
        $this->table->add_row('', '', $sum_due_billed_this_range, $sum_dues_unpaid,$sum_due_billed_this_range+$sum_dues_unpaid);

        echo $this->table->generate();
    }

}
