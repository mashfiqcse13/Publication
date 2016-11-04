<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Production_process
 *
 * @author MD. Mashfiq
 */
class Production_process extends CI_Controller {

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
        $this->load->model('Production_process_model');
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(15);
    }

    function index() {
        $this->process();
    }

    function process() {
        $data['production_process'] = $this->Production_process_model->get_all_production_process();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Production process';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/production_list', $data);
    }

    function add_processes() {
//        echo'<pre>';print_r($_POST);exit();
        $data['get_item'] = $this->Production_process_model->get_items();
        $data['get_vendor'] = $this->Production_process_model->get_vendor();

        $id_item = $this->input->post('id_item');
        $order_quantity = $this->input->post('order_quantity');
        $item_type = $this->input->post('item_type');
        $id_vendor = $this->input->post('id_vendor');

        $btn = $this->input->post('btn_submit');
        $list = $this->input->post('btn');
        $print = $this->input->post('print');
        if (!empty($print)) {
            $id_process_type = 2;
            $this->Production_process_model->add_process($id_item, $order_quantity, $item_type, $id_vendor, $id_process_type, TRUE);
        } else if (!empty($list)) {
            $this->Production_process_model->add_process($id_item, $order_quantity, $item_type, $id_vendor);
            redirect('production_process');
        }
//        if($btn){
//            $this->Production_process_model->save_processes($_POST);
//        }
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Production process';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/add_processes', $data);
    }

    function type() {
        $crud = new grocery_CRUD();
        $crud->set_table('process_type')
                ->set_subject('Production type')
                ->unset_add()->unset_edit()->unset_delete();
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Production type';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/manage_list', $data);
    }

    function vendor() {
        $crud = new grocery_CRUD();
        $crud->set_table('contact_vendor')
                ->set_subject('Vendor')->callback_add_field('division', array($this->Common, 'dropdown_division'))->order_by('id_vendor', 'desc')
                ->callback_edit_field('division', array($this->Common, 'dropdown_division'))
                ->callback_add_field('district', array($this->Common, 'dropdown_district'))
                ->callback_edit_field('district', array($this->Common, 'dropdown_district'))
                ->callback_add_field('upazila', array($this->Common, 'dropdown_upazila'))
                ->callback_edit_field('upazila', array($this->Common, 'dropdown_upazila'));
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Vendor';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/manage_list', $data);
    }

    function steps($id_processes) {
        $data['id_processes'] = $id_processes;
        $data['process_detail_table'] = $this->Production_process_model->process_detail_table($id_processes);
        $data['process_steps_table'] = $this->Production_process_model->process_steps_table($id_processes);
        $data['vendor_dropdown'] = $this->Production_process_model->get_vendor_dropdown_unused($id_processes);
        $data['vendor_dropdown_used_only_list'] = $this->Production_process_model->get_vendor_dropdown_used_only_list($id_processes);
        $data['step_name_dropdown'] = $this->Production_process_model->get_step_name_dropdown();
        $data['id_processes'] = $id_processes;
        $data['process_status'] = $this->Production_process_model->get_process_status_by_process_id($id_processes);

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Process steps';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/steps', $data);
    }

    function add_step() {
        $id_processes = $this->input->post('id_processes');
        $id_vendor = $this->input->post('id_vendor');
        $id_step_name = $this->input->post('id_step_name');
        $id_process_step_from = $this->input->post('id_process_step_from');

        if (!empty($id_processes) && !empty($id_vendor) && !empty($id_step_name)) {
            if (empty($id_process_step_from)) {
                $this->Production_process_model->add_process_step($id_processes, $id_vendor, $id_step_name);
            } else if ($id_process_step_from > 0) {
                $this->Production_process_model->add_process_step($id_processes, $id_vendor, $id_step_name, $id_process_step_from);
            }
        }
        redirect('production_process/steps/' . $id_processes);
    }

    function delete_step($id_processes, $id_process_steps) {
        $this->Production_process_model->delete_process_step($id_process_steps);
        redirect('production_process/steps/' . $id_processes);
    }

    function step_transfer($id_processes) {
        $id_process_step_from = $this->input->post('id_process_step_from');
        $amount_transfered = $this->input->post('amount_transfered');
        $rejected_amount = $this->input->post('rejected_amount');
        $damaged_amount = $this->input->post('damaged_amount');
        $missing_amount = $this->input->post('missing_amount');
        $amount_billed = empty($this->input->post('amount_billed')) ? 0 : $this->input->post('amount_billed');
        $amount_paid = empty($this->input->post('amount_paid')) ? 0 : $this->input->post('amount_paid');
        $id_vendor = $this->input->post('id_vendor');
        $id_step_name = $this->input->post('id_step_name');
        $id_process_step_to = $this->input->post('id_process_step_to');

        if (empty($id_process_step_to) && !empty($id_processes) && !empty($id_vendor) && !empty($id_step_name) && !empty($id_process_step_from)) {
            $id_process_step_to = $this->Production_process_model->add_process_step($id_processes, $id_vendor, $id_step_name, $id_process_step_from);
        }
        if (!empty($id_process_step_from)) {
            if (!empty($id_process_step_to)) {
                $id_process_step_transfer_log = $this->Production_process_model->step_transfer($id_process_step_from, $id_process_step_to, $amount_transfered, $rejected_amount, $damaged_amount, $missing_amount, $amount_billed, $amount_paid);
            } else {
                $id_process_step_transfer_log = $this->Production_process_model->step_transfer($id_process_step_from, FALSE, $amount_transfered, $rejected_amount, $damaged_amount, $missing_amount, $amount_billed, $amount_paid);
            }
        }
        $this->transfer_step_slip($id_process_step_transfer_log);
    }

    function change_status($id_processes, $status_code) {
        $this->Production_process_model->process_status_change($id_processes, $status_code);
        redirect('production_process/steps/' . $id_processes);
    }

    function production_report() {
        $id_processes = $this->input->get('id_processes');
        $from_id_vendor = $this->input->get('from_id_vendor');
        $id_item = $this->input->get('id_item');
        $item_type = $this->input->get('item_type');
        $to_id_vendor = $this->input->get('to_id_vendor');
        $id_process_type = $this->input->get('id_process_type');
        $data['date_range'] = $this->input->get('date_range');

        $data['get_process_type'] = $this->Production_process_model->get_process_type();
        $data['get_order_id'] = $this->Production_process_model->get_order_id();
        $data['get_vendor_from'] = $this->Production_process_model->get_vendor_from();
        $data['get_vendor_to'] = $this->Production_process_model->get_vendor_to();
        $data['get_item'] = $this->Production_process_model->get_item();

        $btn = $this->input->get('btn');
        if (isset($btn)) {
            $data['get_process_details_for_report_by_search'] = $this->Production_process_model->get_process_details_for_report_by_search($id_processes, $from_id_vendor, $id_item, $item_type, $to_id_vendor, $id_process_type, $data['date_range']);
//            print_r($data);exit();
        } else {
            $data['get_all_production_process'] = $this->Production_process_model->get_process_details_for_report();
        }

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Order Transfer Report';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/production_report', $data);
    }

    function production_report_first_step_only() {
        $id_processes = $this->input->get('id_processes');
        $id_vendor = $this->input->get('id_vendor');
        $id_item = $this->input->get('id_item');
        $item_type = $this->input->get('item_type');
        $id_process_type = $this->input->get('id_process_type');
        $data['date_range'] = $this->input->get('date_range');

        $data['get_process_type'] = $this->Production_process_model->get_process_type_first_step_only();
        $data['get_order_id'] = $this->Production_process_model->get_order_id_first_step_only();
        $data['get_vendor'] = $this->Production_process_model->get_vendor_first_step_only();
        $data['get_item'] = $this->Production_process_model->get_item_first_step_only();

        $btn = $this->input->get('btn');
        if (isset($btn)) {
            $data['all_production_process_first_step_info_by_search'] = $this->Production_process_model->get_process_step_details_for_report_by_search_first_step_only($id_processes, $id_vendor, $id_item, $item_type, $id_process_type, $data['date_range']);
        } else {
            $data['all_production_process_first_step_info'] = $this->Production_process_model->get_process_details_for_report_first_step_only();
        }

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Order Starting Report';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/production_report_first_step_only', $data);
    }

    function process_transection() {
        $id_process_step_from = $this->input->get('id_process_step_from');
        $btn = $this->input->get('btn');
        if (isset($btn)) {
            $data['get_process_details_for_report_by_step_from'] = $this->Production_process_model->get_process_details_for_report_by_step_from($id_process_step_from);
            $data['get_process_details_for_row'] = $this->Production_process_model->get_process_details_for_row($id_process_step_from);
//            print_r($data);exit();
        }

        $data['get_id_process_step_from'] = $this->Production_process_model->get_id_process_step_from();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Process Transfer Slip';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/process_transfer', $data);
    }

    function first_step_slip($id_process_steps) {

        $data['first_step_report'] = $this->Production_process_model->first_step_report($id_process_steps);
        // print_r($data['first_step_report'] );

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Process Transection';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/process_detail_report', $data);
    }

    function transfer_step_slip($id_process_step_transfer_log) {
        $data['transfer_step'] = $this->Production_process_model->transfer_step_report($id_process_step_transfer_log);
//       echo '<pre>';
//        print_r($data['transfer_step'] );

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Process Transection';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/process_detail_report', $data);
    }

    function transfer_slip($id_process_step_transfer_log) {
        $data['get_process_details_for_report_by_step_from'] = $this->Production_process_model->get_process_details_for_report_by_step_from($id_process_step_transfer_log);
        $data['get_process_details_for_row'] = $this->Production_process_model->get_process_details_for_row($id_process_step_transfer_log);
        if (empty($data['get_process_details_for_report_by_step_from'])) {
            ?>
            <script>
                alert("No transaction found");
                window.history.back();
            </script>
            <?php

        }

        $data['get_id_process_step_from'] = $this->Production_process_model->get_id_process_step_from();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Process Transfer Slip';
        $this->load->view($this->config->item('ADMIN_THEME') . 'production_process/transfer_slip', $data);
    }

}
