<?php

Class GL_Code_Model extends CI_Model {

    public function get_data($type){
        if($type === 'all'){
            $query = $this->db->select('*')->from('gl_masters')->order_by('gl', 'asc')->get();
        }else{
            $query = $this->db->select('*')->from('gl_masters')->where('type', $type)->order_by('gl', 'asc')->get();
        }
        return $query->result() ? $query->result() : false;
    }

    public function check_gl($data){
        $query = $this->db->select('*')->from('gl_masters')->where('gl', $data['gl'])->where('type', $data['type'])->get();
        return $query->result() ? $query->result() : false;
    }
    public function post_data($data){
        if($data['id'] > 0){
            $data['updated_at'] = Date('Y-m-d h:i:s');
            $this->db->where('id', $data['id'])->update('gl_masters', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $data['created_at'] = Date('Y-m-d h:i:s');
            $data['updated_at'] = Date('Y-m-d h:i:s');
            $this->db->insert('gl_masters', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
    }

    public function delete_data($id){
        $this->db->where('id', $id)->delete('gl_masters');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
}