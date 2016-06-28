<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Test
 *
 * @author MD. Mashfiq
 */
class Test extends CI_Controller {

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
    }

    function index($date_from, $date_to) {
//        $date_from = '2016-05-01';
//        $date_to = '2016-05-31';
        $this->load->model('account/account');
        echo $this->account->get_due($date_from, $date_to,2);
    }

}
