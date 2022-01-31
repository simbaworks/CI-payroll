<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

class Employees extends MY_Controller {
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
        header('Location:' . site_url('employees/lists'));
        exit();
    }

    public function lists() {        
        $cond_and = array();
        if($this->session->userdata($this->data['sess_code'] . 'user_type') == '0'){
            $cond_and = array('status <>' => '5');
        }else{
            $cond_and = array('id' => $this->session->userdata($this->data['sess_code'] . 'user_id'));
        }

        //pagination settings
        $pagiConfig['base_url'] = base_url($this->data['view']);

        $pagiConfig['total_rows'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = TRUE, $return_object = FALSE, $debug = FALSE);
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

        $this->data['results'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'DESC'), $limit = $pagiConfig['per_page'], $offset = $this->data['offset'], $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
      

        if(!$this->session->userdata($this->data['sess_code'] . '_ftoken')){
            $this->data['_ftoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $this->data['_ftoken']);
        }else{
            $this->data['_ftoken'] = $this->session->userdata($this->data['sess_code'] . '_ftoken');
        }

        $this->data['data_table'] = $this->load->view('employees/ajax/lists', $this->data, TRUE);

        $this->load->view('common/header', $this->data);
        $this->load->view($this->data['view'], $this->data);
        $this->load->view('common/footer', $this->data);
    }

    public function add(){
        if(!$this->session->userdata($this->data['sess_code'] . '_ftoken')){
            $this->data['_ftoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $this->data['_ftoken']);
        }else{
            $this->data['_ftoken'] = $this->session->userdata($this->data['sess_code'] . '_ftoken');
        }


        if (isset($this->data['resp']['_ftoken']) && $this->data['resp']['_ftoken'] == $this->session->userdata($this->data['sess_code'] . '_ftoken') && $this->data['resp']['_ftoken'] <> '') {

            $data_to_save = array();
            //$data_to_save['unique_code'] = $this->_random_password(32);
            $data_to_save['encrypted_code'] = $this->_random_password(32);
            $data_to_save['emp_id'] = isset($this->data['resp']['emp_id']) && $this->data['resp']['emp_id'] != '' ? base64_encode($this->data['resp']['emp_id']) : NULL;
            $data_to_save['emp_name'] = isset($this->data['resp']['name']) && $this->data['resp']['name'] != '' ? base64_encode($this->data['resp']['name']) : NULL;
            $data_to_save['emp_father'] = isset($this->data['resp']['father_name']) && $this->data['resp']['father_name'] != '' ? base64_encode($this->data['resp']['father_name']) : NULL;
            $data_to_save['emp_mother'] = isset($this->data['resp']['mother_name']) && $this->data['resp']['mother_name'] != '' ? base64_encode($this->data['resp']['mother_name']) : NULL;
            $data_to_save['emp_identification_mark'] = isset($this->data['resp']['identification_mark']) && $this->data['resp']['identification_mark'] != '' ? base64_encode($this->data['resp']['identification_mark']) : NULL;
            $disability_percentage = isset($this->data['resp']['disability_percentage']) && $this->data['resp']['disability_percentage'] != '' ? base64_encode($this->data['resp']['disability_percentage']) : NULL;
            $data_to_save['emp_email'] = isset($this->data['resp']['contact_email']) && $this->data['resp']['contact_email'] != '' ? base64_encode($this->data['resp']['contact_email']) : NULL;
            $data_to_save['emp_mobile'] = isset($this->data['resp']['contact_phone']) && $this->data['resp']['contact_phone'] != '' ? base64_encode($this->data['resp']['contact_phone']) : NULL;
            $data_to_save['emp_pan'] = isset($this->data['resp']['pan_number']) && $this->data['resp']['pan_number'] != '' ? base64_encode($this->data['resp']['pan_number']) : NULL;
            $data_to_save['emp_aadhar'] = isset($this->data['resp']['aadhaar_number']) && $this->data['resp']['aadhaar_number'] != '' ? base64_encode($this->data['resp']['aadhaar_number']) : NULL;

            $data_to_save['emp_gender_id'] = isset($this->data['resp']['gender_id']) && $this->data['resp']['gender_id'] != '' ? $this->data['resp']['gender_id'] : NULL;
            $data_to_save['emp_religion_id'] = isset($this->data['resp']['religion_id']) && $this->data['resp']['religion_id'] != '' ? $this->data['resp']['religion_id'] : NULL;
            $data_to_save['emp_caste_id'] = isset($this->data['resp']['caste_id']) && $this->data['resp']['caste_id'] != '' ? $this->data['resp']['caste_id'] : NULL;
            //$data_to_save['nationality'] = isset($this->data['resp']['nationality']) && $this->data['resp']['nationality'] != '' ? base64_encode($this->data['resp']['nationality']) : NULL;
            $data_to_save['emp_blood_group'] = isset($this->data['resp']['blood_group_id']) && $this->data['resp']['blood_group_id'] != '' ? $this->data['resp']['blood_group_id'] : NULL;
            $data_to_save['emp_mar_status'] = isset($this->data['resp']['marital_status_id']) && $this->data['resp']['marital_status_id'] != '' ? $this->data['resp']['marital_status_id'] : NULL;
            //$data_to_save['emp_spouse'] = isset($this->data['resp']['spouse_name']) && $this->data['resp']['spouse_name'] != '' ? base64_encode($this->data['resp']['spouse_name']) : NULL;
            $data_to_save['emp_pwd_status'] = isset($this->data['resp']['is_disabled']) && $this->data['resp']['is_disabled'] != '' ? $this->data['resp']['is_disabled'] : '0';
            $pwd_type = isset($this->data['resp']['pwd_type']) && $this->data['resp']['pwd_type'] != '' ? $this->data['resp']['pwd_type'] : NULL;

            $data_to_save['emp_doj'] = isset($this->data['resp']['date_of_joining']) && $this->data['resp']['date_of_joining'] != '' ? date('Y-m-d', strtotime(str_replace('/', '-', $this->data['resp']['date_of_joining']))) : NULL;            
            $data_to_save['date_of_birth'] = isset($this->data['resp']['dob']) && $this->data['resp']['dob'] != '' ? date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->data['resp']['dob']))) : NULL;
            $data_to_save['emp_dor'] = $data_to_save['date_of_birth'] != NULL ? date('Y-m-d H:i:s', strtotime('+58 years', strtotime(str_replace('/', '-', $data_to_save['date_of_birth'])))) : NULL;
            $data_to_save['emp_uan'] = isset($this->data['resp']['uan']) && $this->data['resp']['uan'] != '' ? base64_encode($this->data['resp']['uan']) : NULL;
            $data_to_save['emp_alternate_contact'] = isset($this->data['resp']['alternate_contact']) && $this->data['resp']['alternate_contact'] != '' ? base64_encode($this->data['resp']['alternate_contact']) : NULL;


            $data_to_save['status'] = '1';
            $data_to_save['created'] = date('Y-m-d H:i:s');
            $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id');

            $config = array();
            $config['upload_path'] = './assets/uploads/caste_certificates/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            
            if(isset($_FILES['caste_certificate']) && $_FILES['caste_certificate']['name'] !== ""){

                if ($this->upload->do_upload('caste_certificate')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['caste_certificate'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }
            
            if(isset($_FILES['blood_certificate']) && $_FILES['blood_certificate']['name'] !== ""){
                $config1 = array();
                $config1['upload_path'] = './assets/uploads/blood_certificates/';
                $config1['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config1['overwrite'] = FALSE;
                $config1['encrypt_name'] = TRUE;
                $config1['remove_spaces'] = TRUE;

                $this->upload->initialize($config1);
                if ($this->upload->do_upload('blood_certificate')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['blood_certificate'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['marriage_certificate']) && $_FILES['marriage_certificate']['name'] !== ""){
                $config2 = array();
                $config2['upload_path'] = './assets/uploads/marriage_certificates/';
                $config2['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config2['overwrite'] = FALSE;
                $config2['encrypt_name'] = TRUE;
                $config2['remove_spaces'] = TRUE;

                $this->upload->initialize($config2);
                if ($this->upload->do_upload('marriage_certificate')) {
                    $file_name =  $this->upload->data();
                    //$data_to_save['marriage_certificate'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['disability_certificate']) && $_FILES['disability_certificate']['name'] !== ""){
                $config3 = array();
                $config3['upload_path'] = './assets/uploads/disability_certificates/';
                $config3['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config3['overwrite'] = FALSE;
                $config3['encrypt_name'] = TRUE;
                $config3['remove_spaces'] = TRUE;

                $this->upload->initialize($config3);
                if ($this->upload->do_upload('disability_certificate')) {
                    $file_name =  $this->upload->data();
                    $disability_certificate = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['pan_card']) && $_FILES['pan_card']['name'] !== ""){
                $config4 = array();
                $config4['upload_path'] = './assets/uploads/pan_cards/';
                $config4['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config4['overwrite'] = FALSE;
                $config4['encrypt_name'] = TRUE;
                $config4['remove_spaces'] = TRUE;

                $this->upload->initialize($config4);
                if ($this->upload->do_upload('pan_card')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['pan_card'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['aadhaar_card']) && $_FILES['aadhaar_card']['name'] !== ""){
                $config5 = array();
                $config5['upload_path'] = './assets/uploads/aadhaar_cards/';
                $config5['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config5['overwrite'] = FALSE;
                $config5['encrypt_name'] = TRUE;
                $config5['remove_spaces'] = TRUE;

                $this->upload->initialize($config5);
                if ($this->upload->do_upload('aadhaar_card')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['aadhaar_card'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] !== ""){
                $config6 = array();
                $config6['upload_path'] = './assets/uploads/profile_pictures/';
                $config6['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config6['overwrite'] = FALSE;
                $config6['encrypt_name'] = TRUE;
                $config6['remove_spaces'] = TRUE;

                $this->upload->initialize($config6);
                if ($this->upload->do_upload('profile_picture')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['profile_picture'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            $employee_id = $this->Common->save($p_table = 'hm_emp_master', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
            
            if(isset($employee_id)){
                
                // CREATE LOGIN ENTRY
                $data_to_save = array();
                $data_to_save['unique_code'] = $this->_random_password(32);
                $data_to_save['encrypted_code'] = $this->_random_password(32);
                $data_to_save['employee_id'] = $employee_id;
                $data_to_save['user_type'] = '1';
                $data_to_save['username'] = isset($this->data['resp']['contact_email']) && $this->data['resp']['contact_email'] != '' ? $this->data['resp']['contact_email'] : NULL;
                $data_to_save['userpassword'] = $this->encryption->encrypt('12345678');
                $data_to_save['is_email_verified'] = '0';
                $data_to_save['status'] = '1';
                $data_to_save['created'] = date('Y-m-d H:i:s');
                $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id');

                $resp = $this->Common->save($p_table = 'admin', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);

                $this->session->unset_userdata($this->data['sess_code'] . '_ftoken');

                header('Location:' . site_url('employees/edit/' . base64_encode($employee_id)));
                exit();
            }
            header('Location:' . site_url('employees/lists'));
            exit();
        }
        $cond_and = array();
        $cond_and = array('status' => '1');
        $this->data['caste'] = $this->Common->fetch($p_table = 'caste', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status' => '1');
        $this->data['blood_groups'] = $this->Common->fetch($p_table = 'blood_groups', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status' => '1');
        $this->data['religion'] = $this->Common->fetch($p_table = 'religions', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
        
        $cond_and = array();
        $cond_and = array('status' => '1');
        $this->data['marital_status'] = $this->Common->fetch($p_table = 'marital_status', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
        
        $this->load->view('common/header', $this->data);
        $this->load->view($this->data['view'], $this->data);
        $this->load->view('common/footer', $this->data);
    }


    public function edit($encrypted_code = NULL){  
        if($encrypted_code == NULL){            
            header('Location:' . site_url('employees/lists'));
            exit();
        }

        if(!$this->session->userdata($this->data['sess_code'] . '_ftoken')){
            $this->data['_ftoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $this->data['_ftoken']);
        }else{
            $this->data['_ftoken'] = $this->session->userdata($this->data['sess_code'] . '_ftoken');
        }

        $row_id = base64_decode($encrypted_code);

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $row_id);
        $join_logic = array();
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){            
            header('Location:' . site_url('employees/lists'));
            exit();
        }

        if (isset($this->data['resp']['_ftoken']) && $this->data['resp']['_ftoken'] == $this->session->userdata($this->data['sess_code'] . '_ftoken') && $this->data['resp']['_ftoken'] <> '') {
            
            $data_to_save = array();
            $data_to_save['id'] = $this->data['employee_details']['id'];
            $data_to_save['emp_id'] = isset($this->data['resp']['emp_id']) && $this->data['resp']['emp_id'] != '' ? base64_encode($this->data['resp']['emp_id']) : NULL;
            $data_to_save['emp_name'] = isset($this->data['resp']['name']) && $this->data['resp']['name'] != '' ? base64_encode($this->data['resp']['name']) : NULL;
            $data_to_save['emp_father'] = isset($this->data['resp']['father_name']) && $this->data['resp']['father_name'] != '' ? base64_encode($this->data['resp']['father_name']) : NULL;
            $data_to_save['emp_mother'] = isset($this->data['resp']['mother_name']) && $this->data['resp']['mother_name'] != '' ? base64_encode($this->data['resp']['mother_name']) : NULL;
            $data_to_save['emp_identification_mark'] = isset($this->data['resp']['identification_mark']) && $this->data['resp']['identification_mark'] != '' ? base64_encode($this->data['resp']['identification_mark']) : NULL;
            $disability_percentage = isset($this->data['resp']['disability_percentage']) && $this->data['resp']['disability_percentage'] != '' ? base64_encode($this->data['resp']['disability_percentage']) : NULL;
            $data_to_save['emp_email'] = isset($this->data['resp']['contact_email']) && $this->data['resp']['contact_email'] != '' ? base64_encode($this->data['resp']['contact_email']) : NULL;
            $data_to_save['emp_mobile'] = isset($this->data['resp']['contact_phone']) && $this->data['resp']['contact_phone'] != '' ? base64_encode($this->data['resp']['contact_phone']) : NULL;
            $data_to_save['emp_pan'] = isset($this->data['resp']['pan_number']) && $this->data['resp']['pan_number'] != '' ? base64_encode($this->data['resp']['pan_number']) : NULL;
            $data_to_save['emp_aadhar'] = isset($this->data['resp']['aadhaar_number']) && $this->data['resp']['aadhaar_number'] != '' ? base64_encode($this->data['resp']['aadhaar_number']) : NULL;

            $data_to_save['emp_gender_id'] = isset($this->data['resp']['gender_id']) && $this->data['resp']['gender_id'] != '' ? $this->data['resp']['gender_id'] : NULL;
            $data_to_save['emp_religion_id'] = isset($this->data['resp']['religion_id']) && $this->data['resp']['religion_id'] != '' ? $this->data['resp']['religion_id'] : NULL;
            $data_to_save['emp_caste_id'] = isset($this->data['resp']['caste_id']) && $this->data['resp']['caste_id'] != '' ? $this->data['resp']['caste_id'] : NULL;
            //$data_to_save['nationality'] = isset($this->data['resp']['nationality']) && $this->data['resp']['nationality'] != '' ? base64_encode($this->data['resp']['nationality']) : NULL;
            $data_to_save['emp_blood_group'] = isset($this->data['resp']['blood_group_id']) && $this->data['resp']['blood_group_id'] != '' ? $this->data['resp']['blood_group_id'] : NULL;
            $data_to_save['emp_mar_status'] = isset($this->data['resp']['marital_status_id']) && $this->data['resp']['marital_status_id'] != '' ? $this->data['resp']['marital_status_id'] : NULL;
            //$data_to_save['emp_spouse'] = isset($this->data['resp']['spouse_name']) && $this->data['resp']['spouse_name'] != '' ? base64_encode($this->data['resp']['spouse_name']) : NULL;
            $data_to_save['emp_pwd_status'] = isset($this->data['resp']['is_disabled']) && $this->data['resp']['is_disabled'] != '' ? $this->data['resp']['is_disabled'] : '0';
            $pwd_type = isset($this->data['resp']['pwd_type']) && $this->data['resp']['pwd_type'] != '' ? implode(',', $this->data['resp']['pwd_type']) : NULL;

            $data_to_save['emp_doj'] = isset($this->data['resp']['date_of_joining']) && $this->data['resp']['date_of_joining'] != '' ? date('Y-m-d', strtotime(str_replace('/', '-', $this->data['resp']['date_of_joining']))) : NULL;            
            $data_to_save['emp_dor'] = $data_to_save['emp_doj'] != NULL ? date('Y-m-d H:i:s', strtotime('+60 years', strtotime(str_replace('/', '-', $data_to_save['emp_doj'])))) : NULL;
            $data_to_save['date_of_birth'] = isset($this->data['resp']['dob']) && $this->data['resp']['dob'] != '' ? date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->data['resp']['dob']))) : NULL;
            $data_to_save['emp_uan'] = isset($this->data['resp']['uan']) && $this->data['resp']['uan'] != '' ? base64_encode($this->data['resp']['uan']) : NULL;
            $data_to_save['emp_alternate_contact'] = isset($this->data['resp']['alternate_contact']) && $this->data['resp']['alternate_contact'] != '' ? base64_encode($this->data['resp']['alternate_contact']) : NULL;

            if($data_to_save['emp_mar_status'] !== '2'){
                $data_to_save['emp_spouse'] = '';
                $data_to_save['marriage_certificate'] = '';
            }

            if($data_to_save['emp_caste_id'] == '1'){
                $data_to_save['caste_certificate'] = '';
            }

            if($data_to_save['emp_pwd_status'] == '0'){
                $data_to_save['disability_certificate'] = '';
                $data_to_save['disability_percentage'] = '';
                $data_to_save['pwd_type'] = '';
            }

            $data_to_save['status'] = '1';
            $data_to_save['modified'] = date('Y-m-d H:i:s');
            $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id');

            $config = array();
            $config['upload_path'] = './assets/uploads/caste_certificates/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if(isset($_FILES['caste_certificate']) && $_FILES['caste_certificate']['name'] !== ""){
                if ($this->upload->do_upload('caste_certificate')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['caste_certificate'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }
            
            if(isset($_FILES['blood_certificate']) && $_FILES['blood_certificate']['name'] !== ""){
                $config1 = array();
                $config1['upload_path'] = './assets/uploads/blood_certificates/';
                $config1['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config1['overwrite'] = FALSE;
                $config1['encrypt_name'] = TRUE;
                $config1['remove_spaces'] = TRUE;

                $this->upload->initialize($config1);
                if ($this->upload->do_upload('blood_certificate')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['blood_certificate'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['marriage_certificate']) && $_FILES['marriage_certificate']['name'] !== ""){
                $config2 = array();
                $config2['upload_path'] = './assets/uploads/marriage_certificates/';
                $config2['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config2['overwrite'] = FALSE;
                $config2['encrypt_name'] = TRUE;
                $config2['remove_spaces'] = TRUE;

                $this->upload->initialize($config2);
                if ($this->upload->do_upload('marriage_certificate')) {
                    $file_name =  $this->upload->data();
                    //$data_to_save['marriage_certificate'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['disability_certificate']) && $_FILES['disability_certificate']['name'] !== ""){
                $config3 = array();
                $config3['upload_path'] = './assets/uploads/disability_certificates/';
                $config3['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config3['overwrite'] = FALSE;
                $config3['encrypt_name'] = TRUE;
                $config3['remove_spaces'] = TRUE;

                $this->upload->initialize($config3);
                if ($this->upload->do_upload('disability_certificate')) {
                    $file_name =  $this->upload->data();
                    $disability_certificate = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['pan_card']) && $_FILES['pan_card']['name'] !== ""){
                $config4 = array();
                $config4['upload_path'] = './assets/uploads/pan_cards/';
                $config4['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config4['overwrite'] = FALSE;
                $config4['encrypt_name'] = TRUE;
                $config4['remove_spaces'] = TRUE;

                $this->upload->initialize($config4);
                if ($this->upload->do_upload('pan_card')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['pan_card'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['aadhaar_card']) && $_FILES['aadhaar_card']['name'] !== ""){
                $config5 = array();
                $config5['upload_path'] = './assets/uploads/aadhaar_cards/';
                $config5['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config5['overwrite'] = FALSE;
                $config5['encrypt_name'] = TRUE;
                $config5['remove_spaces'] = TRUE;

                $this->upload->initialize($config5);
                if ($this->upload->do_upload('aadhaar_card')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['aadhaar_card'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] !== ""){
                $config6 = array();
                $config6['upload_path'] = './assets/uploads/profile_pictures/';
                $config6['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config6['overwrite'] = FALSE;
                $config6['encrypt_name'] = TRUE;
                $config6['remove_spaces'] = TRUE;

                $this->upload->initialize($config6);
                if ($this->upload->do_upload('profile_picture')) {
                    $file_name =  $this->upload->data();
                    $data_to_save['profile_picture'] = $file_name['file_name'];
                }else{
                    print_r($this->upload->display_errors());
                    exit();
                }
            }

            $employee_id = $this->Common->update($p_table = 'hm_emp_master', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
            //$employee_id = $this->Common->save($p_table = 'employees', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
            
            if(isset($employee_id)){

                if($data_to_save['emp_pwd_status'] !== '1'){
                    $this->Common->p_delete($p_table = 'emp_pwd_details', $p_key = 'emp_id', $row_id = $this->data['employee_details']['id'], $cond = NULL, $debug = FALSE);
                }
                // CREATE LOGIN ENTRY
                $data_to_save = array();
                $data_to_save['employee_id'] = $this->data['employee_details']['id'];
                $data_to_save['username'] = isset($this->data['resp']['contact_email']) && $this->data['resp']['contact_email'] != '' ? $this->data['resp']['contact_email'] : NULL;
                $data_to_save['status'] = '1';
                $data_to_save['modified'] = date('Y-m-d H:i:s');
                $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id');

                $resp = $this->Common->update($p_table = 'admin', $p_key = 'employee_id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
                //$resp = $this->Common->save($p_table = 'admin', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);

                $this->session->unset_userdata($this->data['sess_code'] . '_ftoken');
            }
            /* UNSET SESSION TOKEN */
            header('Location:' . site_url('employees/edit/' . base64_encode($row_id)));
            exit();
        }
        $cond_and = array();
        $cond_and = array('status' => '1');
        $this->data['caste'] = $this->Common->fetch($p_table = 'caste', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status' => '1');
        $this->data['blood_groups'] = $this->Common->fetch($p_table = 'blood_groups', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status' => '1');
        $this->data['religion'] = $this->Common->fetch($p_table = 'religions', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
        
        $cond_and = array();
        $cond_and = array('status' => '1');
        $this->data['marital_status'] = $this->Common->fetch($p_table = 'marital_status', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'board_univ', 'join_on' => 'board_univ.id = employee_education_details.board_univ_code', 'join_type' => 'left', 'join_select' => array('board_univ.bu_name'));
        $join_logic[1] = array('first_table' => 'degree_master', 'join_on' => 'degree_master.id = employee_education_details.degree_code', 'join_type' => 'left', 'join_select' => array('degree_master.degree_name'));
        $this->data['employee_education_details'] = $this->Common->fetch($p_table = 'employee_education_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $this->data['employee_address_details'] = $this->Common->fetch($p_table = 'employee_address_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $this->data['employee_bank_details'] = $this->Common->fetch($p_table = 'employee_bank_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'relations', 'join_on' => 'relations.id = employee_dependents_details.relation_id', 'join_type' => 'left', 'join_select' => array('relations.relation'));
        $this->data['employee_dependents_details'] = $this->Common->fetch($p_table = 'employee_dependents_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'centre_details', 'join_on' => 'centre_details.id = employee_official_details.loc_code', 'join_type' => 'left', 'join_select' => array('centre_details.centre_name'));
        $join_logic[1] = array('first_table' => 'ro_details', 'join_on' => 'ro_details.id = centre_details.ro_id', 'join_type' => 'left', 'join_select' => array('ro_details.ro_name'));
        $join_logic[2] = array('first_table' => 'centre_types', 'join_on' => 'centre_types.id = centre_details.centre_type_id', 'join_type' => 'left', 'join_select' => array('centre_types.centre_type_name'));
        $join_logic[3] = array('first_table' => 'department_master', 'join_on' => 'department_master.id = employee_official_details.deptt_code', 'join_type' => 'left', 'join_select' => array('department_master.name as department_name'));
        $join_logic[4] = array('first_table' => 'hm_emp_master', 'join_on' => 'hm_emp_master.id = employee_official_details.rep_emp_id', 'join_type' => 'left', 'join_select' => array('hm_emp_master.emp_name, hm_emp_master.emp_id'));
        $join_logic[5] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = employee_official_details.desgn_code', 'join_type' => 'left', 'join_select' => array('designation_master.description, designation_master.type as designation_type'));
        $join_logic[6] = array('first_table' => 'employee_types', 'join_on' => 'employee_types.id = employee_official_details.employee_type_id', 'join_type' => 'left', 'join_select' => array('employee_types.type_name'));
        $this->data['employee_official_details'] = $this->Common->fetch($p_table = 'employee_official_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'designation_pay_scale', 'join_on' => 'designation_pay_scale.id = employee_salary_details.scale_id', 'join_type' => 'left', 'join_select' => array('designation_pay_scale.pay_pattern as scale, designation_pay_scale.scale_min, designation_pay_scale.scale_max'));
        $join_logic[1] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = designation_pay_scale.designation_id', 'join_type' => 'left', 'join_select' => array('designation_master.description'));
        $this->data['employee_salary_details'] = $this->Common->fetch($p_table = 'employee_salary_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $this->data['employee_lic_details'] = $this->Common->fetch($p_table = 'employee_lic_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'emp_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'pwd_master', 'join_on' => 'pwd_master.id = emp_pwd_details.pwd_type_id', 'join_type' => 'left', 'join_select' => array('pwd_master.pwd_name'));
        $this->data['employee_pwd_details'] = $this->Common->fetch($p_table = 'emp_pwd_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $this->data['personal_details'] = $this->load->view('employees/ajax/ajax_personal_details', $this->data, TRUE);
        $this->data['education_details'] = $this->load->view('employees/ajax/ajax_education_details', $this->data, TRUE);
        $this->data['address_details'] = $this->load->view('employees/ajax/ajax_address_details', $this->data, TRUE);
        $this->data['bank_details'] = $this->load->view('employees/ajax/ajax_bank_details', $this->data, TRUE);
        $this->data['dependents_details'] = $this->load->view('employees/ajax/ajax_dependents_details', $this->data, TRUE);
        $this->data['official_details'] = $this->load->view('employees/ajax/ajax_official_details', $this->data, TRUE);
        $this->data['salary_details'] = $this->load->view('employees/ajax/ajax_salary_details', $this->data, TRUE);
        $this->data['lic_details'] = $this->load->view('employees/ajax/ajax_lic_details', $this->data, TRUE);
        $this->data['pwd_details'] = $this->load->view('employees/ajax/ajax_pwd_details', $this->data, TRUE);
        
        $this->load->view('common/header', $this->data);
        $this->load->view($this->data['view'], $this->data);
        $this->load->view('common/footer', $this->data);
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
        $results = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(isset($results)) {
            $data_to_save = array();
            $data_to_save['id'] = $data_id;
            $data_to_save['status'] = $current_value;
            $data_to_save['modified'] = date("Y-m-d H:i:s");
            $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 

            $this->Common->update($p_table = 'hm_emp_master', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $data_id;
            $system_log_array['action'] = 'Changed status of an existing record in employees';
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
        $data_row = isset($this->data['resp']['data_row']) ? $this->data['resp']['data_row'] : NULL;
        $data_code = isset($this->data['resp']['data_code']) ? $this->data['resp']['data_code'] : NULL;
        $html = '';

        if(!$this->session->userdata($this->data['sess_code'] . '_ftoken')){
            $this->data['_ftoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $this->data['_ftoken']);
        }else{
            $this->data['_ftoken'] = $this->session->userdata($this->data['sess_code'] . '_ftoken');
        }

        if($data_row == 'education'){
            $this->data['employee_id'] = $data_code;

            $cond_and = array();
            $cond_and = array('status' => '1');
            $this->data['board_univ'] = $this->Common->fetch($p_table = 'board_univ', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['degrees'] = $this->Common->fetch($p_table = 'degree_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/add/ajax_add_education', $this->data, TRUE);
            $response['title'] = 'Add new educaton history';
        }elseif($data_row == 'address'){
            $this->data['employee_id'] = $data_code;

            $html = $this->load->view('employees/ajax/add/ajax_add_address', $this->data, TRUE);
            $response['title'] = 'Add new address';
        }elseif($data_row == 'bank'){
            $this->data['employee_id'] = $data_code;

            $html = $this->load->view('employees/ajax/add/ajax_add_bank_details', $this->data, TRUE);
            $response['title'] = 'Add new bank details';
        }elseif($data_row == 'dependent'){
            $this->data['employee_id'] = $data_code;
            $this->data['enc_code'] = $this->_random_password(32);
            $this->data['dependent_count'] = '1';
            
            $cond_and = array();
            $cond_and = array('status' => '1');
            $this->data['relations'] = $this->Common->fetch($p_table = 'relations', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/add/ajax_add_dependents', $this->data, TRUE);
            $response['title'] = 'Add new family details';
        }elseif($data_row == 'official'){
            $this->data['employee_id'] = $data_code;
            
            $cond_and = array();
            $cond_and = array('status' => '1');
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'ro_details', 'join_on' => 'ro_details.id = centre_details.ro_id', 'join_type' => 'left', 'join_select' => array('ro_details.ro_name'));
            $join_logic[1] = array('first_table' => 'centre_types', 'join_on' => 'centre_types.id = centre_details.centre_type_id', 'join_type' => 'left', 'join_select' => array('centre_types.centre_type_name'));
            $this->data['centre_details'] = $this->Common->fetch($p_table = 'centre_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['department_master'] = $this->Common->fetch($p_table = 'department_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['designation_master'] = $this->Common->fetch($p_table = 'designation_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['employee_types'] = $this->Common->fetch($p_table = 'employee_types', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['unions'] = $this->Common->fetch($p_table = 'unions', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id <>' => base64_decode($data_code));
            $this->data['employees'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/add/ajax_add_official_details', $this->data, TRUE);
            $response['title'] = 'Add official details';
        }elseif($data_row == 'salary'){
            $this->data['employee_id'] = $data_code;

            $cond_and = array();
            $cond_and = array('status' => '1');
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = designation_pay_scale.designation_id', 'join_type' => 'left', 'join_select' => array('designation_master.description'));
            $this->data['designation_pay_scale'] = $this->Common->fetch($p_table = 'designation_pay_scale', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            
            $cond_and = array();
            $cond_and = array('status' => '1', 'id <>' => base64_decode($data_code));
            $this->data['employees'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/add/ajax_add_salary_details', $this->data, TRUE);
            $response['title'] = 'Add new salary details';
        }elseif($data_row == 'lic'){
            $this->data['employee_id'] = $data_code;

            $html = $this->load->view('employees/ajax/add/ajax_add_lic_info', $this->data, TRUE);
            $response['title'] = 'Add new LIC details';
        }elseif($data_row == 'diability'){
            $this->data['employee_id'] = $data_code;

            $cond_and = array();
            $cond_and = array('status' => '1');
            $this->data['pwd_master'] = $this->Common->fetch($p_table = 'pwd_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/add/ajax_add_disability_info', $this->data, TRUE);
            $response['title'] = 'Add new diability details';
        }

        $response['html'] = $html;
        echo json_encode($response);
    }

    
    public function ajax_save_education_form_data(){  
        $employee_id = isset($this->data['resp']['row-id']) ? base64_decode($this->data['resp']['row-id']) : NULL;
        $degree = isset($this->data['resp']['degree']) ? $this->data['resp']['degree'] : NULL;
        $type_of_degree = isset($this->data['resp']['type_of_degree']) ? $this->data['resp']['type_of_degree'] : NULL;
        $specialization = isset($this->data['resp']['specialization']) ? $this->data['resp']['specialization'] : NULL;
        $board_univ = isset($this->data['resp']['board_univ']) ? $this->data['resp']['board_univ'] : NULL;
        $mark = isset($this->data['resp']['mark']) ? base64_encode($this->data['resp']['mark']) : NULL;
        $yop = isset($this->data['resp']['yop']) ? date('Y-m-d', strtotime(str_replace('/', '-', $this->data['resp']['yop']))) : NULL;
        $certificate_number = isset($this->data['resp']['certificate_number']) ? $this->data['resp']['certificate_number'] : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $employee_id);
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        //$data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['encrypted_code'] = $this->_random_password(32);
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['degree_code'] = $degree;
        $data_to_save['type_of_degree'] = $type_of_degree;
        $data_to_save['specialization'] = $specialization;
        $data_to_save['board_univ_code'] = $board_univ;
        $data_to_save['marks_obtained'] = $mark;
        $data_to_save['date_of_passing'] = $yop;
        $data_to_save['certificate_number'] = $certificate_number;
        $data_to_save['status'] = '1';
        $data_to_save['created'] = date("Y-m-d H:i:s");
        $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 

        if(isset($_FILES['supporting_document'])){
            $config['upload_path'] = './assets/uploads/employee_education/';
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
        $row_id = $this->Common->save($p_table = 'employee_education_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Added a new record in employee education history | ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'board_univ', 'join_on' => 'board_univ.id = employee_education_details.board_univ_code', 'join_type' => 'left', 'join_select' => array('board_univ.bu_name'));
            $join_logic[1] = array('first_table' => 'degree_master', 'join_on' => 'degree_master.id = employee_education_details.degree_code', 'join_type' => 'left', 'join_select' => array('degree_master.degree_name'));
            $this->data['employee_education_details'] = $this->Common->fetch($p_table = 'employee_education_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_education_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'New record added successfully.';
            $response['html'] = $html;
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

    public function ajax_save_address_form_data(){  
        $employee_id = isset($this->data['resp']['row-id']) ? base64_decode($this->data['resp']['row-id']) : NULL;
        $address_type = isset($this->data['resp']['address_type']) ? $this->data['resp']['address_type'] : NULL;
        $address = isset($this->data['resp']['address']) ? base64_encode($this->data['resp']['address']) : NULL;
        $post_office = isset($this->data['resp']['post_office']) ? base64_encode($this->data['resp']['post_office']) : NULL;
        $police_station = isset($this->data['resp']['police_station']) ? base64_encode($this->data['resp']['police_station']) : NULL;
        $district = isset($this->data['resp']['district']) ? base64_encode($this->data['resp']['district']) : NULL;
        $add_line2 = isset($this->data['resp']['add_line2']) ? base64_encode($this->data['resp']['add_line2']) : NULL;
        $state = isset($this->data['resp']['state']) ? base64_encode($this->data['resp']['state']) : NULL;
        $pin = isset($this->data['resp']['pin']) ? base64_encode($this->data['resp']['pin']) : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $employee_id);
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
        $data_to_update = array();
        $data_to_update['address_type'] = '0';
        $data_to_update['modified'] = date("Y-m-d H:i:s");
        $data_to_update['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        $this->db->where('employee_address_details.employee_id', $employee_id);
        $this->db->where("employee_address_details.address_type", $address_type); 
        $this->db->update('employee_address_details', $data_to_update);

        $data_to_save = array();
        //$data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['encrypted_code'] = $this->_random_password(32);
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['address_type'] = $address_type;
        $data_to_save['add_line1'] = $address;
        $data_to_save['add_line2'] = $add_line2;
        $data_to_save['add_po'] = $post_office;
        $data_to_save['add_ps'] = $police_station;
        $data_to_save['add_dist'] = $district;
        $data_to_save['add_state'] = $state;
        $data_to_save['add_pin'] = $pin;
        $data_to_save['status'] = '1';
        $data_to_save['created'] = date("Y-m-d H:i:s");
        $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        $row_id = $this->Common->save($p_table = 'employee_address_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Added a new record in employee employee address| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $this->data['employee_address_details'] = $this->Common->fetch($p_table = 'employee_address_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_address_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'New record added successfully.';
            $response['html'] = $html;
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

    public function ajax_save_bank_form_data(){  
        $employee_id = isset($this->data['resp']['row-id']) ? base64_decode($this->data['resp']['row-id']) : NULL;
        $bank_name = isset($this->data['resp']['bank_name']) ? base64_encode($this->data['resp']['bank_name']) : NULL;
        $bank_branch = isset($this->data['resp']['bank_branch']) ? base64_encode($this->data['resp']['bank_branch']) : NULL;
        $bank_ifsc = isset($this->data['resp']['bank_ifsc']) ? base64_encode($this->data['resp']['bank_ifsc']) : NULL;
        $bank_acc_no = isset($this->data['resp']['bank_acc_no']) ? base64_encode($this->data['resp']['bank_acc_no']) : NULL;
        $bank_acc_type = isset($this->data['resp']['bank_acc_type']) ? base64_encode($this->data['resp']['bank_acc_type']) : NULL;
        $account_purposes = isset($this->data['resp']['account_purposes']) ? base64_encode($this->data['resp']['account_purposes']) : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $employee_id);
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        //$data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['encrypted_code'] = $this->_random_password(32);
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['bank_name'] = $bank_name;
        $data_to_save['bank_branch'] = $bank_branch;
        $data_to_save['bank_ifsc'] = $bank_ifsc;
        $data_to_save['bank_acc_no'] = $bank_acc_no;
        $data_to_save['bank_acc_type'] = $bank_acc_type;
        $data_to_save['account_purposes'] = $account_purposes;
        $data_to_save['status'] = '1';
        $data_to_save['created'] = date("Y-m-d H:i:s");
        $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        if(isset($_FILES['supporting_document'])){
            $config['upload_path'] = './assets/uploads/employee_bank_details/';
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
        $row_id = $this->Common->save($p_table = 'employee_bank_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Added a new record in employee bank details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $this->data['employee_bank_details'] = $this->Common->fetch($p_table = 'employee_bank_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_bank_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'New record added successfully.';
            $response['html'] = $html;
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

    public function ajax_save_dependent_form_data(){  
        $employee_id = isset($this->data['resp']['row-id']) ? base64_decode($this->data['resp']['row-id']) : NULL;
        $priority = isset($this->data['resp']['priority']) ? $this->data['resp']['priority'] : NULL;
        $relation_id = isset($this->data['resp']['relation_id']) ? $this->data['resp']['relation_id'] : NULL;
        $dependent_dob = isset($this->data['resp']['dependent_dob']) ? $this->data['resp']['dependent_dob'] : NULL;
        $nominee_cpf = isset($this->data['resp']['nominee_cpf']) ? $this->data['resp']['nominee_cpf'] : NULL;
        $nominee_gratuity = isset($this->data['resp']['nominee_gratuity']) ? $this->data['resp']['nominee_gratuity'] : NULL;
        $nominee_medical = isset($this->data['resp']['nominee_medical']) ? $this->data['resp']['nominee_medical'] : '0';
        $nominee_ltc = isset($this->data['resp']['nominee_ltc']) ? $this->data['resp']['nominee_ltc'] : '0';
        $income = isset($this->data['resp']['income']) ? $this->data['resp']['income'] : '0';
        $document_type = isset($this->data['resp']['income']) ? $this->data['resp']['document_type'] : '';
        $document_number = isset($this->data['resp']['document_number']) ? $this->data['resp']['document_number'] : '';

        $dependent_name = isset($this->data['resp']['dependent_name']) ? $this->data['resp']['dependent_name'] : NULL;
        $contact_no = isset($this->data['resp']['contact_no']) ? $this->data['resp']['contact_no'] : NULL;
        $address = isset($this->data['resp']['address']) ? $this->data['resp']['address'] : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;
        
        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $employee_id);
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        if(isset($dependent_name) && count($dependent_name) > 0){
            for($i = 0; $i < count($dependent_name); $i++){
                $data_to_save = array();
                //$data_to_save['unique_code'] = $this->_random_password(32);
                $data_to_save['encrypted_code'] = $this->_random_password(32);
                $data_to_save['employee_id'] = $employee_id;
                //$data_to_save['priority'] = $priority[$i];
                $data_to_save['relation_id'] = $relation_id[$i];
                $data_to_save['rel_name'] = base64_encode($dependent_name[$i]);
                $data_to_save['rel_dob'] = date('Y-m-d', strtotime(str_replace('/', '-', $dependent_dob[$i])));        
                $data_to_save['rel_contact'] = base64_encode($contact_no[$i]);
                $data_to_save['address'] = base64_encode($address[$i]);
                $data_to_save['rel_income'] = $income[$i];
                $data_to_save['rel_cpf_nom_percent'] = $nominee_cpf[$i];
                $data_to_save['rel_gratuity_nom_percent'] = $nominee_gratuity[$i];
                $data_to_save['rel_med_app'] = $nominee_medical[$i];
                $data_to_save['rel_ltc_app'] = $nominee_ltc[$i];
                $data_to_save['document_type'] = $document_type[$i];
                $data_to_save['document_number'] = $document_number[$i];
                $data_to_save['status'] = '1';
                $data_to_save['created'] = date("Y-m-d H:i:s");
                $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
                
                $config = array();
                $config['upload_path'] = './assets/uploads/employee_dependent/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                
                if($_FILES['supporting_document']['name'][$i] !== ""){
                    $_FILES['file']['name']     = $_FILES['supporting_document']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['supporting_document']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['supporting_document']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['supporting_document']['error'][$i]; 
                    $_FILES['file']['size']     = $_FILES['supporting_document']['size'][$i]; 
                       
                    
                    if ($this->upload->do_upload('file')) {
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
                // if($_FILES['income_document']['name'][$i] !== ""){
                //     $_FILES['file']['name']     = $_FILES['income_document']['name'][$i]; 
                //     $_FILES['file']['type']     = $_FILES['income_document']['type'][$i]; 
                //     $_FILES['file']['tmp_name'] = $_FILES['income_document']['tmp_name'][$i]; 
                //     $_FILES['file']['error']     = $_FILES['income_document']['error'][$i]; 
                //     $_FILES['file']['size']     = $_FILES['income_document']['size'][$i]; 
                       
                //     $config1 = array();
                //     $config1['upload_path'] = './assets/uploads/income_certificates/';
                //     $config1['allowed_types'] = 'jpg|jpeg|png|pdf';
                //     $config1['overwrite'] = FALSE;
                //     $config1['encrypt_name'] = TRUE;
                //     $config1['remove_spaces'] = TRUE;

                //     $this->upload->initialize($config1);
                //     if ($this->upload->do_upload('file')) {
                //         $file_name =  $this->upload->data();
                //         $data_to_save['income_document'] = $file_name['file_name'];
                //     }else{
                //         $error = $this->upload->display_errors();
                //         $response['code'] = '0';
                //         $response['message'] = $error;
                //         $response['html'] = '';
                //         $response['ftoken'] = '';
                //         echo json_encode($response);
                //         exit();
                //     }
                // }
                //echo "<pre>";print_r($data_to_save);exit();
                $row_id = $this->Common->save($p_table = 'employee_dependents_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
            }
        }
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Added a new record in employee dependent details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'relations', 'join_on' => 'relations.id = employee_dependents_details.relation_id', 'join_type' => 'left', 'join_select' => array('relations.relation'));
            $this->data['employee_dependents_details'] = $this->Common->fetch($p_table = 'employee_dependents_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_dependents_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'New record added successfully.';
            $response['html'] = $html;
            $response['ftoken'] = $ftoken;
            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['message'] = 'Alert! Can\'t add the record. Please try again!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
    }


    public function ajax_save_official_form_data(){  
        $employee_id = isset($this->data['resp']['row-id']) ? base64_decode($this->data['resp']['row-id']) : NULL;
        $center_id = isset($this->data['resp']['center_id']) ? $this->data['resp']['center_id'] : NULL;
        $employee_type_id = isset($this->data['resp']['employee_type_id']) ? $this->data['resp']['employee_type_id'] : NULL;
        //$uan = isset($this->data['resp']['uan']) ? base64_encode($this->data['resp']['uan']) : NULL;
        $department_id = isset($this->data['resp']['department_id']) ? $this->data['resp']['department_id'] : NULL;
        $reporting_officer_id = isset($this->data['resp']['reporting_officer_id']) ? $this->data['resp']['reporting_officer_id'] : 0;
        $alternate_reporting_officer_id = isset($this->data['resp']['alternate_reporting_officer_id']) ? $this->data['resp']['alternate_reporting_officer_id'] : 0;
        $reviewing_officer_id = isset($this->data['resp']['reviewing_officer_id']) ? $this->data['resp']['reviewing_officer_id'] : 0;
        $acceptance_officer_id = isset($this->data['resp']['acceptance_officer_id']) ? $this->data['resp']['acceptance_officer_id'] : 0;
        $designation_id = isset($this->data['resp']['designation_id']) ? $this->data['resp']['designation_id'] : '0';
        $service_book_no = isset($this->data['resp']['service_book_no']) ? $this->data['resp']['service_book_no'] : '0';
        $esic_number = isset($this->data['resp']['esic_number']) ? $this->data['resp']['esic_number'] : '0';
        $date_of_effect = isset($this->data['resp']['date_of_effect']) ? date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $this->data['resp']['date_of_effect']))) : '0';

        //$pension_acc_no = isset($this->data['resp']['pension_acc_no']) ? base64_encode($this->data['resp']['pension_acc_no']) : '';
        $co_opp_acc_no = isset($this->data['resp']['esic_number']) ? base64_encode($this->data['resp']['co_opp_acc_no']) : '';
        //$union_id = isset($this->data['resp']['union_id']) ? $this->data['resp']['union_id'] : '0';
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $employee_id);
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        //$data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['encrypted_code'] = $this->_random_password(32);
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['loc_code'] = $center_id;
        $data_to_save['employee_type_id'] = $employee_type_id;
        //$data_to_save['uan'] = $uan;
        $data_to_save['deptt_code'] = $department_id;        
        $data_to_save['rep_emp_id'] = $reporting_officer_id; 
        $data_to_save['alternate_reporting_officer_id'] = $alternate_reporting_officer_id; 
        $data_to_save['reviewing_officer_id'] = $reviewing_officer_id; 
        $data_to_save['acceptance_officer_id'] = $acceptance_officer_id;
        $data_to_save['desgn_code'] = $designation_id;
        $data_to_save['service_book_no'] = $service_book_no;
        $data_to_save['esic_number'] = $esic_number;
        //$data_to_save['pension_acc_no'] = $pension_acc_no;
        $data_to_save['co_opp_acc_no'] = $co_opp_acc_no;
        //$data_to_save['union_id'] = $union_id;
        $data_to_save['date_of_effect'] = $date_of_effect;
        $data_to_save['status'] = '1';
        $data_to_save['created'] = date("Y-m-d H:i:s");
        $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
                
        $row_id = $this->Common->save($p_table = 'employee_official_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Added a new record in employee official details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'centre_details', 'join_on' => 'centre_details.id = employee_official_details.loc_code', 'join_type' => 'left', 'join_select' => array('centre_details.centre_name'));
            $join_logic[1] = array('first_table' => 'ro_details', 'join_on' => 'ro_details.id = centre_details.ro_id', 'join_type' => 'left', 'join_select' => array('ro_details.ro_name'));
            $join_logic[2] = array('first_table' => 'centre_types', 'join_on' => 'centre_types.id = centre_details.centre_type_id', 'join_type' => 'left', 'join_select' => array('centre_types.centre_type_name'));
            $join_logic[3] = array('first_table' => 'department_master', 'join_on' => 'department_master.id = employee_official_details.deptt_code', 'join_type' => 'left', 'join_select' => array('department_master.name as department_name'));
            $join_logic[4] = array('first_table' => 'hm_emp_master', 'join_on' => 'hm_emp_master.id = employee_official_details.rep_emp_id', 'join_type' => 'left', 'join_select' => array('hm_emp_master.emp_name, hm_emp_master.emp_id'));
            $join_logic[5] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = employee_official_details.desgn_code', 'join_type' => 'left', 'join_select' => array('designation_master.description, designation_master.type as designation_type'));
            $join_logic[6] = array('first_table' => 'employee_types', 'join_on' => 'employee_types.id = employee_official_details.employee_type_id', 'join_type' => 'left', 'join_select' => array('employee_types.type_name'));
            $this->data['employee_official_details'] = $this->Common->fetch($p_table = 'employee_official_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_official_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'New record added successfully.';
            $response['html'] = $html;
            $response['ftoken'] = $ftoken;
            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['message'] = 'Alert! Can\'t add the record. Please try again!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
    }

    public function ajax_save_salary_form_data(){  
        $employee_id = isset($this->data['resp']['row-id']) ? base64_decode($this->data['resp']['row-id']) : NULL;
        $scale_id = isset($this->data['resp']['scale_id']) ? $this->data['resp']['scale_id'] : NULL;
        $basics = isset($this->data['resp']['basics']) ? $this->data['resp']['basics'] : NULL;
        $special_pay = isset($this->data['resp']['special_pay']) ? $this->data['resp']['special_pay'] : NULL;
        $pay_protection = isset($this->data['resp']['pay_protection']) ? $this->data['resp']['pay_protection'] : NULL;
        $da_type = isset($this->data['resp']['da_type']) ? $this->data['resp']['da_type'] : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $employee_id);
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        $data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['encrypted_code'] = $this->_random_password(32);
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['scale_id'] = $scale_id;
        $data_to_save['basics'] = $basics;
        $data_to_save['special_pay'] = $special_pay;
        $data_to_save['pay_protection'] = $pay_protection;
        $data_to_save['da_type'] = $da_type;
        $data_to_save['status'] = '1';
        $data_to_save['created'] = date("Y-m-d H:i:s");
        $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        $row_id = $this->Common->save($p_table = 'employee_salary_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Added a new record in employee salary details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'designation_pay_scale', 'join_on' => 'designation_pay_scale.id = employee_salary_details.scale_id', 'join_type' => 'left', 'join_select' => array('designation_pay_scale.pay_pattern as scale, designation_pay_scale.scale_min, designation_pay_scale.scale_max'));
            $join_logic[1] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = designation_pay_scale.designation_id', 'join_type' => 'left', 'join_select' => array('designation_master.description'));
            $this->data['employee_salary_details'] = $this->Common->fetch($p_table = 'employee_salary_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_salary_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'New record added successfully.';
            $response['html'] = $html;
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

    public function ajax_save_lic_form_data(){  
        $employee_id = isset($this->data['resp']['row-id']) ? base64_decode($this->data['resp']['row-id']) : NULL;
        $policy_no = isset($this->data['resp']['policy_no']) ? $this->data['resp']['policy_no'] : NULL;
        $premium_amount = isset($this->data['resp']['premium_amount']) ? $this->data['resp']['premium_amount'] : NULL;
        $issue_date = isset($this->data['resp']['issue_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $this->data['resp']['issue_date']))) : NULL;
        $maturity_date = isset($this->data['resp']['maturity_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $this->data['resp']['maturity_date']))) : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $employee_id);
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        $data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['encrypted_code'] = $this->_random_password(32);
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['policy_no'] = $policy_no;
        $data_to_save['premium_amount'] = $premium_amount;
        $data_to_save['issue_date'] = $issue_date;
        $data_to_save['maturity_date'] = $maturity_date;
        $data_to_save['status'] = '1';
        $data_to_save['created'] = date("Y-m-d H:i:s");
        $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        if(isset($_FILES['supporting_document'])){
            $config['upload_path'] = './assets/uploads/employee_lic/';
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
        $row_id = $this->Common->save($p_table = 'employee_lic_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Added a new record in employee LIC details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $this->data['employee_lic_details'] = $this->Common->fetch($p_table = 'employee_lic_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_lic_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'New record added successfully.';
            $response['html'] = $html;
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

    public function ajax_save_diability_form_data(){  
        $employee_id = isset($this->data['resp']['row-id']) ? base64_decode($this->data['resp']['row-id']) : NULL;
        $pwd_type = isset($this->data['resp']['pwd_type']) ? $this->data['resp']['pwd_type'] : NULL;
        $disability_percentage = isset($this->data['resp']['disability_percentage']) ? base64_encode($this->data['resp']['disability_percentage']) : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $employee_id);
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        $data_to_save['encrypted_code'] = $this->_random_password(32);
        $data_to_save['emp_id'] = $employee_id;
        $data_to_save['pwd_type_id'] = $pwd_type;
        $data_to_save['pwd_percentage'] = $disability_percentage;
        $data_to_save['status'] = '1';
        $data_to_save['created'] = date("Y-m-d H:i:s");
        $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        if(isset($_FILES['disability_certificate'])){
            $config['upload_path'] = './assets/uploads/disability_certificates/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('disability_certificate')) {
                $file_name =  $this->upload->data();
                $data_to_save['disability_certificate'] = $file_name['file_name'];
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
        $row_id = $this->Common->save($p_table = 'emp_pwd_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Added a new record in employee Disability details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'emp_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'pwd_master', 'join_on' => 'pwd_master.id = emp_pwd_details.pwd_type_id', 'join_type' => 'left', 'join_select' => array('pwd_master.pwd_name'));
            $this->data['employee_pwd_details'] = $this->Common->fetch($p_table = 'emp_pwd_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_pwd_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'New record added successfully.';
            $response['html'] = $html;
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

    function ajax_refresh_page($cond_text = NULL) {  
        $cond_custom = NULL;      
        $cond_and = array();
        $cond_and = array('status <>' => '5');

        if($cond_text !== NULL){
            $cond_custom = $cond_text;
        }

        //pagination settings
        $pagiConfig['base_url'] = base_url($this->data['controller'] . '/lists');

        $pagiConfig['total_rows'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = TRUE, $return_object = FALSE, $debug = FALSE);
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

        $this->data['results'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'DESC'), $limit = $pagiConfig['per_page'], $offset = $this->data['offset'], $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


        if(!$this->session->userdata($this->data['sess_code'] . '_ftoken')){
            $this->data['_ftoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $this->data['_ftoken']);
        }else{
            $this->data['_ftoken'] = $this->session->userdata($this->data['sess_code'] . '_ftoken');
        }

        $html = $this->load->view('employees/ajax/ajax_lists', $this->data, TRUE);

        return $html;
    }

    public function ajax_search(){        
        $search_text = isset($this->data['resp']['input_value']) &&  $this->data['resp']['input_value'] !== ''? $this->data['resp']['input_value'] : NULL;
        $filter_value = isset($this->data['resp']['filter_value']) &&  $this->data['resp']['filter_value'] !== ''? $this->data['resp']['filter_value'] : NULL;

        $cond_text = NULL;
        if($filter_value !== NULL){  
            if($search_text !== NULL){
                $cond_text .= ' AND FROM_BASE64(`' . $filter_value . '`) LIKE "%' . $search_text . '%"';
            }
        }

        $resp = $this->ajax_refresh_page($cond_text);
        echo $resp;
    }

    public function ajax_add_more_dependent(){
        $row_count = isset($this->data['resp']['row_count']) ? $this->data['resp']['row_count'] : NULL;
        $row_code = isset($this->data['resp']['row_code']) ? $this->data['resp']['row_code'] : NULL;

        $this->data['enc_code'] = $this->_random_password(32);
        $this->data['dependent_count'] = $row_count + 1;
        $this->data['pre_enc_code'] = $row_code;
        
        $cond_and = array();
        $cond_and = array('status' => '1');
        $this->data['relations'] = $this->Common->fetch($p_table = 'relations', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $html = $this->load->view('employees/ajax/ajax_add_more_dependents', $this->data, TRUE);

        $response['html'] = $html;
        $response['enc_code'] = $this->data['enc_code'];
        $response['dependent_count'] = $this->data['dependent_count'];
        echo json_encode($response);
    }

    public function ajax_auto_update(){  
        $cond_and = array();
        $cond_and = array('status <>' => '5');
        $results = $this->Common->fetch($p_table = 'designation_pay_scale', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(isset($results)) {
            foreach($results as $value){
                $data_to_save = array();
                $data_to_save['id'] = $value['id'];
                $data_to_save['unique_code'] = $this->_random_password(32);
                $data_to_save['encrypted_code'] = $this->_random_password(32);
                //$data_to_save['type_name'] = base64_encode($value['type_name']);
                $data_to_save['status'] = '1';
                $data_to_save['created'] = date("Y-m-d H:i:s");
                $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 

                $this->Common->update($p_table = 'designation_pay_scale', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
            }
            echo 'done';
        }
    }

    public function ajax_auto_update1(){  
        $cond_and = array();
        $results = $this->Common->fetch($p_table = 'designation_master1', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(isset($results)) {
            foreach($results as $value){
                $data_to_save = array();
                $data_to_save['desig_code'] = $value['desig_code'];
                $data_to_save['designation_id'] = $value['id'];

                $this->Common->update($p_table = 'designation_pay_scale', $p_key = 'desig_code', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
            }
            echo 'done';
        }
    }

    //Edit employee details
    public function ajax_load_edit_form(){
        $data_row = isset($this->data['resp']['row_type']) ? $this->data['resp']['row_type'] : NULL;
        $row_code = isset($this->data['resp']['row_code']) ? $this->data['resp']['row_code'] : NULL;
        $data_code = isset($this->data['resp']['data_code']) ? $this->data['resp']['data_code'] : NULL;
        $html = '';

        if(!$this->session->userdata($this->data['sess_code'] . '_ftoken')){
            $this->data['_ftoken'] = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $this->data['_ftoken']);
        }else{
            $this->data['_ftoken'] = $this->session->userdata($this->data['sess_code'] . '_ftoken');
        }

        if($data_row == 'education'){
            $this->data['employee_id'] = $data_code;
            $this->data['row_code'] = $row_code;

            $cond_and = array();
            $cond_and = array('status' => '1');
            $this->data['board_univ'] = $this->Common->fetch($p_table = 'board_univ', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['degrees'] = $this->Common->fetch($p_table = 'degree_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => base64_decode($row_code));
            $this->data['education_details'] = $this->Common->fetch($p_table = 'employee_education_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/edit/ajax_edit_education', $this->data, TRUE);
            $response['title'] = 'Edit educaton history';
        }elseif($data_row == 'address'){
            $this->data['employee_id'] = $data_code;
            $this->data['row_code'] = $row_code;

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => base64_decode($row_code));
            $this->data['address_details'] = $this->Common->fetch($p_table = 'employee_address_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/edit/ajax_edit_address', $this->data, TRUE);
            $response['title'] = 'Edit address';
        }elseif($data_row == 'bank'){
            $this->data['employee_id'] = $data_code;
            $this->data['row_code'] = $row_code;

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => base64_decode($row_code));
            $this->data['bank_details'] = $this->Common->fetch($p_table = 'employee_bank_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/edit/ajax_edit_bank_details', $this->data, TRUE);
            $response['title'] = 'Edit bank details';
        }elseif($data_row == 'dependent'){
            $this->data['employee_id'] = $data_code;
            $this->data['row_code'] = $row_code;

            $this->data['dependent_count'] = '1';
            
            $cond_and = array();
            $cond_and = array('status' => '1');
            $this->data['relations'] = $this->Common->fetch($p_table = 'relations', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'employee_id' => base64_decode($data_code));
            $this->data['dependents_details'] = $this->Common->fetch($p_table = 'employee_dependents_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/edit/ajax_edit_dependents', $this->data, TRUE);
            $response['title'] = 'Edit family details';
        }elseif($data_row == 'official'){
            $this->data['row_code'] = $row_code;
            $this->data['employee_id'] = $data_code;
            
            $cond_and = array();
            $cond_and = array('status' => '1');
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'ro_details', 'join_on' => 'ro_details.id = centre_details.ro_id', 'join_type' => 'left', 'join_select' => array('ro_details.ro_name'));
            $join_logic[1] = array('first_table' => 'centre_types', 'join_on' => 'centre_types.id = centre_details.centre_type_id', 'join_type' => 'left', 'join_select' => array('centre_types.centre_type_name'));
            $this->data['centre_details'] = $this->Common->fetch($p_table = 'centre_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['department_master'] = $this->Common->fetch($p_table = 'department_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['designation_master'] = $this->Common->fetch($p_table = 'designation_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['employee_types'] = $this->Common->fetch($p_table = 'employee_types', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $this->data['unions'] = $this->Common->fetch($p_table = 'unions', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id <>' => base64_decode($data_code));
            $this->data['employees'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => base64_decode($row_code));
            $this->data['official_details'] = $this->Common->fetch($p_table = 'employee_official_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/edit/ajax_edit_official_details', $this->data, TRUE);
            $response['title'] = 'Edit official details';
        }elseif($data_row == 'salary'){
            $this->data['employee_id'] = $data_code;
            $this->data['row_code'] = $row_code;

            $cond_and = array();
            $cond_and = array('status' => '1');
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = designation_pay_scale.designation_id', 'join_type' => 'left', 'join_select' => array('designation_master.description'));
            $this->data['designation_pay_scale'] = $this->Common->fetch($p_table = 'designation_pay_scale', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => base64_decode($row_code));
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'designation_pay_scale', 'join_on' => 'designation_pay_scale.id = employee_salary_details.scale_id', 'join_type' => 'left');
            $join_logic[1] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = designation_pay_scale.designation_id', 'join_type' => 'left', 'join_select' => array('designation_master.id as designation_id'));
            $this->data['salary_details'] = $this->Common->fetch($p_table = 'employee_salary_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/edit/ajax_edit_salary_details', $this->data, TRUE);
            $response['title'] = 'Edit salary details';
        }elseif($data_row == 'lic'){
            $this->data['employee_id'] = $data_code;
            $this->data['row_code'] = $row_code;

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => base64_decode($row_code));
            $this->data['lic_details'] = $this->Common->fetch($p_table = 'employee_lic_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/edit/ajax_edit_lic_info', $this->data, TRUE);
            $response['title'] = 'Edit LIC details';
        }elseif($data_row == 'diability'){
            $this->data['employee_id'] = $data_code;
            $this->data['row_code'] = $row_code;


            $cond_and = array();
            $cond_and = array('status' => '1');
            $this->data['pwd_master'] = $this->Common->fetch($p_table = 'pwd_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => base64_decode($row_code));
            $this->data['pwd_details'] = $this->Common->fetch($p_table = 'emp_pwd_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/edit/ajax_edit_disability_info', $this->data, TRUE);
            $response['title'] = 'Edit disability details';
        }

        $response['html'] = $html;
        echo json_encode($response);
    }

    public function ajax_update_official_form_data(){  
        $employee_id = isset($this->data['resp']['data-code']) ? base64_decode($this->data['resp']['data-code']) : NULL;
        $id = isset($this->data['resp']['row-code']) ? base64_decode($this->data['resp']['row-code']) : NULL;
        $center_id = isset($this->data['resp']['center_id']) ? $this->data['resp']['center_id'] : NULL;
        $employee_type_id = isset($this->data['resp']['employee_type_id']) ? $this->data['resp']['employee_type_id'] : NULL;
        //$uan = isset($this->data['resp']['uan']) ? base64_encode($this->data['resp']['uan']) : NULL;
        $department_id = isset($this->data['resp']['department_id']) ? $this->data['resp']['department_id'] : NULL;
        $reporting_officer_id = isset($this->data['resp']['reporting_officer_id']) ? $this->data['resp']['reporting_officer_id'] : 0;
        $alternate_reporting_officer_id = isset($this->data['resp']['alternate_reporting_officer_id']) ? $this->data['resp']['alternate_reporting_officer_id'] : 0;
        $reviewing_officer_id = isset($this->data['resp']['reviewing_officer_id']) ? $this->data['resp']['reviewing_officer_id'] : 0;
        $acceptance_officer_id = isset($this->data['resp']['acceptance_officer_id']) ? $this->data['resp']['acceptance_officer_id'] : 0;
        $designation_id = isset($this->data['resp']['designation_id']) ? $this->data['resp']['designation_id'] : '0';
        $service_book_no = isset($this->data['resp']['service_book_no']) ? $this->data['resp']['service_book_no'] : '0';
        $esic_number = isset($this->data['resp']['esic_number']) ? $this->data['resp']['esic_number'] : '0';
        $date_of_effect = isset($this->data['resp']['date_of_effect']) ? date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $this->data['resp']['date_of_effect']))) : '0';

        $pension_acc_no = isset($this->data['resp']['pension_acc_no']) ? base64_encode($this->data['resp']['pension_acc_no']) : '';
        $co_opp_acc_no = isset($this->data['resp']['esic_number']) ? base64_encode($this->data['resp']['co_opp_acc_no']) : '';
        //$union_id = isset($this->data['resp']['union_id']) ? $this->data['resp']['union_id'] : '0';
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'hm_emp_master', 'join_on' => 'hm_emp_master.id = employee_official_details.employee_id', 'join_type' => 'left', 'join_condition' => array('hm_emp_master.id' => $employee_id));
        $this->data['employee_official_details'] = $this->Common->fetch($p_table = 'employee_official_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_official_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        //$data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['id'] = $id;
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['loc_code'] = $center_id;
        $data_to_save['employee_type_id'] = $employee_type_id;
        //$data_to_save['uan'] = $uan;
        $data_to_save['deptt_code'] = $department_id;        
        $data_to_save['rep_emp_id'] = $reporting_officer_id;
        $data_to_save['alternate_reporting_officer_id'] = $alternate_reporting_officer_id; 
        $data_to_save['reviewing_officer_id'] = $reviewing_officer_id; 
        $data_to_save['acceptance_officer_id'] = $acceptance_officer_id;
        $data_to_save['desgn_code'] = $designation_id;
        $data_to_save['service_book_no'] = $service_book_no;
        $data_to_save['esic_number'] = $esic_number;
        $data_to_save['pension_acc_no'] = $pension_acc_no;
        $data_to_save['co_opp_acc_no'] = $co_opp_acc_no;
        //$data_to_save['union_id'] = $union_id;
        $data_to_save['date_of_effect'] = $date_of_effect;
        $data_to_save['status'] = '1';
        $data_to_save['modified'] = date("Y-m-d H:i:s");
        $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
                
        $row_id = $this->Common->update($p_table = 'employee_official_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Edit a record in employee official details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'centre_details', 'join_on' => 'centre_details.id = employee_official_details.loc_code', 'join_type' => 'left', 'join_select' => array('centre_details.centre_name'));
            $join_logic[1] = array('first_table' => 'ro_details', 'join_on' => 'ro_details.id = centre_details.ro_id', 'join_type' => 'left', 'join_select' => array('ro_details.ro_name'));
            $join_logic[2] = array('first_table' => 'centre_types', 'join_on' => 'centre_types.id = centre_details.centre_type_id', 'join_type' => 'left', 'join_select' => array('centre_types.centre_type_name'));
            $join_logic[3] = array('first_table' => 'department_master', 'join_on' => 'department_master.id = employee_official_details.deptt_code', 'join_type' => 'left', 'join_select' => array('department_master.name as department_name'));
            $join_logic[4] = array('first_table' => 'hm_emp_master', 'join_on' => 'hm_emp_master.id = employee_official_details.rep_emp_id', 'join_type' => 'left', 'join_select' => array('hm_emp_master.emp_name, hm_emp_master.emp_id'));
            $join_logic[5] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = employee_official_details.desgn_code', 'join_type' => 'left', 'join_select' => array('designation_master.description, designation_master.type as designation_type'));
            $join_logic[6] = array('first_table' => 'employee_types', 'join_on' => 'employee_types.id = employee_official_details.employee_type_id', 'join_type' => 'left', 'join_select' => array('employee_types.type_name'));
            $this->data['employee_official_details'] = $this->Common->fetch($p_table = 'employee_official_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => $employee_id);
            $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


            $html = $this->load->view('employees/ajax/ajax_official_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully.';
            $response['html'] = $html;
            $response['ftoken'] = $ftoken;
            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['message'] = 'Alert! Can\'t add the record. Please try again!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
    }

    public function ajax_update_education_form_data(){  
        $employee_id = isset($this->data['resp']['data-code']) ? base64_decode($this->data['resp']['data-code']) : NULL;
        $id = isset($this->data['resp']['row-code']) ? base64_decode($this->data['resp']['row-code']) : NULL;
        $degree = isset($this->data['resp']['degree']) ? $this->data['resp']['degree'] : NULL;
        $type_of_degree = isset($this->data['resp']['type_of_degree']) ? $this->data['resp']['type_of_degree'] : NULL;
        $specialization = isset($this->data['resp']['specialization']) ? $this->data['resp']['specialization'] : NULL;
        $board_univ = isset($this->data['resp']['board_univ']) ? $this->data['resp']['board_univ'] : NULL;
        $mark = isset($this->data['resp']['mark']) ? base64_encode($this->data['resp']['mark']) : NULL;
        $yop = isset($this->data['resp']['yop']) ? date('Y-m-d', strtotime(str_replace('/', '-', $this->data['resp']['yop']))) : NULL;
        $certificate_number = isset($this->data['resp']['certificate_number']) ? $this->data['resp']['certificate_number'] : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $employee_id, 'id' => $id);
        $join_logic = array();
        $this->data['education_details'] = $this->Common->fetch($p_table = 'employee_education_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['education_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        $data_to_save['id'] = $id;
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['degree_code'] = $degree;
        $data_to_save['type_of_degree'] = $type_of_degree;
        $data_to_save['specialization'] = $specialization;
        $data_to_save['board_univ_code'] = $board_univ;
        $data_to_save['marks_obtained'] = $mark;
        $data_to_save['date_of_passing'] = $yop;
        $data_to_save['certificate_number'] = $certificate_number;
        $data_to_save['status'] = '1';
        $data_to_save['modified'] = date("Y-m-d H:i:s");
        $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 

        if(isset($_FILES['supporting_document']) && $_FILES['supporting_document']['name'] !== ''){
            $config['upload_path'] = './assets/uploads/employee_education/';
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
        $row_id = $this->Common->update($p_table = 'employee_education_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Updated a record in employee education history | ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'board_univ', 'join_on' => 'board_univ.id = employee_education_details.board_univ_code', 'join_type' => 'left', 'join_select' => array('board_univ.bu_name'));
            $join_logic[1] = array('first_table' => 'degree_master', 'join_on' => 'degree_master.id = employee_education_details.degree_code', 'join_type' => 'left', 'join_select' => array('degree_master.degree_name'));
            $this->data['employee_education_details'] = $this->Common->fetch($p_table = 'employee_education_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => $employee_id);
            $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_education_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully.';
            $response['html'] = $html;
            $response['ftoken'] = $ftoken;
            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['message'] = 'Alert! Can\'t update the record. PLease try again!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
    }

    public function ajax_update_address_form_data(){  
        $employee_id = isset($this->data['resp']['data-code']) ? base64_decode($this->data['resp']['data-code']) : NULL;
        $id = isset($this->data['resp']['row-code']) ? base64_decode($this->data['resp']['row-code']) : NULL;
        $address_type = isset($this->data['resp']['address_type']) ? $this->data['resp']['address_type'] : NULL;
        $address = isset($this->data['resp']['address']) ? base64_encode($this->data['resp']['address']) : NULL;
        $post_office = isset($this->data['resp']['post_office']) ? base64_encode($this->data['resp']['post_office']) : NULL;
        $police_station = isset($this->data['resp']['police_station']) ? base64_encode($this->data['resp']['police_station']) : NULL;
        $district = isset($this->data['resp']['district']) ? base64_encode($this->data['resp']['district']) : NULL;
        $add_line2 = isset($this->data['resp']['add_line2']) ? base64_encode($this->data['resp']['add_line2']) : NULL;
        $state = isset($this->data['resp']['state']) ? base64_encode($this->data['resp']['state']) : NULL;
        $pin = isset($this->data['resp']['pin']) ? base64_encode($this->data['resp']['pin']) : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $employee_id, 'id' => $id);
        $join_logic = array();
        $this->data['address_details'] = $this->Common->fetch($p_table = 'employee_address_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['address_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
        $data_to_update = array();
        $data_to_update['address_type'] = '0';
        $data_to_update['modified'] = date("Y-m-d H:i:s");
        $data_to_update['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        $this->db->where('employee_address_details.employee_id', $employee_id);
        $this->db->where("employee_address_details.address_type", $address_type); 
        $this->db->update('employee_address_details', $data_to_update);

        $data_to_save = array();
        //$data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['id'] = $id;
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['address_type'] = $address_type;
        $data_to_save['add_line1'] = $address;
        $data_to_save['add_line2'] = $add_line2;
        $data_to_save['add_po'] = $post_office;
        $data_to_save['add_ps'] = $police_station;
        $data_to_save['add_dist'] = $district;
        $data_to_save['add_state'] = $state;
        $data_to_save['add_pin'] = $pin;
        $data_to_save['status'] = '1';
        $data_to_save['modified'] = date("Y-m-d H:i:s");
        $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        $row_id = $this->Common->update($p_table = 'employee_address_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Updated a record in employee employee address| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $this->data['employee_address_details'] = $this->Common->fetch($p_table = 'employee_address_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => $employee_id);
            $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_address_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully.';
            $response['html'] = $html;
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


    public function ajax_update_bank_form_data(){  
        $employee_id = isset($this->data['resp']['data-code']) ? base64_decode($this->data['resp']['data-code']) : NULL;
        $id = isset($this->data['resp']['row-code']) ? base64_decode($this->data['resp']['row-code']) : NULL;
        $bank_name = isset($this->data['resp']['bank_name']) ? base64_encode($this->data['resp']['bank_name']) : NULL;
        $bank_branch = isset($this->data['resp']['bank_branch']) ? base64_encode($this->data['resp']['bank_branch']) : NULL;
        $bank_ifsc = isset($this->data['resp']['bank_ifsc']) ? base64_encode($this->data['resp']['bank_ifsc']) : NULL;
        $bank_acc_no = isset($this->data['resp']['bank_acc_no']) ? base64_encode($this->data['resp']['bank_acc_no']) : NULL;
        $bank_acc_type = isset($this->data['resp']['bank_acc_type']) ? base64_encode($this->data['resp']['bank_acc_type']) : NULL;
        $account_purposes = isset($this->data['resp']['account_purposes']) ? base64_encode($this->data['resp']['account_purposes']) : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $employee_id, 'id' => $id);
        $join_logic = array();
        $this->data['bank_details'] = $this->Common->fetch($p_table = 'employee_bank_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['bank_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        //$data_to_save['unique_code'] = $this->_random_password(32);
        $data_to_save['id'] = $id;
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['bank_name'] = $bank_name;
        $data_to_save['bank_branch'] = $bank_branch;
        $data_to_save['bank_ifsc'] = $bank_ifsc;
        $data_to_save['bank_acc_no'] = $bank_acc_no;
        $data_to_save['bank_acc_type'] = $bank_acc_type;
        $data_to_save['account_purposes'] = $account_purposes;
        $data_to_save['status'] = '1';
        $data_to_save['modified'] = date("Y-m-d H:i:s");
        $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        if(isset($_FILES['supporting_document']) && $_FILES['supporting_document']['name'] !== ''){
            $config['upload_path'] = './assets/uploads/employee_bank_details/';
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
        $row_id = $this->Common->update($p_table = 'employee_bank_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Edit a record in employee bank details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $this->data['employee_bank_details'] = $this->Common->fetch($p_table = 'employee_bank_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => $employee_id);
            $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_bank_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully.';
            $response['html'] = $html;
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


    public function ajax_update_salary_form_data(){  
        $employee_id = isset($this->data['resp']['data-code']) ? base64_decode($this->data['resp']['data-code']) : NULL;
        $id = isset($this->data['resp']['row-code']) ? base64_decode($this->data['resp']['row-code']) : NULL;
        $scale_id = isset($this->data['resp']['scale_id']) ? $this->data['resp']['scale_id'] : NULL;
        $basics = isset($this->data['resp']['basics']) ? $this->data['resp']['basics'] : NULL;
        $special_pay = isset($this->data['resp']['special_pay']) ? $this->data['resp']['special_pay'] : NULL;
        $pay_protection = isset($this->data['resp']['pay_protection']) ? $this->data['resp']['pay_protection'] : NULL;
        $da_type = isset($this->data['resp']['da_type']) ? $this->data['resp']['da_type'] : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $employee_id, 'id' => $id);
        $join_logic = array();
        $this->data['salary_details'] = $this->Common->fetch($p_table = 'employee_salary_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['salary_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        $data_to_save['id'] = $id;
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['scale_id'] = $scale_id;
        $data_to_save['basics'] = $basics;
        $data_to_save['special_pay'] = $special_pay;
        $data_to_save['pay_protection'] = $pay_protection;
        $data_to_save['da_type'] = $da_type;
        $data_to_save['status'] = '1';
        $data_to_save['modified'] = date("Y-m-d H:i:s");
        $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        $row_id = $this->Common->update($p_table = 'employee_salary_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Edit a record in employee salary details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'designation_pay_scale', 'join_on' => 'designation_pay_scale.id = employee_salary_details.scale_id', 'join_type' => 'left', 'join_select' => array('designation_pay_scale.pay_pattern as scale, designation_pay_scale.scale_min, designation_pay_scale.scale_max'));
            $join_logic[1] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = designation_pay_scale.designation_id', 'join_type' => 'left', 'join_select' => array('designation_master.description'));
            $this->data['employee_salary_details'] = $this->Common->fetch($p_table = 'employee_salary_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => $employee_id);
            $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_salary_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully.';
            $response['html'] = $html;
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


    public function ajax_update_lic_form_data(){  
        $employee_id = isset($this->data['resp']['data-code']) ? base64_decode($this->data['resp']['data-code']) : NULL;
        $id = isset($this->data['resp']['row-code']) ? base64_decode($this->data['resp']['row-code']) : NULL;
        $policy_no = isset($this->data['resp']['policy_no']) ? $this->data['resp']['policy_no'] : NULL;
        $premium_amount = isset($this->data['resp']['premium_amount']) ? $this->data['resp']['premium_amount'] : NULL;
        $issue_date = isset($this->data['resp']['issue_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $this->data['resp']['issue_date']))) : NULL;
        $maturity_date = isset($this->data['resp']['maturity_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $this->data['resp']['maturity_date']))) : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $employee_id, 'id' => $id);
        $join_logic = array();
        $this->data['lic_details'] = $this->Common->fetch($p_table = 'employee_lic_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['lic_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        $data_to_save['id'] = $id;
        $data_to_save['employee_id'] = $employee_id;
        $data_to_save['policy_no'] = $policy_no;
        $data_to_save['premium_amount'] = $premium_amount;
        $data_to_save['issue_date'] = $issue_date;
        $data_to_save['maturity_date'] = $maturity_date;
        $data_to_save['status'] = '1';
        $data_to_save['modified'] = date("Y-m-d H:i:s");
        $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        if(isset($_FILES['supporting_document']) && $_FILES['supporting_document']['name'] !== ''){
            $config['upload_path'] = './assets/uploads/employee_lic/';
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
        $row_id = $this->Common->update($p_table = 'employee_lic_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Edit a record in employee LIC details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $this->data['employee_lic_details'] = $this->Common->fetch($p_table = 'employee_lic_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => $employee_id);
            $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_lic_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully.';
            $response['html'] = $html;
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

    public function ajax_update_dependent_form_data(){  
        $id = isset($this->data['resp']['row-code']) ? $this->data['resp']['row-code'] : NULL;
        $employee_id = isset($this->data['resp']['row-id']) ? base64_decode($this->data['resp']['row-id']) : NULL;
        $priority = isset($this->data['resp']['priority']) ? $this->data['resp']['priority'] : NULL;
        $relation_id = isset($this->data['resp']['relation_id']) ? $this->data['resp']['relation_id'] : NULL;
        $dependent_dob = isset($this->data['resp']['dependent_dob']) ? $this->data['resp']['dependent_dob'] : NULL;
        $nominee_cpf = isset($this->data['resp']['nominee_cpf']) ? $this->data['resp']['nominee_cpf'] : NULL;
        $nominee_gratuity = isset($this->data['resp']['nominee_gratuity']) ? $this->data['resp']['nominee_gratuity'] : NULL;
        $nominee_medical = isset($this->data['resp']['nominee_medical']) ? $this->data['resp']['nominee_medical'] : '0';
        $nominee_ltc = isset($this->data['resp']['nominee_ltc']) ? $this->data['resp']['nominee_ltc'] : '0';
        $income = isset($this->data['resp']['income']) ? $this->data['resp']['income'] : '0';
        $document_type = isset($this->data['resp']['income']) ? $this->data['resp']['document_type'] : '';
        $document_number = isset($this->data['resp']['document_number']) ? $this->data['resp']['document_number'] : '';

        $dependent_name = isset($this->data['resp']['dependent_name']) ? $this->data['resp']['dependent_name'] : NULL;
        $contact_no = isset($this->data['resp']['contact_no']) ? $this->data['resp']['contact_no'] : NULL;
        $address = isset($this->data['resp']['address']) ? $this->data['resp']['address'] : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;
        
        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'employee_id' => $employee_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'hm_emp_master', 'join_on' => 'hm_emp_master.id = employee_dependents_details.employee_id', 'join_type' => 'left', 'join_condition' => array('hm_emp_master.status <>' => '5'));
        $this->data['dependents_details'] = $this->Common->fetch($p_table = 'employee_dependents_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['dependents_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        if(isset($dependent_name) && count($dependent_name) > 0){
            $this->Common->p_delete($p_table = 'employee_dependents_details', $p_key = 'employee_id', $row_id = $employee_id, $cond = NULL, $debug = FALSE);
            for($i = 0; $i < count($dependent_name); $i++){
                $data_to_save = array();
                $data_to_save['encrypted_code'] = $this->_random_password(32);
                $data_to_save['employee_id'] = $employee_id;
                //$data_to_save['priority'] = $priority[$i];
                $data_to_save['relation_id'] = $relation_id[$i];
                $data_to_save['rel_name'] = base64_encode($dependent_name[$i]);
                $data_to_save['rel_dob'] = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $dependent_dob[$i])));        
                $data_to_save['rel_contact'] = base64_encode($contact_no[$i]);
                $data_to_save['address'] = base64_encode($address[$i]);
                $data_to_save['rel_income'] = $income[$i];
                $data_to_save['rel_cpf_nom_percent'] = $nominee_cpf[$i];
                $data_to_save['rel_gratuity_nom_percent'] = $nominee_gratuity[$i];
                $data_to_save['rel_med_app'] = $nominee_medical[$i];
                $data_to_save['rel_ltc_app'] = $nominee_ltc[$i];
                $data_to_save['document_type'] = $document_type[$i];
                $data_to_save['document_number'] = $document_number[$i];
                $data_to_save['status'] = '1';
                $data_to_save['created'] = date("Y-m-d H:i:s");
                $data_to_save['created_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
                
                $config = array();
                $config['upload_path'] = './assets/uploads/employee_dependent/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                
                if($_FILES['supporting_document']['name'][$i] !== ""){
                    $_FILES['file']['name']     = $_FILES['supporting_document']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['supporting_document']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['supporting_document']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['supporting_document']['error'][$i]; 
                    $_FILES['file']['size']     = $_FILES['supporting_document']['size'][$i]; 
                       
                    
                    if ($this->upload->do_upload('file')) {
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
                // if($_FILES['income_document']['name'][$i] !== ""){
                //     $_FILES['file']['name']     = $_FILES['income_document']['name'][$i]; 
                //     $_FILES['file']['type']     = $_FILES['income_document']['type'][$i]; 
                //     $_FILES['file']['tmp_name'] = $_FILES['income_document']['tmp_name'][$i]; 
                //     $_FILES['file']['error']     = $_FILES['income_document']['error'][$i]; 
                //     $_FILES['file']['size']     = $_FILES['income_document']['size'][$i]; 
                       
                //     $config1 = array();
                //     $config1['upload_path'] = './assets/uploads/income_certificates/';
                //     $config1['allowed_types'] = 'jpg|jpeg|png|pdf';
                //     $config1['overwrite'] = FALSE;
                //     $config1['encrypt_name'] = TRUE;
                //     $config1['remove_spaces'] = TRUE;

                //     $this->upload->initialize($config1);
                //     if ($this->upload->do_upload('file')) {
                //         $file_name =  $this->upload->data();
                //         $data_to_save['income_document'] = $file_name['file_name'];
                //     }else{
                //         $error = $this->upload->display_errors();
                //         $response['code'] = '0';
                //         $response['message'] = $error;
                //         $response['html'] = '';
                //         $response['ftoken'] = '';
                //         echo json_encode($response);
                //         exit();
                //     }
                // }
                //echo "<pre>";print_r($data_to_save);exit();
                $row_id = $this->Common->save($p_table = 'employee_dependents_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
            }
        }
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Edit record in employee dependent details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'employee_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'relations', 'join_on' => 'relations.id = employee_dependents_details.relation_id', 'join_type' => 'left', 'join_select' => array('relations.relation'));
            $this->data['employee_dependents_details'] = $this->Common->fetch($p_table = 'employee_dependents_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => $employee_id);
            $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_dependents_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully.';
            $response['html'] = $html;
            $response['ftoken'] = $ftoken;
            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['message'] = 'Alert! Can\'t add the record. Please try again!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }
    }

    public function ajax_update_disability_form_data(){  
        $employee_id = isset($this->data['resp']['data-code']) ? base64_decode($this->data['resp']['data-code']) : NULL;
        $id = isset($this->data['resp']['row-code']) ? base64_decode($this->data['resp']['row-code']) : NULL;
        $pwd_type = isset($this->data['resp']['pwd_type']) ? $this->data['resp']['pwd_type'] : NULL;
        $disability_percentage = isset($this->data['resp']['disability_percentage']) ? base64_encode($this->data['resp']['disability_percentage']) : NULL;
        $ftoken = isset($this->data['resp']['_ftoken']) ? $this->data['resp']['_ftoken'] : NULL;

        if ($ftoken == NULL || $ftoken !== $this->session->userdata($this->data['sess_code'] . '_ftoken')) {
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'emp_id' => $employee_id, 'id' => $id);
        $join_logic = array();
        $this->data['pwd_details'] = $this->Common->fetch($p_table = 'emp_pwd_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['pwd_details'])){ 
            $response['code'] = '0';
            $response['message'] = 'Can\'t find the employee details!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $data_to_save = array();
        $data_to_save['id'] = $id;
        $data_to_save['emp_id'] = $employee_id;
        $data_to_save['pwd_type_id'] = $pwd_type;
        $data_to_save['pwd_percentage'] = $disability_percentage;
        $data_to_save['status'] = '1';
        $data_to_save['modified'] = date("Y-m-d H:i:s");
        $data_to_save['modified_by'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
        
        if(isset($_FILES['disability_certificate']) && $_FILES['disability_certificate']['name'] !== ''){
            $config['upload_path'] = './assets/uploads/disability_certificates/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('disability_certificate')) {
                $file_name =  $this->upload->data();
                $data_to_save['disability_certificate'] = $file_name['file_name'];
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
        $row_id = $this->Common->update($p_table = 'emp_pwd_details', $p_key = 'id', $data_array = $data_to_save, $cond = NULL, $debug = FALSE);
        if(isset($row_id)){
            /* ------------------------------------- SYSTEM LOG STARTS ------------------------------------- */
            $action_string = base64_encode(json_encode($data_to_save));
            $system_log_array['user_id'] = $this->session->userdata($this->data['sess_code'] . 'user_id'); 
            $system_log_array['controller_name'] = $this->data['controller'];
            $system_log_array['method_name'] = $this->data['method'];
            $system_log_array['row_id'] = $row_id;
            $system_log_array['action'] = 'Edit a record in employee PWD details| ' . $action_string;
            $system_log_array['time'] = date('Y-m-d H:i:s');
            $system_log_array['ip_address'] = $this->input->ip_address();
            $system_log_array['user_browser'] = $this->get_browser();
            $temp = $this->Common->save($p_table = 'system_log', $p_key = 'id', $data_array = $system_log_array, $cond = array(), $debug = FALSE);
            /* ------------------------------------- SYSTEM LOG ENDS --------------------------------------- */

            $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
            $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

            $cond_and = array();
            $cond_and = array('status <>' => '5', 'emp_id' => $employee_id);
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'pwd_master', 'join_on' => 'pwd_master.id = emp_pwd_details.pwd_type_id', 'join_type' => 'left', 'join_select' => array('pwd_master.pwd_name'));
            $this->data['employee_pwd_details'] = $this->Common->fetch($p_table = 'emp_pwd_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $cond_and = array();
            $cond_and = array('status' => '1', 'id' => $employee_id);
            $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

            $html = $this->load->view('employees/ajax/ajax_pwd_details', $this->data, TRUE);

            $response['code'] = '1';
            $response['message'] = 'Record updated successfully.';
            $response['html'] = $html;
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

    public function ajax_view_employee_details(){  
        if (!(isset($this->data['resp']['token']) && $this->data['resp']['token'] <> '' && $this->data['resp']['token'] == $this->session->userdata($this->data['sess_code'] . '_ftoken'))){
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $row_id = isset($this->data['resp']['row_code']) && $this->data['resp']['row_code'] != '' ? base64_decode($this->data['resp']['row_code']) : NULL;
        if($row_id == NULL){
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'caste', 'join_on' => 'caste.id = hm_emp_master.emp_caste_id', 'join_type' => 'inner', 'join_select' => array('caste.caste_name'));
        $join_logic[1] = array('first_table' => 'religions', 'join_on' => 'religions.id = hm_emp_master.emp_religion_id', 'join_type' => 'inner', 'join_select' => array('religions.religion_name'));
        $join_logic[2] = array('first_table' => 'blood_groups', 'join_on' => 'blood_groups.id = hm_emp_master.emp_blood_group', 'join_type' => 'inner', 'join_select' => array('blood_groups.group_name'));
        $join_logic[3] = array('first_table' => 'marital_status', 'join_on' => 'marital_status.id = hm_emp_master.emp_mar_status', 'join_type' => 'inner', 'join_select' => array('marital_status.marital_status'));
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){            
            $response['code'] = '0';
            $response['message'] = 'No recoed found!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'board_univ', 'join_on' => 'board_univ.id = employee_education_details.board_univ_code', 'join_type' => 'left', 'join_select' => array('board_univ.bu_name'));
        $join_logic[1] = array('first_table' => 'degree_master', 'join_on' => 'degree_master.id = employee_education_details.degree_code', 'join_type' => 'left', 'join_select' => array('degree_master.degree_name'));
        $this->data['employee_education_details'] = $this->Common->fetch($p_table = 'employee_education_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $this->data['employee_address_details'] = $this->Common->fetch($p_table = 'employee_address_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $this->data['employee_bank_details'] = $this->Common->fetch($p_table = 'employee_bank_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'relations', 'join_on' => 'relations.id = employee_dependents_details.relation_id', 'join_type' => 'left', 'join_select' => array('relations.relation'));
        $this->data['employee_dependents_details'] = $this->Common->fetch($p_table = 'employee_dependents_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'centre_details', 'join_on' => 'centre_details.id = employee_official_details.loc_code', 'join_type' => 'left', 'join_select' => array('centre_details.centre_name'));
        $join_logic[1] = array('first_table' => 'ro_details', 'join_on' => 'ro_details.id = centre_details.ro_id', 'join_type' => 'left', 'join_select' => array('ro_details.ro_name'));
        $join_logic[2] = array('first_table' => 'centre_types', 'join_on' => 'centre_types.id = centre_details.centre_type_id', 'join_type' => 'left', 'join_select' => array('centre_types.centre_type_name'));
        $join_logic[3] = array('first_table' => 'department_master', 'join_on' => 'department_master.id = employee_official_details.deptt_code', 'join_type' => 'left', 'join_select' => array('department_master.name as department_name'));
        $join_logic[5] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = employee_official_details.desgn_code', 'join_type' => 'left', 'join_select' => array('designation_master.description, designation_master.type as designation_type'));
        $join_logic[6] = array('first_table' => 'employee_types', 'join_on' => 'employee_types.id = employee_official_details.employee_type_id', 'join_type' => 'left', 'join_select' => array('employee_types.type_name'));
        $this->data['employee_official_details'] = $this->Common->fetch($p_table = 'employee_official_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $reporting_off_ids = array();
        if(isset($this->data['employee_official_details'])){
            foreach($this->data['employee_official_details'] as $eod){
                $reporting_off_ids[] = $eod['rep_emp_id'];
                $reporting_off_ids[] = $eod['alternate_reporting_officer_id'];
                $reporting_off_ids[] = $eod['reviewing_officer_id'];
                $reporting_off_ids[] = $eod['acceptance_officer_id'];
            }
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'designation_pay_scale', 'join_on' => 'designation_pay_scale.id = employee_salary_details.scale_id', 'join_type' => 'left', 'join_select' => array('designation_pay_scale.pay_pattern as scale, designation_pay_scale.scale_min, designation_pay_scale.scale_max'));
        $join_logic[1] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = designation_pay_scale.designation_id', 'join_type' => 'left', 'join_select' => array('designation_master.description'));
        $this->data['employee_salary_details'] = $this->Common->fetch($p_table = 'employee_salary_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $this->data['employee_lic_details'] = $this->Common->fetch($p_table = 'employee_lic_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'emp_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'pwd_master', 'join_on' => 'pwd_master.id = emp_pwd_details.pwd_type_id', 'join_type' => 'left', 'join_select' => array('pwd_master.pwd_name'));
        $this->data['employee_pwd_details'] = $this->Common->fetch($p_table = 'emp_pwd_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);     

        if(isset($reporting_off_ids) && count($reporting_off_ids) > 0){
            $cond_and = array();
            $cond_in = array();
            $cond_in = array('id' => $reporting_off_ids);
            $join_logic = array();
            $this->data['reporting_officer_list'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in, $cond_custom = NULL, $select_fields = array('emp_name, emp_id, id'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);     
        }

        $html = $this->load->view('employees/ajax/ajax_employee_details', $this->data, TRUE);

        $ftoken = $this->_random_password(32) . '_' . $this->_random_password(8) . '_' . $this->_random_password(8);
        $this->session->set_userdata($this->data['sess_code'] . '_ftoken', $ftoken);

        $response['code'] = '1';
        $response['message'] = 'Employee Details';
        $response['html'] = $html;
        $response['ftoken'] = $ftoken;
        echo json_encode($response);
        exit();
    }

    public function ajax_download_employee_details($row_code = NULL){  
        $row_id = $row_code != NULL ? base64_decode($row_code) : NULL;
        if($row_id == NULL){
            $response['code'] = '0';
            $response['message'] = '401! Unauthorized access!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status' => '1', 'id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'caste', 'join_on' => 'caste.id = hm_emp_master.emp_caste_id', 'join_type' => 'inner', 'join_select' => array('caste.caste_name'));
        $join_logic[1] = array('first_table' => 'religions', 'join_on' => 'religions.id = hm_emp_master.emp_religion_id', 'join_type' => 'inner', 'join_select' => array('religions.religion_name'));
        $join_logic[2] = array('first_table' => 'blood_groups', 'join_on' => 'blood_groups.id = hm_emp_master.emp_blood_group', 'join_type' => 'inner', 'join_select' => array('blood_groups.group_name'));
        $join_logic[3] = array('first_table' => 'marital_status', 'join_on' => 'marital_status.id = hm_emp_master.emp_mar_status', 'join_type' => 'inner', 'join_select' => array('marital_status.marital_status'));
        $this->data['employee_details'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = TRUE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if(!isset($this->data['employee_details'])){            
            $response['code'] = '0';
            $response['message'] = 'No recoed found!';
            $response['html'] = '';
            $response['ftoken'] = '';
            echo json_encode($response);
            exit();
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'board_univ', 'join_on' => 'board_univ.id = employee_education_details.board_univ_code', 'join_type' => 'left', 'join_select' => array('board_univ.bu_name'));
        $join_logic[1] = array('first_table' => 'degree_master', 'join_on' => 'degree_master.id = employee_education_details.degree_code', 'join_type' => 'left', 'join_select' => array('degree_master.degree_name'));
        $this->data['employee_education_details'] = $this->Common->fetch($p_table = 'employee_education_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);


        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $this->data['employee_address_details'] = $this->Common->fetch($p_table = 'employee_address_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $this->data['employee_bank_details'] = $this->Common->fetch($p_table = 'employee_bank_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'relations', 'join_on' => 'relations.id = employee_dependents_details.relation_id', 'join_type' => 'left', 'join_select' => array('relations.relation'));
        $this->data['employee_dependents_details'] = $this->Common->fetch($p_table = 'employee_dependents_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'centre_details', 'join_on' => 'centre_details.id = employee_official_details.loc_code', 'join_type' => 'left', 'join_select' => array('centre_details.centre_name'));
        $join_logic[1] = array('first_table' => 'ro_details', 'join_on' => 'ro_details.id = centre_details.ro_id', 'join_type' => 'left', 'join_select' => array('ro_details.ro_name'));
        $join_logic[2] = array('first_table' => 'centre_types', 'join_on' => 'centre_types.id = centre_details.centre_type_id', 'join_type' => 'left', 'join_select' => array('centre_types.centre_type_name'));
        $join_logic[3] = array('first_table' => 'department_master', 'join_on' => 'department_master.id = employee_official_details.deptt_code', 'join_type' => 'left', 'join_select' => array('department_master.name as department_name'));
        $join_logic[5] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = employee_official_details.desgn_code', 'join_type' => 'left', 'join_select' => array('designation_master.description, designation_master.type as designation_type'));
        $join_logic[6] = array('first_table' => 'employee_types', 'join_on' => 'employee_types.id = employee_official_details.employee_type_id', 'join_type' => 'left', 'join_select' => array('employee_types.type_name'));
        $this->data['employee_official_details'] = $this->Common->fetch($p_table = 'employee_official_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $reporting_off_ids = array();
        if(isset($this->data['employee_official_details'])){
            foreach($this->data['employee_official_details'] as $eod){
                $reporting_off_ids[] = $eod['rep_emp_id'];
                $reporting_off_ids[] = $eod['alternate_reporting_officer_id'];
                $reporting_off_ids[] = $eod['reviewing_officer_id'];
                $reporting_off_ids[] = $eod['acceptance_officer_id'];
            }
        }

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'designation_pay_scale', 'join_on' => 'designation_pay_scale.id = employee_salary_details.scale_id', 'join_type' => 'left', 'join_select' => array('designation_pay_scale.pay_pattern as scale, designation_pay_scale.scale_min, designation_pay_scale.scale_max'));
        $join_logic[1] = array('first_table' => 'designation_master', 'join_on' => 'designation_master.id = designation_pay_scale.designation_id', 'join_type' => 'left', 'join_select' => array('designation_master.description'));
        $this->data['employee_salary_details'] = $this->Common->fetch($p_table = 'employee_salary_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'employee_id' => $row_id);
        $join_logic = array();
        $this->data['employee_lic_details'] = $this->Common->fetch($p_table = 'employee_lic_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        $cond_and = array();
        $cond_and = array('status <>' => '5', 'emp_id' => $row_id);
        $join_logic = array();
        $join_logic[0] = array('first_table' => 'pwd_master', 'join_on' => 'pwd_master.id = emp_pwd_details.pwd_type_id', 'join_type' => 'left', 'join_select' => array('pwd_master.pwd_name'));
        $this->data['employee_pwd_details'] = $this->Common->fetch($p_table = 'emp_pwd_details', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);     

        if(isset($reporting_off_ids) && count($reporting_off_ids) > 0){
            $cond_and = array();
            $cond_in = array();
            $cond_in = array('id' => $reporting_off_ids);
            $join_logic = array();
            $this->data['reporting_officer_list'] = $this->Common->fetch($p_table = 'hm_emp_master', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in, $cond_custom = NULL, $select_fields = array('emp_name, emp_id, id'), $join_logic, $order_by = array('id' => 'DESC'), $limit = NULL, $offset = NULL, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);     
        }

        $html = $this->load->view('employees/ajax/ajax_employee_details_download_view', $this->data, TRUE);

        $dompdf = new Dompdf\DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Employee.pdf', array('Attachment' => 1));
        exit();
    }
}
