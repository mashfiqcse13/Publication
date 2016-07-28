<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** 
 * Description of Sales
 *
 * @author Rokibul Hasan
 */
class Old_book_model extends CI_Model {

    function get_available_item_dropdown() {

        $items = $this->db->query("SELECT `id_item`, `name`, `regular_price`, `sale_price`,`total_in_hand` 
            FROM `items` natural join `stock_final_stock`
            WHERE `total_in_hand` > 0 ")->result();

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
        $items = $this->db->query("SELECT `id_item`, `name`, `regular_price`, `sale_price`,`total_in_hand` 
            FROM `items` natural join `stock_final_stock`
            WHERE `total_in_hand` > 0 ")->result();

        $data = array();
        foreach ($items as $item) {
            $data[$item->id_item] = array(
                'id_item' => $item->id_item,
                'name' => $item->name,
                'regular_price' => $item->regular_price,
                'sale_price' => $item->sale_price,
                'total_in_hand' => $item->total_in_hand,
            );
        }
        return $data;
    }
    
    
    function get_old_item_details() {
        $items = $this->db->query("SELECT `id_item`, `name`, `regular_price`, `sale_price`,`total_balance` 
            FROM `items` natural join `old_book_stock`
            WHERE `total_balance` > 0 ")->result();

        $data = array();
        foreach ($items as $item) {
            $data[$item->id_item] = array(
                'id_item' => $item->id_item,
                'name' => $item->name,
                'regular_price' => $item->regular_price,
                'sale_price' => $item->sale_price,
                'total_balance' => $item->total_balance,
            );
        }
        return $data;
    }

    function processing_return_oldbook() {
        $this->load->model('misc/Cash');
        $this->load->model('misc/Customer_due');
        $this->load->model('misc/Stock_perpetual');
        $this->load->model('Stock_model');

        $id_customer = $this->input->post('id_customer');
        //$discount_percentage = $this->input->post('discount_percentage');
        //$discount_amount = $this->input->post('discount_amount');
        $sub_total = $this->input->post('sub_total');
        //$dues_unpaid = $this->input->post('dues_unpaid');
        //$cash_payment = $this->input->post('cash_payment');
        //$bank_payment = $this->input->post('bank_payment');
        
        $payment_type=$this->input->post('payment');

        
//        if($sub_total > $dues_unpaid){
//            $total_amount = $sub_total - $dues_unpaid;
//        }else{
//            $total_amount = 0;
//        }
        $total_amount = $sub_total;
        $total_paid = $total_amount;
        
//        if( $dues_unpaid > $sub_total ){
//            
//            $total_due = $dues_unpaid - $sub_total;
//        }else{
//            $total_due = 0;
//        }        
        

//        if ($cash_payment > 0) {
//            $this->Cash->add($cash_payment) or die('Failed to put cash in cash box');
//        }
//        if ($total_due == 0 && $dues_unpaid =! 0) {
//            $due_payment_amount = $dues_unpaid;
//            $this->load->model('misc/Customer_payment');
//            $this->Customer_payment->add($id_customer, $due_payment_amount);
//        }
//        elseif ( $total_due > 0){
//           
//            $due_payment_amount = $dues_unpaid - $total_due;
//            $this->load->model('misc/Customer_payment');
//            $this->Customer_payment->add($id_customer, $due_payment_amount);
//        }
//        
//        
//        advanced paymend update
        if($payment_type == 2 && $total_paid > 0 ){
            $this->load->model('party_advance_model');
            $this->party_advance_model->add($total_paid , $id_customer);
            
        $data = array(
            'id_customer' => $id_customer,
            'id_payment_method' => '4',
            'amount_paid' => $total_amount,  
            'date_payment' => date('Y-m-d h:i:u'),          
            
        );
                

        $this->db->insert('party_advance_payment_register', $data) or die('failed to insert data on old_book_return_total');


            
            
        }
        
        //cash payment
//        if($payment_type == 1){
//            
//        }
        
//        if ($dues_unpaid > 0 && $total_paid > $total_amount) {
//            $due_payment_amount = $total_paid - $total_amount;
//            $this->load->model('misc/Customer_payment');
//            $this->Customer_payment->add($id_customer, $due_payment_amount);
//            $cash_payment = $total_amount;
//            $total_paid = $cash_payment + $bank_payment;
//            $total_due = 0;
//        }


        
        $data = array(
            'id_customer' => $id_customer,
            'issue_date' => date('Y-m-d h:i:u'),
            'sub_total' => $sub_total,
            'discount_percentage' => '',
            'discount_amount' => '',            
            'total_amount' => $total_amount,            
            'payment_type' => $payment_type,
            'mamo_number' => ''
        );
                

        $this->db->insert('old_book_return_total', $data) or die('failed to insert data on old_book_return_total');


        $id_old_book_return_total = $this->db->insert_id() or die('failed to insert data on old_book_return_total');

        
//        old_book_return_items
        
        $item_selection = $this->input->post('item_selection');
        $data_return = array();
        foreach ($item_selection as $value) {
            if (empty($value)) {
                continue;
            }
            $tmp_return_book = array(
                'id_old_book_return_total' => $id_old_book_return_total,
                'id_item' => $value['item_id'],
                'quantity' => $value['item_quantity'],
                'price' => $value['item_price'],
                'total_cost' => $value['total'],
                'discount_amount' => 0,
                'sub_total' => $value['total'],
            );
            array_push($data_return, $tmp_return_book);
            //$this->Stock_perpetual->Stock_perpetual_register($value['item_id'], $value['item_quantity']);
            //$this->old_book_stock_register($value['item_id'], $value['item_quantity']);
            $this->old_book_stock_add($value['item_id'], $value['item_quantity']);
        }


        $this->db->insert_batch('old_book_return_items', $data_return) or die('failed to insert data on old_book_return_items');
        
        
//        old_stock_register
        $data_return_register = array();
        foreach ($item_selection as $value) {
            if (empty($value)) {
                continue;
            }
            $tmp_return_book = array(
                'id_item' => $value['item_id'],
                'id_total_old_book_return' => $id_old_book_return_total,
                'quantity_reeceived' => $value['item_quantity'],
                'date_received' => date('Y-m-d h:i:u')
            );
            array_push($data_return_register, $tmp_return_book);
           
        }
        $this->db->insert_batch('old_stock_register', $data_return_register) or die('failed to insert data on old_stock_register');
        
        
        
        
        
        $action = $this->input->post('action');
        if ($action == 'save_and_reset') {
            $response['msg'] = "The Return is successfully done . \n Memo No: $id_old_book_return_total";
            $response['next_url'] = site_url('old_book/return_book');
        } else if ($action == 'save_and_back_to_list') {
            $response['msg'] = "The Return is successfully done . \n Memo No: $id_old_book_return_total";
            $response['next_url'] = site_url('old_book/return_book_total');
        } else if ($action == 'save_and_print') {
            $response['msg'] = "The Return is successfully done . \n Memo No: $id_old_book_return_total";
            $response['next_url'] = site_url('old_book/memo/' . $id_old_book_return_total);
        }
        echo json_encode($response);
    }
    
        function old_book_stock_add($id_item, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('old_book_stock')
                        ->where('id_item', $id_item)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `old_book_stock` 
                    (`id_old_book_stock`, `id_item`, `total_in`, `total_out`, `total_balance`)
                    VALUES (NULL, '$id_item', '0', '0', '0');");

        $sql = "UPDATE `old_book_stock` SET 
                `total_in` = `total_in`+'$amount', 
                `total_balance` = `total_balance`+'$amount' 
            WHERE `old_book_stock`.`id_item` = $id_item;";
        $this->db->query($sql);
        return TRUE;
    }
    
    
    function old_book_stock_reduce($id_item, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('old_book_stock')
                        ->where('id_item', $id_item)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `old_book_stock` 
                    (`id_final_stock`, `id_item`, `total_in`, `total_out`, `total_balance`)
                    VALUES (NULL, '$id_item', '0', '0', '0');");

        $current = $this->current_stock_info($id_item);

        if ($current->total_balance >= $amount) {
            $sql = "UPDATE `old_book_stock` SET 
                `total_out` = `total_out`+'$amount', 
                `total_balance` = `total_balance`-'$amount' 
            WHERE `old_book_stock`.`id_item` = $id_item;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    
        function current_stock_info($id_item) {
        $current = $this->db->select('*')
                ->from('old_book_stock')
                ->where('id_item', $id_item)
                ->get()
                ->result();
        if (empty($current[0])) {
            return FALSE;
        }
        return $current[0];
    }
//            function stock_add($id_item, $amount) {
//        // cheching if there is a row , otherwise creating it
//        $this->db->select('*')
//                        ->from('old_book_stock')
//                        ->where('id_item', $id_item)
//                        ->get()
//                        ->result() or
//                $this->db->query("INSERT INTO `old_book_stock` 
//                    (`id_old_book_stock`, `id_item`, `total_in`, `total_out`, `total_balance`)
//                    VALUES (NULL, '$id_item', '0', '0', '0');");
//
//        $sql = "UPDATE `old_book_stock` SET 
//                `total_in` = `total_in`+'$amount', 
//                `total_balance` = `total_balance`+'$amount' 
//            WHERE `old_book_stock`.`id_item` = $id_item;";
//        $this->db->query($sql);
//        return TRUE;
//    }
    
    function memo_header_details($total_sales_id) {
        $sql = "SELECT customer.name as party_name,
            customer.district as district,
            customer.address as caddress,
            customer.phone as phone,
            customer.id_customer as code,
            old_book_return_total.id_old_book_return_total as memoid,
            old_book_return_total.issue_date as issue_date
            FROM `customer`
            LEFT join old_book_return_total on customer.id_customer=old_book_return_total.id_customer
            where old_book_return_total.id_old_book_return_total='$total_sales_id'";
        $data = $this->db->query($sql)->result_array();
        Return $data[0];
    }
    function current_advanced_balance($id_customer){
         $balance=$this->db->query("SELECT balance FROM `party_advance` WHERE `id_customer`=$id_customer");
         foreach($balance->result_array() as $row){
             $advanced_balance=$row['balance'];
         }
         return $advanced_balance;
    }
    
    function memo_body_table($total_sales_id) {
        $this->load->library('table');
        // setting up the table design
        $tmpl = array(
            'table_open' => '<table class="table table-bordered table-striped text-right-for-money">',
            'heading_row_start' => '<tr class="success">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td >',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td >',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Quantity', 'Book Name', 'Buy Price', 'Total Price');
        //Getting the data form the sales table in db
        $sql = "SELECT `quantity`,`items`.`name`,`price`,`sub_total` 
                    FROM `old_book_return_items`
                    left join
                    `items`on `items`.`id_item`= `old_book_return_items`.`id_item`
                    WHERE `id_old_book_return_total` = $total_sales_id";
        $rows = $this->db->query($sql)->result_array();
        $total_quantity = 0;
        $total_price = 0;
        foreach ($rows as $row) {
            $total_quantity += $row['quantity'];
            $total_price += $row['sub_total'];
            $this->table->add_row($row);
        }
        // Showing total book amount
        $separator_row = array(
            'class' => 'separator'
        );
        // setting up the footer options of the memo
        $sql = "SELECT * FROM `old_book_return_total` WHERE `id_old_book_return_total` = $total_sales_id";
        $total_sales_details = $this->db->query($sql)->result();
        $total_sales_details = $total_sales_details[0];
       
        
        
        $this->table->add_row($separator_row, $separator_row, $separator_row, $separator_row);
        
        $this->table->add_row($total_quantity, '(Total Book ) ', array(
            'data' => 'বই মূল্য : ',
            'class' => 'left_separator',
            'colspan' => 1
                ), $this->Common->taka_format($total_price));
        $this->table->add_row($separator_row, $separator_row, $separator_row, $separator_row);
        
        $this->table->add_row(array(
            'data' => 'Advanced Balance Added',
            'colspan' => 2
        ),array(
            'data' => $this->Common->taka_format($total_price),
            'colspan' => 2
        ));
        
//        $this->table->add_row(array(
//            'data' => 'Total Advanced Balance',
//            'colspan' => 2
//        ),array(
//            'data' => $this->Common->taka_format($total_price),
//            'colspan' => 2
//        ));
        
        return $this->table->generate();
    }
    
    function old_book_sale_or_rebind(){
        $this->load->model('misc/Cash');
        $this->load->model('misc/Stock_perpetual');
        $this->load->model('Stock_model');

        $id_customer = $this->input->post('id_customer');
        $sub_total = $this->input->post('price');
        $transfer_type=$this->input->post('process');
        $item_selection = $this->input->post('item_selection');

        $total_amount = $sub_total;
        
        
 //        add income and cash
        if($transfer_type == 1){
            $this->load->model('Income_model');            
            $this->Income_model->add_income('1',$total_amount);
            $this->Cash->add($total_amount);       
        
        }
        
//          send rebind        
        if($transfer_type == 2){
            
            $data_return = array();
            foreach ($item_selection as $value) {
                if (empty($value)) {
                    continue;
                }
                $tmp_return_book = array(

                    'id_item' => $value['item_id'],
                    'id_process_type' => 1,
                    'order_quantity' => $value['item_quantity'],
                    'date_created'  => date('Y-m-d h:i:u')
                );
                array_push($data_return, $tmp_return_book);
                //$this->Stock_perpetual->Stock_perpetual_register($value['item_id'], $value['item_quantity']);
                //$this->old_book_stock_register($value['item_id'], $value['item_quantity']);
//                $this->old_book_stock_reduce($value['item_id'], $value['item_quantity']);
            }   

            $this->db->insert_batch('processes', $data_return) or die('failed to insert data on processes');

       
        }
        
//        old book transfer total              
            
            $data_total = array(
                'type_transfer' => $transfer_type,
                'date_transfer' => date('Y-m-d h:i:u'),
                'price' => $total_amount
            );                

        $this->db->insert('old_book_transfer_total', $data_total) or die('failed to insert data on old_book_transfer_total');
        $id_old_book_transfer_total = $this->db->insert_id() or die('failed to insert data on old_book_return_total');
    

 
       
//        old_book_return_items
        
       
        $data_return = array();
        foreach ($item_selection as $value) {
            if (empty($value)) {
                continue;
            }
            $this->old_book_stock_reduce($value['item_id'], $value['item_quantity']);

            $tmp_return_book = array(
               
                'id_item' => $value['item_id'],
                'quantity_item' => $value['item_quantity'],
                'id_old_book_transfer_total' => $id_old_book_transfer_total,
            );
            array_push($data_return, $tmp_return_book);
            //$this->Stock_perpetual->Stock_perpetual_register($value['item_id'], $value['item_quantity']);
            //$this->old_book_stock_register($value['item_id'], $value['item_quantity']);
            
        }   
        
        $this->db->insert_batch('old_book_transfer_items', $data_return) or die('failed to insert data on id_old_book_transfer_items');
        
       
        
        
        $action = $this->input->post('action');
        if ($action == 'save_and_reset') {
            $response['msg'] = "The Return is successfully done . \n Memo No: $id_old_book_transfer_total";
            $response['next_url'] = site_url('old_book/return_book_sale');
        } else if ($action == 'save_and_back_to_list') {
            $response['msg'] = "The Return is successfully done . \n Memo No: $id_old_book_transfer_total";
            $response['next_url'] = site_url('old_book/return_book_sale_list');
        } 
        echo json_encode($response);
    }
    



}
