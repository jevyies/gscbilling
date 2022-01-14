<?php

Class Cost_Center_Model extends CI_Model {

    public function get_data(){
        $query = $this->db->select('*')->from('cost_center_masters')->order_by('costcenter', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function post_data($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('cost_center_masters', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('cost_center_masters', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
    }

    public function delete_data($id){
        $this->db->where('id', $id)->delete('cost_center_masters');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
}