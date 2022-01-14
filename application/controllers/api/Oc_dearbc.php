<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';


class OC_DEARBC extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('oc_dearbc_model');
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
    public function index_get(){
        if($this->get('getDearbc')){
            $result = $this->oc_dearbc_model->get_dearbc();
        }elseif($this->get('getHdr')){
            $result = $this->oc_dearbc_model->get_header($this->get('hdr_id'));
        }elseif($this->get('getHeaderID')){
            $result = $this->oc_dearbc_model->get_transmittal_details($this->get('getHeaderID'));
        }elseif($this->get('getEmployee')){
            $result = $this->oc_dearbc_model->get_employee();
        }elseif($this->get('getDtl')){
            $result = $this->oc_dearbc_model->get_detail($this->get('hdr_id'));
        }elseif($this->get('getPeriod')){
            $result = $this->oc_dearbc_model->get_period();
        }elseif($this->get('getLinkedData')){
            $result = $this->oc_dearbc_model->get_linked_data($this->get('chapa'), $this->get('hdr_id'));
        }elseif($this->get('getReportPreviewData')){
            $result = $this->oc_dearbc_model->get_report_preview($this->get('id'));
        }elseif($this->get('generateReportLetterHead')){
            $records = array(
                'records' => $this->oc_dearbc_model->get_letterhead_report($this->get('id')),
                'details' => $this->oc_dearbc_model->get_letterhead_detail_report($this->get('id'))
            );
            // $html = $this->load->view('DEARBC_Letterhead', $records);
            $html = $this->load->view('DEARBC_Letterhead', $records, true);
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
        }elseif($this->get('printPreviewDetails')){
            $records = array(
                'records' => $this->oc_dearbc_model->preview_report_details($this->get('id')),
            );
            $html = $this->load->view('DEARBC_report', $records);
            // $html = $this->load->view('DEARBC_report', $records, true);
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
        }elseif($this->get('getTotalBilling')){
            $result = $this->oc_dearbc_model->get_total_billing($this->get('hdr_id'));
        }
        $this->returns($result);
    }

    public function index_post(){
        if($this->post('save_header')){
            $data = [
                'TOCDHDR' => $this->post('TOCDHDR') ? $this->post('TOCDHDR') : 0,
                'letter_id' => $this->post('letter_id') ? $this->post('letter_id') : 0,
                'period' => $this->post('period') ? $this->post('period') : "",
                'SOANo' => $this->post('SOANo') ? $this->post('SOANo') : '',
                'paystation' => $this->post('paystation') ? $this->post('paystation') : '',
                'period_date' => $this->post('period_date') ? $this->post('period_date') : '',
                'admin_percentage' => $this->post('admin_percentage') ? $this->post('admin_percentage') : '',
                'prepared_by' => $this->post('prepared_by') ? $this->post('prepared_by') : '',
                'prepared_by_desig' => $this->post('prepared_by_desig') ? $this->post('prepared_by_desig') : '',
                'checked_by' => $this->post('checked_by') ? $this->post('checked_by') : '',
                'checked_by_desig' => $this->post('checked_by_desig') ? $this->post('checked_by_desig') : '',
                'approved_by' => $this->post('approved_by') ? $this->post('approved_by') : '',
                'approved_by_desig' => $this->post('approved_by_desig') ? $this->post('approved_by_desig') : '',
            ];
            $result = $this->oc_dearbc_model->save_header($data);
            if($result['id']){
                $result = array(
                    'success' => true,
                    'id' => $result['id'],
                    'SOANo' => $result['SOANo'],
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }elseif($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully updated'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Incorrect Period or Nothing to update.'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('save_dearbc')){
            $data = [
                'TOCDID' => $this->post('TOCDID') ? $this->post('TOCDID') : 0,
                'period' => $this->post('period') ? $this->post('period') : '',
                'period_date' => $this->post('period_date') ? $this->post('period_date') : '',
                'PayMonthPeriod' => $this->post('PayMonthPeriod') ? $this->post('PayMonthPeriod') : '',
                'PeriodFrom' => $this->post('PeriodFrom') ? $this->post('PeriodFrom') : '',
                'PeriodTo' => $this->post('PeriodTo') ? $this->post('PeriodTo') : '',
                'prepared_by' => $this->post('prepared_by') ? $this->post('prepared_by') : '',
                'prepared_by_desig' => $this->post('prepared_by_desig') ? $this->post('prepared_by_desig') : '',
                'checked_by' => $this->post('checked_by') ? $this->post('checked_by') : '',
                'checked_by_desig' => $this->post('checked_by_desig') ? $this->post('checked_by_desig') : '',
                'approved_by' => $this->post('approved_by') ? $this->post('approved_by') : '',
                'approved_by_desig' => $this->post('approved_by_desig') ? $this->post('approved_by_desig') : '',
            ];
            $result = $this->oc_dearbc_model->save_dearbc($data);
            if($result['id']){
                $result = array(
                    'success' => true,
                    'id' => $result['id'],
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }elseif($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully updated'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to update'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('transmittal')){
            $data = array(
                'transmittal_no' => $this->post('transmittal_no') ? $this->post('transmittal_no') : '',
                'date_transmitted' => $this->post('date_transmitted') ? $this->post('date_transmitted') : '',
                'billing_statement' => $this->post('billing_statement') ? $this->post('billing_statement') : '',
                'Status' => 'TRANSMITTED'
            );
            $result = $this->oc_dearbc_model->transmit_data($this->post('id'), $data);
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully Transmitted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed to transmit'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('reactivation')){
            $data = array(
                'id' => $this->post('id') ? $this->post('id') : 0,
                'reactivatedBy' => $this->post('reactivatedBy') ? $this->post('reactivatedBy') : '',
                'reasonofreactivation' => $this->post('reasonofreactivation') ? $this->post('reasonofreactivation') : '',
                'client' => 'DEARBC',
                'Datetime_reactivation' => date('Y-m-d H:i:s'),
            );
            $result = $this->oc_dearbc_model->reactivate_data($data);
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully Reactivated'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed to reactivate'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('printPreview')){
            $data = array(
                'TOCDID' => $this->post('TOCDID') ? $this->post('TOCDID') : 0,
                'letter_to' => $this->post('letter_to') ? $this->post('letter_to') : '',
                'body' => $this->post('body') ? $this->post('body') : '',
                'body2' => $this->post('body2') ? $this->post('body2') : '',
            );
            $result = $this->oc_dearbc_model->save_print_preview($data);
            if($result){
                $result = array(
                    'success' => true,
                    'array_result' => $result,
                    'message' => 'Successfully saved'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed to save'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('printPreviewDetails')){
            $result = $this->oc_dearbc_model->preview_report_details($this->post('id'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Generation Successful'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed to generate.'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }else{
            $data = [
                'TODDTL' => $this->post('TODDTL') ? $this->post('TODDTL') : 0,
                'hdr_id' => $this->post('hdr_id') ? $this->post('hdr_id') : 0,
                'Chapa' => $this->post('Chapa') ? $this->post('Chapa') : '',
                'Name' => $this->post('Name') ? $this->post('Name') : '',
                'rd_st' => $this->post('rd_st') ? $this->post('rd_st') : '',
                'rd_ot' => $this->post('rd_ot') ? $this->post('rd_ot') : '',
                'rd_nd' => $this->post('rd_nd') ? $this->post('rd_nd') : '',
                'rd_ndot' => $this->post('rd_ndot') ? $this->post('rd_ndot') : '',
                'shol_st' => $this->post('shol_st') ? $this->post('shol_st') : '',
                'shol_ot' => $this->post('shol_ot') ? $this->post('shol_ot') : '',
                'shol_nd' => $this->post('shol_nd') ? $this->post('shol_nd') : '',
                'shol_ndot' => $this->post('shol_ndot') ? $this->post('shol_ndot') : '',
                'rhol_st' => $this->post('rhol_st') ? $this->post('rhol_st') : '',
                'rhol_ot' => $this->post('rhol_ot') ? $this->post('rhol_ot') : '',
                'rhol_nd' => $this->post('rhol_nd') ? $this->post('rhol_nd') : '',
                'rhol_ndot' => $this->post('rhol_ndot') ? $this->post('rhol_ndot') : '',
                'shrd_st' => $this->post('shrd_st') ? $this->post('shrd_st') : '',
                'shrd_ot' => $this->post('shrd_ot') ? $this->post('shrd_ot') : '',
                'shrd_nd' => $this->post('shrd_nd') ? $this->post('shrd_nd') : '',
                'shrd_ndot' => $this->post('shrd_ndot') ? $this->post('shrd_ndot') : '',
                'rhrd_st' => $this->post('rhrd_st') ? $this->post('rhrd_st') : '',
                'rhrd_ot' => $this->post('rhrd_ot') ? $this->post('rhrd_ot') : '',
                'rhrd_nd' => $this->post('rhrd_nd') ? $this->post('rhrd_nd') : '',
                'rhrd_ndot' => $this->post('rhrd_ndot') ? $this->post('rhrd_ndot') : '',
                'extra' => $this->post('extra') ? $this->post('extra') : '',
                'silpat' => $this->post('silpat') ? $this->post('silpat') : '',
                'adjustment' => $this->post('adjustment') ? $this->post('adjustment') : '',
                'incentive' => $this->post('incentive') ? $this->post('incentive') : '',
                'addpay' => $this->post('addpay') ? $this->post('addpay') : '',
                'volumepay' => $this->post('volumepay') ? $this->post('volumepay') : '',
                'allowance' => $this->post('allowance') ? $this->post('allowance') : '',
                'cola' => $this->post('cola') ? $this->post('cola') : '',
                'grosspay' => $this->post('grosspay') ? $this->post('grosspay') : '',
                'sss_ec' => $this->post('sss_ec') ? $this->post('sss_ec') : '',
                'sss_er' => $this->post('sss_er') ? $this->post('sss_er') : '',
                'phic_er' => $this->post('phic_er') ? $this->post('phic_er') : '',
                'hdmf_er' => $this->post('hdmf_er') ? $this->post('hdmf_er') : '',
                'mpro' => $this->post('mpro') ? $this->post('mpro') : '',
                'total' => $this->post('total') ? $this->post('total') : '',
            ];
            $result = $this->oc_dearbc_model->save_detail($data);
            if($result['id']){
                $result = array(
                    'success' => true,
                    'id' => $result['id'],
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }elseif($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully updated'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to update'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }
    }

    public function index_delete(){
        $result = $this->oc_dearbc_model->delete_header($this->query('id'));
        if ($result){
            $result = array(
                'success' => true,
                'message' => 'Successfully deleted'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }else{
            $result = array(
                'success' => false,
                'message' => 'Failed deleting'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }

    public function detail_delete(){
        $result = $this->oc_dearbc_model->delete_detail($this->query('id'));
        if ($result){
            $result = array(
                'success' => true,
                'message' => 'Successfully deleted'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }else{
            $result = array(
                'success' => false,
                'message' => 'Failed deleting'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }

    public function dearbc_delete(){
        $result = $this->oc_dearbc_model->delete_dearbc($this->query('id'));
        if ($result){
            $result = array(
                'success' => true,
                'message' => 'Successfully deleted'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }else{
            $result = array(
                'success' => false,
                'message' => 'Failed deleting'
            );
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }
}