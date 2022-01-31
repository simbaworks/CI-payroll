<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Commonmodel', 'Common');
        $this->data['view'] = $this->data['controller'] . '/' . $this->data['method'];
        $this->clear_cache();
        $this->check_login(1);
    }

    /* ------------------- END BLOCK ------------------- */

    /**
     * 
     */
    public function index() {
        //echo $this->encryption->encrypt('admin@123');
        if ($this->session->userdata($this->data['sess_code'] . '_ltoken') == '') {
            $this->data['_ltoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ltoken', $this->data['_ltoken']);
            $this->session->set_userdata($this->data['sess_code'] . 'login_attempt', '0');
            $this->session->set_userdata($this->data['sess_code'] . 'login_start_time', date('Y-m-d H:i:s'));
        } else {
            $this->data['_ltoken'] = $this->session->userdata($this->data['sess_code'] . '_ltoken');
        }
        $failed_attempts_limit = 3;
        $interval_between_failed_attempts = 5;

        $time_diff = strtotime(date('Y-m-d H:i:s')) - strtotime($this->session->userdata($this->data['sess_code'] . 'login_start_time'));
        $time_elapsed = floor($time_diff / 60);
        if ($time_elapsed >= $interval_between_failed_attempts) {
            $this->session->set_userdata($this->data['sess_code'] . 'login_attempt', '0');
            $this->session->set_userdata($this->data['sess_code'] . 'login_start_time', date('Y-m-d H:i:s'));
            $time_diff = strtotime(date('Y-m-d H:i:s')) - strtotime($this->session->userdata($this->data['sess_code'] . 'login_start_time'));
            $time_elapsed = floor($time_diff / 60);
        }
        //echo $this->session->userdata($this->data['sess_code'] . '_ltoken');
        if (isset($this->data['resp']['_ltoken']) && $this->data['resp']['_ltoken'] == $this->session->userdata($this->data['sess_code'] . '_ltoken') && $this->data['resp']['_ltoken'] <> '' && ($this->session->userdata($this->data['sess_code'] . 'login_attempt') < $failed_attempts_limit && $time_elapsed < $interval_between_failed_attempts)) {
            $username = trim($this->data['resp']['username']);
            $password = trim($this->data['resp']['password']);
            if ($username <> '' && $password <> '') {
                $cond_and = array();
                $cond_and = array('username' => $username, 'status' => '1');
                $join_logic = array();
                $join_logic[0] = array('first_table' => 'hm_emp_master', 'join_on' => 'hm_emp_master.id = admin.employee_id', 'join_type' => 'inner', 'join_select' => array('hm_emp_master.emp_name, hm_emp_master.profile_picture'));
                $row = $this->Common->fetch($p_table = 'admin', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

                if (isset($row)){
                    if($this->encryption->decrypt($row['userpassword']) == $password) {
                        $this->session->set_userdata($this->data['sess_code'] . 'admin_id', $row['id']);
                        $this->session->set_userdata($this->data['sess_code'] . 'user_id', $row['employee_id']);
                        $this->session->set_userdata($this->data['sess_code'] . 'user_type', $row['user_type']);
                        $this->session->set_userdata($this->data['sess_code'] . 'user_encrypted_code', $row['encrypted_code']);
                        $this->session->set_userdata($this->data['sess_code'] . 'user_name', base64_decode($row['emp_name']));
                        $this->session->set_userdata($this->data['sess_code'] . 'username', $row['username']);
                        $this->session->set_userdata($this->data['sess_code'] . 'profile_picture', $row['profile_picture']);
                        $this->session->set_userdata($this->data['sess_code'] . 'login_attempt', '0');

                        header('Location:' . site_url('dashboard'));
                        exit();
                    }else{
                        $attempt_count = $this->session->userdata($this->data['sess_code'] . 'login_attempt');
                        $this->session->set_userdata($this->data['sess_code'] . 'login_attempt', $attempt_count + 1);
                        $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Attention!</strong> Wrong password enterd! 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>';
                        $this->session->set_flashdata('flash_message', $html);

                        /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
                        $system_log_array['user_id'] = '-1';
                        $system_log_array['controller_name'] = $this->data['controller'];
                        $system_log_array['method_name'] = $this->data['method'];
                        $system_log_array['row_id'] = '0';
                        $system_log_array['action'] = 'LOGIN ATTEMPT UNSUCCESSFUL AT ' . date('h:i:s A d-M-Y');
                        $system_log_array['time'] = date('Y-m-d H:i:s');
                        $system_log_array['ip_address'] = $this->input->ip_address();
                        $system_log_array['user_browser'] = $this->get_browser();
                        $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
                        /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */
                        header('Location:' . site_url('login'));
                        exit();
                    }
                } else {
                    $attempt_count = $this->session->userdata($this->data['sess_code'] . 'login_attempt');
                    $this->session->set_userdata($this->data['sess_code'] . 'login_attempt', $attempt_count + 1);
                    $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Attention!</strong> Wrong username enterd! 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>';
                    $this->session->set_flashdata('flash_message', $html);

                    /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
                    $system_log_array['user_id'] = '-1';
                    $system_log_array['controller_name'] = $this->data['controller'];
                    $system_log_array['method_name'] = $this->data['method'];
                    $system_log_array['row_id'] = '0';
                    $system_log_array['action'] = 'LOGIN ATTEMPT UNSUCCESSFUL AT ' . date('h:i:s A d-M-Y');
                    $system_log_array['time'] = date('Y-m-d H:i:s');
                    $system_log_array['ip_address'] = $this->input->ip_address();
                    $system_log_array['user_browser'] = $this->get_browser();
                    $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
                    /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */
                    header('Location:' . site_url('login'));
                    exit();
                }
            }
            $attempt_count = $this->session->userdata($this->data['sess_code'] . 'login_attempt');
            $this->session->set_userdata($this->data['sess_code'] . 'login_attempt', $attempt_count + 1);
            $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Attention!</strong> Username/Password blank! 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>';
            $this->session->set_flashdata('flash_message', $html);
            header('Location:' . site_url('login'));
            exit();
        } else {
            if ($this->session->userdata($this->data['sess_code'] . 'login_attempt') >= $failed_attempts_limit) {
                //$time_elapsed;
                //$interval_between_failed_attempts;
                $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Attention!</strong> You have exceeded the number of unsuccessful attempts! Please try after few minutes. 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>';
                $this->session->set_flashdata('flash_message', $html);
            }
        }

        $this->load->view($this->data['view'], $this->data);
    }
}
