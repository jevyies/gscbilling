<?php 
header('Content-type: application/excel');
$filename = 'GSCDARBilling-'. date('mdY') .'.xls';
header('Content-Disposition: attachment; filename='.$filename);
$total_qty = 0;
$total_amount = 0;
$grand_total = 0;
foreach($headers as $header){
    $transmitted_date = $header->DateTransmitted;
    $period_from = $header->periodCoveredFrom;
    $period_to = $header->periodCoveredTo;
    $control_number = $header->controlNo;
    $preparedBy = $header->preparedBy;
    $preparedByPosition = $header->preparedByPosition;
    $verifiedBy = $header->verifiedBy;
    $verifiedByPosition = $header->verifiedByPosition;
    $notedBy = $header->notedBy;
    $notedByPosition = $header->notedByPosition;
    $approvedBy1 = $header->approvedBy1;
    $approvedByPosition1 = $header->approvedByPosition1;
    $approvedBy2 = $header->approvedBy2;
    $approvedByPosition2 = $header->approvedByPosition2;
    $approvedBy3 = $header->approvedBy3;
    $approvedByPosition3 = $header->approvedByPosition3;
    $x_from = explode('-', $period_from);
    $x_to = explode('-', $period_to);
    $diff = (int)($x_to[1]) - (int)($x_from[1]);
    if($diff > 0){
        $period = strtoupper(date('F j, Y', strtotime($period_from)) ." - ". date('F j, Y', strtotime($period_to)));
    }else{
        $period = strtoupper(date('F j', strtotime($period_from)) ."-". date('j, Y', strtotime($period_to)));
    }
    break;
}

