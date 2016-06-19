<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of Salary_model
 *
 * @author Rokibul Hasan
 */

class Sales_return_m extends CI_Model {

    
    function get_memos($id){
        //$this->load->library('table');
        
        $this->db->select('*');
        $this->db->from('sales_total_sales');
        $this->db->where('id_total_sales',$id);
        
        $query = $this->db->get();
        
       
        
        
        //$data_table = $this->table->generate($query);
        
        return $query->result_array();
        
        
        
    }
    
    function get_all_return_item(){
       
        $this->load->library('table');
        
        $query=$this->db->query("SELECT selection_ID,memo_ID,items.name,quantity,price_per_book,total "
                . "FROM `sales_current_sales_return` "
                . "LEFT JOIN items ON sales_current_sales_return.book_ID=items.id_item "
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
              $this->load->model('misc/Stock_perpetual'); 
              $this->load->model('Stock_model');
                
              
                $memo_ID = $this->input->post('id_total_sales');
                $book_ID= $this->input->post('id_item');
//                $stock_ID= $this->input->post('stock_ID');
                $quantity= $this->input->post('quantity');
                $price_per_book= $this->input->post('price');
                $pre_quantity=$this->input->post('pre_quantity');
                $contact_ID=$this->input->post('id_customer');
//                echo '<pre>';
//                print_r($post);
//               exit();
                $values=0;
                $data_add=array(); 
                $id=array();
                foreach($memo_ID as $key => $val){
                           if($quantity[$key]!= 0){ 

                            $data_add=array(
                                'memo_ID' => $memo_ID[$key],
                                'book_ID' => $book_ID[$key],
//                                'stock_ID' => $stock_ID[$key],
                                'quantity' => $quantity[$key],
                                'price_per_book' => $price_per_book[$key],
                                'total' => $quantity[$key]*$price_per_book[$key]
                            );
                            
                            $this->db->insert('sales_current_sales_return',$data_add);  
                            $id[] = $this->db->insert_id();
                            $values+=$data_add['total'];
                           }
                                                      

                }//insert sales_current_sales_return table
                
                $stock_add=array(); 
                $data_delete=array();
                
                foreach($memo_ID as $key => $val){
                    $memo_ID_update=$memo_ID[$key];
                    $id_item=$book_ID[$key];
                    
                    $amount=$quantity[$key];
                    if(!empty($amount)){
                        $this->Stock_perpetual->Stock_perpetual_register($id_item, $amount, $type_code = 3) ;
                        $this->Stock_model->stock_add($id_item, $amount);
                    }
   
                    //update stock,stock_perpetual_register section end
          
                    $data_delete=array(
                                'quantity' =>$pre_quantity[$key]-$quantity[$key],                                
                                'total_cost' =>($pre_quantity[$key]-$quantity[$key])*$price_per_book[$key]
                            );
                            
                    $this->db->where('id_total_sales', $memo_ID[$key]);
                    $this->db->where('id_item',$book_ID[$key]);
                    $this->db->update('sales', $data_delete);
               }
               
               
              $this->db->query("UPDATE `sales_total_sales` "
                      . "SET `sub_total`=sub_total-$values,"
                      . "`total_amount`=total_amount-$values,`total_due`=total_due-$values"
                      . " WHERE id_total_sales=$memo_ID_update");
              
              $this->customer_due->reduce($contact_ID,$values);
              $this->cash->reduce($values);
              

              return $id;
              
      }
      
      function list_return_item($start,$end){
                 
        $this->load->library('table');
        
        $query=$this->db->query("SELECT selection_ID,memo_ID,items.name,quantity,price_per_book,total "
                . "FROM `sales_current_sales_return` "
                . "LEFT JOIN items ON sales_current_sales_return.book_ID=items.id_item "
                . "WHERE  selection_ID BETWEEN $start and $end ORDER BY selection_ID DESC")->result_array();
        
        $total=$this->db->query("SELECT sum(total) as total FROM sales_current_sales_return "
                . "where selection_ID BETWEEN $start and $end");
        foreach($total->result() as $row){
            $total_price=$row->total;
        }
        
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
            $data['table1']=$this->table->generate($query);
            
            
            $this->table->clear();
            $this->table->set_template($tmpl);
            $cell1 = array('data' => 'Total: ', 'class' => 'text-right');
            $cell2 = array('data' => 'TK '.$total_price, 'class' => 'text-right');
            $this->table->add_row($cell1,$cell2);
            $data['table2']=$this->table->generate();
            
            
           // return $this->table->generate($query);
          return $data;

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
      

      
      function get_book_list($total_sales_id){
          
//        $query = $this->db->query("SELECT * ,pub_books.name as book_name, quantity-IFNULL((SELECT SUM(quantity) FROM sales_current_sales_return where memo_ID=pub_memos.memo_ID and book_ID=pub_books.book_ID),0) as return_quantity
//            FROM `pub_memos_selected_books`
//			LEFT JOIN pub_books on pub_memos_selected_books.book_ID=pub_books.book_ID
//			LEFT JOIN pub_memos on pub_memos.memo_ID=pub_memos_selected_books.memo_ID
//            LEFT JOIN pub_contacts on pub_memos.contact_ID=pub_contacts.contact_ID
//			WHERE pub_memos_selected_books.memo_ID='$id'");
          

        
        $query=$this->db->query("SELECT `quantity`,quantity - IFNULL((SELECT SUM(quantity) 
                                        FROM sales_current_sales_return 
                                        where memo_ID=sales_total_sales.id_total_sales and 
                                        book_ID=items.id_item),0)
                                        as return_quantity,
                    `items`.`name` as item_name,
                    `items`.`regular_price` as regular_price,
                    sales.`price` as sale_price,
                    sales.`sub_total` as sales_sub_total,
                    sales.id_item as id_item,
                    sales_total_sales.id_total_sales,
                    customer.id_customer as id_customer
                    FROM `sales`
                    left join `items`on `items`.`id_item`= `sales`.`id_item`  
			
			LEFT JOIN sales_total_sales on sales_total_sales.id_total_sales=sales.id_total_sales
            LEFT JOIN customer on sales_total_sales.id_customer=customer.id_customer
			
                    WHERE sales_total_sales.`id_total_sales` = $total_sales_id");
        
        return $query->result_array();
        
        
    }
    
   
}

