<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class Overall_Report extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('trucking_overall_model');
    }

    public function index_get()
    {
        $data = array(
            'id' => $this->get('id') ? $this->get('id') : '',
            'generate' => $this->get('generate') ? $this->get('generate') : '',
            'from' => $this->get('from') ? $this->get('from') : '',
            'to' => $this->get('to') ? $this->get('to') : '',
        );
        $records = array(
            'records' => $this->trucking_overall_model->get_report($data),
        );
        if($this->get('excel')){
            if($this->get('generate') === '1' or $this->get('generate') === '2'){
                $html = $this->load->view('Trucking_Overall_Report', $records);
            }else{
                $html = $this->load->view('Trucking_Overall_Report_Summary', $records);
            }
        }else{
            if($this->get('generate') === '1' or $this->get('generate') === '2'){
                $html = $this->load->view('Trucking_Overall_Report', $records, true);
            }else{
                $html = $this->load->view('Trucking_Overall_Report_Summary', $records, true);
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