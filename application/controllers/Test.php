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

    function index() {
        $this->load->library('table');
        $date_from = '2016-05-01';
        $date_to = '2016-05-31';


        $sql_last_memo_id_for_each_customer_in_the_given_date_range = "select contact_ID, max(memo_ID)as last_memo_id
	from (
		SELECT * 
		FROM `pub_memos` 
		where date(`issue_date`) between '$date_from' and '$date_to'
		) AS TBL1
	group by contact_ID";
//        die($sql_last_memo_id_for_each_customer_in_the_given_date_range);
        $sql_result_last_memo_id_for_each_customer_in_the_given_date_range = $this->db->query($sql_last_memo_id_for_each_customer_in_the_given_date_range)->result();
        $last_memo_id_for_each_customer_in_the_given_date_range = array();
        foreach ($sql_result_last_memo_id_for_each_customer_in_the_given_date_range as $value) {
            array_push($last_memo_id_for_each_customer_in_the_given_date_range, $value->last_memo_id);
        }
        $string_last_memo_id_for_each_customer_in_the_given_date_range = implode(',', $last_memo_id_for_each_customer_in_the_given_date_range);

        $sql_contact_ids_who_have_zero_or_nagative_due = "SELECT * 
		FROM `pub_memos` 
		where memo_ID in ($string_last_memo_id_for_each_customer_in_the_given_date_range) and due<1";
        die($sql_contact_ids_who_have_zero_or_nagative_due);
        $sql_result_contact_ids_who_have_zero_or_nagative_due = $this->db->query($sql_contact_ids_who_have_zero_or_nagative_due)->result();
        $contact_ids_who_have_zero_or_nagative_due = array();
        foreach ($sql_result_contact_ids_who_have_zero_or_nagative_due as $value) {
            array_push($contact_ids_who_have_zero_or_nagative_due, $value->contact_ID);
        }
        $string_contact_ids_who_have_zero_or_nagative_due = implode(',', $contact_ids_who_have_zero_or_nagative_due);


        $sql_sum_of_the_fields_in_the_given_date_range = "SELECT `contact_ID`, pub_contacts.name,
                    sum(`sub_total`) as sum_sub_total,
                    sum( `discount`)as sum_discount,
                    sum( `book_return`)as sum_book_return,
                    sum( `cash`)as sum_cash,
                    sum( `bank_pay`)as sum_bank_pay ,
                    (sum(`sub_total`)-sum( `discount`)-sum( `book_return`)-sum( `cash`)-sum( `bank_pay`)-sum( `bank_pay`)) as due
                    FROM `pub_memos` natural join pub_contacts
                    WHERE date(`issue_date`) between '$date_from' and '$date_to'
                        and contact_ID not in ($string_contact_ids_who_have_zero_or_nagative_due)
                    group by `contact_ID`";
        die($sql_sum_of_the_fields_in_the_given_date_range);
    }

    function due() {

        $date_from = '2016-06-01';
        $date_to = '2016-06-26';

        $sql = "
            SELECT sum(due_billed_this_range) FROM (
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
	contact_ID not in(
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
		) and due < 1
	)
	group by `contact_ID`
) as due_result
where due_billed_this_range > 0";
        echo $sql;
    }

}
