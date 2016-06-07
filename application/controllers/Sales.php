<?php

/**
 * Description of Sales
 *
 * @author MD. Mashfiq
 */
class Sales extends CI_Controller {

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
        $this->load->model('Sales_model');
    }

    function index() {
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage sales';

        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/dashboard', $data);
    }

    function tolal_sales() {
        $crud = new grocery_CRUD();
        $crud->set_table('sales_total_sales')
                ->columns('id_total_sales', 'id_customer', 'issue_date', 'discount_percentage', 'discount_amount', 'sub_total', 'total_amount', 'cash', 'bank_pay', 'total_paid', 'total_due')
                ->display_as('id_total_sales', 'Memo No')
                ->display_as('id_customer', 'Customer Name')
                ->set_subject('Total sales')
                ->set_relation('id_customer', 'customer', 'name')
                ->order_by('id_total_sales', 'desc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Total sales';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/total_sales', $data);
    }

    function ajax_url() {
//        echo json_encode($_POST);
        $this->Sales_model->processing_new_sales();
    }

    function sales() {
        $crud = new grocery_CRUD();
        $crud->set_table('sales')
                ->set_subject('Sales')
                ->display_as('id_total_sales', 'Memo No')
                ->set_relation('id_item', 'items', 'name')
                ->order_by('id_sales', 'desc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Sales';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/sales', $data);
    }

    function new_sale() {
        $data['customer_dropdown'] = $this->Sales_model->get_party_dropdown();
        $data['item_dropdown'] = $this->Sales_model->get_item_dropdown();
        $data['customer_due'] = $this->Sales_model->get_party_due();
        $data['item_details'] = $this->Sales_model->get_item_details();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New sale';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/new_sale_form', $data);
    }

    function test($customer_id, $payment_amount) {
//        $this->db->select('')
//        $this->load->model('misc/Customer_due_payment');
//        $this->Customer_due_payment->add($customer_id, $payment_amount);
        $this->load->model('misc/Customer_due');
        $this->Customer_due->reduce($customer_id, $payment_amount) or die('Addtional ammount can not be processed');
    }

}
