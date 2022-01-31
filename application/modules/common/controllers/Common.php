<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    /* ------------------- END BLOCK ------------------- */

    /*
    |-----------------------------------------
    |Ajax get post office, district, state details by PIN code
    |-----------------------------------------
    */
    public function ajax_get_zip_code_details(){
        $pin = isset($this->data['resp']['pin']) && $this->data['resp']['pin'] != '' ? $this->data['resp']['pin'] : NULL;
        
        if($pin == NULL || strlen($pin) <> 6){
            $response['code'] = '0';
            $response['district'] = '';
            $response['state'] = '';

            echo json_encode($response);
            exit();
        }

        $data = file_get_contents('https://api.postalpincode.in/pincode/' . $pin);
        $data = json_decode($data);
        if(isset($data[0]->PostOffice['0'])){

            $response['code'] = '1';
            $response['district'] = $data[0]->PostOffice['0']->District;
            $response['state'] = $data[0]->PostOffice['0']->State;

            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['district'] = '';
            $response['state'] = '';

            echo json_encode($response);
            exit();
        }
    }

    /*
    |-----------------------------------------
    |Ajax get bank details by IFSC code
    |-----------------------------------------
    */
    public function ajax_get_ifsc_details(){
        $ifsc = isset($this->data['resp']['ifsc']) && $this->data['resp']['ifsc'] != '' ? $this->data['resp']['ifsc'] : NULL;
        
        if($ifsc == NULL || strlen($ifsc) <> 11){
            $response['code'] = '0';
            $response['bank_name'] = '';
            $response['bank_branch'] = '';

            echo json_encode($response);
            exit();
        }

        $data = file_get_contents('https://ifsc.razorpay.com/' . $ifsc);
        $data = json_decode($data);
        if(isset($data->MICR)){

            $response['code'] = '1';
            $response['bank_name'] = $data->BANK;
            $response['bank_branch'] = $data->BRANCH;

            echo json_encode($response);
            exit();
        }else{
            $response['code'] = '0';
            $response['bank_name'] = '';
            $response['bank_branch'] = '';

            echo json_encode($response);
            exit();
        }
    }
}
