<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';


class DAR_SOA_Monitoring extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('dar_soa_monitoring_model');
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
        if($this->get('searchPP')){
            $result = $this->dar_soa_monitoring_model->get_batch_by_pp($this->get('pmy'), $this->get('period'), $this->get('status'));
            $this->returns($result);
        }elseif($this->get('searchDR')){
            $result = $this->dar_soa_monitoring_model->get_batch_by_dr($this->get('from'), $this->get('to'), $this->get('status'));
            $this->returns($result);
        }elseif($this->get('ExcelSupervisor')){
            $records = array(
                'records' => $this->dar_soa_monitoring_model->get_supervisor_report($this->get('SOANumber')),
                'soaNumber' => $this->get('SOANumber')
            );
            
            $html = $this->load->view('Supervisor_Entry_Report', $records);
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'default_font' => 'tahoma',
            ]); 
            $mpdf->useFixedNormalLineHeight = false;
            $mpdf->useFixedTextBaseline = false;
            $mpdf->adjustFontDescLineheight = 0.5;
            $mpdf->packTableData = true;
            $mpdf->shrink_tables_to_fit = 1;
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }
        
    }

    public function index_post(){
        $id = $this->post('id');
        $checkFlag = $this->post('checkFlag') ? $this->post('checkFlag') : 0;
        $result = $this->dar_soa_monitoring_model->updateBatchFlag($id, $checkFlag);
        if($result){
            $result = array(
                'success' => true,
                'message' => 'Successfully updated'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }else{
            $result = array(
                'success' => false,
                'message' => 'Something went wrong'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }
}