<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';


class Dmpi_Sar extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('dmpi_sar_model');
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
        if($this->get('search')){
            $result = $this->dmpi_sar_model->search_header($this->get('year'));
        }elseif($this->get('active')){
            $result = $this->dmpi_sar_model->get_active();
        }elseif($this->get('details')){
            $result = $this->dmpi_sar_model->get_details($this->get('id'));
        }elseif($this->get('getTDetails')){
            $result = $this->dmpi_sar_model->get_transmittal_details($this->get('id'));
        }elseif($this->get('location')){
            $result = $this->dmpi_sar_model->get_locations();
        }elseif($this->get('activity')){
            $result = $this->dmpi_sar_model->get_activities();
        }elseif($this->get('gl')){
            $result = $this->dmpi_sar_model->get_gl_sar();
        }elseif($this->get('searchTransmittal')){
            $result = $this->dmpi_sar_model->search_transmittal($this->get('transmittalNo'));
        }
        $this->returns($result);
    }

    public function index_post(){
        if($this->post('header')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'locationID' => $this->post('locationID') ? $this->post('locationID') : 0,
                'Location' => $this->post('Location') ? $this->post('Location') : '',
                'volumeType' => $this->post('volumeType') ? $this->post('volumeType') : '',
                'DateTransmitted' => $this->post('DateTransmitted') ? $this->post('DateTransmitted') : '',
                'periodCoveredFrom' => $this->post('periodCoveredFrom') ? $this->post('periodCoveredFrom') : '',
                'periodCoveredTo' => $this->post('periodCoveredTo') ? $this->post('periodCoveredTo') : '',
                'soaDate' => $this->post('soaDate') ? $this->post('soaDate') : '',
                'docDate' => $this->post('docDate') ? $this->post('docDate') : '',
                'soaNumber' => $this->post('soaNumber') ? $this->post('soaNumber') : '',
                'controlNo' => $this->post('controlNo') ? $this->post('controlNo') : '',
                'preparedBy' => $this->post('preparedBy') ? $this->post('preparedBy') : '',
                'preparedByPosition' => $this->post('preparedByPosition') ? $this->post('preparedByPosition') : '',
                'verifiedBy' => $this->post('verifiedBy') ? $this->post('verifiedBy') : '',
                'verifiedByPosition' => $this->post('verifiedByPosition') ? $this->post('verifiedByPosition') : '',
                'notedBy' => $this->post('notedBy') ? $this->post('notedBy') : '',
                'notedByPosition' => $this->post('notedByPosition') ? $this->post('notedByPosition') : '',
                'approvedBy1' => $this->post('approvedBy1') ? $this->post('approvedBy1') : '',
                'approvedByPosition1' => $this->post('approvedByPosition1') ? $this->post('approvedByPosition1') : '',
                'approvedBy2' => $this->post('approvedBy2') ? $this->post('approvedBy2') : '',
                'approvedByPosition2' => $this->post('approvedByPosition2') ? $this->post('approvedByPosition2') : '',
                'approvedBy3' => $this->post('approvedBy3') ? $this->post('approvedBy3') : '',
                'approvedByPosition3' => $this->post('approvedByPosition3') ? $this->post('approvedByPosition3') : '',
                'status' => $this->post('status') ? $this->post('status') : 'active',
                'cutoff_month' => $this->post('cutoff_month') ? $this->post('cutoff_month') : 0,
                'cutoff_year' => $this->post('cutoff_year') ? $this->post('cutoff_year') : 0,
            ];
            $result = $this->dmpi_sar_model->save_header($data);
            if(gettype($result) ===  "array"){
                if($result['exist']){
                    $result = array(
                        'success' => false,
                        'message' => 'This Control No. already exists'
                    );
                    $this->response($result, REST_Controller::HTTP_OK);
                }else{
                    $result = array(
                        'success' => true,
                        'id' => $result['id'],
                        'message' => 'Successfully inserted'
                    );
                    $this->response($result, REST_Controller::HTTP_OK);
                }
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
                        'message' => 'Nothing changed. Saving failed'
                    );
                    $this->response($result, REST_Controller::HTTP_OK);
                }
            }
        }elseif($this->post('details')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'hdr_id' => $this->post('hdr_id') ? $this->post('hdr_id') : 0,
                'datePerformed' => $this->post('datePerformed') ? $this->post('datePerformed') : '',
                'serviceNumber' => $this->post('serviceNumber') ? $this->post('serviceNumber') : '',
                'activityID' => $this->post('activityID') ? $this->post('activityID') : '',
                'activity' => $this->post('activity') ? $this->post('activity') : '',
                'gl' => $this->post('gl') ? $this->post('gl') : '',
                'rate_id' => $this->post('rate_id') ? $this->post('rate_id') : '',
                'poNumber' => $this->post('poNumber') ? $this->post('poNumber') : '',
                'poID' => $this->post('poID') ? $this->post('poID') : '',
                'glID' => $this->post('glID') ? $this->post('glID') : '',
                'costCenter' => $this->post('costCenter') ? $this->post('costCenter') : '',
                'qty' => $this->post('qty') ? $this->post('qty') : '',
                'unit' => $this->post('unit') ? $this->post('unit') : '',
                'rate' => $this->post('rate') ? $this->post('rate') : '',
                'amount' => $this->post('amount') ? $this->post('amount') : '',
                'entrySheetNumber' => $this->post('entrySheetNumber') ? $this->post('entrySheetNumber') : '',
                'batchID' => $this->post('batchID') ? $this->post('batchID') : '',
                'batchNo' => $this->post('batchNo') ? $this->post('batchNo') : '',
                'pmy' => $this->post('pmy') ? $this->post('pmy') : '',
                'batchDaytype' => $this->post('batchDaytype') ? $this->post('batchDaytype') : '',
                'period' => $this->post('period') ? $this->post('period') : '',
                'batchDaytypeID' => $this->post('batchDaytypeID') ? $this->post('batchDaytypeID') : '',
            ];
            $result = $this->dmpi_sar_model->save_details($data);
            if(gettype($result) ===  "array"){
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
                        'message' => 'Failed'
                    );
                    $this->response($result, REST_Controller::HTTP_OK);
                }
            }
        }elseif($this->post('updateStatus')){
            $result = $this->dmpi_sar_model->update_status($this->post('status'), $this->post('id'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully update status to '.$this->post('status')
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('deleteDetails')){
            $result = $this->dmpi_sar_model->delete_details($this->post('id'));
            if($result){
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
        }elseif($this->post('deleteTransmittal')){
            $result = $this->dmpi_sar_model->delete_transmittal($this->post('id'));
            if($result){
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
        }elseif($this->post('reactivate')){
            $data = [
                'id' => $this->post('id'),
                'reasonofreactivation' => $this->post('reasonofreactivation') ? $this->post('reasonofreactivation') : '',
            ];
            $result = $this->dmpi_sar_model->reactivate_sar($data);
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully reactivated'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Something went wrong'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('transmittalHeader')){
            $data = [
                'id' => $this->post('id')  ? $this->post('id') : 0,
                'date' => $this->post('date') ? $this->post('date') : '',
                'TransmittalNo' => $this->post('TransmittalNo') ? $this->post('TransmittalNo') : '',
                'period' => $this->post('period') ? $this->post('period') : '',
                'store' => $this->post('store') ? $this->post('store') : '',
                'type' => $this->post('type') ? $this->post('type') : '',
                'billing_statement' => $this->post('billing_statement') ? $this->post('billing_statement') : '',
                'PreparedBy' => $this->post('PreparedBy') ? $this->post('PreparedBy') : '',
                'PreparedByPos' => $this->post('PreparedByPos') ? $this->post('PreparedByPos') : '',
                'CheckedBy' => $this->post('CheckedBy') ? $this->post('CheckedBy') : '',
                'CheckedByPos' => $this->post('CheckedByPos') ? $this->post('CheckedByPos') : '',
                'ApprovedBy' => $this->post('ApprovedBy') ? $this->post('ApprovedBy') : '',
                'ApprovedByPos' => $this->post('ApprovedByPos') ? $this->post('ApprovedByPos') : '',
            ];
            $result = $this->dmpi_sar_model->save_transmittal($data);
            if(gettype($result) ===  "array"){
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
                        'message' => 'Something went wrong'
                    );
                    $this->response($result, REST_Controller::HTTP_OK);
                }
            }
        }elseif($this->post('updateTransmittal')){
            $result = $this->dmpi_sar_model->update_transmittal($this->post('id'), $this->post('TID'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully added'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Something went wrong'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }
    }
    public function index_delete(){
        $result = $this->dmpi_sar_model->delete_data($this->query('id'));
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