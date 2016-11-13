<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is used for testing purpose only
 *
 * @author MD. Mashfiq
 */
class Test extends CI_Controller {

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
    }

    /*
     * Do not push this file by keeping your test code, you will use this file for your personal testing .
     */
    function index() {
        $this->load->model('Regenerate_model');
        echo $this->Regenerate_model->master_reconcilation_as_table();
    }

}
