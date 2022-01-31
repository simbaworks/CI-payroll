<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->data['view'] = $this->data['controller'] . '/' . $this->data['method'];
        $this->check_login();
    }

    /* ------------------- END BLOCK ------------------- */

    /**
     * 
     */
    public function index() {
        if ($this->session->userdata($this->data['sess_code'] . 'admin_id')) {
            foreach ($this->session->all_userdata() as $key => $value) {
                if (strpos($key, $this->data['sess_code']) !== false) {
                    $this->session->unset_userdata($key); 
                }
            }
            header('Location:' . site_url('login'));
            exit();
        }
    }

    /* ------------------- END BLOCK ------------------- */
}
