<?php 
header('Content-type: application/excel');
$filename = 'GSCDARBilling-'. date('mdY') .'.xls';
header('Content-Disposition: attachment; filename='.$filename);
$grand_total = 0;
foreach($records as $record){
    $PreparedBy = $record->PreparedBy;
    $PreparedByPos = $record->PreparedByPos;
    $CheckedBy = $record->CheckedBy;
    $CheckedByPos = $record->CheckedByPos;
    $ApprovedBy = $record->ApprovedBy;
    $ApprovedByPos = $record->ApprovedByPos;
    $TransmittalNo = $record->TransmittalNo;
    $BillingStatement = $record->billing_statement;
    $period = $record->period;
    $store = $record->store;
    $date = $record->date;
    $type = $record->type;
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
        @page { sheet-size: Letter; }
        
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
                <td style="border:none;padding:0px;width:50%;text-align:center;font-size:130%;"><strong>GSMPC GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong></td>
            </tr>
            <tr>
                <td style="border:none;padding:2px;text-align:center;font-size:110%;"><strong style="border-bottom:1px solid black;">Borja Road, Damilag, Manolo Fortich, Bukidnon</strong></td>
            </tr>
            <tr>
                <td style="border:none;padding:5px 0px;text-align:center;"><strong>TIN # : 411-478-949</strong></td>
            </tr>
        </table>
        <?php if($type === 'CHECK DAM'): ?>
            <table>
                <tr>
                    <td style="width:150px;border:none;">FROM:</td>
                    <td style="width:150px;border:none;">GSMPC</td>
                </tr>
                <tr>
                    <td style="border:none;">TO:</td>
                    <td style="border:none;"><?php echo $store; ?></td>
                </tr>
                <tr>
                    <td style="border:none;">PERIOD COVERED:</td>
                    <td style="border:none;"><?php echo $period; ?></td>
                </tr>
                <tr>
                    <td style="border:none;">Date:</td>
                    <td style="border:none;"><?php echo date('F j, Y',strtotime($date)); ?></td>
                </tr>
                <tr>
                    <td style="border:none;">Transmittal #:</td>
                    <td style="border:none;"><?php echo $TransmittalNo; ?></td>
                </tr>
                <tr>
                    <td style="border:none;">&nbsp;</td>
                    <td style="border:none;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border:none;">VOLUME BASED</td>
                    <td style="border:none;"></td>
                </tr>
            </table>
            <table style="margin-bottom:20px;width:100%" class="table-fix">
                <tr>
                    <th style="padding:10px 0;">DOCUMENT DATE</th>
                    <th style="padding:10px 0;">REFERENCE</th>
                    <th style="padding:10px 0;">BILLING STATEMENT</th>
                    <th style="padding:10px 0;">OPERATION</th>
                    <th style="padding:10px 0;">AMOUNT</th>
                </tr>
                <?php foreach($records as $record): ?>
                <tr>
                    <td style="text-align:center;"><?php echo date('F j', strtotime($record->periodCoveredFrom)).'-'.date('F j, Y', strtotime($record->periodCoveredTo)); ?> </td>
                    <td style="text-align:center;"><?php echo $record->controlNo; ?></td>
                    <td style="text-align:center;"><?php echo $BillingStatement; ?></td>
                    <?php if($record->volumeType == 1): ?>
                        <td style="text-align:center;"><?php echo 'CHECK DAM'; ?></td>
                    <?php elseif($record->volumeType == 2): ?>
                        <td style="text-align:center;"><?php echo 'DAIRY'; ?></td>
                    <?php else: ?>
                        <td style="text-align:center;"><?php echo 'PAPAYA'; ?></td>
                    <?php endif;?>
                    <td style="text-align:center;"><?php echo number_format($record->Amount, 2, '.', ','); ?></td>
                </tr>
                <?php $grand_total = $grand_total + $record->Amount; ?>
                <?php endforeach;?>
                <tr>
                    <td colspan="3" style="border:none;"></td>
                    <td style="border:none;"><strong><i style="font-size:120%;">TOTAL</i></strong></td>
                    <td style="border:2px solid black;text-align:right;background:yellow;"><strong style="font-size:150%;"><?php echo number_format($grand_total, 2, '.', ',');?></strong></td>
                </tr>
            </table>
        <?php else: ?>
            <table>
                <tr>
                    <td style="border:none;">PERIOD COVERED:</td>
                    <td style="border:none;"><?php echo $period; ?></td>
                </tr>
                <tr>
                    <td style="border:none;">Date Transmitted to Store Room:</td>
                    <td style="border:none;"><?php echo date('j-M-y',strtotime($date)); ?></td>
                </tr>
                <tr>
                    <td style="width:150px;border:none;">FROM</td>
                    <td style="width:150px;border:none;">GSMPC</td>
                </tr>
                <tr>
                    <td style="border:none;">TO</td>
                    <td style="border:none;"><?php echo $store; ?></td>
                </tr>
                <tr>
                    <td style="border:none;">Transmittal #</td>
                    <td style="border:none;"><?php echo $TransmittalNo; ?></td>
                </tr>
                <tr>
                    <td style="border:none;">&nbsp;</td>
                    <td style="border:none;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border:none;">VOLUME BASED</td>
                    <td style="border:none;"></td>
                </tr>
            </table>
            <table style="margin-bottom:20px;width:100%" class="table-fix">
                <tr>
                    <th style="padding:10px 0;">ITEM #</th>
                    <th style="padding:10px 0;">DATE</th>
                    <th style="padding:10px 0;">REFERENCE</th>
                    <th style="padding:10px 0;">BILLING STATEMENT</th>
                    <th style="padding:10px 0;">OPERATION</th>
                    <th style="padding:10px 0;">AMOUNT</th>
                </tr>
                <?php $item = 1; ?>
                <?php foreach($records as $record): ?>
                <tr>
                <td style="text-align:center;"><?php echo $item; ?></td>
                    <td style="text-align:center;"><?php echo date('F j', strtotime($record->periodCoveredFrom)).'-'.date('F j, Y', strtotime($record->periodCoveredTo)); ?> </td>
                    <td style="text-align:center;"><?php echo $record->controlNo; ?></td>
                    <td style="text-align:center;"><?php echo $BillingStatement; ?></td>
                    <?php if($record->volumeType == 1): ?>
                        <td style="text-align:center;"><?php echo 'CHECK DAM'; ?></td>
                    <?php elseif($record->volumeType == 2): ?>
                        <td style="text-align:center;"><?php echo 'DAIRY'; ?></td>
                    <?php else: ?>
                        <td style="text-align:center;"><?php echo 'PAPAYA'; ?></td>
                    <?php endif;?>
                    <td style="text-align:center;"><?php echo number_format($record->Amount, 2, '.', ','); ?></td>
                    <?php $item++; ?>
                </tr>
                <?php $grand_total = $grand_total + $record->Amount; ?>
                <?php endforeach;?>
                <tr>
                    <td colspan="4" style="border:none;"></td>
                    <td style="border:none;"><strong><i style="font-size:120%;">TOTAL</i></strong></td>
                    <td style="border:2px solid black;text-align:right;background:yellow;"><strong style="font-size:150%;"><?php echo number_format($grand_total, 2, '.', ',');?></strong></td>
                </tr>
            </table>
        <?php endif; ?>
        <table>
            <tr>
                <td style="width:150px;border:none;">PREPARED BY:</td>
                <td style="width:200px;border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;"><u><?php echo $PreparedBy; ?></u></td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;"><?php echo $PreparedByPos; ?></td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">CHECKED BY:</td>
                <td style="border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;"><u><?php echo $CheckedBy; ?></u></td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;"><?php echo $CheckedByPos; ?></td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">APPROVED BY:</td>
                <td style="border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;"><u><?php echo $ApprovedBy; ?></u></td>
            </tr>
            <tr>
                <td style="border:none;">&nbsp;</td>
                <td style="border:none;"><?php echo $ApprovedByPos; ?></td>
            </tr>
        </table>
    </body>
</html>