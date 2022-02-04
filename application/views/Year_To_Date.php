<?php 
    header('Content-type: application/excel');
    $filename = 'Year To Date Collection - '. date('mdY') .'.xls';
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

        @page { sheet-size: Letter-L; }
        
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
                    <h2 style="text-align:center;text-decoration:underline;">YEAR TO DATE COLLECTION REPORT</h3>
                </td>
            </tr>
        </table>
        <br><br>
        <table width="100%" class="main_t">
            <thead>
                <tr>
                    <th style="padding:10px 0;" rowspan="2">Date</th>
                    <th style="padding:10px 0;" colspan="2">BILLING</th>
                    <th style="padding:10px 0;" colspan="2">COLLECTION</th>
                    <th style="padding:10px 0;" rowspan="2">DATE</th>
                    <th style="padding:10px 0;" rowspan="2">OR #</th>
                    <th style="padding:10px 0;" colspan="2">UNCOLLECTED</th>
                    <th style="padding:10px 0;" >TO DATE</th>
                </tr>
                <tr>
                    <th>HEAD BASE</th>
                    <th>VOLUME BASE</th>
                    <th>HEAD BASE</th>
                    <th>VOLUME BASE</th>
                    <th>HEAD BASE</th>
                    <th>VOLUME BASE</th>
                    <th>UNPAID</th>
                </tr>
            </thead>
            <tbody>
                <?php $loop = 0; ?>
                <?php $MonthlyTotal = 0; ?>
                <?php $MonthlyCollection = 0; ?>
                <?php $MonthlyUncollected = 0; ?>
                <?php $Unpaid = 0; ?>
                <?php foreach($records as $record): ?>
                    <?php $Total_Headbase_Collection = 0; ?>
                    <?php $Total_Volume_Collection = 0; ?>
                    <?php $Total_Volume_Collection = 0; ?>
                    <?php if(count($record['hbc']) > 0): ?>
                    <tr>
                        <td style="border-bottom:none;" rowspan="<?php count($record['hbc']); ?>"></td>
                        <td rowspan="<?php count($record['hbc']); ?>"></td>
                        <td rowspan="<?php count($record['hbc']); ?>"></td>
                        <?php foreach($record['hbc'] as $collect): ?>
                            <td style="text-align:right;"><?php echo number_format((float)$collect->collection, 2, '.', ','); ?></td>
                            <td></td>
                            <td style="text-align:center"><?php echo date('d-M-Y', strtotime($collect->PayDate)); ?></td>
                            <td><?php echo $collect->ORNo; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php $Total_Headbase_Collection += $collect->collection; ?>
                        <?php endforeach; ?>
                    </tr>
                    <?php endif; ?>
                    <?php if(count($record['vbc']) > 0): ?>
                    <tr>
                        <td style="border-bottom:none;" rowspan="<?php count($record['vbc']); ?>"></td>
                        <td rowspan="<?php count($record['vbc']); ?>"></td>
                        <td rowspan="<?php count($record['vbc']); ?>"></td>
                        <td rowspan="<?php count($record['vbc']); ?>"></td>
                        <?php foreach($record['hbc'] as $collect): ?>
                            <td style="text-align:right;"><?php echo number_format((float)$collect->collection, 2, '.', ','); ?></td>
                            <td style="text-align:center"><?php echo date('d-M-Y', strtotime($collect->PayDate)); ?></td>
                            <td><?php echo $collect->ORNo; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php $Total_Volume_Collection += $collect->collection; ?>
                        <?php endforeach; ?>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td style="border-bottom:none;border-top:none;"></td>
                        <td style="text-align:right;"><?php echo number_format((float)$record['headbase'], 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format((float)$record['volumebase'], 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format((float)$Total_Headbase_Collection, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format((float)$Total_Volume_Collection, 2, '.', ','); ?></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;"><?php echo number_format((float)$record['headbase'] - $Total_Headbase_Collection, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo number_format((float)$record['volumebase'] - $Total_Volume_Collection, 2, '.', ','); ?></td>
                        <td></td>
                        <?php $Uncollected_HB = $record['headbase'] - $Total_Headbase_Collection; ?>
                        <?php $Uncollected_VB = $record['volumebase'] - $Total_Volume_Collection; ?>
                    </tr>
                    <?php $total_amts = $record['headbase'] + $record['volumebase']; ?>
                    <?php $Total_Collections =  $Total_Headbase_Collection + $Total_Volume_Collection; ?>
                    <?php $Total_Uncollected = $Uncollected_HB + $Uncollected_VB; ?>
                    <tr>
                        <td style="border-top:none;"><strong><?php echo $record['Period']; ?></strong></td>
                        <td colspan="2" style="text-align:center"><strong><?php echo number_format((float)$total_amts, 2, '.', ','); ?></strong></td>
                        <td colspan="2" style="text-align:center"><strong><?php echo number_format((float)$Total_Collections, 2, '.', ','); ?></strong></td>
                        <td></td>
                        <td></td>
                        <td colspan="2" style="text-align:center"><strong><?php echo number_format((float)$Total_Uncollected, 2, '.', ','); ?></strong></td>
                        <td></td>
                    </tr>
                    <?php $MonthlyTotal += $total_amts; ?>
                    <?php $MonthlyCollection += $Total_Collections; ?>
                    <?php $MonthlyUncollected += $Total_Uncollected; ?>
                    <?php $Unpaid += $Total_Uncollected; ?>
                    <?php $loop++; ?>
                    <?php if($loop % 2 == 0): ?>
                        <tr>
                            <td><strong>TOTAL</strong></td>
                            <td colspan="2" style="text-align:center"><strong><?php echo number_format((float)$MonthlyTotal, 2, '.', ','); ?></strong></td>
                            <td colspan="2" style="text-align:center"><strong><?php echo number_format((float)$MonthlyCollection, 2, '.', ','); ?></strong></td>
                            <td></td>
                            <td></td>
                            <td colspan="2" style="text-align:center;"><strong><?php echo number_format((float)$MonthlyUncollected, 2, '.', ','); ?></strong></td>
                            <td style="text-align:center;"><strong><?php echo number_format((float)$Unpaid, 2, '.', ','); ?></strong></td>
                        </tr>
                        <?php $MonthlyTotal = 0; ?>
                        <?php $MonthlyCollection = 0; ?>
                        <?php $MonthlyUncollected = 0; ?>
                    <?php endif; ?>
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