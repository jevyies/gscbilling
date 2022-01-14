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
    $diff = (int)($x_to[0]) - (int)($x_from[0]);
    if($diff > 0){
        $period = strtoupper(date('F j, Y', strtotime($period_from)) ." - ". date('F j, Y', strtotime($period_to)));
    }else{
        $period = strtoupper(date('F j', strtotime($period_from)) ." - ". date('F j, Y', strtotime($period_to)));
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
            border: 1px solid #285d8c;
        }
        td {
            font-size: 90%;
            padding:5px;
            border: 1px solid #285d8c;
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
            border:1px solid #285d8c;
        }

        th {
            font-size: 90%;
            text-align:center;
        }

    </style>
    <body>
        <table width="100%" style="margin-bottom:20px;">
            <tr>
                <td style="border:none;padding:0px;text-align:right;width:25%" rowspan="4">
                    <img style="width:100px;height:50px;" src="<?php echo base_url(); ?>assets/images/logo.png">
                </td>
                <td style="border:none;padding:0px;width:50%;text-align:center;font-size:130%;"><strong>GSMPC GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong></td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:2px;text-align:center;font-size:110%;"><strong style="border-bottom:1px solid black;">STATEMENT OF ACCOUNT</strong></td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:3px;text-align:center;">Telephone number: 088-223-3862</td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:0px;text-align:center;">TIN Number: 411-478-949</td>
                <td style="border:none;"></td>
            </tr>
        </table>
        <table width="100%" style="margin-bottom:20px;">
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
                <td style="width:10%;padding:2px;border:none;">Period Covered:</td>
                <td style="width:80%;padding:2px;border:none;"><?php echo $period; ?></td>
            </tr>
            <tr>
                <td style="border:none;"></td>
                <td style="padding:2px;border:none;">Date Transmitted:</td>
                <td style="padding:2px;border:none;"><strong><?php echo date('d-M-y', strtotime($transmitted_date));?></strong></td>
            </tr>
            <tr>
                <td style="border:none;"></td>
                <td style="padding:2px;border:none;">Control No.:</td>
                <td style="padding:2px;border:none;"><strong><?php echo $control_number; ?></strong></td>
            </tr>
        </table>
        <table width="100%" style="margin-bottom:20px;">
            <tr>
                <th style="width:10%;border:none;"></th>
                <th style="width:12%;border:none;"></th>
                <th style="width:8%;border:none;"></th>
                <th style="width:9%;border:none;"></th>
                <th style="width:7%;border:none;"></th>
                <th style="width:8%;border:none;"></th>
                <th style="width:14%" colspan="2">Accomplishment</th>
                <th style="width:6%;border:none;"></th>
                <th style="width:11%;border:none;"></th>
                <th style="width:8%;border:none;"></th>
                <th style="width:9%;border:none;"></th>
                <th style="border:none;"></th>
            </tr>
            <tr>
                <th style="border:none;padding:5px 0;"></th>
                <th style="padding:5px 0;">DATE PERFORMED</th>
                <th style="padding:5px 0;">PO Number</th>
                <th style="padding:5px 0;">DESCRIPTION</th>
                <th style="padding:5px 0;">GL Account</th>
                <th style="padding:5px 0;">Cost Center</th>
                <th style="padding:5px 0;">Qty</th>
                <th style="padding:5px 0;">Unit</th>
                <th style="padding:5px 0;">Rate</th>
                <th style="padding:5px 0;">Amount</th>
                <th style="padding:5px 0;">Entry Sheet No.</th>
                <th style="padding:5px 0;">GR Doc. Number</th>
            </tr>
            <?php foreach($records as $record): ?>
            <?php if($record->activity != $last_activity): ?>
                <tr>
                    <td style="border:none;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right;"><i><strong><?php echo number_format($total_qty, 2, '.', ',');?><i></strong></td>
                    <td style="text-align:center;" colspan="2"><i>subtotal</i></td>
                    <td style="text-align:right;"><i><strong><?php echo number_format($total_amount, 2, '.', ',');?><i></strong></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php $total_amount = 0; ?>
                <?php $total_qty = 0; ?>
                <?php $total_qty = $total_qty + $record->qty; ?>
                <?php $total_amount = $total_amount + $record->amount; ?>
            <?php else: ?>
                <?php $total_qty = $total_qty + $record->qty; ?>
                <?php $total_amount = $total_amount + $record->amount; ?>
            <?php endif; ?>
            <tr>
                <td style="text-align:center;border:none"></td>
                <td style="text-align:center;"><strong><?php echo $period;?></strong></td>
                <td style="text-align:center;"><?php echo $record->poNumber;?></td>
                <td style="text-align:center;"><?php echo $record->activity;?></td>
                <td style="text-align:center;"><?php echo $record->gl;?></td>
                <td style="text-align:center;"><?php echo $record->costCenter;?></td>
                <td style="text-align:right;"><?php echo number_format($record->qty, 2, '.', ',');?></td>
                <td style="text-align:center;"><?php echo $record->unit;?></td>
                <td style="text-align:center;"><?php echo number_format($record->rate, 2, '.', ',');?></td>
                <td style="text-align:right;"><?php echo number_format($record->amount, 2, '.', ',');?></td>
                <td style="text-align:center;"><?php echo $record->entrySheetNumber;?></td>
                <td style="text-align:center;"><?php echo $record->serviceNumber;?></td>
            </tr>
            <?php $grand_total = $grand_total + $record->amount; ?>
            <?php $last_activity = $record->activity; ?>
            <?php endforeach;?>
            <tr>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="text-align:right;"><i><strong><?php echo number_format($total_qty, 2, '.', ',');?><i></strong></td>
                <td style="text-align:center;" colspan="2"><i>subtotal</i></td>
                <td style="text-align:right;"><i><strong><?php echo number_format($total_amount, 2, '.', ',');?><i></strong></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td colspan="12" style="border:none;padding:10px;"></td>
            </tr>
            <tr>
                <td colspan="7" style="border:none;"></td>
                <td colspan="2" style="border:none;text-align:right;"><strong><i style="font-size:110%;">Grand Total</i></strong></td>
                <td style="text-align:right;"><strong style="font-size:110%;"><?php echo number_format($grand_total, 2, '.', ',');?></strong></td>
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
                            <td style="font-weight:bold;border:none;border-bottom:1px solid #285d8c;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"><span style="border:none;border-bottom:1px solid black;"><?php echo $approvedBy1; ?></span></td>
                            <td style="font-weight:bold;border:none;text-align:center;">Date:</td>
                            <td style="font-weight:bold;border:none;border-bottom:1px solid #285d8c;"></td>
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
                            <td style="font-weight:bold;border:none;border-bottom:1px solid #285d8c;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"><span style="border:none;border-bottom:1px solid black;"><?php echo $approvedBy2; ?></span></td>
                            <td style="font-weight:bold;border:none;text-align:center;">Date:</td>
                            <td style="font-weight:bold;border:none;border-bottom:1px solid #285d8c;"></td>
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
                            <td style="font-weight:bold;border:none;border-bottom:1px solid #285d8c;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"></td>
                            <td style="font-weight:bold;border:none;"><span style="border:none;border-bottom:1px solid black;"><?php echo $approvedBy3; ?></span></td>
                            <td style="font-weight:bold;border:none;text-align:center;">Date:</td>
                            <td style="font-weight:bold;border:none;border-bottom:1px solid #285d8c;"></td>
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