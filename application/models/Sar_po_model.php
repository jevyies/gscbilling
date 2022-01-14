<?php

Class SAR_PO_Model extends CI_Model {

    public function get_data(){
        $query = $this->db->select('*')->from('sar_po_master')->order_by('poNumber', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function post_data($data){
        if($data['id'] > 0){
            $this->db->where('id', $data['id'])->update('sar_po_master', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->insert('sar_po_master', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
    }

    public function delete_data($id){
        $this->db->where('id', $id)->delete('sar_po_master');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
}