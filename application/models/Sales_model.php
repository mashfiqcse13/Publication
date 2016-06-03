<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Sales
 *
 * @author MD. Mashfiq
 */
class Sales_model extends CI_Model {

    function get_item_dropdown() {
        $items = $this->db->get('items')->result();

        $data = array();
        $data[''] = 'Select items by name or code';
        foreach ($items as $item) {
            $data[$item->id_item] = $item->id_item . " - " . $item->name;
        }
        return form_dropdown('id_item', $data, '', ' class="select2" ');
    }

    function get_party_dropdown() {
        $customers = $this->db->get('customer')->result();

        $data = array();
        $data[''] = 'Select party by name or code';
        foreach ($customers as $customer) {
            $data[$customer->id_customer] = $customer->id_customer . " - " . $customer->name;
        }
        return form_dropdown('id_customer', $data, NULL, ' class="select2" required');
    }

    function get_party_due() {
        $customers = $this->db->query("SELECT id_customer,total_due
                            FROM customer_due
                            WHERE total_due > 0 ")->result();

        $data = array();
        foreach ($customers as $customer) {
            $data[$customer->id_customer] = $customer->total_due;
        }
        return $data;
    }

    function get_item_details() {
        $items = $this->db->query("SELECT `id_item`, `name`, `regular_price`, `sale_price` "
                        . "FROM `items` WHERE 1")->result();

        $data = array();
        foreach ($items as $item) {
            $data[$item->id_item] = array(
                'id_item' => $item->id_item,
                'name' => $item->name,
                'regular_price' => $item->regular_price,
                'sale_price' => $item->sale_price,
            );
        }
        return $data;
    }

    function processing_new_sales() {
        $data = array(
            'id_customer' => $this->input->post('id_customer'),
            'issue_date' => date('Y-m-d h:i:u'),
            'discount_percentage' => $this->input->post('discount_percentage'),
            'discount_amount' => $this->input->post('discount_amount'),
            'sub_total' => $this->input->post('sub_total'),
            'total_amount' => $this->input->post('total_amount'),
            'cash' => $this->input->post('cash_payment'),
            'total_paid' => $this->input->post('total_paid'),
            'total_due' => $this->input->post('total_due'),
        );

        $this->db->insert('sales_total_sales', $data) or die('failed to insert data on sales_total_sales');
        $id_total_sales = $this->db->insert_id() or die('failed to insert data on sales_total_sales');

        $item_selection = $this->input->post('item_selection');
        $data_sales = array();
        foreach ($item_selection as $value) {
            if (empty($value)) {
                continue;
            }
            $tmp_data_sales = array(
                'id_total_sales' => $id_total_sales,
                'id_item' => $value['item_id'],
                'quantity' => $value['item_quantity'],
                'price' => $value['sale_price'],
                'total_cost' => $value['total'],
                'discount' => 0,
                'sub_total' => $value['total'],
            );
            array_push($data_sales, $tmp_data_sales);
        }


        $this->db->insert_batch('sales', $data_sales) or die('failed to insert data on sales');
        $action = $this->input->post('action');
        if ($action == 'save_and_reset') {
            $response['msg'] = "The sales is successfully done . \n Memo No: $id_total_sales";
            $response['next_url'] = site_url('sales/new_sale');
        } else if ($action == 'save_and_back_to_list') {
            $response['msg'] = "The sales is successfully done . \n Memo No: $id_total_sales";
            $response['next_url'] = site_url('sales/tolal_sales');
        } else if ($action == 'save_and_print') {
            $response['msg'] = "The sales is successfully done . \n Memo No: $id_total_sales";
            $response['next_url'] = site_url('sales/tolal_sales/read/' . $id_total_sales);
        }
        echo json_encode($response);
    }

}
