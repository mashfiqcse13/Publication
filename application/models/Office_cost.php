<?php

class Office_cost extends CI_Model {
    
function today_office_cost(){
        
        $date =date('Y-m-d');
     
        $db_tables = $this->config->item('db_tables');
        $this->db->select('SUM(amount) as cost');
        $this->db->from($db_tables['pub_cost']);
        $this->db->where('date="'.$date.'"');
        
        $query = $this->db->get();
        
        $db_rows = $query->result_array();
        foreach ($db_rows as $row) {
            $cost=$row['cost'];
        }

      return $cost;
}

function monthly_office_cost(){
    
      $date =date('Y-m-d');
     
        $db_tables = $this->config->item('db_tables');
        $this->db->select('SUM(amount) as cost');
        $this->db->from($db_tables['pub_cost']);
        $this->db->where('MONTH(date) = MONTH(CURDATE()) && YEAR(date) = YEAR(CURDATE())');
        
        $query = $this->db->get();
        
        $db_rows = $query->result_array();
        foreach ($db_rows as $row) {
            $cost=$row['cost'];
        }

      return $cost;
    
}

function previous_month_office_cost(){
    
      $date =date('Y-m-d');
     
        $db_tables = $this->config->item('db_tables');
        $this->db->select('SUM(amount) as cost');
        $this->db->from($db_tables['pub_cost']);
        $this->db->where('MONTH(date) = MONTH(CURDATE())-1 && YEAR(date) = YEAR(CURDATE())');
        
        $query = $this->db->get();
        
        $db_rows = $query->result_array();
        foreach ($db_rows as $row) {
            $cost=$row['cost'];
        }

      return $cost;
    
}
}