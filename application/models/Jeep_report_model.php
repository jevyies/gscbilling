<?php

Class Jeep_Report_Model extends CI_Model {
    public function get_standard_report($data){
        if($data['type'] == 1){
            if($data['vID'] == ''){
                $query = $this->db->select("*")->from('tbljeepvehicleloghdr')->order_by('JVLDate', 'asc')->get();
            }else{
                $query = $this->db->select("*")->from('tbljeepvehicleloghdr')->where('JeepIDLink', $data['vID'])->order_by('JVLDate', 'asc')->get();
            }
        }else if($data['type'] == 2){
            $from = $data['from'];
            $to = $data['to'];
            if($data['vID'] == ''){
                $query = $this->db->select("*")->from('tbljeepvehicleloghdr')->where("JVLDate BETWEEN '".$from."' AND '".$to."'")->order_by('JVLDate', 'asc')->get();
            }else{
                $query = $this->db->select("*")->from('tbljeepvehicleloghdr')->where("JVLDate BETWEEN '".$from."' AND '".$to."'")->order_by('JVLDate', 'asc')->where('JeepIDLink', $data['vID'])->get();
            }
        }else if($data['type'] == 3){
            $ovlno = $data['ovlno'];
            $query = $this->db->select("*")->from('tbljeepvehicleloghdr')->where("OVLNo = '".$ovlno."'")->order_by('JVLDate', 'asc')->get();
        }else{
            $from = $data['from'];
            $to = $data['to'];
            if($data['vID'] == ''){
                $query = $this->db->select("*")->from('tbljeepvehicleloghdr')->where("CheckDate BETWEEN '".$from."' AND '".$to."'")->order_by('JVLDate', 'asc')->get();
            }else{
                $query = $this->db->select("*")->from('tbljeepvehicleloghdr')->where("CheckDate BETWEEN '".$from."' AND '".$to."'")->order_by('JVLDate', 'asc')->where('JeepIDLink', $data['vID'])->get();
            }
        }
        return $query->result() ? $query->result() : false;
    }

    public function get_billing_report($data){
        if($data['type'] == 1){
            $query = $this->db
            ->select("TruckerName, JeepPlateNo, SUM(BillAmount) AS TotalBilled, SUM(LessAdmin) AS TotalAdmin, SUM(CWT) AS TotalCWT, SUM(LessFuel) AS TotalFuel, SUM(CollectedAmount) AS TotalCollection")
            ->from('tbljeepvehicleloghdr')
            ->where("JVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->group_by('TruckerIDLink')
            ->group_by('JeepIDLink')
            ->order_by('JVLDate', 'asc')
            ->get();
        }else if($data['type'] == 2){
            $query = $this->db
            ->select("TruckerName, JeepPlateNo, SUM(BillAmount) AS TotalBilled, SUM(LessAdmin) AS TotalAdmin, SUM(CWT) AS TotalCWT, SUM(LessFuel) AS TotalFuel, SUM(CollectedAmount) AS TotalCollection")
            ->from('tbljeepvehicleloghdr')
            ->where("CheckDate <> '0000-00-00'")
            ->where("JVLDate <= '".$data['asof']."'")
            ->group_by('TruckerIDLink')
            ->group_by('JeepIDLink')
            ->order_by('JVLDate', 'asc')
            ->get();
        }else{
            $query = $this->db
            ->select("TruckerName, JeepPlateNo, SUM(BillAmount) AS TotalBilled, SUM(LessAdmin) AS TotalAdmin, SUM(CWT) AS TotalCWT, SUM(LessFuel) AS TotalFuel, SUM(CollectedAmount) AS TotalCollection")
            ->from('tbljeepvehicleloghdr')
            ->where("CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->group_by('TruckerIDLink')
            ->group_by('JeepIDLink')
            ->order_by('JVLDate', 'asc')
            ->get();
        }
        return $query->result() ? $query->result() : false;
    }

    public function get_operator_report($data){
        if($data['type'] == 1){
            $query = $this->db
            ->select("*")
            ->from('tbljeepvehicleloghdr')
            ->where("JVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->where('TruckerIDLink', $data['id'])
            ->order_by('JVLDate', 'asc')
            ->get();
            return $query->result() ? $query->result() : false;
        }else if($data['type'] == 2){
            $query = $this->db
            ->select("*")
            ->from('tbljeepvehicleloghdr')
            ->where("CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->where('TruckerIDLink', $data['id'])
            ->where('JeepIDLink', $data['vehicleID'])
            ->order_by('JVLDate', 'asc')
            ->get();
            return $query->result() ? $query->result() : false;
        }else{
            $query = $this->db
            ->select("*")
            ->from('tbljeepvehicleloghdr')
            ->where("CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->where('TruckerIDLink', $data['id'])
            ->order_by('JVLDate', 'asc')
            ->get();
            return $query->result() ? $query->result() : false;
        }
    }

    public function get_wt_report($data){
        $result_array = [];
        $checks = $this->db
        ->select('CheckDate')
        ->from('tbljeepvehicleloghdr')
        ->where("CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->group_by('CheckDate')
        ->order_by('JVLDate', 'asc')
        ->get()
        ->result();
        foreach($checks as $check){
            $result = [];
            $result['CheckDate'] = $check->CheckDate;
            $array_details = [];
            $query = $this->db
            ->select('SUM(CollectedAmount) AS TotalCollected, SUM(LessAdmin) As TotalAdmin, TruckerName, JeepPlateNo')
            ->from('tbljeepvehicleloghdr')
            ->where('CheckDate', $check->CheckDate)
            ->group_by('TruckerIDLink')
            ->group_by('JeepIDLink')
            ->order_by('TruckerName', 'asc')
            ->get();
            foreach($query->result() as $record){
                array_push($array_details, $record);
            }
            $result['details'] = $array_details;
            array_push($result_array, $result);
        }
        return $result_array;
    }

    public function get_operator_summary_report($data){
        $fuel_adj = "SELECT SUM(b.amount) FROM tbljeepfueladjustment b WHERE a.TruckerIDLink = b.operatorID AND a.JeepIDLink = b.JeepIDLink";
        $other_adj = "SELECT SUM(b.amount) FROM tbljeepotheradjustment b WHERE a.TruckerIDLink = b.operatorID AND a.JeepIDLink = b.JeepIDLink";
        if($data['type'] == 1){
            $query = $this->db
            ->select('SUM(CWT) AS TotalCWT, SUM(CollectedAmount) AS TotalCollected, SUM(LessAdmin) As TotalAdmin,SUM(LessFuel) As TotalFuel, TruckerName, JeepPlateNo, ('.$fuel_adj.') AS FuelAdj, ('.$other_adj.') AS OtherAdj')
            ->from('tbljeepvehicleloghdr a')
            ->where("JVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->group_by('TruckerIDLink')
            ->group_by('JeepIDLink')
            ->order_by('TruckerName', 'asc')
            ->get();
        }else if($data['type'] == 2){
            $query = $this->db
            ->select('SUM(CWT) AS TotalCWT, SUM(CollectedAmount) AS TotalCollected, SUM(LessAdmin) As TotalAdmin,SUM(LessFuel) As TotalFuel, TruckerName, JeepPlateNo, ('.$fuel_adj.') AS FuelAdj, ('.$other_adj.') AS OtherAdj')
            ->from('tbljeepvehicleloghdr a')
            ->where("CheckDate <> '0000-00-00'")
            ->where("CheckDate <= '".$data['asof']."'")
            ->group_by('TruckerIDLink')
            ->group_by('JeepIDLink')
            ->order_by('TruckerName', 'asc')
            ->get();
        }else{
            $query = $this->db
            ->select('SUM(CWT) AS TotalCWT, SUM(CollectedAmount) AS TotalCollected, SUM(LessAdmin) As TotalAdmin,SUM(LessFuel) As TotalFuel, TruckerName, JeepPlateNo, ('.$fuel_adj.') AS FuelAdj, ('.$other_adj.') AS OtherAdj')
            ->from('tbljeepvehicleloghdr a')
            ->where("CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->group_by('TruckerIDLink')
            ->group_by('JeepIDLink')
            ->order_by('TruckerName', 'asc')
            ->get();
        }
        return $query->result() ? $query->result() : false;
    }

    public function get_operator_summary_check_date($data){
        $fuel_adj = "SELECT SUM(b.amount) FROM tbljeepfueladjustment b WHERE a.TruckerIDLink = b.operatorID AND a.JeepIDLink = b.JeepIDLink";
        $other_adj = "SELECT SUM(b.amount) FROM tbljeepotheradjustment b WHERE a.TruckerIDLink = b.operatorID AND a.JeepIDLink = b.JeepIDLink";
        $result = array();

        $checks = $this->db
        ->select('COUNT(*) AS count, CheckDate')
        ->from('tbljeepvehicleloghdr')
        ->where("CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->group_by('CheckDate')
        ->get()->result();

        $query = $this->db
        ->select('TruckerIDLink, JeepIDLink, SUM(CWT) AS TotalCWT, SUM(LessAdmin) As TotalAdmin,SUM(LessFuel) As TotalFuel, TruckerName, JeepPlateNo, ('.$fuel_adj.') AS FuelAdj, ('.$other_adj.') AS OtherAdj')
        ->from('tbljeepvehicleloghdr a')
        ->where("CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->group_by('TruckerIDLink')
        ->group_by('JeepIDLink')
        ->order_by('TruckerName', 'asc')
        ->get()->result();
        foreach(@$query as $rec){
            $result[] = [
                'TotalCWT' => $rec->TotalCWT,
                'TotalAdmin' => $rec->TotalAdmin,
                'TotalFuel' => $rec->TotalFuel,
                'TruckerName' => $rec->TruckerName,
                'JeepPlateNo' => $rec->JeepPlateNo,
                'FuelAdj' => $rec->FuelAdj,
                'OtherAdj' => $rec->OtherAdj,
                'check1' => $checks[0]->CheckDate,
                'check2' => $checks[1]->CheckDate,
                'collection1' => $this->getCollection($checks[0]->CheckDate, $rec->TruckerIDLink, $rec->JeepIDLink),
                'collection2' => $this->getCollection($checks[1]->CheckDate, $rec->TruckerIDLink, $rec->JeepIDLink),
            ];
        }
        return $result;
    }
    private function getCollection($check_date, $trucker, $jeep){
        $collection = $this->db
        ->select('SUM(CollectedAmount) AS TotalCollected')
        ->from('tbljeepvehicleloghdr')
        ->where("CheckDate", $check_date)
        ->where("TruckerIDLink", $trucker)
        ->where("JeepIDLink", $jeep)
        ->group_by('CheckDate')
        ->get()->result();
        return $collection ? $collection[0]->TotalCollected : 0;
    }
    public function get_logs($data){
        $query = $this->db
        ->select('*')
        ->from('tbljeepfueladjustment')
        ->where("check_date BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->where('operatorID', $data['id'])
        ->get()
        ->result();
        return $query ? $query : [];
    }
}