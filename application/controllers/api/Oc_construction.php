<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';


class OC_Construction extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('oc_construction_model');
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
            $result = $this->oc_construction_model->get_header();
        }elseif($this->get('getHeaderID')){
            $result = $this->oc_construction_model->get_transmittal_details($this->get('getHeaderID'));
        }elseif($this->get('getTotalBilling')){
            $result = $this->oc_construction_model->get_total_billing($this->get('hdr_id'));
        }elseif($this->get('getDtl')){
            $result = $this->oc_construction_model->get_detail($this->get('hdr_id'));
        }elseif($this->get('getRates')){
            $result = $this->oc_construction_model->get_rates($this->get('activity_id'));
        }elseif($this->get('getRatesSelected')){
            $result = $this->oc_construction_model->get_rates_selected($this->get('hdr_id'));
        }elseif($this->get('getReportPreviewData')){
            $result = $this->oc_construction_model->get_report_preview($this->get('id'));
        }elseif($this->get('generateReport')){
            $records = array(
                'records' => $this->oc_construction_model->get_report_preview_final($this->get('id')),
            );
            // $html = $this->load->view('CONSTRUCTION_Letterhead', $records);
            $html = $this->load->view('CONSTRUCTION_Letterhead', $records, true);
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
        }elseif($this->get('generateReportDetails')){
            $records = array(
                'records' => $this->oc_construction_model->get_report($this->get('id')),
            );
            $html = $this->load->view('CONSTRUCTION_report', $records);
            // $html = $this->load->view('CONSTRUCTION_report', $records, true);
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
        $this->returns($result);
    }

    public function index_post(){
        if($this->post('save_header')){
            $data = [
                'TOCSHDR' => $this->post('TOCSHDR') ? $this->post('TOCSHDR') : 0,
                'SOANo' => $this->post('SOANo') ? $this->post('SOANo') : 0,
                'period' => $this->post('period') ? $this->post('period') : "",
                'Date' => $this->post('Date') ? $this->post('Date') : '',
                'Payment_for' => $this->post('Payment_for') ? $this->post('Payment_for') : '',
                'period_date' => $this->post('period_date') ? $this->post('period_date') : '',
                'admin_percentage' => $this->post('admin_percentage') ? $this->post('admin_percentage') : '',
                'Prepared_by' => $this->post('Prepared_by') ? $this->post('Prepared_by') : '',
                'Prepared_by_desig' => $this->post('Prepared_by_desig') ? $this->post('Prepared_by_desig') : '',
                'Confirmed_by' => $this->post('Confirmed_by') ? $this->post('Confirmed_by') : '',
                'Confirmed_by_desig' => $this->post('Confirmed_by_desig') ? $this->post('Confirmed_by_desig') : '',
                'Checked_by' => $this->post('Checked_by') ? $this->post('Checked_by') : '',
                'Checked_by_desig' => $this->post('Checked_by_desig') ? $this->post('Checked_by_desig') : '',
                'Approved_by' => $this->post('Approved_by') ? $this->post('Approved_by') : '',
                'Approved_by_desig' => $this->post('Approved_by_desig') ? $this->post('Approved_by_desig') : '',
                'transmittal_no' => $this->post('transmittal_no') ? $this->post('transmittal_no') : '',
                'billing_statement' => $this->post('billing_statement') ? $this->post('billing_statement') : '',
                'date_transmitted' => $this->post('date_transmitted') ? $this->post('date_transmitted') : '',
                'Checked_by_t' => $this->post('Checked_by_t') ? $this->post('Checked_by_t') : '',
                'Checked_by_desig_t' => $this->post('Checked_by_desig_t') ? $this->post('Checked_by_desig_t') : '',
                'Received_by_t' => $this->post('Received_by_t') ? $this->post('Received_by_t') : '',
                'Received_by_desig_t' => $this->post('Received_by_desig_t') ? $this->post('Received_by_desig_t') : '',
                'Approved_by_t' => $this->post('Approved_by_t') ? $this->post('Approved_by_t') : '',
                'Approved_by_desig_t' => $this->post('Approved_by_desig_t') ? $this->post('Approved_by_desig_t') : '',
            ];
            $result = $this->oc_construction_model->save_header($data);
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
                'TOSDTL' => $this->post('TOSDTL') ? $this->post('TOSDTL') : 0,
                'hdr_id' => $this->post('hdr_id') ? $this->post('hdr_id') : 0,
                'activity_id' => $this->post('activity_id') ? $this->post('activity_id') : 0,
                'Activity' => $this->post('Activity') ? $this->post('Activity') : '',
                'Location' => $this->post('Location') ? $this->post('Location') : '',
                'GL' => $this->post('GL') ? $this->post('GL') : '',
                'CC' => $this->post('CC') ? $this->post('CC') : '',
                'MHRS' => $this->post('MHRS') ? $this->post('MHRS') : 0,
                'HC' => $this->post('HC') ? $this->post('HC') : 0,
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
                'rhol_st2x' => $this->post('rhol_st2x') ? $this->post('rhol_st2x') : '',
                'rhol_ot2x' => $this->post('rhol_ot2x') ? $this->post('rhol_ot2x') : '',
                'rhol_nd2x' => $this->post('rhol_nd2x') ? $this->post('rhol_nd2x') : '',
                'rhol_ndot2x' => $this->post('rhol_ndot2x') ? $this->post('rhol_ndot2x') : '',
                'rholrd_st2x' => $this->post('rholrd_st2x') ? $this->post('rholrd_st2x') : '',
                'rholrd_ot2x' => $this->post('rholrd_ot2x') ? $this->post('rholrd_ot2x') : '',
                'rholrd_nd2x' => $this->post('rholrd_nd2x') ? $this->post('rholrd_nd2x') : '',
                'rholrd_ndot2x' => $this->post('rholrd_ndot2x') ? $this->post('rholrd_ndot2x') : '',
                'total_st' => $this->post('total_st') ? $this->post('total_st') : '',
                'total_ot' => $this->post('total_ot') ? $this->post('total_ot') : '',
                'total_nd' => $this->post('total_nd') ? $this->post('total_nd') : '',
                'total_ndot' => $this->post('total_ndot') ? $this->post('total_ndot') : '',
                'total' => $this->post('total') ? $this->post('total') : '',
            ];
            $result = $this->oc_construction_model->save_detail($data);
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
            $result = $this->oc_construction_model->transmit_data($this->post('id'), $data);
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
                'client' => 'CONSTRUCTION',
                'Datetime_reactivation' => date('Y-m-d H:i:s'),
            );
            $result = $this->oc_construction_model->reactivate_data($data);
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
                'TOCSHDR' => $this->post('TOCSHDR') ? $this->post('TOCSHDR') : 0,
                'date_transmitted' => $this->post('date_transmitted') ? $this->post('date_transmitted') : '',
                'transmittal_no' => $this->post('transmittal_no') ? $this->post('transmittal_no') : '',
                'Confirmed_by' => $this->post('Confirmed_by') ? $this->post('Confirmed_by') : '',
                'Confirmed_by_desig' => $this->post('Confirmed_by_desig') ? $this->post('Confirmed_by_desig') : '',
            );
            $result = $this->oc_construction_model->save_print_preview($data);
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
        $result = $this->oc_construction_model->delete_header($this->query('id'));
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
        $result = $this->oc_construction_model->delete_detail($this->query('id'));
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