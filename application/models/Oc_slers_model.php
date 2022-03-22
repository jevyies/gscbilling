<?php

Class OC_Slers_Model extends CI_Model {

    public function get_header(){
        $query = $this->db->select('*')->from('tbloc_slershdr')->order_by('TOCSHDR', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_transmittal_details($id){
        $query = $this->db->select('TOCSHDR as id, transmittal_no, date_transmitted, billing_statement')->from('tbloc_slershdr')->where('TOCSHDR', $id)->order_by('TOCSHDR', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_detail($id){
        $query = $this->db->select('*')->from('tbloc_slersdtl')->where('hdr_id', $id)->order_by('Activity', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_total_billing($id){
        $query = $this->db->select('sum(total) as TotalBilling')->from('tbloc_slersdtl')->where('hdr_id', $id)->order_by('Activity', 'asc')->group_by('hdr_id')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_rates($id){
        $query = $this->db->select('*')->from('slers_rate_masters')->where('activityID', $id)->where('status', 'active')->limit(1)->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_rates_selected($id){
        $query = $this->db->query("SELECT * FROM slers_rate_masters WHERE id IN(SELECT activity_id FROM tbloc_slersdtl WHERE hdr_id = " . $id . " GROUP BY activity_id) AND status = 'active' ORDER BY activity_fr_mg");
        return $query->result() ? $query->result() : false;
    }

    public function get_payroll_period(){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->select("*");
        $db2->from("tblpayrollperiod");
        $db2->order_by("CONCAT(xPeriod,xPhase) DESC");
        $query = $db2->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_report_preview($id){
        $total_amount = "(SELECT sum(d.total) FROM tbloc_slersdtl d WHERE d.hdr_id = h.TOCSHDR GROUP BY d.hdr_id) as Total_Billing";
        $query = $this->db->select('h.*,' . $total_amount)->from('tbloc_slershdr h')->where('h.TOCSHDR', $id)->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_report($id){
        $this->db->select("h.*, d.*, r.rd_st as rd_st_r, r.rd_ot as rd_ot_r, r.rd_nd as rd_nd_r, r.rd_ndot as rd_ndot_r, r.shol_st as shol_st_r, r.shol_ot as shol_ot_r, r.shol_nd as shol_nd_r, r.shol_ndot as shol_ndot_r, r.shrd_st as shrd_st_r, r.shrd_ot as shrd_ot_r, r.shrd_nd as shrd_nd_r, r.shrd_ndot as shrd_ndot_r, r.rhol_st as rhol_st_r, r.rhol_ot as rhol_ot_r, r.rhol_nd as rhol_nd_r, r.rhol_ndot as rhol_ndot_r, r.rhrd_st as rhrd_st_r, r.rhrd_ot as rhrd_ot_r, r.rhrd_nd as rhrd_nd_r, r.rhrd_ndot as rhrd_ndot_r, r.rhol_st2x as rhol_st2x_r, r.rhol_ot2x as rhol_ot2x_r, r.rhol_nd2x as rhol_nd2x_r, r.rhol_ndot2x as rhol_ndot2x_r, r.rholrd_st2x as rholrd_st2x_r, r.rholrd_ot2x as rholrd_ot2x_r, r.rholrd_nd2x as rholrd_nd2x_r, r.rholrd_ndot2x as rholrd_ndot2x_r");
        $this->db->from("tbloc_slershdr h, tbloc_slersdtl d, slers_rate_masters r");
        $this->db->where("h.TOCSHDR", $id);
        $this->db->where("h.TOCSHDR = d.hdr_id");
        $this->db->where("d.activity_id = r.id");
        $this->db->order_by("d.Activity", "asc");
        $this->db->order_by("d.Name", "asc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function save_header($data){
        if($data['TOCSHDR'] > 0){
            $this->db->where('TOCSHDR', $data['TOCSHDR'])->update('tbloc_slershdr', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $data['Status'] = 'ACTIVE';
            $this->db->insert('tbloc_slershdr', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                // get month
                $year = substr($data['period'], 0, 4);
                $month = substr($data['period'], 4, 2);
                $ext = substr($data['period'], 6);
                $SOANo = "SLERS" . $year . $month . str_pad($ext, 2, "0", STR_PAD_LEFT);
                $this->db->where('TOCSHDR', $id)->update('tbloc_slershdr', ['SOANo' => $SOANo]);
                return ['id' => $id, 'SOANo' => $SOANo];
            }else{
                return false;
            }
        }
    }

    public function save_detail($data){
        if($data['TOSDTL'] > 0){
            $this->db->where('TOSDTL', $data['TOSDTL'])->update('tbloc_slersdtl', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('tbloc_slersdtl', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
    }

    public function transmit_data($id, $data){
        $this->db->where('TOCSHDR', $id)->update('tbloc_slershdr', $data);
        return true;
    }

    public function reactivate_data($data){
        $this->db->where('TOCSHDR', $data['id'])->update('tbloc_slershdr', ['Status' => 'ACTIVE']);
        $this->db->insert('tblreactivatedbilling', $data);
        return true;
    }

    public function delete_header($id){
        $query = $this->db->select('*')->from('tbloc_slersdtl')->where('hdr_id', $id)->get();
        if($query->result()){
            $this->db->where('hdr_id', $id)->delete('tbloc_slersdtl');
        }

        $this->db->where('TOCSHDR', $id)->delete('tbloc_slershdr');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

    public function delete_detail($id){
        $this->db->where('TOSDTL', $id)->delete('tbloc_slersdtl');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

    public function save_print_preview($data){
        $query = $this->db->select('TOCSHDR')->from('tbloc_slershdr')->where("TOCSHDR", $data['TOCSHDR'])->get();
        if($query->result()){
            $this->db->where("TOCSHDR", $data['TOCSHDR'])->update("tbloc_slershdr", $data);
            return true;
        }else{
            return false;
        }
    }
}