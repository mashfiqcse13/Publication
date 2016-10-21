<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Sales
 *
 * @author MD. Mashfiq
 */
class Sales_model extends CI_Model {

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

    function get_party_dropdown_as_customer() {
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

    function memo_header_details($total_sales_id) {
        $sql = "SELECT customer.name as party_name,
            customer.district as district,
            customer.address as caddress,
            customer.phone as phone,
            customer.id_customer as code,
            sales_total_sales.id_total_sales as memoid,
            sales_total_sales.issue_date as issue_date
            FROM `customer`
            LEFT join sales_total_sales on customer.id_customer=sales_total_sales.id_customer
            where sales_total_sales.id_total_sales='$total_sales_id'";
        $data = $this->db->query($sql)->result_array();
//        $this->db->select('customer.name as party_name,customer.district as district, customer.address as caddress,customer.phone as phone,customer.id_customer as code,sales_total_sales.id_total_sales as memoid,sales_total_sales.issue_date as issue_date');
//        $this->db->from('customer');
//        $this->db->join('sales_total_sales','customer.id_customer=sales_total_sales.id_customer','left');
//        if(!empty($total_sales_id)){
//            $this->db->where('sales_total_sales.id_total_sales',$total_sales_id);
//        }
//        if(!empty($id_customer)){
//            $this->db->where('sales_total_sales.id_customer',$id_customer);
//        }
//        $data = $this->db->get()->result_array();
//        print_r($data);exit();
        Return $data[0];
    }

    function payment_by_memo($memo_id) {
        $this->db->select('payment_method.name_payment_method as payment_method,sum(paid_amount) as paid_amount')
                ->from('customer_payment')
                ->join('payment_method', 'payment_method.id_payment_method=customer_payment.id_payment_method', 'left')
                ->where('customer_payment.id_total_sales', $memo_id)
                ->group_by('payment_method.id_payment_method');

        $sql = $this->db->get()->result();

        return $sql;
    }

    function memo_previous_due($customer_id, $memo_date) {
        //left join payment_method ON payment_method.id_payment_method=customer_payment.id_payment_method
        //SELECT sum(paid_amount) as due_payment FROM `customer_payment` WHERE due_payment_status=1 group BY id_payment_method
        $this->db->select('payment_method.name_payment_method as payment_method,sum(paid_amount) as paid_amount')
                ->from('customer_payment')
                ->join('payment_method', 'payment_method.id_payment_method=customer_payment.id_payment_method', 'left')
                ->where('due_payment_status', '1')
                ->where('id_customer', $customer_id)
                ->where('payment_date', $memo_date)
                ->group_by('payment_method.id_payment_method');

        $sql = $this->db->get()->result();

        return $sql;
    }

    function get_memo_customer_id($id) {
        $query = $this->db->select('*')
                        ->from('sales_total_sales')
                        ->where('id_total_sales', $id)
                        ->get()->result();
        return $query;
    }

    function generate_due_report_by_memo($memo_id) {
        $this->db->select('customer_payment.id_total_sales,payment_method.name_payment_method,customer_payment.paid_amount')
                ->from('customer_due_payment_register')
                ->join('customer_payment', 'customer_due_payment_register.id_customer_due_payment_register=customer_payment.id_customer_due_payment_register', 'left')
                ->join('payment_method', ' payment_method.id_payment_method=customer_payment.id_payment_method', 'left')
                ->where('customer_due_payment_register.id_total_sales', $memo_id);
        $query = $this->db->get()->result_array();

        return $query;
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
        $this->table->set_heading('Quantity', 'Book Name', 'Book Price', 'Sales Price', 'Total Price');
        //Getting the data form the sales table in db
        $sql = "SELECT `quantity`,`items`.`name`, `items`.`regular_price`,`price`,`sub_total` 
                    FROM `sales`
                    left join
                    `items`on `items`.`id_item`= `sales`.`id_item`
                    WHERE `id_total_sales` = $total_sales_id";
//        $this->db->select('quantity.itemx.name,items.regular_price,price,sub_total');
//        $this->db->from('sales');
//        $this->db->join('items','items.id_item = sales.id_item','left');
//        if(!empty($total_sales_id)){
//            $this->db->where('id_total_sales',$total_sales_id);
//        }
//        if(!empty($id_customer)){
//            $this->db->where('sales_total_sales.id_customer',$id_customer);
//        }
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
        $sql = "SELECT * FROM `sales_total_sales` WHERE `id_total_sales` = $total_sales_id";
        $total_sales_details = $this->db->query($sql)->result();
        $total_sales_details = $total_sales_details[0];

        $generate_due_report_by_memo = $this->generate_due_report_by_memo($total_sales_id);
        
        $current_due_amount = 0;
        foreach ($generate_due_report_by_memo as $due) {
            $current_due_amount+=$due['paid_amount'];
        }


        //্ get due payment info
//        $customer_id=0;
//        $memo_date='';
//        $memo_details=$this->get_memo_customer_id($total_sales_id);
//            foreach($memo_details as $row){
//                $customer_id=$row->id_customer;
//                $memo_date="$row->issue_date";
//            }

        $memo_payment = $this->payment_by_memo($total_sales_id);
        $total_pay = 0;
        foreach ($memo_payment as $row) {
            $pay["$row->payment_method"] = $row->paid_amount;
            $total_pay+=$row->paid_amount;
        }

        $cash_pay = isset($pay['Cash']) ? $pay['Cash'] : 0;
        $bank_pay = isset($pay['Bank']) ? $pay['Bank'] : 0;
        $pay_from_advanced = isset($pay['Customer advance']) ? $pay['Customer advance'] : 0;
        $current_due = $total_sales_details->total_amount - $total_pay;
        if ($current_due > 0) {
            $current_due_status = '<div class="text-memo-special-formate text-danger">DUE</div>';
        } else {
            $current_due_status = '<div class="text-memo-special-formate text-success">PAID</div>';
        }


//        $this->table->add_row($separator_row, $separator_row, $separator_row, $separator_row, $separator_row);
        $this->table->add_row('', ' ', array(
            'data' => 'বই মূল্য : ',
            'class' => '',
            'colspan' => 2
                ), $this->Common->taka_format($total_price));

        $this->table->add_row( '<strong>'.$total_quantity.'</strong>', ' <strong>(মোট বই )</strong> ', array(
            'data' => 'ছাড় : ',
            'class' => ' taka_formate',
            'colspan' => 2
                ), $total_sales_details->discount_amount);


        $this->table->add_row(array(
            'data' => '<strong>কথায় : </strong><span style="font-size:12px">' . $this->Common->convert_number($total_sales_details->total_amount) . '</span>',
            'colspan' => 2
                ), array(
            'data' => 'সর্বমোট : ',
            'class' => '',
            'colspan' => 2
                ), $this->Common->taka_format($total_sales_details->total_amount));


        $this->table->add_row(array(
            'data' => $current_due_status,
            'class' => ' ',
            'colspan' => 2,
            'rowspan' => 5
                ), array(
            'data' => 'নগদ জমা : ',
            'class' => '',
            'colspan' => 2
                ), $cash_pay);

        $this->table->add_row(array(
            'data' => 'ব্যাংক জমা : ',
            'class' => '',
            'colspan' => 2
                ), array(
            'data' => $bank_pay,
            'class' => 'text-right taka_formate'
        ));

        $this->table->add_row(array(
            'data' => 'পূর্বের জমা কর্তন : ',
            'class' => '',
            'colspan' => 2
                ), array(
            'data' => $pay_from_advanced,
            'class' => 'text-right taka_formate'
        ));



        $this->load->model('misc/Customer_due');
        $this->table->add_row(array(
            'data' => ' মোট জমা :',
            'class' => '',
            'colspan' => 2
                ), array(
            'data' => $total_pay,
            'class' => 'text-right taka_formate'
        ));
        
         $this->table->add_row(array(
            'data' => ' পূর্বের বকেয়া পরিশোধ  :',
            'class' => '',
            'colspan' => 2
                ), array(
            'data' => $current_due_amount ,
            'class' => 'text-right taka_formate'
        ));
        


        $this->table->add_row(array(
            'data' => 'সর্বশেষ বাকি : ' . $this->Common->taka_format($this->Customer_due->current_total_due($total_sales_details->id_customer)),
            'class' => 'text-bold',
            'colspan' => 2
                ), array(
            'data' => 'বাকি : ',
            'class' => '  text-bold ',
            'colspan' => 2
                ), $this->Common->taka_format($current_due));

  

        $this->table->add_row(array(
            'data' => 'প্যাকেটিং খরচ বাকি: ',
            'class' => '',
            'colspan' => 2
                ), array(
            'data' => $total_sales_details->bill_for_packeting,
            'class' => 'text-right taka_formate',
            'colspan' => 3
        ));

        $this->table->add_row(array(
            'data' => ' স্লিপ খরচ : ',
            'class' => '',
            'colspan' => 2
                ), array(
            'data' => $total_sales_details->slip_expense_amount,
            'class' => 'text-right taka_formate',
            'colspan' => 3
        ));

        $this->table->add_row(array(
            'data' => 'সর্বমোট  গ্রহন  : ',
            'class' => 'text-bold',
            'colspan' => 2
                ), array(
            'data' => /* $total_sales_details->bill_for_packeting + */ $bank_pay + $cash_pay + $current_due_amount,
            'class' => 'text-right taka_formate text-bold',
            'colspan' => 3
        ));
        

                
        $data['memo'] = $this->table->generate();


        if (!empty($generate_due_report_by_memo)) {
            $this->table->clear();
            $this->table->set_template($tmpl);
            $this->table->set_heading('Memo No', 'Payment Method', 'Payment Amount');
            $data['due_report'] = $this->table->generate($generate_due_report_by_memo);
        }
        return $data;
    }

    function get_customer_name($id_customer) {
        $quer = $this->db->where('id_customer', $id_customer)->get('customer')->result();
        foreach ($quer as $row) {
            $name = $row->name;
        }
        return $name;
    }

    function get_total_sales_info($from, $to, $id_customer, $filter_district) {
        $from = date('Y-m-d', strtotime($from));
        $to = date('Y-m-d', strtotime($to));
        $this->db->select('sales_total_sales.*,customer.*,view_customer_paid_marged.cash_paid,view_customer_paid_marged.bank_paid,view_customer_paid_marged.customer_advance_paid,view_customer_paid_marged.customer_old_book_sell');
        $this->db->from('sales_total_sales');
        $this->db->join('view_customer_paid_marged', 'sales_total_sales.id_total_sales = view_customer_paid_marged.id_total_sales', 'left')
                ->join('customer', 'sales_total_sales.id_customer = customer.id_customer', 'left');
        if (!empty($id_customer)) {
            $this->db->where('sales_total_sales.id_customer', $id_customer);
        }
        if (!empty($filter_district)) {
            $this->db->where('customer.district', $filter_district);
        }
        if ($from != '1970-01-01') {
            $condition = "DATE(sales_total_sales.issue_date) BETWEEN '$from' AND '$to'";
            $this->db->where($condition);
//            $this->db->where('sales_total_sales.issue_date >= ', date('Y-m-d', strtotime($from)));
//            $this->db->where('sales_total_sales.issue_date <= ', date('Y-m-d', strtotime($to)));
        }
        $this->db->order_by('sales_total_sales.id_total_sales', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function accurate_sale($id_customer = '', $date_range = '', $party_district = '') {

        $conditions = array();

        if (!empty($id_customer)) {
            array_push($conditions, "id_customer = $id_customer");
        }
        if (!empty($party_district)) {
            array_push($conditions, "party_district = '$party_district'");
        }
        if (!empty($date_range)) {
            $this->load->model('Common');
            $date = explode('-', $date_range);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime($date[1]));
            $date_range = "DATE(issue_date) BETWEEN DATE('$from') AND  DATE('$to')";
            array_push($conditions, "$date_range");
        }
        $condition = (empty($id_customer) && empty($date_range)) ? "" : "WHERE " . implode(' AND ', $conditions);
        $sql = "SELECT  `id_item` ,  `item_name` , SUM( quantity ) AS sales_quantity,  `issue_date` 
                FROM  `view_sales_with_party_district` 
                $condition
                GROUP BY id_item";
//        die($sql);
        $query = $this->db->query($sql);

        return $query->result();
    }

    function return_book($id_customer = '', $date_range = '') {
        if ($date_range == '') {
            $date_range = '';
        } else {
            $this->load->model('Common');
            $date = explode('-', $date_range);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime($date[1]));
            $date_range = "  DATE(sales_current_sales_return.date_current_sales_return) BETWEEN '$from' AND '$to'";
        }

        if ($id_customer == '' && $date_range == '') {

            $con = ' ';
        }

        if ($id_customer != '') {

            $con = " where sales_total_sales.id_customer = $id_customer ";
        }
        if ($date_range != '') {

            $con = " where  $date_range";
        }

        if ($date_range != '' && $id_customer != '') {
            $con = " where sales_total_sales.id_customer = $id_customer AND $date_range";
        }

        $query = $this->db->query("SELECT items.id_item as id_item,items.name as name,
            sum(sales_current_sales_return.quantity) as return_quantity
            FROM 
            sales_current_sales_return left JOIN items ON sales_current_sales_return.book_ID=items.id_item
            LEFT JOIN sales_total_sales ON sales_total_sales.id_total_sales=sales_current_sales_return.memo_ID
            $con
            GROUP BY items.id_item
                        ");

        return $query->result();
    }

    function old_book_quantity($id_customer = '', $date_range = '') {

        if ($date_range == '') {
            $date_range = '';
        } else {
            $this->load->model('Common');
            $date = explode('-', $date_range);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime($date[1]));
            $date_range = "  DATE(old_book_return_total.issue_date) BETWEEN '$from' AND '$to'";
        }

        if ($id_customer == '' && $date_range == '') {

            $con = ' ';
        }

        if ($id_customer != '') {

            $con = " where old_book_return_total.id_customer = $id_customer ";
        }
        if ($date_range != '') {

            $con = " where  $date_range";
        }

        if ($date_range != '' && $id_customer != '') {
            $con = " where old_book_return_total.id_customer = $id_customer AND $date_range";
        }


        $query = $this->db->query("SELECT `id_item`, 
                sum(old_book_return_items.quantity) as old_quantity 
                FROM `old_book_return_items` 
                LEFT JOIN `old_book_return_total` 
                ON `old_book_return_total`.`id_old_book_return_total` = `old_book_return_items`.`id_old_book_return_total`
                $con
                GROUP BY `id_item` 
                ");

        return $query->result();
    }

}
