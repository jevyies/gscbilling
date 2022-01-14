<?php

Class Rate_Model extends CI_Model {

    public function get_data(){
        $query = $this->db->select("a.*, c.name AS UploadedBy, b.created_at")->from('rate_masters a')->join('dar_upload_rate_history b', 'a.UploadID = b.id', 'left')->join('users c', 'b.UploadedBy = c.id', 'left')->where('a.status', 'active')->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_sar(){
        $query = $this->db->select('*')->from('sar_rate_masters')->where('status', 'active')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_slers(){
        $query = $this->db->select('*')->from('slers_rate_masters')->where('status', 'active')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_bcc(){
        $query = $this->db->select('*')->from('bcc_rate_masters')->where('status', 'active')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_clubhouse(){
        $query = $this->db->select('*')->from('clubhouse_rate_masters')->where('status', 'active')->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_construction(){
        $query = $this->db->select('*')->from('construction_rate_masters')->where('status', 'active')->get();
        return $query->result() ? $query->result() : false;
    }
    public function post_dar($data){
        if($data['id'] > 0){
            $data['status'] = 'active';
            $this->db->where('id', $data['id'])->update('rate_masters', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $data['status'] = 'active';
            $this->db->insert('rate_masters', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
    }
    public function post_sar($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('sar_rate_masters', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('sar_rate_masters', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
    }
    public function post_bcc($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('bcc_rate_masters', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            // check if existing
            $this->db->select('*');
            $this->db->from('bcc_rate_masters');
            $this->db->where('activityID', $data['activityID']);
            $check = $this->db->get();
            if($check->result()){
                foreach($check->result() as $record){
                    $this->db->where('activityID', $data['activityID']);
                    $this->db->update('bcc_rate_masters', array('status'=>'inactive'));
                }
            }
            $data['status'] = 'active';
            $this->db->insert('bcc_rate_masters', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        } 
    }
    public function post_slers($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('slers_rate_masters', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            // check if existing
            $this->db->select('*');
            $this->db->from('slers_rate_masters');
            $this->db->where('activityID', $data['activityID']);
            $check = $this->db->get();
            if($check->result()){
                foreach($check->result() as $record){
                    $this->db->where('activityID', $data['activityID']);
                    $this->db->update('slers_rate_masters', array('status'=>'inactive'));
                }
            }
            $data['status'] = 'active';
            $this->db->insert('slers_rate_masters', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        } 
    }
    public function post_clubhouse($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('clubhouse_rate_masters', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            // check if existing
            $this->db->select('*');
            $this->db->from('clubhouse_rate_masters');
            $this->db->where('activityID', $data['activityID']);
            $check = $this->db->get();
            if($check->result()){
                foreach($check->result() as $record){
                    $this->db->where('activityID', $data['activityID']);
                    $this->db->update('clubhouse_rate_masters', array('status'=>'inactive'));
                }
            }
            $data['status'] = 'active';
            $this->db->insert('clubhouse_rate_masters', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        } 
    }
    public function post_construction($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('construction_rate_masters', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            // check if existing
            $this->db->select('*');
            $this->db->from('construction_rate_masters');
            $this->db->where('activityID', $data['activityID']);
            $check = $this->db->get();
            if($check->result()){
                foreach($check->result() as $record){
                    $this->db->where('activityID', $data['activityID']);
                    $this->db->update('construction_rate_masters', array('status'=>'inactive'));
                }
            }
            $data['status'] = 'active';
            $this->db->insert('construction_rate_masters', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        } 
    }
    public function upload_dar($rows){
        foreach($rows as $record){
            $data = [
                'activity_fr_mg' => preg_replace('/\s+/', ' ',trim($record['activity'])),
                'location_fr_mg' => preg_replace('/\s+/', ' ',trim($record['location'])),
                'gl_fr_mg' => preg_replace('/\s+/', ' ',trim($record['gl'])),
                'costcenter__' => preg_replace('/\s+/', ' ',trim($record['costcenter'])),
                'rd_st' => $record['rd_st'] ? $record['rd_st'] : 0,
                'rd_ot' => $record['rd_ot'] ? $record['rd_ot'] : 0,
                'rd_nd' => $record['rd_nd'] ? $record['rd_nd'] : 0,
                'rd_ndot' => $record['rd_ndot'] ? $record['rd_ndot'] : 0,
                'rt_st' => $record['rt_st'] ? $record['rt_st'] : 0,
                'rt_ot' => $record['rt_ot'] ? $record['rt_ot'] : 0,
                'rt_nd' => $record['rt_nd'] ? $record['rt_nd'] : 0,
                'rt_ndot' => $record['rt_ndot'] ? $record['rt_ndot'] : 0,
                'shol_st' => $record['shol_st'] ? $record['shol_st'] : 0,
                'shol_ot' => $record['shol_ot'] ? $record['shol_ot'] : 0,
                'shol_nd' => $record['shol_nd'] ? $record['shol_nd'] : 0,
                'shol_ndot' => $record['shol_ndot'] ? $record['shol_ndot'] : 0,
                'shrd_st' => $record['shrd_st'] ? $record['shrd_st'] : 0,
                'shrd_ot' => $record['shrd_ot'] ? $record['shrd_ot'] : 0,
                'shrd_nd' => $record['shrd_nd'] ? $record['shrd_nd'] : 0,
                'shrd_ndot' => $record['shrd_ndot'] ? $record['shrd_ndot'] : 0,
                'rhol_st' => $record['rhol_st'] ? $record['rhol_st'] : 0,
                'rhol_ot' => $record['rhol_ot'] ? $record['rhol_ot'] : 0,
                'rhol_nd' => $record['rhol_nd'] ? $record['rhol_nd'] : 0,
                'rhol_ndot' => $record['rhol_ndot'] ? $record['rhol_ndot'] : 0,
                'rhrd_st' => $record['rhrd_st'] ? $record['rhrd_st'] : 0,
                'rhrd_ot' => $record['rhrd_ot'] ? $record['rhrd_ot'] : 0,
                'rhrd_nd' => $record['rhrd_nd'] ? $record['rhrd_nd'] : 0,
                'rhrd_ndot' => $record['rhrd_ndot'] ? $record['rhrd_ndot'] : 0,
                'status' => 'active',
                'created_at' => Date('Y-m-d h:i:s'),
                'updated_at' => Date('Y-m-d h:i:s'),
            ];
            $this->db->insert('rate_masters_1', $data);
        }
        return true;
    }
    public function finalize_upload_dar(){
        date_default_timezone_set('Asia/Manila');
        $sess = $this->session->userdata('gscbilling_session');
        $upload = [
            'UploadedBy' => $sess['id'],
            'status' => 'active',
            'created_at' => Date('Y-m-d H:i:s'),
            'updated_at' => Date('Y-m-d H:i:s'),
        ];
        $this->db->insert('dar_upload_rate_history', $upload);
        $id = $this->db->insert_id();
        // $this->db->where('UploadedBy', $sess['id'])->update('rate_masters', ['status' => 'deactive']);
        $query = $this->db->select('*')
        ->from('rate_masters_1')
        ->group_by('activity_fr_mg')
        ->group_by('location_fr_mg')
        ->group_by('gl_fr_mg')
        ->get();
        if($query->result()){
            foreach($query->result() as $record){
                $data = [
                    'activity_fr_mg' => $record->activity_fr_mg,
                    'location_fr_mg' => $record->location_fr_mg,
                    'gl_fr_mg' => $record->gl_fr_mg,
                    'costcenter__' => $record->costcenter__,
                    'rd_st' => $record->rd_st,
                    'rd_ot' => $record->rd_ot,
                    'rd_nd' => $record->rd_nd,
                    'rd_ndot' => $record->rd_ndot,
                    'rt_st' => $record->rt_st,
                    'rt_ot' => $record->rt_ot,
                    'rt_nd' => $record->rt_nd,
                    'rt_ndot' => $record->rt_ndot,
                    'shol_st' => $record->shol_st,
                    'shol_ot' => $record->shol_ot,
                    'shol_nd' => $record->shol_nd,
                    'shol_ndot' => $record->shol_ndot,
                    'shrd_st' => $record->shrd_st,
                    'shrd_ot' => $record->shrd_ot,
                    'shrd_nd' => $record->shrd_nd,
                    'shrd_ndot' => $record->shrd_ndot,
                    'rhol_st' => $record->rhol_st,
                    'rhol_ot' => $record->rhol_ot,
                    'rhol_nd' => $record->rhol_nd,
                    'rhol_ndot' => $record->rhol_ndot,
                    'rhrd_st' => $record->rhrd_st,
                    'rhrd_ot' => $record->rhrd_ot,
                    'rhrd_nd' => $record->rhrd_nd,
                    'rhrd_ndot' => $record->rhrd_ndot,
                    'status' => 'active',
                    'created_at' => Date('Y-m-d h:i:s'),
                    'updated_at' => Date('Y-m-d h:i:s'),
                    'UploadID' => $id,
                    'UploadedBy' => $sess['id'],
                ];
                $this->db->insert('rate_masters', $data);
            }
            $this->db->truncate('rate_masters_1');
            return true;
        }else{
            return false;
        }
    }
    public function display_uploaded_rate(){
        $sess = $this->session->userdata('gscbilling_session');
        $query = $this->db->select('*')->from('dar_upload_rate_history')->where('UploadedBy', $sess['id'])->order_by('created_at', 'desc')->get()->result();
        return $query ? $query : false;
    }
    public function reactivate_rate($id){
        $sess = $this->session->userdata('gscbilling_session');
        // $this->db->where('UploadedBy', $sess['id'])->update('dar_upload_rate_history', ['status' => 'deactive']);
        $this->db->where('id', $id)->update('dar_upload_rate_history', ['status' => 'active']);
        // $this->db->where('UploadedBy', $sess['id'])->update('rate_masters', ['status' => 'deactive']);
        $this->db->where('UploadID', $id)->update('rate_masters', ['status' => 'active']);
        return true;
    }
    public function delete_dar($id){
        $this->db->where('id', $id)->delete('rate_masters');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
    public function delete_construction($id){
        $this->db->where('id', $id)->delete('construction_rate_masters');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
}