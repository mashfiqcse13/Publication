<?phpdefined('BASEPATH') OR exit('No direct script access allowed');/* * To change this license header, choose License Headers in Project Properties. * To change this template file, choose Tools | Templates * and open the template in the editor. *//** * Description of Admin * * @author MD. Mashfiq *///define('DASHBOARD', "$baseurl");class Admin extends CI_Controller {    //put your code here    function __construct() {        parent::__construct();        $this->load->library('tank_auth');        if (!$this->tank_auth->is_logged_in()) {         //not logged in            redirect('login');            return 0;        }        $this->load->library('grocery_CRUD');    }    function index() {        $this->load->model('account/account');        $data['account_today'] = $this->account->today();        $data['account_monthly'] = $this->account->monthly();        $data['total'] = $this->account->total();        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['base_url'] = base_url();        $data['Title'] = 'Dashboard';        $this->load->view($this->config->item('ADMIN_THEME') . 'dashboard', $data);    }    function manage_book() {        $crud = new grocery_CRUD();        $crud->set_table('pub_books')->set_subject('Book')->order_by('book_ID', 'desc')->display_as('price', 'Sales Price');        $crud->callback_add_field('catagory', function () {            return form_dropdown('catagory', $this->config->item('book_categories'), '0');        });        $crud->callback_add_field('storing_place', function () {            return form_dropdown('storing_place', $this->config->item('storing_place'));        });        $output = $crud->render();        $data['glosary'] = $output;        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['base_url'] = base_url();        $data['Title'] = 'Manage Book';        $this->load->view($this->config->item('ADMIN_THEME') . 'manage_book', $data);    }    function manage_contact() {        $crud = new grocery_CRUD();        $crud->set_table('pub_contacts')->set_subject('Contact')->order_by('contact_ID', 'desc');        $crud->callback_add_field('contact_type', function () {            return form_dropdown('contact_type', $this->config->item('contact_type'));        })->callback_edit_field('contact_type', function ($value, $primary_key) {            return form_dropdown('contact_type', $this->config->item('contact_type'), $value);        });        $crud->callback_add_field('district', function () {            return form_dropdown('district', $this->config->item('districts_english'), '', 'class="form-control select2" ');        })->callback_edit_field('district', function ($value, $primary_key) {            return form_dropdown('district', $this->config->item('districts_english'), $value);        });        $output = $crud->render();        $data['glosary'] = $output;        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['base_url'] = base_url();        $data['Title'] = 'Manage Contact';        $this->load->view($this->config->item('ADMIN_THEME') . 'manage_contact', $data);    }    function book_return() {        $this->load->model('Stock_manages');        $crud = new grocery_CRUD();        $crud->set_table('pub_books_return')->set_subject('Returned Book')                ->display_as('contact_ID', 'Party Name')                ->display_as('book_ID', 'Book');        $crud->set_relation('contact_ID', 'pub_contacts', 'name')                ->set_relation('book_ID', 'pub_books', 'name');        $crud->callback_after_insert(array($this, 'marge_insert_book'));        $output = $crud->render();        $data['scriptInline'] = '<script type="text/javascript" src="' . base_url() . $this->config->item('ASSET_FOLDER') . 'js/Custom-book_return.js"></script>';        $data['contact_dropdown'] = $this->Stock_manages->get_due_holder_dropdown();        $data['glosary'] = $output;        $data['total_book_return_section'] = true;        $data['book_returned_dropdown'] = $this->Stock_manages->get_book_returned_dropdown();        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['base_url'] = base_url();        $data['Title'] = 'Book Return';        $this->load->view($this->config->item('ADMIN_THEME') . 'manage_contact', $data);    }    function total_book_return($book_ID) {        $data = $this->db->select('sum(quantity)')                ->from('pub_books_return')                ->where('book_ID', $book_ID)                ->get()                ->result_array();        echo $data[0]['sum(quantity)'];    }    function marge_insert_book($post_array, $primary_key) {        $contact_ID = $post_array['contact_ID'];        $book_ID = $post_array['book_ID'];        $this->db->where('contact_ID', $contact_ID);        $this->db->where('book_ID', $book_ID);        $query = $this->db->get('pub_books_return');        foreach ($query->result() as $row) {            $new_quantity+=$row->quantity;        }        $this->db->where('contact_ID', $contact_ID);        $this->db->where('book_ID', $book_ID);        $this->db->delete('pub_books_return');        $data = array(            'contact_ID' => $contact_ID,            'book_ID' => $book_ID,            'quantity' => $new_quantity        );        $this->db->insert('pub_books_return', $data);        return true;    }    function print_last_memo() {        $this->db->select('LAST_INSERT_ID(`memo_ID`)');//        $this->db->select('LAST_INSERT_ID()');//        $this->db->insert_id('memo_ID');        $this->db->from('pub_memos');        $data = $this->db->get()->result_array();//        print_r($data);//        echo sizeof($data) - 1;        $last_inserted_memo_id = $data[sizeof($data) - 1]['LAST_INSERT_ID(`memo_ID`)'];        redirect('admin/memo/' . $last_inserted_memo_id);    }    function add_stock($process = false) {//         $crud = new grocery_CRUD();//         $crud->set_table('pub_stock')->set_subject('Stock');//         $crud->set_relation('book_ID', 'pub_books', 'name');//         $crud->set_relation('printing_press_ID', 'pub_contacts', 'name');// //        $crud->set_relation('binding_store_ID', 'pub_contacts', 'name');// //        $crud->set_relation('sales_store_ID', 'pub_contacts', 'name');//         $output = $crud->render();//         $data['glosary'] = $output;        //  'admin/ass_stock/true' aso ?        $this->load->model('stock_manages');        if ($process) {            $book_id = $this->input->post('book_id');            $printingpress_id = $this->input->post('printingpress_id');            $quantity = $this->input->post('quantity');            $this->stock_manages->append_new_stock($book_id, $printingpress_id, $quantity);            redirect('admin/manage_stocks');        }        $data['bookname'] = $this->stock_manages->get_bookid_dropdown();        $data['printingpress'] = $this->stock_manages->get_printingpress_dropdown();        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['base_url'] = base_url();        $data['Title'] = 'Manage Book';        $this->load->view($this->config->item('ADMIN_THEME') . 'stock_manage', $data);    }    function transfer_stock() {        $this->load->model('Stock_manages');        $this->Stock_manages->transfer_stock();        redirect('admin/manage_stocks');    }    function manage_stocks($transfer = false) {        $this->load->model('Stock_manages');        $crud = new grocery_CRUD();        $crud->set_table('pub_stock')->set_subject('Stock');        $crud->set_relation('book_ID', 'pub_books', 'name');        $crud->set_relation('printing_press_ID', 'pub_contacts', 'name');//        $crud->set_relation('binding_store_ID', 'pub_contacts', 'name');////        $crud->set_relation('sales_store_ID', 'pub_contacts', 'name');        $output = $crud->render();        $data['glosary'] = $output;        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['base_url'] = base_url();        $data['Title'] = 'Manage Stock';        $data['scriptInline'] = '<script>            jQuery(\'[data-StockId]\').click(function () {                var stock_id = $(this).attr("data-StockId");                var maxQuantity = $(this).attr("data-maxQuantity");                //console.log(stock_id);                jQuery(\'[name="stock_id_from"]\').val(stock_id);                jQuery(\'[name="Quantity"]\').attr("max",maxQuantity);            });        </script>';        $data['transfer_from_contact_dropdown'] = $this->Stock_manages->get_contact_dropdown();        $data['printing_table'] = $this->Stock_manages->get_stock_table();        $data['binding_table'] = $this->Stock_manages->get_stock_table('Binding Store');        $data['store_table'] = $this->Stock_manages->get_stock_table('Sales Store');        $this->load->view($this->config->item('ADMIN_THEME') . 'manage_stock', $data);    }    function test() {        $db_tables = $this->config->item('db_tables');        $this->db->select("{$db_tables['pub_books']}.* ,{$db_tables['pub_stock']}.Quantity  ");        $db_row = $this->db->from($db_tables['pub_books'])                        ->join("{$db_tables['pub_stock']}", "{$db_tables['pub_stock']}.book_ID = {$db_tables['pub_books']}.book_ID")                        ->join("{$db_tables['pub_contacts']}", "{$db_tables['pub_contacts']}.contact_ID = {$db_tables['pub_stock']}.printing_press_ID")                        ->where('contact_type', 'Sales Store')                        ->get()->result_array();        print_r($db_row);//        $this->db->query("SELECT * FROM `pub_books`")        $db_row = $this->db->query("SELECT * FROM `pub_books`")->result_array();        print_r($db_row);    }    function account() {//        $this->load->model('custom/stock_manage');        $this->load->model('account/account');        // $data['todaysell']=$this->account->todaysell();        // $data['monthly_sell']=$this->account->monthlysell();        // $data['today_due']=$this->account->today_due();        // $data['monthly_due']=$this->account->monthly_due();        // $data['total_cash_paid']=$this->account->total_cash_paid();        // $data['total_bank_pay']=$this->account->total_bank_pay();        // $data['total_due']=$this->account->total_due();        // $data['total_sell']=$this->account->totalsell();        $data['account_today'] = $this->account->today();        $data['account_monthly'] = $this->account->monthly();        $data['total'] = $this->account->total();        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['Title'] = 'Account Information';        $data['base_url'] = base_url();        $this->load->view($this->config->item('ADMIN_THEME') . 'account', $data);    }    function memo($memo_id) {        $this->load->model('Memo');        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['Title'] = 'Memo Generation';        $data['base_url'] = base_url();        $data['Book_selection_table'] = $this->Memo->memogenerat($memo_id);        $data['edit_btn_url'] = site_url('admin/memo_management/edit/' . $memo_id);        //$data['memo']=$this->Memo->memogenerat();        //var_dump($data['memo']);        //$this->Memo->memogenerat();        $this->load->view($this->config->item('ADMIN_THEME') . 'memo', $data);    }    function memo_management($cmd = false, $primary_id = false) {        $this->load->model('Memo');        $this->load->library('session');        $crud = new grocery_CRUD();        $crud->set_table('pub_memos')                ->set_subject('Memo')                ->display_as('contact_ID', 'Party Name')->order_by('memo_ID', 'desc');        $crud->set_relation('contact_ID', 'pub_contacts', 'name');        $crud->unset_add_fields('memo_serial');        $crud->Set_save_and_print(TRUE);        $crud->unset_back_to_list();        //date range config        $data['date_range'] = $this->input->post('date_range');        if ($data['date_range'] != '') {            $this->session->set_userdata('date_range', $data['date_range']);        }        if ($cmd == 'reset_date_range') {            $this->session->unset_userdata('date_range');            redirect("admin/memo_management");        }        if ($this->session->userdata('date_range') != '') {            $crud->where("issue_date BETWEEN " . $this->Memo->dateformatter($this->session->userdata('date_range')));            $data['date_range'] = $this->session->userdata('date_range');        }        $crud->callback_edit_field('memo_serial', function ($value, $primary_key) {            $unique_id = $value;            return '<label>' . $unique_id . '</label><input type="hidden" maxlength="50" value="' . $unique_id . '" name="memo_serial" >';        });        $crud->callback_add_field('sub_total', array($this, 'add_book_selector_table'));        $crud->callback_edit_field('sub_total', array($this, 'edit_book_selector_table'));        $crud->callback_after_insert(array($this, 'after_adding_memo'));        $crud->callback_after_update(array($this, 'after_editing_memo'));        $crud->callback_before_insert(array($this, 'before_adding_or_updating_memo'));        $crud->callback_before_update(array($this, 'before_adding_or_updating_memo'));        $crud->add_action('Print', '', site_url('admin/memo/1'), 'fa fa-print', function ($primary_key, $row) {            return site_url('admin/memo/' . $row->memo_ID);        });        $addContactButtonContent = anchor('admin/manage_contact/add', '<i class="fa fa-plus-circle"></i> Add New Contact', 'class="btn btn-default" style="margin-left: 15px;"');        $data['scriptInline'] = ""                . "<script>"                . "var addContactButtonContent = '$addContactButtonContent';\n "                . "var CurrentDate = '" . date("m/d/Y") . "';"                . "var previousDueFinderUrl = '" . site_url("admin/previousDue/") . "';"                . "</script>\n"                . '<script type="text/javascript" src="' . base_url() . $this->config->item('ASSET_FOLDER') . 'js/Custom-main.js"></script>';        $output = $crud->render();//        $this->grocery_crud->set_table('pub_memos')->set_subject('Memo');//        $output =  $this->grocery_crud->render();        $data['date_filter'] = $cmd;        $data['glosary'] = $output;        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['Title'] = 'Memo Management';        $data['base_url'] = base_url();        $this->load->view($this->config->item('ADMIN_THEME') . 'memo_management', $data);    }    function due_management($cmd = false) {        $this->load->model('Stock_manages');        $this->load->model('Memo');        $crud = new grocery_CRUD();        $crud->set_table('pub_memos')                ->set_subject('Memo')                ->display_as('contact_ID', 'Party Name')->order_by('memo_ID', 'desc')                ->unset_add()->unset_edit()->unset_delete()                ->where('due >', '0');        //date range config        $data['date_range'] = $this->input->post('date_range');        if ($data['date_range'] != '') {            $this->session->set_userdata('date_range', $data['date_range']);        }        if ($cmd == 'reset_date_range') {            $this->session->unset_userdata('date_range');            redirect("admin/due_management");        }        if ($this->session->userdata('date_range') != '') {            $crud->where("issue_date BETWEEN " . $this->Memo->dateformatter($this->session->userdata('date_range')));            $data['date_range'] = $this->session->userdata('date_range');        }        $crud->set_relation('contact_ID', 'pub_contacts', 'name');        $crud->add_action('Update', '', site_url('admin/memo/'), 'fa fa-edit', function ($primary_key, $row) {            return site_url('admin/memo_management/edit/' . $row->memo_ID);        })->add_action('Print', '', site_url('admin/memo/'), 'fa fa-print', function ($primary_key, $row) {            return site_url('admin/memo/' . $row->memo_ID);        });        $output = $crud->render();        $data['scriptInline'] = '<script type="text/javascript" src="' . base_url() . $this->config->item('ASSET_FOLDER') . 'js/Custom-due_management.js"></script>';        $data['contact_dropdown'] = $this->Stock_manages->get_due_holder_dropdown();        $data['date_filter'] = $cmd;        $data['total_due_section'] = TRUE;        $data['glosary'] = $output;        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');        $data['Title'] = 'Due  Management';        $data['base_url'] = base_url();        $this->load->view($this->config->item('ADMIN_THEME') . 'memo_management', $data);    }    function total_due($contact_id) {        $data = $this->db->select('sum(due)')                ->from('pub_memos')                ->where('contact_ID', $contact_id)                ->get()                ->result_array();        echo $data[0]['sum(due)'];    }    function add_book_selector_table() {        $this->load->library('table');        // Getting Data//        $query = $this->db->query("SELECT * FROM `pub_books`");        $db_tables = $this->config->item('db_tables');        $this->db->select("{$db_tables['pub_books']}.* ,{$db_tables['pub_stock']}.Quantity  ");        $query = $this->db->from($db_tables['pub_books'])                ->join("{$db_tables['pub_stock']}", "{$db_tables['pub_stock']}.book_ID = {$db_tables['pub_books']}.book_ID")                ->join("{$db_tables['pub_contacts']}", "{$db_tables['pub_contacts']}.contact_ID = {$db_tables['pub_stock']}.printing_press_ID")                ->where('contact_type', 'Sales Store')                ->get();        $data = array();        foreach ($query->result_array() as $index => $row) {            array_push($data, [$row['name'], $row['book_price'],                $row['price'],                '<input style="width: 100px;" data-index="' . $index . '" data-price="' . $row['price'] . '" name="quantity[' . $row['book_ID'] . ']" min="0" max="' . $row['Quantity'] . '" value="0" class="numeric form-control" type="number">'                . '     <input name="price[' . $row['book_ID'] . ']" value="' . $row['price'] . '" type="hidden">'            ]);        }        $this->table->set_heading('Book Name', 'Book Price', 'Sales Price', 'Quantity');        //Setting table template        $tmpl = array(            'table_open' => '<table class="table table-bordered table-striped">',            'heading_cell_start' => '<th class="success">'        );        $this->table->set_template($tmpl);        $output = '<label>Select Book Quantity:</label><div style="overflow-y:scroll;max-height:335px;">                    ' . $this->table->generate($data) . '</div>                   <label>Sub Total :</label><span id="sub_total">0</span><span>Tk</span> <input type="hidden" maxlength="50  " name="sub_total">';        $output.=""                . "<script>"                . "var memo_ID='';"                . "</script>\n";        return $output;    }    function edit_book_selector_table($value, $primary_key) {        $this->load->library('table');        // Getting Data        $where = array('memo_ID' => $primary_key);        $book_selection_query = $this->db->get_where('pub_memos_selected_books', $where);        $book_selection = $book_selection_query->result_array();        foreach ($book_selection as $index => $row) {            $book_ID = $row['book_ID'];            $quantity = $row['quantity'];            $book_quantity_by_id[$book_ID] = $quantity;        }//        Getting the books (not stock restricted)//        $query = $this->db->query("SELECT * FROM `pub_books`");//        Getting the books (stock restricted)        $db_tables = $this->config->item('db_tables');        $this->db->select("{$db_tables['pub_books']}.* ,{$db_tables['pub_stock']}.Quantity  ");        $query = $this->db->from($db_tables['pub_books'])                ->join("{$db_tables['pub_stock']}", "{$db_tables['pub_stock']}.book_ID = {$db_tables['pub_books']}.book_ID")                ->join("{$db_tables['pub_contacts']}", "{$db_tables['pub_contacts']}.contact_ID = {$db_tables['pub_stock']}.printing_press_ID")                ->where('contact_type', 'Sales Store')                ->get();        $data = array();        foreach ($query->result_array() as $index => $row) {            $book_quantity_by_id[$row['book_ID']] = isset($book_quantity_by_id[$row['book_ID']]) ? $book_quantity_by_id[$row['book_ID']] : 0;            array_push($data, [$row['name'], $row['book_price'],                $row['price'],                '<input style="width: 100px;" data-index="' . $index . '" data-price="' . $row['price'] . '" name="quantity[' . $row['book_ID'] . ']" value="' . $book_quantity_by_id[$row['book_ID']] . '" min="0" max="' . $row['Quantity'] . '"  class="numeric form-control" type="number">'                . '     <input name="price[' . $row['book_ID'] . ']" value="' . $row['price'] . '" type="hidden">'            ]);        }        $this->table->set_heading('Book Name', 'Book Price', 'Sales Price', 'Quantity');        //Setting table template        $tmpl = array(            'table_open' => '<table class="table table-bordered table-striped">',            'heading_cell_start' => '<th class="success">'        );        $this->table->set_template($tmpl);        $output = '<label>Select Book Quantity:</label><div style="overflow-y:scroll;max-height:335px;">                    ' . $this->table->generate($data) . '</div>                   <label>Sub Total :</label><span id="sub_total">' . $value . '</span><span>Tk</span> <input type="hidden" maxlength="50" value="' . $value . '" name="sub_total">';        $output.=""                . "<script>"                . "var memo_ID='" . $primary_key . "';"                . "</script>\n";        return $output;    }    function after_adding_memo($post_array, $primary_key) {        $data = array(            'memo_serial' => $primary_key,        );        $this->db->where('memo_ID', $primary_key);        $this->db->update('pub_memos', $data);        return $this->after_editing_memo($post_array, $primary_key);    }    function after_editing_memo($post_array, $primary_key) {        $this->db->where('memo_ID', $primary_key);        $this->db->delete('pub_memos_selected_books');        foreach ($post_array['quantity'] as $index => $value) {            if ($value <= 0)                continue;            $book_ordered_quantity_insert = array(                "memo_ID" => $primary_key,                "book_ID" => $index,                "quantity" => $value,                "price_per_book" => $post_array['price'][$index],                "total" => $value * $post_array['price'][$index]            );            $this->db->insert('pub_memos_selected_books', $book_ordered_quantity_insert);        }        return TRUE;    }    function before_adding_or_updating_memo($post_array, $primary_key = false) {        $data = array(            'dues_unpaid' => 0        );        $this->db->where('contact_ID', $post_array['contact_ID']);        $this->db->update($this->config->item('db_tables')['pub_memos'], $data);    }    //    Getting the previous due and make other row's due 0    function previousDue($contact_ID = 2, $memo_ID = FALSE) {//        echo site_url("admin/previousDue/$id");        $this->db->select_sum('due');        $where_conditions = array(            'contact_ID' => $contact_ID        );        if ($memo_ID) {            $where_conditions = array(                'contact_ID' => $contact_ID,                'memo_ID !=' => $memo_ID            );        }        $this->db->where($where_conditions);        $query = $this->db->get($this->config->item('db_tables')['pub_memos']);        echo $query->result_array()[0]['due'];//        print_r($query->result_array());    }    //    Getting the previous due and make other row's due 0    function previousDueTest($contact_ID = 2, $memo_ID = false) {        $this->load->library('table');//        echo site_url("admin/previousDue/$id");//        $this->db->select_sum('due');        $where_conditions = array(            'contact_ID' => $contact_ID        );        if ($memo_ID) {            $where_conditions = array(                'memo_ID !=' => $memo_ID            );        }        $this->db->where($where_conditions);        $query = $this->db->get($this->config->item('db_tables')['pub_memos']);        //print_r($query->result_array());        echo "<br>";        echo $this->table->generate($query->result_array());    }}