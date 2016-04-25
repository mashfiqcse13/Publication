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

    function index() {
        $this->load->model('misc/Cash');
//        $this->Cash->add(1000);
//        $this->Cash->reduce(3000) or die("Not enough balance");
        $this->load->model('misc/Customer_due');
//        $this->Customer_due->add(4, 1000);
        $this->Customer_due->reduce(4, 1000) or die("Not enough due");
    }

}
