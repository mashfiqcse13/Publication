<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Memo extends CI_Model {

    private $subtotal;
    private $discount;
    private $total;
    private $due;
    private $cash;
    private $book_return;
    private $dues_unpaid;

    function memogenerat($id) {
        $this->load->library('table');
        $query = $this->db->query("SELECT pub_books.name as book_name,
            book_price,
            quantity,
            price,
            cash,
            bank_pay,
            sub_total,
            pub_memos.total as total_p,
            pub_memos_selected_books.total,
            pub_memos.dues_unpaid as dues_unpaid,
            discount,
            due,
            pub_contacts.name as party_name,
            pub_contacts.district as party_district,
            pub_contacts.address as party_address,
            pub_contacts.phone as party_phone,
            pub_memos.book_return as book_return
            FROM `pub_memos_selected_books`
			LEFT JOIN pub_books on pub_memos_selected_books.book_ID=pub_books.book_ID
			LEFT JOIN pub_memos on pub_memos.memo_ID=pub_memos_selected_books.memo_ID
            LEFT JOIN pub_contacts on pub_memos.contact_ID=pub_contacts.contact_ID

			WHERE pub_memos_selected_books.memo_ID='$id'");
        $tmpl = array(
            'table_open' => '<table class="table table-bordered table-striped">',
            'heading_row_start' => '<tr class="success">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Book Name', 'Book Price', 'Sales Price', 'Quantity', 'Total Price');
        foreach ($query->result() as $value) {
            $this->subtotal = $value->sub_total;
            $this->discount = $value->discount;
            $this->table->add_row($value->book_name, $value->book_price, $value->price, $value->quantity, $value->total);
            $this->due = $value->due;
            $this->cash = $value->cash;
            $this->total = $value->total_p;
            $this->dues_unpaid = $value->dues_unpaid;
            $this->book_return = $value->book_return;
            $this->bank_pay = $value->bank_pay;
        }
        $query1 = $this->db->query("SELECT pub_contacts.name as cname,
            pub_contacts.district as cdistrict,
            pub_contacts.address as caddress,
            pub_contacts.phone as cphone,
            pub_memos.memo_ID as memoid
            FROM `pub_contacts`
            LEFT join pub_memos on pub_contacts.contact_ID=pub_memos.contact_ID
            where pub_memos.memo_ID='$id'");

        foreach ($query1->result() as $value) {
            $data['party_name'] = $value->cname;
            $data['phone'] = $value->cphone;
            $data['address'] = $value->caddress;
            $data['district'] = $value->cdistrict;
            $data['memoid'] = $value->memoid;
        }




        $cell = array('border' => 0, 'colspan' => 4);
        $c3 = array('data' => '<strong><span class="upper">(' . $this->convert_number($this->subtotal) . ')</span></strong>', 'colspan' => 3);
        $c3r = array('data' => '', 'colspan' => 3);
        $this->table->add_row($cell, '');

        $this->table->add_row($c3, '<strong>বই মূল্য :</strong>', '<span id="number">' . $this->subtotal . '</span>');
        $this->table->add_row('<strong>বই ফেরত :</strong>', '(-) ' . $this->book_return, '', '<strong>পূর্বের বাকি :</strong>', $this->dues_unpaid);
        $this->table->add_row('<strong>বোনাস :</strong>', '(-) ' . $this->discount, '', '<strong>মোট:</strong>', $this->total);


        $this->table->add_row($c3r, '<strong>নগদ জমা :</strong>', $this->cash);
        $this->table->add_row($c3r, '<strong>ব্যাংক জমা :</strong>', $this->bank_pay);

        $this->table->add_row($c3r, '<strong>বাকি :</strong>', $this->due);
        $this->table->add_row();
        $data['table'] = $this->table->generate();
        return $data;
    }

    function convert_number($number) {
        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }
        $Gn = floor($number / 1000000);
        /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000);
        /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);
        /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);
        /* Tens (deca) */
        $n = $number % 10;
        /* Ones */
        $res = "";
        if ($Gn) {
            $res .= $this->convert_number($Gn) . "Million";
        }
        if ($kn) {
            $res .= (empty($res) ? "" : " ") . $this->convert_number($kn) . " Thousand";
        }
        if ($Hn) {
            $res .= (empty($res) ? "" : " ") . $this->convert_number($Hn) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= " and ";
            }
            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];
                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }
        if (empty($res)) {
            $res = "zero";
        }
        return $res;
    }

    function dateformatter($range_string, $formate = 'Mysql') {
        $date = explode(' - ', $range_string);
        $date[0] = explode('/', $date[0]);
        $date[1] = explode('/', $date[1]);

        if ($formate == 'Mysql')
            return "'{$date[0][2]}-{$date[0][0]}-{$date[0][1]}' and '{$date[1][2]}-{$date[1][0]}-{$date[1][1]}'";
        else
            return $date;
    }

    function dues_unpaid_updater() {
        $this->load->library('table');
        $db_tables = $this->config->item('db_tables');

        $due_holder_rows = $this->db->select('distinct(contact_ID)')
                        ->from($db_tables['pub_memos'])
                        ->where('due >', 0)
                        ->get()->result_array();
        foreach ($due_holder_rows as $index => $row) {
            $contact_ID = $row['contact_ID'];
            $db_rows = $this->db->select("memo_ID,contact_ID,sub_total,discount,book_return,dues_unpaid,total,cash,bank_pay,due")
                            ->from($db_tables['pub_memos'])
                            ->where('due >', '0')
                            ->where('contact_ID', $contact_ID)
                            ->order_by('contact_ID', 'dsc')
                            ->get()->result_array();
//        print_r($db_rows);
//        $this->table->set_heading('memo_ID', 'sub_total', 'discount', 'book_return', 'dues_unpaid', 'total', 'cash', 'bank_pay', 'due');
//        echo $this->table->generate($db_rows);
            foreach ($db_rows as $index => $db_row) {
                $db_rows[$index]['dues_unpaid'] = isset($db_rows[$index - 1]['due']) ? $db_rows[$index - 1]['due'] : 0;
                $db_rows[$index]['total'] = $db_rows[$index]['sub_total'] - $db_rows[$index]['discount'] - $db_rows[$index]['book_return'] + $db_rows[$index]['dues_unpaid'];
                $db_rows[$index]['due'] = $db_rows[$index]['total'] - $db_rows[$index]['cash'] - $db_rows[$index]['bank_pay'];
            }
            $this->db->update_batch($db_tables['pub_memos'], $db_rows, 'memo_ID');

            $this->table->set_heading('memo_ID', 'contact_ID', 'sub_total', 'discount', 'book_return', 'dues_unpaid', 'total', 'cash', 'bank_pay', 'due');
            echo $this->table->generate($db_rows);
        }
    }

    // function listmemo(){
    // 	$query = $this->db->query("SELECT name,memo_ID,memo_serial,issue_date
    // 		from pub_memos LEFT join pub_contacts on
    // 		pub_memos.contact_ID=pub_contacts.contact_ID");
    // }
}
