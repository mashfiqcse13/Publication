<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->load->model('Bank_model');
        $this->load->model('Advance_payment_model');
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(18);
    }

    function index() {
        $this->tolal_sales();
    }

    function tolal_sales() {
        $crud = new grocery_CRUD();
        $crud->set_table('sales_total_sales')
                ->columns('id_total_sales', 'id_customer', 'issue_date', 'sub_total', 'discount_percentage', 'discount_amount', 'total_amount', 'total_paid', 'total_due', 'number_of_packet', 'bill_for_packeting', 'slip_expense_amount')
                ->display_as('id_total_sales', 'Memo No')->display_as('issue_date', 'Issue Date (M/D/Y)')
                ->display_as('id_customer', 'Customer Name')->display_as('total_amount', 'Total Sale Amout')->display_as('bill_for_packeting', 'Bill For Packeting On Due')
                ->set_subject('Total sales')
                ->set_relation('id_customer', 'customer', 'name')
                ->order_by('id_total_sales', 'desc')
                ->unset_edit()->unset_delete()->unset_add()->unset_read()
                ->add_action('Print Memo', base_url() . 'asset/img/button/Print Memo.png', '', '', function ($primary_key, $row) {
                    return site_url('sales/memo/' . $primary_key);
                });
        $data['date_range'] = $this->input->get('date_range');
        $id_customer = $this->input->get('id_customer');
        $filter_district = $this->input->get('filter_district');

        if (empty($id_customer) && empty($filter_district) && empty($data['date_range']) && !empty($this->input->get('btn_submit'))) {
            ?><script>
                alert("Please select any customer or date range or party district");
                window.history.back();
            </script>
            <?php
            die();
        }

        $date = explode('-', $data['date_range']);
        $from = '';
        $to = '';
        if ($data['date_range'] != '') {
            $from = $date[0];
            $to = $date[1];
        }
        if (!empty($data['date_range']) || !empty($id_customer) || !empty($filter_district)) {
//            $get_where_clause = $this->Stock_model->get_where_clause($date[0], $date[1]);
//            $crud->where($get_where_clause);
            $data['total_sales'] = $this->Sales_model->get_total_sales_info($from, $to, $id_customer, $filter_district);
//             print_r($data['total_sales']);exit();
        }

        $districts = $this->config->item('districts_english');
        $districts[''] = "Select a district";
        $data['district_dropdown'] = form_dropdown('filter_district', $districts, $filter_district, 'class="form-control select2"');

        $output = $crud->render();
        $data['glosary'] = $output;
        $data['memo_list'] = $this->memo_list();
        $data['customer_dropdown'] = $this->Sales_model->get_party_dropdown_as_customer();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Total sales';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/total_sales', $data);
    }

    function ajax_url() {
        $this->load->model('Sales_processing_model');
        $this->Sales_processing_model->initiate();
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
        $data['bank_account_dropdown'] = $this->Bank_model->get_account_dropdown();
        $data['customer_current_balance'] = $this->Advance_payment_model->get_all_advance_payment_balance();

        $data['customer_dropdown'] = $this->Sales_model->get_party_dropdown();
        $data['item_dropdown'] = $this->Sales_model->get_available_item_dropdown();
        $data['customer_due'] = $this->Sales_model->get_party_due();
        $data['item_details'] = $this->Sales_model->get_item_details();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New sale';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/new_sale_form', $data);
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
        $total_sales_id = $this->input->get('id_total_sales');
        if (empty($total_sales_id)) {
            ?><script>
                alert("Please select memo ID");
                window.history.back();
            </script>
            <?php
            die();
        }

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
