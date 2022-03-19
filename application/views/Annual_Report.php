<?php 
    header('Content-type: application/excel');
    $filename = 'Annual Report -'. date('mdY') .'.xls';
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

        @page { sheet-size: Letter; }
        
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
                <td style="width:120%;text-align:center;">
                    <h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
                    <h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
                    <br>
                    <h2 style="text-align:center;text-decoration:underline;">FOR THE YEAR <i><?php echo date('Y', strtotime($to)); ?> </i></h2>
                    <h3 style="text-decoration:underline;">LABOR ONLY</h3>
                </td>
            </tr>
        </table>
        <br><br>
        <table width="100%" class="main_t">
            <thead>
                <tr>
                    <th style="padding:10px 0;width:120px;">DATE</th>
                    <th style="padding:10px 0;width:120px;">HEADCOUNT</th>
                    <th style="padding:10px 0;">GROSS</th>
                    <th style="padding:10px 0;">NETPAY</th>
                    <th style="padding:10px 0;">BILLING</th>
                    <th style="padding:10px 0;width:120px;">%</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $record): ?>
                    <tr>
                        <?php $percent = (($record->Billing - $record->Gross)/$record->Billing)*100; ?>
                        <td><?php echo $record->Date; ?></td>
                        <td style="text-align:center;"><?php echo $record->HeadCount; ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->Gross, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->Net, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->Billing, 2, '.', ','); ?></td>
                        <td style="text-align:center;"><?php echo number_format($percent, 2).'%' ; ?></td>
                    </tr>
                <?php endforeach; ?>
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