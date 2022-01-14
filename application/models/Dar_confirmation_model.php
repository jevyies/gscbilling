<?php

Class DAR_Confirmation_Model extends CI_Model {

    public function get_soa_via_transmittal($search, $role){
        $Amt = 'SELECT SUM(b.c_totalAmt) FROM dmpi_dar_dtls b WHERE b.hdr_id = a.id GROUP BY b.hdr_id';
        $batches = "SELECT GROUP_CONCAT(d.BNo SEPARATOR ', ') FROM dmpi_dar_batches c, 201filedb.tblbatch d WHERE d.BID = c.BID AND c.DARID = a.id GROUP BY c.DARID";
        $location = 
        "CASE
            WHEN nonBatch = 1 THEN (SELECT `location` FROM dmpi_dar_hdrs b WHERE a.id = b.id LIMIT 1)
            WHEN nonBatch = 0 THEN (SELECT `Location` FROM dmpi_dar_batches b, 201filedb.tblbatch c WHERE a.id = b.DARID AND b.BID = c.BID LIMIT 1)
        END";
        $BatchedBy = "SELECT BatchedBy FROM dmpi_dar_batches c, 201filedb.tblbatch d WHERE d.BID = c.BID AND c.DARID = a.id LIMIT 1";
        $Created = "SELECT date_created FROM dar_transmittal c WHERE c.TransmittalNo = a.TransmittalNo ORDER BY c.id DESC LIMIT 1";
        $this->db
        ->select('*, ('.$Amt.') AS Amount, ('.$batches.') AS Batches, ('.$location.') AS Location, ('.$BatchedBy.') AS BatchedBy, ('.$Created.') AS transmittal_date')
        ->from('dmpi_dar_hdrs a')
        ->where('a.TransmittalNo', $search);
        if($role === '1'){
            $this->db->where_in('a.status', ['submitted', 'transmitted']);
        }
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_soa_via_control_no($search){
        $Amt = 'SELECT SUM(b.totalAmt) FROM dmpi_dar_dtls b WHERE b.hdr_id = a.id GROUP BY b.hdr_id';
        $batches = "SELECT GROUP_CONCAT(d.BNo SEPARATOR ', ') FROM dmpi_dar_batches c, 201filedb.tblbatch d WHERE d.BID = c.BID AND c.DARID = a.id GROUP BY c.DARID";
        $location = "SELECT `Location` FROM dmpi_dar_batches c, 201filedb.tblbatch d WHERE d.BID = c.BID AND c.DARID = a.id LIMIT 1";
        $BatchedBy = "SELECT BatchedBy FROM dmpi_dar_batches c, 201filedb.tblbatch d WHERE d.BID = c.BID AND c.DARID = a.id LIMIT 1";
        $query = $this->db
        ->select('*, ('.$Amt.') AS Amount, ('.$batches.') AS Batches, ('.$location.') AS Location, ('.$BatchedBy.') AS BatchedBy')
        ->from('dmpi_dar_hdrs a')
        ->where('a.id', $search)
        // ->where('a.status', 'submitted')
        ->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_soa_via_soa_number($search){
        $Amt = 'SELECT SUM(b.totalAmt) FROM dmpi_dar_dtls b WHERE b.hdr_id = a.id GROUP BY b.hdr_id';
        $batches = "SELECT GROUP_CONCAT(d.BNo SEPARATOR ', ') FROM dmpi_dar_batches c, 201filedb.tblbatch d WHERE d.BID = c.BID AND c.DARID = a.id GROUP BY c.DARID";
        $location = "SELECT `Location` FROM dmpi_dar_batches c, 201filedb.tblbatch d WHERE d.BID = c.BID AND c.DARID = a.id LIMIT 1";
        $BatchedBy = "SELECT BatchedBy FROM dmpi_dar_batches c, 201filedb.tblbatch d WHERE d.BID = c.BID AND c.DARID = a.id LIMIT 1";
        $query = $this->db
        ->select('*, ('.$Amt.') AS Amount, ('.$batches.') AS Batches, ('.$location.') AS Location, ('.$BatchedBy.') AS BatchedBy')
        ->from('dmpi_dar_hdrs a')
        ->where('a.soaNumber', $search)
        // ->where('a.status', 'submitted')
        ->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_soa_details($id){
        $query = $this->db->select('*')->from('dmpi_dar_dtls')->where('hdr_id', $id)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_transmittal_info($id){
        $query = $this->db->select('*')->from('dar_transmittal')->where('TransmittalNo', $id)->order_by('date_created', 'desc')->limit(1)->get();
        return $query->result() ? $query->result() : false;
    }
    public function save_signatory_transmittal($data){
        date_default_timezone_set('Asia/Manila');
        if($data['id'] > 0){
            $data['date_updated'] = Date('Y-m-d H:i:s');
            $data['date_updated'] = Date('Y-m-d H:i:s');
            $this->db->where('id', $data['id'])->update('dar_transmittal', $data);
        }else{
            $data['date_updated'] = Date('Y-m-d H:i:s');
            $data['date_created'] = Date('Y-m-d H:i:s');
            $this->db->insert('dar_transmittal', $data);
        }
        return $this->db->affected_rows() ? true : false;
    }

    public function save_signatory_finalization($data, $rows){
        date_default_timezone_set('Asia/Manila');
        $sess = $this->session->userdata('gscbilling_session');
        if($data['id'] > 0){
            $data['date_updated'] = Date('Y-m-d H:i:s');
            $data['date_finalize'] = Date('Y-m-d H:i:s');
            $this->db->where('TransmittalNo', $data['TransmittalNo'])->where('status', 'confirmed')->update('dmpi_dar_hdrs', ['status' => 'PRINTED TRANSMITTAL']);
            $this->db->where('id', $data['id'])->update('dar_transmittal', $data);
        }else{
            $data['date_updated'] = Date('Y-m-d H:i:s');
            $data['date_created'] = Date('Y-m-d H:i:s');
            $data['date_finalize'] = Date('Y-m-d H:i:s');
            $this->db->where('TransmittalNo', $data['TransmittalNo'])->where('status', 'confirmed')->update('dmpi_dar_hdrs', ['status' => 'PRINTED TRANSMITTAL']);
            $this->db->insert('dar_transmittal', $data);
        }
        if($this->db->affected_rows()){
            foreach($rows as $row){
                $log = [
                    'dar_id' => $row,
                    'activity' => 'Set to Final Transmittal',
                    'user' => $sess['fullname'],
                    'log_date' => Date('Y-m-d H:i:s'),
                ];
                $this->db->insert('dar_audit_logs', $log);
            }
            return true;
        }else{
            return false;
        } 
    }

    public function save_transmittal($rows){
        $sess = $this->session->userdata('gscbilling_session');
        date_default_timezone_set('Asia/Manila');
        $this->db->where_in('id', $rows)->update('dmpi_dar_hdrs', ['status' => 'transmitted']);
        if($this->db->affected_rows()){
            foreach($rows as $row){
                $log = [
                    'dar_id' => $row,
                    'activity' => 'Set As Transmitted',
                    'user' => $sess['fullname'],
                    'log_date' => Date('Y-m-d H:i:s'),
                ];
                $this->db->insert('dar_audit_logs', $log);
            }
            return true;
        }else{
            return false;
        }
    }

    public function save_confirmation($rows){
        $sess = $this->session->userdata('gscbilling_session');
        date_default_timezone_set('Asia/Manila');
        $this->db->where_in('id', $rows)->update('dmpi_dar_hdrs', ['status' => 'confirmed', 'ConfirmationBy' => $sess['fullname'], 'ConfirmationDate' => date('Y-m-d h:i:s')]);
        if($this->db->affected_rows()){
            foreach($rows as $row){
                $log = [
                    'dar_id' => $row,
                    'activity' => 'Confirmed',
                    'user' => $sess['fullname'],
                    'log_date' => Date('Y-m-d H:i:s'),
                ];
                $this->db->insert('dar_audit_logs', $log);
            }
            return true;
        }else{
            return false;
        }
    }
}