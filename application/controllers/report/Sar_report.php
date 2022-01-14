<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class SAR_Report extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('sar_report_model');
    }

    public function index_get()
    {
        $records = array(
            'records' => $this->sar_report_model->get_records($this->get('id')),
            'headers' => $this->sar_report_model->get_header($this->get('id')),
        );
        if($this->get('excel')){
            if($this->get('type') == 1){
                $html = $this->load->view('SAR_Check_Dam', $records);
            }else if($this->get('type') == 2){
                $html = $this->load->view('SAR_Dairy', $records);
            }else{
                $html = $this->load->view('SAR_Papaya', $records);
            }
        }else{
            if($this->get('type') == 1){
                $html = $this->load->view('SAR_Check_Dam', $records, true);
            }else if($this->get('type') == 2){
                $html = $this->load->view('SAR_Dairy', $records, true);
            }else{
                $html = $this->load->view('SAR_Papaya', $records, true);
            }
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