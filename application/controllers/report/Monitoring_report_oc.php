<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class Monitoring_Report_OC extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('monitoring_report_oc_model');
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
            'client' => $this->post('client') ? $this->post('client') : '',
            'year' => $this->post('year') ? $this->post('year') : '',
        );
        $result = $this->monitoring_report_oc_model->get_records($data);
        $this->returns($result);
    }

    public function index_get()
    {
        $data = array(
            'client' => $this->get('client') ? $this->get('client') : '',
            'year' => $this->get('year') ? $this->get('year') : '',
        );
        $records = array(
            'records' => $this->monitoring_report_oc_model->get_records($data),
            'client' => $this->get('client') ? $this->get('client') : '',
            'year' => $this->get('year') ? $this->get('year') : '',
            'Prepared_by' => $_SESSION['gscbilling_session']['fullname']
        );
        if($data['client'] == 'BCC'){
            $html = $this->load->view('BCC_Monitoring_Report', $records);
        }elseif($data['client'] == 'SLERS'){
            $html = $this->load->view('SLERS_Monitoring_Report', $records);
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