<?php 
header('Content-type: application/excel');
$filename = 'GSCBCCMonitoring'.$year.'-'. date('mdY') .'.xls';
header('Content-Disposition: attachment; filename='.$filename);

$total_credit = 0;
$total_debit = 0;
$total_balance = 0;
$r_balance = 0;
foreach($records as $record){
    
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
            /* border: 1px solid #285d8c; */
        }
        td {
            font-size: 90%;
            padding:5px;
            /* border: 1px solid #285d8c; */
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
            border:1px solid black;
        }

    </style>
    <body>
        <table width="100%" style="margin-bottom:20px;">
            <tr>
                <td style="border:none;padding:0px;text-align:right;width:25%" rowspan="3">
                    
                </td>
                <td style="border:none;padding:0px;width:50%;text-align:center;font-size:130%;"><strong>GSMPC GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong></td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:3px;text-align:center;">Telephone number: 088-223-3862</td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:3px;text-align:center;">TIN Number: 411-478-949</td>
                <td style="border:none;"></td>
            </tr>
        </table>
        <h4 style="text-align:center;">BCC Shell Billing Monitoring</h4>
        <h4 style="text-align:center;">For the YEAR <?php echo $year; ?></h4>
        <h4 style="text-align:left;">As of <?php echo date('F j, Y'); ?></h4>
        <br>
        <br>
        <table width="100%">
            <thead>
                <tr>
                    <th>DATE</th>
                    <th>PARTICULARS</th>
                    <th>DEBIT</th>
                    <th>CREDIT</th>
                    <th>BALANCE</th>
                    <th>CHECK #</th>
                    <th>OR #</th>
                    <th>DATE</th>
                    <th>unpaid</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $record): ?>
                <?php
                    $r_balance = $r_balance + $record->Debit - $record->PaidAmount;
                ?>
                <tr>
                    <td><?php echo $record->period_date; ?></td>
                    <td>BCC Outsource</td>
                    <td style="text-align:right;"><?php echo number_format($record->Debit, 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format($record->PaidAmount, 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format($record->Debit - $record->PaidAmount, 2, '.', ','); ?></td>
                    <td><?php echo $record->CheckNo; ?></td>
                    <td><?php echo $record->ORNo; ?></td>
                    <td><?php echo $record->DatePayment; ?></td>
                    <td style="text-align:right;"><?php echo number_format($r_balance, 2, '.', ','); ?></td>
                </tr>
                <?php $total_debit = $total_debit + $record->Debit; ?>
                <?php $total_credit = $total_credit + $record->PaidAmount; ?>
                <?php $total_balance = $total_balance + ($record->Debit - $record->PaidAmount); ?>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align:right;"><?php echo number_format($total_debit, 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format($total_credit, 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format($total_balance, 2, '.', ','); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right;"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <br>
        <table width="100%">
            <tr>
                <td style="width:30%;">Prepared By:</td>
                <td></td>
                <td style="width:30%;"></td>
                <td></td>
                <td style="width:30%;"></td>
            </tr>
            <tr>
                <td style="width:30%;"><br><u><?php echo strtoupper($Prepared_by); ?></u></td>
                <td></td>
                <td style="width:30%;"><br></td>
                <td></td>
                <td style="width:30%;"><br></td>
            </tr>
        </table>
    </body>
</html>