<?php 
    header('Content-type: application/excel');
    $filename = 'SP MONTHLY REPORT SUMMARY.xls';
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
                <td colspan="5" style="text-align:left;"><h3><br><br>Date From: <?php echo date('F Y',strtotime($from)); ?> To <?php echo date('F Y',strtotime($to)); ?><br></b></h3></td>
            </tr>
        </table>
        <table width="100%" class="main_t">
            <thead>
                <tr>
                    <th style="width:10%;padding:20px 0;">MONTHS</th>
                    <th style="width:9%;padding:20px 0;">UNBILLED(Php)</th>
                    <th style="width:10%;padding:20px 0;">UNPAID(Php)</th>
                    <th style="width:10%;padding:20px 0;">UNDUE</th>
                    <th style="width:10%;padding:20px 0;">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php if($records != 'fail'): ?>
                <?php foreach($records as $record): ?>
                <tr>
                    <td style="text-align:left;"><?php echo date('F',strtotime($record['yeer'].'-'.$record['mont'].'-01')); ?></td>
                    <td style="text-align:right;"><?php echo number_format((float)$record['UNBILLED'], 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format((float)$record['UNPAID'], 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format((float)$record['UNDUE'], 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format((float)$record['UNPAID'] + $record['UNDUE'], 2, '.', ','); ?></td>
                    
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