<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class DMPI_OC extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('dmpi_oc_model');
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
    public function transmittal_report_get()
    {
        $sess = $this->session->userdata('gscbilling_session');
        
        if($this->get('transmittalNo')){
            if($this->get('exists')){
                $result = $this->dmpi_oc_model->get_transmittal_no($this->get('transmittalNo'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->get_transmittal_no($this->get('transmittalNo'), 2),
                    'from' => '',
                    'to' => '',
                    'preparedby' => $sess['fullname']
                );
                $html = $this->load->view('Transmittal_Billing', $records);
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
        }elseif($this->get('summary')){
            if($this->get('exists')){
                $data = [
                    'confirmedBy' => $this->get('confirmedBy') ? $this->get('confirmedBy') : '',
                    'confirmedByPosition' => $this->get('confirmedByPosition') ? $this->get('confirmedByPosition') : '',
                    'approvedBy' => $this->get('approvedBy') ? $this->get('approvedBy') : '',
                    'approvedByPosition' => $this->get('approvedByPosition') ? $this->get('approvedByPosition') : '',
                ];
                $update_sig = $this->dmpi_oc_model->update_signatory($data, $this->get('transmitNo'));
                $result = $this->dmpi_oc_model->get_transmittal_summary($this->get('transmitNo'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->get_transmittal_summary($this->get('transmitNo'), 2),
                    'infos' => $this->dmpi_oc_model->get_transmittal_info($this->get('transmitNo')),
                    'latest_date' => $this->dmpi_oc_model->get_latest_soa_date($this->get('transmitNo')),
                    'transmittalNumber' => $this->get('transmitNo'),
                    'copy' => $this->get('copy'),
                    'preview' => $this->get('preview') ? 0 : 1
                );
                if($this->get('long')){
                    $html = $this->load->view('Transmittal_Summary_Long', $records, true);
                }else{
                    $html = $this->load->view('Transmittal_Summary', $records, true);
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
        }else{
            if($this->get('exists')){
                $result = $this->dmpi_oc_model->get_transmittal($this->get('from'), $this->get('to'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->get_transmittal($this->get('from'), $this->get('to'), 2),
                    'from' => $this->get('from'),
                    'to' => $this->get('to'),
                    'preparedby' => $sess['fullname']
                );
                $html = $this->load->view('Transmittal_Billing', $records);
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
    public function reactivated_soa_get()
    {
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('SAR')){
            if($this->get('exists')){
                $result = $this->dmpi_oc_model->get_sar_report($this->get('from'), $this->get('to'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->get_sar_report($this->get('from'), $this->get('to'), 2),
                    'from' => $this->get('from'),
                    'to' => $this->get('to'),
                    'preparedby' => $sess['fullname']
                );
                if($this->get('Excel')){
                    $html = $this->load->view('SAR_Reactivated', $records);
                }else{
                    $html = $this->load->view('SAR_Reactivated', $records, true);
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
        }elseif($this->get('DAR')){
            if($this->get('exists')){
                $result = $this->dmpi_oc_model->get_dar_report($this->get('from'), $this->get('to'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->get_dar_report($this->get('from'), $this->get('to'), 2),
                    'from' => $this->get('from'),
                    'to' => $this->get('to'),
                    'preparedby' => $sess['fullname']
                );
                if($this->get('Excel')){
                    $html = $this->load->view('DAR_Reactivated', $records);
                }else{
                    $html = $this->load->view('DAR_Reactivated', $records, true);
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
        }elseif($this->get('OtherIncome')){
            if($this->get('exists')){
                $result = $this->dmpi_oc_model->get_other_income_report($this->get('from'), $this->get('to'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->get_other_income_report($this->get('from'), $this->get('to'), 2),
                    'from' => $this->get('from'),
                    'to' => $this->get('to'),
                    'preparedby' => $sess['fullname']
                );
                if($this->get('Excel')){
                    $html = $this->load->view('Other_Income_Reactivated', $records);
                }else{
                    $html = $this->load->view('Other_Income_Reactivated', $records, true);
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
        }elseif($this->get('OtherClient')){
            if($this->get('exists')){
                $result = $this->dmpi_oc_model->get_other_client_report($this->get('from'), $this->get('to'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->get_other_client_report($this->get('from'), $this->get('to'), 2),
                    'from' => $this->get('from'),
                    'to' => $this->get('to'),
                    'preparedby' => $sess['fullname']
                );
                if($this->get('Excel')){
                    $html = $this->load->view('Other_Client_Reactivated', $records);
                }else{
                    $html = $this->load->view('Other_Client_Reactivated', $records, true);
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

    public function soa_status_get(){
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->soa_status_sar($this->get('from'), $this->get('to'), 1);
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->soa_status_dar($this->get('from'), $this->get('to'), 2),
                'records_sar' => $this->dmpi_oc_model->soa_status_sar($this->get('from'), $this->get('to'), 2),
                'from' => $this->get('from'),
                'to' => $this->get('to'),
                'preparedby' => $sess['fullname']
            );
            $html = $this->load->view('SOA_Status_Monitoring', $records, true);
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
    public function billing_and_collection_get(){
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->get_billing_and_collection($this->get('generation'), $this->get('from'), $this->get('to'), 1);
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->get_billing_and_collection($this->get('generation'), $this->get('from'), $this->get('to'), 2)
            );
            $html = $this->load->view('Billing_And_Collection', $records, true);
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
    public function aging_report_get(){
        // $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->get_aging($this->get('from'), $this->get('to'), 1);
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->get_aging($this->get('from'), $this->get('to'), 2),
                'from' => $this->get('from'),
                'to' => $this->get('to'),
            );
            if($this->get('type') == "excel"){
                $html = $this->load->view('Aging_Report', $records);
            }else{
                $html = $this->load->view('Aging_Report', $records, true);
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
    public function year_to_date_get(){
        // $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->year_to_date_report($this->get('from'), $this->get('to'), 1);
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->year_to_date_report($this->get('from'), $this->get('to'), 2),
                'from' => $this->get('from'),
                'to' => $this->get('to'),
            );
            if($this->get('excel')){
                $html = $this->load->view('Year_To_Date', $records);
            }else{
                $html = $this->load->view('Year_To_Date', $records, true);
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
    public function per_client_report_get(){
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->all_client_report($this->get('from'), $this->get('to'), 1);
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->all_client_report($this->get('from'), $this->get('to'), 2),
                'from' => $this->get('from'),
                'to' => $this->get('to'),
            );
            if($this->get('type') == "excel"){
                $html = $this->load->view('All_Client_Report', $records);
            }else{
                $html = $this->load->view('All_Client_Report', $records, true);
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
    public function annual_report_get(){
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->annual_report($this->get('from'), $this->get('to'), 1);
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->annual_report($this->get('from'), $this->get('to'), 2),
                'from' => $this->get('from'),
                'to' => $this->get('to'),
            );
            if($this->get('type') == "excel"){
                $html = $this->load->view('Annual_Report', $records);
            }else{
                $html = $this->load->view('Annual_Report', $records, true);
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
    public function weekly_report_get(){
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->weekly_report($this->get('searchBy'), $this->get('from'), $this->get('to'), $this->get('pmy'), $this->get('period'), 1);
            $this->returns($result);
        }else{
            $x_from = explode('-', $this->get('from'));
            $x_to = explode('-', $this->get('to'));
            $diff = (int)($x_to[1]) - (int)($x_from[1]);
            if($diff > 0){
                $period = strtoupper(date('F j, Y', strtotime($this->get('from'))) ." - ". date('F j, Y', strtotime($this->get('to'))));
            }else{
                $period = strtoupper(date('F j', strtotime($this->get('from'))) ."-". date('j, Y', strtotime($this->get('to'))));
            }
            $records = array(
                'records' => $this->dmpi_oc_model->weekly_report($this->get('searchBy'), $this->get('from'), $this->get('to'), $this->get('pmy'), $this->get('period'), 2),
                'from' => $this->get('from'),
                'to' => $this->get('to'),
                'period' => $period
            );
            $html = $this->load->view('Weekly_Report', $records);
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
    public function monthly_report_get(){
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('monthly')){
            if($this->get('exists')){
                $result = $this->dmpi_oc_model->monthly_report($this->get('searchBy'), $this->get('from'), $this->get('to'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->monthly_report($this->get('searchBy'), $this->get('from'), $this->get('to'), 2),
                    'from' => $this->get('from'),
                    'to' => $this->get('to'),
                );
                if($this->get('excel')){
                    $html = $this->load->view('Monthly_Report', $records);
                }else{
                    $html = $this->load->view('Monthly_Report', $records, true);
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
        }elseif($this->get('monthlyTransmittal')){
            if($this->get('exists')){
                $result = $this->dmpi_oc_model->monthly_report_transmittal($this->get('searchBy'), $this->get('from'), $this->get('to'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->monthly_report_transmittal($this->get('searchBy'), $this->get('from'), $this->get('to'), 2),
                );
                if($this->get('excel')){
                    $html = $this->load->view('Monthly_Transmittal_Report', $records);
                }else{
                    $html = $this->load->view('Monthly_Transmittal_Report', $records, true);
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
        }else{
            if($this->get('exists')){
                $result = $this->dmpi_oc_model->monthly_report_summary($this->get('from'), $this->get('to'), 1);
                $this->returns($result);
            }else{
                $records = array(
                    'records' => $this->dmpi_oc_model->monthly_report_summary($this->get('from'), $this->get('to'), 2),
                    'from' => $this->get('from'),
                    'to' => $this->get('to'),
                );
                if($this->get('excel')){
                    $html = $this->load->view('Monthly_Report_Summary', $records);
                }else{
                    $html = $this->load->view('Monthly_Report_Summary', $records, true);
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
    public function sar_transmittal_get(){
        $sess = $this->session->userdata('gscbilling_session');
        $records = array(
            'records' => $this->dmpi_oc_model->sar_transmittal($this->get('id'))
        );
        if($this->get('excel')){
            $html = $this->load->view('SAR_Transmittal', $records);
        }else{
            $html = $this->load->view('SAR_Transmittal', $records, true);
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

    public function accrual_report_get(){
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->accrual_report($this->get('from'), $this->get('to'), 1);
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->accrual_report($this->get('from'), $this->get('to'), 2)
            );
            $html = $this->load->view('Accrual_Report', $records, true);
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
    public function sar_per_department_get(){
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->get_sar_per_dept($this->get('dept'), $this->get('from'), $this->get('to'), 1);
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->get_sar_per_dept($this->get('dept'), $this->get('from'), $this->get('to'), 2)
            );
            if($this->get('excel')){
                $html = $this->load->view('SAR_Per_Dept', $records);
            }else{
                $html = $this->load->view('SAR_Per_Dept', $records, true);
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
    public function sar_po_report_get(){
        $sess = $this->session->userdata('gscbilling_session');
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->get_sar_po_report($this->get('from'), $this->get('to'), 1);
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->get_sar_po_report($this->get('from'), $this->get('to'), 2)
            );
            if($this->get('excel')){
                $html = $this->load->view('SAR_PO_Report', $records);
            }else{
                $html = $this->load->view('SAR_PO_Report', $records, true);
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
    public function oc_ledger_report_get(){
        if($this->get('exists')){
            $result = $this->dmpi_oc_model->get_oc_ledger_report($this->get('client'));
            $this->returns($result);
        }else{
            $records = array(
                'records' => $this->dmpi_oc_model->get_oc_ledger_report($this->get('client')),
                'client' => $this->get('client')
            );
            if($this->get('excel')){
                $html = $this->load->view('OC_Ledger_Report', $records);
            }else{
                $html = $this->load->view('OC_Ledger_Report', $records, true);
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