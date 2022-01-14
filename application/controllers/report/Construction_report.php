<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class Construction_Report extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('construction_report_model');
    }

    public function project_detail_get()
    {
        $records = array('records' => $this->construction_report_model->get_project_detail());
        $html = $this->load->view('C_Project_Detail', $records);

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

    public function project_cost_get()
    {
        $records = array('records' => $this->construction_report_model->get_project_cost($this->get('date_from'), $this->get('date_to'), $this->get('exType'), $this->get('type')));
        $html = $this->load->view('C_Project_Cost', $records);

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

    public function project_sumall_get()
    {
        $records = array('records' => $this->construction_report_model->get_project_sumall());
        $html = $this->load->view('C_Project_Sumall', $records);

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

    public function project_completed_get()
    {
        $records = array(
            'records' => $this->construction_report_model->get_project_completed($this->get('from'), $this->get('to')),
            'from' => $this->get('from'),
            'to' => $this->get('to')
        );
        $html = $this->load->view('C_Project_Completed', $records);

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

    public function project_ongoing_get()
    {
        $records = array(
            'records' => $this->construction_report_model->get_project_ongoing()
        );
        $html = $this->load->view('C_Project_Ongoing', $records);

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

    public function project_unpaid_get()
    {
        $records = array(
            'records' => $this->construction_report_model->get_project_unpaid($this->get('unpaid_year')),
            'year' => $this->get('unpaid_year')
        );
        $html = $this->load->view('C_Project_Unpaid', $records);

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

    public function project_to_get()
    {
        $records = array(
            'records' => $this->construction_report_model->get_project_to($this->get('selectMonth')),
            'selectMonth' => $this->get('selectMonth')
        );
        $html = $this->load->view('C_Project_TO', $records);

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

    public function project_collection_get()
    {
        $records = array(
            'records' => $this->construction_report_model->get_project_collection($this->get('selectMonthCollection')),
            'selectMonthCollection' => $this->get('selectMonthCollection')
        );
        $html = $this->load->view('C_Project_Collection', $records);

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

    public function project_ledger_get()
    {
        $records = array(
            'records' => $this->construction_report_model->get_project_ledger($this->get('selectPODtlid'))
        );
        if($this->get('excel')){
            $html = $this->load->view('C_Project_Ledger', $records);
        }else{
            $html = $this->load->view('C_Project_Ledger', $records, true);
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
    public function expense_details_get()
    {
        $records = array(
            'records' => $this->construction_report_model->get_expense_details($this->get('selectPODtlid'))
        );
        if($this->get('excel')){
            $html = $this->load->view('C_Expense_Details', $records);
        }else{
            $html = $this->load->view('C_Expense_Details', $records, true);
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
    // others billing reports
    public function others_billing_get()
    {
        $records = array(
            'records' => $this->construction_report_model->get_others2($this->get('SOANo'))
        );
        if($this->get('detailType') == 1){
            $html = $this->load->view('others2', $records);
        }else{
            $html = $this->load->view('others3', $records);
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
    // transmittal other income
    public function transmittal_report_get()
    {
        $records = array(
            'records' => $this->construction_report_model->get_transmittal_report($this->get('type'), $this->get('transmittal_no')),
            'type' => $this->get('type'),
            'prepared_by' => $this->get('prepared_by'),
            'prepared_by_desig' => $this->get('prepared_by_desig'),
            'checked_by' => $this->get('checked_by'),
            'checked_by_desig' => $this->get('checked_by_desig'),
            'received_by' => $this->get('received_by'),
            'received_by_desig' => $this->get('received_by_desig'),
            'approved_by' => $this->get('approved_by'),
            'approved_by_desig' => $this->get('approved_by_desig'),
            'approved_by2' => $this->get('approved_by2'),
            'approved_by2_desig' => $this->get('approved_by2_desig'),
        );
        if($this->get('type') == 'ALLOWANCE'){
            $html = $this->load->view('O_allowance_transmittal_final', $records);
        }elseif($this->get('type') == 'INCENTIVES'){
            $html = $this->load->view('O_incentive_transmittal_final', $records);
        }else{
            $html = $this->load->view('O_allowance_transmittal', $records);
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