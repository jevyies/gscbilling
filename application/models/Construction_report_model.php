<?php

Class Construction_Report_Model extends CI_Model {
    
    public function get_project_detail(){
        $this->db->select('h.DocumentDate,h.batchNo,h.DocumentNum,d.ItemDesc, d.Amt as total_Amt');
        $this->db->from('tblpohdr h, tblpodtl d');
        $this->db->where('POid = POhdrlink_id');
        $this->db->order_by('cast(h.batchNo as unsigned)', 'asc');
        $this->db->order_by('h.DocumentNum', 'asc');
        $this->db->order_by('d.ItemDesc', 'asc');
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_project_cost($date_from, $date_to, $extype, $type){
        if($type == 'all'){
            if($extype != 'ALL'){
                $condition = "expenseName = '".$extype."'";
            }else{
                $condition = '';
            }
        }else{
            $date_from = $date_from ? $date_from : '0000-00-00';
            $date_to = $date_to ? $date_to : '0000-00-00';
            if($extype == 'ALL'){
                $condition = "DocumentDate BETWEEN '".$date_from."' AND '".$date_to."'";
            }else{
                $condition = "DocumentDate BETWEEN '".$date_from."' AND '".$date_to."' AND expenseName = '".$type."'";
            }
        }
        $this->db->select('*');
        $this->db->from('direct_cost');
        if($condition != ''){
            $this->db->where($condition);
        }
        $this->db->order_by('DocumentDate', 'asc');
        $this->db->order_by('batchNo', 'asc');
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }

    public function get_project_sumall(){
        $this->db->select('*');
        $this->db->from('sum_all');
        $this->db->order_by('batchNo', 'asc');
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }
    
    public function get_project_completed($from, $to){
        $completed = ("(SELECT as_of FROM tblcollection c WHERE c.PODtlid = d.PODtlid ORDER BY collectionID desc LIMIT 1) as completed");
        $completion = ("(SELECT sum(completion) FROM tblcollection c WHERE c.PODtlid = d.PODtlid LIMIT 1) as completion");
        $this->db->select($completed . ', '. $completion . ', d.PODtlid, d.ItemDesc, h.DocumentNum, d.Amt, d.DelDate');
        $this->db->from('tblpohdr h, tblpodtl d');
        $this->db->where("h.POid=d.POhdrlink_id AND YEAR(d.DelDate) >= '".$from."' AND YEAR(d.DelDate) <= '".$to."' AND IFNULL((SELECT sum(c.completion) FROM tblcollection c WHERE c.PODtlid = d.PODtlid LIMIT 1),0) > 99");
        $this->db->order_by('d.DelDate', 'asc');
        $query = $this->db->get();

        $to_send = array();
        $temp = array();
        foreach($query->result() as $record){
            $temp['ItemDesc'] = $record->ItemDesc;
            $temp['DocumentNum'] = $record->DocumentNum;
            $temp['Amt'] = $record->Amt;
            $temp['DelDate'] = $record->DelDate;
            $temp['completed'] = $record->completed;
            $completion = $record->completion;
            if($record->completion == NULL){ // check if NONPO
                if($record->DocumentNum == 'NONPO'){
                    $completion = 100;
                }
            }
            $temp['completion'] = $completion;
            $temp['billed_date'] = '';
            $temp['cl'] = 0;
            $temp['pf'] = 0;
            $temp['gr'] = 0;
            $temp['f'] = 0;
            $temp['d'] = 0;
            $temp['c'] = 0;
            $temp['m'] = 0;
            $temp['mh'] = 0;
            $temp['total_expenses'] = 0;
            $temp['amount'] = '';
            $temp['ORNo'] = '';
            $temp['check_date'] = '';
            $temp['total_paid'] = 0;
            // EXPENSES
            $this->db->select('Expensetype, Amount');
            $this->db->from('tblpoexpense');
            $this->db->where("POiddtllink", $record->PODtlid);
            $query2 = $this->db->get();
            if($query2->result()){
                foreach($query2->result() as $expense){
                    if($expense->Expensetype == 'Contracted Labor'){
                        $temp['cl'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Professional Fee'){
                        $temp['pf'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Fare/Meal'){
                        $temp['mh'] = $expense->Amount;
                    }elseif($expense->Expensetype == "Gov't Share"){
                        $temp['gr'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Fuel'){
                        $temp['f'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Driver'){
                        $temp['d'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Electrical Installation'){
                        $temp['c'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Materials'){
                        $temp['m'] = $expense->Amount;
                    }
                    $temp['total_expenses'] += $expense->Amount;
                }
            }
            // Billed date
            $this->db->select('soaDate, percentAdvance');
            $this->db->from('tblsoa');
            $this->db->where("PODtlid", $record->PODtlid);
            $this->db->order_by('soaID', 'asc');
            $query3 = $this->db->get();
            if($query3->result()){
                foreach($query3->result() as $bd){
                    $percentage = $bd->percentAdvance == 0 ? '' : '(' . $bd->percentAdvance . '%)';
                    $temp['billed_date'] .= date('d-m-Y', strtotime($bd->soaDate)) . $percentage .' <br>';
                }
            }
            // Collection
            $query4 = $this->db->query("SELECT p.check_amount, p.orNumber, p.check_date FROM tblsoa s LEFT JOIN tblconstructionpayment p ON s.soaID = p.hdr_idLink WHERE s.PODtlid = ".$record->PODtlid." ORDER BY p.check_date desc");
            if($query4->result()){
                foreach($query4->result() as $payment){
                    $temp['amount'] .= $payment->check_amount == NULL ? '' : number_format((float)$payment->check_amount, 2, '.', ',') . ' <br>';
                    $temp['ORNo'] .= $payment->orNumber == NULL ? '' : $payment->orNumber . ' <br>';
                    $temp['check_date'] .= $payment->check_date == NULL ? '' : date('d-m-Y', strtotime($payment->check_date)) . ' <br>';
                    $temp['total_paid'] += $payment->check_amount == NULL ? 0 : $payment->check_amount;
                }
            }
            array_push($to_send, $temp);
        }
        $records = $to_send;
        return $records ? $records : false;
    }

    public function get_project_ongoing(){
        $completed = ("(SELECT as_of FROM tblcollection c WHERE c.PODtlid = d.PODtlid ORDER BY collectionID desc LIMIT 1) as completed");
        $completion = ("(SELECT sum(completion) FROM tblcollection c WHERE c.PODtlid = d.PODtlid LIMIT 1) as completion");
        $query = $this->db->query("SELECT ".$completed.", ".$completion.", d.PODtlid, d.ItemDesc, h.DocumentNum, d.Amt, d.DelDate from tblpohdr h, tblpodtl d WHERE h.POid=d.POhdrlink_id AND IFNULL((SELECT sum(c.completion) FROM tblcollection c WHERE c.PODtlid = d.PODtlid LIMIT 1),0) < 100 ORDER BY d.DelDate asc");

        $to_send = array();
        $temp = array();
        foreach($query->result() as $record){
            $temp['ItemDesc'] = $record->ItemDesc;
            $temp['DocumentNum'] = $record->DocumentNum;
            $temp['Amt'] = $record->Amt;
            $temp['DelDate'] = $record->DelDate;
            $temp['completed'] = $record->completed;
            $completion = $record->completion;
            if($record->completion == NULL){ // check if NONPO
                if($record->DocumentNum == 'NONPO'){
                    $completion = 100;
                }
            }
            $temp['completion'] = $completion;
            $temp['billed_date'] = '';
            $temp['cl'] = 0;
            $temp['pf'] = 0;
            $temp['gr'] = 0;
            $temp['f'] = 0;
            $temp['d'] = 0;
            $temp['c'] = 0;
            $temp['m'] = 0;
            $temp['mh'] = 0;
            $temp['total_expenses'] = 0;
            $temp['amount'] = '';
            $temp['ORNo'] = '';
            $temp['check_date'] = '';
            $temp['total_paid'] = 0;
            // EXPENSES
            $query2 = $this->db->query("SELECT Expensetype, Amount FROM tblpoexpense WHERE POiddtllink = ".$record->PODtlid);
            if($query2->result()){
                foreach($query2->result() as $expense){
                    if($expense->Expensetype == 'Contracted Labor'){
                        $temp['cl'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Professional Fee'){
                        $temp['pf'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Fare/Meal'){
                        $temp['mh'] = $expense->Amount;
                    }elseif($expense->Expensetype == "Gov't Share"){
                        $temp['gr'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Fuel'){
                        $temp['f'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Driver'){
                        $temp['d'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Electrical Installation'){
                        $temp['c'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Materials'){
                        $temp['m'] = $expense->Amount;
                    }
                    $temp['total_expenses'] += $expense->Amount;
                }
            }
            // Billed date
            $query3 = $this->db->query("SELECT soaDate, percentAdvance FROM tblsoa WHERE PODtlid = ".$record->PODtlid." ORDER BY soaID asc");
            if($query3->result()){
                foreach($query3->result() as $bd){
                    $percentage = $bd->percentAdvance == 0 ? '' : '(' . $bd->percentAdvance . '%)';
                    $temp['billed_date'] .= date('d-m-Y', strtotime($bd->soaDate)) . $percentage .' <br>';
                }
            }
            // Collection
            $query4 = $this->db->query("SELECT p.check_amount, p.orNumber, p.check_date FROM tblsoa s LEFT JOIN tblconstructionpayment p ON s.soaID = p.hdr_idLink WHERE s.PODtlid = ".$record->PODtlid." ORDER BY p.check_date desc");
            if($query4->result()){
                foreach($query4->result() as $payment){
                    $temp['amount'] .= $payment->check_amount == NULL ? '' : number_format((float)$payment->check_amount, 2, '.', ',') . ' <br>';
                    $temp['ORNo'] .= $payment->orNumber == NULL ? '' : $payment->orNumber . ' <br>';
                    $temp['check_date'] .= $payment->check_date == NULL ? '' : date('d-m-Y', strtotime($payment->check_date)) . ' <br>';
                    $temp['total_paid'] += $payment->check_amount == NULL ? 0 : $payment->check_amount;
                }
            }
            array_push($to_send, $temp);
        }
        $records = $to_send;
        return $records ? $records : false;
    }

    public function get_project_unpaid($unpaid_year){
        $completed = ("(SELECT as_of FROM tblcollection c WHERE c.PODtlid = d.PODtlid ORDER BY collectionID desc LIMIT 1) as completed");
        $completion = ("(SELECT sum(completion) FROM tblcollection c WHERE c.PODtlid = d.PODtlid LIMIT 1) as completion");
        $query = $this->db->query("SELECT ".$completed.", ".$completion.", d.PODtlid, d.ItemDesc, h.DocumentNum, d.Amt, d.DelDate from tblpohdr h, tblpodtl d WHERE h.POid=d.POhdrlink_id AND IFNULL((SELECT sum(c.check_amount) FROM tblconstructionpayment c, tblsoa s WHERE s.soaID = c.hdr_idLink AND d.PODtlid = s.PODtlid GROUP BY s.PODtlid),0) < d.Amt AND YEAR(d.DelDate) = ".$unpaid_year." ORDER BY d.DelDate asc");

        $to_send = array();
        $temp = array();
        foreach($query->result() as $record){
            $temp['ItemDesc'] = $record->ItemDesc;
            $temp['DocumentNum'] = $record->DocumentNum;
            $temp['Amt'] = $record->Amt;
            $temp['DelDate'] = $record->DelDate;
            $temp['completed'] = $record->completed;
            $temp['completed'] = $record->completed;
            $completion = $record->completion;
            if($record->completion == NULL){ // check if NONPO
                if($record->DocumentNum == 'NONPO'){
                    $completion = 100;
                }
            }
            $temp['completion'] = $completion;
            $temp['billed_date'] = '';
            $temp['cl'] = 0;
            $temp['pf'] = 0;
            $temp['gr'] = 0;
            $temp['f'] = 0;
            $temp['d'] = 0;
            $temp['c'] = 0;
            $temp['m'] = 0;
            $temp['mh'] = 0;
            $temp['total_expenses'] = 0;
            $temp['amount'] = '';
            $temp['ORNo'] = '';
            $temp['check_date'] = '';
            $temp['total_paid'] = 0;
            // EXPENSES
            $query2 = $this->db->query("SELECT Expensetype, Amount FROM tblpoexpense WHERE POiddtllink = ".$record->PODtlid);
            if($query2->result()){
                foreach($query2->result() as $expense){
                    if($expense->Expensetype == 'Contracted Labor'){
                        $temp['cl'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Professional Fee'){
                        $temp['pf'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Fare/Meal'){
                        $temp['mh'] = $expense->Amount;
                    }elseif($expense->Expensetype == "Gov't Share"){
                        $temp['gr'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Fuel'){
                        $temp['f'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Driver'){
                        $temp['d'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Electrical Installation'){
                        $temp['c'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Materials'){
                        $temp['m'] = $expense->Amount;
                    }
                    $temp['total_expenses'] += $expense->Amount;
                }
            }
            // Billed date
            $query3 = $this->db->query("SELECT soaDate, percentAdvance FROM tblsoa WHERE PODtlid = ".$record->PODtlid." ORDER BY soaID asc");
            if($query3->result()){
                foreach($query3->result() as $bd){
                    $percentage = $bd->percentAdvance == 0 ? '' : '(' . $bd->percentAdvance . '%)';
                    $temp['billed_date'] .= date('d-m-Y', strtotime($bd->soaDate)) . $percentage .' <br>';
                }
            }
            // Collection
            $query4 = $this->db->query("SELECT p.check_amount, p.orNumber, p.check_date FROM tblsoa s LEFT JOIN tblconstructionpayment p ON s.soaID = p.hdr_idLink WHERE s.PODtlid = ".$record->PODtlid." ORDER BY p.check_date desc");
            if($query4->result()){
                foreach($query4->result() as $payment){
                    $temp['amount'] .= $payment->check_amount == NULL ? '' : number_format((float)$payment->check_amount, 2, '.', ',') . ' <br>';
                    $temp['ORNo'] .= $payment->orNumber == NULL ? '' : $payment->orNumber . ' <br>';
                    $temp['check_date'] .= $payment->check_date == NULL ? '' : date('d-m-Y', strtotime($payment->check_date)) . ' <br>';
                    $temp['total_paid'] += $payment->check_amount == NULL ? 0 : $payment->check_amount;
                }
            }
            array_push($to_send, $temp);
        }
        $records = $to_send;

        return $records ? $records : false;
    }

    public function get_project_to($month){
        $completed = ("(SELECT as_of FROM tblcollection c WHERE c.PODtlid = d.PODtlid ORDER BY collectionID desc LIMIT 1) as completed");
        $completion = ("(SELECT sum(completion) FROM tblcollection c WHERE c.PODtlid = d.PODtlid LIMIT 1) as completion");
        $query = $this->db->query("SELECT ".$completed.", ".$completion.", d.PODtlid, d.ItemDesc, h.DocumentNum, d.Amt, d.DelDate from tblpohdr h, tblpodtl d WHERE h.POid=d.POhdrlink_id AND IFNULL((SELECT sum(c.check_amount) FROM tblconstructionpayment c, tblsoa s WHERE s.soaID = c.hdr_idLink AND d.PODtlid = s.PODtlid GROUP BY s.PODtlid),0) < d.Amt AND YEAR(d.DelDate) <= ".date('Y', strtotime($month))." AND MONTH(d.DelDate) <= ".date('m', strtotime($month))." ORDER BY d.DelDate asc");

        $to_send = array();
        $temp = array();
        foreach($query->result() as $record){
            $temp['ItemDesc'] = $record->ItemDesc;
            $temp['DocumentNum'] = $record->DocumentNum;
            $temp['Amt'] = $record->Amt;
            $temp['DelDate'] = $record->DelDate;
            $temp['completed'] = $record->completed;
            $completion = $record->completion;
            if($record->completion == NULL){ // check if NONPO
                if($record->DocumentNum == 'NONPO'){
                    $completion = 100;
                }
            }
            $temp['completion'] = $completion;
            $temp['billed_date'] = '';
            $temp['cl'] = 0;
            $temp['pf'] = 0;
            $temp['gr'] = 0;
            $temp['f'] = 0;
            $temp['d'] = 0;
            $temp['c'] = 0;
            $temp['m'] = 0;
            $temp['mh'] = 0;
            $temp['total_expenses'] = 0;
            $temp['amount'] = '';
            $temp['ORNo'] = '';
            $temp['check_date'] = '';
            $temp['total_paid'] = 0;
            // EXPENSES
            $query2 = $this->db->query("SELECT Expensetype, Amount FROM tblpoexpense WHERE POiddtllink = ".$record->PODtlid);
            if($query2->result()){
                foreach($query2->result() as $expense){
                    if($expense->Expensetype == 'Contracted Labor'){
                        $temp['cl'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Professional Fee'){
                        $temp['pf'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Fare/Meal'){
                        $temp['mh'] = $expense->Amount;
                    }elseif($expense->Expensetype == "Gov't Share"){
                        $temp['gr'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Fuel'){
                        $temp['f'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Driver'){
                        $temp['d'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Electrical Installation'){
                        $temp['c'] = $expense->Amount;
                    }elseif($expense->Expensetype == 'Materials'){
                        $temp['m'] = $expense->Amount;
                    }
                    $temp['total_expenses'] += $expense->Amount;
                }
            }
            // Billed date
            $query3 = $this->db->query("SELECT soaDate, percentAdvance FROM tblsoa WHERE PODtlid = ".$record->PODtlid." ORDER BY soaID asc");
            if($query3->result()){
                foreach($query3->result() as $bd){
                    $percentage = $bd->percentAdvance == 0 ? '' : '(' . $bd->percentAdvance . '%)';
                    $temp['billed_date'] .= date('d-m-Y', strtotime($bd->soaDate)) . $percentage .' <br>';
                }
            }
            // Collection
            $query4 = $this->db->query("SELECT p.check_amount, p.orNumber, p.check_date FROM tblsoa s LEFT JOIN tblconstructionpayment p ON s.soaID = p.hdr_idLink WHERE s.PODtlid = ".$record->PODtlid." ORDER BY p.check_date desc");
            if($query4->result()){
                foreach($query4->result() as $payment){
                    $temp['amount'] .= $payment->check_amount == NULL ? '' : number_format((float)$payment->check_amount, 2, '.', ',') . ' <br>';
                    $temp['ORNo'] .= $payment->orNumber == NULL ? '' : $payment->orNumber . ' <br>';
                    $temp['check_date'] .= $payment->check_date == NULL ? '' : date('d-m-Y', strtotime($payment->check_date)) . ' <br>';
                    $temp['total_paid'] += $payment->check_amount == NULL ? 0 : $payment->check_amount;
                }
            }
            array_push($to_send, $temp);
        }
        $records = $to_send;

        return $records ? $records : false;
    }

    public function get_project_collection($month){
        $query = $this->db->query("SELECT s.soaID, s.soaDate, s.billing_statement, d.ItemDesc, d.Amt FROM tblpodtl d, tblsoa s WHERE d.PODtlid = s.PODtlid AND YEAR(s.soaDate) = ".date('Y', strtotime($month))." AND MONTH(s.soaDate) = ".date('m', strtotime($month))." ORDER BY s.soaDate asc");

        $to_send = array();
        $temp = array();
        foreach($query->result() as $record){
            $temp['ItemDesc'] = $record->ItemDesc;
            $temp['SOADate'] = $record->soaDate;
            $temp['billing_statement'] = $record->billing_statement;
            $temp['Amt'] = $record->Amt;
            $temp['amount'] = '';
            $temp['ORNo'] = '';
            $temp['check_date'] = '';
            $temp['check_no'] = '';
            $temp['total_paid'] = 0;
            // Collection
            $query4 = $this->db->query("SELECT p.check_amount, p.orNumber, p.check_date, p.check_no FROM tblsoa s LEFT JOIN tblconstructionpayment p ON s.soaID = p.hdr_idLink WHERE s.soaID = ".$record->soaID." ORDER BY p.check_date desc");
            if($query4->result()){
                foreach($query4->result() as $payment){
                    $temp['amount'] .= $payment->check_amount == NULL ? '' : number_format((float)$payment->check_amount, 2, '.', ',') . ' <br>';
                    $temp['ORNo'] .= $payment->orNumber == NULL ? '' : $payment->orNumber . ' <br>';
                    $temp['check_date'] .= $payment->check_date == NULL ? '' : date('d-m-Y', strtotime($payment->check_date)) . ' <br>';
                    $temp['check_no'] .= $payment->check_no == NULL ? '' : $payment->check_no . ' <br>';
                    $temp['total_paid'] += $payment->check_amount == NULL ? 0 : $payment->check_amount;
                }
            }
            array_push($to_send, $temp);
        }
        $records = $to_send;

        return $records ? $records : false;
    }

    public function get_project_ledger($PODtlid){
        $completed = ("(SELECT as_of FROM tblcollection c WHERE c.PODtlid = d.PODtlid ORDER BY collectionID desc LIMIT 1) as completed");
        $completion = ("(SELECT sum(completion) FROM tblcollection c WHERE c.PODtlid = d.PODtlid LIMIT 1) as completion");
        $query = $this->db->query("SELECT ".$completed.", ".$completion.", d.PODtlid, d.ItemDesc, h.DocumentNum, d.Amt, d.DelDate from tblpohdr h, tblpodtl d WHERE h.POid=d.POhdrlink_id AND d.PODtlid = ".$PODtlid);

        $to_send = array();
        $temp = array();
        foreach($query->result() as $record){
            $temp['ItemDesc'] = $record->ItemDesc;
            $temp['DocumentNum'] = $record->DocumentNum;
            $temp['Amt'] = $record->Amt;
            $temp['DelDate'] = $record->DelDate;
            $temp['completed'] = $record->completed;
            $completion = $record->completion;
            if($record->completion == NULL){ // check if NONPO
                if($record->DocumentNum == 'NONPO'){
                    $completion = 100;
                }
            }
            $temp['completion'] = $completion;
            $temp['total_paid'] = 0;
            $temp['direcr_labor'] = [];
            $temp['direcr_materials'] = [];
            $temp['overhead'] = [];
            $temp['total_billed'] = 0;
            // EXPENSES
            // direct labor
            $query2 = $this->db->query("SELECT Expensetype, Amount FROM tblpoexpense WHERE TRIM(expenseName) = 'Direct Labor' AND POiddtllink = ".$record->PODtlid);
            if($query2->result()){
                foreach($query2->result() as $expense){
                    array_push($temp['direcr_labor'], $expense);
                }
            }
            // direct materials
            $query2 = $this->db->query("SELECT 'Materials' as Expensetype, amtdue as Amount FROM tblmaterialsdtl WHERE POdtlid = ".$record->PODtlid);
            if($query2->result()){
                foreach($query2->result() as $expense){
                    array_push($temp['direcr_materials'], $expense);
                }
            }
            // direct labor
            $query2 = $this->db->query("SELECT Expensetype, Amount FROM tblpoexpense WHERE TRIM(expenseName) = 'Overhead' AND POiddtllink = ".$record->PODtlid);
            if($query2->result()){
                foreach($query2->result() as $expense){
                    array_push($temp['overhead'], $expense);
                }
            }
            // Billed date
            $query3 = $this->db->query("SELECT amountInFigure FROM tblsoa WHERE PODtlid = ".$record->PODtlid);
            if($query3->result()){
                foreach($query3->result() as $bd){
                    $temp['total_billed'] += $bd->amountInFigure == NULL ? 0 : $bd->amountInFigure;
                }
            }
            // Collection
            $query4 = $this->db->query("SELECT p.check_amount FROM tblsoa s LEFT JOIN tblconstructionpayment p ON s.soaID = p.hdr_idLink WHERE s.PODtlid = ".$record->PODtlid." ORDER BY p.check_date desc");
            if($query4->result()){
                foreach($query4->result() as $payment){
                    $temp['total_paid'] += $payment->check_amount == NULL ? 0 : $payment->check_amount;
                }
            }
            array_push($to_send, $temp);
        }
        $records = $to_send;

        return $records ? $records : false;
    }

    public function get_expense_details($PODtlid){
        $query = $this->db->query("SELECT ItemDesc from tblpodtl WHERE PODtlid = ".$PODtlid);
        $to_send = array(
            'project_name' => $query->result()[0]->ItemDesc,
            'direcr_materials' => [],
            'overhead' => []
        );
        // direct materials
        $query2 = $this->db->query("SELECT * FROM tblmaterialshdr h, tblmaterialsdtl d WHERE h.materialshdrID = d.materialshdrLinkID AND h.POdtlid = ".$PODtlid);
        if($query2->result()){
            foreach($query2->result() as $expense){
                array_push($to_send['direcr_materials'], $expense);
            }
        }
        // overhead
        $query2 = $this->db->query("SELECT * FROM tbloverheadhdr h, tbloverheaddtl d WHERE h.materialshdrID = d.materialshdrLinkID AND h.POdtlid = ".$PODtlid);
        if($query2->result()){
            foreach($query2->result() as $expense){
                array_push($to_send['overhead'], $expense);
            }
        }
        $records = $to_send;

        return $records ? $records : false;
    }
    // include others billing reports
    public function get_others2($SOANo){
        $query = $this->db->query("SELECT h.*, d.*, t.TotalAmount from tblothershdr h, tblothersdtl d, v_totalamountothers t WHERE h.OHID = t.OHID AND h.OHID = d.hdr_idLink AND h.SOANo = '" . $SOANo . "' ORDER BY d.Description asc");
        return $query->result() ? $query->result() : false;
    }
    // include other income transmittal
    public function get_transmittal_report($type, $transmittal_no){
        if($type == 'ALLOWANCE'){
            $billed_amount = "(SELECT sum(SubTotal) FROM tblallowancedtl d WHERE d.hdr_idLink = h.hdr_idLink GROUP BY d.hdr_idLink)";
            $ST = "(SELECT sum(manDays) FROM tblallowancedtl d WHERE d.hdr_idLink = h.hdr_idLink GROUP BY d.hdr_idLink) as ST";
            $HC = "(SELECT COUNT(Chapa) FROM tblallowancedtl d WHERE d.hdr_idLink = h.hdr_idLink GROUP BY d.hdr_idLink) as HC";
            $query = $this->db->query("SELECT h.*, t.*, ".$billed_amount." AS billed_amount,".$ST.",".$HC.", h.Date as date_report FROM tblallowancesoahdr h, tblothertransmittal t WHERE h.transmittal_no = '" . $transmittal_no . "' AND t.transmittal_no = h.transmittal_no ORDER BY h.Date asc");
        }elseif($type == 'PPE'){
            $billed_amount = "(SELECT sum(SubAmount) FROM tblppedtl d WHERE d.hdr_idLink = h.PHID GROUP BY d.hdr_idLink)";
            $invoice_no = "(SELECT InvoiceNo FROM tblppedtl d WHERE d.hdr_idLink = h.PHID GROUP BY d.hdr_idLink)";
            $query = $this->db->query("SELECT h.*, t.*, ".$billed_amount." AS billed_amount, ".$invoice_no." AS InvoiceNo FROM tblppehdr h, tblothertransmittal t WHERE h.transmittal_no = '" . $transmittal_no . "' AND t.transmittal_no = h.transmittal_no ORDER BY h.SOADate asc");
        }elseif($type == 'FUEL'){
            $billed_amount = "(SELECT sum(SubAmount) FROM tblfueldtl d WHERE d.hdr_idLink = h.FHID GROUP BY d.hdr_idLink)";
            $invoice_no = "(SELECT InvoiceNo FROM tblfueldtl d WHERE d.hdr_idLink = h.FHID GROUP BY d.hdr_idLink)";
            $query = $this->db->query("SELECT h.*, t.*, ".$billed_amount." AS billed_amount, ".$invoice_no." AS InvoiceNo FROM tblfuelhdr h, tblothertransmittal t WHERE h.transmittal_no = '" . $transmittal_no . "' AND t.transmittal_no = h.transmittal_no ORDER BY h.SOADate asc");
        }elseif($type == 'SUPPLIES'){
            $billed_amount = "(SELECT sum(SubAmount) FROM tblsupdtl d WHERE d.hdr_idLink = h.SHID GROUP BY d.hdr_idLink)";
            $invoice_no = "(SELECT InvoiceNo FROM tblsupdtl d WHERE d.hdr_idLink = h.SHID GROUP BY d.hdr_idLink)";
            $query = $this->db->query("SELECT h.*, t.*, ".$billed_amount." AS billed_amount, ".$invoice_no." AS InvoiceNo FROM tblsuphdr h, tblothertransmittal t WHERE h.transmittal_no = '" . $transmittal_no . "' AND t.transmittal_no = h.transmittal_no ORDER BY h.SOADate asc");
        }elseif($type == 'OTHERS'){
            $billed_amount = "(SELECT sum(SubAmount) FROM tblothersdtl d WHERE d.hdr_idLink = h.OHID GROUP BY d.hdr_idLink)";
            $invoice_no = "(SELECT InvoiceNo FROM tblothersdtl d WHERE d.hdr_idLink = h.OHID GROUP BY d.hdr_idLink)";
            $query = $this->db->query("SELECT h.*, t.*, ".$billed_amount." AS billed_amount, ".$invoice_no." AS InvoiceNo FROM tblothershdr h, tblothertransmittal t WHERE h.transmittal_no = '" . $transmittal_no . "' AND t.transmittal_no = h.transmittal_no ORDER BY h.SOADate asc");
        }elseif($type == 'INCENTIVES'){
            $ST = "(SELECT sum(mhrs) FROM tblincentivesdtl d WHERE d.hdr_idLink = h.IHID GROUP BY d.hdr_idLink) as ST";
            $HC = "(SELECT COUNT(Chapa) FROM tblincentivesdtl d WHERE d.hdr_idLink = h.IHID GROUP BY d.hdr_idLink) as HC";
            $billed_amount = "(SELECT sum(SubAmount) FROM tblincentivesdtl d WHERE d.hdr_idLink = h.IHID GROUP BY d.hdr_idLink)";
            $invoice_no = "(SELECT InvoiceNo FROM tblincentivesdtl d WHERE d.hdr_idLink = h.IHID GROUP BY d.hdr_idLink)";
            $query = $this->db->query("SELECT h.*, t.*, ".$billed_amount." AS billed_amount,".$ST.",".$HC.", ".$invoice_no." AS InvoiceNo FROM tblincentiveshdr h, tblothertransmittal t WHERE h.transmittal_no = '" . $transmittal_no . "' AND t.transmittal_no = h.transmittal_no ORDER BY h.SOADate asc");
        }
        return $query->result() ? $query->result() : false;
    }
}