<?php

/**
 * Description of Sales
 *
 * @author MD. Mashfiq
 */
class Sales extends CI_Controller {

    //put your code here
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
                ->set_subject('Total sales');
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Total sales';
        $this->load->view($this->config->item('ADMIN_THEME') . 'sales/total_sales', $data);
    }

    function ajax_url() {
//        echo json_encode($_POST);
        $data = array(
            'id_customer' => $this->input->post('id_customer'),
            'discount_percentage' => $this->input->post('discount_percentage'),
            'discount_amount' => $this->input->post('discount_amount'),
            'sub_total' => $this->input->post('sub_total'),
            'total_amount' => $this->input->post('total_amount'),
            'total_paid' => $this->input->post('total_paid'),
            'total_due' => $this->input->post('total_due'),
        );

        $this->db->insert('sales_total_sales', $data) or die('failed');
    }

    function sales() {
        $crud = new grocery_CRUD();
        $crud->set_table('sales')
                ->set_subject('Sales');
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

    function memo_management($cmd = false, $primary_id = false) {
        $this->load->model('Memo');
        $this->load->library('session');

        $crud = new grocery_CRUD();
        $crud->set_table('pub_memos')
                ->set_subject('Memo')
                ->display_as('contact_ID', 'Party Name')
                ->display_as('issue_date', 'Issue Date (mm/dd/yyyy)')
                ->display_as('bank_info', 'DD/TT/Cheque')
                ->display_as('bank_pay', 'Bank Collection')->order_by('memo_ID', 'desc')
                ->required_fields('contact_ID', 'issue_date');
        $crud->set_relation('contact_ID', 'pub_contacts', 'name');
        $crud->unset_add_fields('memo_serial');
        $crud->Set_save_and_print(TRUE);
        $crud->unset_back_to_list();
        $crud->unset_delete();
        if ($primary_id) {
            if (!in_array($primary_id, $this->Memo->last_memo_ID_of_each_contact_ID())) {
                if ($cmd == 'edit') {
                    die("<script>"
                            . "alert(' আপনি এই মেমোটি এডিট করতে পারবেন না । প্রয়োজনে এই  ক্রেতার সর্বশেষ  মেমোটি এডিট  করুন । ধন্যবাদ ।   ');"
                            . "window.location.assign( '" . site_url('admin/memo_management') . "');"
                            . "</script>");
                    $crud->unset_edit();
                }
                if ($cmd == 'delete') {
                    die("<script>"
                            . "alert('আপনি এই মেমোটি ডিলিট করতে পারবেন না । প্রয়োজনে এই  ক্রেতার সর্বশেষ  মেমোটি ডিলিট  করুন । ধন্যবাদ ।  ');"
                            . "window.location.assign( '" . site_url('admin/memo_management') . "');"
                            . "</script>");
                    $crud->unset_delete();
                }
            }
        }

        //date range config
        $data['date_range'] = $this->input->post('date_range');
        if ($data['date_range'] != '') {
            $this->session->set_userdata('date_range', $data['date_range']);
        }
        if ($cmd == 'reset_date_range') {
            $this->session->unset_userdata('date_range');
            redirect("admin/memo_management");
        }
        if ($this->session->userdata('date_range') != '') {
            $crud->where("DATE(issue_date) BETWEEN " . $this->Memo->dateformatter($this->session->userdata('date_range')));
            $data['date_range'] = $this->session->userdata('date_range');
        }

        $crud->callback_edit_field('memo_serial', function ($value, $primary_key) {
            $unique_id = $value;
            return '<label>' . $unique_id . '</label><input type="hidden" maxlength="50" value="' . $unique_id . '" name="memo_serial" >';
        });
        $crud->callback_add_field('sub_total', array($this->Memo, 'add_book_selector_table'))
                ->callback_edit_field('sub_total', array($this->Memo, 'edit_book_selector_table'))
                ->callback_after_insert(array($this->Memo, 'after_adding_memo'))
                ->callback_after_update(array($this->Memo, 'after_editing_memo'))
                ->callback_after_delete(array($this->Memo, 'after_deleting_memo'))
                ->add_action('Print', '', site_url('admin/memo/1'), 'fa fa-print', function ($primary_key, $row) {
                    return site_url('admin/memo/' . $row->memo_ID);
                });

        $crud->callback_column('sub_total', function ($value, $row) {
            return $this->Common->taka_format($row->sub_total);
        })->callback_column('discount', function ($value, $row) {
            return $this->Common->taka_format($row->discount);
        })->callback_column('book_return', function ($value, $row) {
            return $this->Common->taka_format($row->book_return);
        })->callback_column('dues_unpaid', function ($value, $row) {
            return $this->Common->taka_format($row->dues_unpaid);
        })->callback_column('total', function ($value, $row) {
            return $this->Common->taka_format($row->total);
        })->callback_column('cash', function ($value, $row) {
            return $this->Common->taka_format($row->cash);
        })->callback_column('bank_pay', function ($value, $row) {
            return $this->Common->taka_format($row->bank_pay);
        })->callback_column('due', function ($value, $row) {
            return $this->Common->taka_format($row->due);
        });

        $addContactButtonContent = anchor('admin/manage_contact/add', '<i class="fa fa-plus-circle"></i> Add New Contact', 'class="btn btn-default" style="margin-left: 15px;"');
        $data['scriptInline'] = ""
                . "<script>"
                . "var addContactButtonContent = '$addContactButtonContent';\n "
                . "var CurrentDate = '" . date("m/d/Y h:i:s a") . "';"
                . "var previousDueFinderUrl = '" . site_url("admin/previousDue/") . "';"
                . "</script>\n"
                . '<script type="text/javascript" src="' . base_url() . $this->config->item('ASSET_FOLDER') . 'js/Custom-main.js"></script>';
        $output = $crud->render();
//        $this->grocery_crud->set_table('pub_memos')->set_subject('Memo');
//        $output =  $this->grocery_crud->render();
        $data['date_filter'] = $cmd;
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Memo Management';
        $data['base_url'] = base_url();
        $this->load->view($this->config->item('ADMIN_THEME') . 'memo_management', $data);

        $this->Memo->clean_pub_memos_selected_books_db();
    }

}
