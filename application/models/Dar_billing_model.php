<?php

Class DAR_Billing_Model extends CI_Model {

    public function get_header($id){
        $query = $this->db
        ->select('*')
        ->from('dmpi_dar_hdrs')
        ->where('id', $id)
        ->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_records($id){
        $query = $this->db
        ->select('*')
        ->from('dmpi_dar_dtls a, rate_masters b')
        ->where('a.rate_id = b.id')
        ->where('a.hdr_id', $id)
        ->get();
        return $query->result() ? $query->result() : false;
    }
}