<?php


class Stationary_model extends CI_Model {

   function stationary_report($date='',$item=''){
       
    $date=$date;
    $item=$item;
    
    if(empty($date) || $date==''){
           $condition="stationary_stock_register.id_name_expense=$item";
    }
    if(empty($item) || $item==''){
        $date=$this->dateformatter($date);
        $condition="date_received BETWEEN $date";
    }
    if(!empty($date) && !empty($item)){
        $date=$this->dateformatter($date);
        $condition="date_received BETWEEN $date and stationary_stock_register.id_name_expense=$item";
    }
        
            
        //$condition="date_received BETWEEN $date";
            
        $range_query=$this->db->query("SELECT name_expense,DATE(date_received),memo_number,quantity FROM `stationary_stock_register` 
LEFT JOIN expense_name ON expense_name.id_name_expense=stationary_stock_register.id_name_expense 
WHERE $condition");
        
        $this->load->library('table');
        $this->table->set_heading(array('Stock Item Name', 'Date', 'Memo Number','Quantity'));
        $tmpl = array (
                    'table_open'          => '<table class="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr style="background:#ddd">',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th class="text-center">',
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
        $this->table->set_caption('<h2 class="text-center">'.$this->config->item('SITE')['name'].'</h2><br>'
                . '<h4><span class="pull-left">Date Range:'.$this->datereport($date).'</span>'
                . '<span class="pull-right">Report Date: '.date('Y-m-d h:i').'</span></h4>');
        return $this->table->generate($range_query);
        
        
    }
    
    
 function stationary_stock_report($item=''){
       
  
    $item=$item;

    if(empty($item) || $item==''){
        
        $condition=" 1";
    }
    if(!empty($item)){
        
        $condition="stationary_stock.id_name_expense=$item";
    }
        
            
        //$condition="date_received BETWEEN $date";
            
        $range_query=$this->db->query("SELECT name_expense,total_in,total_out,"
                . "total_balance FROM `stationary_stock` "
                . "LEFT JOIN expense_name on "
                . "expense_name.id_name_expense=stationary_stock.id_name_expense  WHERE $condition");
        
        $this->load->library('table');
        $this->table->set_heading(array('Stock Item Name', 'Total In', 'Total Out','Total Balance'));
        $tmpl = array (
                    'table_open'          => '<table class="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr style="background:#ddd">',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th class="text-center">',
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
        $this->table->set_caption('<h2 class="text-center">'.$this->config->item('SITE')['name'].'</h2><br>'
                . '<h4><span class="pull-left"></span>'
                . '<span class="pull-right">Report Date: '.date('Y-m-d h:i').'</span></h4>');
        return $this->table->generate($range_query);
        
        
    }
    

    function expense_name_dropdown() {
        
        $this->db->select('*');
        $this->db->from('expense_name');
        $this->db->order_by('name_expense', "asc");
        $query = $this->db->get();
        $db_rows = $query->result_array();
        
        $options[''] = "Select Expense Name";
        foreach ($db_rows as $index => $row) {
            $options[$row['id_name_expense']] = $row['name_expense'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('expense_name_id', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1"  aria-hidden="true"');
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

       function datereport($date){
        $date= str_replace("'", ' ', $date);
        $date=  str_replace('and', 'to', $date);
        return $date;
    }

}
