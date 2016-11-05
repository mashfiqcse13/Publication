<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Sales_processing_model
 * https://drive.google.com/file/d/0BycC64dJHo0JbW0tUXpLOFZpMDg/view?usp=sharing
 * 
 * @author MD. Mashfiq
 */
class Sales_processing_model extends CI_Model {
    /*
     * Processing a new sale
     * see post array structure https://drive.google.com/file/d/0BycC64dJHo0JeGs4QVhjd0hIR1U/view?usp=sharing
     */

    private $id_customer;
    private $discount_percentage;
    private $discount_amount;
    private $item_selection;
    private $sub_total;
    private $cash_payment;
    private $bank_payment;
    private $bank_account_id;
    private $bank_check_no;
    private $advance_payment_balance;
    private $dues_unpaid;
    private $total_amount;
    private $id_total_sales;
    private $number_of_packet;
    private $bill_for_packeting;
    private $slip_expense_amount;

    function initiate() {
        $this->loading_models_and_response_values();
        //searching for Unprocessable case and exception , script will be aborted if found
        $this->processing_validation();

        if ($this->advance_payment_balance == 0) {
            $this->ExecuteCaseType1();
        } else if ($this->dues_unpaid == 0) {
            $this->ExecuteCaseType2();
        } else if ($this->advance_payment_balance == 0 && $this->dues_unpaid == 0) {
            $this->ExecuteCaseType3();
        } else {
            $this->exception_handler('This sale can not be processed');
        }
        $this->insert_on_sale_table($this->id_total_sales, $this->item_selection);

        $this->show_response($this->input->post('action'), $this->id_total_sales);
    }

    function loading_models_and_response_values() {
        $this->load->model('misc/Cash');
        $this->load->model('misc/Customer_due');
        $this->load->model('misc/Stock_perpetual');
        $this->load->model('misc/Customer_payment');
        $this->load->model('Stock_model');
        $this->load->model('Advance_payment_model');
        $this->load->model('misc/Master_reconcillation_model');

        $this->id_customer = $this->input->post('id_customer');
        $this->discount_percentage = $this->input->post('discount_percentage');
        $this->discount_amount = $this->input->post('discount_amount');
        $this->sub_total = $this->input->post('sub_total');
        $this->dues_unpaid = $this->Customer_due->current_total_due($this->id_customer);
        $this->cash_payment = $this->input->post('cash_payment');
        $this->bank_payment = $this->input->post('bank_payment');
        $this->bank_account_id = $this->input->post('bank_account_id');
        $this->bank_check_no = $this->input->post('bank_check_no');
        $this->item_selection = $this->input->post('item_selection');
        $this->number_of_packet = $this->input->post('number_of_packet');
        $this->bill_for_packeting = $this->input->post('bill_for_packeting');
        $this->slip_expense_amount = $this->input->post('slip_expense_amount');
        $this->advance_payment_balance = $this->Advance_payment_model->get_advance_payment_balance_by($this->id_customer);
        $this->total_amount = $this->sub_total - $this->discount_amount;
    }

    function total_paid() {
        return $this->advance_payment_balance + $this->bank_payment + $this->cash_payment;
    }

    function total_due() {
        return $this->total_amount - $this->total_paid();
    }

    function processing_validation() {
        $paid = $this->advance_payment_balance + $this->bank_payment + $this->cash_payment;
        if ($this->total_amount < 1) {
            $this->exception_handler('Nothing selected to sell');
        }
        if ($this->advance_payment_balance > 0 && $this->dues_unpaid > 0) {
            $this->exception_handler('Advance payment and dues unpaid both exists');
        }
        if ($this->dues_unpaid <= 0 && $paid > $this->total_amount && ($this->bank_payment + $this->cash_payment) > 0) {
            $this->exception_handler('You have extra bank or cash payment . It cannot be processed');
        }
    }

