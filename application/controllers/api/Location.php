<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';


class Location extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('location_model');
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
        $result = $this->location_model->get_data();
        $this->returns($result);
    }

    public function index_post(){
        $data = [
            'LocationID' => $this->post('LocationID') ? $this->post('LocationID') : 0,
            'Location' => $this->post('Location') ? $this->post('Location') : '',
            'LocPrefix' => $this->post('LocPrefix') ? $this->post('LocPrefix') : '',
            'Code' => $this->post('Code') ? $this->post('Code') : '',
        ];
        $result = $this->location_model->post_data($data);
        if($result['id']){
            $result = array(
                'success' => true,
                'id' => $result['id'],
                'message' => 'Successfully inserted'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }elseif($result){
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

    public function index_delete(){
        $result = $this->location_model->delete_data($this->query('id'));
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