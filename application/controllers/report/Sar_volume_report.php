<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class SAR_Volume_Report extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('sar_volume_report_model');
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
        );
        $result = $this->sar_volume_report_model->get_records($data, true);
        $this->returns($result);
    }

    public function index_get()
    {
        $data = array(
            'from' => $this->get('from') ? $this->get('from') : '',
            'to' => $this->get('to') ? $this->get('to') : '',
        );
        $records = array(
            'records' => $this->sar_volume_report_model->get_records($data, false),
            'from' => $this->get('from') ? $this->get('from') : '',
            'to' => $this->get('to') ? $this->get('to') : '',
        );
        $html = $this->load->view('SAR_Volume', $records);
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