    function ExecuteCaseType1() {
        $this->load->model('Bank_model');
        $this->Customer_payment->set_combine_due_payment_register();
        if ($this->bank_account_id > 0 && $this->bank_payment > 0) {
            $this->Bank_model->bank_transection($this->bank_account_id, 1, $this->bank_payment, $this->bank_check_no, 1);       //accepting bank payment
        }
        if ($this->dues_unpaid > 0 && $this->bank_payment > 0) {
            if ($this->bank_payment >= $this->dues_unpaid) {
                $this->Customer_payment->due_payment($this->id_customer, $this->dues_unpaid, 3);
                $this->bank_payment = $this->bank_payment - $this->dues_unpaid;
                $this->dues_unpaid = 0;
            } else {
                $this->Customer_payment->due_payment($this->id_customer, $this->bank_payment, 3);
                $this->dues_unpaid = $this->dues_unpaid - $this->bank_payment;
                $this->bank_payment = 0;
            }
        }
        if ($this->dues_unpaid > 0 && $this->cash_payment > 0) {
            if ($this->cash_payment >= $this->dues_unpaid) {
                $this->Customer_payment->due_payment($this->id_customer, $this->dues_unpaid, 1);
                $this->cash_payment = $this->cash_payment - $this->dues_unpaid;
                $this->dues_unpaid = 0;
            } else {
                $this->Customer_payment->due_payment($this->id_customer, $this->cash_payment, 1);
                $this->dues_unpaid = $this->dues_unpaid - $this->cash_payment;
                $this->cash_payment = 0;
            }
        }
        $total_paid = $this->bank_payment + $this->cash_payment;
        $total_due = $this->total_amount - $total_paid;
        $this->id_total_sales = $this->insert_on_sales_total_sales($total_paid, $total_due);
        if ($this->bank_payment > 0) {
            $this->Customer_payment->payment_register($this->id_customer, $this->bank_payment, $this->id_total_sales, 3);
        }
        $this->accepting_payments($this->id_customer, $this->id_total_sales, 0, $this->cash_payment, 0, 0, 0);
        $this->Customer_payment->unset_combine_due_payment_register($this->id_total_sales);
    }

    function ExecuteCaseType2() {
        if ($this->advance_payment_balance >= $this->total_amount) {
            $this->advance_payment_balance = $this->total_amount;
            $this->id_total_sales = $this->insert_on_sales_total_sales($this->advance_payment_balance, 0);
            $this->accepting_payments($this->id_customer, $this->id_total_sales, $this->advance_payment_balance, $this->cash_payment, $this->bank_payment, $this->bank_check_no, $this->bank_account_id);
        } else {
            $this->id_total_sales = $this->insert_on_sales_total_sales($this->total_paid(), $this->total_due());
            $this->accepting_payments($this->id_customer, $this->id_total_sales, $this->advance_payment_balance, $this->cash_payment, $this->bank_payment, $this->bank_check_no, $this->bank_account_id);
        }
    }

    function ExecuteCaseType3() {
        $total_paid = $this->cash_payment + $this->bank_payment;
        $total_due = $this->total_amount - $total_paid;
        $this->id_total_sales = $this->insert_on_sales_total_sales($total_paid, $total_due);
        $this->accepting_payments($this->id_customer, $this->id_total_sales, 0, $this->cash_payment, $this->bank_payment, $this->bank_check_no, $this->bank_account_id);
    }

