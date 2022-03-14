<?php

Class Payment_Model extends CI_Model {
    public function get_uploaded(){
        $sess = $this->session->userdata('gscbilling_session');
        $query = $this->db->where('UploadedBy', $sess['id'])->from('payment_uploads')->select('*')->get()->result();
        return $query ? $query : false;
    }
    public function get_uploaded_report(){
        $sess = $this->session->userdata('gscbilling_session');
        $amount = 'SELECT SUM(b.totalAmt) FROM dmpi_dar_dtls b WHERE a.DARID = b.hdr_id GROUP BY b.hdr_id';
        $query = $this->db->where('UploadedBy', $sess['id'])->from('payment_uploads a')->select('COUNT(*) As CT, DARID, SUM(Amount) AS SAmount, DocDate, SOA_Number, ('.$amount.') AS CAmount')->group_by('SOA_Number')->get()->result();
        return $query ? $query : false;
    }
    public function get_payment_details($id){
        $query = $this->db->select("*")->from('payment_dtl')->where('HDRID', $id)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_soa_from_payment($id, $client){
        if($client === 'DAR'){
            $amount = 'SELECT SUM(b.totalAmt) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
            $query = $this->db->select("a.id AS SOAID, a.soaNumber, (".$amount.") AS Amount, SUM(c.Amount) AS AmountPaid, a.soaDate")->from('dmpi_dar_hdrs a, dar_payment_link c')->where('c.PDTLID', $id)->where('a.id = c.DARID')->group_by('a.id')->get();
            return $query->result() ? $query->result() : false;
        }if($client === 'SAR'){
            $amount = 'SELECT SUM(b.amount) FROM dmpi_sar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
            $query = $this->db->select("a.id AS SOAID, a.controlNo AS soaNumber, (".$amount.") AS Amount, SUM(c.Amount) AS AmountPaid, a.soaDate")->from('dmpi_sars a, sar_payment_link c')->where('c.PDTLID', $id)->where('a.id = c.SARID')->group_by('a.id')->get();
            return $query->result() ? $query->result() : false;
        }elseif($client === 'BCC'){
            $amount = 'SELECT SUM(b.total + (b.total * (a.admin_percentage/100))) FROM tbloc_bccdtl b WHERE a.TOCSHDR = b.hdr_id GROUP BY b.hdr_id';
            $query = $this->db->select("a.TOCSHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, SUM(c.Amount) AS AmountPaid, a.Date as soaDate")->from('tbloc_bcchdr a, other_client_payment_link c')->where('c.PDTLID', $id)->where('a.TOCSHDR = c.HdrID')->where('client', 'BCC')->group_by('a.TOCSHDR')->get();
            return $query->result() ? $query->result() : false;
        }elseif($client === 'SLERS'){
            $amount = 'SELECT SUM(b.total + (b.total * (a.admin_percentage/100))) FROM tbloc_slersdtl b WHERE a.TOCSHDR = b.hdr_id GROUP BY b.hdr_id';
            $query = $this->db->select("a.TOCSHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, SUM(c.Amount) AS AmountPaid, a.Date as soaDate")->from('tbloc_slershdr a, other_client_payment_link c')->where('c.PDTLID', $id)->where('a.TOCSHDR = c.HdrID')->where('client', 'SLERS')->group_by('a.TOCSHDR')->get();
            return $query->result() ? $query->result() : false;
        }elseif($client === 'LABNOTIN'){
            $amount = 'SELECT SUM(b.amount_billed + (b.amount_billed * (a.admin_percentage/100))) FROM tbloc_labnotindtl b WHERE a.TOCLHDR = b.hdr_id GROUP BY b.hdr_id';
            $query = $this->db->select("a.TOCLHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, SUM(c.Amount) AS AmountPaid, a.Date as soaDate")->from('tbloc_labnotinhdr a, other_client_payment_link c')->where('c.PDTLID', $id)->where('a.TOCLHDR = c.HdrID')->where('client', 'LABNOTIN')->group_by('a.TOCLHDR')->get();
            return $query->result() ? $query->result() : false;
        }elseif($client === 'DEARBC'){
            $amount = 'SELECT SUM(b.total + (b.total * (a.admin_percentage/100))) FROM tbloc_dearbcdtl b WHERE a.TOCDHDR = b.hdr_id GROUP BY b.hdr_id';
            $query = $this->db->select("a.TOCDHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, SUM(c.Amount) AS AmountPaid, a.date_created as soaDate")->from('tbloc_dearbchdr a, other_client_payment_link c')->where('c.PDTLID', $id)->where('a.TOCDHDR = c.HdrID')->where('client', 'DEARBC')->group_by('a.TOCDHDR')->get();
            return $query->result() ? $query->result() : false;
        }elseif($client === 'CLUBHOUSE'){
            $amount = 'SELECT SUM(b.total + (b.total * (a.admin_percentage/100))) FROM tbloc_cbdtl b WHERE a.TOCSHDR = b.hdr_id GROUP BY b.hdr_id';
            $query = $this->db->select("a.TOCSHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, SUM(c.Amount) AS AmountPaid, a.Date as soaDate")->from('tbloc_cbhdr a, other_client_payment_link c')->where('c.PDTLID', $id)->where('a.TOCSHDR = c.HdrID')->where('client', 'CLUBHOUSE')->group_by('a.TOCSHDR')->get();
            return $query->result() ? $query->result() : false;
        }
    }
    public function get_dar_hdr($soa, $type){
        if($type == 'Summary'){
            $amount = 'SELECT SUM(b.totalAmt) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
            $paid = 'SELECT SUM(c.Amount) FROM dar_payment_link c WHERE a.id = c.DARID GROUP BY c.DARID';
            $ORNo = 'SELECT GROUP_CONCAT(d.ORNo) FROM dar_payment_link c, payment_dtl d WHERE a.id = c.DARID AND d.PDTLID = c.PDTLID GROUP BY c.DARID';
            $ORDate = 'SELECT GROUP_CONCAT(d.PayDate) FROM dar_payment_link c, payment_dtl d WHERE a.id = c.DARID AND d.PDTLID = c.PDTLID GROUP BY c.DARID';
            $CheckNo = 'SELECT GROUP_CONCAT(d.CardNo) FROM dar_payment_link c, payment_dtl d WHERE a.id = c.DARID AND d.PDTLID = c.PDTLID GROUP BY c.DARID';
            $RefNo = 'SELECT GROUP_CONCAT(d.Remarks) FROM dar_payment_link c, payment_dtl d WHERE a.id = c.DARID AND d.PDTLID = c.PDTLID GROUP BY c.DARID';
            $query = $this->db->select("a.id AS SOAID, a.soaNumber, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, (".$ORNo.") AS ORNo, (".$ORDate.") AS ORDate, (".$CheckNo.") AS CheckNo, (".$RefNo.") AS RefNo")->from('dmpi_dar_hdrs a')->like('a.soaNumber', $soa)->get();
            return $query->result() ? $query->result() : false;    
        }else{
            $query = $this->db->select("*")->from('dmpi_dar_hdrs a')->join('dar_payment_link b', 'a.id = b.DARID', 'left')->join('payment_dtl c', 'c.PDTLID = b.PDTLID', 'left')->like('a.soaNumber', $soa)->get();
            return $query->result() ? $query->result() : false;
        }
        
    }

    public function get_sar_hdr($soa){
        $amount = 'SELECT SUM(b.amount) FROM dmpi_sar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
        $paid = 'SELECT SUM(c.Amount) FROM sar_payment_link c WHERE a.id = c.SARID GROUP BY c.SARID';
        $query = $this->db->select("a.id AS SOAID, a.controlNo AS soaNumber, (".$amount.") AS Amount, periodCoveredFrom AS soaDate, (".$paid.") AS AmountPaid")->from('dmpi_sars a')->like('a.controlNo', $soa)->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_bcc_hdr($soa){
        $amount = 'SELECT SUM(b.total + (b.total * (a.admin_percentage/100))) FROM tbloc_bccdtl b WHERE a.TOCSHDR = b.hdr_id GROUP BY b.hdr_id';
        $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCSHDR = c.HdrID AND client = "BCC" GROUP BY c.HdrID';
        $query = $this->db->select("a.TOCSHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, a.Date as soaDate")->from('tbloc_bcchdr a')->like('a.SOANo', $soa)->order_by('a.TOCSHDR', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_slers_hdr($soa){
        $amount = 'SELECT SUM(b.total + (b.total * (a.admin_percentage/100))) FROM tbloc_slersdtl b WHERE a.TOCSHDR = b.hdr_id GROUP BY b.hdr_id';
        $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCSHDR = c.HdrID AND client = "SLERS" GROUP BY c.HdrID';
        $query = $this->db->select("a.TOCSHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, a.Date as soaDate")->from('tbloc_slershdr a')->like('a.SOANo', $soa)->order_by('a.TOCSHDR', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_labnotin_hdr($soa){
        $amount = 'SELECT SUM(b.amount_billed + (b.amount_billed * (a.admin_percentage/100))) FROM tbloc_labnotindtl b WHERE a.TOCLHDR = b.hdr_id GROUP BY b.hdr_id';
        $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCLHDR = c.HdrID AND client = "LABNOTIN" GROUP BY c.HdrID';
        $query = $this->db->select("a.TOCLHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, a.Date as soaDate")->from('tbloc_labnotinhdr a')->like('a.SOANo', $soa)->order_by('a.TOCLHDR', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_dearbc_hdr($soa){
        $amount = 'SELECT SUM(b.total + (b.total * (a.admin_percentage/100))) FROM tbloc_dearbcdtl b WHERE a.TOCDHDR = b.hdr_id GROUP BY b.hdr_id';
        $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCDHDR = c.HdrID AND client = "DEARBC" GROUP BY c.HdrID';
        $query = $this->db->select("a.TOCDHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, (".$paid.") AS AmountPaid")->from('tbloc_dearbchdr a')->like('a.SOANo', $soa)->order_by('a.TOCDHDR', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_clubhouse_hdr($soa){
        $amount = 'SELECT SUM(b.total + (b.total * (a.admin_percentage/100))) FROM tbloc_cbdtl b WHERE a.TOCSHDR = b.hdr_id GROUP BY b.hdr_id';
        $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCSHDR = c.HdrID AND client = "CLUBHOUSE" GROUP BY c.HdrID';
        $query = $this->db->select("a.TOCSHDR AS SOAID, a.SOANo as soaNumber, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, a.Date as soaDate")->from('tbloc_cbhdr a')->like('a.SOANo', $soa)->order_by('a.TOCSHDR', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_payment_hdr($field, $data){
        $query = $this->db
        ->select('a.*, SUM(b.Amount) AS TotalAmount, b.PayDate, b.ORNo, b.CardNo')
        ->from('payment_hdr a')
        ->join('payment_dtl b', 'a.PHDRID = b.HDRID', 'left')
        ->like($field, $data)
        ->group_by('a.PHDRID')->get();
        return $query->result() ? $query->result() : false;
    }
    public function save_hdr($data){
        if($data['PHDRID'] > 0){
            $this->db->where('PHDRID', $data['PHDRID'])->update('payment_hdr', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('payment_hdr', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();

                $PaymentNo = $data['Client'].Date('Ymd').'-'.str_pad($id, 4, '0', STR_PAD_LEFT);

                $this->db->where('PHDRID', $id)->update('payment_hdr', ['PayNo' => $PaymentNo]);
                return ['id' => $id, 'PayNo' => $PaymentNo];
            }else{
                return false;
            }
        }
    }
    public function save_dtl($data){
        if($data['PDTLID'] > 0){
            $this->db->where('PDTLID', $data['PDTLID'])->update('payment_dtl', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('payment_dtl', $data);
            if($this->db->affected_rows()){
                return ['id' => $this->db->insert_id()];
            }else{
                return false;
            }
        }
    }
    public function save_dtl_uploaded($data){
        $sess = $this->session->userdata('gscbilling_session');
        if($data['PDTLID'] > 0){
            $dtl_id = $data['PDTLID'];
        }else{
            $data['UploadedBy'] = $sess['fullname'];
            $data['UploadedDate'] = date('Y-m-d');
            $this->db->insert('payment_dtl', $data);
            $dtl_id = $this->db->insert_id();
        }
        
        $not_saved = [];
        $query = $this->db->where('UploadedBy', $sess['id'])->where('DARID > 0')->from('payment_uploads')->select('*')->get()->result();
        if($query){
            foreach($query as $record){
                // $update = ['PaidAmount' => $record->Amount, 'DocumentDate' => $record->DocDate, 'PaymentHDRID' => $data['HDRID']];
                // $this->db->where('id', $record->DARID)->update('dmpi_dar_hdrs', $update);
                $get_total_amt = $this->db->select('SUM(c_totalAmt) AS total FROM dmpi_dar_dtls WHERE hdr_id = '.$record->DARID.' GROUP BY hdr_id')->get()->result();
                $get_total_paid = $this->db->select('SUM(Amount) AS paid FROM dar_payment_link WHERE DARID = '.$record->DARID.' GROUP BY DARID')->get()->result();
                $totalAmt = $get_total_amt ? $get_total_amt[0]->total : 0;
                $totalPaid = $get_total_paid ? $get_total_paid[0]->paid : 0;
                $totals = $totalPaid + $record->Amount;
                // if($totals > $totalAmt){
                //     $array = ['SOANumber' => $record->SOA_Number, 'Balance' => $totalAmt - $totalPaid, 'Amt' => $record->Amount];
                //     array_push($not_saved, $array);
                // }
                // else{
                    $pay_data = ['DARID' => $record->DARID, 'PDTLID' => $dtl_id, 'Amount' => $record->Amount];
                    $this->db->insert('dar_payment_link', $pay_data);
                    $this->db->insert('soa_accounting_entries', ['Debit' => $record->Amount, 'SOAID' => $record->DARID, 'Client' => 'DAR']);
                    $this->db->insert('soa_accounting_entries', ['Credit' => $record->Amount, 'SOAID' => $record->DARID, 'Client' => 'DAR']);
                // }
            }
        }
        if($data['PDTLID'] > 0){
            $update_amt = $this->db->select('SUM(Amount) AS total')->from('dar_payment_link')->where('PDTLID', $data['PDTLID'])->group_by('PDTLID')->get()->result();
            $this->db->where('PDTLID', $data['PDTLID'])->update('payment_dtl', ['Amount' => $update_amt ? $update_amt[0]->total : 0]);
        }
        // if($this->db->affected_rows()){
            return ['id' => $dtl_id, 'rows' => $not_saved];
        // }else{
        //     return false;
        // }
    }
    public function save_soas($rows, $client){
        foreach($rows as $rec){
            if($client === 'DAR'){
                $this->db->insert('dar_payment_link', ['DARID' => $rec['SOAID'], 'Amount' => $rec['AmountPaid'], 'PDTLID' => $rec['PDTLID']]);
            }elseif($client === 'SAR'){
                $this->db->insert('sar_payment_link', ['SARID' => $rec['SOAID'], 'Amount' => $rec['AmountPaid'], 'PDTLID' => $rec['PDTLID']]);
            }elseif($client === 'BCC'){
                $this->db->insert('other_client_payment_link', ['HdrID' => $rec['SOAID'], 'Amount' => $rec['AmountPaid'], 'PDTLID' => $rec['PDTLID'], 'client' => 'BCC']);
            }elseif($client === 'SLERS'){
                $this->db->insert('other_client_payment_link', ['HdrID' => $rec['SOAID'], 'Amount' => $rec['AmountPaid'], 'PDTLID' => $rec['PDTLID'], 'client' => 'SLERS']);
            }elseif($client === 'DEARBC'){
                $this->db->insert('other_client_payment_link', ['HdrID' => $rec['SOAID'], 'Amount' => $rec['AmountPaid'], 'PDTLID' => $rec['PDTLID'], 'client' => 'DEARBC']);
            }elseif($client === 'LABNOTIN'){
                $this->db->insert('other_client_payment_link', ['HdrID' => $rec['SOAID'], 'Amount' => $rec['AmountPaid'], 'PDTLID' => $rec['PDTLID'], 'client' => 'LABNOTIN']);
            }elseif($client === 'CLUBHOUSE'){
                $this->db->insert('other_client_payment_link', ['HdrID' => $rec['SOAID'], 'Amount' => $rec['AmountPaid'], 'PDTLID' => $rec['PDTLID'], 'client' => 'CLUBHOUSE']);
            }
            $this->db->insert('soa_accounting_entries', ['Debit' => $rec['AmountPaid'], 'SOAID' => $rec['SOAID'], 'Client' => $client]);
            $this->db->insert('soa_accounting_entries', ['Credit' => $rec['AmountPaid'], 'SOAID' => $rec['SOAID'], 'Client' => $client]);
        }
        return true;
    }
    public function erase_prevoius_uploads(){
        $sess = $this->session->userdata('gscbilling_session');
        $this->db->where('UploadedBy', $sess['id'])->delete('payment_uploads');
        return true;
    }
    public function upload_payment_dar($rows){
        $sess = $this->session->userdata('gscbilling_session');
        // $this->db->where('UploadedBy', $sess['id'])->delete('payment_uploads');
        foreach($rows as $record){
            $SOA = str_replace(" ","", $record['SOA_Number']);
            $DAR = $this->db->select('id')->from('dmpi_dar_hdrs')->where('soaNumber', $SOA)->where('status', 'PRINTED TRANSMITTAL')->order_by('id', 'desc')->get()->row();
            $data = [
                'SOA_Number' => $SOA,
                'Amount' => $record['Amount'],
                'DocDate' => $record['DocDate'],
                'DARID' => $DAR ? $DAR->id : 0,
                'UploadedBy' => $sess['id']
            ];
            $this->db->insert('payment_uploads', $data);
        }
        return true;
    }
    public function delete_data($id){
        $this->db->where('HDRID', $id)->delete('payment_dtl');
        $this->db->where('PHDRID', $id)->delete('payment_hdr');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

    public function delete_dtl($id, $client){
        if($client == 'DAR'){
            $this->db->where('PDTLID', $id)->delete('dar_payment_link');
        }elseif($client == 'SAR'){
            $this->db->where('PDTLID', $id)->delete('sar_payment_link');
        }
        $this->db->where('PDTLID', $id)->delete('payment_dtl');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

    public function save_overpayment($data){
        $query = $this->db->select('id, soaNumber')->from('dmpi_dar_hdrs')->where('soaNumber', $data['soaNumber'])->get()->result();
        if(!$query){return ['id'=> 0, 'error' => true];}
        else{
            $array = [
                'DARID' => $query[0]->id,
                'Amount' => $data['Amount'],
                'referenceNo' => $data['refNo']
            ];
            $this->db->insert('dar_payment_link', $array);
            if($this->db->insert_id()){
                return true;
            }else{
                return false;
            }
        }
    }
}