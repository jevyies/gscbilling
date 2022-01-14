<?php

Class Monitoring_Report_OC_Model extends CI_Model {

    public function get_records($data){
        if($data['client'] == 'BCC'){
            $Debit = "(SELECT sum(d.total) FROM tbloc_bccdtl d WHERE d.hdr_id=h.TOCSHDR Group by d.hdr_id) as Debit";
            $Checkno = "(SELECT d.CardNo FROM payment_dtl d WHERE d.HDRID=h.PaymentHDRID limit 1) as CheckNo";
            $ORNo = "(SELECT d.ORNo FROM payment_dtl d WHERE d.HDRID=h.PaymentHDRID limit 1) as ORNo";
            $Date = "(SELECT d.PayDate FROM payment_dtl d WHERE d.HDRID=h.PaymentHDRID limit 1) as DatePayment";
            $this->db->select('h.*, '.$Debit.', '.$Checkno.', '.$ORNo.', '.$Date);
            $this->db->from('tbloc_bcchdr h');
            $this->db->where("SUBSTRING(h.period, 1, 4) = '".$data['year']."'");
            $this->db->where("h.Status = 'TRANSMITTED'");
            $this->db->order_by('h.period');
            $query = $this->db->get();
        }elseif($data['client'] == 'SLERS'){
            $Debit = "(SELECT sum(d.total) FROM tbloc_slersdtl d WHERE d.hdr_id=h.TOCSHDR Group by d.hdr_id) as Debit";
            $Checkno = "(SELECT d.CardNo FROM payment_dtl d WHERE d.HDRID=h.PaymentHDRID limit 1) as CheckNo";
            $ORNo = "(SELECT d.ORNo FROM payment_dtl d WHERE d.HDRID=h.PaymentHDRID limit 1) as ORNo";
            $Date = "(SELECT d.PayDate FROM payment_dtl d WHERE d.HDRID=h.PaymentHDRID limit 1) as DatePayment";
            $this->db->select('h.*, '.$Debit.', '.$Checkno.', '.$ORNo.', '.$Date);
            $this->db->from('tbloc_slershdr h');
            $this->db->where("SUBSTRING(h.period, 1, 4) = '".$data['year']."'");
            $this->db->where("h.Status = 'TRANSMITTED'");
            $this->db->order_by('h.period');
            $query = $this->db->get();
        }
        return $query->result() ? $query->result() : false;
    }
}