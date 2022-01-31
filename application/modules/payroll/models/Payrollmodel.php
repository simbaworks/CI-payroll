<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payrollmodel extends CI_Model {

    
    function __construct() {
        parent::__construct();
        set_time_limit(0);
        ini_set('memory_limit', '-1');
    }

    public function getAllEmployeeForPayslip(){
        $selectStatement = "
                            hm_emp_master.id,
                            hm_emp_master.emp_id,
                            hm_emp_master.emp_email,
                            hm_emp_master.emp_mobile,
                            employee_salary_details.basics,
                            employee_salary_details.da_type,
                            employee_salary_details.scale_id
                            ";
        $query = $this->db
                ->select($selectStatement)
                ->join("employee_salary_details","hm_emp_master.id = employee_salary_details.employee_id","inner")
                ->get("hm_emp_master");
        if( $query->num_rows()>0){
            return $query->result_array();
        }else{
            return array();
        }
    }//fn


    //insertMonthlyPayslip($dataArray)

    // $this->db->insert("salary_heads_desc", $dataArray);

    public function insertMonthlyPayslip($dataArray){
        $this->db->insert("salary_heads_description", $dataArray);
        
    }//fn
    

    public function insertMonthlyPaysliphead($dataArray){

        $q = $this->db->insert("salary_head", $dataArray);
        if($q){
            return $this->db->insert_id();
        }else{
            return false;
        }
        
    }

    public function updateMonthlyPaysliphead($dataArray, $head_id){

        $q = $this->db->update("salary_head", $dataArray, array("id" => $head_id));
        if($q){
            return true;
        }else{
            return false;
        }
        
    }

    public function checkPayslipExistInHead($month,$year){
        $q = $this->db->select('id')
                    ->where(array('month' => $month, 'year' => $year))
                    ->get('salary_head');
        if($q->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function fetchSalaryHead(){
        $q = $this->db->select('*')
                ->get('salary_head');
        if($q->num_rows()){
            return $q->result_array();
        }else{
            return array();
        }
    }

    public function fetchMySalary($emp_id){

        $q = $this->db->select('*')
                ->where(array("emp_id" => $emp_id))
                ->get('salary_heads_description');
        if($q->num_rows()){
            return $q->result_array();
        }else{
            return array();
        }
    }

    public function fetchEmployeeSalaryDetails($id){
        $q = $this->db->select('*')
                ->where(array("id" => $id))
                ->get('salary_heads_description');
        return $q->result_array();
    }

    public function fetchEmployeeDetails($emp_id){
        $code = "
                hm_emp_master.id,
                hm_emp_master.emp_id,
                employee_official_details.desgn_code,
                employee_official_details.deptt_code,
                designation_master.description,
                department_master.name
                ";
        $q = $this->db->select($code)
                ->where(array("hm_emp_master.id" => $emp_id))
                ->join("employee_official_details"," hm_emp_master.id = employee_official_details.employee_id","inner" )
                ->join("designation_master", "employee_official_details.desgn_code = designation_master.id", "inner")
                ->join("department_master", "employee_official_details.deptt_code = department_master.id")
                ->get("hm_emp_master");
        return  $q->result_array(); 
    }

    public function daDetails(){
        $q = $this->db->select('*')
                  ->order_by('id','DESC')
                  ->get('da_master');
        return $q->result_array();
    }

    public function insertDadetails($data){
        $q=$this->db->insert('da_master',$data);
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }

    public function getDaPercentage($daType){
        $q = $this->db
                    ->select('percentage')
                    ->where(array('type' => $daType, "status" => "1"))
                    ->get('da_master');
        if($q->num_rows()){
            return $q->result_array()[0]['percentage'];
        }else{
            return 0;
        }
    }

    public function saveDadetails($data, $da_id){
        $q=$this->db->update('da_master',$data, array('id' => $da_id));
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }

    public function hraDetails(){
        $q = $this->db->select('*')
                      ->order_by('id','DESC')
                      ->get('hra_master');

        return $q->result_array();
    }

    public function inserthradetails($data){
        $q=$this->db->insert('hra_master', $data);
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }


    public function getHraPercentage($city_class){

        // $city_class = '(city_class = "X" OR city_class = "Y" OR city_class = "Z")';
        
        $q = $this->db
                    ->select('rate')
                    ->where(array('status' => '1', 'city_class' =>$city_class))
                    ->get('hra_master');
        if($q->num_rows()){
            return $q->result_array()[0]['rate'];
        }else{
            return 0;
        }
    }


    public function getLocCode($emp_id){

        $q = $this->db
                    ->select('loc_code')
                    ->where(array('employee_id' => $emp_id))
                    ->get('employee_official_details');
        if($q->num_rows()){
            return $q->result_array()[0]['loc_code'];
        }else{
            return 0;
        } 
    }

    public function getCityClassCode($loc_code){

        $q = $this->db
                    ->select('city_class')
                    ->where(array('ro_code' => $loc_code))
                    ->get('ro_details');
        if($q->num_rows()){
            return $q->result_array()[0]['city_class'];
        }else{
            return 0;
        } 
    }

    public function saveHradetails($data, $hra_id){
        $q=$this->db->update('hra_master',$data, array('id' => $hra_id));
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }

  
    
    public function taDetails(){
        $sql = "SELECT DM.ID, DM.DESCRIPTION, DM.TYPE, DM.SHORTNAME, TM.CITY_CLASS, TM.RATE, TM.START_DATE, TM.END_DATE, TM.STATUS
        FROM TA_MASTER TM, DESIGNATION_MASTER DM
        WHERE TM.DESIG=DM.ID";
        $q = $this->db->query($sql);
        if($q->num_rows()>0)
        {
            return $q->result_array();
        }else{
            return false;
        }
    }

    public function inserttadetails($data){
        $q=$this->db->insert('ta_master', $data);
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }


   

    public function saveTadetails($data, $ta_id){
        $q=$this->db->update('ta_master',$data, array('id' => $ta_id));
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }
 
    public function get_all_desig_details(){
        $sql = "SELECT ID, DESCRIPTION, TYPE, SHORTNAME FROM DESIGNATION_MASTER ORDER BY DESCRIPTION";
        $q = $this->db->query($sql);
        if($q->num_rows()>0)
        {
            return $q->result_array();
        }else{
            return false;
        }
    }
    
    public function sdaDetails(){
        $q = $this->db->select('*')
                      ->order_by('id','DESC')
                      ->get('sda_rate');

        return $q->result_array();
    }

    public function insertsdadetails($data){
        $q=$this->db->insert('sda_rate', $data);
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }


    public function getSdaPercentage($city_class){

        // $city_class = '(city_class = "X" OR city_class = "Y" OR city_class = "Z")';
        
        $q = $this->db
                    ->select('rate')
                    ->where(array('status' => '1', 'city_class' =>$city_class))
                    ->get('sda_rate');
        if($q->num_rows()){
            return $q->result_array()[0]['rate'];
        }else{
            return 0;
        }
    }



    public function saveSdadetails($data, $sda_id){
        $q=$this->db->update('sda_rate',$data, array('id' => $sda_id));
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }


}
