<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'third_party/vendor/autoload.php';

class Payment extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('payment_model');
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
        if($this->get('dar')){
            $result = $this->payment_model->get_dar_hdr($this->get('soaNumber'));
        }elseif($this->get('sar')){
            $result = $this->payment_model->get_sar_hdr($this->get('soaNumber'));
        }elseif($this->get('bcc')){
            $result = $this->payment_model->get_bcc_hdr($this->get('soaNumber'));
        }elseif($this->get('slers')){
            $result = $this->payment_model->get_slers_hdr($this->get('soaNumber'));
        }elseif($this->get('dearbc')){
            $result = $this->payment_model->get_dearbc_hdr($this->get('soaNumber'));
        }elseif($this->get('labnotin')){
            $result = $this->payment_model->get_labnotin_hdr($this->get('soaNumber'));
        }elseif($this->get('clubhouse')){
            $result = $this->payment_model->get_clubhouse_hdr($this->get('soaNumber'));
        }elseif($this->get('searchPayment')){
            $result = $this->payment_model->get_payment_hdr($this->get('field'), $this->get('payNo'));
        }elseif($this->get('details')){
            $result = $this->payment_model->get_payment_details($this->get('id'));
        }elseif($this->get('paymentSOA')){
            $result = $this->payment_model->get_soa_from_payment($this->get('id'), $this->get('client'));
        }elseif($this->get('uploadedDAR')){
            $result = $this->payment_model->get_uploaded();
        }elseif($this->get('report')){
            $records = array('records' => $this->payment_model->get_uploaded_report());
            if($this->get('excel')){
                $html = $this->load->view('Uploaded_DAR_Report', $records);
            }else{
                $html = $this->load->view('Uploaded_DAR_Report', $records, true);
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
        $this->returns($result);
    }
    public function index_post(){
        if($this->post('hdr')){
            $data = [
                'PHDRID' => $this->post('PHDRID') ? $this->post('PHDRID') : 0,
                'Client' => $this->post('Client') ? $this->post('Client') : '',
                'Date' => $this->post('Date'),
            ];
            $result = $this->payment_model->save_hdr($data);
            if(gettype($result) == "array"){
                $result = array(
                    'success' => true,
                    'id' => $result['id'],
                    'PayNo' => $result['PayNo'],
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                if($result){
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
        }elseif($this->post('erasePrevious')){
            $result = $this->payment_model->erase_prevoius_uploads();
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully erase'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Something went wrong'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('savePayment')){
            $result = $this->payment_model->save_soas($this->post('rows'), $this->post('client'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully paid'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Something went wrong'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('dtl')){
            $data = [
                'PDTLID' => $this->post('PDTLID') ? $this->post('PDTLID') : 0,
                'HDRID' => $this->post('HDRID') ? $this->post('HDRID') : '',
                'Mode' => $this->post('Mode') ? $this->post('Mode') : '',
                'PayDate' => $this->post('PayDate') ? $this->post('PayDate') : '',
                'ORNo' => $this->post('ORNo') ? $this->post('ORNo') : '',
                'CardNo' => $this->post('CardNo') ? $this->post('CardNo') : '',
                'BankName' => $this->post('BankName') ? $this->post('BankName') : '',
                'Amount' => $this->post('Amount') ? $this->post('Amount') : '',
                'Remarks' => $this->post('Remarks') ? $this->post('Remarks') : '',
            ];
            $result = $this->payment_model->save_dtl($data);
            if(gettype($result) == "array"){
                $result = array(
                    'success' => true,
                    'id' => $result['id'],
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                if($result){
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
        }elseif($this->post('deleteDtls')){
            $result = $this->payment_model->delete_dtl($this->post('id'), $this->post('client'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully deleted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Nothing to delete'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('uploadPayment')){
            $result = $this->payment_model->upload_payment_dar($this->post('list'));
            if($result){
                $result = array(
                    'success' => true
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('uploadingSave')){
            $data = [
                'PDTLID' => $this->post('PDTLID') ? $this->post('PDTLID') : 0,
                'HDRID' => $this->post('HDRID') ? $this->post('HDRID') : '',
                'Mode' => $this->post('Mode') ? $this->post('Mode') : '',
                'PayDate' => $this->post('PayDate') ? $this->post('PayDate') : '',
                'ORNo' => $this->post('ORNo') ? $this->post('ORNo') : '',
                'CardNo' => $this->post('CardNo') ? $this->post('CardNo') : '',
                'BankName' => $this->post('BankName') ? $this->post('BankName') : '',
                'Amount' => $this->post('Amount') ? $this->post('Amount') : '',
                'Remarks' => $this->post('Remarks') ? $this->post('Remarks') : '',
            ];
            $result = $this->payment_model->save_dtl_uploaded($data);
            if(gettype($result) == "array"){
                $result = array(
                    'success' => true,
                    'id' => $result['id'],
                    'rows' => $result['rows'],
                    'message' => 'Successfully inserted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                if($result){
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
        
    }

    public function index_delete(){
        $result = $this->payment_model->delete_data($this->query('id'));
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