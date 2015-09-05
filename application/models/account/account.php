<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Account extends CI_Model{

private $todaysell=0;
private $monthlysell=0;
private $today_due=0;
private $monthly_due=0;
private $total_cash_paid=0;
private $total_bank_due=0;
private $total_due=0;
private $total_sell=0;


function today(){
	$query = $this->db->query("SELECT sub_total,discount,due FROM pub_memos WHERE issue_date=DATE(NOW())");

	foreach ($query->result() as $value) {
		$this->todaysell+=$value->sub_total - $value->discount;
		$this->today_due+=$value->due;
	}
	$data['todaysell']=$this->todaysell;
	$data['today_due']=$this->today_due;
	return $data;
	
}



function monthly(){
	$query=$this->db->query("SELECT due,sub_total,discount FROM pub_memos WHERE issue_date BETWEEN DATE_ADD(now(),INTERVAL -1 MONTH) AND NOW()");

	foreach ($query->result() as $value) {
		$this->monthlysell+=$value->sub_total-$value->discount;
		$this->monthly_due+=$value->due;
	}

	$data['monthlysell']=$this->monthlysell;
	$data['monthly_due']=$this->monthly_due;

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

function total(){
 $query=$this->db->query("SELECT cash,bank_due,due FROM pub_memos");

 foreach ($query->result() as $value) {
 	$this->total_cash_paid+=$value->cash;
 	$this->total_bank_due+=$value->bank_due;
 	$this->total_due+=$value->due;


 }
 $data['total_cash_paid']=$this->total_cash_paid;
 $data['total_bank_due']=$this->total_bank_due;
 $data['total_due']=$this->total_due;
 $data['total_sell']=$this->total_cash_paid+$this->total_bank_due+$this->total_due;
 return $data;
}

// function total_bank_due(){
// 	$query=$this->db->query("SELECT bank_due FROM pub_memos");

//  foreach ($query->result() as $value) {
//  	$this->total_bank_due+=$value->bank_due;
//  }

//  return $this->total_bank_due;

// }


// function total_due(){
// 	$query=$this->db->query("SELECT due FROM pub_memos");

//  foreach ($query->result() as $value) {
//  	$this->total_due+=$value->due;
//  }

//  return $this->total_due;
// }

// function totalsell(){
// 	$bankdue=$this->total_bank_due;
// 	$cashpaid=$this->total_cash_paid;
// 	$totaldue=$this->total_due;
	
//  	$totalsell=$bankdue+$cashpaid+$totaldue;

//  	return $totalsell;
// }

}