<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Account extends CI_Model{

public $todaysell;
public $monthlysell;
private $today_due;
private $monthlydue;

function todaysell(){
	$query = $this->db->query("SELECT sub_total FROM pub_memos WHERE issue_date=DATE(NOW())");

	foreach ($query->result() as $value) {
		$this->todaysell+=$value->sub_total;
	}
	return $this->todaysell;
	
}



function monthlysell(){
	$query=$this->db->query("SELECT sub_total FROM pub_memos WHERE issue_date BETWEEN DATE_ADD(now(),INTERVAL -1 MONTH) AND NOW()");

	foreach ($query->result() as $value) {
		$this->monthlysell+=$value->sub_total;
	}

	return $this->monthlysell;

	
}

function today_due(){
	$query=$this->db->query();

	foreach ($query->result() as $value) {
		$this->today_due+=$value->due;
	}

	return $this->today_due;
}

}