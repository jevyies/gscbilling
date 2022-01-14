<?php 
    header('Content-type: application/excel');
    $filename = 'shabu-'. date('mdY') .'.xls';
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
                <!-- <td style="width:20%;"><img src="http://192.168.1.250/epis/static/img/gsclogo.png" alt="GSC Logo" style="width:8%;"></td> -->
                <td style="width:120%;text-align:center;">
                    <h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
                    <h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
                    <br>
                    <h2 style="text-align:center;text-decoration:underline;">SOA STATUS MONITORING</h3>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:left;"><h3><br><br>Date From: <?php echo $from; ?> To <?php echo $to; ?><br></b></h3></td>
            </tr>
        </table>
        <table width="100%" class="main_t">
            <thead>
                <tr>
                    <th style="width:10%;padding:20px 0;">SOA No</th>
                    <th style="width:9%;padding:20px 0;">SOA Amount</th>
                    <th style="width:10%;padding:20px 0;">Batch Date</th>
                    <th style="width:10%;padding:20px 0;">Activation Date</th>
                    <th style="width:10%;padding:20px 0;">Activated By</th>
                    <th style="width:10%;padding:20px 0;">Confirmation Date</th>
                    <th style="width:13%;padding:20px 0;">Confirmed By</th>
                    <th style="width:13%;padding:20px 0;">Transmittal Date</th>
                    <th style="width:8%;padding:20px 0;">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if($records != 'fail'): ?>
                <?php foreach($records as $record): ?>
                <tr>
                    <td style="text-align:left;"><?php echo $record->soaNumber; ?></td>
                    <td style="text-align:right;"><?php echo number_format((float)$record->amount, 2, '.', ','); ?></td>
                    <td style="text-align:left;"><?php  echo $record->xDate ? date('Y-m-d',strtotime($record->xDate)) : ""; ?></td>
                    <td style="text-align:left;"><?php echo date('Y-m-d h:m:s A',strtotime($record->created_at));  ?></td>
                    <td style="text-align:left;"><?php echo $record->preparedBy; ?></td>
                    <td style="text-align:left;"><?php  echo $record->ConfirmedDateTime ? date('Y-m-d h:m:s A',strtotime($record->ConfirmedDateTime)) : ""; ?></td>
                    <td style="text-align:left;"><?php echo $record->adminConfirmedBy; ?></td>
                    <td style="text-align:left;"><?php  echo $record->TransmittedDate ? date('Y-m-d h:m:s A',strtotime($record->TransmittedDate)) : ""; ?></td>
                    <td style="text-align:left;"><?php echo $record->status; ?></td>
                    
                </tr>
                <?php $total = $total + $record->amount; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if($records_sar != 'fail'): ?>
                <?php foreach($records_sar as $record_sar): ?>
                <tr>
                    <td style="text-align:left;"><?php echo $record_sar->soaNumber; ?></td>
                    <td style="text-align:right;"><?php echo number_format((float)$record_sar->amount, 2, '.', ','); ?></td>
                    <td style="text-align:left;"><?php  echo $record_sar->xDate ? date('Y-m-d',strtotime($record_sar->xDate)) : ""; ?></td>
                    <td style="text-align:left;"><?php echo date('Y-m-d h:m:s A',strtotime($record_sar->created_at));  ?></td>
                    <td style="text-align:left;"><?php echo $record_sar->preparedBy; ?></td>
                    <td style="text-align:left;"><?php  echo $record_sar->adminConfirmedDate ? date('Y-m-d h:m:s A',strtotime($record_sar->adminConfirmedDate)) : ""; ?></td>
                    <td style="text-align:left;"><?php echo $record_sar->adminConfirmedBy; ?></td>
                    <td style="text-align:left;"><?php  echo $record_sar->adminTransmittedDate ? date('Y-m-d h:m:s A',strtotime($record_sar->adminTransmittedDate)) : ""; ?></td>
                    <td style="text-align:left;"><?php echo $record_sar->status; ?></td>
                    
                </tr>
                <?php $total = $total + $record_sar->amount; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            
                <tr>
                    <td colspan="1" style="text-align:right;color:red;border:none;font-weight:bold;">TOTAL AMOUNT</td>
                    <td style="text-align:right;border-bottom:3px double black;"><?php echo number_format((float)$total, 2, '.', ','); ?></td>
                    <td style="border:none;"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table width="100%">
            <tr>
                <td>
                    <table width="50%">
                        <tr>
                            <td style="width:20%;font-weight:bold;">Prepared By:</td>
                            <td style="width:5%;font-weight:bold;"></td>
                            <td style="width:20%;font-weight:bold;"></td>
                            <td style="width:5%;font-weight:bold;"></td>
                            <td style="width:20%;font-weight:bold;"></td>
                            <td style="width:5%;font-weight:bold;"></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;text-align:center;"><?php echo $preparedby; ?></td>
                            <td style="font-weight:bold;"></td>
                            <td style="font-weight:bold;text-align:center;"></td>
                            <td style="font-weight:bold;"></td>
                            <td style="font-weight:bold;text-align:center;"></td>
                            <td style="font-weight:bold;"></td>
                        </tr>
                        <tr>
                            <td style="border-top:1px solid black;text-align:center;"></td>
                            <td style=""></td>
                            <td style="text-align:center;"></td>
                            <td style=""></td>
                            <td style="text-align:center;"></td>
                            <td style=""></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    
        <!-- footer -->
        <htmlpagefooter name="myFooter" class="footer" style="display:none">
            <div style="text-align: center;font-weight:bold;font-size:90%;">
                <!-- Page {PAGENO} of {nbpg} -->
            </div>
        </htmlpagefooter>
    </body>
</html>