<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of Salary_model
 *
 * @author Rokibul Hasan 
 */

class Sales_return_m extends CI_Model {
    
    
    function __construct() {
              $this->load->model('misc/cash');
              $this->load->model('misc/customer_due');  
              $this->load->model('misc/Stock_perpetual'); 
              $this->load->model('Stock_model');
              $this->load->model('advance_payment_model');
              //$this->load->libraty('session');
    }

    
    function get_memos($id){
        //$this->load->library('table');
        
        $this->db->select('*');
        $this->db->from('sales_total_sales');
        $this->db->where('id_total_sales',$id);
        
        $query = $this->db->get();
        
       
        
        
        //$data_table = $this->table->generate($query);
        
        return $query->result_array();
        
        
        
    }
    

    
    function memo_dropdown() {
        $this->db->select('*')
                ->from('sales_total_sales')
                ->order_by('id_total_sales','desc');
        $sql=$this->db->get()->result();
        $data = array();
        $data = '<select id="field-id_account" name="memo_id" class="select2 chosen-select chzn-done" data-placeholder="Select Memo Number" required>';
        $data.='<option value="">Select Memo Number</option>';
        foreach ($sql as $row) {
            $data.='<option value="' . $row->id_total_sales . '">' . $row->id_total_sales . '</option>';
        }
        $data.='</select>';
        return $data;
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
      function current_memo_due($memo_id){
          $query=$this->db->query("SELECT total_due FROM `sales_total_sales` WHERE id_total_sales=$memo_id");
          $due=0;
          foreach($query->result() as $row){
              $due=$row->total_due;
          }
          return $due;
      }

      function insert_return_item($post){   
              
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
                               $date_now=date('Y-m-d H:i:s');

                            $data_add=array(
                                'memo_ID' => $memo_ID[$key],
                                'book_ID' => $book_ID[$key],
//                                'stock_ID' => $stock_ID[$key],
                                'quantity' => $quantity[$key],
                                'price_per_book' => $price_per_book[$key],
                                'total' => $quantity[$key]*$price_per_book[$key],
                                'date_current_sales_return' => $date_now,
                                
                            );
                            
                            
                            $this->db->insert('sales_current_sales_return',$data_add);  
                            $id[] = $this->db->insert_id();
                            $values+=$data_add['total'];
                            
                            
                           }
                           
                           
                           //update sales table
                           $this->db->query("UPDATE `sales` "
                                            . "SET `quantity`=quantity-$quantity[$key],"
                                            . "`total_cost`=total_cost-$quantity[$key]*$price_per_book[$key],"
                                            . "`sub_total`=sub_total-$quantity[$key]*$price_per_book[$key]"
                                            . " WHERE id_total_sales=$memo_ID[$key] AND "
                                            . " id_item=$book_ID[$key]");
                                                      

                }
                
                foreach($memo_ID as $key => $val){
                    $memo_id=$memo_ID[$key];
                }
                
                  
                
                $memo_due=$this->current_memo_due($memo_id);

                   if($memo_due >= $values){


                             //update sales total sales table
                         $this->db->query("UPDATE `sales_total_sales` "
                               . "SET `sub_total`=sub_total-$values, "
                               . "`total_amount`=total_amount-$values, "
                               . " total_due = total_due-$values"
                               . " WHERE id_total_sales=$memo_id");

                         $this->customer_due->reduce($contact_ID,$values);                         
                         $this->update_payment($memo_id,$values);
                         $this->session->set_userdata('only_due_clear',$values);

                }else{
                    
                    
                    $update_value=$values-$memo_due;
                    
                    $this->session->set_userdata('due',$memo_due);
                    
                    //update sales total sales table
                    
                     $this->db->query("UPDATE `sales_total_sales` "
                      . "SET `sub_total`=sub_total-$values, "
                      . "`total_amount`=total_amount-$values, "
                      . " total_paid = total_paid-$update_value, "
                      . " total_due = total_due-$memo_due"
                      . " WHERE id_total_sales=$memo_id");
                        
                        $this->session->set_userdata('only_due_clear',$memo_due);
                        $this->session->set_userdata('add_to_advanced',$update_value);
                        
                        
                         $this->customer_due->reduce($contact_ID,$memo_due);
                         if($update_value > 0){    
                             $this->advance_payment_model->payment_add($contact_ID, $update_value, 2);
                             $this->update_payment($memo_id,$values,$contact_ID);
                            //$this->cash->reduce($update_value);
                         }
                     
                } 
              
              
            
                
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

