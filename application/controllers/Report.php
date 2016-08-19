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
//        $this->load->model('Report_model');
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

        $data['today_customer_due_bank'] = $this->Customer_payment->today_customer_due_bank();
        $data['today_customer_due_cash'] = $this->Customer_payment->today_customer_due_cash();
        $data['today_customer_advance_payment_bank'] = $this->Advance_payment_model->today_customer_advance_payment_bank();
        $data['today_customer_advance_payment__cash'] = $this->Advance_payment_model->today_customer_advance_payment__cash();
        
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Cash in Hand';
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

}