    function insert_on_sales_total_sales($total_paid, $total_due) {
        if ($total_due < 0) {
            $this->exception_handler('Due cannot be negetive');
        }
        $this->Customer_due->add($this->id_customer, $total_due);
        $data = array(
            'id_customer' => $this->id_customer,
            'issue_date' => date('Y-m-d h:i:u'),
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
            'sub_total' => $this->sub_total,
            'total_amount' => $this->total_amount,
            'total_paid' => $total_paid,
            'total_due' => $total_due,
            'number_of_packet' => $this->number_of_packet,
            'bill_for_packeting' => $this->bill_for_packeting,
            'slip_expense_amount' => $this->slip_expense_amount
        );
        $this->db->insert('sales_total_sales', $data) or $this->exception_handler('failed to insert data on sales_total_sales');
        $this->Master_reconcillation_model->add_total_sale($this->total_amount);
        $this->id_total_sales = $this->max_id_total_sales();
        if ($this->slip_expense_amount > 0) {
            $this->load->model('Expense_model');
            $this->Expense_model->expense_register(4, $this->slip_expense_amount, "Memo No : {$this->id_total_sales}");
        }
        if ($this->bill_for_packeting > 0) {
//            $this->load->model('Expense_model');
//            $this->Expense_model->expense_register(6, $this->bill_for_packeting, "Memo No : {$this->id_total_sales}");
        }
        return $this->id_total_sales;
    }

    function max_id_total_sales() {
        $sql = "SELECT max(`id_total_sales`) as max_id_total_sales FROM `sales_total_sales`";
        $result = $this->db->query($sql)->result();
        return $result[0]->max_id_total_sales;
    }

    function insert_on_sale_table($id_total_sales, $item_selection) {
        $data_sales = array();
        foreach ($item_selection as $value) {
            if (empty($value)) {
                continue;
            }
            $tmp_data_sales = array(
                'id_total_sales' => $id_total_sales,
                'id_item' => $value['item_id'],
                'quantity' => $value['item_quantity'],
                'price' => $value['sale_price'],
                'total_cost' => $value['total'],
                'discount' => 0,
                'sub_total' => $value['total']
            );
            array_push($data_sales, $tmp_data_sales);
            $this->Stock_perpetual->Stock_perpetual_register($value['item_id'], $value['item_quantity']);
            $this->Stock_model->stock_reduce($value['item_id'], $value['item_quantity']);
        }
        $this->db->insert_batch('sales', $data_sales) or $this->exception_handler('failed to insert data on sales');
    }

    function accepting_payments($id_customer, $id_total_sales, $amount_to_reduce_from_advance_payment, $cash_payment, $bank_payment, $bank_check_no, $bank_account_id) {
        if ($cash_payment > 0) {
            $this->Cash->add($cash_payment) or $this->exception_handler('Failed to put cash in cash box');
            $this->Customer_payment->payment_register($id_customer, $cash_payment, $id_total_sales, 1);
        }
        if ($bank_payment > 0 && $bank_account_id > 0 && !empty($bank_check_no)) {
            $this->load->model('Bank_model');
            $this->Bank_model->bank_transection($bank_account_id, 1, $bank_payment, $bank_check_no, 1);
            $this->Customer_payment->payment_register($id_customer, $bank_payment, $id_total_sales, 3);
        }
        if ($amount_to_reduce_from_advance_payment > 0) {
            $this->Customer_payment->payment_register($id_customer, $amount_to_reduce_from_advance_payment, $id_total_sales, 2);
            $this->Advance_payment_model->payment_reduce($id_customer, $amount_to_reduce_from_advance_payment);
        }
    }

    function exception_handler($error_msg, $destination_url = FALSE) {
        if ($destination_url == FALSE) {
            $destination_url = site_url('sales/new_sale/');
        }
        $response['msg'] = $error_msg;
        $response['next_url'] = $destination_url;
        die(json_encode($response));
    }

    function show_response($action, $id_total_sales) {
        if ($action == 'save_and_reset') {
            $response['msg'] = "The sales is successfully done . \n Memo No: $id_total_sales";
            $response['next_url'] = site_url('sales/new_sale');
        } else if ($action == 'save_and_back_to_list') {
            $response['msg'] = "The sales is successfully done . \n Memo No: $id_total_sales";
            $response['next_url'] = site_url('sales/tolal_sales');
        } else if ($action == 'save_and_print') {
            $response['msg'] = "The sales is successfully done . \n Memo No: $id_total_sales";
            $response['next_url'] = site_url('sales/memo/' . $id_total_sales);
        }
        die(json_encode($response));
    }

}
