<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';


class SAR_PO extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('sar_po_model');
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
        $result = $this->sar_po_model->get_data();
        $this->returns($result);
    }

    public function index_post(){
        $data = [
            'id' => $this->post('id') ? $this->post('id') : 0,
            'poNumber' => $this->post('poNumber') ? $this->post('poNumber') : '',
            'qty' => $this->post('qty') ? $this->post('qty') : '',
            'rate' => $this->post('rate') ? $this->post('rate') : '',
            'unit' => $this->post('unit') ? $this->post('unit') : '',
            'dayType' => $this->post('dayType') ? $this->post('dayType') : '',
        ];
        $result = $this->sar_po_model->post_data($data);
        if(gettype($result) ===  "array"){
            $result = array(
                'success' => true,
                'id' => $result['id'],
                'message' => 'Successfully inserted'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }else{
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully updated'
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

    public function index_delete(){
        $result = $this->sar_po_model->delete_data($this->query('id'));
        if ($result){
            $result = array(
                'success' => true,
                'message' => 'Successfully deleted'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }else{
            $result = array(
                'success' => false,
                'message' => 'Failed deleting'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }
}