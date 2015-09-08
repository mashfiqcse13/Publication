<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Memo extends CI_Model{
	private $subtotal;
	private $discount;
	private $total;

	function memogenerat($id){
		$this->load->library('table');
		$query = $this->db->query("SELECT name,quantity,price,total,discount FROM `pub_memos_selected_books` 
			LEFT JOIN pub_books on pub_memos_selected_books.book_ID=pub_books.book_ID 
			LEFT JOIN pub_memos on pub_memos.memo_ID=pub_memos_selected_books.memo_ID 
			WHERE pub_memos_selected_books.memo_ID='$id' ");
			
			$tmpl = array (
                    'table_open'          => '<table class="table table-bordered table-striped">',

                    'heading_row_start'   => '<tr class="success">',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

			$this->table->set_template($tmpl); 
			$this->table->set_heading('Book Name','Quantity','Price','Total Price');
		foreach ($query->result() as $value) {
			 // $data['name']=$value->name;
			 // $data['quantity']=$value->quantity;
			 // $data['price']=$value->price;
			 // $data['total']=$value->total;
			$this->subtotal+=$value->total;
			$this->discount=$value->discount;
			
			$this->table->add_row($value->name, $value->quantity, $value->price,$value->total);
			 
		
		}

		$this->table->add_row('','','Subtotal',$this->subtotal);
		$this->table->add_row('','','Discount',$this->discount);
		$this->table->add_row('','','Total',$this->subtotal-$this->discount);
		return $this->table->generate();
		
	}

	// function listmemo(){
	

	// 	$query = $this->db->query("SELECT name,memo_ID,memo_serial,issue_date 
	// 		from pub_memos LEFT join pub_contacts on 
	// 		pub_memos.contact_ID=pub_contacts.contact_ID");
		
	

	// }

}