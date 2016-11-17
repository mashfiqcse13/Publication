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
                . '</th><th>opening_due<br>(From DB / Calculated)</th><th>ending_due<br>(From DB / Calculated)</th>'
                . '<th>opening_bank_balance<br>(From DB / Calculated)</th></th><th>closing_bank_balance<br>(From DB / Calculated)</th>'
                . '<th>Opening Advance Balance</th><th>Closing Advance Balance</th></tr>';
        $master_reconcillation_rows = $this->db->get('master_reconcillation')->result();
        $calculated_opening = array(
            'cash' => $master_reconcillation_rows[0]->opening_cash,
            'bank' => $master_reconcillation_rows[0]->opening_bank_balance,
            'due' => $master_reconcillation_rows[0]->opening_due,
            'advance_balance' => 0
        );
        $today_calculated_closing = array('cash' => 0, 'bank' => 0, 'due' => 0, 'advance_balance' => 0);
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


//            Calculating due
            $sale_info = $this->Report_model->sale_info($from, $to);
            $data['total_due_collection_cash'] = $this->Report_model->total_due_collection($from, $to, 'Cash');
            $data['total_due_collection_bank'] = $this->Report_model->total_due_collection($from, $to, 'Bank');
            $data['previous_due_collection_by_cash'] = $this->Report_model->previous_due_collection_by_cash($from, $to);
            $data['previous_due_collection_by_bank'] = $this->Report_model->previous_due_collection_by_bank($from, $to);
            $SaleCollectionCash = $this->Report_model->total_sale_against_cash_collection($from, $to) + $data['total_due_collection_cash'] - $data['previous_due_collection_by_cash'];
            $sale_info_due = $sale_info->total_sale - ($SaleCollectionBank + $SaleCollectionCash + $sale_info->sale_against_advance_deduction + $sale_info->sale_against_due_deduction_by_old_book_sell );
            $today_calculated_closing['due'] = $calculated_opening['due'] + $sale_info_due - $data['previous_due_collection_by_cash'] - $data['previous_due_collection_by_bank'];


//            Calculating advance_balance
            $today_calculated_closing['advance_balance'] = $calculated_opening['advance_balance'] + $this->Report_model->total_advance_collection_without_book_sale($from, $to) - $this->Report_model->total_sale_against_advance_deduction($from, $to);

            $output .= "\n<tr>\n\t<td>{$row->id_master_reconcillation}</td><td>{$row->date}</td><td>{$row->total_sales}</td>";

            //Showing Cash
//            $output .= "<td>{$row->opening_cash}</td><td>{$row->ending_cash}</td>";
            $opening_cash_color = ($row->opening_cash != $calculated_opening['cash']) ? ' style="color:red"' : "";
            $closing_cash_color = ($row->ending_cash != $today_calculated_closing['cash']) ? ' style="color:red"' : "";
            $output .= "<td$opening_cash_color>{$row->opening_cash} / {$calculated_opening['cash']}</td><td$closing_cash_color>{$row->ending_cash} / {$today_calculated_closing['cash']}</td>";

            //Showing Due
//            $output .= "<td>{$row->opening_due}</td><td>{$row->ending_due}</td>";
            $opening_cash_color = ($row->opening_due != $calculated_opening['due']) ? ' style="color:red"' : "";
            $closing_cash_color = ($row->ending_due != $today_calculated_closing['due']) ? ' style="color:red"' : "";
            $output .= "<td$opening_cash_color>{$row->opening_due} / {$calculated_opening['due']}</td><td$closing_cash_color>{$row->ending_due} / {$today_calculated_closing['due']}</td>";

            //Showing Bank
//            $output .= "<td>{$row->opening_bank_balance}</td><td>{$row->closing_bank_balance}</td>\n</tr>\n";
            $opening_bank_color = ($row->opening_bank_balance != $calculated_opening['bank']) ? ' style="color:red"' : "";
            $closing_bank_color = ($row->closing_bank_balance != $today_calculated_closing['bank']) ? ' style="color:red"' : "";
            $output .= "<td$opening_bank_color>{$row->opening_bank_balance} / {$calculated_opening['bank']}</td><td$closing_bank_color>{$row->closing_bank_balance} / {$today_calculated_closing['bank']}</td>\n";


            //Showing Bank
            $output .= "<td>{$calculated_opening['advance_balance'] }</td><td>{$today_calculated_closing['advance_balance'] }</td>\n</tr>\n";

            $calculated_opening['cash'] = $today_calculated_closing['cash'];
            $calculated_opening['bank'] = $today_calculated_closing['bank'];
            $calculated_opening['due'] = $today_calculated_closing['due'];
            $calculated_opening['advance_balance'] = $today_calculated_closing['advance_balance'];
        }
        return $output . '</table>';
    }

    function master_reconcilation_update() {
        $this->load->model('Report_model');
        $master_reconcillation_rows = $this->db->get('master_reconcillation')->result();
        $calculated_opening = array(
            'cash' => $master_reconcillation_rows[0]->opening_cash,
            'bank' => $master_reconcillation_rows[0]->opening_bank_balance,
            'due' => $master_reconcillation_rows[0]->opening_due,
            'advance_balance' => 0
        );
        $today_calculated_closing = array('cash' => 0, 'bank' => 0, 'due' => 0, 'advance_balance' => 0);
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


//            Calculating due
            $sale_info = $this->Report_model->sale_info($from, $to);
            $data['total_due_collection_cash'] = $this->Report_model->total_due_collection($from, $to, 'Cash');
            $data['total_due_collection_bank'] = $this->Report_model->total_due_collection($from, $to, 'Bank');
            $data['previous_due_collection_by_cash'] = $this->Report_model->previous_due_collection_by_cash($from, $to);
            $data['previous_due_collection_by_bank'] = $this->Report_model->previous_due_collection_by_bank($from, $to);
            $SaleCollectionCash = $this->Report_model->total_sale_against_cash_collection($from, $to) + $data['total_due_collection_cash'] - $data['previous_due_collection_by_cash'];
            $sale_info_due = $sale_info->total_sale - ($SaleCollectionBank + $SaleCollectionCash + $sale_info->sale_against_advance_deduction + $sale_info->sale_against_due_deduction_by_old_book_sell );
            $today_calculated_closing['due'] = $calculated_opening['due'] + $sale_info_due - $data['previous_due_collection_by_cash'] - $data['previous_due_collection_by_bank'];


//            Calculating advance_balance
            $today_calculated_closing['advance_balance'] = $calculated_opening['advance_balance'] + $this->Report_model->total_advance_collection_without_book_sale($from, $to) - $this->Report_model->total_sale_against_advance_deduction($from, $to);



            $data_to_update = array(
                'opening_cash' => $calculated_opening['cash'],
                'ending_cash' => $today_calculated_closing['cash'],
                'opening_due' => $calculated_opening['due'],
                'ending_due' => $today_calculated_closing['due'],
                'opening_bank_balance' => $calculated_opening['bank'],
                'closing_bank_balance' => $today_calculated_closing['bank'],
                'opening_advance_balance' => $calculated_opening['advance_balance'],
                'closing_advance_balance' => $today_calculated_closing['advance_balance']
            );
            $this->db->where('id_master_reconcillation', $row->id_master_reconcillation)->update('master_reconcillation', $data_to_update);
            $calculated_opening['cash'] = $today_calculated_closing['cash'];
            $calculated_opening['bank'] = $today_calculated_closing['bank'];
            $calculated_opening['due'] = $today_calculated_closing['due'];
            $calculated_opening['advance_balance'] = $today_calculated_closing['advance_balance'];
        }
    }

}
