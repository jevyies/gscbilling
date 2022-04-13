<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class Jeep_OpSummary_Report extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('jeep_report_model');
    }

    public function index_get()
    {
        $data = array(
            'asof' => $this->get('asof') ? $this->get('asof') : '',
            'from' => $this->get('from') ? $this->get('from') : '',
            'to' => $this->get('to') ? $this->get('to') : '',
            'type' => $this->get('type') ? $this->get('type') : '',
        );
        $records = array(
            'records' => $data['type'] == 3 ? $this->jeep_report_model->get_operator_summary_check_date($data) : $this->jeep_report_model->get_operator_summary_report($data),
            'as_of_date' => $this->get('asof') ? $this->get('asof') : '',
            'from' => $this->get('from') ? $this->get('from') : '',
            'to' => $this->get('to') ? $this->get('to') : '',
            'type' => $this->get('type') ? $this->get('type') : '',
            'pb' => $this->get('pb') ? $this->get('pb') : '',
            'pbp' => $this->get('pbp') ? $this->get('pbp') : '',
            'cb' => $this->get('cb') ? $this->get('cb') : '',
            'cbp' => $this->get('cbp') ? $this->get('cbp') : '',
            'ab' => $this->get('ab') ? $this->get('ab') : '',
            'abp' => $this->get('abp') ? $this->get('abp') : '',
            'nb' => $this->get('nb') ? $this->get('nb') : '',
            'nbp' => $this->get('nbp') ? $this->get('nbp') : '',
        );
        if($data['type'] == 3){
            if($this->get('excel')){
                $html = $this->load->view('Jeep_Operator_Summary_Checks', $records);
            }else{
                $html = $this->load->view('Jeep_Operator_Summary_Checks', $records, true);
            }
        }else{
            if($this->get('excel')){
                $html = $this->load->view('Jeep_Operator_Summary_Report', $records);
            }else{
                $html = $this->load->view('Jeep_Operator_Summary_Report', $records, true);
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