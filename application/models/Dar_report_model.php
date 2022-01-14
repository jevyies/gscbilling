<?php

Class DAR_Report_Model extends CI_Model {

    public function get_data($year, $month, $phase){
        // SELECT b.PayStation, count(b.DEDTLID) as Total, ROUND(sum(b.TotalAmount), 2) as TotalAmount 
        // from tbldarentry_hdr as a, tbldarentry_dtl as b 
        // where a.DEHDRID = b.DEHDRID_Link and 
        // month(b.PeriodDate)='$monthtonum' and year(b.PeriodDate)='$y' and a.Period='$p' and a.Status='POSTED' 
        // group by b.PayStation
        // var_dump($year, $month, $phase);
        $db2 = $this->load->database('otherdb', TRUE);
        $query = $db2
        ->select('b.PayStation, COUNT(b.DEDTLID) AS Total, ROUND(SUM(b.TotalAmount), 2) AS TotalAmount')
        ->from('tbldarentry_hdr a, tbldarentry_dtl as b')
        ->where('a.DEHDRID = b.DEHDRID_Link')
        ->where('MONTH(b.PeriodDate)', $month)
        ->where('YEAR(b.PeriodDate)', $year)
        ->where('a.Period', $phase)
        ->where('a.Status', 'POSTED')
        ->group_by('b.PayStation')
        ->get();
        return $query->result() ? $query->result() : false;
    }

}
