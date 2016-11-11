<?php

class Test_stock_model extends CI_Model {
    
    function sales_item(){
        $sql = "SELECT date(issue_date) as issue_date, id_item, sum(quantity) as sale_quantity FROM `sales` 
LEFT JOIN sales_total_sales on sales.id_total_sales = sales_total_sales.id_total_sales 
group BY id_item";
       return $this->db->query($sql)->result();
       
    } 
    
    function stock_register_item(){
        $sql = "SELECT date,id_item, sum(sales_amount) as register_sales_amount FROM `stock_perpetual_stock_register` 
GROUP BY id_item";
        return $this->db->query($sql)->result();
    }
    
    

}

