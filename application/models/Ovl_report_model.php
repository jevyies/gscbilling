<?php

Class OVL_Report_Model extends CI_Model {
    public function get_standard_report($data){
        if($data['type'] == 1){
            $query = $this->db->select("*")->from('tblovlvehicleloghdr')->order_by('OVLVLDate', 'asc')->get();
        }else if($data['type'] == 2){
            $from = $data['from'];
            $to = $data['to'];
            $query = $this->db->select("*")->from('tblovlvehicleloghdr')->where("OVLVLDate BETWEEN '".$from."' AND '".$to."'")->order_by('OVLVLDate', 'asc')->get();
        }else{
            $ovlno = $data['ovlno'];
            $query = $this->db->select("*")->from('tblovlvehicleloghdr')->where("OVLNo = '".$ovlno."'")->order_by('OVLVLDate', 'asc')->get();
        }
        return $query->result() ? $query->result() : false;
    }
    public function get_payroll_report($data){
        $chapa = 'SELECT ChapaID_Old FROM 201filedb.tblemployeemasterfile b WHERE a.DriverIDLink = b.EmpID LIMIT 1';
        $query = $this->db
        ->select('*, ('.$chapa.') AS Chapa')
        ->from('tblovlvehicleloghdr a')
        ->where('DriverIDLink', $data['id'])
        ->where("OVLVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->order_by('OVLVLDate', 'asc')
        ->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_collection_report($data){
        if(!$data['id']){
            if($data['checkdate'] == ''){
                $query = $this->db
                ->select('*')
                ->from('tblovlvehicleloghdr')
                ->where("OVLVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
                ->order_by('OVLVLDate', 'asc')
                ->get();
            }else{
                $query = $this->db
                ->select('*')
                ->from('tblovlvehicleloghdr')
                ->where("CheckDate = '".$data['checkdate']."'")
                ->order_by('CheckDate', 'asc')
                ->get();
            }
        }else{
            $query = $this->db
            ->select('*')
            ->from('tblovlvehicleloghdr')
            ->where('OVLPlateNo', $data['id'])
            ->where("OVLVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->order_by('OVLVLDate', 'asc')
            ->get();
        }
        return $query->result() ? $query->result() : false;
    }
}