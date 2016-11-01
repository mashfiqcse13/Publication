<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Stock
 *
 * @author sonjoy
 */
class Stock extends CI_Controller {

//put your code here

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('Common');
        $this->load->model('Stock_model');
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(23);
    }

    function index() {
        $super_user_id = $this->config->item('super_user_id');
        if ($super_user_id == $_SESSION['user_id']) {
            redirect('stock/stock_perpetual');
        } else if ($this->User_access_model->if_user_has_permission(36)) {
            redirect('stock/stock_perpetual');
        } else if ($this->User_access_model->if_user_has_permission(35)) {
            redirect('stock/final_stock');
        } else {
            redirect();
        }
    }

    function stock_perpetual($cmd = false) {
        $this->User_access_model->check_user_access(36, 'stock');
        $data['stock_info'] = $this->Stock_model->select_stock();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Stock Perpitual';

        $crud = new grocery_CRUD();
        $crud->set_table('stock_perpetual_stock_register')
                ->columns("Item_ID", "id_item", "opening_amount", "receive_amount", "sales_amount", "specimen", "specimen_returned", "return_amountreject", "reject_amount", "closing_stock", "date")
                ->callback_column("Item_ID", function ($value, $row) {
                    return $row->id_item;
                })
                ->set_subject('Stock Perpitual')->display_as('return_amountreject', 'Sales Return Amount')->display_as('id_item', 'Item Name')
                ->set_relation('id_item', 'items', 'name')->unset_columns('reject_amount')
                ->order_by('id_perpetual_stock_register', 'desc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();

        $data['date_range'] = $this->input->get('date_range');
        $date = explode('-', $data['date_range']);
        if ($data['date_range'] != '') {
//            $get_where_clause = $this->Stock_model->get_where_clause($date[0], $date[1]);
//            $crud->where($get_where_clause);
            $data['stock_perpetual'] = $this->Stock_model->get_perpetual_info($date[0], $date[1]);
            $data['old_info'] = $this->Stock_model->old_book_quantity($date[0], $date[1]);
            $this->load->model('Specimen_model');
            $data['return_specimen'] = $this->Specimen_model->get_report_table_return($data['id_agent'] = '', $data['id_item'] = '', $data['date_range']);
//print_r($data['report2']  );
        }

        $output = $crud->render();
        $data['glosary'] = $output;


        $this->load->view($this->config->item('ADMIN_THEME') . 'stock/stock_perpetual', $data);
    }

    function final_stock() {
        $this->User_access_model->check_user_access(35, 'stock');
        $id_item = $this->input->post('id_item');
        $amount = $this->input->post('amount');
        if (!empty($id_item) && !empty($amount)) {
            $this->load->model('misc/Stock_perpetual');
            $this->Stock_perpetual->Stock_perpetual_register($id_item, $amount, 0);
            $this->Stock_model->stock_add($id_item, $amount) or die('failed');
            redirect(current_url());
            die();
        }

        $data['item_dropdown'] = $this->Common->get_item_dropdown();

        $crud = new grocery_CRUD();
        $crud->set_table('stock_final_stock')
                ->columns("Item_ID", "id_item", "total_in", "total_out", "total_in_hand")->callback_column("Item_ID", function ($value, $row) {
                    return $row->id_item;
                })
                ->set_subject('Final stock')
                ->set_relation('id_item', 'items', 'name')
                ->order_by('stock_final_stock.id_item', 'ASC')->display_as('id_item', 'Item Name')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Final stock';
        $this->load->view($this->config->item('ADMIN_THEME') . 'stock/final_stock', $data);
    }

}
