<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Commonmodel', 'Common');
        $this->data['view'] = $this->data['controller'] . '/' . $this->data['method'];
        $this->clear_cache();
        $this->check_login(0);
    }

    /* ------------------- END BLOCK ------------------- */

    /**
     * 
     */
    public function index() {
         
        $this->load->view('common/header', $this->data);
        $this->load->view($this->data['view'], $this->data);
        $this->load->view('common/footer', $this->data);
    }
}
