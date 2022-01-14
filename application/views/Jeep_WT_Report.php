<?php 
    header('Content-type: application/excel');
    $filename = 'Jeep Witholding Tax Report -'. date('mdY') .'.xls';
    header('Content-Disposition: attachment; filename='.$filename);

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
			table.no-borders th{
				border: none;
			}
			table.no-borders td{
				border: none;
			}
			.main_t{
				margin-bottom: 30px;
			}
		</style>
		<body>
			<?php if($records != 'fail'): ?>
			<table width="100%">
				<tr>
					<td colspan="6" style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</td>
				</tr>
				<tr>
					<td colspan="6" style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</td>
                </tr>
                <tr>
					<td colspan="6" style="text-align:center;"><strong>JEEP WITHOLDING TAX REPORT</strong></td>
                </tr>
            </table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="border:1px solid black;">
						<th style="padding:20px 0;width:8%">Operator</th>
						<th style="padding:20px 0;width:10%">Unit No</th>
						<th style="padding:20px 0;width:8%">Collected Amount</th>
						<th style="padding:20px 0;width:10%">Less 10%</th>
						<th style="padding:20px 0;width:8%">Net Pay of Operator from 10% admin fee</th>
						<th style="padding:20px 0;width:8%">Less: 2% CWT</th>
					</tr>
				</thead>
				<tbody>
                    <?php $grand_total_collected = 0; ?>
                    <?php $grand_total_amount = 0; ?>
                    <?php $grand_total_ten_percent = 0; ?>
                    <?php $grand_total_two_percent = 0; ?>
                    <?php foreach($records as $record): ?>
                        <tr style="border:1px solid black;">
                            <td colspan="6"><i><strong><?php echo 'Release as of '. date('F j, Y', strtotime($record['CheckDate'])); ?></i></strong></td>
                        </tr>
                        <?php $check_total_collected = 0; ?>
                        <?php $check_total_amount = 0; ?>
                        <?php $check_total_ten_percent = 0; ?>
                        <?php $check_total_two_percent = 0; ?>
                        <?php foreach($record['details'] as $detail): ?>
                            <?php $ten_percent = $detail->TotalCollected - $detail->TotalAdmin; ?>
                            <?php $two_percent = $ten_percent * .02; ?>
                            <tr style="border:1px solid black;">
                                <td class="text-center"><?php echo $detail->TruckerName; ?></td>
                                <td class="text-center"><?php echo $detail->JeepPlateNo; ?></td>
                                <td class="text-right"><?php echo number_format((float)$detail->TotalCollected, 2, '.', ','); ?></td>
                                <td class="text-right"><?php echo number_format((float)$detail->TotalAdmin, 2, '.', ','); ?></td>
                                <td class="text-right"><?php echo number_format((float)($ten_percent), 2, '.', ','); ?></td>
                                <td class="text-right"><?php echo number_format((float)($two_percent), 2, '.', ','); ?></td>
                            </tr>
                            <?php 
                                $check_total_collected = $check_total_collected + $detail->TotalCollected; 
                                $check_total_amount = $check_total_amount + $detail->TotalAdmin; 
                                $check_total_ten_percent = $check_total_ten_percent + $ten_percent; 
                                $check_total_two_percent = $check_total_two_percent + $two_percent; 
                            ?>
                        <?php endforeach; ?>
                        <tr style="border:1px solid black;">
                            <td colspan="2"><strong>Total <?php echo date('F j, Y', strtotime($record['CheckDate'])); ?></strong></td>
                            <td class="text-right"><?php echo number_format((float)$check_total_collected, 2, '.', ','); ?></td>
                            <td class="text-right"><?php echo number_format((float)$check_total_amount, 2, '.', ','); ?></td>
                            <td class="text-right"><?php echo number_format((float)$check_total_ten_percent, 2, '.', ','); ?></td>
                            <td class="text-right"><?php echo number_format((float)$check_total_two_percent, 2, '.', ','); ?></td>
						</tr>
						<?php 
							$grand_total_collected = $grand_total_collected + $check_total_collected; 
							$grand_total_amount = $grand_total_amount + $check_total_amount; 
							$grand_total_ten_percent = $grand_total_ten_percent + $check_total_ten_percent; 
							$grand_total_two_percent = $grand_total_two_percent + $check_total_two_percent; 
						?>
                    <?php endforeach; ?>
                    <tr style="border:1px solid black;">
                        <td colspan="2"><strong>GrandTotal</strong></td>
                        <td class="text-right"><?php echo number_format((float)$grand_total_collected, 2, '.', ','); ?></td>
                        <td class="text-right"><?php echo number_format((float)$grand_total_amount, 2, '.', ','); ?></td>
                        <td class="text-right"><?php echo number_format((float)$grand_total_ten_percent, 2, '.', ','); ?></td>
                        <td class="text-right"><?php echo number_format((float)$grand_total_two_percent, 2, '.', ','); ?></td>
                    </tr>
				</tbody>
			</table>
			<table class="no-borders">
				<tr>
					<th style="width:30px;"></th>
					<th style="width:70px;"></th>
					<th style="width:180px;"></th>
					<th style="width:130px;"></th>
					<th style="width:50px;"></th>
					<th style="width:50px;"></th>
					<th style="width:50px;"></th>
					<th style="width:50px;"></th>
					<th style="width:50px;"></th>
					<th style="width:110px;"></th>
				</tr>
				<tr>
					<td></td>
					<td colspan="4" style="font-size:13px;"><strong>PREPARED BY:</strong></td>
					<td colspan="4" style="font-size:13px;"><strong>CHECKED BY:</strong></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($pb); ?></strong></td>
					<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($cb); ?></strong></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $pbp; ?></span></td>
					<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $cbp; ?></span></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($ab); ?></strong></td>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $abp; ?> </td>
					<td colspan="4"></td>
				</tr>
			</table>
			<?php else: ?>
			NO DATA FOUND...
			<?php endif; ?>
			<!-- footer -->
			<htmlpagefooter name="myFooter" class="footer" style="display:none">
				<div style="text-align: center;font-weight:bold;font-size:90%;">
					<!-- Page {PAGENO} of {nbpg} -->
				</div>
			</htmlpagefooter>
		</body>
	</html>