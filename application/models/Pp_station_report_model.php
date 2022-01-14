<?php

Class PP_Station_Report_Model extends CI_Model {

    public function get_data($year, $month, $phase, $station){
        $db2 = $this->load->database('otherdb', TRUE);
        $query = $db2
        ->select("DATE_FORMAT(b.PeriodDate, '%M %d, %Y') as PeriodDate, count(b.DEDTLID) as Total, ROUND(sum(b.TotalAmount), 2) as TotalAmount")
        ->from('tbldarentry_hdr a, tbldarentry_dtl as b')
        ->where('a.DEHDRID = b.DEHDRID_Link')
        ->where('MONTH(b.PeriodDate)', $month)
        ->where('YEAR(b.PeriodDate)', $year)
        ->where('a.Period', $phase)
        ->where('b.PayStation', $station)
        ->where('a.Status', 'POSTED')
        ->group_by('DAY(b.PeriodDate) asc')
        ->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_stations(){
        $query = $this->db->select('PayStation')->from('tblpaystation')->get();
        return $query->result() ? $query->result() : false;
    }
}
