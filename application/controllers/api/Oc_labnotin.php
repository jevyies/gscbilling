<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';


class OC_Labnotin extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('oc_labnotin_model');
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
        if($this->get('getHeader')){
            $result = $this->oc_labnotin_model->get_header();
        }elseif($this->get('getHeaderID')){
            $result = $this->oc_labnotin_model->get_transmittal_details($this->get('getHeaderID'));
        }elseif($this->get('getCCList')){
            $result = $this->oc_labnotin_model->get_cc_list();
        }elseif($this->get('getGLList')){
            $result = $this->oc_labnotin_model->get_gl_list();
        }elseif($this->get('getDtl')){
            $result = $this->oc_labnotin_model->get_detail($this->get('hdr_id'));
        }elseif($this->get('getTotalBilling')){
            $result = $this->oc_labnotin_model->get_total_billing($this->get('hdr_id'));
        }elseif($this->get('getReportPreviewData')){
            $result = $this->oc_labnotin_model->get_report_preview($this->get('id'));
        }elseif($this->get('generateReport')){
            $records = array(
                'records' => $this->oc_labnotin_model->get_report($this->get('id')),
            );
            // $html = $this->load->view('DEARBC_report', $records);
            $html = $this->load->view('LABNOTIN_report', $records, true);
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
        }elseif($this->get('getTransmittalNo')){
            $result = $this->oc_labnotin_model->get_transmittal_number($this->get('id'));
        }
        $this->returns($result);
    }

    public function index_post(){
        if($this->post('save_header')){
            $data = [
                'TOCLHDR' => $this->post('TOCLHDR') ? $this->post('TOCLHDR') : 0,
                'SOANo' => $this->post('SOANo') ? $this->post('SOANo') : 0,
                'period' => $this->post('period') ? $this->post('period') : "",
                'Date' => date('Y-m-d'),
                'Payment_for' => $this->post('Payment_for') ? $this->post('Payment_for') : '',
                'period_date' => $this->post('period_date') ? $this->post('period_date') : '',
                'admin_percentage' => $this->post('admin_percentage') ? $this->post('admin_percentage') : '',
                'Prepared_by' => $this->post('Prepared_by') ? $this->post('Prepared_by') : '',
                'Prepared_by_desig' => $this->post('Prepared_by_desig') ? $this->post('Prepared_by_desig') : '',
                'Noted_by' => $this->post('Noted_by') ? $this->post('Noted_by') : '',
                'Noted_by_desig' => $this->post('Noted_by_desig') ? $this->post('Noted_by_desig') : '',
                'Checked_by' => $this->post('Checked_by') ? $this->post('Checked_by') : '',
                'Checked_by_desig' => $this->post('Checked_by_desig') ? $this->post('Checked_by_desig') : '',
                'Approved_by' => $this->post('Approved_by') ? $this->post('Approved_by') : '',
                'Approved_by_desig' => $this->post('Approved_by_desig') ? $this->post('Approved_by_desig') : '',
                'Approved_by_2' => $this->post('Approved_by_2') ? $this->post('Approved_by_2') : '',
                'Approved_by_2_desig' => $this->post('Approved_by_2_desig') ? $this->post('Approved_by_2_desig') : '',
                'cut_off_month' => $this->post('cut_off_month') ? $this->post('cut_off_month') : '',
                'cut_off_year' => $this->post('cut_off_year') ? $this->post('cut_off_year') : ''
            ];
            $result = $this->oc_labnotin_model->save_header($data);
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
                    'message' => 'Nothing to update'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('detail')){
            $data = [
                'TOCLDTL' => $this->post('TOCLDTL') ? $this->post('TOCLDTL') : 0,
                'hdr_id' => $this->post('hdr_id') ? $this->post('hdr_id') : 0,
                'Activity' => $this->post('Activity') ? $this->post('Activity') : '',
                'date' => $this->post('date') ? $this->post('date') : '',
                'gl' => $this->post('gl') ? $this->post('gl') : '',
                'cc' => $this->post('cc') ? $this->post('cc') : '',
                'hrs' => $this->post('hrs') ? $this->post('hrs') : '',
                'rate_hr' => $this->post('rate_hr') ? $this->post('rate_hr') : '',
                'amount_billed' => $this->post('amount_billed') ? $this->post('amount_billed') : ''
            ];
            $result = $this->oc_labnotin_model->save_detail($data);
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
            $result = $this->oc_labnotin_model->transmit_data($this->post('id'), $data);
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
                'client' => 'LABNOTIN',
                'Datetime_reactivation' => date('Y-m-d H:i:s'),
            );
            $result = $this->oc_labnotin_model->reactivate_data($data);
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
                'TOCLHDR' => $this->post('TOCLHDR') ? $this->post('TOCLHDR') : 0,
                'letter_to' => $this->post('letter_to') ? $this->post('letter_to') : '',
                'Payment_for' => $this->post('Payment_for') ? $this->post('Payment_for') : '',
            );
            $result = $this->oc_labnotin_model->save_print_preview($data);
            if($result){
                $result = array(
                    'success' => true,
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
        }elseif($this->post('saveReport')){
            $data = array(
                'TOCLHDR' => $this->post('TOCLHDR') ? $this->post('TOCLHDR') : 0,
                'transmittal_no' => $this->post('transmittal_no') ? $this->post('transmittal_no') : '',
                'date_transmitted' => $this->post('date_transmitted') ? $this->post('date_transmitted') : '',
                'Date' => $this->post('Date') ? $this->post('Date') : '',
            );
            $result = $this->oc_labnotin_model->save_report_transmittal($data);
            if($result){
                $result = array(
                    'success' => true,
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
        }
    }

    public function index_delete(){
        $result = $this->oc_labnotin_model->delete_header($this->query('id'));
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