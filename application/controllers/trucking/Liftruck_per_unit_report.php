<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class Liftruck_Per_Unit_Report extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('liftruck_report_model');
    }

    public function index_get()
    {
        $data = array(
            'from' => $this->get('from') ? $this->get('from') : '',
            'to' => $this->get('to') ? $this->get('to') : '',
            'id' => $this->get('id') ? $this->get('id') : '',
            'type' => $this->get('type') ? $this->get('type') : '',
        );
        $records = array(
            'records' => $this->liftruck_report_model->get_per_unit_report($data)
        );
        if($this->get('excel')){
            $html = $this->load->view('Liftruck_PerUnit_Report', $records);
        }else{
            $html = $this->load->view('Liftruck_PerUnit_Report', $records, true);
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