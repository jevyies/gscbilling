<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class Retro_Report extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('retro_report_model');
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
    public function index_post(){
        $data = array(
            'from' => $this->post('from') ? $this->post('from') : '',
            'to' => $this->post('to') ? $this->post('to') : '',
            'client' => $this->post('client') ? $this->post('client') : '',
            'location' => $this->post('location') ? $this->post('location') : '',
        );
        $result = $this->retro_report_model->get_records($data, true);
        $this->returns($result);
    }

    public function index_get()
    {
        if($this->get('uploads')){
            $result = $this->retro_report_model->get_uploads($this->get('type'));
            $this->returns($result);
        }else{
            $data = array(
                'from' => $this->get('from') ? $this->get('from') : '',
                'to' => $this->get('to') ? $this->get('to') : '',
                'client' => $this->get('client') ? $this->get('client') : '',
                'location' => $this->get('location') ? $this->get('location') : '',
            );
            $records = array(
                'records' => $this->retro_report_model->get_records($data, false),
                'from' => $this->get('from') ? $this->get('from') : '',
                'to' => $this->get('to') ? $this->get('to') : '',
            );
            if($this->get('client') == "DAR"){
                $html = $this->load->view('Retro_Report_DAR', $records);
            }
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
}