                        $data_delete=array(
                                    'quantity' =>$pre_quantity[$key]-$quantity[$key],                                
                                    'total_cost' =>($pre_quantity[$key]-$quantity[$key])*$price_per_book[$key]
                                );

                        $this->db->where('id_total_sales', $memo_ID[$key]);
                        $this->db->where('id_item',$book_ID[$key]);
                        $this->db->update('sales', $data_delete);
                   
                }  

              return $id;
              
      }
      
      function  update_payment($memo_id,$values,$contact_ID=''){
          $value=$values;
          
          $list = $this->db->get_where("customer_payment" , "id_total_sales = $memo_id")->result();
          
          foreach($list as $row){
              
              if($row->id_payment_method==2){
                  $value = $this->update_payment_log($memo_id,2,$value,$row->paid_amount,$contact_ID);                  
              }
              if($row->id_payment_method==1){
                  $value = $this->update_payment_log($memo_id,1,$value,$row->paid_amount,$contact_ID);
              }
               if($row->id_payment_method==3){
                  $value = $this->update_payment_log($memo_id,3,$value,$row->paid_amount,$contact_ID);
              }
              
          }
           
              
        return true;
      }
      
      function update_payment_log($memo_id,$payment_method_id,$value,$paid_amount,$contact_ID){
          
//          if($this->session->userdata('due')){
//              $due = $this->session->userdata('due');
//          }else{
//              $due = 0;
//          }
//          
           
          
          if($paid_amount >= $value){
              $value_update = $value;              
              $value = 0;
          }else{
              $value_update = $paid_amount;
              $value = $value - $paid_amount;
          }
          
//          if($value_update == $due){
//              $advanced_value = 0;
//              $this->session->set_userdata('due',0);
//              
//          }elseif($value_update < $due ){
//             $advanced_value = 0;
//             $due  = $due - $value_update;
//             $this->session->set_userdata('due',$due);
//             
//          }elseif($value_update > $due){
//              $advanced_value = $value_update  - $due;
//               $this->session->set_userdata('due',0);
//          }
//          
          if($value_update > 0 ){
                
                $this->db->query("UPDATE `customer_payment` "
                            . "SET `paid_amount`=paid_amount-$value_update "
                            . " WHERE id_total_sales=$memo_id and id_payment_method = $payment_method_id");         
                return $value;
          }else{
              return 0;
          }
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
            $cell2 = array('data' => 'TK '.$total_price, 'class' => 'text-right taka_formate');
            
                  
                    
            if($this->session->userdata('only_due_clear')){
                $due_paid=$this->session->userdata('only_due_clear');
                $this->session->unset_userdata('only_due_clear');
            }else{
                $due_paid=0;
            } 
            
            if($this->session->userdata('add_to_advanced')){
                $add_to_advanced=$this->session->userdata('add_to_advanced');
                $this->session->unset_userdata('add_to_advanced');
            }else{
                $add_to_advanced=0;
            }
            
            
            
            $cell_due=array('data' => 'Due Reduced = TK '.$due_paid,'class' => 'text-right taka_fomrate','colspan'=> 2 );
            $cell_adv=array('data' => 'Add To Advanced = TK '.$add_to_advanced,'class' => 'text-right taka_fomrate','colspan'=> 2 );
                    
            $this->table->add_row($cell1,$cell2);
            $this->table->add_row($cell_due);
            $this->table->add_row($cell_adv);
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

