<?php

Class SAR_Volume_Report_Model extends CI_Model {

    public function get_records($data){
        $query = $this->db
        ->select('a.*, b.volumeType, b.controlNo')
        ->from('dmpi_sar_dtls a, dmpi_sars b')
        ->where('a.hdr_id = b.id')
        ->where("b.DateTransmitted BETWEEN '".$data['from']."' AND '".$data['to']."'")
        ->get();
        return $query->result() ? $query->result() : false;
    }
}