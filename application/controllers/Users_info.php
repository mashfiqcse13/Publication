<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_info extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('security');
        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {         //not logged in
            redirect('login');
            return 0;
        }
        $this->load->model('tank_auth/users', 'users');
        $this->load->model('user_access_model');
        $this->lang->load('tank_auth');
        $this->load->model('User_access_model');
        $this->User_access_model->check_user_access(24);
    }

    function index() {
        redirect('users_info/user_list');
    }

    function success() {
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Users';
        if ($message = $this->session->flashdata('message')) {
            $this->load->view('auth/general_message', array('message' => $message));
        } else {
            redirect('/users_info/add_user/');
        }

        $this->load->view($this->config->item('ADMIN_THEME') . 'user/success', $data);
    }

    function user_list() {
        $data['user_info'] = $this->users->get_users();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Users';

        $this->load->view($this->config->item('ADMIN_THEME') . 'user/users_list', $data);
    }

    function add_user() {
        if ($this->tank_auth->is_logged_in(FALSE)) {      // logged in, not activated
            redirect('/auth/send_again/');
        } else {
            $use_username = $this->config->item('use_username', 'tank_auth');
            if ($use_username) {
                $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[' . $this->config->item('username_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('username_max_length', 'tank_auth') . ']|alpha_dash');
            }
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

            $captcha_registration = $this->config->item('captcha_registration', 'tank_auth');
            $use_recaptcha = $this->config->item('use_recaptcha', 'tank_auth');
            if ($captcha_registration) {
                if ($use_recaptcha) {
                    $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
                } else {
                    $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
                }
            }
            $data['errors'] = array();

            $email_activation = $this->config->item('email_activation', 'tank_auth');

            if ($this->form_validation->run()) {        // validation ok
                if (!is_null($data = $this->tank_auth->create_user(
                                $use_username ? $this->form_validation->set_value('username') : '', $this->form_validation->set_value('email'), $this->form_validation->set_value('password'), $email_activation))) {         // success
                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                    if ($email_activation) {         // send "activate" email
                        $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

                        $this->_send_email('activate', $data['email'], $data);

                        unset($data['password']); // Clear password (just for any case)

                        $this->_show_message($this->lang->line('auth_message_registration_completed_1'));
                    } else {
                        if ($this->config->item('email_account_details', 'tank_auth')) { // send "welcome" email
                            $this->_send_email('welcome', $data['email'], $data);
                        }
                        unset($data['password']); // Clear password (just for any case)

                        $this->_show_message($this->lang->line('auth_message_registration_completed_2') . ' ' . anchor('/auth/login/', 'Login'));
                    }
                } else {
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v)
                        $data['errors'][$k] = $this->lang->line($v);
                }
            }
            if ($captcha_registration) {
                if ($use_recaptcha) {
                    $data['recaptcha_html'] = $this->_create_recaptcha();
                } else {
                    $data['captcha_html'] = $this->_create_captcha();
                }
            }

            $data['use_username'] = $use_username;
            $data['captcha_registration'] = $captcha_registration;
            $data['use_recaptcha'] = $use_recaptcha;
            $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
            $data['base_url'] = base_url();
            $data['Title'] = 'Manage Users';




            $this->load->view($this->config->item('ADMIN_THEME') . 'user/add_user', $data);
        }
    }

    function update_user($id) {
        $data['users'] = $this->users->get_users_by_user_id($id);
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'Manage Users';

        $this->load->view($this->config->item('ADMIN_THEME') . 'user/update_user', $data);
    }

    function updata_data() {
        //echo '<pre>'; print_r($_POST);exit();
        $id = $this->input->post('id');
//        $user['username'] = 'trim|required|xss_clean|min_length[' . $this->config->item('username_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('username_max_length', 'tank_auth') . ']|alpha_dash';
//        $user['email'] = 'trim|required|xss_clean|valid_email';
//        $user['password'] = 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash';
//        $user['confirm_password'] = 'trim|required|xss_clean|matches[password]';
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[' . $this->config->item('username_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('username_max_length', 'tank_auth') . ']|alpha_dash');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
        $this->form_validation->set_rules('activated', 'Activated', 'trim|required|xss_clean');
//        $this->form_validation->set_rules($user);
        if ($this->form_validation->run() == FALSE) {
//            redirect('users_info/update_user/' . $id);
            return $this->update_user($id);
        } else {
            $user['username'] = $this->input->post('username');
            $user['email'] = $this->input->post('email');
            $password = $this->input->post('password');
            $hasher = new PasswordHash(
                    $this->config->item('phpass_hash_strength', 'tank_auth'), $this->config->item('phpass_hash_portable', 'tank_auth')
            );
            $user['password'] = $hasher->HashPassword($password);
            $user['activated'] = $this->input->post('activated');
            $this->users->update_user($user, $id);
            redirect('users_info/user_list');
        }
    }

    function delete_user($id) {
        $this->users->delete_user($id);
        redirect('users_info/user_list');
    }

    function _show_message($message) {
        $this->session->set_flashdata('message', $message);
        redirect('users_info/success');
    }

    function _send_email($type, $email, &$data) {
        $this->load->library('email');
        $this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->to($email);
        $this->email->subject(sprintf($this->lang->line('auth_subject_' . $type), $this->config->item('website_name', 'tank_auth')));
        $this->email->message($this->load->view('email/' . $type . '-html', $data, TRUE));
        $this->email->set_alt_message($this->load->view('email/' . $type . '-txt', $data, TRUE));
        $this->email->send();
    }

    function user_access_group() {

        $this->load->model('user_access_model');
        $data['access_area'] = $this->user_access_model->get_user_access_area();
        $btn = $this->input->post('btn_submit');
        if ($btn) {

            $data['insert'] = $this->user_access_model->insert_access_group($_POST);
            //$access_area=$this->input->post('access_area');
        }
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'User Access Group';
        $this->load->view($this->config->item('ADMIN_THEME') . 'user/access_group', $data);
    }

    function user_access_group_list() {
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table('user_access_group')
                ->unset_add()
                ->unset_delete();

        $output = $crud->render();
        $data['glosary'] = $output;


        $data['access_area'] = $this->user_access_model->get_user_access_area();
        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'User Access Group';
        if ($this->uri->segment(3) == 'edit') {
            $data['Title'] = 'User Access Group Edit';
        }

        $btn = $this->input->post('btn_submit');
        if ($btn) {
            $data['update'] = $this->user_access_model->update_access_group($_POST);
            //$access_area=$this->input->post('access_area');
        }

        if ($this->uri->segment(3) == 'edit') {
            $update_id = $this->uri->segment(4);
            $data['get_all_group_info'] = $this->user_access_model->get_all_group_info_by_id($update_id);
            $id_user_group = $data['get_all_group_info'][0]->id_user_access_group;
            $data['get_all_access_area'] = $this->user_access_model->get_all_access_area_by_access_id($id_user_group);
        }
//        print_r($data['get_all_access_area_max']);exit();
        $this->load->view($this->config->item('ADMIN_THEME') . 'user/access_group_list', $data);
    }

    function user_access_area() {
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table('user_access_area')
                ->unset_add()->unset_delete();

        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'User Access';
        $this->load->view($this->config->item('ADMIN_THEME') . 'user/access_area', $data);
    }

    function user_group_element() {
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table('user_group_elements')
                ->set_relation('id_user_access_group', 'user_access_group', 'user_access_group_title')
                ->set_relation('id_user_access_area', 'user_access_area', 'user_access_area_title')
                ->display_as('id_user_access_group', 'User Group Name')->order_by('id_user_access_group')
//                ->unset_add()
                //->unset_edit()
                //->unset_delete()
                ->display_as('id_user_access_area', 'User Access Area Name');

        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'User Access element';
        $this->load->view($this->config->item('ADMIN_THEME') . 'user/access_group_element', $data);
    }

    function user_group_assign_to_user() {
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table('user_access_area_permission')
                ->set_relation('id_user_access_group', 'user_access_group', 'user_access_group_title')
                ->set_relation('user_id', 'users', 'username')
                ->display_as('id_user_access_group', 'User Group Name')
                ->display_as('user_id', 'User Name')->order_by('id_user_access_group');

        $output = $crud->render();
        $data['glosary'] = $output;

        $data['theme_asset_url'] = base_url() . $this->config->item('THEME_ASSET');
        $data['base_url'] = base_url();
        $data['Title'] = 'User Group Allocation';
        $this->load->view($this->config->item('ADMIN_THEME') . 'user/access_group_element', $data);
    }

}
