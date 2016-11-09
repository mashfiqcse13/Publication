<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Sales_edit_model
 * 
 * This will be user for edit an sale entity
 * 
 * Referense document : https://drive.google.com/file/d/0BycC64dJHo0JUXluYXNHZ2trNm8/view?usp=sharing
 *
 * @author MD. Mashfiq
 */
class Sales_edit_model extends CI_Model {

    private $existing_data;     // this will be grabbed from the database
    private $changed_data;      // This will be grabbed from the edit from
    private $existing_memo_data;
    private $existing_memo_items;
    private $changed_memo_data;
    private $changed_memo_items;
    /*
     * This is test data section
     * Here dummy data will be added for testing purpose
     */
    function __construct() {
        $this->load->model('misc/Stock_perpetual');
        $this->load->model('Stock_model');
    }

    function test_data() {

      $data['existing_memo_data'] = $this->existing_memo_data =   array (
                                    "id_total_sales" => 70,
                                    "id_customer" => 329,
                                    "discount_percentage" => 0,
                                    "discount_amount" => 0,
                                    "sub_total" => 2950,
                                    "total_amount" => 2950,
                                    "total_paid" => 2950,
                                    "total_due" => 0,
                                    "issue_date" => '2016-10-04 12:41:00',
                                    "number_of_packet" => 0,
                                    "bill_for_packeting" => 0,
                                    "slip_expense_amount" => 0
                                );
      $data['existing_memo_items'] =  $this->existing_memo_items  = array(
                        array(
                               "id_sales" => 110,
                               "id_total_sales"  => 70,
                              "id_item" => 53,
                               "quantity" => 5,
                               "price" => 180,
                               "total_cost" => 900,
                               "discount" => 0,
                               "sub_total" => 900
                           ),
                        array(
                               "id_sales" => 110,
                               "id_total_sales"  => 70,
                              "id_item" => 52,
                               "quantity" => 5,
                               "price" => 120,
                               "total_cost" => 900,
                               "discount" => 0,
                               "sub_total" => 900
                           ),
                        array(
                               "id_sales" => 110,
                               "id_total_sales"  => 70,
                               "id_item" => 51,
                               "quantity" => 5,
                               "price" => 180,
                               "total_cost" => 900,
                               "discount" => 0,
                               "sub_total" => 900
                           )         
                    );

       
         $data['changed_memo_data'] =  $this->changed_memo_data =  array(
                            "id_total_sales" => 96,
                            "id_customer" => 739,
                            "discount_percentage" => 0,
                            "discount_amount" => 0,
                            "sub_total" => 5950,
                            "total_amount" => 5950,
                            "total_paid" => 4950,
                            "total_due" => 0,
                            "issue_date" => '2016-10-04 12:41:00',
                            "number_of_packet" => 0,
                            "bill_for_packeting" => 0,
                            "slip_expense_amount" => 0
                        );
        
        $data['changed_memo_items'] =  $this->changed_memo_items  =   array(
                array(
                        "id_sales" =>'' ,
                        "id_total_sales"  => 52,
                       "id_item" => 53,
                        "quantity" => 55,
                        "price" => 180,
                        "total_cost" => 900,
                        "discount" => 0,
                        "sub_total" => 900
                    ),
                 array(
                        "id_sales" => '',
                        "id_total_sales"  => 52,
                       "id_item" => 52,
                        "quantity" => 5,
                        "price" => 180,
                        "total_cost" => 900,
                        "discount" => 0,
                        "sub_total" => 900
                    ),
                 array(
                        "id_sales" => '',
                        "id_total_sales"  => 52,
                        "id_item" => 51,
                        "quantity" => 5,
                        "price" => 180,
                        "total_cost" => 900,
                        "discount" => 0,
                        "sub_total" => 900
                    )
            );
        
        return $data;
    }

