<?php

Class Liftruck_Report_Model extends CI_Model {
    public function get_standard_report($data){
        $amount = "SELECT SUM(c.amount) from liftruck_soa_dtl c WHERE a.id = c.soa_hdr_id GROUP BY c.soa_hdr_id";
        $collected = "SELECT SUM(b.amount) from liftruck_payment b WHERE a.id = b.soa_link GROUP BY b.soa_link";
        $result_array = [];
        if($data['type'] == 1){
            $query = $this->db->select("a.id, a.series_no, a.billed_name, a.soa_date, a.charge_invoice_no, a.details, (". $amount .") AS BilledAmount, (". $collected .") AS CollectedAmount")->from("liftruck_soa_hdr a")->get()->result();
            if($query){
                foreach($query as $record){
                    $collected = $this->db->select("b.id, b.mode, b.payment_date, b.or_ref_no, b.check_card_no, b.check_card_bank_name, b.amount")->from("liftruck_payment b")->where("b.soa_link = '".$record->id."'")->get()->result();
                    $record->payments = $collected ? $collected : [];
                    array_push($result_array, $record);
                }
                return $result_array;
            }else{
                return false;
            }
        }
        elseif($data['type'] == 2){
            $query = $this->db->select("a.id, a.series_no, a.billed_name, a.soa_date, a.charge_invoice_no, a.details, (". $amount .") AS BilledAmount, (". $collected .") AS CollectedAmount")->from("liftruck_soa_hdr a")->where("a.soa_date BETWEEN '".$data['from']."' AND '".$data['to']."'")->get()->result();
            if($query){
                foreach($query as $record){
                    $collected = $this->db->select("b.id, b.mode, b.payment_date, b.or_ref_no, b.check_card_no, b.check_card_bank_name, b.amount")->from("liftruck_payment b")->where("b.soa_link = '".$record->id."'")->get()->result();
                    $record->payments = $collected ? $collected : [];
                    array_push($result_array, $record);
                }
                return $result_array;
            }else{
                return false;
            }
        }elseif($data['type'] == 3){
            $query = $this->db->select("a.id, a.series_no, a.billed_name, a.soa_date, a.charge_invoice_no, a.details, (". $amount .") AS BilledAmount, (". $collected .") AS CollectedAmount")->from("liftruck_soa_hdr a")->where("a.charge_invoice_no = '".$data['invoice']."'")->get()->result();
            if($query){
                foreach($query as $record){
                    $collected = $this->db->select("b.id, b.mode, b.payment_date, b.or_ref_no, b.check_card_no, b.check_card_bank_name, b.amount")->from("liftruck_payment b")->where("b.soa_link = '".$record->id."'")->get()->result();
                    $record->payments = $collected ? $collected : [];
                    array_push($result_array, $record);
                }
                return $result_array;
            }else{
                return false;
            }
        }elseif($data['type'] == 4){
            $query = $this->db->select("a.id, a.series_no, a.billed_name, a.soa_date, a.charge_invoice_no, a.details, (". $amount .") AS BilledAmount, (". $collected .") AS CollectedAmount")->from("liftruck_soa_hdr a, liftruck_rental d")->where("d.vehicle_id = '".$data['unitID']."'")->where("a.id = d.soaid_link")->get()->result();
            if($query){
                foreach($query as $record){
                    $collected = $this->db->select("b.id, b.mode, b.payment_date, b.or_ref_no, b.check_card_no, b.check_card_bank_name, b.amount")->from("liftruck_payment b")->where("b.soa_link = '".$record->id."'")->get()->result();
                    $record->payments = $collected ? $collected : [];
                    array_push($result_array, $record);
                }
                return $result_array;
            }else{
                return false;
            }
        }
    }

    public function get_per_unit_report($data){
        $collected = 'SELECT SUM(amount) FROM liftruck_payment b WHERE b.soa_link = a.soaid_link GROUP BY b.soa_link';
        $check = 'SELECT check_card_no FROM liftruck_payment b WHERE b.soa_link = a.soaid_link LIMIT 1';
        $check_date = 'SELECT payment_date FROM liftruck_payment b WHERE b.soa_link = a.soaid_link LIMIT 1';
        $ref = 'SELECT or_ref_no FROM liftruck_payment b WHERE b.soa_link = a.soaid_link LIMIT 1';
        if($data['type'] == 1){
            $query = $this->db
            ->select('a.*, ('.$collected.') AS collected, ('.$check.') AS check_no, ('.$check_date.') AS check_date, ('.$ref.') AS ref_no')
            ->from('liftruck_rental a')
            ->get()
            ->result();
        }else{
            $query = $this->db
            ->select('a.*, ('.$collected.') AS collected, ('.$check.') AS check_no, ('.$check_date.') AS check_date, ('.$ref.') AS ref_no')
            ->from('liftruck_rental a')
            ->where('vehicle_name', $data['id'])
            ->where("date BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->get()
            ->result();
        }
        
        return $query ? $query : false;
    }
}