foreach($records as $record){
    $last_activity = $record->activity;
    break;
}
?>
<html xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
	</head>
    <style>
        body {
            font-family: 'Arial, Helvetica, sans-serif';
        }

        table {
            border-spacing: -1px;
            border-width:thin;
        }
        th{
            border: 1px solid black;
        }
        td {
            font-size: 90%;
            padding:5px;
            border: 1px solid black;
        }
        .table-fix td{
            height: 30px;
            vertical-align:bottom;
            padding:2px;
        }
        @page { sheet-size: Legal-L; }
        
        @page {
            margin-top: 1cm;
            margin-bottom: 1.5cm;
            margin-left: .5cm;
            margin-right: .5cm;
            odd-footer-name: html_myFooter;
        }
        
        h1.bigsection {
                page-break-before: always;
                page: bigger;
        }

        .main_t td{
            border:1px solid black;
        }

        th {
            font-size: 90%;
            text-align:center;
        }

    </style>
    <body>
        <table width="100%" style="margin-bottom:20px;">
            <tr>
                <td style="border:none;padding:0px;text-align:right;width:25%" rowspan="3">
                    <img style="width:100px;height:50px;" src="<?php echo base_url(); ?>assets/images/logo.png">
                </td>
                <td style="border:none;padding:0px;width:50%;text-align:center;font-size:130%;"><strong>GSMPC GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong></td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:2px;text-align:center;font-size:110%;"><strong style="border-bottom:1px solid black;">Borja Road, Damilag, Manolo Fortich, Bukidnon</strong></td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:5px 0px;text-align:center;"><strong>TIN # : 411-478-949</strong></td>
                <td style="border:none;"></td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td style="width:10%;border:none;"></td>
                <td style="width:90%;padding:2px;border:none;"><i><strong>Charlotte S. Carpentero</strong></i></td>
            </tr>
            <tr>
                <td style="border:none;"></td>
                <td style="padding:2px;border:none;">Manager, Mindanao Accounting Services</td>
            </tr>
            <tr>
                <td style="border:none;"></td>
                <td style="padding:5px 2px;border:none;">Bugo, Cagayan de Oro City</td>
            </tr>
        </table>
        <table width="100%" style="margin-bottom:20px;">
            <tr>
                <td style="width:10%;border:none;"></td>
                <td style="width:10%;padding:2px;border:none;">Date Transmitted:</td>
                <td style="width:10%;padding:2px;border:none;"><strong><?php echo date('d-M-y', strtotime($transmitted_date));?></strong></td>
                <td style="width:70%;padding:2px;border:none;text-align:center;" rowspan="2"><strong>STATEMENT OF ACCOUNT</strong></td>
            </tr>
            <tr>
                <td style="border:none;"></td>
                <td style="padding:2px;border:none;">Control No.:</td>
                <td style="padding:2px;border:none;"><strong><?php echo $control_number; ?></strong></td>
            </tr>
        </table>
        <table style="margin-bottom:20px;table-layout:fixed;width:100%" class="table-fix">
            <tr>
                <th style="width:10%;border:none;"></th>
                <th style="width:10%;border:none;"></th>
                <th style="width:7%;border:none;"></th>
                <th style="width:14%;border:none;"></th>
                <th style="width:7%;border:none;"></th>
                <th style="width:12%;background:#7bbbf3;" colspan="2">Account to Charge</th>
                <th style="width:14%;background:#7bbbf3;" colspan="2">Accomplishment</th>
                <th style="width:8%;border:none;"></th>
                <th style="width:9%;border:none;"></th>
                <th style="width:9%;border:none;"></th>
                <th style="border:none;"></th>
            </tr>
            <tr>
                <th style="border:none;padding:5px 0;"></th>
                <th style="padding:10px 0;background:#c1c1c1;">Period Covered</th>
                <th style="padding:10px 0;background:#c1c1c1;">PO Number</th>
                <th style="padding:10px 0;background:#c1c1c1;">DESCRIPTION</th>
                <th style="padding:10px 0;background:#c1c1c1;">GL Account</th>
                <th style="padding:10px 0;background:#c1c1c1;width:4%;">Field # / Cost Center</th>
                <th style="padding:10px 0;background:#c1c1c1;width:6%;">Qty</th>
                <th style="padding:10px 0;background:#c1c1c1;width:8%;">Unit</th>
                <th style="padding:10px 0;background:#c1c1c1;width:6%;">Rate</th>
                <th style="padding:10px 0;background:#c1c1c1;">Amount</th>
                <th style="padding:10px 0;background:#c1c1c1;">Entry Sheet No.</th>
                <th style="padding:10px 0;background:#c1c1c1;">GR Doc. Number</th>
            </tr>
            <?php foreach($records as $record): ?>
            <tr>
                <td style="text-align:center;border:none"></td>
                <td style="text-align:center;"><?php echo date('d-M-y', strtotime($record->datePerformed));?></td>
                <td style="text-align:center;"><strong><?php echo $record->poNumber;?></strong></td>
                <td style="text-align:center;"><strong><?php echo $record->activity;?></strong></td>
                <td style="text-align:center;"><?php echo $record->gl;?></td>
                <td style="text-align:center;"><?php echo $record->costCenter;?></td>
                <td style="text-align:right;"><?php echo number_format($record->qty, 2, '.', ',');?></td>
                <td style="text-align:center;"><?php echo $record->unit;?></td>
                <td style="text-align:right;"><?php echo number_format($record->rate, 2, '.', ',');?></td>
                <td style="text-align:right;"><?php echo number_format($record->amount, 2, '.', ',');?></td>
                <td style="text-align:center;"><?php echo $record->entrySheetNumber;?></td>
                <td style="text-align:center;"><?php echo $record->serviceNumber;?></td>
            </tr>
            <?php $grand_total = $grand_total + $record->amount; ?>
            <?php endforeach;?>
            <tr>
                <td colspan="7" style="border:none;"></td>
                <td style="border:none;"><strong><i style="font-size:120%;">Grand Total</i></strong></td>
                <td style="border:none;">&nbsp;&nbsp;&nbsp;--</td>
                <td style="border:2px solid black;text-align:right;background:yellow;"><strong style="font-size:150%;"><?php echo number_format($grand_total, 2, '.', ',');?></strong></td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td style="font-weight:bold;border:none;width:10%;"></td>
                            <td style="font-weight:bold;border:none;width:10%;">Prepared By:</td>
                            <td style="font-weight:bold;border:none;width:14%;"></td>
                            <td style="font-weight:bold;border:none;width:6%;"></td>
                            <td style="font-weight:bold;border:none;width:5%;"></td>
                            <td style="font-weight:bold;border:none;width:12%;"></td>
                            <td style="font-weight:bold;border:none;width:10%;">Approved By:</td>
                            <td style="font-weight:bold;border:none;width:14%;"></td>
                            <td style="font-weight:bold;border:none;width:6%;"></td>
                            <td style="font-weight:bold;border:none;width:8%;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                        </tr>
                        <tr>
                            <td colspan="11" style="border:none;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"><span style="border:none;border-bottom:1px solid black;"><?php echo $preparedBy; ?></span></td>
                            <td style="font-weight:bold;border:none;text-align:center;">Date:</td>
                            <td style="font-weight:bold;border:none;border-bottom:1px solid black;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"><span style="border:none;border-bottom:1px solid black;"><?php echo $approvedBy1; ?></span></td>
                            <td style="font-weight:bold;border:none;text-align:center;">Date:</td>
                            <td style="font-weight:bold;border:none;border-bottom:1px solid black;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;border:none;padding:3px 5px;" colspan="2"></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;"><?php echo $preparedByPosition; ?></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;" colspan="4"></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;"><?php echo $approvedByPosition1; ?></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;" colspan="3"></td>
                        </tr>
                        <tr>
                            <td style="border:none;font-weight:bold;"></td>
                            <td style="border:none;font-weight:bold;" colspan="10">Verified & Checked By:</td>
                        </tr>
                        <tr>
                            <td colspan="11" style="border:none;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"><span style="border:none;border-bottom:1px solid black;"><?php echo $verifiedBy; ?></span></td>
                            <td style="font-weight:bold;border:none;text-align:center;">Date:</td>
                            <td style="font-weight:bold;border:none;border-bottom:1px solid black;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"><span style="border:none;border-bottom:1px solid black;"><?php echo $approvedBy2; ?></span></td>
                            <td style="font-weight:bold;border:none;text-align:center;">Date:</td>
                            <td style="font-weight:bold;border:none;border-bottom:1px solid black;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;border:none;padding:3px 5px;" colspan="2"></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;"><?php echo $verifiedByPosition; ?></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;" colspan="4"></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;"><?php echo $approvedByPosition2; ?></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;" colspan="3"></td>
                        </tr>
                        <tr>
                            <td style="border:none;font-weight:bold;"></td>
                            <td style="border:none;font-weight:bold;" colspan="10">Noted By:</td>
                        </tr>
                        <tr>
                            <td colspan="11" style="border:none;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"><span style="border:none;border-bottom:1px solid black;"><?php echo $notedBy; ?></span></td>
                            <td style="font-weight:bold;border:none;text-align:center;">Date:</td>
                            <td style="font-weight:bold;border:none;border-bottom:1px solid black;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"><span style="border:none;border-bottom:1px solid black;"><?php echo $approvedBy3; ?></span></td>
                            <td style="font-weight:bold;border:none;text-align:center;">Date:</td>
                            <td style="font-weight:bold;border:none;border-bottom:1px solid black;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;border:none;padding:3px 5px;" colspan="2"></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;"><?php echo $notedByPosition; ?></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;" colspan="4"></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;"><?php echo $approvedByPosition3; ?></td>
                            <td style="font-weight:bold;border:none;padding:3px 5px;" colspan="3"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>