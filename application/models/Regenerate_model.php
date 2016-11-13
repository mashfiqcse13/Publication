<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Regenerate
 *
 * @author MD. Mashfiq
 */
class Regenerate_model extends CI_Model {

    function master_reconcilation_as_table() {
        $this->load->model('Report_model');
        $output = '<table border="1"><tr><th>id_master_reconcillation</th><th>date</th><th>total_sales</th><th>opening_cash<br>(From DB / Calculated)</th><th>ending_cash<br>(From DB / Calculated)'
                . '</th><th>opening_due</th><th>ending_due</th><th>opening_bank_balance<br>(From DB / Calculated)</th></th><th>closing_bank_balance<br>(From DB / Calculated)</th></th></tr>';
        $master_reconcillation_rows = $this->db->get('master_reconcillation')->result();
        $calculated_opening = array('cash' => 0, 'bank' => 0, 'due' => 0);
        $today_calculated_closing = array('cash' => 0, 'bank' => 0, 'due' => 0);
        foreach ($master_reconcillation_rows as $row) {
            $from = $to = $row->date;
//            Calculating Cash
            $previous_due_collection_by_cash = $this->Report_model->previous_due_collection_by_cash($from, $to);
            $total_cash_collection = $this->Report_model->total_sale_against_cash_collection($from, $to) + $this->Report_model->total_due_collection($from, $to, 'Cash') - $previous_due_collection_by_cash;
            $total_advance_collection_cash = $this->Report_model->total_advance_collection_without_book_sale($from, $to, 'Cash');
            $total_others_income = $this->Report_model->total_others_income($from, $to);

            $total_cash_2_bank_trasfer = $this->Report_model->total_cash_2_bank_trasfer($from, $to);
            $total_cash_2_owner = $this->Report_model->total_cash_2_owner($from, $to);
            $total_cash_2_expense_adjustment = $this->Report_model->total_cash_2_expense_adjustment($from, $to);
            $total_cash_calculation = $calculated_opening['cash'] + $total_cash_collection + $previous_due_collection_by_cash + $total_advance_collection_cash + $total_others_income;

            $today_calculated_closing['cash'] = ( $total_cash_calculation - ($total_cash_2_bank_trasfer + $total_cash_2_owner + $total_cash_2_expense_adjustment));

//            Calculating bank
            $today_calculated_closing['bank'] = 0;
            $previous_due_collection_by_bank = $this->Report_model->previous_due_collection_by_bank($from, $to);
            $SaleCollectionBank = $this->Report_model->total_sale_against_bank_collection($from, $to) + $this->Report_model->total_due_collection($from, $to, 'Bank') - $previous_due_collection_by_bank;
            $total_advance_collection_bank = $this->Report_model->total_advance_collection_without_book_sale($from, $to, 'Bank');
            $total_bank_calculation = $calculated_opening['bank'] + $SaleCollectionBank + $previous_due_collection_by_bank + $total_advance_collection_bank + $total_cash_2_bank_trasfer;

            $today_calculated_closing['bank'] = ( $total_bank_calculation - $this->Report_model->total_bank_withdraw($from, $to) );

            $output .= "\n<tr>\n\t<td>{$row->id_master_reconcillation}</td><td>{$row->date}</td><td>{$row->total_sales}</td>";
            
//            $output .= "<td>{$row->opening_cash}</td><td>{$row->ending_cash}</td>";
            $opening_cash_color = ($row->opening_cash != $calculated_opening['cash']) ? ' style="color:red"' : "";
            $closing_cash_color = ($row->ending_cash != $today_calculated_closing['cash']) ? ' style="color:red"' : "";
            $output .= "<td$opening_cash_color>{$row->opening_cash} / {$calculated_opening['cash']}</td><td$closing_cash_color>{$row->ending_cash} / {$today_calculated_closing['cash']}</td>";
            $output .= "<td>{$row->opening_due}</td><td>{$row->ending_due}</td>";
            
//            $output .= "<td>{$row->opening_bank_balance}</td><td>{$row->closing_bank_balance}</td>\n</tr>\n";
            $opening_bank_color = ($row->opening_bank_balance != $calculated_opening['bank']) ? ' style="color:red"' : "";
            $closing_bank_color = ($row->closing_bank_balance != $today_calculated_closing['bank']) ? ' style="color:red"' : "";
            $output .= "<td$opening_bank_color>{$row->opening_bank_balance} / {$calculated_opening['bank']}</td><td$closing_bank_color>{$row->closing_bank_balance} / {$today_calculated_closing['bank']}</td>\n</tr>\n";
            
            $calculated_opening['cash'] = $today_calculated_closing['cash'];
            $calculated_opening['bank'] = $today_calculated_closing['bank'];
        }
        return $output . '</table>';
    }

}
