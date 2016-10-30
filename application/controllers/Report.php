<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Report
 *
 * @author MD. Mashfiq
 */
class Report extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('Common');
        $this->load->model('Report_model');
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(16);
    }

    function index() {
        $this->cash_box();
    }

    function cash_box() {
        $data['cash'] = $this->db->get('cash')->result();
        $data['cash'] = $data['cash'][0];
//        die(print_r($data));


        $query1 = $this->db->query("SELECT IFNULL(sum(`total_amount`) ,0) as today_total,"
                . "IFNULL(sum(`total_due`) ,0) as today_due"
                . "  FROM sales_total_sales WHERE  DATE(issue_date) = DATE(NOW())");
        foreach ($query1->result() as $row) {
            $data['today_sales'] = $row->today_total;
            $data['today_due'] = $row->today_due;
        }
        $this->load->model('misc/Customer_payment');
        $this->load->model('Advance_payment_model');
        $data['today_cash'] = $this->Customer_payment->today_collection() + $this->Advance_payment_model->today_collection();
        $data['today_bank'] = $this->Customer_payment->today_collection(3) + $this->Advance_payment_model->today_collection(3);
        $data['advance_payment_balance'] = $this->Advance_payment_model->total_advance_payment_balance();


        $today_total_payment_against_sale = $this->Customer_payment->today_total_payment_against_sale();
        $data['today_total_cash_paid_against_sale'] = $today_total_payment_against_sale['today_total_cash_paid_against_sale'];
        $data['today_total_bank_paid_against_sale'] = $today_total_payment_against_sale['today_total_bank_paid_against_sale'];
        $data['today_total_advance_deduction_against_sale'] = $today_total_payment_against_sale['today_total_advance_deduction_against_sale'];

        $from = date('Y-m-d', now());
        $to = date('Y-m-d', now());


        $data['sale_info'] = $this->Report_model->sale_info($from, $to);
//        foreach($old_book_sale->result() as $row){
//            $data['due_payment_by_old_book']=$row->Sale_against_due_deduction_by_old_book_sell;
//        }
        //print_r($data['due_payment_by_old_book']);

        $data['today_due_collection_against_sale'] = $this->Report_model->total_sale_against_due_collection($from, $to);

        //$data['today_due_collection_against_sale'] =  $this->Customer_payment->today_customer_due_bank() +  $this->Customer_payment->today_customer_due_cash() ;

        $data['today_total_due_collection'] = $this->Customer_payment->today_total_due_collection();

        $data['totay_total_advance_collection_without_book_sale'] = $this->Report_model->total_advance_collection_without_book_sale($from, $to);
        $data['total_advance_collection_without_book_sale_cash'] = $this->Report_model->total_advance_collection_without_book_sale($from, $to, 'Cash');
        $data['total_advance_collection_without_book_sale_bank'] = $this->Report_model->total_advance_collection_without_book_sale($from, $to, 'Bank');

        //$data['$totay_total_collection_cash_bank'] =

        $data['totay_total_expense'] = $this->Customer_payment->today_total_expesne();

//        $data['today_customer_advance_payment_bank'] = $this->Advance_payment_model->today_customer_advance_payment_bank();
//        $data['totay_total_cash_collection'] = $this->Advance_payment_model->today_customer_advance_payment__cash();


        $data['today_total_cash_2_bank_trasfer'] = $this->Report_model->total_cash_2_bank_trasfer($from, $to);
        $data['today_total_cash_2_expense_adjustment'] = $this->Report_model->total_cash_2_expense_adjustment($from, $to);

        $data['previous_due_collection'] = $this->Report_model->previous_due_collection($from, $to);
        $data['previous_due_collection_by_cash'] = $this->Report_model->previous_due_collection_by_cash($from, $to);
        $data['previous_due_collection_by_bank'] = $this->Report_model->previous_due_collection_by_bank($from, $to);
        $data['previous_due_collection_by_old_book_sell'] = $this->Report_model->previous_due_collection_by_old_book_sell($from, $to);

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Cash box';
        $this->load->view($this->config->item('ADMIN_THEME') . 'report/cash_box', $data);
    }

    function customer_due() {
        $crud = new grocery_CRUD();
        $crud->set_table('customer_due')
                ->set_subject('Customer Due')
                ->set_relation('id_customer', 'customer', 'name')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Customer Due';
        $this->load->view($this->config->item('ADMIN_THEME') . 'report/customer_due_and_payment', $data);
    }

    function customer_payment() {
        $crud = new grocery_CRUD();
        $crud->set_table('customer_payment')
                ->set_subject('Customer Payment')
                ->set_relation('id_customer', 'customer', 'name')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Customer Payment';
        $this->load->view($this->config->item('ADMIN_THEME') . 'report/customer_due_and_payment', $data);
    }

    function master_reconcillation() {
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Master reconcillation';

        $crud = new grocery_CRUD();
        $crud->set_table('master_reconcillation')
                ->set_subject('Master reconcillation')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();

        $data['date_range'] = $this->input->get('date_range');
        $date = explode('-', $data['date_range']);
        if ($data['date_range'] != '') {
            $from_date = date('Y-m-d', strtotime($date[0]));
            $to_date = date('Y-m-d', strtotime($date[0]));
            $crud->where("date(`date`) between '$from_date' and '$to_date'");
        }

        $output = $crud->render();
        $data['glosary'] = $output;


        $this->load->view($this->config->item('ADMIN_THEME') . 'report/master_reconcillation', $data);
    }

    function total_report() {
        $btn = $this->input->get('btn_submit');
        $data['date_range'] = $this->input->get('date_range');
        $date = explode('-', $data['date_range']);
        if ($btn) {
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime($date[1]));

            $data['sale_info'] = $this->Report_model->sale_info($from, $to);

            $this->load->model('misc/Customer_payment');
            $total_payments_against_sale = $this->Customer_payment->total_payments_against_sale($from, $to);
            $data['total_sale_against_cash_collection'] = $total_payments_against_sale['today_total_cash_paid_against_sale'];
            $data['total_sale_against_bank_collection'] = $total_payments_against_sale['today_total_bank_paid_against_sale'];
            $data['total_sale_against_advance_deduction'] = $total_payments_against_sale['today_total_advance_deduction_against_sale'];

            $data['total_sale_against_due_collection'] = $this->Report_model->total_sale_against_due_collection($from, $to);
            $data['total_sale_against_due_collection_cash'] = $this->Report_model->total_sale_against_due_collection($from, $to, 'Cash');
            $data['total_sale_against_due_collection_bank'] = $this->Report_model->total_sale_against_due_collection($from, $to, 'Bank');

            $data['total_due_collection'] = $this->Report_model->total_due_collection($from, $to);
            $data['total_due_collection_cash'] = $this->Report_model->total_due_collection($from, $to, 'Cash');
            $data['total_due_collection_bank'] = $this->Report_model->total_due_collection($from, $to, 'Bank');

            $data['previous_due_collection'] = $this->Report_model->previous_due_collection($from, $to);
            $data['previous_due_collection_by_cash'] = $this->Report_model->previous_due_collection_by_cash($from, $to);
            $data['previous_due_collection_by_bank'] = $this->Report_model->previous_due_collection_by_bank($from, $to);
            $data['previous_due_collection_by_old_book_sell'] = $this->Report_model->previous_due_collection_by_old_book_sell($from, $to);

            $data['total_advance_collection'] = $this->Report_model->total_advance_collection_without_book_sale($from, $to);
            $data['total_advance_collection_cash'] = $this->Report_model->total_advance_collection_without_book_sale($from, $to, 'Cash');
            $data['total_advance_collection_bank'] = $this->Report_model->total_advance_collection_without_book_sale($from, $to, 'Bank');
            $data['total_advance_collection_old_book_sell'] = $this->Report_model->total_advance_collection_without_book_sale($from, $to, 'Old Book Sell');

            $data['total_cash_collection_from_customer_payment'] = $this->Report_model->total_cash_collection_from_customer_payment($from, $to);
            $data['total_bank_collection_from_customer_payment'] = $this->Report_model->total_bank_collection_from_customer_payment($from, $to);
            $data['total_cash_collection_from_advance_payment'] = $this->Report_model->total_cash_collection_from_advance_payment($from, $to);
            $data['total_bank_collection_from_advance_payment'] = $this->Report_model->total_bank_collection_from_advance_payment($from, $to);

            $data['total_old_book_transfer'] = $this->Report_model->total_old_book_transfer($from, $to);

            $data['total_cash_collection'] = $data['total_cash_collection_from_customer_payment'] + $data['total_cash_collection_from_advance_payment'] + $data['total_old_book_transfer'];
            $data['total_bank_collection'] = $data['total_bank_collection_from_customer_payment'] + $data['total_bank_collection_from_advance_payment'];
            $data['total_collection_cash_bank'] = $data['total_cash_collection'] + $data['total_bank_collection'];

            $data['total_expence'] = $this->Report_model->total_expence($from, $to);

            $data['opening'] = $this->Report_model->opening($from, $to);
            $data['closing'] = $this->Report_model->closing($from, $to);


            $data['total_cash_2_bank_trasfer'] = $this->Report_model->total_cash_2_bank_trasfer($from, $to);
            $data['total_cash_2_owner'] = $this->Report_model->total_cash_2_owner($from, $to);
            $data['total_cash_2_expense_adjustment'] = $this->Report_model->total_cash_2_expense_adjustment($from, $to);
            $data['total_bank_withdraw'] = $this->Report_model->total_bank_withdraw($from, $to);
//            print_r($data);exit();
        }
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Final Report';
        $this->load->view($this->config->item('ADMIN_THEME') . 'report/total_report', $data);
    }

}
