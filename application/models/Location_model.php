<?php

Class Location_Model extends CI_Model {

    public function get_data(){
        $db2 = $this->load->database('otherdb', TRUE);
        $query = $db2->select('*')->from('tbllocation')->order_by('Location', 'asc')->get();
        return $query->result() ? $query->result() : false;
    }

    public function post_data($data){
        $db2 = $this->load->database('otherdb', TRUE);
        if($data['LocationID'] > 0){
            $db2->where('LocationID', $data['LocationID'])->update('tbllocation', $data);
            if($db2->affected_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            $db2->insert('tbllocation', $data);
            if($db2->affected_rows()){
                $id = $db2->insert_id();
                return ['id' => $id];
            }else{
                return false;
            }
        }
        
    }

    public function delete_data($id){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('LocationID', $id)->delete('tbllocation');
        if($db2->affected_rows()){
            return true;
        }else{
            return false;
        }
    }
}