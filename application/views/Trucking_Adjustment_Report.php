<?php 
    header('Content-type: application/excel');
    $filename = 'Trucking Adjustment Report -'. date('mdY') .'.xls';
    header('Content-Disposition: attachment; filename='.$filename);
    // $x_from = explode('-', $from);
    // $x_to = explode('-', $to);
    // $diff = (int)($x_to[1]) - (int)($x_from[1]);
    // if($diff > 0){
    //     $period = strtoupper(date('F j, Y', strtotime($from)) ." - ". date('F j, Y', strtotime($to)));
    // }else{
    //     $period = strtoupper(date('F j', strtotime($from)) ."-". date('j, Y', strtotime($to)));
    // }
?>
	<html xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
		</head>
		<style>
			body {
				font-family: 'Courier New';
			}
            .text-center{
                text-align: center;
            }
            .text-right{
                text-align: right;
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
                    <td style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</td>
                </tr>
                <tr>
                    <td style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</td>
                </tr>
            </table>
            <table width="100%">
                <tr style="border:1px solid black;">
                    <th rowspan="2">UNIT</th>
                    <th colspan="12">ADJUSTMENT</th>
                    <th rowspan="2">INCOME REPORT</th>
                    <th rowspan="2">TOTAL</th>
                </tr>
                <tr>
                    <th>JANUARY</th>
                    <th>FEBRUARY</th>
                    <th>MARCH</th>
                    <th>APRIL</th>
                    <th>MAY</th>
                    <th>JUNE</th>
                    <th>JULY</th>
                    <th>AUGUST</th>
                    <th>SEPTEMBER</th>
                    <th>OCTOBER</th>
                    <th>NOVEMBER</th>
                    <th>DECEMBER</th>
                </tr>
                <?php foreach($records as $record): ?>
                    <?php $Total = $record['Total'] + $record['Collection']; ?>
                    <tr style="border:1px solid black;">
                        <td style="border:1px solid black;"><?php echo $record['Unit']; ?></td>
                        <?php if($record['January'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['January'], 2, '.', ','); ?></td>
                        <?php elseif($record['January'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['January']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['February'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['February'], 2, '.', ','); ?></td>
                        <?php elseif($record['February'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['February']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['March'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['March'], 2, '.', ','); ?></td>
                        <?php elseif($record['March'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['March']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['April'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['April'], 2, '.', ','); ?></td>
                        <?php elseif($record['April'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['April']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['May'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['May'], 2, '.', ','); ?></td>
                        <?php elseif($record['May'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['May']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['June'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['June'], 2, '.', ','); ?></td>
                        <?php elseif($record['June'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['June']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['July'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['July'], 2, '.', ','); ?></td>
                        <?php elseif($record['July'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['July']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['August'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['August'], 2, '.', ','); ?></td>
                        <?php elseif($record['August'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['August']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['September'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['September'], 2, '.', ','); ?></td>
                        <?php elseif($record['September'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['September']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['October'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['October'], 2, '.', ','); ?></td>
                        <?php elseif($record['October'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['October']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['November'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['November'], 2, '.', ','); ?></td>
                        <?php elseif($record['November'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['November']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['December'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['December'], 2, '.', ','); ?></td>
                        <?php elseif($record['December'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['December']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['Collection'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['Collection'], 2, '.', ','); ?></td>
                        <?php elseif($record['Collection'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['Collection']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($Total > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$Total, 2, '.', ','); ?></td>
                        <?php elseif($Total < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($Total), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <?php if($golfcarts): ?>
                    <?php foreach($golfcarts as $record): ?>
                    <?php $Total = $record['Total'] + $record['Collection']; ?>
                    <tr style="border:1px solid black;">
                        <td style="border:1px solid black;"><?php echo $record['Unit']; ?></td>
                        <?php if($record['January'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['January'], 2, '.', ','); ?></td>
                        <?php elseif($record['January'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['January']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['February'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['February'], 2, '.', ','); ?></td>
                        <?php elseif($record['February'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['February']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['March'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['March'], 2, '.', ','); ?></td>
                        <?php elseif($record['March'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['March']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['April'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['April'], 2, '.', ','); ?></td>
                        <?php elseif($record['April'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['April']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['May'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['May'], 2, '.', ','); ?></td>
                        <?php elseif($record['May'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['May']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['June'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['June'], 2, '.', ','); ?></td>
                        <?php elseif($record['June'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['June']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['July'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['July'], 2, '.', ','); ?></td>
                        <?php elseif($record['July'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['July']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['August'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['August'], 2, '.', ','); ?></td>
                        <?php elseif($record['August'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['August']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['September'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['September'], 2, '.', ','); ?></td>
                        <?php elseif($record['September'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['September']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['October'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['October'], 2, '.', ','); ?></td>
                        <?php elseif($record['October'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['October']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['November'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['November'], 2, '.', ','); ?></td>
                        <?php elseif($record['November'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['November']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['December'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['December'], 2, '.', ','); ?></td>
                        <?php elseif($record['December'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['December']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['Collection'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['Collection'], 2, '.', ','); ?></td>
                        <?php elseif($record['Collection'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['Collection']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($Total > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$Total, 2, '.', ','); ?></td>
                        <?php elseif($Total < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($Total), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr style="border:1px solid black;">
                        <td style="border:1px solid black;">GOLF CART</td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                    </tr>
                <?php endif; ?>
                <?php if($jeeps): ?>
                    <?php foreach($jeeps as $record): ?>
                    <?php $Total = $record['Total'] + $record['Collection']; ?>
                    <tr style="border:1px solid black;">
                        <td style="border:1px solid black;"><?php echo $record['Unit']; ?></td>
                        <?php if($record['January'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['January'], 2, '.', ','); ?></td>
                        <?php elseif($record['January'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['January']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['February'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['February'], 2, '.', ','); ?></td>
                        <?php elseif($record['February'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['February']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['March'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['March'], 2, '.', ','); ?></td>
                        <?php elseif($record['March'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['March']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['April'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['April'], 2, '.', ','); ?></td>
                        <?php elseif($record['April'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['April']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['May'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['May'], 2, '.', ','); ?></td>
                        <?php elseif($record['May'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['May']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['June'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['June'], 2, '.', ','); ?></td>
                        <?php elseif($record['June'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['June']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['July'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['July'], 2, '.', ','); ?></td>
                        <?php elseif($record['July'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['July']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['August'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['August'], 2, '.', ','); ?></td>
                        <?php elseif($record['August'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['August']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['September'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['September'], 2, '.', ','); ?></td>
                        <?php elseif($record['September'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['September']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['October'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['October'], 2, '.', ','); ?></td>
                        <?php elseif($record['October'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['October']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['November'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['November'], 2, '.', ','); ?></td>
                        <?php elseif($record['November'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['November']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['December'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['December'], 2, '.', ','); ?></td>
                        <?php elseif($record['December'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['December']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($record['Collection'] > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$record['Collection'], 2, '.', ','); ?></td>
                        <?php elseif($record['Collection'] < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($record['Collection']), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                        <?php if($Total > 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo number_format((float)$Total, 2, '.', ','); ?></td>
                        <?php elseif($Total < 0): ?>
                            <td style="border:1px solid black;text-align:right;"><?php echo '('.number_format((float)abs($Total), 2, '.', ',').')'; ?></td>
                        <?php else: ?>
                            <td style="text-align:right;border:1px solid black;"></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr style="border:1px solid black;">
                        <td style="border:1px solid black;">JEEP</td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                    </tr>
                <?php endif; ?>
            </table>
        </body>
    </html>