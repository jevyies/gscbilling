<?php

Class B_History_Model extends CI_Model {

    public function get_all_history($type){
        $this->db->select('*');
        if($type == 'TRUCKING'){
            $this->db->from('tbltruckinginventory');
        }else{
            $this->db->from('tblconstructioninventory');
        }
        $this->db->order_by('date_created', "asc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_item_history($type, $id){
        $this->db->select('*');
        if($type == 'TRUCKING'){
            $this->db->from('tbltruckinginventory');
        }else{
            $this->db->from('tblconstructioninventory');
        }
        $this->db->where('ExpenseListID_Link', $id);
        $this->db->order_by('date_created', "asc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_vehicle_history($plate_no){
        $this->db->select('*');
        $this->db->from('tblexpensehdr_trucking h, tblexpensedtl_trucking d');
        $this->db->where('h.EHDRID = d.EHDRID_Link');
        $this->db->where('h.PlateNo', $plate_no);
        $this->db->order_by('h.EHDate', "desc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_project_history($project_name){
        $this->db->select('*');
        $this->db->from('tblexpensehdr_construction h, tblexpensedtl_construction d');
        $this->db->where('h.EHDRID = d.EHDRID_Link');
        $this->db->where('h.ProjectName', $project_name);
        $this->db->order_by('h.EHDate', "desc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }
}