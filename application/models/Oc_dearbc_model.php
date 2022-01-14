<?php

Class OC_DEARBC_Model extends CI_Model {

    public function get_dearbc(){
        $query = $this->db->select('*')->from('tbloc_dearbc')->order_by('TOCDID', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_header($hdr_id){
        $query = $this->db->select('*')->from('tbloc_dearbchdr')->where("letter_id", $hdr_id)->order_by('SOANo', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_transmittal_details($id){
        $query = $this->db->select('TOCDID as id, transmittal_no, date_transmitted, billing_statement')->from('tbloc_dearbc')->where('TOCDID', $id)->order_by('TOCDID', 'desc')->get();
        return $query->result() ? $query->result() : false;
    }
    
    public function get_detail($hdr_id){
        $query = $this->db->select('*')->from('tbloc_dearbcdtl')->where('hdr_id', $hdr_id)->order_by('Name', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_report_preview($id){
        $query = $this->db->select('*')->from('tbloc_dearbc')->where('TOCDID', $id)->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_letterhead_report($id){
        $query = $this->db->select('*')->from('tbloc_dearbc')->where('TOCDID', $id)->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_total_billing($id){
        $query = $this->db->select('sum(total) as TotalBilling')->from('tbloc_dearbcdtl')->where('hdr_id', $id)->group_by('hdr_id')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_letterhead_detail_report($id){
        $this->db->select("hdr.paystation, (SELECT (sum(d.total) + (sum(d.total) * (hdr.admin_percentage/100))) FROM tbloc_dearbcdtl d WHERE d.hdr_id = hdr.TOCDHDR GROUP BY d.hdr_id) as sumTotal");
        $this->db->from("tbloc_dearbc h, tbloc_dearbchdr hdr");
        $this->db->where("h.TOCDID = hdr.letter_id");
        $this->db->where("h.TOCDID", $id);
        $this->db->order_by("hdr.paystation", "asc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_employee()
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->select('ChapaID_Old, ChapaID_New, LName, FName, MName, ExtName');
        $db2->from('tblemployeemasterfile');
        $db2->order_by('LName', 'asc');
        $db2->order_by('FName', 'asc');
        $query = $db2->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_period()
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->select('xMonth, xYear, xPhase, PeriodFrom, PeriodTo, CONCAT(xPeriod, xPhase) as PayMonthPeriod, xPeriod');
        $db2->from('tblpayrollperiod');
        $db2->order_by("CONCAT(xPeriod, xPhase) DESC");
        $query = $db2->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_linked_data($chapa, $hdr_id)
    {
        $this->db->select("h.PeriodFrom, h.PeriodTo, h.PayMonthPeriod");
        $this->db->from("tbloc_dearbc h, tbloc_dearbchdr hdr");
        $this->db->where("h.TOCDID = hdr.letter_id");
        $this->db->where("hdr.TOCDHDR", $hdr_id);
        $query = $this->db->get();
        if($query->result()){
            $final_array = array(
                'rd_st' => 0,
                'rd_ot' => 0,
                'rd_nd' => 0,
                'rd_ndot' => 0,
                'shol_st' => 0,
                'shol_ot' => 0,
                'shol_nd' => 0,
                'shol_ndot' => 0,
                'rhol_st' => 0,
                'rhol_ot' => 0,
                'rhol_nd' => 0,
                'rhol_ndot' => 0,
                'shrd_st' => 0,
                'shrd_ot' => 0,
                'shrd_nd' => 0,
                'shrd_ndot' => 0,
                'rhrd_st' => 0,
                'rhrd_ot' => 0,
                'rhrd_nd' => 0,
                'rhrd_ndot' => 0,
                'extra' => 0,
                'adjustment' => 0,
                'incentive' => 0,
                'addpay' => 0,
                'silpat' => 0,
                'cola' => 0,
                'sss_ec' => 0,
                'sss_er' => 0,
                'phic_er' => 0,
                'hdmf_er' => 0,
                'mpro' => 0,
            );
            foreach($query->result() as $record){
                $period_from = $record->PeriodFrom;
                $period_to = $record->PeriodTo;
                $PayMonthPeriod = $record->PayMonthPeriod;
                $false1 = false;
                $false2 = false;
                $db2 = $this->load->database('otherdb', TRUE);
                $db2->select('IncomeDetails,PayAmount,WorkHours');
                $db2->from('tblpayslipdtl_income');
                $db2->where("CONCAT(PayMonthYear, PayPeriod) = '" . $PayMonthPeriod . "'");
                $db2->where("ChapaID_Old", $chapa);
                $query = $db2->get();
                if($query){
                    foreach($query->result() as $record){
                        if($record->IncomeDetails == 'BASIC'){
                            $final_array['rd_st'] = $final_array['rd_st'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'OT'){
                            $final_array['rd_ot'] = $final_array['rd_ot'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'ND'){
                            $final_array['rd_nd'] = $final_array['rd_nd'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'ND-OT'){
                            $final_array['rd_ndot'] = $final_array['rd_ndot'] + $record->PayAmount;
                        }
                        // 
                        elseif($record->IncomeDetails == 'SRD/SHOL'){
                            $final_array['shol_st'] = $final_array['shol_st'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'SRD/SHOL-OT'){
                            $final_array['shol_ot'] = $final_array['shol_ot'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'SRD/SHOL-ND'){
                            $final_array['shol_nd'] = $final_array['shol_nd'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'SRD/SHOL-ND-OT'){
                            $final_array['shol_ndot'] = $final_array['shol_ndot'] + $record->PayAmount;
                        }
                        // 
                        elseif($record->IncomeDetails == 'RHOL'){
                            $final_array['rhol_st'] = $final_array['rhol_st'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'RHOL-OT'){
                            $final_array['rhol_ot'] = $final_array['rhol_ot'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'RHOL-ND'){
                            $final_array['rhol_nd'] = $final_array['rhol_nd'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'RHOL-ND-OT'){
                            $final_array['rhol_ndot'] = $final_array['rhol_ndot'] + $record->PayAmount;
                        }
                        // 
                        elseif($record->IncomeDetails == 'SHRD'){
                            $final_array['shrd_st'] = $final_array['shrd_st'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'SHRD-OT'){
                            $final_array['shrd_ot'] = $final_array['shrd_ot'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'SHRD-ND'){
                            $final_array['shrd_nd'] = $final_array['shrd_nd'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'SHRD-ND-OT'){
                            $final_array['shrd_ndot'] = $final_array['shrd_ndot'] + $record->PayAmount;
                        }
                        // 
                        elseif($record->IncomeDetails == 'RHRD'){
                            $final_array['rhrd_st'] = $final_array['rhrd_st'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'RHRD-OT'){
                            $final_array['rhrd_ot'] = $final_array['rhrd_ot'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'RHRD-ND'){
                            $final_array['rhrd_nd'] = $final_array['rhrd_nd'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'RHRD-ND-OT'){
                            $final_array['rhrd_ndot'] = $final_array['rhrd_ndot'] + $record->PayAmount;
                        }
                        // 
                        elseif($record->IncomeDetails == 'Adjustment'){
                            $final_array['adjustment'] = $final_array['adjustment'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'Extra'){
                            $final_array['extra'] = $final_array['extra'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'COLA'){
                            $final_array['cola'] = $final_array['cola'] + $record->PayAmount;
                        }elseif($record->IncomeDetails == 'SIL/PAT'){
                            $final_array['silpat'] = $final_array['silpat'] + $record->PayAmount;
                        }
                    }
                }else{
                    $false1 = true;
                }
                $db2 = $this->load->database('otherdb', TRUE);
                $db2->select('Type, xAmount');
                $db2->from('tblpayslip_ercontribution');
                $db2->where("CONCAT(PayMonthYear, PayPeriod) = '" . $PayMonthPeriod . "'");
                $db2->where("ChapaOld", $chapa);
                $query = $db2->get();
                if($query){
                    foreach($query->result() as $record){
                        if($record->Type == 'SSS CONTRIBUTION ER'){
                            $final_array['sss_er'] = $final_array['sss_er'] + $record->xAmount;
                        }elseif($record->Type == 'SSS CONTRIBUTION EC'){
                            $final_array['sss_ec'] = $final_array['sss_ec'] + $record->xAmount;
                        }elseif($record->Type == 'PHIL HEALTH CONTRIBUTION ER'){
                            $final_array['phic_er'] = $final_array['phic_er'] + $record->xAmount;
                        }elseif($record->Type == 'PAG IBIG CONTRIBUTION ER'){
                            $final_array['hdmf_er'] = $final_array['hdmf_er'] + $record->xAmount;
                        }elseif($record->Type == 'SSS CONTRIBUTION ER MPF'){
                            $final_array['mpro'] = $final_array['mpro'] + $record->xAmount;
                        }
                    }
                }else{
                    $false2 = true;
                }
                if($false1 and $false2){
                    return false;
                }else{
                    return $final_array;
                }
            }
        }else{
            return false;
        }
        return $query->result() ? $query->result() : false;
    }

    public function save_header($data){
        if($data['TOCDHDR'] > 0){
            $this->db->where('TOCDHDR', $data['TOCDHDR'])->update('tbloc_dearbchdr', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('tbloc_dearbchdr', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                // get month
                $year = substr($data['period'], 2, 2);
                $month = substr($data['period'], 4, 2);
                $SOANo = "DEARBC" . $year . $month . "-" . $id;
                $this->db->where('TOCDHDR', $id)->update('tbloc_dearbchdr', ['SOANo' => $SOANo]);
                return ['id' => $id, 'SOANo' => $SOANo];
            }else{
                return false;
            }
        }
        
    }

    public function save_dearbc($data){
        if($data['TOCDID'] > 0){
            $this->db->where('TOCDID', $data['TOCDID'])->update('tbloc_dearbc', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $data['Status'] = 'ACTIVE';
            $this->db->insert('tbloc_dearbc', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
    }

    public function save_detail($data){
        if($data['TODDTL'] > 0){
            $this->db->where('TODDTL', $data['TODDTL'])->update('tbloc_dearbcdtl', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('tbloc_dearbcdtl', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
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

    public function delete_detail($id){
        $this->db->where('TODDTL', $id)->delete('tbloc_dearbcdtl');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

    public function delete_dearbc($id){
        $query = $this->db->select('*')->from('tbloc_dearbchdr')->where('letter_id', $id)->get();
        if($query->result()){
            foreach($query->result() as $record){
                $query = $this->db->select('*')->from('tbloc_dearbcdtl')->where('hdr_id', $record->TOCDHDR)->get();
                if($query->result()){
                    $this->db->where('hdr_id', $record->TOCDHDR)->delete('tbloc_dearbcdtl');
                }
            }
            $this->db->where('letter_id', $id)->delete('tbloc_dearbchdr');
        }

        $this->db->where('TOCDID', $id)->delete('tbloc_dearbc');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

    public function transmit_data($id, $data){
        $this->db->where('TOCDID', $id)->update('tbloc_dearbc', $data);
        return true;
    }

    public function reactivate_data($data){
        $this->db->where('TOCDID', $data['id'])->update('tbloc_dearbc', ['Status' => 'ACTIVE']);
        $this->db->insert('tblreactivatedbilling', $data);
        return true;
    }

    public function save_print_preview($data){
        $this->db->where("TOCDID", $data['TOCDID']);
        $this->db->update("tbloc_dearbc", $data);
        $return_array = [];
        $query = $this->db->select('TOCDHDR')->from('tbloc_dearbchdr')->where('letter_id', $data['TOCDID'])->get();
        if($query->result()){
            foreach($query->result() as $record){
                array_push($return_array, $record);
            }
            return $return_array;
        }else{
            return false;
        }
    }

    public function preview_report_details($id){
        $this->db->select("d.*, h.period_date, h.paystation, h.prepared_by, h.checked_by, h.approved_by, h.admin_percentage");
        $this->db->from("tbloc_dearbchdr h, tbloc_dearbcdtl d");
        $this->db->where("h.TOCDHDR = d.hdr_id");
        $this->db->where("h.TOCDHDR", $id);
        $this->db->order_by("d.Name", "asc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }
}