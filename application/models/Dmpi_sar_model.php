<?php

Class Dmpi_Sar_Model extends CI_Model {

    public function search_header($search){
        $amount = 'SELECT SUM(b.amount) FROM dmpi_sar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
        // $location = "SELECT UCASE(`Location`) FROM 201filedb.tbllocation b WHERE a.locationID = b.LocationID LIMIT 1";
        $query = $this->db->select('*, ('.$amount.') AS amount')->from('dmpi_sars a')->where('YEAR(a.created_at)', $search)->get();
        return $query->result() ? $query->result() : false;
    }
    public function search_transmittal($search){
        $query = $this->db->select('*')->from('dmpi_sar_transmittal')->like('TransmittalNo', $search)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_active(){
        $location = "SELECT UCASE(`Location`) FROM 201filedb.tbllocation b WHERE a.locationID = b.LocationID LIMIT 1";
        $query = $this->db->select('*, ('.$location.') AS Location')->from('dmpi_sars a')->where('a.status', 'active')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_details($id){
        $query = $this->db->select('*')->from('dmpi_sar_dtls')->where('hdr_id', $id)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_transmittal_details($id){
        $amount = 'SELECT SUM(b.amount) FROM dmpi_sar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
        $query = $this->db->select('a.*, ('.$amount.') AS amount')->from('dmpi_sars a')->where('a.transmittal_id', $id)->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_locations(){
        $db2 = $this->load->database('otherdb', TRUE);
        $query = $db2->select("LocationID, UCASE(Location) AS Location, LocPrefix, Code")->from('tbllocation')->order_by('Location', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_activities(){
        $query = $this->db->select("*")->from('sar_rate_masters')->order_by('activity', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_gl_sar(){
        $query = $this->db->select('*')->from('gl_masters')->where('type', 'SAR')->get();
        return $query->result() ? $query->result() : false;
    }

    public function check_soa_no($data){
        if($data['id'] > 0){
            $query = $this->db->select('id')->from('dmpi_sars')->where('soaNumber', $data['soaNumber'])->where("id <> '". $data['id']."'")->get();
        }else{
            $query = $this->db->select('id')->from('dmpi_sars')->where('soaNumber', $data['soaNumber'])->where("id <> ".$data['id'])->get();
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

    public function save_header($data){
        $sess = $this->session->userdata('gscbilling_session');
        if($data['id'] > 0){
            $query = $this->db->select('controlNo')->from('dmpi_sars')->where('controlNo', $data['controlNo'])->where("id <> ".$data['id'])->get()->result();
            if($query){
                return ['exist' => true];
            }
            $data['updated_at'] = Date('Y-m-d h:i:s');
            $this->db->where('id', $data['id'])->update('dmpi_sars', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $query = $this->db->select('controlNo')->from('dmpi_sars')->where('controlNo', $data['controlNo'])->get()->result();
            if($query){
                return ['exist' => true];
            }
            $data['adminencodedById'] = $sess['id'];
            $data['adminencodedby'] = $sess['fullname'];
            $data['created_at'] = Date('Y-m-d h:i:s');
            $data['updated_at'] = Date('Y-m-d h:i:s');
            $this->db->insert('dmpi_sars', $data);
            if($this->db->affected_rows()){
                return ['exist' => false, 'id' => $this->db->insert_id()];
            }else{
                return false;
            }
        }
    }

    public function save_transmittal($data){
        $sess = $this->session->userdata('gscbilling_session');
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('dmpi_sar_transmittal', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $data['transmitted_by_id'] = $sess['id'];
            $data['transmitted_by'] = $sess['fullname'];
            $this->db->insert('dmpi_sar_transmittal', $data);
            if($this->db->affected_rows()){
                return ['id' => $this->db->insert_id()];
            }else{
                return false;
            }
        }
    }

    public function save_details($data){
        if($data['id'] > 0){
            $data['updated_at'] = Date('Y-m-d h:i:s');
            $this->db->where('id', $data['id'])->update('dmpi_sar_dtls', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $data['created_at'] = Date('Y-m-d h:i:s');
            $data['updated_at'] = Date('Y-m-d h:i:s');
            $this->db->insert('dmpi_sar_dtls', $data);
            if($this->db->affected_rows()){
                return ['id' => $this->db->insert_id()];
            }else{
                return false;
            }
        }
    }

    public function update_status($status, $id){
        $this->db->where('id', $id)->update('dmpi_sars', ['status' => $status]);
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function update_transmittal($id, $tid){
        $this->db->where('id', $id)->update('dmpi_sars', ['transmittal_id' => $tid]);
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function reactivate_sar($data){
        $sess = $this->session->userdata('gscbilling_session');
        date_default_timezone_set('Asia/Manila');
        $data['Datetime_reactivation'] = date('Y-m-d h:i:s');
        $data['reactivatedBy'] = $sess['fullname'];
        $data['client'] = 'SAR';
        $this->db->insert('tblreactivatedbilling', $data);
        $this->db->where('id', $data['id'])->update('dmpi_sars', ['status' => 'active']);
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function delete_data($id){
        $this->db->where('hdr_id', $id)->delete('dmpi_sar_dtls');
        $this->db->where('id', $id)->delete('dmpi_sars');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function delete_details($id){
        $this->db->where('id', $id)->delete('dmpi_sar_dtls');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function delete_transmittal($id){
        $this->db->where('transmittal_id', $id)->update('dmpi_sars', ['transmittal_id' => 0]);
        $this->db->where('id', $id)->delete('dmpi_sar_transmittal');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
}