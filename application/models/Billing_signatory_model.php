<?php

Class Billing_Signatory_Model extends CI_Model {

    public function get_data(){
        $query = $this->db->select('*')->from('billing_signatories')->order_by('lname', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function post_data($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('billing_signatories', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('billing_signatories', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
    }

    public function delete_data($id){
        $this->db->where('id', $id)->delete('billing_signatories');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
}