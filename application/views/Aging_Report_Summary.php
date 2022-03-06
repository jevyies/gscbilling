<?php 
    header('Content-type: application/excel');
    $filename = 'Aging Report -'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
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
                <!-- <td style="width:20%;"><img src="http://192.168.1.250/epis/static/img/gsclogo.png" alt="GSC Logo" style="width:8%;"></td> -->
                <td style="width:120%;text-align:center;" colspan="9">
                    <h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
                    <h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
                    <br>
                    <h2 style="text-align:center;text-decoration:underline;">YEAR TO DATE AGING REPORT</h3>
                </td>
            </tr>
        </table>
        <br><br>
        <table width="100%" class="main_t">
            <thead>
                <tr style="border:1px solid black;">
                    <th style="padding:10px 5px;background-color:#7CFC00;width:70px;" rowspan="2">CATEGORY</th>
                    <th style="padding:10px 5px;background-color:#7CFC00;width:100px;" rowspan="2">Billed Amount</th>
                    <th style="padding:10px 5px;background-color:#7CFC00;width:100px;" rowspan="2">Collection</th>
                    <th style="padding:10px 5px;background-color:#7CFC00;width:100px;" rowspan="2">Balance</th>
                    <th style="padding:10px 5px;background-color:#7CFC00;width:100px;" rowspan="2">Current</th>
                    <th style="padding:10px 5px;background-color:#7CFC00;width:400px;" colspan="4">Past Due in Days</th>
                </tr>
                <tr style="border:1px solid black;">
                    <th style="background-color:#7CFC00;">1-30 days</th>
                    <th style="background-color:#7CFC00;">31-60 days</th>
                    <th style="background-color:#7CFC00;">61-120 days</th>
                    <th style="background-color:#7CFC00;">120 days up</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $record): ?>
                    <?php $outstanding = $record->TotalBilling - $record->TotalCollection; ?>
                    <tr style="border:1px solid black;">
                        <td><?php echo $record->Category; ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->TotalBilling, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->TotalCollection, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format($outstanding, 2, '.', ','); ?></td>
                        <?php if($record->Outstanding < 31): ?>
                            <td style="text-align:right;"><?php echo round($outstanding, 2) <= 0 ? '' : number_format($outstanding, 2, '.', ','); ?></td>
                        <?php else: ?>
                            <td style="text-align:right;"></td>
                        <?php endif; ?>
                        <?php if($record->Outstanding > 31 and $record->Outstanding <= 60): ?>
                            <td style="text-align:right;"><?php echo round($outstanding, 2) <= 0 ? '' : number_format($outstanding, 2, '.', ','); ?></td>
                        <?php else: ?>
                            <td style="text-align:right;"></td>
                        <?php endif; ?>
                        <?php if($record->Outstanding > 61 and $record->Outstanding <= 90): ?>
                            <td style="text-align:right;"><?php echo round($outstanding, 2) <= 0 ? '' : number_format($outstanding, 2, '.', ','); ?></td>
                        <?php else: ?>
                            <td style="text-align:right;"></td>
                        <?php endif; ?>
                        <?php if($record->Outstanding > 91 and $record->Outstanding <= 150): ?>
                            <td style="text-align:right;"><?php echo round($outstanding, 2) <= 0 ? '' : number_format($outstanding, 2, '.', ','); ?></td>
                        <?php else: ?>
                            <td style="text-align:right;"></td>
                        <?php endif; ?>
                        <?php if($record->Outstanding > 150): ?>
                            <td style="text-align:right;"><?php echo round($outstanding, 2) <= 0 ? '' : number_format($outstanding, 2, '.', ','); ?></td>
                        <?php else: ?>
                            <td style="text-align:right;"></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <!-- footer -->
        <htmlpagefooter name="myFooter" class="footer" style="display:none">
            <div style="text-align: center;font-weight:bold;font-size:90%;">
                <!-- Page {PAGENO} of {nbpg} -->
            </div>
        </htmlpagefooter>
    </body>
</html>