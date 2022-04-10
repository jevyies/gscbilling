<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';


class Dmpi_Dar extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load session library
        // $this->load->library('session');

        // Load database
        $this->load->model('dmpi_dar_model');
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
            $result = $this->dmpi_dar_model->search_header($this->get('soaNumber'), $this->get('pmy'), $this->get('period'));
        }elseif($this->get('searchByBatch')){
            $result = $this->dmpi_dar_model->search_header_batch($this->get('BatNo'), $this->get('pmy'), $this->get('period'));
        }elseif($this->get('transmittalExist')){
            $result = $this->dmpi_dar_model->get_transmittal_exist($this->get('transmittal'));
        }elseif($this->get('active')){
            $result = $this->dmpi_dar_model->get_active();
        }elseif($this->get('batch')){
            $result = $this->dmpi_dar_model->get_batch($this->get('phase'), $this->get('period'));
        }elseif($this->get('bInfoBNo')){
            $data = array(
                'BNo' => $this->get('batchNo'),
                'Phase' => $this->get('Phase'),
                'Period' => $this->get('Period'),
            );
            $result = $this->dmpi_dar_model->get_batch_info_BNO($data);
        }elseif($this->get('bInfoSNo')){
            $data = array(
                'soaNumber' => $this->get('soaNumber'),
                'Phase' => $this->get('Phase'),
                'Period' => $this->get('Period'),
            );
            $result = $this->dmpi_dar_model->get_batch_info_SNO($data);
        }elseif($this->get('checkSoa')){
            $data = [
                'id' => $this->get('id') ? $this->get('id') : 0,
                'soaNumber' => $this->get('soaNumber') ? $this->get('soaNumber') : '',
            ];
            $result = $this->dmpi_dar_model->check_soa_no($data);
        }elseif($this->get('checkBatch')){
            $data = [
                'id' => $this->get('id') ? $this->get('id') : 0,
                'batches' => $this->get('batches') ? $this->get('batches') : [],
            ];
            $result = $this->dmpi_dar_model->check_batch_no($data);
        }elseif($this->get('details')){
            $result = $this->dmpi_dar_model->get_details($this->get('id'));
        }elseif($this->get('detailsSupervisor')){
            $result = $this->dmpi_dar_model->get_details_supervisor($this->get('id'));
        }elseif($this->get('detailsIncentive')){
            $result = $this->dmpi_dar_model->get_details_incentives($this->get('id'));
        }elseif($this->get('rates')){
            $result = $this->dmpi_dar_model->get_rates($this->get('id'));
        }elseif($this->get('warnings')){
            $result = $this->dmpi_dar_model->get_warnings($this->get('id'));
        }elseif($this->get('autoNo')){
            $result = $this->dmpi_dar_model->get_transmittals($this->get('id'));
        }elseif($this->get('logs')){
            $result = $this->dmpi_dar_model->get_dar_logs($this->get('id'));
        }
        $this->returns($result);
    }

    public function index_post(){
        if($this->post('rate')){
            $row = $this->post('row');
            $location = $this->post('location');
            $result = $this->dmpi_dar_model->check_rate($row, $location);
            if($result){
                $result = array(
                    'success' => true,
                    'row' => $result,
                    'message' => 'Success'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('header')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'pmy' => $this->post('pmy') ? $this->post('pmy') : '',
                'period' => $this->post('period') ? $this->post('period') : '',
                'soaNumber' => $this->post('soaNumber') ? $this->post('soaNumber') : '',
                'soaDate' => $this->post('soaDate') ? $this->post('soaDate') : '',
                'gtSt' => $this->post('gtSt') ? $this->post('gtSt') : 0,
                'gtOt' => $this->post('gtOt') ? $this->post('gtOt') : 0,
                'gtNd' => $this->post('gtNd') ? $this->post('gtNd') : 0,
                'gtNdot' => $this->post('gtNdot') ? $this->post('gtNdot') : 0,
                'preparedBy' => $this->post('preparedBy') ? $this->post('preparedBy') : '',
                'preparedByPosition' => $this->post('preparedByPosition') ? $this->post('preparedByPosition') : '',
                'confirmedBy' => $this->post('confirmedBy') ? $this->post('confirmedBy') : '',
                'confirmedByPosition' => $this->post('confirmedByPosition') ? $this->post('confirmedByPosition') : '',
                'approvedBy' => $this->post('approvedBy') ? $this->post('approvedBy') : '',
                'approvedByPosition' => $this->post('approvedByPosition') ? $this->post('approvedByPosition') : '',
                'approvedBy2' => $this->post('approvedBy2') ? $this->post('approvedBy2') : '',
                'approvedByPosition2' => $this->post('approvedByPosition2') ? $this->post('approvedByPosition2') : '',
                'status' => $this->post('status') ? $this->post('status') : 'active',
                'isClubhouse' => $this->post('isClubhouse') ? $this->post('isClubhouse') : 0,
                'TransmittedDate' => $this->post('TransmittedDate') ? $this->post('TransmittedDate') : '',
                'SupervisorDate' => $this->post('SupervisorDate') ? $this->post('SupervisorDate') : '',
                'ManagerDate' => $this->post('ManagerDate') ? $this->post('ManagerDate') : '',
                'DataControllerDate' => $this->post('DataControllerDate') ? $this->post('DataControllerDate') : '',
                'BillingClerkDate' => $this->post('BillingClerkDate') ? $this->post('BillingClerkDate') : '',
                'DMPIReceivedDate' => $this->post('DMPIReceivedDate') ? $this->post('DMPIReceivedDate') : '',
                'TransmittalNo' => $this->post('TransmittalNo') ? $this->post('TransmittalNo') : '',
                'detailType' => $this->post('detailType') ? $this->post('detailType') : '',
                'nonBatch' => $this->post('nonBatch') ? $this->post('nonBatch') : 0,
                'location' => $this->post('location') ? $this->post('location') : '',
                'locationID' => $this->post('locationID') ? $this->post('locationID') : 0,
                'cutoff_month' => $this->post('cutoff_month') ? $this->post('cutoff_month') : 0,
                'cutoff_year' => $this->post('cutoff_year') ? $this->post('cutoff_year') : 0,
            ];
            $result = $this->dmpi_dar_model->save_header($data);
            if(gettype($result) ===  "array"){
                if($result['error']){
                    $result = array(
                        'error' => true,
                        'message' => 'SOA Number Already Exist'
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
                        'message' => 'Failed'
                    );
                    $this->response($result, REST_Controller::HTTP_OK);
                }
            }
        }elseif($this->post('accounting')){
            $result = $this->dmpi_dar_model->update_payment_acc($this->post('amount'), $this->post('id'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully saved'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('batches')){
            $result = $this->dmpi_dar_model->save_batches($this->post('id'), $this->post('rows'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully saved'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('details')){
            $result = $this->dmpi_dar_model->save_details($this->post('id'), $this->post('rows'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully saved'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('detailsSupervisor')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'hdr_id' => $this->post('hdr_id') ? $this->post('hdr_id') : '',
                'Name' => $this->post('Name') ? $this->post('Name') : '',
                'Chapa' => $this->post('Chapa') ? $this->post('Chapa') : '',
                'activity' => $this->post('activity') ? $this->post('activity') : '',
                'gl' => $this->post('gl') ? $this->post('gl') : '',
                'cc' => $this->post('cc') ? $this->post('cc') : '',
                'detailType' => $this->post('detailType') ? $this->post('detailType') : '',
                'leaveNoPayHrs' => $this->post('leaveNoPayHrs') ? $this->post('leaveNoPayHrs') : 0,
                'rdst' => $this->post('rdst') ? $this->post('rdst') : 0,
                'rdnd' => $this->post('rdnd') ? $this->post('rdnd') : 0,
                'rdot' => $this->post('rdot') ? $this->post('rdot') : 0,
                'rdndot' => $this->post('rdndot') ? $this->post('rdndot') : 0,
                'totalst' => $this->post('c_totalst') ? $this->post('c_totalst') : 0,
                'c_totalst' => $this->post('c_totalst') ? $this->post('c_totalst') : 0,
                'totalnd' => $this->post('c_totalnd') ? $this->post('c_totalnd') : 0,
                'c_totalnd' => $this->post('c_totalnd') ? $this->post('c_totalnd') : 0,
                'TotalLeave' => $this->post('TotalLeave') ? $this->post('TotalLeave') : 0,
                'headCount' => 1,
                'totalAmt' => $this->post('c_totalAmt') ? $this->post('c_totalAmt') : 0,
                'c_totalAmt' => $this->post('c_totalAmt') ? $this->post('c_totalAmt') : 0,
            ];
            $result = $this->dmpi_dar_model->save_details_supervisor($data);
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
        }elseif($this->post('detailsIncentive')){
            $data = [
                'id' => $this->post('id') ? $this->post('id') : 0,
                'hdr_id' => $this->post('hdr_id') ? $this->post('hdr_id') : '',
                'activity' => $this->post('activity') ? $this->post('activity') : '',
                'gl' => $this->post('gl') ? $this->post('gl') : '',
                'cc' => $this->post('cc') ? $this->post('cc') : '',
                'detailType' => $this->post('detailType') ? $this->post('detailType') : '',
                'headCount' => 1,
                'totalAmt' => $this->post('c_totalAmt') ? $this->post('c_totalAmt') : 0,
                'c_totalAmt' => $this->post('c_totalAmt') ? $this->post('c_totalAmt') : 0,
            ];
            $result = $this->dmpi_dar_model->save_details_incentive($data);
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
        }elseif($this->post('rates')){
            $result = $this->dmpi_dar_model->save_rates($this->post('id'), $this->post('rows'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully saved'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('warnings')){
            $result = $this->dmpi_dar_model->save_warnings($this->post('id'), $this->post('rows'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully saved'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Failed'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('updateStatus')){
            if($this->post('status') === 'confirmed'){
                $sess = $this->session->userdata('gscbilling_session');
                if((int)$this->post('uploadedBy') == (int)$sess['id']){
                    $result = array(
                        'success' => false,
                        'message' => 'Exist'
                    );
                    return $this->response($result, REST_Controller::HTTP_OK);
                }
            }
            $data = array();
            if($this->post('updateHeader')){
                $data = array(
                    'soaNumber' => $this->post('soaNumber'),
                    'soaDate' => $this->post('soaDate'),
                    'TransmittedDate' => $this->post('TransmittedDate'),
                    'SupervisorDate' => $this->post('SupervisorDate'),
                    'ManagerDate' => $this->post('ManagerDate'),
                    'DataControllerDate' => $this->post('DataControllerDate'),
                    'BillingClerkDate' => $this->post('BillingClerkDate'),
                    'DMPIReceivedDate' => $this->post('DMPIReceivedDate'),
                    'TransmittalNo' => $this->post('TransmittalNo'),
                );
            }
            $result = $this->dmpi_dar_model->update_status($this->post('status'), $this->post('id'), $data);
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
        }elseif($this->post('reactivate')){
            $data = [
                'id' => $this->post('id'),
                'reasonofreactivation' => $this->post('reasonofreactivation') ? $this->post('reasonofreactivation') : '',
            ];
            $result = $this->dmpi_dar_model->reactivate_dar($data);
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
        }elseif($this->post('saveRemarks')){
            $data = [
                'id' => $this->post('id'),
                'Remarks' => $this->post('Remarks') ? $this->post('Remarks') : '',
            ];
            $result = $this->dmpi_dar_model->save_remarks($data);
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Remarks Successfully Saved'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Something went wrong'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('clearBatch')){
            $result = $this->dmpi_dar_model->clear_batch($this->post('id'), $this->post('soaNumber'));
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Successfully deleted'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }else{
                $result = array(
                    'success' => false,
                    'message' => 'Something went wrong'
                );
                $this->response($result, REST_Controller::HTTP_OK);
            }
        }elseif($this->post('saveRemarks2')){
            $data = [
                'id' => $this->post('id'),
                'Remarks2' => $this->post('Remarks2') ? $this->post('Remarks2') : '',
            ];
            $result = $this->dmpi_dar_model->save_remarks($data);
            if($result){
                $result = array(
                    'success' => true,
                    'message' => 'Remarks Successfully Saved'
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
        $result = $this->dmpi_dar_model->delete_data($this->query('id'));
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

    public function supervisor_delete(){
        $result = $this->dmpi_dar_model->delete_supervisor($this->query('id'));
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

    public function incentive_delete(){
        $result = $this->dmpi_dar_model->delete_incentive($this->query('id'));
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