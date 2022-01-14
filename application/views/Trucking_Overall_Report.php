<?php 
    header('Content-type: application/excel');
    $filename = 'Trucking Overall Report (Detailed).xls';
    header('Content-Disposition: attachment; filename='.$filename);

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    $TotalBillAmount = 0; 
    $TotalCollectionAmount = 0; 
    $TotalBalanceAmount = 0; 
    $TotalLiterAmount = 0; 
    $TotalFuelAmount = 0; 
    $TotalMCAmount = 0; 
    $TotalAdminAmount = 0; 
    $TotalDailyAmount = 0; 
    $TotalExtraAmount = 0; 
    $TotalLoadersAmount = 0; 
    $TotalHelperAmount = 0; 
    $TotalLaborAmount = 0; 
    $TotalGPSAmount = 0; 
    $TotalActualExpenseAmount = 0; 
    $TotalGovernmentAmount = 0; 
    $TotalDepreciaionAmount = 0; 
    $TotalSeparationAmount = 0; 
    $TotalTrainingAmount = 0; 
    $TotalWaterAmount = 0; 
    $TotalTransportationAmount = 0; 
    $TotalTravellingAmount = 0;
    $TotalCostAmount = 0; 
    $TotalNetAmount = 0; 
?>
<html xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
    </head>
    <style>
        body {
            font-family: 'Courier New';
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        table {
            border-spacing: -1px;
            border-width:thin;
        }

        td {
            font-size: 100%;
            padding:5px;
            /* border: 1px solid black; */
        }

        .padding-none {
            padding:none;
        }

        @page { sheet-size: Legal-L; }
        
        @page {
            margin-top: 1cm;
            margin-bottom: 1cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            odd-footer-name: html_myFooter;
        }
        
        h1.bigsection {
                page-break-before: always;
                page: bigger;
        }

        .main_t td, th{
            border:1px solid black;
        }

        th {
            font-size: 90%;
            padding: 5px;
            text-align:center;
            font-style: italic;
        }

    </style>
    <body>
        <table width="100%">
            <tr>
                <td colspan="18" style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</td>
            </tr>
            <tr>
                <td colspan="18" style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</td>
            </tr>
        </table>
        <table width="100%">
            <tr style="border:1px solid black;">
                <th rowspan="2" style="text-align:center;padding:10px;">Unit No.</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Month</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Date</th>
                <th rowspan="2" style="text-align:center;padding:10px;">VL No.</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Location</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Operator</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Billed Amount</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Collection</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Balance</th>
                <th colspan="2" style="text-align:center;padding:10px;">FUEL</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Maintenance Cost</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Admin Cost</th>
                <th rowspan="2" style="text-align:center;padding:10px;">GPS</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Daily w/in 120 km</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Extra km run</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Loaders/Unloaders</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Helper</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Labor</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Actual Expense</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Gov't Remittance</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Depreciation Cost</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Separation Pay</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Trainings & Seminar</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Light & Water</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Transportation Allowance</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Travelling Fare</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Total Cost</th>
                <th rowspan="2" style="text-align:center;padding:10px;">Income</th>
            </tr>
            <tr style="border:1px solid black;">
                <th>LITERS</th>
                <th>AMOUNT</th>
            </tr>
            <?php foreach($records as $record): ?>
                <?php $BillAmount = $record->Collection > $record->BillAmount ? $record->Collection : $record->BillAmount; ?>
                <?php $Balance = $BillAmount - $record->Collection; ?>
                <?php $TotalCost = 
                                    $record->FuelAmount + 
                                    $record->MaintenanceCost + 
                                    $record->AdminCost + 
                                    $record->ExtraRun + 
                                    $record->Loaders + 
                                    $record->Helper + 
                                    $record->Labor + 
                                    $record->ActualExpense;
                ?>
                <?php $NetIncome = $BillAmount - $TotalCost; ?>
                <tr style="border:1px solid black;" >
                    <td style="text-align:left;border:1px solid black;"><?php echo $record->UnitNo; ?></td>
                    <td style="text-align:center;border:1px solid black;"><?php echo date('F Y', strtotime($record->IEDate)); ?></td>
                    <td style="text-align:center;border:1px solid black;"><?php echo date('M j, Y', strtotime($record->IEDate)); ?></td>
                    <td style="text-align:center;border:1px solid black;"><?php echo validateDate($record->VLNo) ? '' : $record->VLNo; ?></td>
                    <td style="border:1px solid black;" ><?php echo is_numeric($record->Location) ? '' : $record->Location; ?></td>
                    <td style="border:1px solid black;" ><?php echo is_numeric($record->Operator) ? '' : $record->Operator; ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($BillAmount, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Collection, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($Balance, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->FuelLiter, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->FuelAmount, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->MaintenanceCost, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->AdminCost, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->GPS, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Daily, 2, '.', ',') ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->ExtraRun, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Loaders, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Helper, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo $record->LaborType !== 'ADMIN CHARGE' ? number_format($record->Labor, 2, '.', ',') : ''; ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->ActualExpense, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Government, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Depreciation, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Separation, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Training, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Water, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Transportation, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->Travelling, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalCost, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:1px solid black;"><?php echo number_format($NetIncome, 2, '.', ','); ?></td>
                </tr>
                <?php 
                    $TotalBillAmount += $BillAmount; 
                    $TotalCollectionAmount += $record->Collection; 
                    $TotalBalanceAmount += $Balance; 
                    $TotalLiterAmount += $record->FuelLiter; 
                    $TotalFuelAmount += $record->FuelAmount; 
                    $TotalMCAmount += $record->MaintenanceCost; 
                    $TotalAdminAmount += $record->AdminCost; 
                    $TotalDailyAmount += $record->Daily; 
                    $TotalExtraAmount += $record->ExtraRun; 
                    $TotalLoadersAmount += $record->Loaders; 
                    $TotalHelperAmount += $record->Helper; 
                    $TotalLaborAmount += $record->LaborType !== 'ADMIN CHARGE' ? $record->Labor : 0; 
                    $TotalGPSAmount += $record->GPS;
                    $TotalActualExpenseAmount += $record->ActualExpense;
                    $TotalGovernmentAmount += $record->Government;
                    $TotalDepreciaionAmount += $record->Depreciation;
                    $TotalSeparationAmount += $record->Separation;
                    $TotalTrainingAmount += $record->Training;
                    $TotalWaterAmount += $record->Water;
                    $TotalTransportationAmount += $record->Transportation;
                    $TotalTravellingAmount += $record->Travelling;
                    $TotalCostAmount += $TotalCost; 
                    $TotalNetAmount += $NetIncome; 
                ?>
            <?php endforeach; ?>
            <tr style="border:1px solid black;">
                <td style="text-align:left;border:1px solid black;" colspan="6">Total</td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalBillAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalCollectionAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalBalanceAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalLiterAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalFuelAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalMCAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalAdminAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalGPSAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalDailyAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalExtraAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalLoadersAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalHelperAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalLaborAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalActualExpenseAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalGovernmentAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalDepreciaionAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalSeparationAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalTrainingAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalWaterAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalTransportationAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalTravellingAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalCostAmount, 2, '.', ','); ?></td>
                <td style="text-align:right;border:1px solid black;"><?php echo number_format($TotalNetAmount, 2, '.', ','); ?></td>
            </tr>
        </table>
    </body>
</html>