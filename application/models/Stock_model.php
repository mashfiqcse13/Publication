<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stock
 *
 * @author sonjoy
 */
class Stock_model  extends CI_Model{
    //put your code here
    function select_stock(){
        $this->db->select('*');
        $this->db->from('pub_books_return');
        $query = $this->db->get();
        return $query->result();
    }
    
    function search_item($start_date,$end_date){
//        print_r($start_date);exit();
        $this->db->select('*');
        $this->db->from('pub_books_return');
        $this->db->where('issue_date BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date. ' +1 day')).'"');
        $query = $this->db->get();
        return $query->result();
    }
}
