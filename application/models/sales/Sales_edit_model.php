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

    /*
     * This is test data section
     * Here dummy data will be added for testing purpose
     */

    function test_data() {

        $this->existing_data = array(
            'id_sales_total_sales' => 234,
            "id_customer" => "60",
            'item_selection' => array(
                array(
                    "item_id" => 1,
                    "item_quantity" => 2,
                    "name" => "ব্যবসায় সংগঠন ও ব্যবস্হাপনা - প্রথম পত্র",
                    "regular_price" => "205",
                    "sale_price" => "140",
                    "total" => 280 // should be calculated
                ), // should be calculated
                array(
                    "item_id" => 3,
                    "item_quantity" => 2,
                    "name" => "Business Organization & Management 2nd Paper",
                    "regular_price" => "200",
                    "sale_price" => "140",
                    "total" => 280 // should be calculated
                )
            ),
            'sub_total' => 560,
            "discount_amount" => 0,
            "discount_percentage" => 0,
            'total_amount' => 560,
            "dues_unpaid" => 0,
            'payment_info_cash' => 260,
            'payment_info_bank' => 260,
            'payment_info_customer_balance_reduction' => 0,
            'total_paid' => 460,
            'total_due' => 100,
            "number_of_packet" => 5,
            'bill_for_packeting' => 30,
            'slip_expense_amount' => 40
        );
        $this->changed_data = array(
            'bank_account_id' => 1,
            'bank_check_no' => "This is account number",
            'bank_payment' => 200,
            'bill_for_packeting' => 30,
            'payment_info_cash' => 260,
            'customer_balance_reduction' => 0,
            "discount_amount" => 0,
            "discount_percentage" => 0,
            "dues_unpaid" => 0,
            "id_customer" => "60",
            'item_selection' => array(
                array(
                    "item_id" => 1,
                    "item_quantity" => 2,
                    "name" => "ব্যবসায় সংগঠন ও ব্যবস্হাপনা - প্রথম পত্র",
                    "regular_price" => "205",
                    "sale_price" => "140",
                    "total" => 280 // should be calculated 'ffff
                ), // should be calculated
                array(
                    "item_id" => 3,
                    "item_quantity" => 2,
                    "name" => "Business Organization & Management 2nd Paper",
                    "regular_price" => "200",
                    "sale_price" => "140",
                    "total" => 280 // should be calculated
                )
            ),
            "number_of_packet" => 5,
            'slip_expense_amount' => 40,
            'sub_total' => 560,
            'total_amount' => 560,
            'total_due' => 100,
            'total_paid' => 460
        );
    }

    /*
     * This function will grabb data from the database+edit from and initialize to the respective variable
     */

    function grab_data($id_sales_total_sales) {
        $this->test_data();
    }

    /*
     * This function will update the test sales table in the database
     */

    function sales_update() {
        
    }

    /*
     * This function will update the final stock
     */

    function stock_update() {
        
    }

    /*
     * If user increase or decrease the slip expense or bill payment option then it will be used to add row in expense table
     */

    function expense_update() {
        
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
