<?php
/**
 * Description of Salary_model
 *
 * @author Rokibul Hasan
 */

class Sales_return_m extends CI_Model {

    
    function get_memos($id){
        //$this->load->library('table');
        
        $this->db->select('*');
        $this->db->from('pub_memos');
        $this->db->where('memo_ID',$id);
        
        $query = $this->db->get();
        
       
        
        
        //$data_table = $this->table->generate($query);
        
        return $query->result_array();
        
        
        
    }
    
    function get_all_return_item(){
       
        $this->load->library('table');
        
        $query=$this->db->query("SELECT selection_ID,memo_ID,pub_books.name,quantity,price_per_book,total "
                . "FROM `sales_current_sales_return` "
                . "LEFT JOIN pub_books ON sales_current_sales_return.book_ID=pub_books.book_ID "
                . "WHERE  quantity>0 ORDER BY selection_ID DESC")->result_array();
        
        
        $tmpl = array (
                    'table_open'          => '<table class="table table-bordered table-striped">',

                    'heading_row_start'   => '<tr>',
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
            $this->table->set_heading('Selection Id', 'Memo Id', 'Book Name', 'Quantity', 'Price', 'Total');

            return $this->table->generate($query);
    }

      function insert_return_item($post){
              $this->load->model('misc/cash');
              $this->load->model('misc/customer_due');         
                
              
                $memo_ID = $this->input->post('memo_ID');
                $book_ID= $this->input->post('book_ID');
                $stock_ID= $this->input->post('stock_ID');
                $quantity= $this->input->post('quantity');
                $price_per_book= $this->input->post('price');
                $pre_quantity=$this->input->post('pre_quantity');
                $contact_ID=$this->input->post('contact_ID');
                
               
                $values=0;
                $data_add=array();   
                foreach($memo_ID as $key => $val){
                  
                            $data_add=array(
                                'memo_ID' => $memo_ID[$key],
                                'book_ID' => $book_ID[$key],
                                'stock_ID' => $stock_ID[$key],
                                'quantity' => $quantity[$key],
                                'price_per_book' => $price_per_book[$key],
                                'total' => $quantity[$key]*$price_per_book[$key]
                            );
                            
                            $this->db->insert('sales_current_sales_return',$data_add);  
                            
                            $values+=$data_add['total'];

                }
                
                $stock_add=array();   
                foreach($memo_ID as $key => $val){
                  $memo_ID_update=$memo_ID[$key];
                    
                  $this->db->query("UPDATE pub_stock SET Quantity=Quantity+$quantity[$key] WHERE book_ID=$book_ID[$key] AND printing_press_ID=2");
                  
                  
                }
                
                $data_delete=array();
                foreach ($memo_ID as $key => $val){
                    $data_delete=array(
                                'quantity' =>$pre_quantity[$key]-$quantity[$key],                                
                                'total' =>($pre_quantity[$key]-$quantity[$key])*$price_per_book[$key]
                            );
                            
                    $this->db->where('memo_ID', $memo_ID[$key]);
                    $this->db->where('book_ID',$book_ID[$key]);
                    $this->db->update('pub_memos_selected_books', $data_delete);
               }
               
               
              $this->db->query("UPDATE `pub_memos` SET `sub_total`=sub_total-$values,`total`=total-$values,`due`=due-$values WHERE memo_ID=$memo_ID_update");
              
              $this->customer_due->reduce($contact_ID,$values);
              $this->cash->reduce($values);

               return $values;
      }
      

      
//      function update_memo($id){
//                   
//          $this->db->select('SUM(total) as total_price');
//          $this->db->where('memo_ID',$id);
//          $total_book_price = $this->db->get('pub_memos_selected_books');
//
//            foreach ($total_book_price->result() as $row)
//            {
//                $total_price= $row->total_price;
//            }
//            
//            
//          
//      }
      

      
      function get_book_list($id){
          
        $query = $this->db->query("SELECT * ,pub_books.name as book_name, quantity-IFNULL((SELECT SUM(quantity) FROM sales_current_sales_return where memo_ID=pub_memos.memo_ID and book_ID=pub_books.book_ID),0) as return_quantity
            FROM `pub_memos_selected_books`
			LEFT JOIN pub_books on pub_memos_selected_books.book_ID=pub_books.book_ID
			LEFT JOIN pub_memos on pub_memos.memo_ID=pub_memos_selected_books.memo_ID
            LEFT JOIN pub_contacts on pub_memos.contact_ID=pub_contacts.contact_ID
			WHERE pub_memos_selected_books.memo_ID='$id'");
        
        return $query->result_array();
        
        
    }
    
   
}

