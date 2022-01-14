<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
class B_History extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set("memory_limit", "-1");
        // Load session library
        // $this->load->library('session');
        $this->load->model('b_history_model');
    }

    public function index_get()
    {
        if($this->get('allHistory')){
            $records = array('records' => $this->b_history_model->get_all_history($this->get('type')), 'filename' => $this->get('type') . "_ALL");
            $html = $this->load->view('B_History', $records);
        }elseif($this->get('getItemHistory')){
            $records = array('records' => $this->b_history_model->get_item_history($this->get('type'), $this->get('ExpenseListID_Link')), 'filename' => $this->get('item'));
            $html = $this->load->view('B_History', $records);
        }elseif($this->get('getVehicleItem')){
            $records = array('records' => $this->b_history_model->get_vehicle_history($this->get('PlateNo')), 'filename' => $this->get('PlateNo'));
            $html = $this->load->view('B_History2', $records);
        }elseif($this->get('getProjectItem')){
            $records = array('records' => $this->b_history_model->get_project_history($this->get('ProjectName')), 'filename' => $this->get('ProjectName'));
            $html = $this->load->view('B_History2', $records);
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