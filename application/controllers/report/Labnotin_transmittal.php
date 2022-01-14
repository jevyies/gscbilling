<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class Labnotin_Transmittal extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('oc_labnotin_model');
    }

    public function index_get()
    {
        $records = array(
            'records' => $this->oc_labnotin_model->get_transmittal_labnotin($this->get('id')),
            'details' => array(
                'period_date' => $this->get('period_date'),
                'transmittal_no' => $this->get('transmittal_no'),
                'date_transmitted' => $this->get('date_transmitted'),
                'document_date' => $this->get('document_date'),
                'Prepared_by' => $this->get('Prepared_by'),
                'Prepared_by_desig' => $this->get('Prepared_by_desig'),
                'Checked_by' => $this->get('Checked_by'),
                'Checked_by_desig' => $this->get('Checked_by_desig'),
                'Received_by' => $this->get('Received_by'),
                'Received_by_desig' => $this->get('Received_by_desig'),
                'Approved_by' => $this->get('Approved_by'),
                'Approved_by_desig' => $this->get('Approved_by_desig'),
                'Approved_by_2' => $this->get('Approved_by_2'),
                'Approved_by_2_desig' => $this->get('Approved_by_2_desig')
            )
        );
        $html = $this->load->view('Labnotin_Transmittal', $records, true);
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