<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Supply_info
 *
 * @author sonjoy
 */
class Supply_info extends CI_Controller {
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
        $this->load->model('Supply_info_model');
    }
    
    
    function index(){
        $crud = new grocery_CRUD();
        $crud->set_table('supply_info')
                ->set_subject('Supply Info');
        $output = $crud->render();
        $data['glosary'] = $output;
        $data['all_style_no'] = $this->Supply_info_model->select_all_by_technician_id();
        $data['all_session'] = $this->Supply_info_model->select_all('supply_session');
        $data['all_department'] = $this->Supply_info_model->select_all('department');
        $data['all_supplyer'] = $this->Supply_info_model->select_all('supplyer');
        $data['all_fit_name'] = $this->Supply_info_model->select_all('supply_fit_name');
        $supply_id = $this->uri->segment(4);
        $data['all_supply_info'] = $this->Supply_info_model->supply_info_by_supply_id($supply_id);
//        echo '<pre>';print_r($data['all_supply_info']);exit();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['Title'] = 'Insert Info';
        $data['base_url'] = base_url();
        $this->load->view($this->config->item('ADMIN_THEME') . 'supply_info/supply_info', $data);
    }
    
    function fit_info(){
        $id = $this->input->post('id_supply_fit_name');
        $data['supply_fit'] = $this->Supply_info_model->select_fit_name_by_fit_id($id);
//        echo '<pre>';print_r($data['supply_fit']);exit();
        echo json_encode($data);
    }
    
    function save_info(){
        $data['id_supply_style_no'] = $this->input->post('id_supply_style_no');
        $data['id_supply_session'] = $this->input->post('id_supply_session');
        $data['id_department'] = $this->input->post('id_department');
        $data['style_description'] = $this->input->post('style_description');
        $data['id_supplyer'] = $this->input->post('id_supplyer');
        $data['sample_result'] = $this->input->post('sample_result');
        $data['approved_by'] = $this->input->post('approved_by');
        $data['id_technician'] = $this->session->userdata('technician_id');
        $data['lab_test_report'] = $this->input->post('lab_test_report');
        $data['pattern_block'] = $this->input->post('pattern_block');
        $data['date_created'] = date('Y-m-d H:i:s');
        $data['remark'] = $this->input->post('remark');
        $supply_info_id = $this->Supply_info_model->save_info('supply_info',$data);
        
        $fit['id_supply_info'] = $supply_info_id;
        $fit['id_supply_fit_name'] = $this->input->post('id_supply_fit_name');
        $fit['supply_fit_register_date_send'] = date('Y-m-d H:i:s',strtotime($this->input->post('supply_fit_register_date_send')));
        $fit['supply_fit_register_date_receive'] = date('Y-m-d H:i:s',strtotime($this->input->post('supply_fit_register_date_receive')));
//        echo '<pre>'; print_r($fit);exit();
        $this->Supply_info_model->save_info('supply_fit_register',$fit);
        redirect('supply_info');
    }
    function update_info(){
        $id = $this->input->post('id_supply_info');
        $data['id_supply_style_no'] = $this->input->post('id_supply_style_no');
        $data['id_supply_session'] = $this->input->post('id_supply_session');
        $data['id_department'] = $this->input->post('id_department');
        $data['style_description'] = $this->input->post('style_description');
        $data['id_supplyer'] = $this->input->post('id_supplyer');
        $data['sample_result'] = $this->input->post('sample_result');
        $data['approved_by'] = $this->input->post('approved_by');
        $data['id_technician'] = $this->session->userdata('technician_id');
        $data['lab_test_report'] = $this->input->post('lab_test_report');
        $data['pattern_block'] = $this->input->post('pattern_block');
        $data['date_created'] = date('Y-m-d H:i:s');
        $data['remark'] = $this->input->post('remark');
        $supply_info_id = $this->Supply_info_model->update_info('supply_info','id_supply_info',$data,$id);
//        echo '<pre>'; print_r($supply_info_id);exit();
        $id_fit = $this->input->post('id_supply_fit_register');
        $fit['id_supply_info'] = $supply_info_id->id_supply_info;
        $fit['id_supply_fit_name'] = $this->input->post('id_supply_fit_name');
        $fit['supply_fit_register_date_send'] = date('Y-m-d H:i:s',strtotime($this->input->post('supply_fit_register_date_send')));
        $fit['supply_fit_register_date_receive'] = date('Y-m-d H:i:s',strtotime($this->input->post('supply_fit_register_date_receive')));
//        echo '<pre>'; print_r($fit);exit();
        $this->Supply_info_model->update_info('supply_fit_register','id_supply_fit_register',$fit,$id_fit);
        redirect('supply_info');
    }
}
