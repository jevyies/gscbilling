<?php

Class PHB_Report_Model extends CI_Model {
    public function get_standard_report($data){
        if($data['type'] == 1){
            $query = $this->db->select("*")->from('tblphbvehicleloghdr')->order_by('PHBVLDate', 'asc')->get();
        }else if($data['type'] == 2){
            $from = $data['from'];
            $to = $data['to'];
            $query = $this->db->select("*")->from('tblphbvehicleloghdr')->where("PHBVLDate BETWEEN '".$from."' AND '".$to."'")->order_by('PHBVLDate', 'asc')->get();
        }else if($data['type'] == 3){
            $ovlno = $data['ovlno'];
            $query = $this->db->select("*")->from('tblphbvehicleloghdr')->where("OVLNo = '".$ovlno."'")->order_by('PHBVLDate', 'asc')->get();
        }else{
            $from = $data['from'];
            $to = $data['to'];
            $id = $data['id'];
            $query = $this->db->select("*")->from('tblphbvehicleloghdr')->where('PHBIDLink', $id)->where("PHBVLDate BETWEEN '".$from."' AND '".$to."'")->order_by('PHBVLDate', 'asc')->get();
        }
        return $query->result() ? $query->result() : false;
    }
    public function get_payroll_report($data){
        $query = $this->db
        ->select('*')
        ->from('tblphbvehicleloghdr')
        ->where('DriverIDLink', $data['id'])
        ->where("PHBVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->order_by('PHBVLDate', 'asc')
        ->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_extra_odo_report($data){
        $query = $this->db
        ->select('*')
        ->from('tblphbvehicleloghdr')
        ->where('DriverIDLink', $data['id'])
        ->where("CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->where('ExtraRun > 0')
        ->order_by('PHBVLDate', 'asc')
        ->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_collection_report($data){
        if(!$data['id']){
            $query = $this->db
            ->select('*')
            ->from('tblphbvehicleloghdr')
            ->where("PHBVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->order_by('PHBVLDate', 'asc')
            ->get();
        }else{
            $query = $this->db
            ->select('*')
            ->from('tblphbvehicleloghdr')
            ->where('PHBPlateNo', $data['id'])
            ->where("PHBVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->order_by('PHBVLDate', 'asc')
            ->get();
        }
        return $query->result() ? $query->result() : false;
    }
}