<?php

Class Login_Model extends CI_Model {

    // Insert registration data in database
    public function login_auth($data) {
        // $this->db->select("ID, UserID");
        // $this->db->from("apvs_xucmpc.tblsalesjournalhdr");
        // $this->db->where_not_in("UserID", array(141,145,146,147));
        // $this->db->group_by("UserID");
        // $query = $this->db->get();
        // // if($query->result()){
        // //     foreach($query->result() as $record){
        // //         // delete dtl
        // //         $this->db->where("CVDHdrIDLink", $record->ID);
        // //         $this->db->delete("apvs_xucmpc.tblsalesjournaldtl");
        // //         // delete hdr
        // //         $this->db->where("ID", $record->ID);
        // //         $this->db->delete("apvs_xucmpc.tblsalesjournalhdr");
        // //     }
        // // }
        // return var_dump($query->result());
        // return var_dump("DONE");
        // $query = $this->db
        // ->select('*')
        // ->from('rate_masters_1')
        // ->group_by('activity_fr_mg')
        // ->group_by('location_fr_mg')
        // ->group_by('gl_fr_mg')
        // ->group_by('costcenter__')
        // ->get();
        // foreach($query->result() as $record){
        //     $this->db->insert('rate_masters', $record);
        // }

        // $query = $this->db
        // ->select('*')
        // ->from('rate_masters')
        // ->group_by('activity_fr_mg')
        // ->get();
        // foreach($query->result() as $record){
        //     $data = [
        //         'activity' => $record->activity_fr_mg,
        //         'created_at' => Date('Y-m-d h:i:s'),
        //         'updated_at' => Date('Y-m-d h:i:s'),
        //     ];
        //     $this->db->insert('acivity_masters', $data);
        // }

        // $query = $this->db
        // ->select('*')
        // ->from('rate_masters')
        // ->group_by('location_fr_mg')
        // ->get();
        // foreach($query->result() as $record){
        //     $data = [
        //         'location' => $record->location_fr_mg,
        //         'created_at' => Date('Y-m-d h:i:s'),
        //         'updated_at' => Date('Y-m-d h:i:s'),
        //     ];
        //     $this->db->insert('location_masters', $data);
        // }

        // $query = $this->db
        // ->select('*')
        // ->from('rate_masters')
        // ->group_by('gl_fr_mg')
        // ->get();
        // foreach($query->result() as $record){
        //     $update = [
        //         'gl' => $record->gl_fr_mg,
        //         'created_at' => Date('Y-m-d h:i:s'),
        //         'updated_at' => Date('Y-m-d h:i:s'),
        //         'type' => 'DAR',
        //     ];
        //     $this->db->insert('gl_masters', $update);
        // }

        // $query = $this->db
        // ->select('*')
        // ->from('rate_masters')
        // ->group_by('costcenter__')
        // ->get();
        // foreach($query->result() as $record){
        //     $update = [
        //         'costcenter' => $record->costcenter__,
        //         'created_at' => Date('Y-m-d h:i:s'),
        //         'updated_at' => Date('Y-m-d h:i:s'),
        //     ];
        //     $this->db->insert('cost_center_masters', $update);
        // }

        // $activity = 'SELECT id FROM acivity_masters b WHERE a.activity_fr_mg = b.activity GROUP BY b.activity';
        // $location = 'SELECT LocationID FROM 201filedb.tbllocation c WHERE a.location_fr_mg = c.Location GROUP BY c.Location';
        // $costcenter = 'SELECT id FROM cost_center_masters d WHERE a.costcenter__ = d.costcenter GROUP BY d.costcenter';
        // $gl = 'SELECT id FROM gl_masters e WHERE a.gl_fr_mg = e.gl GROUP BY e.gl';
        // $query = $this->db
        // ->select('a.id, ('.$activity.') AS activityID, ('.$costcenter.') AS costCenterID, ('.$gl.') AS glID, ('.$location.') AS locationID')
        // ->from('rate_masters a')
        // ->get();
        // foreach($query->result() as $record){
        //     $update = [
        //         'activityID' => $record->activityID,
        //         'costCenterID' => $record->costCenterID,
        //         'glID' => $record->glID,
        //         'locationID' => $record->locationID,
        //         'created_at' => Date('Y-m-d h:i:s'),
        //         'updated_at' => Date('Y-m-d h:i:s'),
        //         'status' => 'active',
        //     ];
        //     $this->db->where('id', $record->id)->update('rate_masters', $update);
        // }
        // $query = $this->db
        // ->select('id, activity')
        // ->from('acivity_masters')
        // ->get();
        // foreach($query->result() as $record){
        //     $update = [
        //         'activity' => ltrim($record->activity),
        //     ];
        //     $this->db->where('id', $record->id)->update('acivity_masters', $update);
        // }
        $condition = "email =" . "'" . $data['username'] . "'";
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($condition);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return array('username' => false, 'password' => true, 'result' => []);
        }else{
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where("email ='" . $data['username'] . "'");
            $query = $this->db->get();
            if ($query->num_rows() == 0) {
                return array('password' => false, 'username' => true, 'result' => []);
            }else{
                foreach($query->result() as $record){
                    if(password_verify($data['password'], $record->password)){
                        return array('password' => true, 'username' => true, 'result' => $query->result());
                    }else{
                        return array('password' => false, 'username' => true, 'result' => []);
                    }
                    break;
                }
            }
        }
    }

    public function get_formlist($id){
        $condition = "userID = " . $id;
        $this->db->select('*');
        $this->db->from('tbluseraccessrights');
        $this->db->where($condition);
        $query = $this->db->get();
        $record_holder = array();
        if($query->result()){
            foreach($query->result() as $item){
                array_push($record_holder, $item->formID);
            } 
            return $record_holder;
        }else{
            return false;
        }
        
    }
    public function get_menu_not_allowed(){
        $sess = $this->session->userdata('gscbilling_session');
        $menu = "SELECT AccessRghtsFormID FROM tbluseraccessrights b WHERE AccessRghtsUserID = " . $sess['id'];
        $query = $this->db->select("*")->from('tblformlist a')->where("a.FormID NOT IN(". $menu .")")->get();
        return $query->result() ? $query->result() : "";
    }
    public function restriction_auth($data){
        $condition1 = "email = '" . $data['username'] . "'";
        $condition2 = "password = '" . $data['password'] . "'";
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($condition1);
        $this->db->where('role_id', '1');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->result()){
            foreach($query->result() as $record){
                if(password_verify($data['password'], $record->password)){
                    return true;
                }
                break;
            }
        }else{
            return false;
        }
    }

    public function get_menu_allowed(){
        $sess = $this->session->userdata('gscbilling_session');
        $query = $this->db
        ->select('b.*')
        ->from('tbluseraccessrights a, tblformlist b')
        ->where('a.AccessRghtsUserID', $sess['id'])
        ->where('a.AccessRghtsFormID = b.FormID')
        ->get();
        return $query->result() ? $query->result() : false;
    }

    public function update_user($data, $password) {
        $sess = $this->session->userdata('gscbilling_session');
        $username = $this->db
        ->select('Username')
        ->from('users')
        ->where('Username', $data['Username'])
        ->where("LoginID <> '". $sess['id']. "'")
        ->get();
        if($username->result()){
            return array('username' => true, 'password' => false);
        }
        $this->db->select('Password');
        $this->db->from('users');
        $this->db->where('LoginID', $sess['id']);
        $query = $this->db->get();
        if ($query->result()) {
            $password = true;
            foreach($query->result() as $record){
                if($record->Password != $password){
                    $password = false;
                }
            }
            if(!$password){
                return array('password' => true, 'username' => false);
            }
            $this->db->where('LoginID', $sess['id']);
            $this->db->update('users', $data);
            return true;
        }else {
            return false;
        }
    }

    public function update_password($data, $old){
        $sess = $this->session->userdata('gscbilling_session');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $sess['id']);
        $query = $this->db->get();
        if ($query->result()) {
            $password = true;
            foreach($query->result() as $record){
                if(!password_verify($old, $record->password)){
                    $password = false;
                }
                break;
            }
            if(!$password){
                return array('password' => true);
            }
            $this->db->where('id', $sess['id']);
            $this->db->update('users', ['password' => password_hash($data['Password'], PASSWORD_BCRYPT)]);
            return true;
        }else {
            return false;
        }
    }

    public function save_profile($data, $password){
        $sess = $this->session->userdata('gscbilling_session');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('LoginID', $sess['id']);
        $query = $this->db->get();
        if ($query->result()) {
            $password = true;
            foreach($query->result() as $record){
                if($record->Password != $password){
                    $password = false;
                }
            }
            if(!$password){
                return array('password' => true);
            }
            $this->db->where('LoginID', $sess['id']);
            $this->db->update('users', $data);
            return true;
        }else {
            return false;
        }
    }

    public function get_form_list($id){
        $sess = $this->session->userdata('gscbilling_session');
        if($sess['role'] == 1){
            $query = $this->db->select('FormControlID as AccessRghtsFormID')->from('tblformlist')->get()->result();
        }else{
            $query = $this->db->select('AccessRghtsFormID')->from('tbluseraccessrights')->where('AccessRghtsUserID', $id)->get()->result();
        }
        $record_holder = array();
        if($query){
            foreach($query as $item){
                array_push($record_holder, $item->AccessRghtsFormID);
            } 
            return $record_holder;
        }else{
            return [];
        }
    }

    public function do_query(){
        // $this->db->where('uploaded', 1)->delete('dmpi_dar_hdrs');
        // $this->db->where('uploaded', 1)->delete('dmpi_dar_dtls');
        // $query1 = $this->db->select("*")->from('dmpi_dar_hdrs')->where('pmy', '')->get()->result();
        // if($query1){
        //     foreach($query1 as $record){
        //         $this->db->where('hdr_id', $record->id)->delete('dmpi_dar_dtls');
        //         $this->db->where('id', $record->id)->delete('dmpi_dar_hdrs');
        //     }
        // }
        // $query2 = $this->db->select("*")->from('dmpi_dar_hdrs')->where('pmy', '202012')->get()->result();
        // if($query2){
        //     foreach($query2 as $record){
        //         $this->db->where('hdr_id', $record->id)->delete('dmpi_dar_dtls');
        //         $this->db->where('id', $record->id)->delete('dmpi_dar_hdrs');
        //     }
        // }
        // $query3 = $this->db->select("*")->from('dmpi_dar_hdrs')->where('pmy', '202011')->get()->result();
        // if($query3){
        //     foreach($query3 as $record){
        //         $this->db->where('hdr_id', $record->id)->delete('dmpi_dar_dtls');
        //         $this->db->where('id', $record->id)->delete('dmpi_dar_hdrs');
        //     }
        // }
        // $query1 = $this->db->select('*')->from('dar_pending_upload_recon')->get()->result();
        // $soa = '';
        // $transmittal = '';
        // $hdr_id = 0;
        // foreach($query1 as $row){
        //     if($soa != $row->soa_no){
        //         $hdr = [
        //             'pmy' => Date('Ym', strtotime($row->doc_date)),
        //             'soaNumber' => $row->soa_no,
        //             'soaDate' => $row->doc_date,
        //             'TransmittedDate' => $row->date_transmitted ? $row->date_transmitted : '0000-00-00',
        //             'SupervisorDate' => $row->date_supervisor ? $row->date_supervisor : '0000-00-00',    
        //             'ManagerDate' => $row->date_manager ? $row->date_manager : '0000-00-00',    
        //             'DataControllerDate' => $row->date_controller ? $row->date_controller : '0000-00-00',    
        //             'BillingClerkDate' => $row->date_billing ? $row->date_billing : '0000-00-00',    
        //             'DMPIReceivedDate' => $row->date_accounting ? $row->date_accounting : '0000-00-00',    
        //             'TransmittalNo' => $row->transmittal_no,
        //             'location' => $row->department,
        //             'status' => 'PRINTED TRANSMITTAL',
        //             'nonBatch' => 1,
        //             'uploaded' => 3
        //         ];
        //         $day = Date('d', strtotime($row->doc_date));
        //         if($day < 16){
        //             $hdr['period'] = 1;
        //         }else{
        //             $hdr['period'] = 2;
        //         }
        //         $this->db->insert('dmpi_dar_hdrs', $hdr);
        //         $hdr_id = $this->db->insert_id();
        //         $soa = $row->soa_no;
        //     }
        //     $total_st = 
        //         ($row->rdst_amt * $row->rdst_rate) + 
        //         ($row->sholst_amt * $row->sholst_rate) + 
        //         ($row->shrdst_amt * $row->shrdst_rate) +
        //         ($row->rholst_amt * $row->rholst_rate) + 
        //         ($row->rhrdst_amt * $row->rhrdst_rate);

        //     $total_ot = 
        //         ($row->rdot_amt * $row->rdot_rate) + 
        //         ($row->sholot_amt * $row->sholot_rate) + 
        //         ($row->shrdot_amt * $row->shrdot_rate) +
        //         ($row->rholot_amt * $row->rholot_rate) + 
        //         ($row->rhrdot_amt * $row->rhrdot_rate);

        //     $total_nd = 
        //         ($row->rdnd_amt * $row->rdnd_rate) + 
        //         ($row->sholnd_amt * $row->sholnd_rate) + 
        //         ($row->shrdnd_amt * $row->shrdnd_rate) +
        //         ($row->rholnd_amt * $row->rholnd_rate) + 
        //         ($row->rhrdnd_amt * $row->rhrdnd_rate);

        //     $total_ndot = 
        //         ($row->rdndot_amt * $row->rdndot_rate) + 
        //         ($row->sholndot_amt * $row->sholndot_rate) + 
        //         ($row->shrdndot_amt * $row->shrdndot_rate) +
        //         ($row->rholndot_amt * $row->rholndot_rate) + 
        //         ($row->rhrdndot_amt * $row->rhrdndot_rate);
            
        //     $c_totalAmt = $total_st + $total_ot + $total_nd + $total_ndot;
        //     $dtl = [
        //         'hdr_id' => $hdr_id,
        //         'activity' => $row->activity,
        //         'field' => $row->field,
        //         'accomplished' => preg_replace("/[^0-9]/", "", $row->has_tons),
        //         'gl' => $row->gl,
        //         'cc' => $row->cc,
        //         'rdst' => $row->rdst_amt,
        //         'rdot' => $row->rdot_amt,
        //         'rdnd' => $row->rdnd_amt,
        //         'rdnd' => $row->rdndot_amt,
        //         'sholst' => $row->sholst_amt,
        //         'sholot' => $row->sholot_amt,
        //         'sholnd' => $row->sholnd_amt,
        //         'sholnd' => $row->sholndot_amt,
        //         'shrdst' => $row->shrdst_amt,
        //         'shrdot' => $row->shrdot_amt,
        //         'shrdnd' => $row->shrdnd_amt,
        //         'shrdnd' => $row->shrdndot_amt,
        //         'rholst' => $row->rholst_amt,
        //         'rholot' => $row->rholot_amt,
        //         'rholnd' => $row->rholnd_amt,
        //         'rholnd' => $row->rholndot_amt,
        //         'rhrdst' => $row->rhrdst_amt,
        //         'rhrdot' => $row->rhrdot_amt,
        //         'rhrdnd' => $row->rhrdnd_amt,
        //         'rhrdnd' => $row->rhrdndot_amt,
        //         'totalst' => $row->total_st,
        //         'totalot' => $row->total_ot,
        //         'totalnd' => $row->total_nd,
        //         'totalnd' => $row->total_ndot,
        //         'c_totalst' => $total_st,
        //         'c_totalot' => $total_ot,
        //         'c_totalnd' => $total_nd,
        //         'c_totalnd' => $total_ndot,
        //         'c_totalAmt' => $c_totalAmt,
        //         'totalAmt' => $row->total_amt,
        //         'headCount' => $row->hc,
        //         'uploaded' => 3
        //     ];
        //     $this->db->insert('dmpi_dar_dtls', $dtl);
        // }
        // $query = $this->db->select("*")->from('dmpi_sar_dtls')->get()->result();
        // foreach($query as $rec){
        //     $po = $this->db->select('id')->from('sar_po_master')->where('poNumber', $rec->poNumber)->like('dayType', 'REGULAR')->get()->result();
        //     $this->db->where('id', $rec->id)->update('dmpi_sar_dtls', ['poID' => $po[0]->id]);
        // }
        // copying totalAmt to c_totalAmt
        // $query = $this->db->select("*")->from('dmpi_dar_dtls')->where('uploaded > 0')->get()->result();
        // foreach($query as $q){
        //     $this->db->where('id', $q->id)->update('dmpi_dar_dtls', ['c_totalAmt' => $q->totalAmt]);
        // }
        // $query = $this->db->select('id, shol_st, shol_ot, shol_nd, shol_ndot')->from('rate_masters')->get()->result();
        // foreach($query as $rec){
        //     $this->db->where('id', $rec->id)->update('rate_masters', 
        //     [
        //         'rt_st' => $rec->shol_st,
        //         'rt_ot' => $rec->shol_ot,
        //         'rt_nd' => $rec->shol_nd,
        //         'rt_ndot' => $rec->shol_ndot,
        //     ]);
        // }
        // $query = $this->db->select('*')->from('dar_payment_link')->get()->result();
        // foreach($query as $rec){
        //     $query1 = $this->db->select('PDTLID')->from('payment_dtl')->where('PDTLID', $rec->PDTLID)->get()->result();
        //     if(!$query1){
        //         $this->db->where('dpl_id', $record->dpl_id)->delete('dar_payment_link');
        //     }
        // }
        return true;
    }
}