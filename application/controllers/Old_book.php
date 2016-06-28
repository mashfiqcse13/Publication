<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Sales
 *
 * @author MD. Mashfiq
 */
class Old_book extends CI_Controller {

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
        $this->load->model('Old_book_model');
    }

    function index() {
        $this->return_book();
    }
    
    
    function old_book_dashboard(){
        $this->tolal_return_book();
    }
    
    function tolal_return_book() {
        $crud = new grocery_CRUD();
        $crud->set_table('old_book_return_total')
                ->columns('id_old_book_return_total', 'id_customer', 'issue_date', 'sub_total','discount_percentage','	discount_amount', 'total_amount', 'payment_type')
                ->display_as('id_old_book_return_total', 'Memo No')
                ->display_as('id_customer', 'Customer Name')->display_as('total_amount', 'Total Return Price')
                ->set_subject('Old Book Return')
                ->set_relation('id_customer', 'customer', 'name')
                ->order_by('id_old_book_return_total', 'desc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add()
                ->add_action('Print Memo', '', '', 'fa fa-print', function ($primary_key, $row) {
                    return site_url('old_book/memo/' . $primary_key);
                });
                $crud->callback_column('payment_type', function($value){
                    if($value == 1){
                        return 'cash';
                    }elseif($value == 2){
                       return 'Advanced';
                    }
                    
                });
        $data['date_range'] = $this->input->get('date_range');
        $date = explode('-', $data['date_range']);
        if ($data['date_range'] != '') {
//            $get_where_clause = $this->Stock_model->get_where_clause($date[0], $date[1]);
//            $crud->where($get_where_clause);
            $data['total_sales'] = $this->Sales_model->get_total_sales_info($date[0], $date[1]);
        }

        $output = $crud->render();
        $data['glosary'] = $output;
        $data['memo_list'] = $this->memo_list();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Old Book Return';
        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/total_return', $data);
    }

    function ajax_url() {
//        echo json_encode($_POST);
        $this->Old_book_model->processing_return_oldbook();
    }
    
    function old_book_sale_or_rebind(){
        $this->Old_book_model->old_book_sale_or_rebind();
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

    function return_book() {
        $data['customer_dropdown'] = $this->Old_book_model->get_party_dropdown();
        $data['item_dropdown'] = $this->Old_book_model->get_available_item_dropdown();
        $data['customer_due'] = $this->Old_book_model->get_party_due();
        $data['item_details'] = $this->Old_book_model->get_item_details();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New sale';
        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/old_return_form', $data);
    }
    
    function return_book_sale(){
        $data['customer_dropdown'] = $this->Old_book_model->get_party_dropdown();
        $data['item_dropdown'] = $this->Old_book_model->get_available_item_dropdown();
        $data['customer_due'] = $this->Old_book_model->get_party_due();
        $data['item_details'] = $this->Old_book_model->get_old_item_details();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New sale';
        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/old_return_book_sale', $data);  
    }

    function memo($total_sales_id) {

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Memo Generation';
        $data['base_url'] = base_url();
        $data['memo_header_details'] = $this->Sales_model->memo_header_details($total_sales_id);
        $data['memo_body_table'] = $this->Sales_model->memo_body_table($total_sales_id);
//        print_r($data['memo_header_details']);
//        $data['Book_selection_table'] = $this->Memo->memogenerat($memo_id);
        $customer_id = $data['memo_header_details']['code'];
        $data['edit_btn_url'] = site_url('due/make_payment/' . $customer_id);

        $this->load->model('misc/Customer_due');
        $data['customer_total_due'] = $this->Customer_due->current_total_due($customer_id);

        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/memo', $data);
    }

    function memo_report() {
        $data['memo_list'] = $this->memo_list();
        $total_sales_id = $this->input->post('id_total_sales');

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Memo Generation';
        $data['base_url'] = base_url();
        $data['memo_header_details'] = $this->Sales_model->memo_header_details($total_sales_id);
        $data['memo_body_table'] = $this->Sales_model->memo_body_table($total_sales_id);
//        print_r($data['memo_header_details']);
//        $data['Book_selection_table'] = $this->Memo->memogenerat($memo_id);
        $customer_id = $data['memo_header_details']['code'];
        $data['edit_btn_url'] = site_url('due/make_payment/' . $customer_id);

        $data['check_dues_payment'] = $this->check_dues_payment($total_sales_id);

        $this->load->model('misc/Customer_due');

        $data['customer_total_due'] = $this->Customer_due->current_total_due($customer_id);


        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/memo_report', $data);
    }

    function memo_list() {

        $this->db->select('id_total_sales');
        $this->db->from('sales_total_sales');
        $this->db->order_by('id_total_sales', "asc");
        $query = $this->db->get();
        $db_rows = $query->result_array();

        $options[''] = "Select Memo Number";
        foreach ($db_rows as $index => $row) {
            $options[$row['id_total_sales']] = $row['id_total_sales'];
        }
        if (!isset($options)) {
            $options[''] = "";
        }

        return form_dropdown('id_total_sales', $options, '', 'class="form-control select2 select2-hidden-accessible" tabindex="-1"  aria-hidden="true"');
    }

    function check_dues_payment($memo_id) {
        $query = $this->db->query("SELECT `payment_date`,CONCAT('TK',`paid_amount`) "
                . "FROM `customer_payment` WHERE `id_total_sales`=$memo_id");


        $this->load->library('table');
        $this->table->set_heading(array('Payment Date', 'Paid Amount'));

        $tmpl = array(
            'table_open' => '<table class="report_payment table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0">',
            'heading_row_start' => '<tr style="background:#ddd">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="text-center">',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );

        $this->table->set_template($tmpl);

        $data['table1'] = $this->table->generate($query);
        $this->table->clear();
        $totalpadi = $this->db->query("SELECT CONCAT('TK ',sum(paid_amount)) as total FROM customer_payment WHERE `id_total_sales`=$memo_id");
        foreach ($totalpadi->result() as $row) {
            $total = $row->total;
        }
        $this->table->set_heading('', '');
        $this->table->add_row('<span style="float:right">Total :</span>', $total);

        $data['table2'] = $this->table->generate();

        return $data;
    }

}
