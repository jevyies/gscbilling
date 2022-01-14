<?php

Class OC_Labnotin_Model extends CI_Model {

    public function get_header(){
        $query = $this->db->select('*')->from('tbloc_labnotinhdr')->order_by('TOCLHDR', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_transmittal_details($id){
        $query = $this->db->select('TOCLHDR as id, transmittal_no, date_transmitted, billing_statement')->from('tbloc_labnotinhdr')->where('TOCLHDR', $id)->order_by('TOCLHDR', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_cc_list(){
        $query = $this->db->select('*')->from('cost_center_masters')->order_by('costcenter', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_gl_list(){
        $query = $this->db->select('*')->from('gl_masters')->order_by('gl', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_detail($id){
        $query = $this->db->select('*')->from('tbloc_labnotindtl')->where('hdr_id', $id)->order_by('Activity', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_total_billing($id){
        $query = $this->db->select('sum(amount_billed) as TotalBilling')->from('tbloc_labnotindtl')->where('hdr_id', $id)->order_by('Activity', 'asc')->group_by('hdr_id')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_report_preview($id){
        $query = $this->db->select('*')->from('tbloc_labnotinhdr')->where('TOCLHDR', $id)->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_report($id){
        // $this->db->select("*, sum(d.hrs) as sum_hrs, sum(amount_billed) as sum_amount");
        $this->db->select("*");
        $this->db->from("tbloc_labnotinhdr h, tbloc_labnotindtl d");
        $this->db->where("h.TOCLHDR", $id);
        $this->db->where("h.TOCLHDR = d.hdr_id");
        // $this->db->group_by("d.Activity");
        // $this->db->group_by("d.gl");
        // $this->db->group_by("d.cc");
        $this->db->order_by("d.Activity", "asc");
        $this->db->order_by("d.gl", "asc");
        $this->db->order_by("d.cc", "asc");
        $this->db->order_by("d.date", "asc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_transmittal_number($id){
        $query = $this->db->select('*')->from('tbloc_labnotinhdr')->where('TOCLHDR', $id)->get();
        return $query->result() ? $query->result() : false;
    }

    public function save_header($data){
        if($data['TOCLHDR'] > 0){
            $this->db->where('TOCLHDR', $data['TOCLHDR'])->update('tbloc_labnotinhdr', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $data['Status'] = 'ACTIVE';
            $this->db->insert('tbloc_labnotinhdr', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                $year = substr($data['period'], 2, 2);
                $SOANo = "LCA" . $year . str_pad($id, 3, "0", STR_PAD_LEFT);
                $this->db->where('TOCLHDR', $id)->update('tbloc_labnotinhdr', ['SOANo' => $SOANo]);
                return ['id' => $id, 'SOANo' => $SOANo];
            }else{
                return false;
            }
        }
    }

    public function save_detail($data){
        if($data['TOCLDTL'] > 0){
            $this->db->where('TOCLDTL', $data['TOCLDTL'])->update('tbloc_labnotindtl', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('tbloc_labnotindtl', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
    }

    public function transmit_data($id, $data){
        $this->db->where('TOCLHDR', $id)->update('tbloc_labnotinhdr', $data);
        return true;
    }

    public function reactivate_data($data){
        $this->db->where('TOCLHDR', $data['id'])->update('tbloc_labnotinhdr', ['Status' => 'ACTIVE']);
        $this->db->insert('tblreactivatedbilling', $data);
        return true;
    }

    public function delete_header($id){
        $query = $this->db->select('*')->from('tbloc_dearbcdtl')->where('hdr_id', $id)->get();
        if($query->result()){
            $this->db->where('hdr_id', $id)->delete('tbloc_dearbcdtl');
        }

        $this->db->where('TOCDHDR', $id)->delete('tbloc_dearbchdr');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

    public function save_print_preview($data){
        $query = $this->db->select('TOCLHDR')->from('tbloc_labnotinhdr')->where("TOCLHDR", $data['TOCLHDR'])->get();
        if($query->result()){
            $this->db->where("TOCLHDR", $data['TOCLHDR'])->update("tbloc_labnotinhdr", $data);
            return true;
        }else{
            return false;
        }
    }

    public function get_transmittal_labnotin($id){
        $total_hrs = "(Select sum(d.hrs) from tbloc_labnotindtl d where h.TOCLHDR = d.hdr_id) as total_hrs";
        $total_amount = "(Select sum(d.amount_billed) from tbloc_labnotindtl d where h.TOCLHDR = d.hdr_id) as total_amount";
        $query = $this->db->select('*, '.$total_hrs.', '.$total_amount)->from('tbloc_labnotinhdr h')->where('TOCLHDR', $id)->get();
        return $query->result() ? $query->result() : false;
    }

    public function save_report_transmittal($data){
        $query = $this->db->select('TOCLHDR')->from('tbloc_labnotinhdr')->where("TOCLHDR", $data['TOCLHDR'])->get();
        if($query->result()){
            $this->db->where("TOCLHDR", $data['TOCLHDR'])->update("tbloc_labnotinhdr", $data);
            return true;
        }else{
            return false;
        }
    }
}