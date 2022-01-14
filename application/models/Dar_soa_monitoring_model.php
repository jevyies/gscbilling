<?php

Class DAR_SOA_Monitoring_Model extends CI_Model {
    public function get_batch_by_pp($pmy, $period, $status){
        $db2 = $this->load->database('otherdb', TRUE);
        if($status === 'ALL'){
            $Amount = "SELECT SUM(b.c_totalAmt) FROM gscbilling.dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id";
            $query = $db2
            ->query("SELECT 
                b.BatchedBy AS BatchedBy, 
                SUM(b.THW_ST) AS STSum, 
                SUM(b.THW_OT) AS OTSum, 
                SUM(b.THW_ND) AS NDSum, 
                SUM(b.THW_NDOT) AS NDOTSum, 
                b.Location AS `Location`,
                GROUP_CONCAT(b.BNo) AS `Batches`, 
                a.soaNumber AS SOANumber,
                a.soaDate AS soaDate,
                a.Remarks AS Remarks,
                a.Status AS `Status`,
                a.TransmittalNo AS TransmittalNo,
                a.adminencodedby AS UploadedBy,
                a.ConfirmationBy AS ConfirmedBy,
                a.DMPIReceivedDate AS DateTransmitted,
                (".$Amount.") AS Amount,
                a.detailType AS detailType,
                b.checkFlag,
                b.BID,
                FROM gscbilling.dmpi_dar_hdrs a, tblbatch b 
                WHERE a.pmy = '$pmy' AND a.period = $period
                AND a.soaNumber = CONCAT(b.Code_Location, b.Code_Date, b.Code_Series)
                AND a.nonBatch = 0
                GROUP BY a.soaNumber
            UNION 
            SELECT 
                '' AS BatchedBy, 
                0 AS STSum, 
                0 AS OTSum, 
                0 AS NDSum, 
                0 AS NDOTSum, 
                a.Location AS `Location`,
                '' AS `Batches`, 
                a.soaNumber AS SOANumber,
                a.soaDate AS soaDate,
                a.Remarks AS Remarks,
                a.Status AS `Status`,
                a.TransmittalNo AS TransmittalNo,
                a.adminencodedby AS UploadedBy,
                a.ConfirmationBy AS ConfirmedBy,
                a.DMPIReceivedDate AS DateTransmitted,
                (".$Amount.") AS Amount,
                a.detailType AS detailType,
                1 as checkFlag,
                0 as BID
                FROM gscbilling.dmpi_dar_hdrs a 
                WHERE a.pmy = '$pmy' AND a.period = $period
                AND a.nonBatch = 1
            UNION
                SELECT 
                BatchedBy, 
                SUM(a.THW_ST) AS STSum, 
                SUM(a.THW_OT) AS OTSum, 
                SUM(a.THW_ND) AS NDSum, 
                SUM(a.THW_NDOT) AS NDOTSum, 
                a.Location, 
                'PENDING' AS `Status`,
                CONCAT(a.Code_Location, a.Code_Date, a.Code_Series) AS SOANumber,
                GROUP_CONCAT(a.BNo SEPARATOR ', ') AS `Batches`, 
                '' AS soaDate,
                '' AS Remarks,
                '' AS TransmittalNo,
                '' AS UploadedBy,
                '' AS ConfirmedBy,
                '' AS DateTransmitted,
                0 AS Amount,
                1 AS detailType,
                a.checkFlag,
                0 as BID
                FROM tblbatch a 
                WHERE a.Period = '$pmy' AND a.Phase = $period
                AND a.BID NOT IN (SELECT b.BID FROM gscbilling.dmpi_dar_batches b, gscbilling.dmpi_dar_hdrs c WHERE b.DARID = c.id AND c.pmy = '$pmy' AND a.period = $period)
                GROUP BY a.Code_Location, a.Code_Date, a.Code_Series
            ");
        }elseif($status === 'PENDING'){
            $query = $db2
            ->query("SELECT
            BatchedBy, 
            SUM(a.THW_ST) AS STSum, 
            SUM(a.THW_OT) AS OTSum, 
            SUM(a.THW_ND) AS NDSum, 
            SUM(a.THW_NDOT) AS NDOTSum, 
            a.Location, 
            'PENDING' AS `Status`,
            CONCAT(a.Code_Location, a.Code_Date, a.Code_Series) AS SOANumber,
            GROUP_CONCAT(a.BNo SEPARATOR ', ') AS `Batches`, 
            '' AS soaDate,
            '' AS Remarks,
            '' AS TransmittalNo,
            '' AS UploadedBy,
            '' AS ConfirmedBy,
            '' AS DateTransmitted,
            0 AS Amount,
            1 AS detailType,
            a.checkFlag,
            a.BID
            FROM tblbatch a 
            WHERE a.Period = '$pmy' AND a.Phase = $period
            AND a.BID NOT IN (SELECT b.BID FROM gscbilling.dmpi_dar_batches b)
            GROUP BY a.Code_Location, a.Code_Date, a.Code_Series
            ");
        }else{
            $Amount = "SELECT SUM(b.c_totalAmt) FROM gscbilling.dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id";
            $query = $db2
            ->query("SELECT 
                b.BatchedBy AS BatchedBy, 
                SUM(b.THW_ST) AS STSum, 
                SUM(b.THW_OT) AS OTSum, 
                SUM(b.THW_ND) AS NDSum, 
                SUM(b.THW_NDOT) AS NDOTSum, 
                b.Location AS `Location`,
                GROUP_CONCAT(b.BNo) AS `Batches`, 
                a.soaNumber AS SOANumber,
                a.soaDate AS soaDate,
                a.Remarks AS Remarks,
                a.Status AS `Status`,
                a.TransmittalNo AS TransmittalNo,
                a.adminencodedby AS UploadedBy,
                a.ConfirmationBy AS ConfirmedBy,
                a.DMPIReceivedDate AS DateTransmitted,
                (".$Amount.") AS Amount,
                a.detailType AS detailType,
                1 as checkFlag,
                0 as BID
                FROM gscbilling.dmpi_dar_hdrs a, gscbilling.dmpi_dar_batches c, tblbatch b
                WHERE a.pmy = '$pmy' AND a.period = $period
                AND a.nonBatch = 0
                AND a.id = c.DARID
                AND b.BID = c.BID 
                AND a.status = '$status'
                GROUP BY a.soaNumber
            UNION 
            SELECT 
                '' AS BatchedBy, 
                0 AS STSum, 
                0 AS OTSum, 
                0 AS NDSum, 
                0 AS NDOTSum, 
                a.Location AS `Location`,
                '' AS `Batches`, 
                a.soaNumber AS SOANumber,
                a.soaDate AS soaDate,
                a.Remarks AS Remarks,
                a.Status AS `Status`,
                a.TransmittalNo AS TransmittalNo,
                a.adminencodedby AS UploadedBy,
                a.ConfirmationBy AS ConfirmedBy,
                a.DMPIReceivedDate AS DateTransmitted,
                (".$Amount.") AS Amount,
                a.detailType AS detailType,
                1 as checkFlag,
                0 as BID
                FROM gscbilling.dmpi_dar_hdrs a 
                WHERE a.pmy = '$pmy' AND a.period = $period
                AND a.nonBatch = 1
                AND a.status = '$status'
            ");
        }
        if($query->result()){
            return $query->result();
        }else{
            return false;
        }
    }
    public function get_batch_by_dr($from, $to, $status){
        $db2 = $this->load->database('otherdb', TRUE);
        if($status === 'ALL'){
            $Amount = "SELECT SUM(b.c_totalAmt) FROM gscbilling.dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id";
            $query = $db2
            ->query("SELECT 
                b.BatchedBy AS BatchedBy, 
                SUM(b.THW_ST) AS STSum, 
                SUM(b.THW_OT) AS OTSum, 
                SUM(b.THW_ND) AS NDSum, 
                SUM(b.THW_NDOT) AS NDOTSum, 
                b.Location AS `Location`,
                GROUP_CONCAT(b.BNo) AS `Batches`, 
                a.soaNumber AS SOANumber,
                a.soaDate AS soaDate,
                a.Remarks AS Remarks,
                a.Status AS `Status`,
                a.TransmittalNo AS TransmittalNo,
                a.adminencodedby AS UploadedBy,
                a.ConfirmationBy AS ConfirmedBy,
                a.DMPIReceivedDate AS DateTransmitted,
                (".$Amount.") AS Amount,
                a.detailType AS detailType,
                b.checkFlag,
                b.BID
                FROM gscbilling.dmpi_dar_hdrs a, tblbatch b 
                WHERE a.DMPIReceivedDate BETWEEN '$from' AND '$to'
                AND a.soaNumber = CONCAT(b.Code_Location, b.Code_Date, b.Code_Series)
                AND a.nonBatch = 0
                GROUP BY a.soaNumber
            UNION 
            SELECT 
                '' AS BatchedBy, 
                0 AS STSum, 
                0 AS OTSum, 
                0 AS NDSum, 
                0 AS NDOTSum, 
                a.Location AS `Location`,
                '' AS `Batches`, 
                a.soaNumber AS SOANumber,
                a.soaDate AS soaDate,
                a.Remarks AS Remarks,
                a.Status AS `Status`,
                a.TransmittalNo AS TransmittalNo,
                a.adminencodedby AS UploadedBy,
                a.ConfirmationBy AS ConfirmedBy,
                a.DMPIReceivedDate AS DateTransmitted,
                (".$Amount.") AS Amount,
                a.detailType AS detailType,
                1 as checkFlag,
                0 as BID
                FROM gscbilling.dmpi_dar_hdrs a 
                WHERE a.DMPIReceivedDate BETWEEN '$from' AND '$to'
                AND a.nonBatch = 1
            UNION
                SELECT 
                BatchedBy, 
                SUM(a.THW_ST) AS STSum, 
                SUM(a.THW_OT) AS OTSum, 
                SUM(a.THW_ND) AS NDSum, 
                SUM(a.THW_NDOT) AS NDOTSum, 
                a.Location, 
                'PENDING' AS `Status`,
                CONCAT(a.Code_Location, a.Code_Date, a.Code_Series) AS SOANumber,
                GROUP_CONCAT(a.BNo SEPARATOR ', ') AS `Batches`, 
                '' AS soaDate,
                '' AS Remarks,
                '' AS TransmittalNo,
                '' AS UploadedBy,
                '' AS ConfirmedBy,
                '' AS DateTransmitted,
                0 AS Amount,
                1 AS detailType, 
                1 as checkFlag,
                0 as BID
                FROM tblbatch a 
                WHERE a.xDate BETWEEN '$from' AND '$to'
                AND a.BID NOT IN (SELECT b.BID FROM gscbilling.dmpi_dar_batches b, gscbilling.dmpi_dar_hdrs c WHERE b.DARID = c.id AND c.DMPIReceivedDate BETWEEN '$from' AND '$to')
                GROUP BY a.Code_Location, a.Code_Date, a.Code_Series
            ");
        }elseif($status === 'PENDING'){
            $query = $db2
            ->query("SELECT
            BatchedBy, 
            SUM(a.THW_ST) AS STSum, 
            SUM(a.THW_OT) AS OTSum, 
            SUM(a.THW_ND) AS NDSum, 
            SUM(a.THW_NDOT) AS NDOTSum, 
            a.Location, 
            'PENDING' AS `Status`,
            CONCAT(a.Code_Location, a.Code_Date, a.Code_Series) AS SOANumber,
            GROUP_CONCAT(a.BNo SEPARATOR ', ') AS `Batches`, 
            '' AS soaDate,
            '' AS Remarks,
            '' AS TransmittalNo,
            '' AS UploadedBy,
            '' AS ConfirmedBy,
            '' AS DateTransmitted,
            0 AS Amount,
            1 AS detailType,
            a.checkFlag,
            a.BID
            FROM tblbatch a 
            WHERE a.xDate BETWEEN '$from' AND '$to'
            AND a.BID NOT IN (SELECT b.BID FROM gscbilling.dmpi_dar_batches b)
            GROUP BY a.Code_Location, a.Code_Date, a.Code_Series
            ");
        }else{
            $Amount = "SELECT SUM(b.c_totalAmt) FROM gscbilling.dmpi_dar_dtls b WHERE a.id = b.hdr_id GROUP BY b.hdr_id";
            $query = $db2
            ->query("SELECT 
                b.BatchedBy AS BatchedBy, 
                SUM(b.THW_ST) AS STSum, 
                SUM(b.THW_OT) AS OTSum, 
                SUM(b.THW_ND) AS NDSum, 
                SUM(b.THW_NDOT) AS NDOTSum, 
                b.Location AS `Location`,
                GROUP_CONCAT(b.BNo) AS `Batches`, 
                a.soaNumber AS SOANumber,
                a.soaDate AS soaDate,
                a.Remarks AS Remarks,
                a.Status AS `Status`,
                a.TransmittalNo AS TransmittalNo,
                a.adminencodedby AS UploadedBy,
                a.ConfirmationBy AS ConfirmedBy,
                a.DMPIReceivedDate AS DateTransmitted,
                (".$Amount.") AS Amount,
                a.detailType AS detailType,
                1 as checkFlag,
                0 as BID
                FROM gscbilling.dmpi_dar_hdrs a, tblbatch b 
                WHERE a.DMPIReceivedDate BETWEEN '$from' AND '$to'
                AND a.soaNumber = CONCAT(b.Code_Location, b.Code_Date, b.Code_Series)
                AND a.nonBatch = 0
                AND a.status = '$status'
                GROUP BY a.soaNumber
            UNION 
            SELECT 
                '' AS BatchedBy, 
                0 AS STSum, 
                0 AS OTSum, 
                0 AS NDSum, 
                0 AS NDOTSum, 
                a.Location AS `Location`,
                '' AS `Batches`, 
                a.soaNumber AS SOANumber,
                a.soaDate AS soaDate,
                a.Remarks AS Remarks,
                a.Status AS `Status`,
                a.TransmittalNo AS TransmittalNo,
                a.adminencodedby AS UploadedBy,
                a.ConfirmationBy AS ConfirmedBy,
                a.DMPIReceivedDate AS DateTransmitted,
                (".$Amount.") AS Amount,
                a.detailType AS detailType,
                1 as checkFlag,
                0 as BID
                FROM gscbilling.dmpi_dar_hdrs a 
                WHERE a.DMPIReceivedDate BETWEEN '$from' AND '$to'
                AND a.nonBatch = 1
                AND a.status = '$status'
            ");
        }
        if($query->result()){
            return $query->result();
        }else{
            return false;
        }
    }

    public function get_supervisor_report($SOANumber) {
        $this->db->select("*");
        $this->db->from("dmpi_dar_hdrs h, dmpi_dar_dtls d");
        $this->db->where("h.id = d.hdr_id");
        $this->db->where("h.soaNumber", $SOANumber);
        $this->db->order_by("d.Name", "asc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function updateBatchFlag($id, $checkFlag){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('BID', $id)->update('tblbatch', ['checkFlag' => $checkFlag]);
        return $db2->affected_rows() ? true : false;
    }
}