<?php

Class Trucking_Adjustment_Model extends CI_Model {

    public function get_adjustment_report($data){
        $result_array = [];
        $Collection = 
        "CASE 
            WHEN a.MVTypeName = 'PHB' THEN (SELECT SUM(b.CollectedAmount) FROM tblphbvehicleloghdr b WHERE b.CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."' AND a.MVID = b.PHBIDLink) 
            WHEN a.MVTypeName = 'OVL' THEN (SELECT SUM(b.CollectedAmount) FROM tblovlvehicleloghdr b WHERE b.CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."' AND a.MVID = b.OVLIDLink)
            WHEN a.MVTypeName = 'LIFT TRUCK' THEN (SELECT SUM(b.amount) FROM liftruck_payment b, liftruck_rental c WHERE b.payment_date BETWEEN '".$data['from']."' AND '".$data['to']."' AND a.MVID = c.vehicle_id AND c.soaid_link = b.soa_link)
            WHEN a.MVTypeName = 'WINGVAN' THEN (SELECT SUM(b.amount) FROM wingvan_payment b, wingvan_requisition c WHERE b.payment_date BETWEEN '".$data['from']."' AND '".$data['to']."' AND a.MVID = c.vehicle_id AND c.soaid_link = b.soa_link)
            WHEN a.MVTypeName = 'VAN RENTAL' THEN (SELECT SUM(b.amount) FROM vanrental_collection b WHERE b.payment_date BETWEEN '".$data['from']."' AND '".$data['to']."' AND a.MVID = b.vehicle_id)
        END";
        if($data['id'] === ""){
            $query = $this->db->select("a.PlateNumber, ".$Collection." AS Collection, a.MVID, a.MVTypeName")->from("tblmotorvehiclelist a")->where("a.MVTypeName NOT IN('GOLFCART', 'JEEP')")->get();
        }else{
            $query = $this->db->select("a.PlateNumber, ".$Collection." AS Collection, a.MVID, a.MVTypeName")->from("tblmotorvehiclelist a")->where("a.MVID", $data['id'])->get();
        }
        if($query->result()){
            foreach($query->result() as $record){
                $array = [
                    'Unit' => $record->PlateNumber,
                    'Collection' => $record->Collection,
                    'January' => 0,
                    'February' => 0,
                    'March' => 0,
                    'April' => 0,
                    'May' => 0,
                    'June' => 0,
                    'July' => 0,
                    'August' => 0,
                    'September' => 0,
                    'October' => 0,
                    'November' => 0,
                    'December' => 0,
                    'Total' => 0,
                ];
                $dtls = $this->db
                ->select('amount, MONTH(adjustment_date) AS adjmonth')
                ->from('tbltruckingadjustment')
                ->where("adjustment_date BETWEEN '".$data['from']."' AND '".$data['to']."'")
                ->where('vehicle_id', $record->MVID)
                ->get();
                if($dtls->result()){
                    foreach($dtls->result() as $dtl){
                        if($dtl->adjmonth === '1'){
                            $array['January'] = $array['January'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '2'){
                            $array['February'] = $array['February'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '3'){
                            $array['March'] = $array['March'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '4'){
                            $array['April'] = $array['April'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '5'){
                            $array['May'] = $array['May'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '6'){
                            $array['June'] = $array['June'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '7'){
                            $array['July'] = $array['July'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '8'){
                            $array['August'] = $array['August'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '9'){
                            $array['September'] = $array['September'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '10'){
                            $array['October'] = $array['October'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '11'){
                            $array['November'] = $array['November'] + $dtl->amount;
                        }elseif($dtl->adjmonth === '12'){
                            $array['December'] = $array['December'] + $dtl->amount;
                        }
                        $array['Total'] = $array['Total'] + $dtl->amount;
                    }
                }
                array_push($result_array, $array);
            }
        }
        return $result_array;
    }

    public function get_jeep_adjustment($data){
        $result_array = [];
        $array = [
            'Unit' => 'JEEP',
            'Collection' => 0,
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
            'Total' => 0,
        ];
        $Collection = $this->db->select('SUM(LessAdmin) AS Collect')->from('tbljeepvehicleloghdr')->where("CheckDate BETWEEN '".$data['from']."' AND '".$data['to']."'")->get()->row();
        if($Collection){
            $array['Collection'] = $Collection->Collect;
        }
        $adjustments = $this->db
                ->select('amount, MONTH(adjustment_date) AS adjmonth')
                ->from('tbltruckingadjustment')
                ->where("adjustment_date BETWEEN '".$data['from']."' AND '".$data['to']."'")
                ->where('vehicle_type', 'JEEP')
                ->get();
        if($adjustments->result()){
            foreach($adjustments->result() as $dtl){
                if($dtl->adjmonth === '1'){
                    $array['January'] = $array['January'] + $dtl->amount;
                }elseif($dtl->adjmonth === '2'){
                    $array['February'] = $array['February'] + $dtl->amount;
                }elseif($dtl->adjmonth === '3'){
                    $array['March'] = $array['March'] + $dtl->amount;
                }elseif($dtl->adjmonth === '4'){
                    $array['April'] = $array['April'] + $dtl->amount;
                }elseif($dtl->adjmonth === '5'){
                    $array['May'] = $array['May'] + $dtl->amount;
                }elseif($dtl->adjmonth === '6'){
                    $array['June'] = $array['June'] + $dtl->amount;
                }elseif($dtl->adjmonth === '7'){
                    $array['July'] = $array['July'] + $dtl->amount;
                }elseif($dtl->adjmonth === '8'){
                    $array['August'] = $array['August'] + $dtl->amount;
                }elseif($dtl->adjmonth === '9'){
                    $array['September'] = $array['September'] + $dtl->amount;
                }elseif($dtl->adjmonth === '10'){
                    $array['October'] = $array['October'] + $dtl->amount;
                }elseif($dtl->adjmonth === '11'){
                    $array['November'] = $array['November'] + $dtl->amount;
                }elseif($dtl->adjmonth === '12'){
                    $array['December'] = $array['December'] + $dtl->amount;
                }
                $array['Total'] = $array['Total'] + $dtl->amount;
            }
        }
        array_push($result_array, $array);
        return $result_array;
    }
    public function get_golfcart_adjustment($data){
        $result_array = [];
        $array = [
            'Unit' => 'GOLFCART',
            'Collection' => 0,
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
            'Total' => 0,
        ];
        $Collection = $this->db->select('SUM(b.amount) AS Collect')->from('golf_cart_soa_dtl b, golf_cart_payment c')->where('c.soa_link = b.soa_hdr_id')->where("c.payment_date BETWEEN '".$data['from']."' AND '".$data['to']."'")->get()->row();
        if($Collection){
            $array['Collection'] = $Collection->Collect;
        }
        $adjustments = $this->db
                ->select('amount, MONTH(adjustment_date) AS adjmonth')
                ->from('tbltruckingadjustment')
                ->where("adjustment_date BETWEEN '".$data['from']."' AND '".$data['to']."'")
                ->where('vehicle_type', 'GOLFCART')
                ->get();
        if($adjustments->result()){
            foreach($adjustments->result() as $dtl){
                if($dtl->adjmonth === '1'){
                    $array['January'] = $array['January'] + $dtl->amount;
                }elseif($dtl->adjmonth === '2'){
                    $array['February'] = $array['February'] + $dtl->amount;
                }elseif($dtl->adjmonth === '3'){
                    $array['March'] = $array['March'] + $dtl->amount;
                }elseif($dtl->adjmonth === '4'){
                    $array['April'] = $array['April'] + $dtl->amount;
                }elseif($dtl->adjmonth === '5'){
                    $array['May'] = $array['May'] + $dtl->amount;
                }elseif($dtl->adjmonth === '6'){
                    $array['June'] = $array['June'] + $dtl->amount;
                }elseif($dtl->adjmonth === '7'){
                    $array['July'] = $array['July'] + $dtl->amount;
                }elseif($dtl->adjmonth === '8'){
                    $array['August'] = $array['August'] + $dtl->amount;
                }elseif($dtl->adjmonth === '9'){
                    $array['September'] = $array['September'] + $dtl->amount;
                }elseif($dtl->adjmonth === '10'){
                    $array['October'] = $array['October'] + $dtl->amount;
                }elseif($dtl->adjmonth === '11'){
                    $array['November'] = $array['November'] + $dtl->amount;
                }elseif($dtl->adjmonth === '12'){
                    $array['December'] = $array['December'] + $dtl->amount;
                }
                $array['Total'] = $array['Total'] + $dtl->amount;
            }
        }
        array_push($result_array, $array);
        return $result_array;
    }
}
