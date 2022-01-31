<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Commonmodel', 'Common');
        $this->load->model('Payrollmodel');
        $this->data['view'] = $this->data['controller'] . '/' . $this->data['method'];
        $this->clear_cache();
        $this->check_login(0);
    }

    /* ------------------- END BLOCK ------------------- */

    /**
     * 
     */
    public function index() {
         header('Location:' . site_url('payroll/all'));
        exit();
    }

    public function all() {
        // echo $this->_random_password(32);
        $headList = $this->Payrollmodel->fetchSalaryHead();
        // print_r($headList);
        $this->load->view('common/header', $this->data);
        $this->load->view('payroll/parentlists', array(
            "headList" => $headList,
        ) );
        $this->load->view('common/footer', $this->data);
    }

    public function my_salary() {
        // echo $this->_random_password(32);
        $emp_id = $this->session->userdata($this->data['sess_code'] . 'user_id');
        $mySalary = $this->Payrollmodel->fetchMySalary($emp_id);
        $this->load->view('common/header', $this->data);
        $this->load->view('payroll/individuallist', array(
            "mySalary" => $mySalary));
        $this->load->view('common/footer', $this->data);
    }

    public function single_slip($slip_id) {
        // echo $this->_random_password(32);
       
        $salarydetails = $this->Payrollmodel->fetchEmployeeSalaryDetails($slip_id);
        $empdetails = $this->Payrollmodel->fetchEmployeeDetails($salarydetails[0]['emp_id']);

        // print_r($salarydetails[0]);
        $this->load->view('common/header', $this->data);
        $this->load->view('payroll/single', array(
            "salarydetails" => $salarydetails[0],
            "empdetails"   => $empdetails[0],
        ));
        $this->load->view('common/footer', $this->data);
    }

    public function generate_payslip_ajax(){
        if($this->Payrollmodel->checkPayslipExistInHead(date('M'), date('Y'))){
            echo 0;
        }else{
            $allEmployee = $this->Payrollmodel->getAllEmployeeForPayslip();
            $headdataarray = array(
                "month" =>   date('M'),
                "date"    => date('d'),
                "year"    => date('Y'),
            );
            $head_id = $this->Payrollmodel->insertMonthlyPaysliphead($headdataarray);
     
            $payslipcount = 1;
            foreach($allEmployee as $employee){
                // da Calculation
                $daType = $employee['da_type'];
                $daPercentage = $this->Payrollmodel->getDaPercentage($daType);
                $daAmount  = (intval($daPercentage)/100)*intval($employee['basics']);

                // use emp id  and get loc_code from employee_official_details
                //if 2 digit
                //use the code to get city class from either ro_details(ro_code) table 
                //if 4 digit
                //or from centre_details()
                $emp_id = $employee['id'];
                $loc_code = $this->Payrollmodel->getLocCode($emp_id);
                $city_class =$this->Payrollmodel->getCityClassCode($loc_code);
                $hraPercentage = $this->Payrollmodel->getHraPercentage($city_class);
                $hraAmount  = (intval($hraPercentage)/100)*intval($employee['basics']);
                $totalIncome = intval($employee['basics']) + $daAmount + $hraAmount;
                $totalDeduction = 0;
                $total = $totalIncome - $totalDeduction;

                $dataArray = array(
                    "emp_id"            => $employee['id'],
                    "month"             => date('M'),
                    "date"              => date('d'),
                    "year"              => date('Y'),
                    "basics"            => $employee['basics'],
                    "da_type"           => $employee['da_type'],
                    "da_amount"         => $daAmount,
                    "hra_amount"        => $hraAmount,
                    "total_income"      => $totalIncome,
                    "total_deduction"   => $totalDeduction,
                    "total"             => $total,
                    "head_id"           => $head_id,
                );
                //insert to salary_heads($dataArray)
                $this->Payrollmodel->insertMonthlyPayslip($dataArray);
                $payslipcount++;
             }
            $headDataUpdate = array(
                "no_of_payslip" =>  $payslipcount -1 
            );
            $this->Payrollmodel->updateMonthlyPaysliphead($headDataUpdate,$head_id);
            echo 1;
        }

    }

    public function da() {
       
        $dadetails = $this->Payrollmodel->daDetails();
        $this->load->view('common/header', $this->data);
        $this->load->view('payroll/da', array(
            "dadetails" => $dadetails
        ));
        $this->load->view('common/footer', $this->data);
    }

    public function insertdadetails(){
        // print_r($_POST);
        // die();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('effect_date', 'effectivedate', 'trim|callback_check_equal_less');
        $this->form_validation->set_rules('end_date', 'enddate', 'trim|required|callback_check_greater_then['.$this->input->post('first_field').']');




        $da_type = $this->input->post('da_type');
        $percentage = $this->input->post('percentage');
        $effect_date = $this->input->post('effect_date');
        $end_date = $this->input->post('end_date');
        $regulation_date = $this->input->post('regulation_date');

        $data=array(
            'type'   =>  $da_type,
            'percentage'   =>  $percentage,
            'effective_date'   =>  $effect_date,
            'end_date'   =>  $end_date,
            'date_of_regulation'   =>  $regulation_date

        );
        if($this->Payrollmodel->insertDadetails($data)){
          return redirect(site_url('payroll/da'));   
        }
    }

    public function savedadetails(){
        $da_id = $this->input->post('da_id');  
        $da_type = $this->input->post('da_type');
        $percentage = $this->input->post('percentage');
        $effect_date = $this->input->post('effect_date');
        $end_date = $this->input->post('end_date');
        $regulation_date = $this->input->post('regulation_date');

        $data=array(
            'type'   =>  $da_type,
            'percentage'   =>  $percentage,
            'effective_date'   =>  $effect_date,
            'end_date'   =>  $end_date,
            'regulation_date'   =>  $regulation_date,
        );

        if($this->Payrollmodel->saveDadetails($data, $da_id)){
          return redirect(site_url('payroll/da'));   
        }
    }

    public function savedastatusajax(){
        $da_id = $this->input->post('id');  
        $status = $this->input->post('status');
        

        $data=array(
            'status'   =>  $status,
        );

        if($this->Payrollmodel->saveDadetails($data, $da_id)){
          echo 1; 
        }else{
            echo 0;
        }
    }

    public function hra() {
       
        $hradetails = $this->Payrollmodel->hraDetails();
        $this->load->view('common/header', $this->data);
        $this->load->view('payroll/hra', array(
            "hradetails" => $hradetails
        ));
        $this->load->view('common/footer', $this->data);
    }

    public function inserthradetails(){
        $da_type = $this->input->post('da_type');
        $city_class = $this->input->post('city_class');
        $rate = $this->input->post('rate');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $data=array(
            'type'   =>  $da_type,
            'city_class'   =>  $city_class,
            'rate'         =>  $rate,
            'start_date'   =>  $start_date,
            'end_date'     =>  $end_date
        );
        if($this->Payrollmodel->inserthradetails($data)){
          return redirect(site_url('payroll/hra'));   
        }
    }

    public function savehradetails(){
        $hra_id = $this->input->post('hra_id');  
        $city_class = $this->input->post('city_class');
        $rate = $this->input->post('rate');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $data=array(
            'city_class'   =>  $city_class,
            'rate'         =>  $rate,
            'start_date'   =>  $start_date,
            'end_date'     =>  $end_date
        );

        if($this->Payrollmodel->saveHraDetails($data, $hra_id)){
          return redirect(site_url('payroll/hra'));   
        }
    }

    public function savehrastatusajax(){
        $hra_id = $this->input->post('id');  
        $status = $this->input->post('status');
        

        $data=array(
            'status'   =>  $status,
        );

        if($this->Payrollmodel->saveHradetails($data, $hra_id)){
          echo 1; 
        }else{
            echo 0;
        }
    }
 