    /*
     * This function will grabb data from the database+edit from and initialize to the respective variable
     */
//
//    function grab_data($id_sales_total_sales = null) {
////         return $this->test_data();
//        $sales_results = $this->db->select('*')
//                        ->from('sales_total_sales')->get()->result();
//        $sales = $this->db->select('*')
//                ->from('view_customer_paid_unmarged')->get()->result();
//        $items = $this->db->get('items')->result_array();
//        foreach ($sales_results as $result) {
//            $sales = $this->db->select('*')
//                ->from('view_customer_paid_unmarged')->where('id_total_sales',$result->id_total_sales)->get()->row();
//            $this->existing_data = array('id_sales_total_sales' => $result->id_total_sales,
//            'id_customer' => $result->id_customer,
//            'item_selection' => $items,
//            'sub_total' => $result->sub_total,
//            "discount_amount" => $result->discount_amount,
//            "discount_percentage" => $result->discount_percentage,
//            'total_amount' => $result->total_amount,
//            "dues_unpaid" => $result->total_due,
//            'payment_info_cash' => $sales->cash_paid,
//            'payment_info_bank' => $sales->bank_paid,
//            'payment_info_customer_balance_reduction' => $result->id_customer,
//            'total_paid' => $result->total_paid,
//            'total_due' => $result->total_due,
//            "number_of_packet" => $result->number_of_packet,
//            'bill_for_packeting' => $result->bill_for_packeting,
//            'slip_expense_amount' => $result->slip_expense_amount);
//        }
////        $bank = $this->db->select('*')->from;
//        return $this->existing_data;
//    }
    
    function grab_data($id_sales_total_sales = null) {
        $this->existing_data['existing_memo_data'] = $this->existing_memo_data($id_sales_total_sales);
        $this->existing_data['existing_memo_items'] = $this->existing_memo_items($id_sales_total_sales);
        return $this->existing_data;
    }
    

    /*
     * This function will update the test sales table in the database
     */
    function existing_memo_data($id){
        return $this->db->select('*')
                ->from('sales_total_sales')
                ->join('view_customer_paid_marged','sales_total_sales.id_total_sales = view_customer_paid_marged.id_total_sales','left')
                ->where('sales_total_sales.id_total_sales',$id)
                ->get()->row_array();
//        return $this->db->get_where( ' sales_total_sales ' , '`id_total_sales`= '.$id )->row_array();
    }
     function existing_memo_items($id){
         return $this->db->select('*')
                ->from('sales')
                ->join('items','sales.id_item = items.id_item','left')
                ->where('sales.id_total_sales',$id)
                ->get()->result_array();
//        return $this->db->get_where( ' sales ' , '`id_total_sales`= '.$id )->result_array();
    }
    
    function sales_update( $memo_id,$changed_memo_data,$changed_memo_items ) {
        
        
        $array1 = $this->existing_memo_data($memo_id);
//        $array2 = $changed_memo_data;
        
        
        $existing_items= $this->existing_memo_items($memo_id);
        $changed_items=$changed_memo_items;
        
        $update_sales = array();
        $items = array();
        
       
      
//        
//                foreach($array1 as $key1 => $value1){
//                    foreach($array2 as $key2 => $value2){
//                        if($key1 == $key2){                            
//                            if( $value1 != $value2 ){
//                                $update_sales[$key1] = $value2; 
//                            }
//                        }
//                    }
//                }
                
                
                if(!empty($changed_memo_data)){
                     $this->sales_total_sales_update($changed_memo_data,$memo_id);                     
                }
                
                
                if(!empty($existing_items)){ 
                     $this->delete_sale_row($existing_items);
                }
                if(!empty($changed_items)){                    
                     $this->insert_sale_row($changed_items);
                }
                return true;
    }
    
    
      /*
     * This function will update sales_total_sales table row
     */


   function insert_sale_row($array){
      $this->db->insert_batch('sales', $array);      
      foreach($array as  $value){
          $this->Stock_perpetual->Stock_perpetual_register($value['id_item'], $value['quantity']);
          $this->Stock_model->stock_reduce($value['id_item'], $value['quantity']);
      }
   }
   
   
   function delete_sale_row($existing_items){ 
           foreach($existing_items as $value){  
                $this->db->where('id_sales',$value['id_sales'])->delete('sales');
                $this->Stock_perpetual->Stock_perpetual_register_reverse($value['id_item'], $value['quantity']);
                $this->Stock_model->stock_reduce_revert($value['id_item'], $value['quantity']);                                    
            }            
   }
    
