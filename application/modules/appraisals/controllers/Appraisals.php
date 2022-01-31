<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Appraisals extends MY_Controller {
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
        header('Location:' . site_url('appraisals/lists'));
        exit();
    }

    public function lists() {        
        $cond_and = array();
        $cond_and = array('status <>' => '5');

        //pagination settings
        $pagiConfig['base_url'] = base_url($this->data['view']);

        $pagiConfig['total_rows'] = $this->Common->fetch($p_table = 'appraisals', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = TRUE, $return_object = FALSE, $debug = FALSE);
        $pagiConfig['per_page'] = $this->data["per_page"];
        $pagiConfig["uri_segment"] = 3;
        $choice = $pagiConfig["total_rows"] / $pagiConfig["per_page"];
        $pagiConfig["num_links"] = floor($choice) < 5 ? floor($choice) : 5; //floor( $choice );
        $pagiConfig["use_page_numbers"] = TRUE;

        //pagiConfig for bootstrap pagination class integration
        //Encapsulate whole pagination 
        $pagiConfig['full_tag_open'] = '<nav><ul class="pagination justify-content-end pagination-sm">';
        $pagiConfig['full_tag_close'] = '</ul></nav>';

        //First link of pagination
        $pagiConfig['first_link'] = '&laquo';
        $pagiConfig['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['first_tag_close'] = '</span></li>';

        //Customizing the “Digit�? Link
        $pagiConfig['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['num_tag_close'] = '</span></li>';

        //For PREVIOUS PAGE Setup
        $pagiConfig['prev_link'] = '&lsaquo;';
        $pagiConfig['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['prev_tag_close'] = '</span></li>';

        //For NEXT PAGE Setup
        $pagiConfig['next_link'] = '&rsaquo;';
        $pagiConfig['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['next_tag_close'] = '</span></li>';

        //For LAST PAGE Setup
        $pagiConfig['last_link'] = '&raquo';
        $pagiConfig['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['last_tag_close'] = '</span></li>';

        //For CURRENT page on which you are
        $pagiConfig['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $pagiConfig['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';

        $this->pagination->initialize($pagiConfig);
        $this->data['offset'] = ( $this->uri->segment($pagiConfig["uri_segment"]) > 0 ) ? ($this->uri->segment($pagiConfig["uri_segment"]) + 0) * $pagiConfig['per_page'] - $pagiConfig['per_page'] : $this->uri->segment($pagiConfig["uri_segment"]);
        $this->data["page_no"] = $this->uri->segment($pagiConfig["uri_segment"]);
        $this->data["total_rows"] = $pagiConfig['total_rows'];
        //call the model function to get the department data

        $this->data['results'] = $this->Common->fetch($p_table = 'appraisals', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'DESC'), $limit = $pagiConfig['per_page'], $offset = $this->data['offset'], $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


        if(!$this->session->userdata($this->data['sess_code'] . '_ftoken')){
            $this->data['_ftoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $this->data['_ftoken']);
        }else{
            $this->data['_ftoken'] = $this->session->userdata($this->data['sess_code'] . '_ftoken');
        }
       
        $cond_and = array();
        $cond_and = array('status <>' => '5');
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'employees', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('id, emp_id, name'), $join_logic = array(), $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
        
        $this->data['data_table'] = $this->load->view('appraisals/ajax/lists', $this->data, TRUE);

        $this->load->view('common/header', $this->data);
        $this->load->view($this->data['view'], $this->data);
        $this->load->view('common/footer', $this->data);
    }


    public function ajax_insta_edit_content(){  
        $data_id = isset($this->data['resp']['data_row_id']) ? base64_decode($this->data['resp']['data_row_id']) : NULL;
        $edit_type = isset($this->data['resp']['edit_type']) ? $this->data['resp']['edit_type'] : '1';
        $data_row_field = isset($this->data['resp']['data_row_field']) ? $this->data['resp']['data_row_field'] : NULL;

        if($edit_type == '1'){
            $current_value = isset($this->data['resp']['current_value']) ? base64_encode($this->data['resp']['current_value']) : NULL;
        }else{
            $current_value = isset($this->data['resp']['current_value']) ? $this->data['resp']['current_value'] : NULL;
        }
        $ftoken = isset($this->data['resp']['ftoken']) ? $this->data['resp']['ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
        $cond_and = array();
        $cond_and = array('status <>' => '5', 'id' =>$data_id);
        $results = $this->Common->fetch($p_table = 'appraisals', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(isset($results)) {
            $data_to_save = array();
            $data_to_save['id'] = $data_id;
            $data_to_save[$data_row_field] = $current_value;
            $data_to_save['modified'] = date("Y-m-d H:i:s");
            $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 

            $this->Common->update($p_table = 'appraisals', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = 'Changed ' . $data_row_field . ' | Old value: ' . $results[$data_row_field] . ' Modified value: ' . $data_to_save[$data_row_field];
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $data_id;
            $system_log_array['action'] = 'Modified an existing record in appraisals | ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully.';
            $response['ftoken'] = $ftoken;
            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['message'] = 'Alert! Can\'t find the record!';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
    }

    public function ajax_insta_status_update(){  
        $data_id = isset($this->data['resp']['data_row_id']) ? base64_decode($this->data['resp']['data_row_id']) : NULL;
        $current_value = isset($this->data['resp']['current_value']) ? $this->data['resp']['current_value'] : NULL;
        $ftoken = isset($this->data['resp']['ftoken']) ? $this->data['resp']['ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
        $cond_and = array();
        $cond_and = array('status <>' => '5', 'id' =>$data_id);
        $results = $this->Common->fetch($p_table = 'appraisals', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(isset($results)) {
            $data_to_save = array();
            $data_to_save['id'] = $data_id;
            $data_to_save['status'] = $current_value;
            $data_to_save['modified'] = date("Y-m-d H:i:s");
            $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 

            $this->Common->update($p_table = 'appraisals', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $data_id;
            $system_log_array['action'] = 'Changed status of an existing record in appraisals';
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully';
            $response['ftoken'] = $ftoken;
            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['message'] = 'Alert! Can\'t find the record!';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
    }

    public function ajax_load_add_form(){
        if(!$this->session->userdata($this->data['sess_code'] . '_ftoken')){
            $this->data['_ftoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $this->data['_ftoken']);
        }else{
            $this->data['_ftoken'] = $this->session->userdata($this->data['sess_code'] . '_ftoken');
        }

        
        $cond_and = array();
        $cond_and = array('status <>' => '5');
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'employees', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('id, emp_id, name'), $join_logic = array(), $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
        $html = $this->load->view('appraisals/ajax/ajax_add_form', $this->data, TRUE);

        $response['html'] = $html;
        $response['title'] = 'Add new Appraisal';
        echo json_encode($response);
    }

    public function ajax_save_add_form_data(){  
        $employee_id = isset($this->data['resp']['employee_id']) ? $this->data['resp']['employee_id'] : NULL;
        $reporting_off_id = isset($this->data['resp']['reporting_off_id']) ? $this->data['resp']['reporting_off_id'] : NULL;
        $reviewing_off_id = isset($this->data['resp']['reviewing_off_id']) ? $this->data['resp']['reviewing_off_id'] : NULL;
        $marks_obtained = isset($this->data['resp']['marks_obtained']) ? $this->data['resp']['marks_obtained'] : NULL;
        $year = isset($this->data['resp']['year']) ? $this->data['resp']['year'] : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        $data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['encrypted_code'] = $this->_random_password(32);
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['reporting_off_id'] = $reporting_off_id;
        $data_to_save['reviewing_off_id'] = $reviewing_off_id;
        $data_to_save['marks_obtained'] = $marks_obtained;
        $data_to_save['year'] = $year;
        $data_to_save['status'] = '1';
        $data_to_save['created'] = date("Y-m-d H:i:s");
        $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 

        if(isset($_FILES['supporting_document'])){
            $config['upload_path'] = './assets/uploads/appraisals/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('supporting_document')) {
                $file_name =  $this->upload->data();
                $data_to_save['supporting_document'] = $file_name['file_name'];
            }else{
                $error = $this->upload->display_errors();
                $response['code'] = '0';
                $response['message'] = $error;
                $response['html'] = '';
                $response['ftoken'] = '';
                echo json_encode($response);
                exit();
            }
        }

        $row_id = $this->Common->save($p_table = 'appraisals', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Added a new record in appraisal | ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $response['code'] = '1';
            $response['message'] = 'New record added successfully.';
            $response['html'] = $this->ajax_refresh_page();
            $response['ftoken'] = $ftoken;
            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['message'] = 'Alert! Can\'t add the record. PLease try again!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
    }

    function ajax_refresh_page($search_text = NULL) {  
        $cond_custom = NULL;      
        $cond_and = array();
        $cond_and = array('status <>' => '5');

        if($search_text !== NULL){
            $cond_custom = ' AND FROM_BASE64(`appraisals_name`) LIKE "%' . $search_text . '%"';
        }

        //pagination settings
        $pagiConfig['base_url'] = base_url($this->data['controller'] . '/lists');

        $pagiConfig['total_rows'] = $this->Common->fetch($p_table = 'appraisals', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = TRUE, $return_object = FALSE, $debug = FALSE);
        $pagiConfig['per_page'] = $this->data["per_page"];
        $pagiConfig["uri_segment"] = 3;
        $choice = $pagiConfig["total_rows"] / $pagiConfig["per_page"];
        $pagiConfig["num_links"] = floor($choice) < 5 ? floor($choice) : 5; //floor( $choice );
        $pagiConfig["use_page_numbers"] = TRUE;

        //pagiConfig for bootstrap pagination class integration
        //Encapsulate whole pagination 
        $pagiConfig['full_tag_open'] = '<nav><ul class="pagination justify-content-end pagination-sm">';
        $pagiConfig['full_tag_close'] = '</ul></nav>';

        //First link of pagination
        $pagiConfig['first_link'] = '&laquo';
        $pagiConfig['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['first_tag_close'] = '</span></li>';

        //Customizing the “Digit�? Link
        $pagiConfig['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['num_tag_close'] = '</span></li>';

        //For PREVIOUS PAGE Setup
        $pagiConfig['prev_link'] = '&lsaquo;';
        $pagiConfig['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['prev_tag_close'] = '</span></li>';

        //For NEXT PAGE Setup
        $pagiConfig['next_link'] = '&rsaquo;';
        $pagiConfig['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['next_tag_close'] = '</span></li>';

        //For LAST PAGE Setup
        $pagiConfig['last_link'] = '&raquo';
        $pagiConfig['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $pagiConfig['last_tag_close'] = '</span></li>';

        //For CURRENT page on which you are
        $pagiConfig['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $pagiConfig['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';

        $this->pagination->initialize($pagiConfig);
        $this->data['offset'] = ( $this->uri->segment($pagiConfig["uri_segment"]) > 0 ) ? ($this->uri->segment($pagiConfig["uri_segment"]) + 0) * $pagiConfig['per_page'] - $pagiConfig['per_page'] : $this->uri->segment($pagiConfig["uri_segment"]);
        $this->data["page_no"] = $this->uri->segment($pagiConfig["uri_segment"]);
        $this->data["total_rows"] = $pagiConfig['total_rows'];
        //call the model function to get the department data

        $this->data['results'] = $this->Common->fetch($p_table = 'appraisals', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'DESC'), $limit = $pagiConfig['per_page'], $offset = $this->data['offset'], $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


        $cond_and = array();
        $cond_and = array('status <>' => '5');
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'employees', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('id, emp_id, name'), $join_logic = array(), $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


        if(!$this->session->userdata($this->data['sess_code'] . '_ftoken')){
            $this->data['_ftoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $this->data['_ftoken']);
        }else{
            $this->data['_ftoken'] = $this->session->userdata($this->data['sess_code'] . '_ftoken');
        }

        $html = $this->load->view('appraisals/ajax/ajax_lists', $this->data, TRUE);

        return $html;
    }

    public function ajax_search(){        
        $search_text = isset($this->data['resp']['input_text']) &&  $this->data['resp']['input_text'] !== ''? $this->data['resp']['input_text'] : NULL;

        $resp = $this->ajax_refresh_page($search_text);
        echo $resp;
    }

    public function ajax_get_reporting_off(){  
        $selected_emp = isset($this->data['resp']['selected_emp']) ? $this->data['resp']['selected_emp'] : NULL;

        $cond_and = array();
        $cond_and = array('status <>' => '5');
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'employee_official_details', 'join_on' => 'employee_official_details.reporting_officer_id = employees.id', 'join_type' => 'inner', 'join_condition' => array('employee_official_details.status' => '1', 'employee_official_details.employee_id' => $selected_emp));
        $results = $this->Common->fetch($p_table = 'employees', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('id, emp_id, name'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


        $cond_and = array();
        $cond_and = array('status <>' => '5', 'id <>' => $selected_emp);
        $employee_details = $this->Common->fetch($p_table = 'employees', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('id, emp_id, name'), $join_logic = array(), $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(isset($results)) {
            $response['code'] = '1';
            $response['html'] = "<option value='" . $results['id'] . "'>" . "[" . base64_decode($results['emp_id']) . "] " . base64_decode($results['name']) . "</option>";
            $response['reviewing_off'] = '';

            if(isset($employee_details)){
                foreach ($employee_details as $value) {
                    $response['reviewing_off'] .= "<option value='" . $value['id'] . "'>" . "[" . base64_decode($value['emp_id']) . "] " . base64_decode($value['name']) . "</option>";
                }
            }
            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['html'] = 'No record found. Please try again!';
            echo json_encode($response);
            exit();
        }
    }
}
