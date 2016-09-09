<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Specimen
 *
 * @author MD. Mashfiq
 */
class Specimen extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->library('grocery_CRUD');
        $this->load->model('Sales_model');
        $this->load->model('Common');
        $this->load->model('Specimen_model');
        $this->load->library('table');
        $this->load->model('User_access_model');
        $super_user_id = $this->config->item('super_user_id');
        if($super_user_id != $_SESSION['user_id'] || $this->User_access_model->if_user_has_permission(21)){
            redirect();
            return 0;
        }
    }

    function index() {
        $this->new_entry();
    }

    function ajax_url() {
//        echo json_encode($_POST);
        $this->Specimen_model->processing_new_specimen();
    }
    
     function specimen_return_ajax_url() {
//        echo json_encode($_POST);
        $this->Specimen_model->processing_return_specimen();
    }

    function new_entry() {
        $data['agent_dropdown'] = $this->Specimen_model->get_agent_dropdown();
        $data['item_dropdown'] = $this->Sales_model->get_available_item_dropdown();
        $data['item_details'] = $this->Sales_model->get_item_details();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New specimen entry';
        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/new_entry_form', $data);
    }

    function items($id_specimen_total = '') {
        $crud = new grocery_CRUD();
        $crud->set_table('specimen_items')
                ->set_subject('Specimen Items')
                ->display_as('specimen_items_id', 'ID')
                ->set_relation('id_item', 'items', 'name')
                ->order_by('specimen_items_id', 'desc')
                ->unset_edit()
                ->unset_delete()
                ->unset_add();
        if (!empty($id_specimen_total)) {
            $crud->where('id_specimen_total', $id_specimen_total);
        }

        $output = $crud->render();
        $data['glosary'] = $output;
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Teachers';
        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/manage_list', $data);
    }

    function tolal() {
        $crud = new grocery_CRUD();
        $crud->set_table('specimen_total')
                ->display_as('id_specimen_total', 'Specimen Total ID')
                ->display_as('id_agent', 'Name')
                ->display_as('id_employee', 'Approved by')
                ->columns('id_specimen_total', 'id_agent', 'date_entry', 'id_employee')
                ->set_subject('Total specimen')
                ->set_relation('id_agent', 'specimen_agent', 'name')
                ->set_relation('id_employee', 'users', 'username')
                ->order_by('id_specimen_total', 'desc')
                ->unset_edit()->unset_delete()->unset_add()->unset_read()
                ->add_action(' ', '', '', 'fa fa-print', function ($primary_key, $row) {
                    return site_url('specimen/memo/' . $primary_key);
                });
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Total specimen';
        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/manage_list', $data);
    }

    function report() {
        $data['agent_dropdown'] = $this->Specimen_model->get_agent_dropdown_who_have_taken_specimen();
        $data['item_dropdown'] = $this->Specimen_model->get_item_dropdown_who_are_given_as_specimen();

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Specimen Issue Report';

        $data['id_agent'] = $this->input->post('id_agent');
        $data['id_item'] = $this->input->post('id_item');
        $data['date_range'] = $this->input->post('date_range');
        $data['report_asked'] = $this->input->post('report_asked');

        if (!empty($data['report_asked'])) {
            $data['report1'] = $this->Specimen_model->get_report_table_issue($data['id_agent'], $data['id_item'], $data['date_range']);
            $data['report2'] = $this->Specimen_model->get_report_table_return($data['id_agent'], $data['id_item'], $data['date_range']);
            
            $data['agent_name'] = $this->Specimen_model->get_agent_name_by($data['id_agent']) or
                    $data['agent_name'] = 'Any';
            $data['item_name'] = $this->Common->get_item_name_by($data['id_item']) or
                    $data['item_name'] = 'Any';
//            echo '<pre>';
//            print_r($data);
            $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/report_filter', $data);
        } else {
            $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/report_filter', $data);
            
        }
    }
    
    function specimen_return(){ 
        
        
        
        $data['get_specimen_dropdown'] = $this->Specimen_model->get_specimen_dropdown();
        
        $search_memo=$this->input->post('memo_search');
        $memo_id=$this->input->post('id_specimen_total');
        
        if(isset($search_memo)){        
            $data['item_details'] = $this->Specimen_model->get_item_details_from_specimen_items($memo_id);
            $id='';
            foreach($data['item_details'] as $row){
                $id=$row['id_agent'];
            }
             $data['agent_dropdown'] = $this->Specimen_model->get_agent_dropdown_by_id($id);
             $data['item_dropdown'] = $this->Specimen_model->get_available_specimen_item_dropdown($memo_id);
             $data['memo_id']=$memo_id;
        }
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'New specimen entry';
        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/specimen_return', $data);
        
    }

    function memo($id_specimen_total) {

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Memo Generation';
        $data['base_url'] = base_url();
        $data['memo_header_details'] = $this->Specimen_model->specimen_memo_header_details($id_specimen_total);
        $data['memo_body_table'] = $this->Specimen_model->memo_body_table($id_specimen_total);

        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/memo', $data);
    }
    
     function return_memo($id_specimen_total) {

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Specimen Return Memo Generation';
        $data['base_url'] = base_url();
        $data['memo_header_details'] = $this->Specimen_model->return_specimen_memo_header_details($id_specimen_total);
        $data['memo_body_table'] = $this->Specimen_model->return_memo_body_table($id_specimen_total);

        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/return_memo', $data);
    }
    
    
    function specimen_return_list(){
        $crud = new grocery_CRUD();
        $crud->set_table('specimen_return_total')
                ->display_as('id_specimen_total', 'Specimen Return ID')
                ->display_as('id_agent', 'Name')
                ->display_as('id_employee', 'Approved by')
                ->columns('id_specimen_total', 'id_agent', 'date_entry', 'id_employee')
                ->set_subject('Return specimen')
                ->set_relation('id_agent', 'specimen_agent', 'name')
                ->set_relation('id_employee', 'users', 'username')
                ->order_by('id_specimen_total', 'desc')
                ->unset_edit()->unset_delete()->unset_add()->unset_read()
                ->add_action(' ', '', '', 'fa fa-print', function ($primary_key, $row) {
                    return site_url('specimen/return_memo/' . $primary_key);
                }); 
        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Specimen Return List';
        $this->load->view($this->config->item('ADMIN_THEME') . 'specimen/specimen_return_list', $data);
    }

}
