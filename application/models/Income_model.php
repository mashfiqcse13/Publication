<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Income_model extends CI_Model {

    function income_report($date) {
        if($date==''){
            $con='';
        }else{
             $date = $this->dateformatter($date);
             $con="WHERE DATE(date_income) BETWEEN $date";
        }
       
  
        $range_query = $this->db->query("SELECT name_expense,amount_income,date_income,description_income FROM `income` 
LEFT JOIN income_name on income_name.id_name_income=income.id_name_income $con ");
        return $range_query->result();
        
    }

    function add_income($id, $amount) {
        $data = array(
            'id_name_income' => $id,
            'amount_income' => $amount,
            'date_income' => date('Y-m-d h:i:u')
        );
        $this->db->insert('income', $data) or die('failed to insert data on income');

        return true;
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

    function datereport($date) {
        $date = str_replace("'", ' ', $date);
        $date = str_replace('and', 'to', $date);
        return $date;
    }
    
    function sale_report($date){
        //SELECT id_payment_method,sum(paid_amount) as due_payment FROM `customer_payment` WHERE `due_payment_status`=1 GROUP BY id_payment_method
         if($date==''){
            $con='1=1';
        }else{
             $date = $this->dateformatter($date);
             $con=" DATE(payment_date) BETWEEN $date";
        }
        
        $query = $this->db->select('id_payment_method,sum(paid_amount) as payment')
                ->from('customer_payment')
                ->where('due_payment_status IS NULL')
                ->where(" $con ")
                ->group_by('id_payment_method')
                ->get()->result();
        
        foreach($query as $row){
                    $sale[$row->id_payment_method]=$row->payment;
                }
                
                if(!empty($sale[1])){
                        $data['cash'] = $sale[1];
                    }else{
                        $data['cash'] = 0;
                    }
                    if(!empty($sale['2'])){
                        $data['advanced']=$sale['2'];
                    }else{
                        $data['advanced']=0;
                    }
                     if(!empty($sale[3])){
                        $data['bank'] = $sale[3];
                    }else{
                        $data['bank'] = 0;
                    }
                    
                    $data['total'] = $data['cash'] + $data['bank']+$data['advanced'];
                    
        return $data;
    }
    
     function customer_due_report($date){
        //SELECT id_payment_method,sum(paid_amount) as due_payment FROM `customer_payment` WHERE `due_payment_status`=1 GROUP BY id_payment_method
         if($date==''){
            $con='1=1';
        }else{
             $date = $this->dateformatter($date);
             $con=" DATE(payment_date) BETWEEN $date";
        }
        
        $query = $this->db->select('id_payment_method,sum(paid_amount) as due_payment')
                ->from('customer_payment')
                ->where('due_payment_status','1')
                ->where(" $con ")
                ->group_by('id_payment_method')
                ->get()->result();
        
        foreach($query as $row){
                    $due[$row->id_payment_method]=$row->due_payment;
                }
                
                if(!empty($due[1])){
                        $data['due_cash'] = $due[1];
                    }else{
                        $data['due_cash'] = 0;
                    }
                     if(!empty($due[3])){
                        $data['due_bank'] = $due[3];
                    }else{
                        $data['due_bank'] = 0;
                    }
                    
                    $data['due_total'] = $data['due_cash'] + $data['due_bank'];
                    
        return $data;
    }
    
     function old_report($date){ 
        //SELECT id_payment_method,sum(paid_amount) as due_payment FROM `customer_payment` WHERE `due_payment_status`=1 GROUP BY id_payment_method
         if($date==''){
            $con='1=1';
        }else{
             $date = $this->dateformatter($date);
             $con=" DATE(date_transfer) BETWEEN $date";
        }
        
        $query = $this->db->select('type_transfer,sum(price) as payment')
                ->from('old_book_transfer_total')
                ->where('type_transfer','1')
                ->where(" $con ")
                ->get()->result();
        
        foreach($query as $row){
                    $old[$row->type_transfer]=$row->payment;
                }
                
                if(!empty($old[1])){
                        $data['cash'] = $old[1];
                    }else{
                        $data['cash'] = 0;
                    }
                     
                        $data['bank'] = 0;
                   
                    
                    $data['total'] = $data['cash'] + $data['bank'];
                    
        return $data;
    }
    

}
