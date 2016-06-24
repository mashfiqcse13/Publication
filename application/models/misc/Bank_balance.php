<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Cash
 *
 * @author MD. Mashfiq
 */
class Bank_balance extends CI_Model {
    /*
     * This will add cash amount to the database table 'Customer_due'
     */

    
    function add($id_account, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('bank_balance')
                        ->where('id_account', $id_account)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `bank_balance` 
                    (`id_bank_balance`, `id_account`, `total_in`, `total_out`, `balance`)
                    VALUES (NULL, '$id_account', '0', '0', '0');");

        $sql = "UPDATE `bank_balance` SET 
                `total_in` = `total_in`+'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `bank_balance`.`id_account` = $id_account;";
        $this->db->query($sql);
        return TRUE;
    }
    
    function add_reverse($id_account, $amount) {
                
        $current = $this->db->select('*')
                ->from('bank_balance')
                ->where('id_account', $id_account)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `bank_balance` SET 
                `total_in` = `total_in`-'$amount', 
                `balance` = `balance`-'$amount' 
            WHERE `bank_balance`.`id_account` = $id_account;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    
        function reduce_reverse($id_account, $amount) {
                
        $current = $this->db->select('*')
                ->from('bank_balance')
                ->where('id_account', $id_account)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `bank_balance` SET 
                `total_out` = `total_out`-'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `bank_balance`.`id_account` = $id_account;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    

    function reduce($id_account, $amount) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('bank_balance')
                        ->where('id_account', $id_account)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `bank_balance` 
                    (`id_bank_balance`, `id_account`, `total_in`, `total_out`, `balance`)
                    VALUES (NULL, '$id_account', '0', '0', '0');");
        
        $current = $this->db->select('*')
                ->from('bank_balance')
                ->where('id_account', $id_account)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `bank_balance` SET 
                `total_out` = `total_out`+'$amount', 
                `balance` = `balance`-'$amount' 
            WHERE `bank_balance`.`id_account` = $id_account;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function record_count() {
        return $this->db->count_all("bank_management_status");
    }
    
    function list_bank_status($limit,$start){
        $query=$this->db->query("select "
                . "transaction_date,name_bank, account_number,CONCAT('TK ',amount_transaction) as amount_transaction,"
                . "name_trnsaction_type, username,action_date,approval_status,id_bank_management_status,"
                . "(select username from users where id=bank_management_status.approved_by) as approved_by"
                . " from "
                . "`bank_management_status`,`bank_management`, `bank_transaction_type`,`bank_account`, `users`,`bank`"
                . " where "
                . "bank_management_status.id_bank_management=bank_management.id_bank_management "
                . "and bank_management.id_account=bank_account.id_bank_account "
                . "and bank_management.id_transaction_type=bank_transaction_type.id_trnsaction_type "
                . "and bank_account.id_bank=bank.id_bank "
                . "and bank_management.id_user=users.id"
                
                . " ORDER BY bank_management_status.id_bank_management DESC LIMIT $start,$limit");
                
        
        return $query;
    }
    
    function bank_report($date= '',$user_id = '',$bank_account = '',$transaction_type = ''){
    
        $date=$date;
        if($date==''){
            $date='';
        }else{
            $date=$this->dateformatter($date);
        }
        $user_id=$user_id;
        $bank_account=$bank_account;
        $transaction_type=$transaction_type;
        
        
        
        if(!empty($bank_account)){
            
            $condition="bank_management.id_account=$bank_account";
        }
        if(!empty($user_id)){
            
            $condition="bank_management.id_user=$user_id";
        }
        if(!empty($date)){
            
            $condition="transaction_date BETWEEN $date";
        }
       if(!empty($transaction_type)){
            
            $condition="bank_management.id_transaction_type=$transaction_type";
        }
        if(!empty($date) && !empty($user_id) ){
            
            $condition="transaction_date BETWEEN $date and "
                    . "bank_management.id_user=$user_id";
        }        
        
         if(!empty($date) && !empty($transaction_type)){
            
            $condition="transaction_date BETWEEN $date and "
                    . "bank_management.id_transaction_type=$transaction_type";
        }
        
        if(!empty($date) && !empty($bank_account)){
           
            $condition="transaction_date BETWEEN $date and "
                    . "bank_management.id_account=$bank_account";
        }
        

        if(!empty($user_id) && !empty($bank_account)){
            
            $condition="bank_management.id_user=$user_id and "
                    . "bank_management.id_account=$bank_account";
        }
        if(!empty($user_id) && !empty($transaction_type)){
            
            $condition="bank_management.id_user=$user_id and "
                    . "bank_management.id_transaction_type=$transaction_type";
        }

        if(!empty($bank_account) && !empty($transaction_type)){
            
            $condition="bank_management.id_transaction_type=$transaction_type and "
                    . "bank_management.id_account=$bank_account";
        }
        if(!empty($date) && !empty($user_id) && !empty($bank_account)){
            //$date=$this->dateformatter($date);
            $condition="transaction_date BETWEEN $date and "
                    . "bank_management.id_user=$user_id and "
                    . "bank_management.id_account=$bank_account";
        }


        
        
        if(!empty($date) && !empty($bank_account) && !empty($transaction_type)){
            //$date=$this->dateformatter($date);
            $condition="transaction_date BETWEEN $date and "
                    . "bank_management.id_transaction_type=$transaction_type and "
                    . "bank_management.id_account=$bank_account";
        }
        
        
        if(!empty($date) && !empty($user_id) && !empty($transaction_type)){
            //$date=$this->dateformatter($date);
            $condition="transaction_date BETWEEN $date and "
                    . "bank_management.id_user=$user_id and "
                    . "bank_management.id_transaction_type=$transaction_type";
        }
                
        
        if(!empty($date) && !empty($user_id) && !empty($bank_account) && !empty($transaction_type)){
            
            $condition="transaction_date BETWEEN $date and "
                    . "bank_management.id_user=$user_id and "
                    . "bank_management.id_transaction_type=$transaction_type and "
                    . "bank_management.id_account=$bank_account";
        }
        
       if(empty($date) && empty($user_id) && empty($bank_account) && empty($transaction_type)){
            
            $condition=" 1";
        }

        
        //$date=$this->dateformatter($date);
        
        $range_query=$this->db->query("SELECT name_bank,account_number,name_trnsaction_type,transaction_date,
            CONCAT('TK ',amount_transaction),username,check_number FROM `bank_management`
LEFT JOIN bank_account on bank_account.id_bank_account=bank_management.id_account
LEFT join bank on bank.id_bank=bank_account.id_bank
left JOIN bank_transaction_type on bank_transaction_type.id_trnsaction_type=bank_management.id_transaction_type
left JOIN users on users.id=bank_management.id_user 
WHERE $condition");
        
        $this->load->library('table');
        $this->table->set_heading(array('Bank Name', 'Account Number', 'Transaction Type','Transaction Date','Amount','User','Check Number'));
        $tmpl = array (
                    'table_open'          => '<table class="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" >',

                    'heading_row_start'   => '<tr style="background:#ddd">',
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
        
        if(!empty($date) && $date!==''){
            $date_range=$this->datereport($date);
            
        }else{ 
            $date_range='';
            
        }
        
        $this->table->set_template($tmpl);
                $this->table->set_caption('<h4><span class="pull-left">Date Range:'.$date_range.'</span>'
                . '<span class="pull-right">Report Date: '.date('Y-m-d h:i').'</span></h4>'
                . '<style>td:nth-child(5) {    text-align: right;}</style>');
        return $this->table->generate($range_query);
        
        
    }
    
    
    function bank_status_report($date= '',$user_id = '',$status_type = ''){
    
        $date=$date;
        if($date==''){
            $date='';
        }else{
            $date=$this->dateformatter($date);
        }
        $user_id=$user_id;
        
        $status_type=$status_type;
        
        
        
        if(!empty($user_id)){
            
            $condition="bank_management.id_user=$user_id";
        }elseif(!empty($date)){
            
            $condition="action_date BETWEEN $date";
            
        }elseif(!empty($status_type)){
            
            $condition="bank_management_status.approval_status=$status_type";
            
        }elseif(!empty($user_id) && !empty ($date)){
            $condition="action_date BETWEEN $date and bank_management.id_user=$user_id";
            
        }elseif(!empty($user_id) && !empty($status_type)){
            
            $condition="bank_management.id_user=$user_id and bank_management.id_user=$user_id";
            
        }elseif(!empty ($date) && !empty($status_type)){
            
            $condition="action_date BETWEEN $date and bank_management_status.approval_status=$status_type";
        }elseif(!empty ($date) && !empty($status_type) && !empty($user_id)){
            
            $condition="action_date BETWEEN $date and bank_management_status.approval_status=$status_type and bank_management.id_user=$user_id";
        }else if(empty($date) && empty($user_id) && empty($status_type)){
            
            $condition=" 1=1";
        }

  
        
        $range_query=$this->db->query("select "
                . "transaction_date,name_bank, account_number,CONCAT('TK ',amount_transaction) as amount_transaction,
                    name_trnsaction_type, username,(select username from users where id=bank_management_status.approved_by) as approved_by,action_date,
                    CASE
                        when approval_status='1' then 'approved'
                        when approval_status ='2' then 'canceled'
                        else 'pending' end as approval_status"
                . " from "
                . "`bank_management_status`,`bank_management`, `bank_transaction_type`,`bank_account`, `users`,`bank`"
                . " where "
                . "bank_management_status.id_bank_management=bank_management.id_bank_management "
                . "and bank_management.id_account=bank_account.id_bank_account "
                . "and bank_management.id_transaction_type=bank_transaction_type.id_trnsaction_type "
                . "and bank_account.id_bank=bank.id_bank "
                . "and bank_management.id_user=users.id "
                . "and $condition ");
        
        $this->load->library('table');
        $this->table->set_heading(array('Generate Date', 'Bank Name', 'Account No','Amount','Transaction Type','User Entered','Approved By','Action Date','Approval Status'));
        $tmpl = array (
                    'table_open'          => '<table class="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr style="background:#ddd">',
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
        
        if(!empty($date) && $date!==''){
            $date_range=$this->datereport($date);
            
        }else{ 
            $date_range='';
            
        }
        
        $this->table->set_template($tmpl);
                $this->table->set_caption('<h4><span class="pull-left">Date Range:'.$date_range.'</span>'
                . '<span class="pull-right">Report Date: '.date('Y-m-d h:i').'</span></h4>'
                . '<style>td:nth-child(4) {    text-align: right;}</style>');
        return $this->table->generate($range_query);
        
        
    }
    
    
    function transaction_type_dropdown() {
        
        $this->db->select('*');
        $this->db->from('bank_transaction_type');
        $this->db->order_by('name_trnsaction_type', "asc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        
        $options[''] = "All Selected ";
        foreach ($db_rows as $index => $row) {
            $options[$row['id_trnsaction_type']] = $row['name_trnsaction_type'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('id_transaction_type', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1"  aria-hidden="true"');
    }
    
    
    function account_dropdown() {
        
        $this->db->select('*');
        $this->db->from('bank_account');
        $this->db->order_by('account_number', "asc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        
        $options[''] = "All Selected ";
        foreach ($db_rows as $index => $row) {
            $options[$row['id_bank_account']] = $row['account_number'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('id_bank_account', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1"  aria-hidden="true"');
    }
    
    
    function user_dropdown() {
        
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('username', "asc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        
        $options[''] = "All Selected ";
        foreach ($db_rows as $index => $row) {
            $options[$row['id']] = $row['username'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('id', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1"  aria-hidden="true"');
    }
    
    function datereport($date){
        $date= str_replace("'", ' ', $date);
        $date=  str_replace('and', 'to', $date);
        return $date;
    }
    
    
    function dateformatter($range_string, $formate = 'Mysql') {
        $date = explode(' - ', $range_string);
        $date[0] = explode('/', $date[0]);
        $date[1] = explode('/', $date[1]);

        if ($formate == 'Mysql') {
            return "'{$date[0][2]}-{$date[0][0]}-{$date[0][1]}' and '{$date[1][2]}-{$date[1][0]}-{$date[1][1]}'";
        } else if ($formate == "2_string") {
            $date = explode(' - ', $range_string);
            $from_date = date('Y-m-d', strtotime($date[0]));
            $to_date = date('Y-m-d', strtotime($date[1]));
            return compact(array('from_date', 'to_date'));
        } else {
            return $date;
        }
    }
    
   

}
