<?php

Class Activity_Model_OC extends CI_Model {

    public function get_data($client){
        $this->db->select('*');
        $this->db->from('acivity_masters_oc');
        if($client != 'ALL'){
            $this->db->where('client', $client);
        }
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function post_data($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('acivity_masters_oc', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('acivity_masters_oc', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
    }

    public function delete_data($id){
        $this->db->where('id', $id)->delete('acivity_masters_oc');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
}