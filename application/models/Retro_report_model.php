<?php

Class Retro_Report_Model extends CI_Model {

    public function get_records($data){
        if($data['client'] == "DAR"){
            $query = $this->db
            ->select('
            a.soaDate,
            a.soaNumber,
            b.activity,
            b.gl,
            b.cc,
            b.headCount,
            b.rdst AS rdst_hrs,
            b.rdot AS rdot_hrs,
            b.rdnd AS rdnd_hrs,
            b.rdndot AS rdndot_hrs,
            b.sholst AS sholst_hrs,
            b.sholot AS sholot_hrs,
            b.sholnd AS sholnd_hrs,
            b.sholndot AS sholndot_hrs,
            b.shrdst AS shrdst_hrs,
            b.shrdot AS shrdot_hrs,
            b.shrdnd AS shrdnd_hrs,
            b.shrdndot AS shrdndot_hrs,
            b.rholst AS rholst_hrs,
            b.rholot AS rholot_hrs,
            b.rholnd AS rholnd_hrs,
            b.rholndot AS rholndot_hrs,
            b.rhrdst AS rhrdst_hrs,
            b.rhrdot AS rhrdot_hrs,
            b.rhrdnd AS rhrdnd_hrs,
            b.rhrdndot AS rhrdndot_hrs,
            c.rd_st AS rdst_old,
            c.rd_ot AS rdot_old,
            c.rd_nd AS rdnd_old,
            c.rd_ndot AS rdndot_old,
            c.shol_st AS sholst_old,
            c.shol_ot AS sholot_old,
            c.shol_nd AS sholnd_old,
            c.shol_ndot AS sholndot_old,
            c.shrd_st AS shrdst_old,
            c.shrd_ot AS shrdot_old,
            c.shrd_nd AS shrdnd_old,
            c.shrd_ndot AS shrdndot_old,
            c.rhol_st AS rholst_old,
            c.rhol_ot AS rholot_old,
            c.rhol_nd AS rholnd_old,
            c.rhol_ndot AS rholndot_old,
            c.rhrd_st AS rhrdst_old,
            c.rhrd_ot AS rhrdot_old,
            c.rhrd_nd AS rhrdnd_old,
            c.rhrd_ndot AS rhrdndot_old,
            d.rd_st AS rdst_new,
            d.rd_ot AS rdot_new,
            d.rd_nd AS rdnd_new,
            d.rd_ndot AS rdndot_new,
            d.shol_st AS sholst_new,
            d.shol_ot AS sholot_new,
            d.shol_nd AS sholnd_new,
            d.shol_ndot AS sholndot_new,
            d.shrd_st AS shrdst_new,
            d.shrd_ot AS shrdot_new,
            d.shrd_nd AS shrdnd_new,
            d.shrd_ndot AS shrdndot_new,
            d.rhol_st AS rholst_new,
            d.rhol_ot AS rholot_new,
            d.rhol_nd AS rholnd_new,
            d.rhol_ndot AS rholndot_new,
            d.rhrd_st AS rhrdst_new,
            d.rhrd_ot AS rhrdot_new,
            d.rhrd_nd AS rhrdnd_new,
            d.rhrd_ndot AS rhrdndot_new,

            ((b.rdst * c.rd_st) - (b.rdst * d.rd_st)) AS rdst_diff,
            ((b.rdot * c.rd_ot) - (b.rdot * d.rd_ot)) AS rdot_diff,
            ((b.rdnd * c.rd_nd) - (b.rdnd * d.rd_nd)) AS rdnd_diff,
            ((b.rdndot * c.rd_ndot) - (b.rdndot * d.rd_ndot)) AS rdndot_diff,

            ((b.sholst * c.shol_st) - (b.sholst * d.shol_st)) AS sholst_diff,
            ((b.sholot * c.shol_ot) - (b.sholot * d.shol_ot)) AS sholot_diff,
            ((b.sholnd * c.shol_nd) - (b.sholnd * d.shol_nd)) AS sholnd_diff,
            ((b.sholndot * c.shol_ndot) - (b.sholndot * d.shol_ndot)) AS sholndot_diff,

            ((b.shrdst * c.shrd_st) - (b.shrdst * d.shrd_st)) AS shrdst_diff,
            ((b.shrdot * c.shrd_ot) - (b.shrdot * d.shrd_ot)) AS shrdot_diff,
            ((b.shrdnd * c.shrd_nd) - (b.shrdnd * d.shrd_nd)) AS shrdnd_diff,
            ((b.shrdndot * c.shrd_ndot) - (b.shrdndot * d.shrd_ndot)) AS shrdndot_diff,

            ((b.rholst * c.rhol_st) - (b.rholst * d.rhol_st)) AS rholst_diff,
            ((b.rholot * c.rhol_ot) - (b.rholot * d.rhol_ot)) AS rholot_diff,
            ((b.rholnd * c.rhol_nd) - (b.rholnd * d.rhol_nd)) AS rholnd_diff,
            ((b.rholndot * c.rhol_ndot) - (b.rholndot * d.rhol_ndot)) AS rholndot_diff,

            ((b.rhrdst * c.rhrd_st) - (b.rhrdst * d.rhrd_st)) AS rhrdst_diff,
            ((b.rhrdot * c.rhrd_ot) - (b.rhrdot * d.rhrd_ot)) AS rhrdot_diff,
            ((b.rhrdnd * c.rhrd_nd) - (b.rhrdnd * d.rhrd_nd)) AS rhrdnd_diff,
            ((b.rhrdndot * c.rhrd_ndot) - (b.rhrdndot * d.rhrd_ndot)) AS rhrdndot_diff,

            ')
            ->from('dmpi_dar_hdrs a')
            ->join('dmpi_dar_dtls b', 'a.id = b.hdr_id', 'inner')
            ->join('rate_masters c', 'c.id = b.rate_id', 'left')
            ->join('retro_dar_rate d', 'a.location = d.location_fr_mg AND b.activity = d.activity_fr_mg AND b.gl = d.gl_fr_mg AND b.cc = d.costcenter__', 'left')
            ->where("a.soaDate BETWEEN '".$data['from']."' AND '".$data['to']."'")
            // ->where("a.location", $data['location'])
            ->get();
            return $query->result() ? $query->result() : false;
            return false;
        }
        
    }

    public function get_uploads($type){
        $query = $this->db->select('date_uploaded_description')->from('retro_slers_rate')->where('status', 'active')->where('date_uploaded_description <>', '')->get();
        return $query->result() ? $query->result() : false;
    }
}