public function salary_heads_management(){
    $this->load->view('common/header', $this->data);
    $this->load->view('payroll/salaryheadsmanagement');
    $this->load->view('common/footer', $this->data);
}

public function generate_salary(){
    $this->load->view('common/header', $this->data);
    $this->load->view('payroll/generateslip');
    $this->load->view('common/footer', $this->data);
}

public function view_salary(){
    $this->load->view('common/header', $this->data);
    $this->load->view('common/footer', $this->data);
}

public function edit_salary(){
    $this->load->view('common/header', $this->data);
    $this->load->view('payroll/editsalary');
    $this->load->view('common/footer', $this->data);
}

public function sda(){
    $this->load->view('common/header', $this->data);
    $this->load->view('common/footer', $this->data);
}

public function ta(){
    $this->load->view('common/header', $this->data);
    $this->load->view('common/footer', $this->data);
}






    // public function ta() {
       
    //     $tadetails = $this->Payrollmodel->taDetails();
    //     $desig_details = $this->Payrollmodel->get_all_desig_details();
    //     $this->load->view('common/header', $this->data);
    //     $this->load->view('payroll/ta', array(
    //         "tadetails" => $tadetails,
    //         "desig_details" => $desig_details
    //     ));
    //     $this->load->view('common/footer', $this->data);
    // }

    // public function inserttadetails(){
    //     $desig = $this->input->post('desig');
    //     $city_class = $this->input->post('city_class');
    //     $rate = $this->input->post('rate');
    //     $start_date = $this->input->post('start_date');
    //     $end_date = $this->input->post('end_date');

    //     $data=array(
    //         'desig'   =>  $desig,
    //         'city_class'   =>  $city_class,
    //         'rate'         =>  $rate,
    //         'start_date'   =>  $start_date,
    //         'end_date'     =>  $end_date
    //     );
    //     if($this->Payrollmodel->inserttadetails($data)){
    //       return redirect(site_url('payroll/ta'));   
    //     }
    // }

    // public function savetadetails(){
    //     $ta_id = $this->input->post('ta_id');  
    //     $city_class = $this->input->post('city_class');
    //     $rate = $this->input->post('rate');
    //     $start_date = $this->input->post('start_date');
    //     $end_date = $this->input->post('end_date');

    //     $data=array(
    //         'city_class'   =>  $city_class,
    //         'rate'         =>  $rate,
    //         'start_date'   =>  $start_date,
    //         'end_date'     =>  $end_date
    //     );

    //     if($this->Payrollmodel->saveTaDetails($data, $ta_id)){
    //       return redirect(site_url('payroll/ta'));   
    //     }
    // }
    

    // public function savetastatusajax(){
    //     $hra_id = $this->input->post('id');  
    //     $status = $this->input->post('status');
        

    //     $data=array(
    //         'status'   =>  $status,
    //     );

    //     if($this->Payrollmodel->saveTadetails($data, $ta_id)){
    //       echo 1; 
    //     }else{
    //         echo 0;
    //     }
    // }

    
    // public function sda() {
       
    //     $sdadetails = $this->Payrollmodel->sdaDetails();
    //     $this->load->view('common/header', $this->data);
    //     $this->load->view('payroll/sda', array(
    //         "sdadetails" => $sdadetails
    //     ));
    //     $this->load->view('common/footer', $this->data);
    // }

    // public function insertsdadetails(){
    //     $ro_name = $this->input->post('ro_name');
    //     $rate = $this->input->post('rate');
    //     $start_date = $this->input->post('start_date');
    //     $end_date = $this->input->post('end_date');

    //     $data=array(
    //         'ro_name'   =>  $ro_name,
    //         'rate'         =>  $rate,
    //         'start_date'   =>  $start_date,
    //         'end_date'     =>  $end_date
    //     );
    //     if($this->Payrollmodel->insertsdadetails($data)){
    //       return redirect(site_url('payroll/sda'));   
    //     }
    // }

    // public function savesdadetails(){
    //     $sda_id = $this->input->post('sda_id');  
    //     $ro_name = $this->input->post('ro_name');
    //     $rate = $this->input->post('rate');
    //     $start_date = $this->input->post('start_date');
    //     $end_date = $this->input->post('end_date');

    //     $data=array(
    //         'ro_name'   =>  $ro_name,
    //         'rate'         =>  $rate,
    //         'start_date'   =>  $start_date,
    //         'end_date'     =>  $end_date
    //     );

    //     if($this->Payrollmodel->saveSdaDetails($data, $sda_id)){
    //       return redirect(site_url('payroll/sda'));   
    //     }
    // }

    // public function savesdastatusajax(){
    //     $sda_id = $this->input->post('id');  
    //     $status = $this->input->post('status');
        

    //     $data=array(
    //         'status'   =>  $status,
    //     );

    //     if($this->Payrollmodel->saveSdadetails($data, $hra_id)){
    //       echo 1; 
    //     }else{
    //         echo 0;
    //     }
    // }
 


    
}
