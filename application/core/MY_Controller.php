<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller {

    public $data;

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->_hmvc_fixes();
        $this->load->library('my_functions');
        $this->load->model('common/Commonmodel', 'Common');

        $this->data['base_url'] = site_url();
        $this->data['site_title'] = $this->config->item('site_title') . ' | ' . ucwords(singular($this->router->fetch_method()));
        $this->data['assets'] = $this->config->item('assets_folder');
        $this->data['css'] = $this->config->item('css_folder');
        $this->data['js'] = $this->config->item('js_folder');
        $this->data['img'] = $this->config->item('img_folder');
        $this->data['uploads'] = $this->config->item('upload_folder');
        $this->data['vendors'] = $this->config->item('vendor_folder');
        $this->data['per_page'] = $this->config->item('pegination_per_page');
        //$this->data['front_sess_code'] = $this->config->item('fsess_code');
        $this->data['sess_code'] = $this->config->item('asess_code');
        $this->data['title'] = $this->config->item('title');
        $this->data['version'] = $this->config->item('version');
        $this->data['version_status'] = $this->config->item('version_status');
        $this->data['footer_text'] = $this->config->item('footer_text');
        $this->data['controller'] = $this->router->fetch_class();
        $this->data['method'] = $this->router->fetch_method();
        $this->data['front_path'] = "front";

        $this->data['resp'] = $this->input->post(NULL, TRUE);
        $this->data['assets_path'] = $this->data['base_url'] . $this->config->item('assets_folder') . '/';
        $this->data['css_path'] = $this->data['assets_path'] . $this->data['css'] . '/';
        $this->data['js_path'] = $this->data['assets_path'] . $this->data['js'] . '/';
        $this->data['img_path'] = $this->data['assets_path'] . $this->data['img'] . '/';
        $this->data['upload_path'] = $this->data['assets_path'] . $this->data['uploads'] . '/';
        $this->data['vendor_path'] = $this->data['assets_path'] . $this->data['vendors'] . '/';

        //echo $key = $this->encryption->create_key(16);
        $cond_and = array('status' => '1');
        $this->data['modules'] = $this->Common->fetch($p_table = 'modules', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('modules.module_order' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
    }

    function _hmvc_fixes() {
        //fix callback form_validation		
        //https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
        $this->load->library('form_validation');
        $this->form_validation->CI = & $this;
    }

    function _random_password($chars = 8) {
        $letters = md5(uniqid(rand(), true));
        return substr(str_shuffle($letters), 0, $chars);
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    function check_login($disabled = 0) {
        if ($disabled == 0) {
            if (!$this->session->userdata($this->data['sess_code'] . 'admin_id')) {
                header('Location:' . site_url('login'));
                exit();
            }
        } else {
            if ($this->session->userdata($this->data['sess_code'] . 'admin_id')) {
                header('Location:' . site_url('dashboard'));
                exit();
            }
        }
    }

    function get_browser() {
        $this->load->library('user_agent');
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }
        return $agent . ' [' . $this->agent->platform() . ']';
    }

}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
