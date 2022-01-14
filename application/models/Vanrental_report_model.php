<?php

Class VanRental_Report_Model extends CI_Model {
    public function get_standard_report($data){
        $amount = "SELECT SUM(c.amount) from vanrental_soa_dtl c WHERE a.id = c.soa_hdr_id GROUP BY c.soa_hdr_id";
        $collected = "SELECT SUM(b.amount) from vanrental_payment b WHERE a.id = b.soa_link GROUP BY b.soa_link";
        $result_array = [];
        if($data['type'] == 1){
            $query = $this->db->select("a.id, a.series_no, a.billed_name, a.soa_date, a.charge_invoice_no, a.details, (". $amount .") AS BilledAmount, (". $collected .") AS CollectedAmount")->from("vanrental_soa_hdr a")->get()->result();
            if($query){
                foreach($query as $record){
                    $collected = $this->db->select("b.id, b.mode, b.payment_date, b.or_ref_no, b.check_card_no, b.check_card_bank_name, b.amount")->from("vanrental_payment b")->where("b.soa_link = '".$record->id."'")->get()->result();
                    $record->payments = $collected ? $collected : [];
                    array_push($result_array, $record);
                }
                return $result_array;
            }else{
                return false;
            }
        }
        elseif($data['type'] == 2){
            $query = $this->db->select("a.id, a.series_no, a.billed_name, a.soa_date, a.charge_invoice_no, a.details, (". $amount .") AS BilledAmount, (". $collected .") AS CollectedAmount")->from("vanrental_soa_hdr a")->where("a.soa_date BETWEEN '".$data['from']."' AND '".$data['to']."'")->get()->result();
            if($query){
                foreach($query as $record){
                    $collected = $this->db->select("b.id, b.mode, b.payment_date, b.or_ref_no, b.check_card_no, b.check_card_bank_name, b.amount")->from("vanrental_payment b")->where("b.soa_link = '".$record->id."'")->get()->result();
                    $record->payments = $collected ? $collected : [];
                    array_push($result_array, $record);
                }
                return $result_array;
            }else{
                return false;
            }
        }elseif($data['type'] == 3){
            $query = $this->db->select("a.id, a.series_no, a.billed_name, a.soa_date, a.charge_invoice_no, a.details, (". $amount .") AS BilledAmount, (". $collected .") AS CollectedAmount")->from("vanrental_soa_hdr a")->where("a.charge_invoice_no = '".$data['invoice']."'")->get()->result();
            if($query){
                foreach($query as $record){
                    $collected = $this->db->select("b.id, b.mode, b.payment_date, b.or_ref_no, b.check_card_no, b.check_card_bank_name, b.amount")->from("vanrental_payment b")->where("b.soa_link = '".$record->id."'")->get()->result();
                    $record->payments = $collected ? $collected : [];
                    array_push($result_array, $record);
                }
                return $result_array;
            }else{
                return false;
            }
        }elseif($data['type'] == 4){
            $query = $this->db->select("a.id, a.series_no, a.billed_name, a.soa_date, a.charge_invoice_no, a.details, (". $amount .") AS BilledAmount, (". $collected .") AS CollectedAmount")->from("vanrental_soa_hdr a, vanrental_requisition d")->where('a.id = d.soaid_link')->where("d.vehicle_id = '".$data['unitID']."'")->get()->result();
            if($query){
                foreach($query as $record){
                    $collected = $this->db->select("b.id, b.mode, b.payment_date, b.or_ref_no, b.check_card_no, b.check_card_bank_name, b.amount")->from("vanrental_payment b")->where("b.soa_link = '".$record->id."'")->get()->result();
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
        $collected = 'SELECT SUM(amount) FROM vanrental_payment b WHERE b.soa_link = a.soaid_link GROUP BY b.soa_link';
        $check = 'SELECT check_card_no FROM vanrental_payment b WHERE b.soa_link = a.soaid_link LIMIT 1';
        $check_date = 'SELECT payment_date FROM vanrental_payment b WHERE b.soa_link = a.soaid_link LIMIT 1';
        $ref = 'SELECT or_ref_no FROM vanrental_payment b WHERE b.soa_link = a.soaid_link LIMIT 1';
        $invoice = 'SELECT charge_invoice_no FROM vanrental_soa_hdr b WHERE b.id = a.soaid_link LIMIT 1';
        if($data['type'] == 1){
            $query = $this->db
            ->select('a.*, ('.$collected.') AS collected, ('.$check.') AS check_no, ('.$check_date.') AS check_date, ('.$ref.') AS ref_no, ('.$invoice.') AS invoice_no')
            ->from('vanrental_requisition a')
            ->where('OVLType', 'TRIP')
            ->get()
            ->result();
        }else{
            $query = $this->db
            ->select('a.*, ('.$collected.') AS collected, ('.$check.') AS check_no, ('.$check_date.') AS check_date, ('.$ref.') AS ref_no, ('.$invoice.') AS invoice_no')
            ->from('vanrental_requisition a')
            ->where('vehicle_id', $data['id'])
            ->where("date BETWEEN '".$data['from']."' AND '".$data['to']."'")
            ->where('OVLType', 'TRIP')
            ->get()
            ->result();
        }
       
        return $query ? $query : false;
    }

    public function get_per_unit_report_monthly($data){
        $collected = 'SELECT SUM(amount) FROM vanrental_payment b WHERE b.soa_link = a.soa_hdr_id GROUP BY b.soa_link';
        $check = 'SELECT check_card_no FROM vanrental_payment b WHERE b.soa_link = a.soa_hdr_id LIMIT 1';
        $check_date = 'SELECT payment_date FROM vanrental_payment b WHERE b.soa_link = a.soa_hdr_id LIMIT 1';
        $ref = 'SELECT or_ref_no FROM vanrental_payment b WHERE b.soa_link = a.soa_hdr_id LIMIT 1';

        $query = $this->db->select('a.*, ('.$collected.') AS collected, ('.$check.') AS check_no, ('.$check_date.') AS check_date, ('.$ref.') AS ref_no, b.charge_invoice_no')
        ->from('vanrental_soa_dtl a, vanrental_soa_hdr b')
        ->where('a.soa_hdr_id = b.id')
        ->where('a.vehicle_id', $data['id'])
        ->where("req_date BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->get()
        ->result();
        return $query ? $query : false;
    }

    public function get_payroll_report($data){
        $chapa = 'SELECT ChapaID_Old FROM 201filedb.tblemployeemasterfile b WHERE a.DriverID = b.EmpID LIMIT 1';
        $soa = 'SELECT series_no FROM vanrental_soa_hdr b WHERE a.soaid_link = b.id';
        $query = $this->db
        ->select('*, ('.$chapa.') AS Chapa, ('.$soa.') AS SOANo')
        ->from('vanrental_requisition a')
        ->where('DriverID', $data['id'])
        ->where("date BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->get();
        return $query->result() ? $query->result() : false;
    }
}