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

      function insert_return_item($post){
         
         
              
                $memo_ID = $this->input->post('memo_ID');
                $book_ID= $this->input->post('book_ID');
                $stock_ID= $this->input->post('stock_ID');
                $quantity= $this->input->post('quantity');
                $price_per_book= $this->input->post('price');
                
      
                $data=array();   
                foreach($memo_ID as $key => $val){
                  
                            $data=array(
                                'memo_ID' => $memo_ID[$key],
                                'book_ID' => $book_ID[$key],
                                'stock_ID' => $stock_ID[$key],
                                'quantity' => $quantity[$key],
                                'price_per_book' => $price_per_book[$key],
                                'total' => $quantity[$key]*$price_per_book[$key]
                            );
                            $this->db->insert('sales_current_sales_return',$data);
                            
                            
                                 
                }  

            

      }
      
      
      function get_book_list($id){
          
        $query = $this->db->query("SELECT * ,pub_books.name as book_name
            FROM `pub_memos_selected_books`
			LEFT JOIN pub_books on pub_memos_selected_books.book_ID=pub_books.book_ID
			LEFT JOIN pub_memos on pub_memos.memo_ID=pub_memos_selected_books.memo_ID
            LEFT JOIN pub_contacts on pub_memos.contact_ID=pub_contacts.contact_ID
			WHERE pub_memos_selected_books.memo_ID='$id'");
        
        return $query->result_array();
        
        
    }
    
   
}

