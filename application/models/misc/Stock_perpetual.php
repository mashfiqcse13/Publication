<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Stock_perpetual
 *
 * @author MD. Mashfiq
 */
class Stock_perpetual extends CI_Model {

    function Stock_perpetual_register($id_item, $amount, $type_code = 1) {
        $types = array('receive_amount', 'sales_amount','specimen', 'return_amountreject', 'reject_amount');
        $types_opetator = array('+', '-', '-', '+', '-');
        if (empty($types[$type_code])) {
            return false;
        }
        $current_id_perpetual_stock_register = $this->id_today_row($id_item) or
                $current_id_perpetual_stock_register = $this->start_today_row($id_item);

        $type_of_data = $types[$type_code];
        $closing_operator = $types_opetator[$type_code];
        $sql = "UPDATE  `stock_perpetual_stock_register`
            SET  `$type_of_data` =  `$type_of_data`+ ($amount) , `closing_stock` =  `closing_stock`$closing_operator ($amount)
            WHERE `id_perpetual_stock_register` =$current_id_perpetual_stock_register;";

        $this->db->query($sql);
        return TRUE;
    }

    function id_today_row($id_item) {
        $where = array(
            'id_item' => $id_item,
            'date' => date('Y-m-d')
        );
        $result = $this->db->select('id_perpetual_stock_register')
                        ->from('stock_perpetual_stock_register')
                        ->where($where)
                        ->get()->result();
        if (empty($result[0])) {
            return FALSE;
        }
        return $result[0]->id_perpetual_stock_register;
    }

    function start_today_row($id_item) {
       $last_closeing_stock = $this->get_last_closeing_stock($id_item);
        $data_to_insert_in_stock_perpetual_stock_register = array(
            'id_item' => $id_item,
            'opening_amount' => $last_closeing_stock,
            'closing_stock' => $last_closeing_stock,
            'date' => date('Y-m-d')
        );

        $this->db->insert('stock_perpetual_stock_register', $data_to_insert_in_stock_perpetual_stock_register);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function get_last_closeing_stock($id_item) {

        $sql = "SELECT  `id_perpetual_stock_register` ,  `id_item` ,  `closing_stock` 
            FROM  `stock_perpetual_stock_register` 
            WHERE  `id_item` = $id_item
            ORDER BY  `id_perpetual_stock_register` DESC  ";
        $result = $this->db->query($sql)->result();
        if (empty($result[0])) {
            return 0;
        }
        $closing_stock = $result[0]->closing_stock;
        return $closing_stock;
    }

}