    function sales_total_sales_update($array,$memo_id){
          
             $sql = "UPDATE `sales_total_sales` SET 
                `id_customer`= '".$array["id_customer"]."',
                `discount_percentage`= '".$array['discount_percentage']."' ,
                `discount_amount`='".$array['discount_amount']."',
                `sub_total`= '".$array['sub_total']."',
                `total_amount`= '".$array['total_amount']."',
                `total_paid`= '".$array['total_paid']."',
                `total_due`='".$array['total_due']."',
                `number_of_packet`='".$array['number_of_packet']."' ,
                `bill_for_packeting`='".$array['bill_for_packeting']."' ,
                `slip_expense_amount`='".$array['slip_expense_amount']."'  WHERE id_total_sales=$memo_id ";        
         
//        $sales_memo = array();
//         $sales_memo = "UPDATE $table_name SET  ";
//            foreach($array as $key => $value){
//                $sales_memo.=" $key = '$value',";
//            }
//            $sales_memo = rtrim($sales_memo,',');
//            $sales_memo.=" WHERE id_total_sales = ".$memo_id;
        
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
        
    }
    


    /*
     * If user increase or decrease the slip expense or bill payment option then it will be used to add row in expense table
     */

    function expense_update() {
        $id = $this->input->post('id_total_sales');
        $slip['amount_expense'] = $this->input->post('slip_expense_amount');
        $slip['date_expense'] = Date('Y-m-d H:i:s');
        $slip['id_name_expense'] = '4';
        $bill['amount_expense'] = $this->input->post('bill_for_packeting');
        $bill['date_expense'] = Date('Y-m-d H:i:s');
        $bill['id_name_expense'] = '3';
        $result = $this->db->get_where('sales_total_sales',array('id_total_sales' => $id))->row();
        if($slip['amount_expense'] < $result->slip_expense_amount || $slip['amount_expense'] > $result->slip_expense_amount ){
            $this->db->insert('expense',$slip);
            return true;
        }
        if($bill['amount_expense'] < $result->bill_for_packeting || $bill['amount_expense'] > $result->bill_for_packeting){
            $this->db->insert('expense',$bill);
            return true;
        }
        return false;
    }

    /*
     * 1. insert a row to payment log and the amount will be negetive
     * 2. new status colum need to be added to identify to row as edited adjust ment .
     * 3. Reduce from the cash balance
     */

    function reduce_cash($id_total_sales, $id_customer, $reduced_paid_amount) {
        $this->load->model("misc/Cash");
        if ($this->Cash->reduce($reduced_paid_amount) == FALSE) {
            return FALSE;
        }
        $this->load->model("misc/Customer_payment");
        $this->Customer_payment->payment_register($id_customer, -$reduced_paid_amount, $id_total_sales, 1,1);
        return true;
    }

    /*
     * 1. insert a row to payment log and the amount will be negetive
     * 2. new status colum need to be added to identify to row as edited adjust ment .
     * 3. Reduce from the cash balance
     */

    function increase_cash($id_total_sales, $id_customer, $increased_paid_amount) {
        $this->load->model("misc/Cash");
        if ($this->Cash->add($increased_paid_amount) == FALSE) {
            return FALSE;
        }
        $this->load->model("misc/Customer_payment");
        $this->Customer_payment->payment_register($id_customer, $increased_paid_amount, $id_total_sales, 1,1);
        return true;
    }

    /*
     * 1. use $this->Customer_due->add($id_customer, $amount) 
     */

    function increase_due() {
        
    }

    /*
     * 1. use proper model to execute this function
     */

    function increase_advance_balence($id_customer, $amount, $method = "as bank") {
        
    }

    function situation_selector() {
        
    }

    function situation_1_case_1() {
        
    }

    function situation_2_case_1() {
        
    }

    function situation_3_case_1() {
        
    }

    function situation_4_case_1() {
        
    }

    function situation_5_case_1() {
        
    }

    function situation_6_case_1() {
        
    }

    function situation_7_case_1() {
        
    }

    function situation_1_case_2() {
        
    }

    function situation_2_case_2() {
        
    }

    function situation_3_case_2() {
        
    }

    function situation_4_case_2() {
        
    }

    function situation_5_case_2() {
        
    }

    function situation_6_case_2() {
        
    }

    function situation_7_case_2() {
        
    }

}
