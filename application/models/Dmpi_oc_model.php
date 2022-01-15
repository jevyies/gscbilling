<?php

Class DMPI_OC_Model extends CI_Model {

    public function get_transmittal($from, $to, $type){
        $this->db->select('a.id AS HdrID, a.TransmittalNo')->from('dmpi_dar_hdrs a')->where("a.soaDate BETWEEN '".$from."' AND '".$to."'")->where('a.status', 'transmitted');
        if($type == 1){
            $this->db->limit(1);
        }
        $query = $this->db->get();
        if($query->result()){
            $result = [];
            foreach($query->result() as $record){
                $dtls = $this->db->select('*, a.id AS headerID')->from('dmpi_dar_hdrs a, dmpi_dar_dtls b, rate_masters c, 201filedb.tblbatch d')
                ->where('b.rate_id = c.id')
                ->where('a.id = b.hdr_id')
                ->where('a.batcIDLink = d.BID')
                ->where('a.id', $record->HdrID)
                ->order_by('a.id', 'asc')
                ->get();
                array_push($result, 
                [ 
                    'hdr_id' => $record->HdrID, 
                    'TransmittalNo' => $record->TransmittalNo,
                    'dtls' => $dtls->result() ? $dtls->result() : [] 
                ]);
            }
            return $result;
        }else{
            return false;
        }
    }
    public function get_transmittal_no($No, $type){
        $Location = 'SELECT `Location` FROM 201filedb.tblbatch d, dmpi_dar_batches e WHERE e.DARID = a.id AND e.BID = d.BID LIMIT 1';
        $this->db
        ->select('a.id AS HdrID, a.TransmittalNo, a.detailType')
        ->from('dmpi_dar_hdrs a')
        ->where("a.TransmittalNo", $No)
        ->where_in('a.status', ['transmitted', 'confirmed', 'PRINTED TRANSMITTAL']);
        if($type == 1){
            $this->db->limit(1);
        }
        $query = $this->db->get();
        if($query->result()){
            $result = [];
            foreach($query->result() as $record){
                if($record->detailType == 1){
                    $dtls = $this->db->select('*, 
                    a.id AS headerID, ('.$Location.') AS Location')
                    ->from('dmpi_dar_hdrs a, dmpi_dar_dtls b')
                    ->where('a.id = b.hdr_id')
                    ->where('a.id', $record->HdrID)
                    ->join('rate_masters c', 'c.id = b.rate_id', 'left')
                    ->order_by('a.id', 'asc')
                    ->get();
                }else{
                    $dtls = $this->db->select('*, a.id AS headerID, 
                    ('.$Location.') AS Location,
                    rdst AS rd_st,
                    rdot AS rd_ot,
                    rdnd AS rd_nd,
                    rdndot AS rd_ndot,

                    rtst AS rt_st,
                    rtot AS rt_ot,
                    rtnd AS rt_nd,
                    rtndot AS rt_ndot,

                    sholst AS shol_st,
                    sholot AS shol_ot,
                    sholnd AS shol_nd,
                    sholndot AS shol_ndot,

                    shrdst AS shrd_st,
                    shrdot AS shrd_ot,
                    shrdnd AS shrd_nd,
                    shrdndot AS shrd_ndot,

                    rholst AS rhol_st,
                    rholot AS rhol_ot,
                    rholnd AS rhol_nd,
                    rholndot AS rhol_ndot,

                    rhrdst AS rhrd_st,
                    rhrdot AS rhrd_ot,
                    rhrdnd AS rhrd_nd,
                    rhrdndot AS rhrd_ndot
                    ')->from('dmpi_dar_hdrs a, dmpi_dar_dtls b')
                    ->where('a.id = b.hdr_id')
                    ->where('a.id', $record->HdrID)
                    ->order_by('a.id', 'asc')
                    ->get();
                }
                array_push($result, [ 'hdr_id' => $record->HdrID, 'TransmittalNo' => $record->TransmittalNo, 'dtls' => $dtls->result() ? $dtls->result() : [] ]);
            }
            return $result;
        }else{
            return false;
        }
    }
    public function get_transmittal_summary($No, $type){
        $Amount = 'SELECT SUM(totalAmt) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
        $ST = 'SELECT SUM(IFNULL(rdst, 0) + IFNULL(sholst, 0) + IFNULL(shrdst, 0) + IFNULL(rholst, 0) + IFNULL(rhrdst, 0)) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
        $OT = 'SELECT SUM(IFNULL(rdot, 0) + IFNULL(sholot, 0) + IFNULL(shrdot, 0) + IFNULL(rholot, 0) + IFNULL(rhrdot, 0)) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
        $ND = 'SELECT SUM(IFNULL(rdnd, 0) + IFNULL(sholnd, 0) + IFNULL(shrdnd, 0) + IFNULL(rholnd, 0) + IFNULL(rhrdnd, 0)) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
        $NDOT = 'SELECT SUM(IFNULL(rdndot, 0) + IFNULL(sholndot, 0) + IFNULL(shrdndot, 0) + IFNULL(rholndot, 0) + IFNULL(rhrdndot, 0)) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
        $HC = 'SELECT SUM(headCount) FROM dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id';
        $Location = 
        "CASE
            WHEN nonBatch = 1 THEN (SELECT `location` FROM dmpi_dar_hdrs b WHERE a.id = b.id LIMIT 1)
            WHEN nonBatch = 0 THEN (SELECT `Location` FROM dmpi_dar_batches b, 201filedb.tblbatch c WHERE a.id = b.DARID AND b.BID = c.BID LIMIT 1)
        END";
        $this->db
        ->select('*, ('.$Amount.') AS TotalAmt, ('.$ST.') AS gt_st, ('.$OT.') AS gt_ot, ('.$ND.') AS gt_nd, ('.$NDOT.') AS gt_ndot, ('.$HC.') AS HC, ('.$Location.') AS Location')
        ->from('dmpi_dar_hdrs a')
        ->where('TransmittalNo', $No)
        ->where_in('status', ['transmitted', 'confirmed', 'PRINTED TRANSMITTAL']);
        // ->order_by('soaDate', 'desc');
        if($type == 1){
            $this->db->limit(1);
        }
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_transmittal_info($No){
        $query = $this->db->select('*')->from('dar_transmittal')->where('TransmittalNo', $No)->order_by('id', 'desc')->limit(1)->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_sar_report($from, $to, $type){
        $qty = 'SELECT SUM(dtl.qty) FROM dmpi_sar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        $rate = 'SELECT SUM(dtl.rate) FROM dmpi_sar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        $amount = 'SELECT SUM(dtl.amount) FROM dmpi_sar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        $this->db
        ->select("hdr.id, hdr.soaNumber, (".$qty.") AS Qty, (".$rate.") AS rate, (".$amount.") AS total")
        ->from('dmpi_sars hdr, tblreactivatedbilling d')
        ->where('d.id = hdr.id')
        ->where('d.client', 'SAR')
        ->where("d.Datetime_reactivation BETWEEN '" . $from . " 00:00:00' AND '" . $to . " 23:59:59'")
        ->group_by('d.id');
        if($type == 1){
            $this->db->limit(1);
        }
        $this->db->order_by('d.Datetime_reactivation', 'asc');
        $query = $this->db->get();
        if($query->result()){
            $array_result = [];
            foreach($query->result() as $rec){
                $result = [
                    'soaNumber' => $rec->soaNumber,
                    'Qty' => $rec->Qty,
                    'rate' => $rec->rate,
                    'total' => $rec->total,
                ];
                $dtls = $this->db->select('*')->from('tblreactivatedbilling')->where('id', $rec->id)->where('client', 'SAR')->order_by('Datetime_reactivation', 'asc')->get();
                $result['dtls'] = $dtls->result() ? $dtls->result() : [];
                array_push($array_result, $result);
            }
            return $array_result;
        }else{
            return false;
        }
    }
    public function get_other_income_report($from, $to, $type){
        $soa_no = 
        "CASE
            WHEN a.client = 'ALLOWANCE' THEN (SELECT `SOANo` FROM tblallowancesoahdr b WHERE a.id = b.ASHID LIMIT 1)
            WHEN a.client = 'PPE' THEN (SELECT `SOANo` FROM tblppehdr b WHERE a.id = b.PHID LIMIT 1)
            WHEN a.client = 'FUEL' THEN (SELECT `SOANo` FROM tblfuelhdr b WHERE a.id = b.FHID LIMIT 1)
            WHEN a.client = 'SUPPLIES' THEN (SELECT `SOANo` FROM tblsuphdr b WHERE a.id = b.SHID LIMIT 1)
            WHEN a.client = 'INCENTIVES' THEN (SELECT `SOANo` FROM tblincentiveshdr b WHERE a.id = b.IHID LIMIT 1)
            WHEN a.client = 'OTHERS' THEN (SELECT `SOANo` FROM tblothershdr b WHERE a.id = b.OHID LIMIT 1)
        END";
        $amount = 
        "CASE
            WHEN a.client = 'ALLOWANCE' THEN (SELECT TotalAmount FROM v_totalamountallowance b WHERE a.id = b.ASHID LIMIT 1)
            WHEN a.client = 'PPE' THEN (SELECT sum(b.subAmount) FROM tblppedtl b WHERE a.id = b.hdr_idLink GROUP BY b.hdr_idLink LIMIT 1)
            WHEN a.client = 'FUEL' THEN (SELECT sum(b.subAmount) FROM tblfueldtl b WHERE a.id = b.hdr_idLink GROUP BY b.hdr_idLink LIMIT 1)
            WHEN a.client = 'SUPPLIES' THEN (SELECT sum(b.subAmount) FROM tblsupdtl b WHERE a.id = b.hdr_idLink GROUP BY b.hdr_idLink LIMIT 1)
            WHEN a.client = 'INCENTIVES' THEN (SELECT sum(b.subAmount) FROM tblincentivesdtl b WHERE a.id = b.hdr_idLink GROUP BY b.hdr_idLink LIMIT 1)
            WHEN a.client = 'OTHERS' THEN (SELECT sum(b.subAmount) FROM tblothersdtl b WHERE a.id = b.hdr_idLink GROUP BY b.hdr_idLink LIMIT 1)
        END";
        $this->db
        ->select("*,".$soa_no." AS SOANo,".$amount." AS Amount")
        ->from('tblreactivatedbilling a')
        ->where_in('a.client', ['ALLOWANCE','PPE','FUEL','SUPPLIES','INCENTIVES','OTHERS'])
        ->where("a.Datetime_reactivation BETWEEN '" . $from . " 00:00:00' AND '" . $to . " 23:59:59'")
        ->order_by('a.client', 'asc');
        if($type == 1){
            $this->db->limit(1);
        }
        $this->db->order_by('a.Datetime_reactivation', 'asc');
        $query = $this->db->get();
        if($query->result()){
            return $query->result();
        }else{
            return false;
        }
    }
    public function get_other_client_report($from, $to, $type){
        $soa_no = 
        "CASE
            WHEN a.client = 'BCC' THEN (SELECT `SOANo` FROM tbloc_bcchdr b WHERE a.id = b.TOCSHDR LIMIT 1)
            WHEN a.client = 'DEARBC' THEN (SELECT `SOANo` FROM tbloc_dearbchdr b WHERE a.id = b.TOCDHDR LIMIT 1)
            WHEN a.client = 'SLERS' THEN (SELECT `SOANo` FROM tbloc_slershdr b WHERE a.id = b.TOCSHDR LIMIT 1)
            WHEN a.client = 'LABNOTIN' THEN (SELECT `SOANo` FROM tbloc_labnotinhdr b WHERE a.id = b.TOCLHDR LIMIT 1)
            WHEN a.client = 'CLUBHOUSE' THEN (SELECT `SOANo` FROM tbloc_cbhdr b WHERE a.id = b.TOCSHDR LIMIT 1)
        END";
        $amount = 
        "CASE
            WHEN a.client = 'BCC' THEN (SELECT sum(b.total) FROM tbloc_bccdtl b WHERE a.id = b.hdr_id GROUP BY b.hdr_id LIMIT 1)
            WHEN a.client = 'DEARBC' THEN (SELECT sum(b.total) FROM tbloc_dearbcdtl b WHERE a.id = b.hdr_id GROUP BY b.hdr_id LIMIT 1)
            WHEN a.client = 'SLERS' THEN (SELECT sum(b.total) FROM tbloc_slersdtl b WHERE a.id = b.hdr_id GROUP BY b.hdr_id LIMIT 1)
            WHEN a.client = 'LABNOTIN' THEN (SELECT sum(b.amount_billed) FROM tbloc_labnotindtl b WHERE a.id = b.hdr_id GROUP BY b.hdr_id LIMIT 1)
            WHEN a.client = 'CLUBHOUSE' THEN (SELECT sum(b.total) FROM tbloc_cbdtl b WHERE a.id = b.hdr_id GROUP BY b.hdr_id LIMIT 1)
        END";
        $this->db
        ->select("*,".$soa_no." AS SOANo,".$amount." AS Amount")
        ->from('tblreactivatedbilling a')
        ->where_in('a.client', ['BCC','DEARBC','SLERS','LABNOTIN','CLUBHOUSE'])
        ->where("a.Datetime_reactivation BETWEEN '" . $from . " 00:00:00' AND '" . $to . " 23:59:59'")
        ->order_by('a.client', 'asc');
        if($type == 1){
            $this->db->limit(1);
        }
        $this->db->order_by('a.Datetime_reactivation', 'asc');
        $query = $this->db->get();
        if($query->result()){
            return $query->result();
        }else{
            return false;
        }
    }
    public function get_dar_report($from, $to, $type){
        $st = 'SELECT SUM(dtl.rdst)+SUM(dtl.sholst)+SUM(dtl.shrdst)+SUM(dtl.rholst)+SUM(dtl.rhrdst)+SUM(dtl.rtst) FROM dmpi_dar_dtls dtl WHERE dtl.hdr_id = hdr.id';
        $ot = 'SELECT SUM(dtl.rdot)+SUM(dtl.sholot)+SUM(dtl.shrdot)+SUM(dtl.rholot)+SUM(dtl.rhrdot)+SUM(dtl.rtot) FROM dmpi_dar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        $nd = 'SELECT SUM(dtl.rdnd)+SUM(dtl.sholnd)+SUM(dtl.shrdnd)+SUM(dtl.rholnd)+SUM(dtl.rhrdnd)+SUM(dtl.rtnd) FROM dmpi_dar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        $ndot = 'SELECT SUM(dtl.rdndot)+SUM(dtl.sholndot)+SUM(dtl.shrdndot)+SUM(dtl.rholndot)+SUM(dtl.rhrdndot)+SUM(dtl.rtndot) FROM dmpi_dar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        $total_amt = 'SELECT SUM(dtl.c_totalAmt) FROM dmpi_dar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        $this->db
        ->select("hdr.id, hdr.soaNumber, (".$st.") AS ST, (".$ot.") AS OT, (".$nd.") AS ND, (".$ndot.") AS ND_OT, (".$total_amt.") AS TOTAL_AMT")
        ->from('dmpi_dar_hdrs hdr, tblreactivatedbilling d')
        ->where('d.id = hdr.id')
        ->where('d.client', 'DAR')
        ->where("d.Datetime_reactivation BETWEEN '" . $from . " 00:00:00' AND '" . $to . " 23:59:59'")
        ->group_by('d.id');
        if($type == 1){
            $this->db->limit(1);
        }
        $query = $this->db->get();
        if($query->result()){
            $array_result = [];
            foreach($query->result() as $rec){
                $result = [
                    'soaNumber' => $rec->soaNumber,
                    'ST' => $rec->ST,
                    'OT' => $rec->OT,
                    'ND' => $rec->ND,
                    'ND_OT' => $rec->ND_OT,
                    'TOTAL_AMT' => $rec->TOTAL_AMT,
                ];
                $dtls = $this->db->select('*')->from('tblreactivatedbilling')->where('id', $rec->id)->where('client', 'DAR')->order_by('Datetime_reactivation', 'asc')->get();
                $result['dtls'] = $dtls->result() ? $dtls->result() : [];
                array_push($array_result, $result);
            }
            return $array_result;
        }else{
            return false;
        }
    }
    public function soa_status_dar($from, $to, $type){
        $amount = 'SELECT SUM(dtl.totalAmt) FROM dmpi_dar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        $this->db
        ->select('hdr.id,hdr.soaNumber,hdr.created_at, hdr.preparedBy, hdr.ConfirmedDateTime,hdr.adminConfirmedBy,hdr.TransmittedDate,hdr.`status`, batch.xDate, ('.$amount.') AS amount')
        ->from('dmpi_dar_hdrs hdr, 201filedb.tblbatch batch')
        ->where('batch.BID = hdr.batcIDLink')
        ->where("hdr.soaDate BETWEEN '".$from."' AND '".$to."'");
        if($type == 1){
            $this->db->limit(1);
        }
        $this->db->order_by('hdr.soaDate', 'asc');
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function soa_status_sar($from, $to, $type){
        $amount = 'SELECT SUM(dtl.amount) FROM dmpi_sar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        $batch = 'SELECT batch.xDate FROM 201filedb.tblbatch batch WHERE hdr.soaNumber = batch.BNo';
        $this->db
        ->select('hdr.soaNumber, hdr.created_at, hdr.preparedBy, hdr.adminConfirmedDate, hdr.adminConfirmedBy, hdr.adminTransmittedDate, hdr.`status`, ('.$amount.') AS amount, ('.$batch.') AS xDate')
        ->from('dmpi_sars hdr')
        ->where("hdr.soaDate BETWEEN '".$from."' AND '".$to."'");
        if($type == 1){
            $this->db->limit(1);
        }
        $this->db->order_by('hdr.soaDate', 'asc');
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }
    public function get_billing_and_collection($gen, $from, $to, $opt){
        $amount = "SELECT SUM(c_totalAmt) FROM dmpi_dar_dtls b WHERE b.hdr_id= a.id GROUP BY b.hdr_id";
        if($gen == 1){
            $this->db->select("a.*, (".$amount.") AS amount, 0 AS collection, '' AS checkNo, '' AS checkDate")->from('dmpi_dar_hdrs a')->where('a.PaidAmount', 0);
            if($opt == 1){
                $this->db->limit(1);
            }
            $query = $this->db->get()->result();
        }elseif($gen == 2){

        }elseif($gen == 3){

        }elseif($gen == 4){

        }else{

        }
        return $query ? $query : false;
    }
    public function get_aging($from, $to, $type){
        $DARAmount = 'SELECT SUM(b.totalAmt) FROM dmpi_dar_dtls b WHERE b.hdr_id= a.id';
        $DARCollectionDate = 'SELECT b.PayDate FROM payment_dtl b WHERE b.HDRID = a.PaymentHDRID ORDER BY PayDate DESC LIMIT 1';

        $GolfCartSOA = 'SELECT b.series_no FROM golf_cart_soa_hdr b WHERE b.id = a.soaid_link LIMIT 1';
        $GolfCartCollection = 'SELECT SUM(b.amount) FROM golf_cart_payment b WHERE b.soa_link = a.soaid_link GROUP BY(b.soa_link)';
        $GolfCartCollectionDate = 'SELECT b.payment_date FROM golf_cart_payment b WHERE b.soa_link = a.soaid_link ORDER BY b.id DESC LIMIT 1';

        $LiftruckSOA = 'SELECT b.series_no FROM liftruck_soa_hdr b WHERE b.id = a.soaid_link LIMIT 1';
        $LiftruckCollection = 'SELECT SUM(b.amount) FROM liftruck_payment b WHERE b.soa_link = a.soaid_link GROUP BY(b.soa_link)';
        $LiftruckCollectionDate = 'SELECT b.payment_date FROM liftruck_payment b WHERE b.soa_link = a.soaid_link ORDER BY b.id DESC LIMIT 1';

        $WingVanSOA = 'SELECT b.series_no FROM wingvan_soa_hdr b WHERE b.id = a.soaid_link LIMIT 1';
        $WingVanCollection = 'SELECT SUM(b.amount) FROM wingvan_payment b WHERE b.soa_link = a.soaid_link GROUP BY(b.soa_link)';
        $WingVanCollectionDate = 'SELECT b.payment_date FROM wingvan_payment b WHERE b.soa_link = a.soaid_link ORDER BY b.id DESC LIMIT 1';

        $VanRentalSOA = 'SELECT b.series_no FROM vanrental_soa_hdr b WHERE b.id = a.soa_id LIMIT 1';

        $query = $this->db->query(
            "
            (
                SELECT 'DMPI BILLING' AS ClientName, 
                CONVERT(TransmittedDate USING utf8) AS DateTransmitted, 
                CONVERT(soaNumber USING utf8) AS SOANo,
                ($DARAmount) AS SOAAmount,
                CONVERT(PaidAmount USING utf8) AS Collection,
                ($DARCollectionDate) AS CollectionDate,
                DATEDIFF(NOW(), TransmittedDate) AS Outstanding
                FROM dmpi_dar_hdrs a
                WHERE status = 'PRINTED TRANSMITTAL' AND TransmittedDate BETWEEN '".$from."' AND '".$to."'
            ) 
            UNION 
            (
                SELECT 'DMPI TRUCKING' AS ClientName, 
                CONVERT(trans_date USING utf8) AS DateTransmitted, 
                ($GolfCartSOA) AS SOANo,
                SUM(debit_amount) AS SOAAmount,
                ($GolfCartCollection) AS Collection,
                ($GolfCartCollection) AS CollectionDate,
                DATEDIFF(NOW(), trans_date) AS Outstanding
                FROM golf_cart_ledger a
                WHERE soaid_link > 0 AND trans_date BETWEEN '".$from."' AND '".$to."'
                GROUP BY soaid_link
            )
            UNION
            (
                SELECT 'DMPI TRUCKING' AS ClientName, 
                JVLDate AS DateTransmitted, 
                OVLNo AS SOANo,
                BillAmount AS SOAAmount,
                CollectedAmount AS Collection,
                CheckDate AS CollectionDate,
                DATEDIFF(NOW(), JVLDate) AS Outstanding
                FROM tbljeepvehicleloghdr a
                WHERE JVLDate BETWEEN '".$from."' AND '".$to."'
            ) 
            UNION
            (
                SELECT 'DMPI TRUCKING' AS ClientName, 
                PHBVLDate AS DateTransmitted, 
                OVLNo AS SOANo,
                BillAmount AS SOAAmount,
                CollectedAmount AS Collection,
                CheckDate AS CollectionDate,
                DATEDIFF(NOW(), PHBVLDate) AS Outstanding
                FROM tblphbvehicleloghdr a
                WHERE PHBVLDate BETWEEN '".$from."' AND '".$to."'
            ) 
            UNION
            (
                SELECT 'DMPI TRUCKING' AS ClientName, 
                OVLVLDate AS DateTransmitted, 
                OVLNo AS SOANo,
                BillAmount AS SOAAmount,
                CollectedAmount AS Collection,
                CheckDate AS CollectionDate,
                DATEDIFF(NOW(), OVLVLDate) AS Outstanding
                FROM tblovlvehicleloghdr a
                WHERE OVLVLDate BETWEEN '".$from."' AND '".$to."'
            ) 
            UNION
            (
                SELECT 'DMPI TRUCKING' AS ClientName, 
                date AS DateTransmitted, 
                ($LiftruckSOA) AS SOANo,
                SUM(amount) AS SOAAmount,
                ($LiftruckCollection) AS Collection,
                ($LiftruckCollectionDate) AS CollectionDate,
                DATEDIFF(NOW(), date) AS Outstanding
                FROM liftruck_rental a
                WHERE soaid_link > 0 AND date BETWEEN '".$from."' AND '".$to."'
                GROUP BY soaid_link
            ) 
            UNION
            (
                SELECT 'DMPI TRUCKING' AS ClientName, 
                date AS DateTransmitted, 
                ($WingVanSOA) AS SOANo,
                SUM(amount) AS SOAAmount,
                ($WingVanCollection) AS Collection,
                ($WingVanCollectionDate) AS CollectionDate,
                DATEDIFF(NOW(), date) AS Outstanding
                FROM wingvan_requisition a
                WHERE soaid_link > 0 AND date BETWEEN '".$from."' AND '".$to."'
                GROUP BY soaid_link
            ) 
            UNION
            (
                SELECT 'DMPI TRUCKING' AS ClientName, 
                trans_date AS DateTransmitted, 
                ($VanRentalSOA) AS SOANo,
                SUM(bill) AS SOAAmount,
                SUM(amount) AS Collection,
                payment_date AS CollectionDate,
                DATEDIFF(NOW(), trans_date) AS Outstanding
                FROM vanrental_collection a
                WHERE soa_id > 0 AND trans_date BETWEEN '".$from."' AND '".$to."'
                GROUP BY soa_id
            ) 
            "
        );
        return $query->result() ? $query->result() : false;
    }
    public function year_to_date_report($from, $to, $type){
        $return_array = [];
        $start = strtotime($from);
        $end = strtotime($to);
        while($start <= $end)
        {
            $month = date('Ym', $start);

            $start_between = date('Y-m-1', $start);
            $end_between = date('Y-m-15', $start);

            // FOR FIRST HALF
            $headbase = 0;
            $volumebase = 0;
            $head_base_collection = array();
            // DAR QUERY
            $total_query1 = $this->db->select("SUM(b.c_totalAmt) AS total")->from('dmpi_dar_dtls b, dmpi_dar_hdrs a')->where('a.id = b.hdr_id')->where('pmy',$month)->where('period', '1')->get()->result();
            $headbase += $total_query1[0]->total;

            $collect_query1 = $this->db
            ->select('SUM(c.Amount) AS collection, b.ORNo, b.PayDate')
            ->from('dmpi_dar_hdrs a, payment_dtl b, dar_payment_link c')
            ->where('a.id = c.DARID')
            ->where('c.PDTLID = b.PDTLID')
            ->where('a.pmy',$month)
            ->where('a.period', '1')
            ->group_by('b.ORNo')
            ->get()
            ->result();
            foreach(@$collect_query1 as $record){
                array_push($head_base_collection, $record);
            }
            //SAR QUERY 
            $total_query1 = $this->db->select("SUM(b.amount) AS total")->from('dmpi_sar_dtls b, dmpi_sars a')->where('a.id = b.hdr_id')->where("a.periodCoveredFrom BETWEEN '".$start_between."' AND '".$end_between."'")->get()->result();
            $volumebase += $total_query1[0]->total;

            $push_array = ['Period' => strtoupper(date('M 1-15', $start)), 'hbc' => $head_base_collection, 'headbase' => $headbase, 'volumebase' => $volumebase, 'vbc' => array()];
            array_push($return_array, $push_array);


            // FOR SECOND HALF
            $start_between = date('Y-m-16', $start);
            $end_between = date('Y-m-t', $start);

            $headbase = 0;
            $head_base_collection = array();
            // DAR QUERY
            $total_query2 = $this->db->select("SUM(b.c_totalAmt) AS total")->from('dmpi_dar_dtls b, dmpi_dar_hdrs a')->where('a.id = b.hdr_id')->where('pmy',$month)->where('period', '2')->get()->result();
            $headbase += $total_query2[0]->total;
            $collect_query2 = $this->db
            ->select('SUM(c.Amount) AS collection, b.ORNo, b.PayDate')
            ->from('dmpi_dar_hdrs a, payment_dtl b, dar_payment_link c')
            ->where('a.id = c.DARID')
            ->where('c.PDTLID = b.PDTLID')
            ->where('a.pmy',$month)
            ->where('a.period', '2')
            ->group_by('b.ORNo')
            ->get()
            ->result();
            foreach(@$collect_query2 as $record){
                array_push($collection, $record);
            }
            // SAR QUERY 
            $total_query1 = $this->db->select("SUM(b.amount) AS total")->from('dmpi_sar_dtls b, dmpi_sars a')->where('a.id = b.hdr_id')->where("a.periodCoveredFrom BETWEEN '".$start_between."' AND '".$end_between."'")->get()->result();
            $volumebase += $total_query1[0]->total;

            $push_array = ['Period' => strtoupper(date('M 16-t', $start)), 'hbc' => $head_base_collection, 'headbase' => $headbase, 'volumebase' => $volumebase, 'vbc' => array()];
            array_push($return_array, $push_array);

            $start = strtotime("+1 month", $start);
        }
        return $return_array;
    }
    public function all_client_report($from, $to, $type){
        $result_array = [];
        $start = strtotime($from);
        $end = strtotime($to);
        while($start <= $end)
        {
            $array = [
                'BCC' => 0,
                'SLERS' => 0,
                'DEARBC' => 0,
                'TECHNICAL' => 0,
                'DMPI' => 0,
            ];
            $array['Date'] = date('F', $start).' 1-15';
            $dmpi_start = date('Ym', $start);
            $dmpi_period = 1;
            $query_start = date('Y-m-1', $start);
            $query_end = date('Y-m-15', $start);
            $bcc_date = date('F', $start).' 1-15 '.date('Y', $start);

            $BCC = $this->db->select('SUM(b.total) AS BCC')->from('tbloc_bcchdr a, tbloc_bccdtl b')->where('a.TOCSHDR = b.hdr_id')->where('period_date', strtoupper($bcc_date))->get()->row();
            $array['BCC'] = $BCC->BCC;

            $SLERS = $this->db->select('SUM(b.total) AS SLERS')->from('tbloc_slershdr a, tbloc_slersdtl b')->where('a.TOCSHDR = b.hdr_id')->where('period_date', strtoupper($bcc_date))->get()->row();
            $array['SLERS'] = $SLERS->SLERS;

            $DEARBC = $this->db->select('SUM(b.total) AS DEARBC')->from('tbloc_dearbchdr a, tbloc_dearbcdtl b')->where('a.TOCDHDR = b.hdr_id')->where('period_date', strtoupper($bcc_date))->get()->row();
            $array['DEARBC'] = $DEARBC->DEARBC;

            $DMPI = $this->db->query("
                SELECT SUM(total) AS DMPI FROM 
                (
                    (SELECT SUM(b.totalAmt) AS total FROM dmpi_dar_hdrs a, dmpi_dar_dtls b WHERE a.id = b.hdr_id AND a.pmy = '".$dmpi_start."' AND a.period = '".$dmpi_period."')
                    UNION ALL
                    (SELECT SUM(b.amount) AS total FROM dmpi_sars a, dmpi_sar_dtls b WHERE a.id = b.hdr_id AND soaDate BETWEEN '".$query_start."' AND '".$query_end."')
                ) AS TotalDMPI
            ")->row();
            $array['DMPI'] = $DMPI->DMPI;

            array_push($result_array, $array);

            $array['Date'] = date('F', $start).' 16-'.date('t', $start);
            $dmpi_period = 2;
            $query_start = date('Y-m-16', $start);
            $query_end = date('Y-m-t', $start);
            $bcc_date = date('F', $start).' 16-'.date('t Y', $start);

            $BCC = $this->db->select('SUM(b.total) AS BCC')->from('tbloc_bcchdr a, tbloc_bccdtl b')->where('a.TOCSHDR = b.hdr_id')->where('period_date', strtoupper($bcc_date))->get()->row();
            $array['BCC'] = $BCC->BCC;
            
            $SLERS = $this->db->select('SUM(b.total) AS SLERS')->from('tbloc_slershdr a, tbloc_slersdtl b')->where('a.TOCSHDR = b.hdr_id')->where('period_date', strtoupper($bcc_date))->get()->row();
            $array['SLERS'] = $SLERS->SLERS;
            
            $DEARBC = $this->db->select('SUM(b.total) AS DEARBC')->from('tbloc_dearbchdr a, tbloc_dearbcdtl b')->where('a.TOCDHDR = b.hdr_id')->where('period_date', strtoupper($bcc_date))->get()->row();
            $array['DEARBC'] = $DEARBC->DEARBC;

            $DMPI = $this->db->query("
                SELECT SUM(total) AS DMPI FROM 
                (
                    (SELECT SUM(b.totalAmt) AS total FROM dmpi_dar_hdrs a, dmpi_dar_dtls b WHERE a.id = b.hdr_id AND a.pmy = '".$dmpi_start."' AND a.period = '".$dmpi_period."')
                    UNION ALL
                    (SELECT SUM(b.amount) AS total FROM dmpi_sars a, dmpi_sar_dtls b WHERE a.id = b.hdr_id AND soaDate BETWEEN '".$query_start."' AND '".$query_end."')
                ) AS TotalDMPI
            ")->row();
            $array['DMPI'] = $DMPI->DMPI;
            array_push($result_array, $array);
            $start = strtotime("+1 month", $start);
        }
        return $result_array ? json_decode(json_encode($result_array)) : false;
    }
    public function annual_report($from, $to, $type){
        // $amount = 'SELECT SUM(dtl.amount) FROM dmpi_sar_dtls dtl WHERE dtl.hdr_id= hdr.id';
        // $batch = 'SELECT batch.xDate FROM 201filedb.tblbatch batch WHERE hdr.soaNumber = batch.BNo';
        // $this->db
        // ->select('hdr.soaNumber, hdr.created_at, hdr.preparedBy, hdr.adminConfirmedDate, hdr.adminConfirmedBy, hdr.adminTransmittedDate, hdr.`status`, ('.$amount.') AS amount, ('.$batch.') AS xDate')
        // ->from('dmpi_sars hdr')
        // ->where("hdr.soaDate BETWEEN '".$from."' AND '".$to."'");
        // if($type == 1){
        //     $this->db->limit(1);
        // }
        // $this->db->order_by('hdr.soaDate', 'asc');
        // $query = $this->db->get();
        // return $query->result() ? $query->result() : false;
        return true;
    }
    public function weekly_report($searchBy, $from, $to, $pmy, $period, $type){

        //DAR QUERY
        $amount = 'SELECT SUM(dtl.c_totalAmt) FROM dmpi_dar_dtls dtl WHERE dtl.hdr_id=hdr.id GROUP BY dtl.hdr_id';
        $location = 'SELECT `Location` FROM 201filedb.tblbatch d, dmpi_dar_batches e WHERE e.DARID = hdr.id AND e.BID = d.BID LIMIT 1';
        $last_activity = 'SELECT `Activity` FROM dmpi_dar_dtls b WHERE hdr.id = b.hdr_id ORDER BY b.id LIMIT 1';
        $st = "SELECT SUM(st.rdst) + SUM(st.sholst) + SUM(st.shrdst) + SUM(st.rholst) + SUM(st.rhrdst) + SUM(st.rtst) FROM dmpi_dar_dtls st WHERE st.hdr_id=hdr.id GROUP BY st.hdr_id";
        $ot = "SELECT SUM(ot.rdot) + SUM(ot.sholot) + SUM(ot.shrdot) + SUM(ot.rholot) + SUM(ot.rhrdot) + SUM(ot.rtot) FROM dmpi_dar_dtls ot WHERE ot.hdr_id=hdr.id GROUP BY ot.hdr_id";
        $nd = "SELECT SUM(nd.rdnd) + SUM(nd.sholnd) + SUM(nd.shrdnd) + SUM(nd.rholnd) + SUM(nd.rhrdnd) + SUM(nd.rtnd) FROM dmpi_dar_dtls nd WHERE nd.hdr_id=hdr.id GROUP BY nd.hdr_id";
        $ndot = "SELECT SUM(ndot.rdndot) + SUM(ndot.sholndot) + SUM(ndot.shrdndot) + SUM(ndot.rholndot) + SUM(ndot.rhrdndot) + SUM(ndot.rtndot) FROM dmpi_dar_dtls ndot WHERE ndot.hdr_id=hdr.id GROUP BY ndot.hdr_id";
        $hc = "SELECT SUM(ndot.headCount) FROM dmpi_dar_dtls ndot WHERE ndot.hdr_id=hdr.id GROUP BY ndot.hdr_id";
        $dar_query = 'SELECT soaDate, soaNumber, TransmittedDate, SupervisorDate, ManagerDate, DataControllerDate, BillingClerkDate, DMPIReceivedDate, TransmittalNo, nonBatch, ('.$amount.') as total_amount, ('.$location.') as location, ('.$last_activity.') as activity, ('.$st.') as st, ('.$ot.') as ot, ('.$nd.') as nd, ('.$ndot.') as ndot, ('.$hc.') as hc,
        DATEDIFF(TransmittedDate, soaDate) AS TDDate,
        DATEDIFF(SupervisorDate, TransmittedDate) AS STDate,
        DATEDIFF(ManagerDate, SupervisorDate) AS MSDate,
        DATEDIFF(DataControllerDate, ManagerDate) AS DMDate,
        DATEDIFF(DMPIReceivedDate, DataControllerDate) AS DDatDate,
        DATEDIFF(DMPIReceivedDate, soaDate) AS DDocDate FROM dmpi_dar_hdrs hdr WHERE '.$searchBy.' BETWEEN "'.$from.'" AND "'.$to.'" AND hdr.status = "PRINTED TRANSMITTAL"';
        
        //SAR QUERY 
        $sar_amt = 'SELECT SUM(dtl.amount) FROM dmpi_sar_dtls dtl WHERE dtl.hdr_id=hdr.id GROUP BY dtl.hdr_id';
        $last_activity_sar = 'SELECT `activity` FROM dmpi_sar_dtls b WHERE hdr.id = b.hdr_id ORDER BY b.id LIMIT 1';
        $sar_transmittal = 'SELECT `TransmittalNo` FROM dmpi_sar_transmittal b WHERE hdr.transmittal_id = b.id ORDER BY b.id LIMIT 1';
        $transmittal_date = 'SELECT b.date FROM dmpi_sar_transmittal b WHERE hdr.transmittal_id = b.id ORDER BY b.id LIMIT 1';
        $sar_query = 'SELECT periodCoveredFrom as soaDate, controlNo as soaNumber, "0000-00-00" as TransmittedDate, "0000-00-00" as SupervisorDate, "0000-00-00" as ManagerDate, "0000-00-00" as DataControllerDate, "0000-00-00" as BillingClerkDate, ('.$transmittal_date.') as DMPIReceivedDate,  ('.$sar_transmittal.') as TransmittalNo, 1 as nonBatch, ('.$sar_amt.') as total_amount, Location as location, ('.$last_activity_sar.') as activity, 0 as st, 0 as ot, 0 as nd, 0 as ndot, 0 as hc,
        0 as TDDate,
        0 AS STDate,
        0 AS MSDate,
        0 AS DMDate,
        0 AS DDatDate,
        0 AS DDocDate FROM dmpi_sars hdr WHERE periodCoveredFrom BETWEEN "'.$from.'" AND "'.$to.'" AND hdr.status = "transmitted"';

        //ALLOWANCE QUERY 
        $allowance_query = 'SELECT Date as soaDate, SOANo as soaNumber, date_transmitted as TransmittedDate, "0000-00-00" as SupervisorDate, "0000-00-00" as ManagerDate, "0000-00-00" as DataControllerDate, "0000-00-00" as BillingClerkDate, "0000-00-00" as DMPIReceivedDate,  transmittal_no as TransmittalNo, 1 as nonBatch, TotalAmount as total_amount, Location as location, "ALLOWANCE" as activity, 0 as st, 0 as ot, 0 as nd, 0 as ndot, 0 as hc, 
        0 as TDDate,
        0 AS STDate,
        0 AS MSDate,
        0 AS DMDate,
        0 AS DDatDate,
        0 AS DDocDate FROM v_totalamountallowance WHERE Date BETWEEN "'.$from.'" AND "'.$to.'" AND transmittal_no <> ""';

        //INCENTIVES QUERY 
        $location = 'SELECT `location` FROM tblincentivesdtl b WHERE hdr.IHID = b.hdr_idLink ORDER BY b.hdr_idLink LIMIT 1';
        $incentives_query = 'SELECT Date as soaDate, SOANo as soaNumber, date_transmitted as TransmittedDate, "0000-00-00" as SupervisorDate, "0000-00-00" as ManagerDate, "0000-00-00" as DataControllerDate, "0000-00-00" as BillingClerkDate, "0000-00-00" as DMPIReceivedDate,  transmittal_no as TransmittalNo, 1 as nonBatch, TotalAmount as total_amount, ('.$location.') as location, "INCENTIVES" as activity, 0 as st, 0 as ot, 0 as nd, 0 as ndot, 0 as hc, 
        0 as TDDate,
        0 AS STDate,
        0 AS MSDate,
        0 AS DMDate,
        0 AS DDatDate,
        0 AS DDocDate FROM v_totalamountincentives hdr WHERE Date BETWEEN "'.$from.'" AND "'.$to.'" AND transmittal_no <> ""';

         //LABNOTIN QUERY 
         $amt = 'SELECT SUM(dtl.amount_billed) FROM tbloc_labnotindtl dtl WHERE dtl.hdr_id=hdr.TOCLHDR GROUP BY dtl.hdr_id';
         $last_activity = 'SELECT `Activity` FROM tbloc_labnotindtl b WHERE hdr.TOCLHDR = b.hdr_id ORDER BY b.TOCLDTL LIMIT 1';
         $labnotin_query = 'SELECT Date as soaDate, SOANo as soaNumber, date_transmitted as TransmittedDate, "0000-00-00" as SupervisorDate, "0000-00-00" as ManagerDate, "0000-00-00" as DataControllerDate, "0000-00-00" as BillingClerkDate, "0000-00-00" as DMPIReceivedDate,  transmittal_no as TransmittalNo, 1 as nonBatch, ('.$amt.') as total_amount, "LABNOTIN" as location, ('.$last_activity.') as activity, 0 as st, 0 as ot, 0 as nd, 0 as ndot, 0 as hc, 
         0 as TDDate,
         0 AS STDate,
         0 AS MSDate,
         0 AS DMDate,
         0 AS DDatDate,
         0 AS DDocDate FROM tbloc_labnotinhdr hdr WHERE hdr.Date BETWEEN "'.$from.'" AND "'.$to.'" AND hdr.transmittal_no <> ""';

        if($type == 1){
            $query = $this->db->query("(".$dar_query." LIMIT 1) UNION ALL (".$sar_query." LIMIT 1)  UNION ALL (".$allowance_query." LIMIT 1)  UNION ALL (".$incentives_query." LIMIT 1)  UNION ALL (".$labnotin_query." LIMIT 1)");
            // $query = $this->db->query("(".$allowance_query." LIMIT 1)  UNION ALL (".$incentives_query." LIMIT 1)  UNION ALL (".$labnotin_query." LIMIT 1)");
        }else{
            $query = $this->db->query("SELECT * FROM (".$dar_query." UNION ALL ".$sar_query." UNION ALL ".$allowance_query." UNION ALL ".$incentives_query." UNION ALL ".$labnotin_query.") dum ORDER BY TransmittalNo");
            // $query = $this->db->query("(".$allowance_query.") UNION ALL (".$incentives_query.") UNION ALL (".$labnotin_query.")");
        }
        return $query->result() ? $query->result() : false;
    }
    public function monthly_report($searchBy, $from, $to, $type){

        $from = date('Y-m-01', strtotime($from));
        $to = date("Y-m-t", strtotime($to));
        // DAR Query
        $amount1 = 'SELECT SUM(dtl.c_totalAmt) FROM dmpi_dar_dtls dtl WHERE dtl.hdr_id= a.id GROUP BY dtl.hdr_id';
        $dar_query = 'SELECT a.DMPIReceivedDate, soaDate, soaNumber, ('.$amount1.') AS TotalAmt, DATEDIFF(DMPIReceivedDate, TransmittedDate) AS billing_period, SupervisorDate, ManagerDate, DATEDIFF(DMPIReceivedDate, TransmittedDate) AS total_processing, date_finalize
        FROM dmpi_dar_hdrs a, dar_transmittal b
        WHERE a.status = "PRINTED TRANSMITTAL"
        AND a.TransmittalNo = b.TransmittalNo
        AND a.'.$searchBy.' BETWEEN "'.$from.'" AND "'.$to.'"';
        // SAR QUERY 
        $amount2 = 'SELECT SUM(dtl.amount) FROM dmpi_sar_dtls dtl WHERE dtl.hdr_id=a.id GROUP BY dtl.hdr_id';
        $transmittal_date = 'SELECT b.date FROM dmpi_sar_transmittal b WHERE hdr.transmittal_id = b.id ORDER BY b.id LIMIT 1';
        $sar_query = 'SELECT ('.$transmittal_date.') as DMPIReceivedDate, a.periodCoveredFrom as soaDate, controlNo as soaNumber, ('.$amount2.') AS TotalAmt, DATEDIFF(soaDate, date) AS billing_period, "0000-00-00" as SupervisorDate, "0000-00-00" as ManagerDate, 0 AS total_processing, "0000-00-00" as date_finalize
        FROM dmpi_sars a, dmpi_sar_transmittal b
        WHERE a.status = "transmitted"
        AND a.transmittal_id = b.id
        AND a.periodCoveredFrom BETWEEN "'.$from.'" AND "'.$to.'"';
        // ALLOWANCE QUERY 
        $allowance_query = 'SELECT Date as DMPIReceivedDate, Date as soaDate, SOANo as soaNumber, TotalAmount AS TotalAmt, DATEDIFF(Date, date_transmitted) AS billing_period, "0000-00-00" as SupervisorDate, "0000-00-00" as ManagerDate, 0 AS total_processing, "0000-00-00" as date_finalize
        FROM v_totalamountallowance
        WHERE transmittal_no <> ""
        AND Date BETWEEN "'.$from.'" AND "'.$to.'"';
        // INCENTIVES QUERY 
        $incentives_query = 'SELECT Date as DMPIReceivedDate, Date as soaDate, SOANo as soaNumber, TotalAmount AS TotalAmt, DATEDIFF(Date, date_transmitted) AS billing_period, "0000-00-00" as SupervisorDate, "0000-00-00" as ManagerDate, 0 AS total_processing, "0000-00-00" as date_finalize
        FROM v_totalamountincentives
        WHERE transmittal_no <> ""
        AND Date BETWEEN "'.$from.'" AND "'.$to.'"';
        // LABNOTIN QUERY 
        $amount3 = 'SELECT SUM(dtl.amount_billed) FROM tbloc_labnotindtl dtl WHERE dtl.hdr_id=TOCLHDR GROUP BY dtl.hdr_id';
        $labnotin_query = 'SELECT Date as DMPIReceivedDate, Date, SOANo as soaNumber, ('.$amount3.') AS TotalAmt, DATEDIFF(Date, date_transmitted) AS billing_period, "0000-00-00" as SupervisorDate, "0000-00-00" as ManagerDate, 0 AS total_processing, "0000-00-00" as date_finalize
        FROM tbloc_labnotinhdr
        WHERE transmittal_no <> ""
        AND Date BETWEEN "'.$from.'" AND "'.$to.'"';
        
        // $this->db
        // ->select('a.DMPIReceivedDate, soaDate, soaNumber, ('.$amount1.') AS TotalAmt, DATEDIFF(DMPIReceivedDate, TransmittedDate) AS billing_period, SupervisorDate, ManagerDate, DATEDIFF(DMPIReceivedDate, TransmittedDate) AS total_processing, date_finalize')
        // ->from('dmpi_dar_hdrs a, dar_transmittal b')
        // ->where('a.status', 'PRINTED TRANSMITTAL')
        // ->where('a.TransmittalNo = b.TransmittalNo')
        // ->where("a.DMPIReceivedDate BETWEEN '".$from."' AND '".$to."'");
        if($type == 1){
            $query = $this->db->query("(".$dar_query." LIMIT 1) UNION ALL (".$sar_query." LIMIT 1) UNION ALL (".$allowance_query." LIMIT 1) UNION ALL (".$incentives_query." LIMIT 1) UNION ALL (".$labnotin_query." LIMIT 1)");
            // $query = $this->db->query("(".$allowance_query." LIMIT 1) UNION ALL (".$incentives_query." LIMIT 1) UNION ALL (".$labnotin_query." LIMIT 1)");
        }else{
            $query = $this->db->query("(".$dar_query.") UNION ALL (".$sar_query.") UNION ALL (".$allowance_query.") UNION ALL (".$incentives_query.") UNION ALL (".$labnotin_query.")");
            // $query = $this->db->query("(".$allowance_query.") UNION ALL (".$incentives_query.") UNION ALL (".$labnotin_query.")");
        }
        // $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }
    public function monthly_report_transmittal($searchBy, $from, $to, $type){
        
        $from = date('Y-m-01', strtotime($from));
        $to = date("Y-m-t", strtotime($to));
        
        // DAR QUERY 
        $Location = 'SELECT `Location` FROM 201filedb.tblbatch d, dmpi_dar_batches e WHERE e.DARID = a.id AND e.BID = d.BID LIMIT 1';
        $dar_query = 'SELECT a.id AS HdrID, a.TransmittalNo, a.detailType, "DAR" as ClientType
        FROM dmpi_dar_hdrs a
        WHERE a.'.$searchBy.' BETWEEN "'.$from.'" AND "'.$to.'"
        AND a.status = "PRINTED TRANSMITTAL"
        ';
        
        // SAR QUERY 
        $TransmittalNo = 'SELECT b.TransmittalNo FROM dmpi_sar_transmittal b WHERE b.id = a.transmittal_id LIMIT 1';
        $sar_query = 'SELECT a.id AS HdrID, ('.$TransmittalNo.') AS TransmittalNo, 0 as detailType, "SAR" as ClientType
        FROM dmpi_sars a
        WHERE a.periodCoveredFrom BETWEEN "'.$from.'" AND "'.$to.'"
        AND a.status = "transmitted"
        ';

        // ALLOWANCE QUERY 
        $allowance_query = 'SELECT ASHID AS HdrID, transmittal_no AS TransmittalNo, 0 as detailType, "ALLOWANCE" as ClientType
        FROM v_totalamountallowance
        WHERE Date BETWEEN "'.$from.'" AND "'.$to.'"
        AND transmittal_no <> ""
        ';

        // INCENTIVES QUERY 
        $incentives_query = 'SELECT IHID AS HdrID, transmittal_no AS TransmittalNo, 0 as detailType, "INCENTIVES" as ClientType
        FROM v_totalamountincentives
        WHERE Date BETWEEN "'.$from.'" AND "'.$to.'"
        AND transmittal_no <> ""
        ';

        // LABNOTIN QUERY 
        $labnotin_query = 'SELECT TOCLHDR AS HdrID, transmittal_no AS TransmittalNo, 0 as detailType, "LABNOTIN" as ClientType
        FROM tbloc_labnotinhdr
        WHERE Date BETWEEN "'.$from.'" AND "'.$to.'"
        AND transmittal_no <> ""
        ';
        // $this->db
        // ->select('a.id AS HdrID, a.TransmittalNo, a.detailType')
        // ->from('dmpi_dar_hdrs a')
        // ->where("a.DMPIReceivedDate BETWEEN '".$from."' AND '".$to."'")
        // ->where('a.status', 'PRINTED TRANSMITTAL');
        // if($type == 1){
        //     $this->db->limit(1);
        // }
        // $query = $this->db->get();
        if($type == 1){
            $query = $this->db->query("(".$dar_query." LIMIT 1) UNION ALL (".$sar_query." LIMIT 1) UNION ALL (".$allowance_query." LIMIT 1) UNION ALL (".$incentives_query." LIMIT 1) UNION ALL (".$labnotin_query." LIMIT 1)");
            // $query = $this->db->query("(".$allowance_query." LIMIT 1) UNION ALL (".$incentives_query." LIMIT 1) UNION ALL (".$labnotin_query." LIMIT 1)");
        }else{
            $query = $this->db->query("(".$dar_query.") UNION ALL (".$sar_query.") UNION ALL (".$allowance_query.") UNION ALL (".$incentives_query.") UNION ALL (".$labnotin_query.")");
            // $query = $this->db->query("(".$allowance_query.") UNION ALL (".$incentives_query.") UNION ALL (".$labnotin_query.")");
        }
        if($query->result()){
            $result = [];
            foreach($query->result() as $record){
                if($record->ClientType === "DAR"){
                    if($record->detailType == 1){
                        $dtls = $this->db->select('
                        a.TransmittedDate, 
                        a.SupervisorDate, 
                        a.ManagerDate, 
                        a.DataControllerDate, 
                        a.BillingClerkDate, 
                        a.DMPIReceivedDate, 
                        b.activity, 
                        b.field, 
                        b.gl, 
                        b.cc,
                        b.rdst,
                        b.rdot,
                        b.rdnd,
                        b.rdndot,
            
                        b.rtst,
                        b.rtot,
                        b.rtnd,
                        b.rtndot,
                        
                        b.sholst,
                        b.sholot,
                        b.sholnd,
                        b.sholndot,
                        b.shrdst,
                        b.shrdot,
                        b.shrdnd,
                        b.shrdndot,
                        b.rholst,
                        b.rholot,
                        b.rholnd,
                        b.rholndot,
                        b.rhrdst,
                        b.rhrdot,
                        b.rhrdnd,
                        b.rhrdndot,
                        c.rd_st,
                        c.rd_ot,
                        c.rd_nd,
                        c.rd_ndot,
                        c.rt_st,
                        c.rt_ot,
                        c.rt_nd,
                        c.rt_ndot,
                        c.shol_st,
                        c.shol_ot,
                        c.shol_nd,
                        c.shol_ndot,
                        c.shrd_st,
                        c.shrd_ot,
                        c.shrd_nd,
                        c.shrd_ndot,
                        c.rhol_st,
                        c.rhol_ot,
                        c.rhol_nd,
                        c.rhol_ndot,
                        c.rhrd_st,
                        c.rhrd_ot,
                        c.rhrd_nd,
                        c.rhrd_ndot,
                        b.c_totalst,
                        b.c_totalot,
                        b.c_totalnd,
                        b.c_totalndot,
                        b.c_totalAmt,
                        b.headCount,
                        a.soaNumber,
                        a.soaDate,
                        a.TransmittalNo,
                        a.id AS headerID, ('.$Location.') AS Location')
                        ->from('dmpi_dar_hdrs a, dmpi_dar_dtls b')
                        ->join('rate_masters c', 'c.id = b.rate_id', 'left')
                        ->where('a.id = b.hdr_id')
                        ->where('a.id', $record->HdrID)
                        ->order_by('a.id', 'asc')
                        ->get();
                    }else{
                        $dtls = $this->db->select('
                        a.TransmittedDate, 
                        a.SupervisorDate, 
                        a.ManagerDate, 
                        a.DataControllerDate, 
                        a.BillingClerkDate, 
                        a.DMPIReceivedDate, 
                        b.activity, 
                        b.field, 
                        b.gl, 
                        b.cc,
                        b.rdst,
                        b.rdot,
                        b.rdnd,
                        b.rdndot,

                        b.rtst,
                        b.rtot,
                        b.rtnd,
                        b.rtndot,

                        b.sholst,
                        b.sholot,
                        b.sholnd,
                        b.sholndot,
                        b.shrdst,
                        b.shrdot,
                        b.shrdnd,
                        b.shrdndot,
                        b.rholst,
                        b.rholot,
                        b.rholnd,
                        b.rholndot,
                        b.rhrdst,
                        b.rhrdot,
                        b.rhrdnd,
                        b.rhrdndot,
                        b.c_totalst,
                        b.c_totalot,
                        b.c_totalnd,
                        b.c_totalndot,
                        b.c_totalAmt,
                        b.headCount,
                        a.soaNumber,
                        a.soaDate,
                        a.TransmittalNo, 
                        a.id AS headerID, 
                        ('.$Location.') AS Location,

                        rdst AS rd_st,
                        rdot AS rd_ot,
                        rdnd AS rd_nd,
                        rdndot AS rd_ndot,

                        rtst AS rt_st,
                        rtot AS rt_ot,
                        rtnd AS rt_nd,
                        rtndot AS rt_ndot,
    
                        sholst AS shol_st,
                        sholot AS shol_ot,
                        sholnd AS shol_nd,
                        sholndot AS shol_ndot,
    
                        shrdst AS shrd_st,
                        shrdot AS shrd_ot,
                        shrdnd AS shrd_nd,
                        shrdndot AS shrd_ndot,
    
                        rholst AS rhol_st,
                        rholot AS rhol_ot,
                        rholnd AS rhol_nd,
                        rholndot AS rhol_ndot,
    
                        rhrdst AS rhrd_st,
                        rhrdot AS rhrd_ot,
                        rhrdnd AS rhrd_nd,
                        rhrdndot AS rhrd_ndot
                        ')->from('dmpi_dar_hdrs a, dmpi_dar_dtls b')
                        ->where('a.id = b.hdr_id')
                        ->where('a.id', $record->HdrID)
                        ->order_by('a.id', 'asc')
                        ->get();
                    }
                }elseif($record->ClientType === "SAR"){
                    $dtls = $this->db->select('
                    "0000-00-00" as TransmittedDate, 
                    "0000-00-00" as SupervisorDate, 
                    "0000-00-00" as ManagerDate, 
                    "0000-00-00" as DataControllerDate, 
                    "0000-00-00" as BillingClerkDate, 
                    "0000-00-00" as DMPIReceivedDate, 
                    b.activity, 
                    "" as field, 
                    b.gl, 
                    b.costCenter as cc,
                    0 as rdst,
                    0 as rdot,
                    0 as rdnd,
                    0 as rdndot,
                    0 as rtst,
                    0 as rtot,
                    0 as rtnd,
                    0 as rtndot,
                    0 as sholst,
                    0 as sholot,
                    0 as sholnd,
                    0 as sholndot,
                    0 as shrdst,
                    0 as shrdot,
                    0 as shrdnd,
                    0 as shrdndot,
                    0 as rholst,
                    0 as rholot,
                    0 as rholnd,
                    0 as rholndot,
                    0 as rhrdst,
                    0 as rhrdot,
                    0 as rhrdnd,
                    0 as rhrdndot,
                    0 as  rd_st,
                    0 as  rd_ot,
                    0 as  rd_nd,
                    0 as  rd_ndot,
                    0 as  rt_st,
                    0 as  rt_ot,
                    0 as  rt_nd,
                    0 as  rt_ndot,
                    0 as  shol_st,
                    0 as  shol_ot,
                    0 as  shol_nd,
                    0 as  shol_ndot,
                    0 as  shrd_st,
                    0 as  shrd_ot,
                    0 as  shrd_nd,
                    0 as  shrd_ndot,
                    0 as  rhol_st,
                    0 as  rhol_ot,
                    0 as  rhol_nd,
                    0 as  rhol_ndot,
                    0 as  rhrd_st,
                    0 as  rhrd_ot,
                    0 as  rhrd_nd,
                    0 as  rhrd_ndot,
                    0 as  c_totalst,
                    0 as  c_totalot,
                    0 as  c_totalnd,
                    0 as  c_totalndot,
                    0 as  c_totalAmt,
                    0 as  headCount,
                    a.soaNumber,
                    a.soaDate,
                    ('.$TransmittalNo.') as TransmittalNo, 
                    a.id AS headerID, a.Location')
                    ->from('dmpi_sars a, dmpi_sar_dtls b')
                    ->join('rate_masters c', 'c.id = b.rate_id', 'left')
                    ->where('a.id = b.hdr_id')
                    ->where('a.id', $record->HdrID)
                    ->order_by('a.id', 'asc')
                    ->get();
                }elseif($record->ClientType === "ALLOWANCE"){
                    $dtls = $this->db->select('
                    a.date_transmitted as TransmittedDate, 
                    "0000-00-00" as SupervisorDate, 
                    "0000-00-00" as ManagerDate, 
                    "0000-00-00" as DataControllerDate, 
                    "0000-00-00" as BillingClerkDate, 
                    "0000-00-00" as DMPIReceivedDate, 
                    "ALLOWANCE" as activity, 
                    "" as field, 
                    b.GL as gl, 
                    b.CostCenter as cc,
                    0 as rdst,
                    0 as rdot,
                    0 as rdnd,
                    0 as rdndot,
                    0 as rtst,
                    0 as rtot,
                    0 as rtnd,
                    0 as rtndot,
                    0 as sholst,
                    0 as sholot,
                    0 as sholnd,
                    0 as sholndot,
                    0 as shrdst,
                    0 as shrdot,
                    0 as shrdnd,
                    0 as shrdndot,
                    0 as rholst,
                    0 as rholot,
                    0 as rholnd,
                    0 as rholndot,
                    0 as rhrdst,
                    0 as rhrdot,
                    0 as rhrdnd,
                    0 as rhrdndot,
                    0 as  rd_st,
                    0 as  rd_ot,
                    0 as  rd_nd,
                    0 as  rd_ndot,
                    0 as  rt_st,
                    0 as  rt_ot,
                    0 as  rt_nd,
                    0 as  rt_ndot,
                    0 as  shol_st,
                    0 as  shol_ot,
                    0 as  shol_nd,
                    0 as  shol_ndot,
                    0 as  shrd_st,
                    0 as  shrd_ot,
                    0 as  shrd_nd,
                    0 as  shrd_ndot,
                    0 as  rhol_st,
                    0 as  rhol_ot,
                    0 as  rhol_nd,
                    0 as  rhol_ndot,
                    0 as  rhrd_st,
                    0 as  rhrd_ot,
                    0 as  rhrd_nd,
                    0 as  rhrd_ndot,
                    0 as  c_totalst,
                    0 as  c_totalot,
                    0 as  c_totalnd,
                    0 as  c_totalndot,
                    b.SubTotal as  c_totalAmt,
                    0 as  headCount,
                    a.SOANo as soaNumber,
                    a.Date as soaDate,
                    a.transmittal_no as TransmittalNo, 
                    a.ASHID AS headerID, a.Location')
                    ->from('v_totalamountallowance a, tblallowancedtl b')
                    ->where('a.AHID = b.hdr_idLink')
                    ->where('a.ASHID', $record->HdrID)
                    ->order_by('a.ASHID', 'asc')
                    ->get();
                }elseif($record->ClientType === "INCENTIVES"){
                    $dtls = $this->db->select('
                    a.date_transmitted as TransmittedDate, 
                    "0000-00-00" as SupervisorDate, 
                    "0000-00-00" as ManagerDate, 
                    "0000-00-00" as DataControllerDate, 
                    "0000-00-00" as BillingClerkDate, 
                    "0000-00-00" as DMPIReceivedDate, 
                    "INCENTIVES" as activity, 
                    "" as field, 
                    b.GL as gl, 
                    b.CC as cc,
                    0 as rdst,
                    0 as rdot,
                    0 as rdnd,
                    0 as rdndot,
                    0 as rtst,
                    0 as rtot,
                    0 as rtnd,
                    0 as rtndot,
                    0 as sholst,
                    0 as sholot,
                    0 as sholnd,
                    0 as sholndot,
                    0 as shrdst,
                    0 as shrdot,
                    0 as shrdnd,
                    0 as shrdndot,
                    0 as rholst,
                    0 as rholot,
                    0 as rholnd,
                    0 as rholndot,
                    0 as rhrdst,
                    0 as rhrdot,
                    0 as rhrdnd,
                    0 as rhrdndot,
                    0 as  rd_st,
                    0 as  rd_ot,
                    0 as  rd_nd,
                    0 as  rd_ndot,
                    0 as  rt_st,
                    0 as  rt_ot,
                    0 as  rt_nd,
                    0 as  rt_ndot,
                    0 as  shol_st,
                    0 as  shol_ot,
                    0 as  shol_nd,
                    0 as  shol_ndot,
                    0 as  shrd_st,
                    0 as  shrd_ot,
                    0 as  shrd_nd,
                    0 as  shrd_ndot,
                    0 as  rhol_st,
                    0 as  rhol_ot,
                    0 as  rhol_nd,
                    0 as  rhol_ndot,
                    0 as  rhrd_st,
                    0 as  rhrd_ot,
                    0 as  rhrd_nd,
                    0 as  rhrd_ndot,
                    0 as  c_totalst,
                    0 as  c_totalot,
                    0 as  c_totalnd,
                    0 as  c_totalndot,
                    b.subAmount as  c_totalAmt,
                    0 as  headCount,
                    a.SOANo as soaNumber,
                    a.Date as soaDate,
                    a.transmittal_no as TransmittalNo, 
                    a.IHID AS headerID, b.location as Location')
                    ->from('v_totalamountincentives a, tblincentivesdtl b')
                    ->where('a.IHID = b.hdr_idLink')
                    ->where('a.IHID', $record->HdrID)
                    ->order_by('a.IHID', 'asc')
                    ->get();
                }elseif($record->ClientType === "LABNOTIN"){
                    $dtls = $this->db->select('
                    a.date_transmitted as TransmittedDate, 
                    "0000-00-00" as SupervisorDate, 
                    "0000-00-00" as ManagerDate, 
                    "0000-00-00" as DataControllerDate, 
                    "0000-00-00" as BillingClerkDate, 
                    "0000-00-00" as DMPIReceivedDate, 
                    b.Activity as activity, 
                    "" as field, 
                    b.gl, 
                    b.cc,
                    0 as rdst,
                    0 as rdot,
                    0 as rdnd,
                    0 as rdndot,
                    0 as rtst,
                    0 as rtot,
                    0 as rtnd,
                    0 as rtndot,
                    0 as sholst,
                    0 as sholot,
                    0 as sholnd,
                    0 as sholndot,
                    0 as shrdst,
                    0 as shrdot,
                    0 as shrdnd,
                    0 as shrdndot,
                    0 as rholst,
                    0 as rholot,
                    0 as rholnd,
                    0 as rholndot,
                    0 as rhrdst,
                    0 as rhrdot,
                    0 as rhrdnd,
                    0 as rhrdndot,
                    0 as  rd_st,
                    0 as  rd_ot,
                    0 as  rd_nd,
                    0 as  rd_ndot,
                    0 as  rt_st,
                    0 as  rt_ot,
                    0 as  rt_nd,
                    0 as  rt_ndot,
                    0 as  shol_st,
                    0 as  shol_ot,
                    0 as  shol_nd,
                    0 as  shol_ndot,
                    0 as  shrd_st,
                    0 as  shrd_ot,
                    0 as  shrd_nd,
                    0 as  shrd_ndot,
                    0 as  rhol_st,
                    0 as  rhol_ot,
                    0 as  rhol_nd,
                    0 as  rhol_ndot,
                    0 as  rhrd_st,
                    0 as  rhrd_ot,
                    0 as  rhrd_nd,
                    0 as  rhrd_ndot,
                    0 as  c_totalst,
                    0 as  c_totalot,
                    0 as  c_totalnd,
                    0 as  c_totalndot,
                    b.amount_billed as  c_totalAmt,
                    0 as  headCount,
                    a.SOANo as soaNumber,
                    a.Date as soaDate,
                    a.transmittal_no as TransmittalNo, 
                    a.TOCLHDR AS headerID, "LABNOTIN" as Location')
                    ->from('tbloc_labnotinhdr a, tbloc_labnotindtl b')
                    ->where('a.TOCLHDR = b.hdr_id')
                    ->where('a.TOCLHDR', $record->HdrID)
                    ->order_by('a.TOCLHDR', 'asc')
                    ->get();
                }
                
                array_push($result, [ 'hdr_id' => $record->HdrID, 'TransmittalNo' => $record->TransmittalNo, 'dtls' => $dtls->result() ? $dtls->result() : [] ]);
            }
            return $result;
        }else{
            return false;
        }
    }
    public function monthly_report_summary($from, $to, $type){
        $month_in_words = [];
        $records = [];
        $to = date("Y-m-d", strtotime('+1 month', strtotime($to)));
        if($type == 1){
            $query = $this->db->select('soaDate')
            ->from('dmpi_dar_hdrs')
            ->where("soaDate BETWEEN '".$from."' AND '".$to."'")
            ->limit(1)
            ->get();
            if(!$query->result()){
                return false;
            }
        }
        while (date('m-Y', strtotime($from)) != date('m-Y', strtotime($to))) {
            $month = date('m', (strtotime($from)));
            $year = date('Y', (strtotime($from)));

            $result['mont'] = $month;
            $result['yeer'] = $year;

            $query = $this->db
            ->select('SUM(b.totalAmt) AS UNBILLED')
            ->from('dmpi_dar_hdrs a, dmpi_dar_dtls b')
            ->where('MONTH(a.soaDate)', $month)
            ->where('YEAR(a.soaDate)', $year)
            ->where('a.id = b.hdr_id')
            ->where("a.status", 'active')
            ->group_by('MONTH(a.soaDate)')
            ->group_by('YEAR(a.soaDate)')
            ->get()
            ->row();
            if($query){
                $result['UNBILLED'] = $query->UNBILLED;
            }else{
                $result['UNBILLED'] = '0';
            }
            $query = $this->db
            ->select('(SUM(b.totalAmt) - SUM(a.PaidAmount)) AS UNPAID')
            ->from('dmpi_dar_hdrs a, dmpi_dar_dtls b')
            ->where('MONTH(a.soaDate)', $month)
            ->where('YEAR(a.soaDate)', $year)
            ->where('a.id = b.hdr_id')
            ->where("a.status", 'PRINTED TRANSMITTAL')
            ->where('DATEDIFF(NOW(), DATE_ADD(soaDate, INTERVAL 30 DAY)) < 0')
            ->group_by('MONTH(a.soaDate)')
            ->group_by('YEAR(a.soaDate)')
            ->get()
            ->row();
            if($query){
                $result['UNPAID'] = $query->UNPAID;
            }else{
                $result['UNPAID'] = '0';
            }
            $query = $this->db
            ->select('SUM(b.totalAmt) AS UNDUE')
            ->from('dmpi_dar_hdrs a, dmpi_dar_dtls b')
            ->where('MONTH(a.soaDate)', $month)
            ->where('YEAR(a.soaDate)', $year)
            ->where('a.id = b.hdr_id')
            ->where('DATEDIFF(NOW(), DATE_ADD(soaDate, INTERVAL 30 DAY)) >= 0')
            ->where("a.status <> 'active'")
            ->group_by('MONTH(a.soaDate)')
            ->group_by('YEAR(a.soaDate)')
            ->get()
            ->row();
            if($query){
                $result['UNDUE'] = $query->UNDUE;
            }else{
                $result['UNDUE'] = '0';
            }
            array_push($records, $result);  
            array_push($month_in_words, date('Y-m-d', (strtotime($from))));   
            $from = date('Y-m-d',(strtotime('next month',strtotime($from))));
        }
        return $records ? $records : false;
    }
    public function sar_transmittal($id){
        $amount = 'SELECT SUM(c.amount) FROM dmpi_sar_dtls c WHERE a.id = c.hdr_id GROUP BY c.hdr_id';
        $records = $this->db->select("*, ($amount) AS Amount")->from('dmpi_sars a, dmpi_sar_transmittal b')->where('b.id = a.transmittal_id')->where('b.id', $id)->get()->result();
        return $records ? $records : false;
    }
    public function accrual_report($from, $to, $type)
    {
        $Location = 'SELECT `Location` FROM 201filedb.tblbatch d, dmpi_dar_batches e WHERE e.DARID = a.id AND e.BID = d.BID LIMIT 1';
        $this->db
        ->select('a.id AS HdrID, a.TransmittalNo, a.detailType')
        ->from('dmpi_dar_hdrs a')
        ->where("a.soaDate BETWEEN '".$from."' AND '".$to."'")
        ->where('a.status', 'active');
        if($type == 1){
            $this->db->limit(1);
        }
        $query = $this->db->get();
        if($query->result()){
            $result = [];
            foreach($query->result() as $record){
                if($record->detailType == 1){
                    $dtls = $this->db->select('*, 
                    a.id AS headerID, ('.$Location.') AS Location,
                    rdst AS rd_st,
                    rdot AS rd_ot,
                    rdnd AS rd_nd,
                    rdndot AS rd_ndot,
                    
                    rtst AS rt_st,
                    rtot AS rt_ot,
                    rtnd AS rt_nd,
                    rtndot AS rt_ndot,

                    sholst AS shol_st,
                    sholot AS shol_ot,
                    sholnd AS shol_nd,
                    sholndot AS shol_ndot,

                    shrdst AS shrd_st,
                    shrdot AS shrd_ot,
                    shrdnd AS shrd_nd,
                    shrdndot AS shrd_ndot,

                    rholst AS rhol_st,
                    rholot AS rhol_ot,
                    rholnd AS rhol_nd,
                    rholndot AS rhol_ndot,

                    rhrdst AS rhrd_st,
                    rhrdot AS rhrd_ot,
                    rhrdnd AS rhrd_nd,
                    rhrdndot AS rhrd_ndot')
                    ->from('dmpi_dar_hdrs a, dmpi_dar_dtls b')
                    // ->where('b.rate_id = c.id')
                    ->where('a.id = b.hdr_id')
                    ->where('a.id', $record->HdrID)
                    ->order_by('a.id', 'asc')
                    ->get();
                }else{
                    $dtls = $this->db->select('*, a.id AS headerID, 
                    ('.$Location.') AS Location,
                    rdst AS rd_st,
                    rdot AS rd_ot,
                    rdnd AS rd_nd,
                    rdndot AS rd_ndot,

                    rtst AS rt_st,
                    rtot AS rt_ot,
                    rtnd AS rt_nd,
                    rtndot AS rt_ndot,

                    sholst AS shol_st,
                    sholot AS shol_ot,
                    sholnd AS shol_nd,
                    sholndot AS shol_ndot,

                    shrdst AS shrd_st,
                    shrdot AS shrd_ot,
                    shrdnd AS shrd_nd,
                    shrdndot AS shrd_ndot,

                    rholst AS rhol_st,
                    rholot AS rhol_ot,
                    rholnd AS rhol_nd,
                    rholndot AS rhol_ndot,

                    rhrdst AS rhrd_st,
                    rhrdot AS rhrd_ot,
                    rhrdnd AS rhrd_nd,
                    rhrdndot AS rhrd_ndot
                    ')->from('dmpi_dar_hdrs a, dmpi_dar_dtls b')
                    ->where('a.id = b.hdr_id')
                    ->where('a.id', $record->HdrID)
                    ->order_by('a.id', 'asc')
                    ->get();
                }
                array_push($result, [ 'hdr_id' => $record->HdrID, 'TransmittalNo' => $record->TransmittalNo, 'dtls' => $dtls->result() ? $dtls->result() : [] ]);
            }
            return $result;
        }else{
            return false;
        }
    }
    public function get_sar_per_dept($dept, $from, $to, $opt){
        $transmittal_date = "SELECT `date` FROM dmpi_sar_transmittal c WHERE a.transmittal_id = c.id";
        $transmittal_no = "SELECT `TransmittalNo` FROM dmpi_sar_transmittal c WHERE a.transmittal_id = c.id";
        $this->db->select('a.soaDate, a.controlNo, a.soaNumber, a.volumeType, b.poNumber, b.activity, b.gl, b.costCenter, b.rate, b.amount, ('.$transmittal_date.') AS TransmittalDate, ('.$transmittal_no.') AS TransmittalNo')
        ->from('dmpi_sars a, dmpi_sar_dtls b')
        ->where('a.id = b.hdr_id')
        ->where("a.periodCoveredFrom BETWEEN '".$from."' AND '".$to."'");
        if($dept !== 'ALL'){
            $this->db->where('volumeType', $dept);
        }
        if($opt == 1){
            $this->db->limit(1);
        }
        $query = $this->db->get()->result();
        return $query ? $query : false;
    }
    public function get_sar_po_report($from, $to, $opt){
        $po_qty = "SELECT qty FROM sar_po_master c WHERE c.id = a.poID";
        $po_rate = "SELECT rate FROM sar_po_master c WHERE c.id = a.poID";
        $this->db->select('a.poNumber, a.activity, a.batchDaytype, b.volumeType, a.unit, SUM(a.qty) AS totalQty, SUM(a.amount) AS totalAmt, ('.$po_qty.') AS poQty, a.rate AS poRate')
        ->from('dmpi_sar_dtls a, dmpi_sars b')
        ->where("b.id = a.hdr_id")
        ->where("b.soaDate BETWEEN '".$from."' AND '".$to."'")
        ->group_by("a.poID");
        if($opt == 1){
            $this->db->limit(1);
        }
        $query = $this->db->get()->result();
        return $query ? $query : false;
    }
    public function update_signatory($data, $transmittal){
        $sess = $this->session->userdata('gscbilling_session');
        $data['preparedBy'] = $sess['fullname'];
        $data['preparedByPosition'] = 'GSMPC-ACCOUNTING STAFF';
        $this->db->where('TransmittalNo', $transmittal)->update('dmpi_dar_hdrs', $data);
    }

    public function get_latest_soa_date($transmittal){
        $query = $this->db->select('soaDate')->from('dmpi_dar_hdrs')->where('TransmittalNo', $transmittal)->order_by('soaDate', 'desc')->limit(1)->get()->result();
        return $query ? $query[0]->soaDate : 'false';
    }
    public function get_oc_ledger_report($client){
        if($client === 'BCC'){
            $collection_date = 'SELECT GROUP_CONCAT(DATE_FORMAT(p.PayDate,\'%m/%d/%Y\') separator "<br>") as collection_date FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCSHDR = c.HdrID AND c.client = "BCC" GROUP BY c.HdrID';
            $ORNo = 'SELECT GROUP_CONCAT(p.ORNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCSHDR = c.HdrID AND c.client = "BCC" GROUP BY c.HdrID';
            $CardNo = 'SELECT GROUP_CONCAT(p.CardNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCSHDR = c.HdrID AND c.client = "BCC" GROUP BY c.HdrID';
            $amount = 'SELECT SUM(b.total) FROM tbloc_bccdtl b WHERE a.TOCSHDR = b.hdr_id GROUP BY b.hdr_id';
            $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCSHDR = c.HdrID AND client = "BCC" GROUP BY c.HdrID';
            $query = $this->db->select("a.*, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, (".$collection_date.") AS collection_date, (".$ORNo.") AS ORNo, (".$CardNo.") AS CardNo")->from('tbloc_bcchdr a')->where('a.Status', 'TRANSMITTED')->order_by('a.TOCSHDR', 'desc')->get();
            $result = $query->result() ? $query->result() : false;
        }elseif($client === 'SLERS'){
            $collection_date = 'SELECT GROUP_CONCAT(DATE_FORMAT(p.PayDate,\'%m/%d/%Y\') separator "<br>") as collection_date FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCSHDR = c.HdrID AND c.client = "SLERS" GROUP BY c.HdrID';
            $ORNo = 'SELECT GROUP_CONCAT(p.ORNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCSHDR = c.HdrID AND c.client = "SLERS" GROUP BY c.HdrID';
            $CardNo = 'SELECT GROUP_CONCAT(p.CardNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCSHDR = c.HdrID AND c.client = "SLERS" GROUP BY c.HdrID';
            $amount = 'SELECT SUM(b.total) FROM tbloc_slersdtl b WHERE a.TOCSHDR = b.hdr_id GROUP BY b.hdr_id';
            $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCSHDR = c.HdrID AND client = "SLERS" GROUP BY c.HdrID';
            $query = $this->db->select("a.*, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, (".$collection_date.") AS collection_date, (".$ORNo.") AS ORNo, (".$CardNo.") AS CardNo")->from('tbloc_slershdr a')->where('a.Status', 'TRANSMITTED')->order_by('a.TOCSHDR', 'desc')->get();
            $result = $query->result() ? $query->result() : false;
        }elseif($client === 'LABNOTIN'){
            $collection_date = 'SELECT GROUP_CONCAT(DATE_FORMAT(p.PayDate,\'%m/%d/%Y\') separator "<br>") as collection_date FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCLHDR = c.HdrID AND c.client = "LABNOTIN" GROUP BY c.HdrID';
            $ORNo = 'SELECT GROUP_CONCAT(p.ORNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCLHDR = c.HdrID AND c.client = "LABNOTIN" GROUP BY c.HdrID';
            $CardNo = 'SELECT GROUP_CONCAT(p.CardNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCLHDR = c.HdrID AND c.client = "LABNOTIN" GROUP BY c.HdrID';
            $amount = 'SELECT SUM(b.amount_billed) FROM tbloc_labnotindtl b WHERE a.TOCLHDR = b.hdr_id GROUP BY b.hdr_id';
            $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCLHDR = c.HdrID AND client = "LABNOTIN" GROUP BY c.HdrID';
            $query = $this->db->select("a.*, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, (".$collection_date.") AS collection_date, (".$ORNo.") AS ORNo, (".$CardNo.") AS CardNo")->from('tbloc_labnotinhdr a')->where('a.Status', 'TRANSMITTED')->order_by('a.TOCLHDR', 'desc')->get();
            $result = $query->result() ? $query->result() : false;
        }elseif($client === 'DEARBC'){
            $collection_date = 'SELECT GROUP_CONCAT(DATE_FORMAT(p.PayDate,\'%m/%d/%Y\') separator "<br>") as collection_date FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCDHDR = c.HdrID AND c.client = "DEARBC" GROUP BY c.HdrID';
            $ORNo = 'SELECT GROUP_CONCAT(p.ORNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCDHDR = c.HdrID AND c.client = "DEARBC" GROUP BY c.HdrID';
            $CardNo = 'SELECT GROUP_CONCAT(p.CardNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCDHDR = c.HdrID AND c.client = "DEARBC" GROUP BY c.HdrID';
            $amount = 'SELECT SUM(b.total) FROM tbloc_dearbcdtl b WHERE a.TOCDHDR = b.hdr_id GROUP BY b.hdr_id';
            $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCDHDR = c.HdrID AND client = "DEARBC" GROUP BY c.HdrID';
            $query = $this->db->select("a.*, a.date_created as Date, h.transmittal_no, h.date_transmitted, h.billing_statement, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, (".$collection_date.") AS collection_date, (".$ORNo.") AS ORNo, (".$CardNo.") AS CardNo")->from('tbloc_dearbchdr a, tbloc_dearbc h')->where('h.TOCDID = a.letter_id')->where('h.Status', 'TRANSMITTED')->order_by('a.TOCDHDR', 'desc')->get();
            $result = $query->result() ? $query->result() : false;
        }elseif($client === 'CLUBHOUSE'){
            $collection_date = 'SELECT GROUP_CONCAT(DATE_FORMAT(p.PayDate,\'%m/%d/%Y\') separator "<br>") as collection_date FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCSHDR = c.HdrID AND c.client = "CLUBHOUSE" GROUP BY c.HdrID';
            $ORNo = 'SELECT GROUP_CONCAT(p.ORNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCSHDR = c.HdrID AND c.client = "CLUBHOUSE" GROUP BY c.HdrID';
            $CardNo = 'SELECT GROUP_CONCAT(p.CardNo separator "<br>") as ORNo FROM payment_dtl p, other_client_payment_link c WHERE c.PDTLID = p.PDTLID AND a.TOCSHDR = c.HdrID AND c.client = "CLUBHOUSE" GROUP BY c.HdrID';
            $amount = 'SELECT SUM(b.total) FROM tbloc_cbdtl b WHERE a.TOCSHDR = b.hdr_id GROUP BY b.hdr_id';
            $paid = 'SELECT SUM(c.Amount) FROM other_client_payment_link c WHERE a.TOCSHDR = c.HdrID AND client = "CLUBHOUSE" GROUP BY c.HdrID';
            $query = $this->db->select("a.*, (".$amount.") AS Amount, (".$paid.") AS AmountPaid, (".$collection_date.") AS collection_date, (".$ORNo.") AS ORNo, (".$CardNo.") AS CardNo")->from('tbloc_cbhdr a')->where('a.Status', 'TRANSMITTED')->order_by('a.TOCSHDR', 'desc')->get();
            $result = $query->result() ? $query->result() : false;
        }

        return $result ? $result : false;
    }
}