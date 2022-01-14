<?php

Class Trucking_Overall_Model extends CI_Model {

    public function get_report($data){
        $wingvan_collection = "SELECT SUM(b.amount) from wingvan_payment b WHERE a.soaid_link = b.soa_link GROUP BY b.soa_link";
        $liftruck_collection = "SELECT SUM(b.amount) from liftruck_payment b WHERE a.soaid_link = b.soa_link GROUP BY b.soa_link";

        // DAILY GOLFCART
        $GCActualExpense = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.gcid_link";
        $GCGPS = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%GPS%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.gcid_link";
        $GCGovt = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Government%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.gcid_link";
        $GCDepreciation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Depreciation%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.gcid_link";
        $GCSeparation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Separation%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.gcid_link";
        $GCTraining = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Training%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.gcid_link";
        $GCWater = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Water%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.gcid_link";
        $GCTransportation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Transportation%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.gcid_link";
        $GCTravelling = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Travelling%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.gcid_link";

        // DAILY PHB
        $PHBActualExpense = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND c.EHDate = a.PHBVLDate AND d.VehicleID_Link = a.PHBIDLink";
        $PHBGPS = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%GPS%' AND c.EHDate = a.PHBVLDate AND d.VehicleID_Link = a.PHBIDLink";
        $PHBGovt = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Government%' AND c.EHDate = a.PHBVLDate AND d.VehicleID_Link = a.PHBIDLink";
        $PHBDepreciation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Depreciation%' AND c.EHDate = a.PHBVLDate AND d.VehicleID_Link = a.PHBIDLink";
        $PHBSeparation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Separation%' AND c.EHDate = a.PHBVLDate AND d.VehicleID_Link = a.PHBIDLink";
        $PHBTraining = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Training%' AND c.EHDate = a.PHBVLDate AND d.VehicleID_Link = a.PHBIDLink";
        $PHBWater = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Water%' AND c.EHDate = a.PHBVLDate AND d.VehicleID_Link = a.PHBIDLink";
        $PHBTransportation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Transportation%' AND c.EHDate = a.PHBVLDate AND d.VehicleID_Link = a.PHBIDLink";
        $PHBTravelling = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Travelling%' AND c.EHDate = a.PHBVLDate AND d.VehicleID_Link = a.PHBIDLink";

        // DAILY OVL
        $OVLActualExpense = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND c.EHDate = a.OVLVLDate AND d.VehicleID_Link = a.OVLIDLink";
        $OVLGPS = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%GPS%' AND c.EHDate = a.OVLVLDate AND d.VehicleID_Link = a.OVLIDLink";
        $OVLGovt = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Government%' AND c.EHDate = a.OVLVLDate AND d.VehicleID_Link = a.OVLIDLink";
        $OVLDepreciation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Depreciation%' AND c.EHDate = a.OVLVLDate AND d.VehicleID_Link = a.OVLIDLink";
        $OVLSeparation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Separation%' AND c.EHDate = a.OVLVLDate AND d.VehicleID_Link = a.OVLIDLink";
        $OVLTraining = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Training%' AND c.EHDate = a.OVLVLDate AND d.VehicleID_Link = a.OVLIDLink";
        $OVLWater = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Water%' AND c.EHDate = a.OVLVLDate AND d.VehicleID_Link = a.OVLIDLink";
        $OVLTransportation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Transportation%' AND c.EHDate = a.OVLVLDate AND d.VehicleID_Link = a.OVLIDLink";
        $OVLTravelling = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Travelling%' AND c.EHDate = a.OVLVLDate AND d.VehicleID_Link = a.OVLIDLink";

        // DAILY WINGVAN
        $WVActualExpense = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $WVGPS = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%GPS%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $WVGovt = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Government%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $WVDepreciation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Depreciation%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $WVSeparation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Separation%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $WVTraining = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Training%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $WVWater = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Water%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $WVTransportation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Transportation%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $WVTravelling = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Travelling%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";

        // DAILY LIFTRUCK
        $LFActualExpense = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $LFGPS = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%GPS%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $LFGovt = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Government%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $LFDepreciation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Depreciation%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $LFSeparation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Separation%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $LFTraining = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Training%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $LFWater = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Water%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $LFTransportation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Transportation%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";
        $LFTravelling = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Travelling%' AND c.EHDate = a.date AND d.VehicleID_Link = a.vehicle_id";

        // DAILY OTHERS
        $OVActualExpense = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.vehicle_id";
        $OVGPS = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%GPS%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.vehicle_id";
        $OVGovt = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Government%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.vehicle_id";
        $OVDepreciation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Depreciation%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.vehicle_id";
        $OVSeparation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Separation%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.vehicle_id";
        $OVTraining = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Training%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.vehicle_id";
        $OVWater = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Water%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.vehicle_id";
        $OVTransportation = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Transportation%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.vehicle_id";
        $OVTravelling = "SELECT SUM(d.AmountDue) FROM tblexpensedtl_trucking d, tblexpensehdr_trucking c WHERE c.EHDRID = d.EHDRID_Link AND d.ExpenseListName LIKE '%Travelling%' AND c.EHDate = a.trans_date AND d.VehicleID_Link = a.vehicle_id";

        
        if($data['generate'] == 1){
            $query = $this->db->query("
            (   SELECT 
                    CONVERT(golfcart_no USING utf8) AS UnitNo, 
                    trans_date AS IEDate, 
                    trans_date AS VLNo,
                    gcid_link AS Location,
                    id AS Operator,
                    debit_amount AS BillAmount,
                    credit_amount AS Collection,
                    0 AS FuelLiter, 
                    0 AS FuelAmount,
                    0 AS AdminCost,
                    0 AS MaintenanceCost,
                    0 AS ExtraRun,
                    0 AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    0 AS Helper,
                    (".$GCActualExpense.") AS ActualExpense,
                    (".$GCGPS.") AS GPS,
                    (".$GCGovt.") AS Government,
                    (".$GCDepreciation.") AS Depreciation,
                    (".$GCSeparation.") AS Separation,
                    (".$GCTraining.") AS Training,
                    (".$GCWater.") AS Water,
                    (".$GCTransportation.") AS Transportation,
                    (".$GCTravelling.") AS Travelling,
                    '' AS LaborType
                FROM golf_cart_ledger a WHERE trans_date BETWEEN '".$data['from']."' AND '".$data['to']."' AND type = 'TRANSACTION'
            )
            UNION 
            (   SELECT 
                    CONVERT(PHBPlateNo USING utf8) AS UnitNo, 
                    PHBVLDate AS IEDate, 
                    OVLNo AS VLNo,
                    LocationName AS Location,
                    DriverName AS Operator,
                    BillAmount AS BillAmount,
                    CollectedAmount AS Collection,
                    FuelLiters AS FuelLiter,
                    FuelAmount AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MaintenanceCost AS MaintenanceCost,
                    ExtraRunAmount AS ExtraRun,
                    0 AS Labor,
                    Labor AS Daily,
                    0 AS Loaders,
                    Helper AS Helper,
                    (".$PHBActualExpense.") AS ActualExpense,
                    (".$PHBGPS.") AS GPS,
                    (".$PHBGovt.") AS Government,
                    (".$PHBDepreciation.") AS Depreciation,
                    (".$PHBSeparation.") AS Separation,
                    (".$PHBTraining.") AS Training,
                    (".$PHBWater.") AS Water,
                    (".$PHBTransportation.") AS Transportation,
                    (".$PHBTravelling.") AS Travelling,
                    OVLType AS LaborType
                FROM tblphbvehicleloghdr a WHERE PHBVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'
            )
            UNION 
            (   SELECT 
                    CONVERT(OVLPlateNo USING utf8) AS UnitNo, 
                    OVLVLDate AS IEDate, 
                    OVLNo AS VLNo,
                    LocationFrom AS Location,
                    DriverName AS Operator,
                    BillAmount AS BillAmount,
                    CollectedAmount AS Collection,
                    FuelLiters AS FuelLiter,
                    LessFuel AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MaintenanceCost AS MaintenanceCost,
                    0 AS ExtraRun,
                    Labor AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    Helper AS Helper,
                    (".$OVLActualExpense.") AS ActualExpense,
                    (".$OVLGPS.") AS GPS,
                    (".$OVLGovt.") AS Government,
                    (".$OVLDepreciation.") AS Depreciation,
                    (".$OVLSeparation.") AS Separation,
                    (".$OVLTraining.") AS Training,
                    (".$OVLWater.") AS Water,
                    (".$OVLTransportation.") AS Transportation,
                    (".$OVLTravelling.") AS Travelling,
                    OVLType AS LaborType 
                FROM tblovlvehicleloghdr a WHERE OVLVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'
            )
            UNION 
            (   SELECT 
                    CONVERT(vehicle_name USING utf8) AS UnitNo, 
                    date AS IEDate, 
                    dr_no AS VLNo,
                    po_route_from AS Location,
                    DriverName AS Operator,
                    amount AS BillAmount,
                    ($wingvan_collection) AS Collection,
                    FuelLiters AS FuelLiter,
                    LessFuel AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MaintenanceCost AS MaintenanceCost,
                    0 AS ExtraRun,
                    Labor AS Labor,
                    0 AS Daily,
                    loaders AS Loaders,
                    Helper AS Helper,
                    (".$WVActualExpense.") AS ActualExpense,
                    (".$WVGPS.") AS GPS,
                    (".$WVGovt.") AS Government,
                    (".$WVDepreciation.") AS Depreciation,
                    (".$WVSeparation.") AS Separation,
                    (".$WVTraining.") AS Training,
                    (".$WVWater.") AS Water,
                    (".$WVTransportation.") AS Transportation,
                    (".$WVTravelling.") AS Travelling,
                    OVLType AS LaborType 
                FROM wingvan_requisition a WHERE date BETWEEN '".$data['from']."' AND '".$data['to']."'
            )
            UNION 
            (   SELECT 
                    CONVERT(vehicle_name USING utf8) AS UnitNo, 
                    date AS IEDate, 
                    delivery_no AS VLNo,
                    po_route AS Location, 
                    DriverName AS Location, 
                    amount AS BillAmount,
                    ($liftruck_collection) AS Collection,
                    FuelLiters AS FuelLiter,
                    LessFuel AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MaintenanceCost AS MaintenanceCost,
                    0 AS ExtraRun,
                    Labor AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    Helper AS Helper,
                    (".$LFActualExpense.") AS ActualExpense,
                    (".$LFGPS.") AS GPS,
                    (".$LFGovt.") AS Government,
                    (".$LFDepreciation.") AS Depreciation,
                    (".$LFSeparation.") AS Separation,
                    (".$LFTraining.") AS Training,
                    (".$LFWater.") AS Water,
                    (".$LFTransportation.") AS Transportation,
                    (".$LFTravelling.") AS Travelling,
                    '' AS LaborType 
                FROM liftruck_rental a WHERE date BETWEEN '".$data['from']."' AND '".$data['to']."'
            )
            UNION 
            (   SELECT 
                    CONVERT(plate_number USING utf8) AS UnitNo, 
                    trans_date AS IEDate, 
                    trans_date AS VLNo,
                    location AS Location,
                    driver AS Operator,
                    bill AS BillAmount,
                    amount AS Collection,
                    FuelLiter AS FuelLiter,
                    LessFuel AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MCost AS MaintenanceCost,
                    0 AS ExtraRun,
                    Labor AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    Helper AS Helper,
                    (".$OVActualExpense.") AS ActualExpense,
                    (".$OVGPS.") AS GPS,
                    (".$OVGovt.") AS Government,
                    (".$OVDepreciation.") AS Depreciation,
                    (".$OVSeparation.") AS Separation,
                    (".$OVTraining.") AS Training,
                    (".$OVWater.") AS Water,
                    (".$OVTransportation.") AS Transportation,
                    (".$OVTravelling.") AS Travelling,
                    LaborType AS LaborType 
                FROM vanrental_collection a WHERE trans_date BETWEEN '".$data['from']."' AND '".$data['to']."'
            )
            ORDER BY UnitNo, IEDate
            ");
        }elseif($data['generate'] == 2){
            $query = $this->db->query("
            (   SELECT 
                    CONVERT(golfcart_no USING utf8) AS UnitNo, 
                    trans_date AS IEDate, 
                    trans_date AS VLNo,
                    gcid_link AS Location,
                    id AS Operator,
                    debit_amount AS BillAmount,
                    credit_amount AS Collection,
                    0 AS FuelLiter, 
                    0 AS FuelAmount,
                    0 AS AdminCost,
                    0 AS MaintenanceCost,
                    0 AS ExtraRun,
                    0 AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    0 AS Helper,
                    (".$GCActualExpense.") AS ActualExpense,
                    (".$GCGPS.") AS GPS,
                    (".$GCGovt.") AS Government,
                    (".$GCDepreciation.") AS Depreciation,
                    (".$GCSeparation.") AS Separation,
                    (".$GCTraining.") AS Training,
                    (".$GCWater.") AS Water,
                    (".$GCTransportation.") AS Transportation,
                    (".$GCTravelling.") AS Travelling,
                    '' AS LaborType
                FROM golf_cart_ledger a WHERE trans_date BETWEEN '".$data['from']."' AND '".$data['to']."' AND type = 'TRANSACTION' AND gcid_link = '".$data['id']."'
            )
            UNION 
            (   SELECT 
                    CONVERT(PHBPlateNo USING utf8) AS UnitNo, 
                    PHBVLDate AS IEDate, 
                    OVLNo AS VLNo,
                    LocationName AS Location,
                    DriverName AS Operator,
                    BillAmount AS BillAmount,
                    CollectedAmount AS Collection,
                    FuelLiters AS FuelLiter,
                    FuelAmount AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MaintenanceCost AS MaintenanceCost,
                    ExtraRunAmount AS ExtraRun,
                    0 AS Labor,
                    Labor AS Daily,
                    0 AS Loaders,
                    Helper AS Helper,
                    (".$PHBActualExpense.") AS ActualExpense,
                    (".$PHBGPS.") AS GPS,
                    (".$PHBGovt.") AS Government,
                    (".$PHBDepreciation.") AS Depreciation,
                    (".$PHBSeparation.") AS Separation,
                    (".$PHBTraining.") AS Training,
                    (".$PHBWater.") AS Water,
                    (".$PHBTransportation.") AS Transportation,
                    (".$PHBTravelling.") AS Travelling,
                    OVLType AS LaborType
                FROM tblphbvehicleloghdr a WHERE PHBVLDate BETWEEN '".$data['from']."' AND '".$data['to']."' AND PHBIDLink = '".$data['id']."'
            )
            UNION 
            (   SELECT 
                    CONVERT(OVLPlateNo USING utf8) AS UnitNo, 
                    OVLVLDate AS IEDate, 
                    OVLNo AS VLNo,
                    LocationFrom AS Location,
                    DriverName AS Operator,
                    BillAmount AS BillAmount,
                    CollectedAmount AS Collection,
                    FuelLiters AS FuelLiter,
                    LessFuel AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MaintenanceCost AS MaintenanceCost,
                    0 AS ExtraRun,
                    Labor AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    Helper AS Helper,
                    (".$OVLActualExpense.") AS ActualExpense,
                    (".$OVLGPS.") AS GPS,
                    (".$OVLGovt.") AS Government,
                    (".$OVLDepreciation.") AS Depreciation,
                    (".$OVLSeparation.") AS Separation,
                    (".$OVLTraining.") AS Training,
                    (".$OVLWater.") AS Water,
                    (".$OVLTransportation.") AS Transportation,
                    (".$OVLTravelling.") AS Travelling,
                    OVLType AS LaborType 
                FROM tblovlvehicleloghdr a WHERE OVLVLDate BETWEEN '".$data['from']."' AND '".$data['to']."' AND OVLIDLink = '".$data['id']."'
            )
            UNION 
            (   SELECT 
                    CONVERT(vehicle_name USING utf8) AS UnitNo, 
                    date AS IEDate, 
                    dr_no AS VLNo,
                    po_route_from AS Location,
                    DriverName AS Operator,
                    amount AS BillAmount,
                    ($wingvan_collection) AS Collection,
                    FuelLiters AS FuelLiter,
                    LessFuel AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MaintenanceCost AS MaintenanceCost,
                    0 AS ExtraRun,
                    Labor AS Labor,
                    0 AS Daily,
                    loaders AS Loaders,
                    Helper AS Helper,
                    (".$WVActualExpense.") AS ActualExpense,
                    (".$WVGPS.") AS GPS,
                    (".$WVGovt.") AS Government,
                    (".$WVDepreciation.") AS Depreciation,
                    (".$WVSeparation.") AS Separation,
                    (".$WVTraining.") AS Training,
                    (".$WVWater.") AS Water,
                    (".$WVTransportation.") AS Transportation,
                    (".$WVTravelling.") AS Travelling,
                    OVLType AS LaborType 
                FROM wingvan_requisition a WHERE date BETWEEN '".$data['from']."' AND '".$data['to']."' AND vehicle_id = '".$data['id']."'
            )
            UNION 
            (   SELECT 
                    CONVERT(vehicle_name USING utf8) AS UnitNo, 
                    date AS IEDate, 
                    delivery_no AS VLNo,
                    po_route AS Location, 
                    DriverName AS Location, 
                    amount AS BillAmount,
                    ($liftruck_collection) AS Collection,
                    FuelLiters AS FuelLiter,
                    LessFuel AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MaintenanceCost AS MaintenanceCost,
                    0 AS ExtraRun,
                    Labor AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    Helper AS Helper,
                    (".$LFActualExpense.") AS ActualExpense,
                    (".$LFGPS.") AS GPS,
                    (".$LFGovt.") AS Government,
                    (".$LFDepreciation.") AS Depreciation,
                    (".$LFSeparation.") AS Separation,
                    (".$LFTraining.") AS Training,
                    (".$LFWater.") AS Water,
                    (".$LFTransportation.") AS Transportation,
                    (".$LFTravelling.") AS Travelling,
                    '' AS LaborType 
                FROM liftruck_rental a WHERE date BETWEEN '".$data['from']."' AND '".$data['to']."' AND vehicle_id = '".$data['id']."'
            )
            UNION 
            (   SELECT 
                    CONVERT(plate_number USING utf8) AS UnitNo, 
                    trans_date AS IEDate, 
                    trans_date AS VLNo,
                    location AS Location,
                    driver AS Operator,
                    bill AS BillAmount,
                    amount AS Collection,
                    FuelLiter AS FuelLiter,
                    LessFuel AS  FuelAmount,
                    LessAdmin AS AdminCost,
                    MCost AS MaintenanceCost,
                    0 AS ExtraRun,
                    Labor AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    Helper AS Helper,
                    (".$OVActualExpense.") AS ActualExpense,
                    (".$OVGPS.") AS GPS,
                    (".$OVGovt.") AS Government,
                    (".$OVDepreciation.") AS Depreciation,
                    (".$OVSeparation.") AS Separation,
                    (".$OVTraining.") AS Training,
                    (".$OVWater.") AS Water,
                    (".$OVTransportation.") AS Transportation,
                    (".$OVTravelling.") AS Travelling,
                    LaborType AS LaborType 
                FROM vanrental_collection a WHERE trans_date BETWEEN '".$data['from']."' AND '".$data['to']."' AND vehicle_id = '".$data['id']."'
            )
            ORDER BY UnitNo, IEDate
            ");
        }elseif($data['generate'] == 3){
            $query = $this->db->query("
            (   SELECT 
                    CONVERT(golfcart_no USING utf8) AS UnitNo, 
                    trans_date AS IEDate, 
                    SUM(debit_amount) AS BillAmount,
                    SUM(credit_amount) AS Collection,
                    0 AS FuelLiter, 
                    0 AS FuelAmount,
                    0 AS AdminCost,
                    0 AS MaintenanceCost,
                    0 AS ExtraRun,
                    0 AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    0 AS Helper,
                    (".$GCActualExpense.") AS ActualExpense,
                    (".$GCGPS.") AS GPS,
                    (".$GCGovt.") AS Government,
                    (".$GCDepreciation.") AS Depreciation,
                    (".$GCSeparation.") AS Separation,
                    (".$GCTraining.") AS Training,
                    (".$GCWater.") AS Water,
                    (".$GCTransportation.") AS Transportation,
                    (".$GCTravelling.") AS Travelling,
                    '' AS LaborType
                FROM golf_cart_ledger a WHERE trans_date BETWEEN '".$data['from']."' AND '".$data['to']."' AND type = 'TRANSACTION' 
                GROUP BY golfcart_no, MONTH(trans_date), YEAR(trans_date)
            )
            UNION 
            (   SELECT 
                    CONVERT(PHBPlateNo USING utf8) AS UnitNo, 
                    PHBVLDate AS IEDate, 
                    SUM(BillAmount) AS BillAmount,
                    SUM(CollectedAmount) AS Collection,
                    SUM(FuelLiters) AS FuelLiter,
                    SUM(FuelAmount) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MaintenanceCost) AS MaintenanceCost,
                    SUM(ExtraRunAmount) AS ExtraRun,
                    0 AS Labor,
                    SUM(Labor) AS Daily,
                    0 AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$PHBActualExpense.") AS ActualExpense,
                    (".$PHBGPS.") AS GPS,
                    (".$PHBGovt.") AS Government,
                    (".$PHBDepreciation.") AS Depreciation,
                    (".$PHBSeparation.") AS Separation,
                    (".$PHBTraining.") AS Training,
                    (".$PHBWater.") AS Water,
                    (".$PHBTransportation.") AS Transportation,
                    (".$PHBTravelling.") AS Travelling,
                    OVLType AS LaborType
                FROM tblphbvehicleloghdr a WHERE PHBVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'
                GROUP BY PHBPlateNo, MONTH(PHBVLDate), YEAR(PHBVLDate)
            )
            UNION 
            (   SELECT 
                    CONVERT(OVLPlateNo USING utf8) AS UnitNo, 
                    OVLVLDate AS IEDate,
                    SUM(BillAmount) AS BillAmount,
                    SUM(CollectedAmount) AS Collection,
                    SUM(FuelLiters) AS FuelLiter,
                    SUM(LessFuel) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MaintenanceCost) AS MaintenanceCost,
                    0 AS ExtraRun,
                    SUM(Labor) AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$OVLActualExpense.") AS ActualExpense,
                    (".$OVLGPS.") AS GPS,
                    (".$OVLGovt.") AS Government,
                    (".$OVLDepreciation.") AS Depreciation,
                    (".$OVLSeparation.") AS Separation,
                    (".$OVLTraining.") AS Training,
                    (".$OVLWater.") AS Water,
                    (".$OVLTransportation.") AS Transportation,
                    (".$OVLTravelling.") AS Travelling,
                    OVLType AS LaborType 
                FROM tblovlvehicleloghdr a WHERE OVLVLDate BETWEEN '".$data['from']."' AND '".$data['to']."'
                GROUP BY OVLPlateNo, MONTH(OVLVLDate), YEAR(OVLVLDate)
            )
            UNION 
            (   SELECT 
                    CONVERT(vehicle_name USING utf8) AS UnitNo, 
                    date AS IEDate, 
                    SUM(amount) AS BillAmount,
                    ($wingvan_collection) AS Collection,
                    SUM(FuelLiters) AS FuelLiter,
                    SUM(LessFuel) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MaintenanceCost) AS MaintenanceCost,
                    0 AS ExtraRun,
                    SUM(Labor) AS Labor,
                    0 AS Daily,
                    SUM(loaders) AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$WVActualExpense.") AS ActualExpense,
                    (".$WVGPS.") AS GPS,
                    (".$WVGovt.") AS Government,
                    (".$WVDepreciation.") AS Depreciation,
                    (".$WVSeparation.") AS Separation,
                    (".$WVTraining.") AS Training,
                    (".$WVWater.") AS Water,
                    (".$WVTransportation.") AS Transportation,
                    (".$WVTravelling.") AS Travelling,
                    OVLType AS LaborType 
                FROM wingvan_requisition a WHERE date BETWEEN '".$data['from']."' AND '".$data['to']."'
                GROUP BY vehicle_name, MONTH(date), YEAR(date)
            )
            UNION 
            (   SELECT 
                    CONVERT(vehicle_name USING utf8) AS UnitNo, 
                    date AS IEDate,
                    SUM(amount) AS BillAmount,
                    ($liftruck_collection) AS Collection,
                    SUM(FuelLiters) AS FuelLiter,
                    SUM(LessFuel) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MaintenanceCost) AS MaintenanceCost,
                    0 AS ExtraRun,
                    SUM(Labor) AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$LFActualExpense.") AS ActualExpense,
                    (".$LFGPS.") AS GPS,
                    (".$LFGovt.") AS Government,
                    (".$LFDepreciation.") AS Depreciation,
                    (".$LFSeparation.") AS Separation,
                    (".$LFTraining.") AS Training,
                    (".$LFWater.") AS Water,
                    (".$LFTransportation.") AS Transportation,
                    (".$LFTravelling.") AS Travelling,
                    '' AS LaborType 
                FROM liftruck_rental a WHERE date BETWEEN '".$data['from']."' AND '".$data['to']."'
                GROUP BY vehicle_name, MONTH(date), YEAR(date)
            )
            UNION 
            (   SELECT 
                    CONVERT(plate_number USING utf8) AS UnitNo, 
                    trans_date AS IEDate,
                    SUM(bill) AS BillAmount,
                    SUM(amount) AS Collection,
                    SUM(FuelLiter) AS FuelLiter,
                    SUM(LessFuel) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MCost) AS MaintenanceCost,
                    0 AS ExtraRun,
                    SUM(Labor) AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$OVActualExpense.") AS ActualExpense,
                    (".$OVGPS.") AS GPS,
                    (".$OVGovt.") AS Government,
                    (".$OVDepreciation.") AS Depreciation,
                    (".$OVSeparation.") AS Separation,
                    (".$OVTraining.") AS Training,
                    (".$OVWater.") AS Water,
                    (".$OVTransportation.") AS Transportation,
                    (".$OVTravelling.") AS Travelling,
                    LaborType AS LaborType 
                FROM vanrental_collection a WHERE trans_date BETWEEN '".$data['from']."' AND '".$data['to']."'
                GROUP BY plate_number, MONTH(trans_date), YEAR(trans_date)
            )
            ORDER BY IEDate, UnitNo
            ");
        }else{
            $query = $this->db->query("
            (   SELECT 
                    CONVERT(golfcart_no USING utf8) AS UnitNo, 
                    trans_date AS IEDate, 
                    SUM(debit_amount) AS BillAmount,
                    SUM(credit_amount) AS Collection,
                    0 AS FuelLiter, 
                    0 AS FuelAmount,
                    0 AS AdminCost,
                    0 AS MaintenanceCost,
                    0 AS ExtraRun,
                    0 AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    0 AS Helper,
                    (".$GCActualExpense.") AS ActualExpense,
                    (".$GCGPS.") AS GPS,
                    (".$GCGovt.") AS Government,
                    (".$GCDepreciation.") AS Depreciation,
                    (".$GCSeparation.") AS Separation,
                    (".$GCTraining.") AS Training,
                    (".$GCWater.") AS Water,
                    (".$GCTransportation.") AS Transportation,
                    (".$GCTravelling.") AS Travelling,
                    '' AS LaborType
                FROM golf_cart_ledger a WHERE trans_date BETWEEN '".$data['from']."' AND '".$data['to']."' AND type = 'TRANSACTION' AND gcid_link = '".$data['id']."' 
                GROUP BY golfcart_no, MONTH(trans_date), YEAR(trans_date)
            )
            UNION 
            (   SELECT 
                    CONVERT(PHBPlateNo USING utf8) AS UnitNo, 
                    PHBVLDate AS IEDate, 
                    SUM(BillAmount) AS BillAmount,
                    SUM(CollectedAmount) AS Collection,
                    SUM(FuelLiters) AS FuelLiter,
                    SUM(FuelAmount) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MaintenanceCost) AS MaintenanceCost,
                    SUM(ExtraRunAmount) AS ExtraRun,
                    0 AS Labor,
                    SUM(Labor) AS Daily,
                    0 AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$PHBActualExpense.") AS ActualExpense,
                    (".$PHBGPS.") AS GPS,
                    (".$PHBGovt.") AS Government,
                    (".$PHBDepreciation.") AS Depreciation,
                    (".$PHBSeparation.") AS Separation,
                    (".$PHBTraining.") AS Training,
                    (".$PHBWater.") AS Water,
                    (".$PHBTransportation.") AS Transportation,
                    (".$PHBTravelling.") AS Travelling,
                    OVLType AS LaborType
                FROM tblphbvehicleloghdr a WHERE PHBVLDate BETWEEN '".$data['from']."' AND '".$data['to']."' AND PHBIDLink = '".$data['id']."'
                GROUP BY PHBPlateNo, MONTH(PHBVLDate), YEAR(PHBVLDate)
            )
            UNION 
            (   SELECT 
                    CONVERT(OVLPlateNo USING utf8) AS UnitNo, 
                    OVLVLDate AS IEDate,
                    SUM(BillAmount) AS BillAmount,
                    SUM(CollectedAmount) AS Collection,
                    SUM(FuelLiters) AS FuelLiter,
                    SUM(LessFuel) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MaintenanceCost) AS MaintenanceCost,
                    0 AS ExtraRun,
                    SUM(Labor) AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$OVLActualExpense.") AS ActualExpense,
                    (".$OVLGPS.") AS GPS,
                    (".$OVLGovt.") AS Government,
                    (".$OVLDepreciation.") AS Depreciation,
                    (".$OVLSeparation.") AS Separation,
                    (".$OVLTraining.") AS Training,
                    (".$OVLWater.") AS Water,
                    (".$OVLTransportation.") AS Transportation,
                    (".$OVLTravelling.") AS Travelling,
                    OVLType AS LaborType 
                FROM tblovlvehicleloghdr a WHERE OVLVLDate BETWEEN '".$data['from']."' AND '".$data['to']."' AND OVLIDLink = '".$data['id']."'
                GROUP BY OVLPlateNo, MONTH(OVLVLDate), YEAR(OVLVLDate)
            )
            UNION 
            (   SELECT 
                    CONVERT(vehicle_name USING utf8) AS UnitNo, 
                    date AS IEDate, 
                    SUM(amount) AS BillAmount,
                    ($wingvan_collection) AS Collection,
                    SUM(FuelLiters) AS FuelLiter,
                    SUM(LessFuel) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MaintenanceCost) AS MaintenanceCost,
                    0 AS ExtraRun,
                    SUM(Labor) AS Labor,
                    0 AS Daily,
                    SUM(loaders) AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$WVActualExpense.") AS ActualExpense,
                    (".$WVGPS.") AS GPS,
                    (".$WVGovt.") AS Government,
                    (".$WVDepreciation.") AS Depreciation,
                    (".$WVSeparation.") AS Separation,
                    (".$WVTraining.") AS Training,
                    (".$GCWater.") AS Water,
                    (".$WVTransportation.") AS Transportation,
                    (".$WVTravelling.") AS Travelling,
                    OVLType AS LaborType 
                FROM wingvan_requisition a WHERE date BETWEEN '".$data['from']."' AND '".$data['to']."' AND vehicle_id = '".$data['id']."'
                GROUP BY vehicle_name, MONTH(date), YEAR(date)
            )
            UNION 
            (   SELECT 
                    CONVERT(vehicle_name USING utf8) AS UnitNo, 
                    date AS IEDate,
                    SUM(amount) AS BillAmount,
                    ($liftruck_collection) AS Collection,
                    SUM(FuelLiters) AS FuelLiter,
                    SUM(LessFuel) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MaintenanceCost) AS MaintenanceCost,
                    0 AS ExtraRun,
                    SUM(Labor) AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$LFActualExpense.") AS ActualExpense,
                    (".$LFGPS.") AS GPS,
                    (".$LFGovt.") AS Government,
                    (".$LFDepreciation.") AS Depreciation,
                    (".$LFSeparation.") AS Separation,
                    (".$LFTraining.") AS Training,
                    (".$LFWater.") AS Water,
                    (".$LFTransportation.") AS Transportation,
                    (".$LFTravelling.") AS Travelling,
                    '' AS LaborType 
                FROM liftruck_rental a WHERE date BETWEEN '".$data['from']."' AND '".$data['to']."' AND vehicle_id = '".$data['id']."'
                GROUP BY vehicle_name, MONTH(date), YEAR(date)
            )
            UNION 
            (   SELECT 
                    CONVERT(plate_number USING utf8) AS UnitNo, 
                    trans_date AS IEDate,
                    SUM(bill) AS BillAmount,
                    SUM(amount) AS Collection,
                    SUM(FuelLiter) AS FuelLiter,
                    SUM(LessFuel) AS  FuelAmount,
                    SUM(LessAdmin) AS AdminCost,
                    SUM(MCost) AS MaintenanceCost,
                    0 AS ExtraRun,
                    SUM(Labor) AS Labor,
                    0 AS Daily,
                    0 AS Loaders,
                    SUM(Helper) AS Helper,
                    (".$OVActualExpense.") AS ActualExpense,
                    (".$OVGPS.") AS GPS,
                    (".$OVGovt.") AS Government,
                    (".$OVDepreciation.") AS Depreciation,
                    (".$OVSeparation.") AS Separation,
                    (".$OVTraining.") AS Training,
                    (".$OVWater.") AS Water,
                    (".$OVTransportation.") AS Transportation,
                    (".$OVTravelling.") AS Travelling,
                    LaborType AS LaborType 
                FROM vanrental_collection a WHERE trans_date BETWEEN '".$data['from']."' AND '".$data['to']."' AND vehicle_id = '".$data['id']."'
                GROUP BY plate_number, MONTH(trans_date), YEAR(trans_date)
            )
            ORDER BY IEDate, UnitNo
            ");
        }
        
        return $query->result();
    }
}