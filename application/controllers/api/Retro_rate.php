<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';


class Retro_Rate extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('retro_rate_model');
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
        if($this->get('sar')){
            $result = $this->retro_rate_model->get_sar();
        }elseif($this->get('bcc')){
            $result = $this->retro_rate_model->get_bcc();
        }elseif($this->get('slers')){
            $result = $this->retro_rate_model->get_slers();
        }elseif($this->get('clubhouse')){
            $result = $this->retro_rate_model->get_clubhouse();
        }elseif($this->get('displayUploads')){
            $result = $this->retro_rate_model->display_uploaded_rate();
        }else{
            $result = $this->retro_rate_model->get_data();
        }
        $this->returns($result);
    }

    public function index_post(){
        if($this->post('sar')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'activityID' => $this->post('activityID') ? $this->post('activityID') : '',
                'activity' => $this->post('activity') ? $this->post('activity') : '',
                'unit' => $this->post('unit') ? $this->post('unit') : '',
                'rd_rate' => $this->post('rd_rate') ? $this->post('rd_rate') : '',
                'shol_rate' => $this->post('shol_rate') ? $this->post('shol_rate') : '',
                'shrd_rate' => $this->post('shrd_rate') ? $this->post('shrd_rate') : '',
                'rhol_rate' => $this->post('rhol_rate') ? $this->post('rhol_rate') : '',
                'rhrd_rate' => $this->post('rhrd_rate') ? $this->post('rhrd_rate') : '',
                'status' => $this->post('status') ? $this->post('status') : '',
            ];
            $result = $this->retro_rate_model->post_sar($data);
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
        }elseif($this->post('bcc')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'activityID' => $this->post('activityID') ? $this->post('activityID') : '',
                'costCenterID' => $this->post('costCenterID') ? $this->post('costCenterID') : '',
                'glID' => $this->post('glID') ? $this->post('glID') : '',
                'locationID' => $this->post('locationID') ? $this->post('locationID') : '',
                'activity_fr_mg' => $this->post('activity_fr_mg') ? $this->post('activity_fr_mg') : '',
                'location_fr_mg' => $this->post('location_fr_mg') ? $this->post('location_fr_mg') : '',
                'gl_fr_mg' => $this->post('gl_fr_mg') ? $this->post('gl_fr_mg') : '',
                'costcenter__' => $this->post('costcenter__') ? $this->post('costcenter__') : '',
                'rd_st' => $this->post('rd_st') ? $this->post('rd_st') : '',
                'rd_ot' => $this->post('rd_ot') ? $this->post('rd_ot') : '',
                'rd_nd' => $this->post('rd_nd') ? $this->post('rd_nd') : '',
                'rd_ndot' => $this->post('rd_ndot') ? $this->post('rd_ndot') : '',
                'shol_st' => $this->post('shol_st') ? $this->post('shol_st') : '',
                'shol_ot' => $this->post('shol_ot') ? $this->post('shol_ot') : '',
                'shol_nd' => $this->post('shol_nd') ? $this->post('shol_nd') : '',
                'shol_ndot' => $this->post('shol_ndot') ? $this->post('shol_ndot') : '',
                'shrd_st' => $this->post('shrd_st') ? $this->post('shrd_st') : '',
                'shrd_ot' => $this->post('shrd_ot') ? $this->post('shrd_ot') : '',
                'shrd_nd' => $this->post('shrd_nd') ? $this->post('shrd_nd') : '',
                'shrd_ndot' => $this->post('shrd_ndot') ? $this->post('shrd_ndot') : '',
                'rhol_st' => $this->post('rhol_st') ? $this->post('rhol_st') : '',
                'rhol_ot' => $this->post('rhol_ot') ? $this->post('rhol_ot') : '',
                'rhol_nd' => $this->post('rhol_nd') ? $this->post('rhol_nd') : '',
                'rhol_ndot' => $this->post('rhol_ndot') ? $this->post('rhol_ndot') : '',
                'rhrd_st' => $this->post('rhrd_st') ? $this->post('rhrd_st') : '',
                'rhrd_ot' => $this->post('rhrd_ot') ? $this->post('rhrd_ot') : '',
                'rhrd_nd' => $this->post('rhrd_nd') ? $this->post('rhrd_nd') : '',
                'rhrd_ndot' => $this->post('rhrd_ndot') ? $this->post('rhrd_ndot') : '',
                'rhol_st2x' => $this->post('rhol_st2x') ? $this->post('rhol_st2x') : '',
                'rhol_ot2x' => $this->post('rhol_ot2x') ? $this->post('rhol_ot2x') : '',
                'rhol_nd2x' => $this->post('rhol_nd2x') ? $this->post('rhol_nd2x') : '',
                'rhol_ndot2x' => $this->post('rhol_ndot2x') ? $this->post('rhol_ndot2x') : '',
                'rholrd_st2x' => $this->post('rholrd_st2x') ? $this->post('rholrd_st2x') : '',
                'rholrd_ot2x' => $this->post('rholrd_ot2x') ? $this->post('rholrd_ot2x') : '',
                'rholrd_nd2x' => $this->post('rholrd_nd2x') ? $this->post('rholrd_nd2x') : '',
                'rholrd_ndot2x' => $this->post('rholrd_ndot2x') ? $this->post('rholrd_ndot2x') : '',
                'status' => $this->post('status') ? $this->post('status') : '',
            ];
            $result = $this->retro_rate_model->post_bcc($data);
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
        }elseif($this->post('slers')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'activityID' => $this->post('activityID') ? $this->post('activityID') : '',
                'costCenterID' => $this->post('costCenterID') ? $this->post('costCenterID') : '',
                'glID' => $this->post('glID') ? $this->post('glID') : '',
                'locationID' => $this->post('locationID') ? $this->post('locationID') : '',
                'activity_fr_mg' => $this->post('activity_fr_mg') ? $this->post('activity_fr_mg') : '',
                'location_fr_mg' => $this->post('location_fr_mg') ? $this->post('location_fr_mg') : '',
                'gl_fr_mg' => $this->post('gl_fr_mg') ? $this->post('gl_fr_mg') : '',
                'costcenter__' => $this->post('costcenter__') ? $this->post('costcenter__') : '',
                'rd_st' => $this->post('rd_st') ? $this->post('rd_st') : '',
                'rd_ot' => $this->post('rd_ot') ? $this->post('rd_ot') : '',
                'rd_nd' => $this->post('rd_nd') ? $this->post('rd_nd') : '',
                'rd_ndot' => $this->post('rd_ndot') ? $this->post('rd_ndot') : '',
                'shol_st' => $this->post('shol_st') ? $this->post('shol_st') : '',
                'shol_ot' => $this->post('shol_ot') ? $this->post('shol_ot') : '',
                'shol_nd' => $this->post('shol_nd') ? $this->post('shol_nd') : '',
                'shol_ndot' => $this->post('shol_ndot') ? $this->post('shol_ndot') : '',
                'shrd_st' => $this->post('shrd_st') ? $this->post('shrd_st') : '',
                'shrd_ot' => $this->post('shrd_ot') ? $this->post('shrd_ot') : '',
                'shrd_nd' => $this->post('shrd_nd') ? $this->post('shrd_nd') : '',
                'shrd_ndot' => $this->post('shrd_ndot') ? $this->post('shrd_ndot') : '',
                'rhol_st' => $this->post('rhol_st') ? $this->post('rhol_st') : '',
                'rhol_ot' => $this->post('rhol_ot') ? $this->post('rhol_ot') : '',
                'rhol_nd' => $this->post('rhol_nd') ? $this->post('rhol_nd') : '',
                'rhol_ndot' => $this->post('rhol_ndot') ? $this->post('rhol_ndot') : '',
                'rhrd_st' => $this->post('rhrd_st') ? $this->post('rhrd_st') : '',
                'rhrd_ot' => $this->post('rhrd_ot') ? $this->post('rhrd_ot') : '',
                'rhrd_nd' => $this->post('rhrd_nd') ? $this->post('rhrd_nd') : '',
                'rhrd_ndot' => $this->post('rhrd_ndot') ? $this->post('rhrd_ndot') : '',
                'rhol_st2x' => $this->post('rhol_st2x') ? $this->post('rhol_st2x') : '',
                'rhol_ot2x' => $this->post('rhol_ot2x') ? $this->post('rhol_ot2x') : '',
                'rhol_nd2x' => $this->post('rhol_nd2x') ? $this->post('rhol_nd2x') : '',
                'rhol_ndot2x' => $this->post('rhol_ndot2x') ? $this->post('rhol_ndot2x') : '',
                'rholrd_st2x' => $this->post('rholrd_st2x') ? $this->post('rholrd_st2x') : '',
                'rholrd_ot2x' => $this->post('rholrd_ot2x') ? $this->post('rholrd_ot2x') : '',
                'rholrd_nd2x' => $this->post('rholrd_nd2x') ? $this->post('rholrd_nd2x') : '',
                'rholrd_ndot2x' => $this->post('rholrd_ndot2x') ? $this->post('rholrd_ndot2x') : '',
                'status' => $this->post('status') ? $this->post('status') : '',
            ];
            $result = $this->retro_rate_model->post_slers($data);
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
        }elseif($this->post('clubhouse')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'activityID' => $this->post('activityID') ? $this->post('activityID') : '',
                'costCenterID' => $this->post('costCenterID') ? $this->post('costCenterID') : '',
                'glID' => $this->post('glID') ? $this->post('glID') : '',
                'locationID' => $this->post('locationID') ? $this->post('locationID') : '',
                'activity_fr_mg' => $this->post('activity_fr_mg') ? $this->post('activity_fr_mg') : '',
                'location_fr_mg' => $this->post('location_fr_mg') ? $this->post('location_fr_mg') : '',
                'gl_fr_mg' => $this->post('gl_fr_mg') ? $this->post('gl_fr_mg') : '',
                'costcenter__' => $this->post('costcenter__') ? $this->post('costcenter__') : '',
                'rd_st' => $this->post('rd_st') ? $this->post('rd_st') : '',
                'rd_ot' => $this->post('rd_ot') ? $this->post('rd_ot') : '',
                'rd_nd' => $this->post('rd_nd') ? $this->post('rd_nd') : '',
                'rd_ndot' => $this->post('rd_ndot') ? $this->post('rd_ndot') : '',
                'shol_st' => $this->post('shol_st') ? $this->post('shol_st') : '',
                'shol_ot' => $this->post('shol_ot') ? $this->post('shol_ot') : '',
                'shol_nd' => $this->post('shol_nd') ? $this->post('shol_nd') : '',
                'shol_ndot' => $this->post('shol_ndot') ? $this->post('shol_ndot') : '',
                'shrd_st' => $this->post('shrd_st') ? $this->post('shrd_st') : '',
                'shrd_ot' => $this->post('shrd_ot') ? $this->post('shrd_ot') : '',
                'shrd_nd' => $this->post('shrd_nd') ? $this->post('shrd_nd') : '',
                'shrd_ndot' => $this->post('shrd_ndot') ? $this->post('shrd_ndot') : '',
                'rhol_st' => $this->post('rhol_st') ? $this->post('rhol_st') : '',
                'rhol_ot' => $this->post('rhol_ot') ? $this->post('rhol_ot') : '',
                'rhol_nd' => $this->post('rhol_nd') ? $this->post('rhol_nd') : '',
                'rhol_ndot' => $this->post('rhol_ndot') ? $this->post('rhol_ndot') : '',
                'rhrd_st' => $this->post('rhrd_st') ? $this->post('rhrd_st') : '',
                'rhrd_ot' => $this->post('rhrd_ot') ? $this->post('rhrd_ot') : '',
                'rhrd_nd' => $this->post('rhrd_nd') ? $this->post('rhrd_nd') : '',
                'rhrd_ndot' => $this->post('rhrd_ndot') ? $this->post('rhrd_ndot') : '',
                'rhol_st2x' => $this->post('rhol_st2x') ? $this->post('rhol_st2x') : '',
                'rhol_ot2x' => $this->post('rhol_ot2x') ? $this->post('rhol_ot2x') : '',
                'rhol_nd2x' => $this->post('rhol_nd2x') ? $this->post('rhol_nd2x') : '',
                'rhol_ndot2x' => $this->post('rhol_ndot2x') ? $this->post('rhol_ndot2x') : '',
                'rholrd_st2x' => $this->post('rholrd_st2x') ? $this->post('rholrd_st2x') : '',
                'rholrd_ot2x' => $this->post('rholrd_ot2x') ? $this->post('rholrd_ot2x') : '',
                'rholrd_nd2x' => $this->post('rholrd_nd2x') ? $this->post('rholrd_nd2x') : '',
                'rholrd_ndot2x' => $this->post('rholrd_ndot2x') ? $this->post('rholrd_ndot2x') : '',
                'status' => $this->post('status') ? $this->post('status') : '',
            ];
            $result = $this->retro_rate_model->post_clubhouse($data);
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
        }elseif($this->post('uploadDAR')){
            $result = $this->retro_rate_model->upload_dar($this->post('list'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to insert'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('uploadBCC')){
            $result = $this->retro_rate_model->upload_bcc($this->post('list'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to insert'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('uploadSLERS')){
            $result = $this->retro_rate_model->upload_slers($this->post('list'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to insert'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('uploadCLUBHOUSE')){
            $result = $this->retro_rate_model->upload_clubhouse($this->post('list'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to insert'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('finalizeDAR')){
            $result = $this->retro_rate_model->finalize_upload_dar();
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully uploaded'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to insert'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('finalizeBCC')){
            $result = $this->retro_rate_model->finalize_upload_bcc();
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully uploaded'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to insert'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('finalizeSLERS')){
            $result = $this->retro_rate_model->finalize_upload_slers();
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully uploaded'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to insert'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('finalizeCLUBHOUSE')){
            $result = $this->retro_rate_model->finalize_upload_clubhouse();
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully uploaded'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to insert'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('reactivateRate')){
            $result = $this->retro_rate_model->reactivate_rate($this->post('id'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully reactivated'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to reactivate'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('deleteDAR')){
            $result = $this->retro_rate_model->delete_dar($this->post('id'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully deleted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Something went wrong'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }else{
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'activityID' => $this->post('activityID') ? $this->post('activityID') : '',
                'costCenterID' => $this->post('costCenterID') ? $this->post('costCenterID') : '',
                'glID' => $this->post('glID') ? $this->post('glID') : '',
                'locationID' => $this->post('locationID') ? $this->post('locationID') : '',
                'activity_fr_mg' => $this->post('activity_fr_mg') ? $this->post('activity_fr_mg') : '',
                'location_fr_mg' => $this->post('location_fr_mg') ? $this->post('location_fr_mg') : '',
                'gl_fr_mg' => $this->post('gl_fr_mg') ? $this->post('gl_fr_mg') : '',
                'costcenter__' => $this->post('costcenter__') ? $this->post('costcenter__') : '',
                'rd_st' => $this->post('rd_st') ? $this->post('rd_st') : '',
                'rd_ot' => $this->post('rd_ot') ? $this->post('rd_ot') : '',
                'rd_nd' => $this->post('rd_nd') ? $this->post('rd_nd') : '',
                'rd_ndot' => $this->post('rd_ndot') ? $this->post('rd_ndot') : '',
                'shol_st' => $this->post('shol_st') ? $this->post('shol_st') : '',
                'shol_ot' => $this->post('shol_ot') ? $this->post('shol_ot') : '',
                'shol_nd' => $this->post('shol_nd') ? $this->post('shol_nd') : '',
                'shol_ndot' => $this->post('shol_ndot') ? $this->post('shol_ndot') : '',
                'shrd_st' => $this->post('shrd_st') ? $this->post('shrd_st') : '',
                'shrd_ot' => $this->post('shrd_ot') ? $this->post('shrd_ot') : '',
                'shrd_nd' => $this->post('shrd_nd') ? $this->post('shrd_nd') : '',
                'shrd_ndot' => $this->post('shrd_ndot') ? $this->post('shrd_ndot') : '',
                'rhol_st' => $this->post('rhol_st') ? $this->post('rhol_st') : '',
                'rhol_ot' => $this->post('rhol_ot') ? $this->post('rhol_ot') : '',
                'rhol_nd' => $this->post('rhol_nd') ? $this->post('rhol_nd') : '',
                'rhol_ndot' => $this->post('rhol_ndot') ? $this->post('rhol_ndot') : '',
                'rhrd_st' => $this->post('rhrd_st') ? $this->post('rhrd_st') : '',
                'rhrd_ot' => $this->post('rhrd_ot') ? $this->post('rhrd_ot') : '',
                'rhrd_nd' => $this->post('rhrd_nd') ? $this->post('rhrd_nd') : '',
                'rhrd_ndot' => $this->post('rhrd_ndot') ? $this->post('rhrd_ndot') : '',
                'status' => $this->post('status') ? $this->post('status') : '',
            ];
            $result = $this->retro_rate_model->post_dar($data);
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
        $result = $this->retro_rate_model->delete_data($this->query('id'));
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