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
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(12);
    }

    function index() {
        redirect('old_book/return_book');
//        $this->return_book();
    }

    function old_book_dashboard() {
        redirect('old_book/tolal_return_book');
//        $this->tolal_return_book();
    }

    function tolal_return_book() {
        $crud = new grocery_CRUD();
        $crud->set_table('old_book_return_total')
                ->columns('id_old_book_return_total', 'id_customer', 'issue_date', 'sub_total', 'discount_percentage', 'discount_amount', 'total_amount', 'payment_type')
                ->display_as('id_old_book_return_total', 'Memo No')
                ->display_as('discount_amount', 'Courier Cost Deduction')
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
        $crud->callback_column('payment_type', function($value) {
            if ($value == 1) {
                return 'cash';
            } elseif ($value == 2) {
                return 'Advanced';
            }
        });
        $date_range = $this->input->post('date_range');



        $btn = $this->input->post('btn_submit');

        $id_customer = $this->input->post('id_customer');

        if (isset($btn)) {
            $data['return_book'] = $this->Old_book_model->get_total_return_info($id_customer,$date_range);
            $data['get_curier'] = $this->Old_book_model->get_curier_cost($date_range);
           // $data['curuer'] = $this->Old_book_model->get_total_courier($id_customer,$date_range);
//            echo '<pre>';
//            print_r($data['return_book']);

            $data['date_range'] = $date_range;
        }
//        $data['customer_dropdown'] = $this->Old_book_model->get_party_dropdown_search();
        
        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();

        $output = $crud->render();
        $data['glosary'] = $output;
        $data['memo_list'] = $this->memo_list();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Old Book Dashboard';
        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/total_return', $data);
    }

    function total_report() {

        $date_range = $this->input->post('date_range');

        $btn = $this->input->post('btn_submit');

        $id_customer = $this->input->post('id_customer');

        if (isset($btn)) {

            $date = explode('-', $date_range);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime($date[1]));
            $data['report'] = $this->Old_book_model->get_total_info($from,$to);
            $data['items'] = $this->Old_book_model->get_all_item();
            // $data['curuer'] = $this->Old_book_model->get_total_courier($id_customer,$date_range);
//            echo '<pre>';
//            print_r($data['report']);
//            exit();

            $data['date_range'] = $date_range;
        }
//        $data['customer_dropdown'] = $this->Old_book_model->get_party_dropdown_search();
        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();


        $data['memo_list'] = $this->memo_list();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Old Book Total Report';
        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/total_report', $data);
    }

    function ajax_url() {
//        echo json_encode($_POST);
        
        $this->Old_book_model->processing_return_oldbook();
    }

    function old_book_sale_or_rebind() {        
        $this->Old_book_model->old_book_sale_or_rebind();
//        redirect('old_book/return_book_sale_list');
    }

    function return_book() {
        $this->load->model('sales_model');
//        $data['customer_dropdown'] = $this->Old_book_model->get_party_dropdown();
        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();
//        $data['item_dropdown'] = $this->Old_book_model->get_item_dropdown();
        $data['item_dropdown'] = $this->Sales_model->get_available_item_dropdown();
        $data['customer_due'] = $this->Old_book_model->get_party_due();

        $data['item_details'] = $this->Old_book_model->get_item_details();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New Entry Of Old Book ';
        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/old_return_form', $data);
    }

    function return_book_sale() {
//        $data['customer_dropdown'] = $this->Old_book_model->get_party_dropdown();
        $data['customer_dropdown'] = $this->Common->get_customer_dropdown();
        $data['item_dropdown'] = $this->Old_book_model->get_available_item_dropdown();
        
        $data['customer_due'] = $this->Old_book_model->get_party_due();
        $data['item_details'] = $this->Old_book_model->get_old_item_details();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New Entry of Rebined/Sale';
        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/old_return_book_sale', $data);
    }

    function return_book_sale_list() {
        $crud = new grocery_CRUD();
        $crud->set_table('old_book_transfer_total')
                ->set_subject('Old Book Sales or Rebind')
                ->display_as('type_transfer', 'Transfer Type')
                ->display_as('id_old_book_transfer_total', 'Id')
                ->order_by('id_old_book_transfer_total', 'desc')
                ->columns('id_old_book_transfer_total', 'type_transfer', 'date_transfer', 'price')
                ->unset_edit()
                ->unset_delete()
                ->unset_add()
                ->add_action('Print Memo', '', '', 'fa fa-print', function ($primary_key, $row) {
                    return site_url('old_book/rebind_transfer_slip/' . $primary_key);
                });


        $crud->callback_column('type_transfer', function($value) {
            if ($value == 1) {
                return 'Old Book Sale';
            } elseif ($value == 2) {
                return 'Send To Rebind';
            } else {
                return 'Throw Away';
            }
        });

        $date_range = $this->input->post('date_range');
        $btn = $this->input->post('btn_submit');

        $id_type = $this->input->post('process');


        if (isset($btn)) {
            $data['return_list'] = $this->Old_book_model->get_sale_rebind($id_type, $date_range);
//            echo '<pre>';
//            print_r($data['return_list']);
            if ($id_type != '') {
                $data['id_type'] = $id_type;
            }
            $data['date_range'] = $date_range;
        }

        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Rebine/Sale Dashboard';
        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/list_old_book_sale_rebind', $data);
    }

    function memo($total_sales_id) {




        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Memo Generation';
        $data['base_url'] = base_url();
        $data['memo_header_details'] = $this->Old_book_model->memo_header_details($total_sales_id);
        $data['memo_body_table'] = $this->Old_book_model->memo_body_table($total_sales_id);
//        print_r($data['memo_header_details']);
//        $data['Book_selection_table'] = $this->Memo->memogenerat($memo_id);
        $customer_id = $data['memo_header_details']['code'];
        $data['balance'] = $this->Old_book_model->current_advanced_balance($customer_id);



        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/memo', $data);
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

    function rebind_transfer_slip($id_old_book_transfer_total) {
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Memo Generation';
        $data['base_url'] = base_url();
        $data['old_book_rebind_table'] = $this->Old_book_model->old_book_rebind_table($id_old_book_transfer_total);

        $this->load->view($this->config->item('ADMIN_THEME') . 'old_book/rebind_transfer_slip', $data);
    }

}
