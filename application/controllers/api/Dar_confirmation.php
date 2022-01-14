<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';


class DAR_Confirmation extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('dar_confirmation_model');
    }
    private function returns($result){
        if($result){
            return $this->response($result, REST_Controller::HTTP_OK);
        }else{
            $result = array(
                'message' => 'No data found'
            );
            return $this->response($result, REST_Controller::HTTP_OK);
        }
    }
    public function index_get(){
        if($this->get('transmittal')){
            $result = $this->dar_confirmation_model->get_soa_via_transmittal($this->get('search'), $this->get('role') ? $this->get('role') : 0);
            $this->returns($result);
        }elseif($this->get('controlNo')){
            $result = $this->dar_confirmation_model->get_soa_via_control_no($this->get('search'));
            $this->returns($result);
        }elseif($this->get('soaNumber')){
            $result = $this->dar_confirmation_model->get_soa_via_soa_number($this->get('search'));
            $this->returns($result);
        }elseif($this->get('details')){
            $result = $this->dar_confirmation_model->get_soa_details($this->get('id'));
            $this->returns($result);
        }elseif($this->get('transmittalInfo')){
            $result = $this->dar_confirmation_model->get_transmittal_info($this->get('No'));
            $this->returns($result);
        }
    }

    public function index_post(){
        if($this->post('transmittalBeginning')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'approvedBy' => $this->post('approvedBy') ? $this->post('approvedBy') : '',
                'approvedByPosition' => $this->post('approvedByPosition') ? $this->post('approvedByPosition') : '',
                'approvedBy2' => $this->post('approvedBy2') ? $this->post('approvedBy2') : '',
                'approvedByPosition2' => $this->post('approvedByPosition2') ? $this->post('approvedByPosition2') : '',
                'confirmedBy' => $this->post('confirmedBy') ? $this->post('confirmedBy') : '',
                'confirmedByPosition' => $this->post('confirmedByPosition') ? $this->post('confirmedByPosition') : '',
                'TransmittalNo' => $this->post('transmitNo') ? $this->post('transmitNo') : '',
            ];
            $result = $this->dar_confirmation_model->save_signatory_transmittal($data);
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully generated'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to generate'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('finalization')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'approvedBy' => $this->post('approvedBy') ? $this->post('approvedBy') : '',
                'approvedByPosition' => $this->post('approvedByPosition') ? $this->post('approvedByPosition') : '',
                'approvedBy2' => $this->post('approvedBy2') ? $this->post('approvedBy2') : '',
                'approvedByPosition2' => $this->post('approvedByPosition2') ? $this->post('approvedByPosition2') : '',
                'confirmedBy' => $this->post('confirmedBy') ? $this->post('confirmedBy') : '',
                'confirmedByPosition' => $this->post('confirmedByPosition') ? $this->post('confirmedByPosition') : '',
                'TransmittalNo' => $this->post('transmitNo') ? $this->post('transmitNo') : '',
            ];
            $result = $this->dar_confirmation_model->save_signatory_finalization($data, $this->post('rows'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully generated'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to generate'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('bulkConfirmation')){
            $result = $this->dar_confirmation_model->save_confirmation($this->post('rows'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully confirmed'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to update'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }else{
            $result = $this->dar_confirmation_model->save_transmittal($this->post('rows'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully transmitted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to update'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }
        
    }
}