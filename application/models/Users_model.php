<?php

Class Users_Model extends CI_Model {

    public function get_data(){
        $query = $this->db->select('*')->from('users')->order_by('name', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function post_data($data){
        date_default_timezone_set('Asia/Manila');
        if($data['id'] > 0){
            $data['updated_at'] = Date('Y-m-d h:i:s');
            $this->db->where('id', $data['id'])->update('users', $data);
            if($this->db->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $password = $data['password'];
            unset($data['password']);
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
            $data['created_at'] = Date('Y-m-d h:i:s');
            $data['updated_at'] = Date('Y-m-d h:i:s');
            $this->db->insert('users', $data);
            if($this->db->affected_rows()){
                $id = $this->db->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
    }
    public function reset_password($id){
        $data['updated_at'] = Date('Y-m-d h:i:s');
        $this->db->where('id', $id)->update('users', ['password' => password_hash('123', PASSWORD_BCRYPT)]);
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

    public function delete_data($id){
        $this->db->where('id', $id)->delete('users');
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
}