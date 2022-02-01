<?php

Class Dmpi_Dar_Model extends CI_Model {

    public function search_header($search, $pmy, $period){
        $amount = "SELECT SUM(c_totalAmt) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id";
        $query = $this->db
        ->select('*, ('.$amount.') as total_amount')
        ->from('dmpi_dar_hdrs a')
        ->where('pmy', $pmy)
        ->where('period', $period)
        ->like('soaNumber', $search)->get();
        return $query->result() ? $query->result() : false;
    }
    public function search_header_batch($search, $pmy, $period){
        $amount = "SELECT SUM(c_totalAmt) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id";
        $query = $this->db
        ->select('a.*, ('.$amount.') as total_amount')
        ->from('dmpi_dar_hdrs a, dmpi_dar_batches b, 201filedb.tblbatch c')
        ->where('a.id = b.DARID')
        ->where('c.BID = b.BID')
        ->where('a.pmy', $pmy)
        ->where('a.period', $period)
        ->where('c.BNo', $search)
        ->group_by('a.id')
        ->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_active(){
        $query = $this->db->select('*')->from('dmpi_dar_hdrs')->where('status', 'active')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_transmittal_exist($transmittal){
        $query = $this->db->select('TransmittalNo')->from('dmpi_dar_hdrs')->where('TransmittalNo', $transmittal)->where('status', 'PRINTED TRANSMITTAL')->limit(1)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_details($id){
        $query = $this->db->select('*')->from('dmpi_dar_dtls')->where('hdr_id', $id)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_details_supervisor($id){
        $query = $this->db->select('*')->from('dmpi_dar_dtls')->where('hdr_id', $id)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_details_incentives($id){
        $query = $this->db->select('*')->from('dmpi_dar_dtls')->where('hdr_id', $id)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_dar_logs($id){
        $query = $this->db->select('*')->from('dar_audit_logs')->where('dar_id', $id)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_rates($id){
        $query = $this->db
        ->select('b.*')
        ->from('dmpi_dar_dtls a, rate_masters b')
        ->where('a.rate_id = b.id')
        ->where('a.hdr_id', $id)
        ->group_by('a.rate_id')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_warnings($id){
        $query = $this->db->select('*')->from('dmpi_dar_warnings')->where('hdr_id', $id)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_transmittals(){
        $query = $this->db->select('TransmittalNo')->from('dmpi_dar_hdrs')->where("status <> 'PRINTED TRANSMITTAL'")->group_by('TransmittalNo')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_batch($phase, $period){
        $db2 = $this->load->database('otherdb', TRUE);
        $query = $db2
        ->select('BID, BNo')->from('tblbatch')
        ->where('Period', $period)
        ->where('Phase', $phase)
        ->where('isVolume', 0)
        ->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_batch_info_BNO($data){
        $db2 = $this->load->database('otherdb', TRUE);
        $query = $db2
        ->select('*')->from('tblbatch')
        ->where('BNo', $data['BNo'])
        ->where('Phase', $data['Phase'])
        ->where('Period', $data['Period'])
        ->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_batch_info_SNO($data){
        $db2 = $this->load->database('otherdb', TRUE);
        $query = $db2
        ->select('*')->from('tblbatch')
        ->where("CONCAT(Code_Location, Code_Date, Code_Series) ='".$data['soaNumber']."'")
        ->where('Phase', $data['Phase'])
        ->where('Period', $data['Period'])
        ->get();
        return $query->result() ? $query->result() : false;
    }
    public function check_soa_no($data){
        if($data['id'] > 0){
            $query = $this->db->select('id')->from('dmpi_dar_hdrs')->where('soaNumber', $data['soaNumber'])->where("id <> '". $data['id']."'")->get();
        }else{
            $query = $this->db->select('id')->from('dmpi_dar_hdrs')->where('soaNumber', $data['soaNumber'])->get();
        }
        return $query->result() ? true : false;
    }
    public function check_batch_no($data){
        if($data['id'] > 0){
            $query = $this->db->select('DBID')->from('dmpi_dar_batches')->where_in('BID', $data['batches'])->where("DARID <> '". $data['id']."'")->get();
        }else{
            $query = $this->db->select('DBID')->from('dmpi_dar_batches')->where_in('BID', $data['batches'])->get();
        }
        return $query->result() ? true : false;
    }
    public function post_data($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('acivity_masters', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('acivity_masters', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
    }

    public function check_rate($row, $location){
        $data = [];
        foreach($row as $record){
            $query = 
            $this->db
                ->select('*')
                ->from('rate_masters')
                ->where('TRIM(activity_fr_mg)', trim($record['activity_fr_mg']))
                // ->where('TRIM(costcenter__)', trim($record['costcenter__']))
                ->where('TRIM(gl_fr_mg)', trim($record['gl_fr_mg']))
                ->where('TRIM(location_fr_mg)', trim($location))
                ->where('status', 'active')
                ->order_by('id', 'desc')
                ->limit(1)
                ->get();
            if($query->result()){
                $match = true;
                $notMatched = [];
                foreach($query->result() as $rec){
                    if(round($rec->rd_st, 2) != round($record['rd_st'], 2)){
                        $notMatched['rdstm'] = 'Must be '.round($rec->rd_st, 2);
                    }
                    if(round($rec->rd_ot, 2) != round($record['rd_ot'], 2)){
                        $notMatched['rdotm'] = 'Must be '.round($rec->rd_ot, 2);
                    }
                    if(round($rec->rd_nd, 2) != round($record['rd_nd'], 2)){
                        $notMatched['rdndm'] = 'Must be '.round($rec->rd_nd, 2);
                    }
                    if(round($rec->rd_ndot, 2) != round($record['rd_ndot'], 2)){
                        $notMatched['rdndotm'] = 'Must be '.round($rec->rd_ndot, 2);
                    }
                    if(round($rec->shol_st, 2) != round($record['shol_st'], 2)){
                        $notMatched['sholstm'] = 'Must be '.round($rec->shol_st, 2);
                    }
                    if(round($rec->shol_ot, 2) != round($record['shol_ot'], 2)){
                        $notMatched['sholotm'] = 'Must be '.round($rec->shol_ot, 2);
                    }
                    if(round($rec->shol_nd, 2) != round($record['shol_nd'], 2)){
                        $notMatched['sholndm'] = 'Must be '.round($rec->shol_nd, 2);
                    }
                    if(round($rec->shol_ndot, 2) != round($record['shol_ndot'], 2)){
                        $notMatched['sholndotm'] = 'Must be '.round($rec->shol_ndot, 2);
                    }
                    if(round($rec->shrd_st, 2) != round($record['shrd_st'], 2)){
                        $notMatched['shrdstm'] = 'Must be '.round($rec->shrd_st, 2);
                    }
                    if(round($rec->shrd_ot, 2) != round($record['shrd_ot'], 2)){
                        $notMatched['shrdotm'] = 'Must be '.round($rec->shrd_ot, 2);
                    }
                    if(round($rec->shrd_nd, 2) != round($record['shrd_nd'], 2)){
                        $notMatched['shrdndm'] = 'Must be '.round($rec->shrd_nd, 2);
                    }
                    if(round($rec->shrd_ndot, 2) != round($record['shrd_ndot'], 2)){
                        $notMatched['shrdndotm'] = 'Must be '.round($rec->shrd_ndot, 2);
                    }
                    if(round($rec->rhol_st, 2) != round($record['rhol_st'], 2)){
                        $notMatched['rholstm'] = 'Must be '.round($rec->rhol_st, 2);
                    }
                    if(round($rec->rhol_ot, 2) != round($record['rhol_ot'], 2)){
                        $notMatched['rholotm'] = 'Must be '.round($rec->rhol_ot, 2);
                    }
                    if(round($rec->rhol_nd, 2) != round($record['rhol_nd'], 2)){
                        $notMatched['rholndm'] = 'Must be '.round($rec->rhol_nd, 2);
                    }
                    if(round($rec->rhol_ndot, 2) != round($record['rhol_ndot'], 2)){
                        $notMatched['rholndotm'] = 'Must be '.round($rec->rhol_ndot, 2);
                    }
                    if(round($rec->rhrd_st, 2) != round($record['rhrd_st'], 2)){
                        $notMatched['rhrdstm'] = 'Must be '.round($rec->rhrd_st, 2);
                    }
                    if(round($rec->rhrd_ot, 2) != round($record['rhrd_ot'], 2)){
                        $notMatched['rhrdotm'] = 'Must be '.round($rec->rhrd_ot, 2);
                    }
                    if(round($rec->rhrd_nd, 2) != round($record['rhrd_nd'], 2)){
                        $notMatched['rhrdndm'] = 'Must be '.round($rec->rhrd_nd, 2);
                    }
                    if(round($rec->rhrd_ndot, 2) != round($record['rhrd_ndot'], 2)){
                        $notMatched['rhrdndotm'] = 'Must be '.round($rec->rhrd_ndot, 2);
                    }
                    if(round($rec->rt_st, 2) != round($record['rt_st'], 2)){
                        $notMatched['rtstm'] = 'Must be '.round($rec->rt_st, 2);
                    }
                    if(round($rec->rt_ot, 2) != round($record['rt_ot'], 2)){
                        $notMatched['rtotm'] = 'Must be '.round($rec->rt_ot, 2);
                    }
                    if(round($rec->rt_nd, 2) != round($record['rt_nd'], 2)){
                        $notMatched['rtndm'] = 'Must be '.round($rec->rt_nd, 2);
                    }
                    if(round($rec->rt_ndot, 2) != round($record['rt_ndot'], 2)){
                        $notMatched['rtndotm'] = 'Must be '.round($rec->rt_ndot, 2);
                    }
                }
                if($match){
                    $record['matched'] = true;
                    $record['matchID'] = $query->row()->id;
                    $record['fetchStatus'] = 'fetched';
                    $record['notMatched'] = $notMatched;
                }else{
                    $record['matched'] = false;
                    $record['matchID'] = 0;
                    $record['fetchStatus'] = 'not matched';
                }
            }else{
                $record['matched'] = false;
                $record['matchID'] = 0;
                $record['fetchStatus'] = 'not fetched';
            }
            array_push($data, $record);
            // var_dump($record['matchID']);
        }
        return $data;
    }

    public function save_header($data){
        $sess = $this->session->userdata('gscbilling_session');
        date_default_timezone_set('Asia/Manila');
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('dmpi_dar_hdrs', $data);
            if($this->db->affected_rows()){
                $log = [
                    'dar_id' => $data['id'],
                    'activity' => 'Updated DAR Info',
                    'user' => $sess['fullname'],
                    'log_date' => Date('Y-m-d H:i:s'),
                ];
                $this->db->insert('dar_audit_logs', $log);
                return true;
            }else{
                return false;
            }
        }else{
            $data['adminencodedById'] = $sess['id'];
            $data['adminencodedby'] = $sess['fullname'];
            $this->db->insert('dmpi_dar_hdrs', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                $log = [
                    'dar_id' => $id,
                    'activity' => 'Created',
                    'user' => $sess['fullname'],
                    'log_date' => Date('Y-m-d H:i:s'),
                ];
                $this->db->insert('dar_audit_logs', $log);
                return ['id' => $id];
            }else{
                return false;
            }
        }
    }
    public function save_remarks($data){
        $this->db->where('id', $data['id'])->update('dmpi_dar_hdrs', $data);
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function save_batches($id, $rows){
        $this->db->where('DARID', $id)->delete('dmpi_dar_batches');
        foreach($rows as $record){
            $data = [];
            $data['DARID'] = $id;
            $data['BID'] = $record['BID'];
            $this->db->insert('dmpi_dar_batches', $data);
        }
        return true;
    }
    public function save_details($id, $rows){
        $this->db->where('hdr_id', $id)->delete('dmpi_dar_dtls');
        foreach($rows as $record){
            $data = [];
            $data['hdr_id'] = $id;
            $data['rate_id'] = $record['rate_id'];
            $data['activity'] = $record['activity'];
            $data['accomplished'] = $record['accomplished'];
            $data['headCount'] = $record['headCount'];
            $data['field'] = $record['field'];
            $data['gl'] = $record['gl'];
            $data['cc'] = $record['cc'];
            $data['ccc'] = $record['ccc'];
            $data['ioa'] = $record['ioa'];
            $data['ioc'] = $record['ioc'];
            $data['rdst'] = $record['rdst'];
            $data['rdot'] = $record['rdot'];
            $data['rdnd'] = $record['rdnd'];
            $data['rdndot'] = $record['rdndot'];
            $data['rtst'] = $record['rtst'];
            $data['rtot'] = $record['rtot'];
            $data['rtnd'] = $record['rtnd'];
            $data['rtndot'] = $record['rtndot'];
            $data['sholst'] = $record['sholst'];
            $data['sholot'] = $record['sholot'];
            $data['sholnd'] = $record['sholnd'];
            $data['sholndot'] = $record['sholndot'];
            $data['shrdst'] = $record['shrdst'];
            $data['shrdot'] = $record['shrdot'];
            $data['shrdnd'] = $record['shrdnd'];
            $data['shrdndot'] = $record['shrdndot'];
            $data['rholst'] = $record['rholst'];
            $data['rholot'] = $record['rholot'];
            $data['rholnd'] = $record['rholnd'];
            $data['rholndot'] = $record['rholndot'];
            $data['rhrdst'] = $record['rhrdst'];
            $data['rhrdot'] = $record['rhrdot'];
            $data['rhrdnd'] = $record['rhrdnd'];
            $data['rhrdndot'] = $record['rhrdndot'];
            $data['totalst'] = $record['totalst'];
            $data['totalot'] = $record['totalot'];
            $data['totalnd'] = $record['totalnd'];
            $data['totalndot'] = $record['totalndot'];
            $data['totalAmt'] = $record['totalAmt'];
            $data['c_totalst'] = $record['c_totalst'];
            $data['c_totalot'] = $record['c_totalot'];
            $data['c_totalnd'] = $record['c_totalnd'];
            $data['c_totalndot'] = $record['c_totalndot'];
            $data['c_totalAmt'] = $record['c_totalAmt'];
            $data['vat_rate'] = $record['vat_rate'];
            $data['vat'] = $record['vat'];
            $this->db->insert('dmpi_dar_dtls', $data);
        }
        return true;
    }

    public function save_details_supervisor($data){
        $this->db->where('hdr_id', $data['hdr_id'])->where('detailType <> 2')->delete('dmpi_dar_dtls');
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('dmpi_dar_dtls', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('dmpi_dar_dtls', $data);
            if($this->db->affected_rows()){
                return ['id' => $this->db->insert_id()];
            }else{
                return false;
            }
        }
    }

    public function save_details_incentive($data){
        $this->db->where('hdr_id', $data['hdr_id'])->where('detailType <> 3')->delete('dmpi_dar_dtls');
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('dmpi_dar_dtls', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('dmpi_dar_dtls', $data);
            if($this->db->affected_rows()){
                return ['id' => $this->db->insert_id()];
            }else{
                return false;
            }
        }
    }

    public function save_warnings($id, $rows){
        $this->db->where('hdr_id', $id)->delete('dmpi_dar_warnings');
        foreach($rows as $record){
            $data = [];
            $data['hdr_id'] = $id;
            $data['title'] = $record['error'];
            $data['description'] = $record['description'];
            $data['type'] = $record['type'];
            $this->db->insert('dmpi_dar_warnings', $data);
        }
        return true;
    }
    public function update_payment_acc($amount, $id){
        $this->db->where('SOAID', $id)->where('Client', 'DAR')->delete('soa_accounting_entries');
        $this->db->insert('soa_accounting_entries', ['Debit'=> $amount, 'Client' => 'DAR', 'SOAID' => $id]);
        $this->db->insert('soa_accounting_entries', ['Credit'=> $amount, 'Client' => 'DAR', 'SOAID' => $id]);
        return $this->db->affected_rows() ? true : false;
    }
    public function update_status($status, $id, $data){
        if(count($data) > 0){
           $this->db->where('id', $id)->update('dmpi_dar_hdrs', $data); 
        }
        $sess = $this->session->userdata('gscbilling_session');
        date_default_timezone_set('Asia/Manila');
        if($status === 'confirmed'){
            $log = [
                'dar_id' => $id,
                'activity' => 'Confirmed',
                'user' => $sess['fullname'],
                'log_date' => Date('Y-m-d H:i:s'),
            ];
            $this->db->insert('dar_audit_logs', $log);
            $this->db->where('id', $id)->update('dmpi_dar_hdrs', ['status' => $status, 'ConfirmationBy' => $sess['fullname'], 'ConfirmationDate' => date('Y-m-d h:i:s')]);
        }else{
            $log = [
                'dar_id' => $id,
                'activity' => ucfirst($status),
                'user' => $sess['fullname'],
                'log_date' => Date('Y-m-d H:i:s'),
            ];
            $this->db->insert('dar_audit_logs', $log);
            $this->db->where('id', $id)->update('dmpi_dar_hdrs', ['status' => $status]);
        }
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function reactivate_dar($data){
        $sess = $this->session->userdata('gscbilling_session');
        date_default_timezone_set('Asia/Manila');
        $data['Datetime_reactivation'] = date('Y-m-d h:i:s');
        $data['reactivatedBy'] = $sess['fullname'];
        $data['client'] = 'DAR';
        $this->db->insert('tblreactivatedbilling', $data);
        $log = [
            'dar_id' => $data['id'],
            'activity' => 'Reactivated',
            'user' => $sess['fullname'],
            'log_date' => Date('Y-m-d H:i:s'),
        ];
        $this->db->insert('dar_audit_logs', $log);
        $this->db->where('id', $data['id'])->update('dmpi_dar_hdrs', ['status' => 'active']);
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function delete_data($id){
        $this->db->where('DARID', $id)->delete('dmpi_dar_batches');
        $this->db->where('hdr_id', $id)->delete('dmpi_dar_dtls');
        $this->db->where('hdr_id', $id)->delete('dmpi_dar_warnings');
        $this->db->where('id', $id)->delete('tblreactivatedbilling');
        $this->db->where('dar_id', $id)->delete('dar_audit_logs');
        $this->db->where('id', $id)->delete('dmpi_dar_hdrs');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function delete_supervisor($id){
        $this->db->where('id', $id)->delete('dmpi_dar_dtls');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function delete_incentive($id){
        $this->db->where('id', $id)->delete('dmpi_dar_dtls');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function clear_batch($id, $soa){
        $query = $this->db->select('BID')->from('dmpi_dar_batches')->where('DARID', $id)->get()->result();
        $deleted = false;
        $db2 = $this->load->database('otherdb', TRUE);
        if($query){
            foreach($query as $record){
                $row = $db2->select('BNo')->from('tblbatch')->where('BID', $record->BID)->where("CONCAT(Code_Location, Code_Date, Code_Series) = '".$soa."'")->get()->result();
                if(!$row){
                    $this->db->where('DARID', $id)->where('BID', $record->BID)->delete('dmpi_dar_batches');
                    $deleted = true;
                }
            }
        }
        if($deleted){
            return true;
        }else{
            return false;
        }
    }
}