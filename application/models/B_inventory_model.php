<?php

Class B_Inventory_Model extends CI_Model {

    public function get_data($type){
        if($type == 'TRUCKING'){
            $table = 'tbltruckinginventory';
        }else{
            $table = 'tblconstructioninventory';
        }
        $balance = 'IFNULL((SELECT sum(d.item_count) FROM ' . $table . ' d WHERE d.ExpenseListID_Link = h.ExpenseListID_Link GROUP BY d.ExpenseListID_Link), 0) as Balance';
        $remarks = '(SELECT Remarks FROM ' . $table . ' d WHERE d.ExpenseListID_Link = h.ExpenseListID_Link GROUP BY d.ExpenseListID_Link) as Remarks';
        $this->db->select('h.*, '.$balance.' ,'.$remarks.' ');
        $this->db->from('tblexpensespurchasesautodebit h');
        $this->db->where("h.Type", $type);
        $this->db->where("h.ExpenseCategory = 'PARTS'");
        $this->db->order_by('EPLName', "asc");
        $query = $this->db->get();
        return $query->result() ? $query->result() : false;
    }
}