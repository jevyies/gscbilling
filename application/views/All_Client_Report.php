<?php 
    header('Content-type: application/excel');
    $filename = 'shabu-'. date('mdY') .'.xls';
    header('Content-Disposition: attachment; filename='.$filename);
    $from_year = date('Y', strtotime($from));
    $to_year = date('Y', strtotime($to));
    $diff = $to_year - $from_year;
    if($diff > 0){
        $year = $from_year.' - '.$to_year;
    }else{
        $year = $to_year;
    }
    $overall_bcc = 0; 
    $overall_slers = 0;
    $overall_dearbc = 0;
    $overall_technical = 0;
    $overall_dmpi = 0;
    $overall_total = 0;
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
                    <h2 style="text-align:center;text-decoration:underline;">BILLING REPORT <?php echo $year; ?><i></i></h2>
                    <h3 style="text-decoration:underline;">BCC/SLERS/DEARBC/DMPI</h3>
                </td>
            </tr>
        </table>
        <br><br>
        <table width="100%" class="main_t">
            <thead>
                <tr>
                    <th style="padding:10px 0;width:150px;">Date</th>
                    <th style="padding:10px 0;width:150px;">BCC</th>
                    <th style="padding:10px 0;width:100px;">SLERS</th>
                    <th style="padding:10px 0;width:100px;">DEARBC</th>
                    <th style="padding:10px 0;width:100px;">NICE FRUIT (TECHNICAL)</th>
                    <th style="padding:10px 0;width:100px;">DMPI</th>
                    <th style="padding:10px 0;width:100px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $record): ?>
                    <?php $Total = $record->BCC + $record->SLERS + $record->DEARBC + $record->TECHNICAL + $record->DMPI; ?>
                    <tr>
                        <td><?php echo $record->Date; ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->BCC, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->SLERS, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->DEARBC, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->TECHNICAL, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->DMPI, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format($Total, 2, '.', ','); ?></td>
                    </tr>
                    <?php $overall_bcc = $overall_bcc + $record->BCC; ?>
                    <?php $overall_slers = $overall_slers + $record->SLERS; ?>
                    <?php $overall_dearbc = $overall_dearbc + $record->DEARBC; ?>
                    <?php $overall_technical = $overall_technical + $record->TECHNICAL; ?>
                    <?php $overall_dmpi = $overall_dmpi + $record->DMPI; ?>
                    <?php $overall_total = $overall_total + $Total; ?>
                <?php endforeach ;?>
                <tr>
                    <td style="border:none;border-bottom:1px solid black;"><strong>OVER-ALL TOTAL</strong></td>
                    <td style="text-align:right;border:none;border-bottom:1px solid black;"><?php echo number_format($overall_bcc, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:none;border-bottom:1px solid black;"><?php echo number_format($overall_slers, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:none;border-bottom:1px solid black;"><?php echo number_format($overall_dearbc, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:none;border-bottom:1px solid black;"><?php echo number_format($overall_technical, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:none;border-bottom:1px solid black;"><?php echo number_format($overall_dmpi, 2, '.', ','); ?></td>
                    <td style="text-align:right;border:none;border-bottom:1px solid black;"><?php echo number_format($overall_total, 2, '.', ','); ?></td>
                </tr>
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