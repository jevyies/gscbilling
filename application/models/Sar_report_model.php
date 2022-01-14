<?php

Class SAR_Report_Model extends CI_Model {

    public function get_header($id){
        $query = $this->db
        ->select('*')
        ->from('dmpi_sars')
        ->where('id', $id)
        ->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_records($id){
        $query = $this->db
        ->select('*')
        ->from('dmpi_sar_dtls a')
        ->where('a.hdr_id', $id)
        ->order_by('activity', 'asc')
        ->get();
        return $query->result() ? $query->result() : false;
    }
}