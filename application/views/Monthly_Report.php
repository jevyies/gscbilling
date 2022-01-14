<?php 
    header('Content-type: application/excel');
    $filename = 'SP MONTHLY REPORT.xls';
	header('Content-Disposition: attachment; filename='.$filename);

	$total = 0;
?>
<html xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
    </head>
    <style>
        body {
            font-family: 'Arial Black';
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
                <td colspan="5" style="text-align:left;"><h3>HR Monthly Report</h3></td>
            </tr>
        </table>
        <table width="100%" class="main_t">
            <thead>
                <tr style="border:1px solid black;">
                    <th colspan="7"></th>
                    <th colspan="5">Returned SOA</th>
                    <th colspan="5"></th>
                </tr>
                <tr style="border:1px solid black;">
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">Date</th>
                    <th style="width:9%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">SOA Number</th>
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">Total Amount</th>
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">Billing Period</th>
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" colspan="2">Signed by Department</th>
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">Total Processing Days (From date submitted to department to date transacted to accounting)</th>
                    <th style="width:10%;padding:20px 0;background:#92d050;color:#fff;" rowspan="2">Returned by Department (due to some errors)</th>
                    <th style="width:10%;padding:20px 0;background:#92d050;color:#fff;" rowspan="2">Reason of Returned SOA</th>
                    <th style="width:10%;padding:20px 0;background:#92d050;color:#fff;" rowspan="2">Processed returned SOA by SP</th>
                    <th style="width:10%;padding:20px 0;background:#92d050;color:#fff;" rowspan="2">Returned SOA signed by Department</th>
                    <th style="width:10%;padding:20px 0;background:#92d050;color:#fff;" rowspan="2">Submitted to Accounting</th>
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">Date Transacted to Accounting</th>
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">Due Date</th>
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">GSMPC Remarks</th>
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">Date Transacted by Accounting to BPOI</th>
                    <th style="width:10%;padding:20px 0;background:#1f497d;color:#fff;" rowspan="2">Accounting Remarks</th>
                </tr>
                <tr style="border:1px solid black;">
                    <th style="color:#fff;background:#1f497d;">Supervisor Date</th>
                    <th style="color:#fff;background:#1f497d;">Manager Date</th>
                </tr>
            </thead>
            <tbody>
            <?php if($records != 'fail'): ?>
                <?php foreach($records as $record): ?>
                <tr>
                    <td style="text-align:center;"><?php echo date('d-M-Y',strtotime($record->soaDate)); ?></td>
                    <td style="text-align:center;"><?php echo $record->soaNumber; ?></td>
                    <td style="text-align:right;"><?php echo number_format((float)$record->TotalAmt, 2, '.', ','); ?></td>
                    <td style="text-align:center;"><?php echo date('d-M-Y',strtotime($record->DMPIReceivedDate)); ?></td>
                    <td style="text-align:center;"><?php echo date('d-M-Y',strtotime($record->SupervisorDate)); ?></td>
                    <td style="text-align:center;"><?php echo date('d-M-Y',strtotime($record->ManagerDate)); ?></td>
                    <td style="text-align:center;"><?php echo $record->total_processing; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:center;"><?php echo date('d-M-Y',strtotime($record->date_finalize)); ?></td>
                    <td style="text-align:center;"><?php echo date('d-M-Y',strtotime('+30 days',strtotime($record->soaDate))); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <!-- footer -->
        <htmlpagefooter name="myFooter" class="footer" style="display:none">
            <div style="text-align: center;font-weight:bold;font-size:90%;">
                <!-- Page {PAGENO} of {nbpg} -->
            </div>
        </htmlpagefooter>
    </body>
</html>