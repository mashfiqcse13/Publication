<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Stock_Manages extends CI_Model{

    function printing_press(){
        $query="SELECT book_ID,printing_press_Quantity,binding_store_ID,binding_store_Quantity,sales_store_id,Sales_store_Quantity FROM pub_stock WHERE "
    }

}