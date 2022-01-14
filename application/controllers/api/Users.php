<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';


class Users extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('users_model');
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
        $result = $this->users_model->get_data();
        $this->returns($result);
    }

    public function index_post(){
        if($this->post('reset')){
            $result = $this->users_model->reset_password($this->post('id'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Reset successful'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to reset'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }else{
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'name' => $this->post('name') ? $this->post('name') : '',
                'email' => $this->post('email') ? $this->post('email') : '',
                'password' => $this->post('password') ? $this->post('password') : '',
                'role_id' => $this->post('role_id') ? $this->post('role_id') : 0,
                'status' => 'ACTIVE',
            ];
            $result = $this->users_model->post_data($data);
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
        
    }

    public function index_delete(){
        $result = $this->users_model->delete_data($this->query('id'));
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