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
    function get_party_dropdown_search() {
        $customers = $this->db->get('customer')->result();

        $data = array();
        $data[''] = 'Select party by name or code';
        foreach ($customers as $customer) {
            $data[$customer->id_customer] = $customer->id_customer . " - " . $customer->name;
        }
        return form_dropdown('id_customer', $data, NULL, ' class="select2"');
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
        $this->load->model('misc/Customer_payment');

        $id_customer = $this->input->post('id_customer');
        //$discount_percentage = $this->input->post('discount_percentage');
        //$discount_amount = $this->input->post('discount_amount');
        $sub_total = $this->input->post('sub_total');
        $dues_unpaid = $this->input->post('dues_unpaid');
        //$cash_payment = $this->input->post('cash_payment');
        //$bank_payment = $this->input->post('bank_payment');
        $cost=$this->input->post('cost');

        $payment_type = $this->input->post('payment');


//        if($sub_total > $dues_unpaid){
//            $total_amount = $sub_total - $dues_unpaid;
//        }else{
//            $total_amount = 0;
//        }
        $total_amount = $sub_total-$cost;
        
        
         if($cost>0){
            $this->load->model('expense_model');
            $id_name_expense=5;
            $amount_expense=$cost;
            $this->expense_model->expense_register($id_name_expense, $amount_expense, $description_expense = "Customer Send book without transport fees. so we deduct cost from advanced");
        }
        
        if($dues_unpaid>0){
            if($total_amount <= $dues_unpaid ){
                
                 $id_duepayment = $this->Customer_payment->due_payment($id_customer, $total_amount, 4);
                 $total_amount = 0;
            }
            if($total_amount > $dues_unpaid){
                $id_duepayment = $this->Customer_payment->due_payment($id_customer, $dues_unpaid, 4);
                
                $total_amount = $total_amount - $dues_unpaid;
                
            }

        }
        
        if(isset($id_duepayment)){
            $this->session->set_userdata('due_payment',$id_duepayment);
        }
        
        $total_paid = $total_amount;
        


        if ($payment_type == 2 && $total_paid > 0) {
            $this->load->model('advance_payment_model');
            $this->advance_payment_model->payment_add($id_customer, $total_paid, 4);

        }

        $data = array(
            'id_customer' => $id_customer,
            'issue_date' => date('Y-m-d h:i:u'),
            'sub_total' => $sub_total,
            'discount_percentage' => '',
            'discount_amount' => $cost,
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
            $response['next_url'] = site_url('old_book/old_book_dashboard');
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

    function current_advanced_balance($id_customer) {
        $balance = $this->db->query("SELECT balance FROM `party_advance` WHERE `id_customer`=$id_customer");
        foreach ($balance->result_array() as $row) {
            $advanced_balance = $row['balance'];
        }
        
        if(isset($advanced_balance)){
            return $advanced_balance;
        }else{
            return 0;
        }
        
    }
//    
//    function due_payment_report_for_old_book($id){
//        $sql="SELECT * FROM `customer_due_payment_register` WHERE `id_customer_due_payment_register`=$id";
//        return $this->db->get($sql)->result();
//    }
    
    
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
         $return_total=0;
          foreach($total_sales_details as $return){
            $return_total=$return->total_amount;
            $quriar_cost=$return->discount_amount;
            $total_amount = $return->total_amount;
            $sub_total = $return->sub_total;
        }
        
        if($total_amount == 0 && $sub_total>0){
            $due_payment = $sub_total - $quriar_cost + $total_amount;
        }
        if($total_amount > 0  ){
            $due_payment = $sub_total - $quriar_cost - $total_amount;
        }
        
        $total_sales_details = $total_sales_details[0];
       
      



        $this->table->add_row($separator_row, $separator_row, $separator_row, $separator_row);

        $this->table->add_row($total_quantity, '(মোট বই ) ', array(
            'data' => 'বই মূল্য : ',
            'class' => 'left_separator',
            'colspan' => 1
                ), $this->Common->taka_format($total_price));
        $this->table->add_row($separator_row, $separator_row, $separator_row, $separator_row);

        $this->table->add_row(array(
            'data' => 'ফেরত বই এর মূল্য',
            'colspan' => 2
                ), array(
            'data' => $this->Common->taka_format($total_price),
            'colspan' => 2,
            'class' => 'text-right'
        ));
        $this->table->add_row(array(
            'data' => 'কুরিয়ার খরচ',
            'colspan' => 2
                ), array(
            'data' => $quriar_cost,
            'colspan' => 2,
            'class' => 'taka_formate text-right'
        ));
        if(isset($due_payment)){
        $this->table->add_row(array(
            'data' => 'পূর্বের বাকি পরিশোধ',
            'colspan' => 2,
              'class' => 'text-bold'
                ), array(
            'data' => $due_payment,
            'colspan' => 2,
            'class' => 'text-right text-bold taka_formate'
        ));
          }
          $this->table->add_row(array(
            'data' => 'অবশিষ্ট জমা' ,
            'colspan' => 2,
              'class' => 'text-bold'
                ), array(
            'data' => $return_total,
            'colspan' => 2,
            'class' => 'text-right text-bold taka_formate'
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

    function old_book_sale_or_rebind() {
        $this->load->model('misc/Cash');
        $this->load->model('misc/Stock_perpetual');
        $this->load->model('Stock_model');

        $id_customer = $this->input->post('id_customer');
        $sub_total = $this->input->post('price');
        $transfer_type = $this->input->post('process');
        $item_selection = $this->input->post('item_selection');

        $total_amount = $sub_total;


        //        add income and cash
        if ($transfer_type == 1) {
            $this->load->model('Income_model');
            $this->Income_model->add_income('1', $total_amount);
            $this->Cash->add($total_amount);
        }

//          send rebind        
        if ($transfer_type == 2) {

            $data_return = array();
            foreach ($item_selection as $value) {
                if (empty($value)) {
                    continue;
                }
                $tmp_return_book = array(
                    'id_item' => $value['item_id'],
                    'id_process_type' => 1,
                    'order_quantity' => $value['item_quantity'],
                    'date_created' => date('Y-m-d h:i:u')
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
        } else if ($action == 'save_and_print') {
            $response['msg'] = "The Return is successfully done . \n Memo No: $id_old_book_transfer_total";
            $response['next_url'] = site_url('old_book/rebind_transfer_slip/' . $id_old_book_transfer_total);
        }
        echo json_encode($response);
    }

    function old_book_rebind_table($id_old_book_transfer_total) {
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
        $sql = "SELECT old_book_transfer_total.id_old_book_transfer_total,items.id_item,items.name,quantity_item,type_transfer,date_transfer,price 
                    FROM  `old_book_transfer_items` 
                    join items on items.id_item = old_book_transfer_items.id_item
                    join old_book_transfer_total on old_book_transfer_total.id_old_book_transfer_total = old_book_transfer_items.id_old_book_transfer_total
                    where old_book_transfer_total.id_old_book_transfer_total = $id_old_book_transfer_total";
        $results = $this->db->query($sql)->result();
        if (empty($results)) {
            die("No match found");
        }
        $this->table->add_row("Slip Number ", $results[0]->id_old_book_transfer_total, "Date", $results[0]->date_transfer);
        $output = $this->table->generate();
        $total_quantity = 0;
        $this->table->set_heading( "Book ID", 'Book Name', 'Quantity');
        $counter = 1;
        foreach ($results as $row) {
            $this->table->add_row( $row->id_item, $row->name, $row->quantity_item);
            $total_quantity+=$row->quantity_item;
        }

        // Showing total book amount
        $separator_row = array(
            'class' => 'separator'
        );
        $this->table->add_row($separator_row, $separator_row, $separator_row, $separator_row, $separator_row);
        $output .= $this->table->generate();
        $this->table->add_row(array(
            'data' => 'Total Book',
            'class' => 'Bold',
                ), $total_quantity);
        if ($results[0]->type_transfer == 2) {
            $this->table->add_row(array(
                'data' => "Process Type",
                'class' => 'Bold'
                    ), 'Send To Rebind');
        } else {
            $this->table->add_row(array(
                'data' => "Process Type",
                'class' => 'Bold'
                    ), 'Sell');
            $this->table->add_row(array(
                'data' => 'Total Price',
                'class' => 'Bold'
                    ), $this->Common->taka_format($results[0]->price));
        }
        $output .= $this->table->generate();
        return $output;
    }
    //SELECT name,sum(quantity),sum(old_book_return_total.total_amount) FROM `old_book_return_items` left JOIN old_book_return_total on old_book_return_items.id_old_book_return_total=old_book_return_total.id_old_book_return_total 
//LEFT JOIN items ON items.id_item=old_book_return_items.id_item GROUP BY name
    
    function get_total_return_info( $id_customer='' , $date_range='') {
        if($date_range==''){
            $date_range='';
        }else{
            $this->load->model('Common');
            $date = explode('-', $date_range);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime($date[1]));
            $date_range=" DATE(old_book_return_total.issue_date) BETWEEN '$from' AND '$to'";
        }
        
        if($id_customer == '' && $date_range == ''){
            
            $con = ' ';
        }
        
        if ($id_customer !='') {
            
            $con=" where old_book_return_total.id_customer = $id_customer ";    
            
        }
        if ($date_range != '') {            
            
            $con = " where  $date_range";
            
        }
        
        if ($date_range != '' && $id_customer !='') {
            $con = " where old_book_return_total.id_customer = $id_customer AND $date_range";
            
        }       
        
        $query=$this->db->query("SELECT * ,id_old_book_return_items,name,sum(quantity) as total_quantity,sum(old_book_return_total.total_amount) as total_ammount FROM `old_book_return_items` left JOIN old_book_return_total on old_book_return_items.id_old_book_return_total=old_book_return_total.id_old_book_return_total 
LEFT JOIN items ON items.id_item=old_book_return_items.id_item  $con GROUP BY name ORDER BY id_old_book_return_items asc");
        return $query->result();
    }
    
     //SELECT sum(quantity_item),date_transfer,sum(price) FROM `old_book_transfer_total` 
     //left JOIN old_book_transfer_items ON 
     //old_book_transfer_total.id_old_book_transfer_total=old_book_transfer_items.id_old_book_transfer_total
     // where type_transfer=2 GROUP BY id_item
    
    function get_sale_rebind( $id_type='' , $date_range='') {
        if($date_range==''){
            $date_range='';
        }else{
            $this->load->model('Common');
            $date = explode('-', $date_range);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime($date[1]));
            $date_range=" DATE(date_transfer) BETWEEN '$from' AND '$to'";
        }
        
        if($id_type == '' && $date_range == ''){
            
            $con = ' ';
        }
        
        if ($id_type !='') {
            
            $con=" where type_transfer = $id_type ";    
            
        }
        if ($date_range != '') {            
            
            $con = " where  $date_range";
            
        }
        
        if ($date_range != '' && $id_type !='') {
            $con = " where type_transfer = $id_type AND $date_range";
            
        }       
        
        $query=$this->db->query("SELECT *,name, sum(quantity_item) as quantity,date_transfer,sum(price) as price
            FROM `old_book_transfer_total` left JOIN old_book_transfer_items ON 
            old_book_transfer_total.id_old_book_transfer_total=old_book_transfer_items.id_old_book_transfer_total 
            left JOIN items ON items.id_item=old_book_transfer_items.id_item 
            $con GROUP BY old_book_transfer_items.id_item");
        
        return $query->result();
    }
    
    
    
}
