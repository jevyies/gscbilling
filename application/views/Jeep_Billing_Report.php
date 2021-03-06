<?php 
    header('Content-type: application/excel');
    $filename = 'Jeep Billing Report -'. date('mdY') .'.xls';
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
				/* odd-footer-name: html_myFooter; */
			}
			
			h1.bigsection {
					page-break-before: always;
					page: bigger;
			}
			.main_t td, th{
				font-size: 90%;
				border:1px solid black;
				padding: 2px;
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
					<td colspan="11" style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</td>
				</tr>
				<tr>
					<td colspan="11" style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="border:1px solid black;">
						<th style="padding:5px 0;width:8%">No</th>
						<th style="padding:5px 0;width:10%">Operator</th>
						<th style="padding:5px 0;width:8%">Unit No</th>
						<th style="padding:5px 0;width:10%">Billed Amount</th>
						<th style="padding:5px 0;width:8%">Admin Fee</th>
						<th style="padding:5px 0;width:8%">Net From 10% Admin</th>
						<th style="padding:5px 0;width:8%">2% CWT</th>
						<th style="padding:5px 0;width:8%">Operator Fuel Consumption</th>
						<th style="padding:5px 0;width:8%">Net Pay of Operator</th>
						<th style="padding:5px 0;width:8%">Collection</th>
						<th style="padding:5px 0;width:8%">Balance</th>
					</tr>
				</thead>
				<tbody>
					<?php $No = 0; ?>
					<?php $TotalBillAmount = 0; ?>
					<?php $TotalLessAdmin = 0; ?>
					<?php $TotalNetOpWith10 = 0; ?>
					<?php $TotalCWT = 0; ?>
					<?php $TotalFuel = 0; ?>
					<?php $TotalNet = 0; ?>
					<?php $TotalCollection = 0; ?>
					<?php $TotalBalance = 0; ?>
					<?php foreach($records as $record): ?>
						<?php $balance = $record->TotalBilled - $record->TotalCollection; ?>
						<?php $NetOpWith10 = $record->TotalBilled - $record->TotalAdmin; ?>
						<?php $TotalTrucker = $record->TotalBilled - ($record->TotalAdmin + $record->TotalCWT + $record->TotalFuel); ?>
                        <tr>
                            <td class="text-center"><?php echo $No = $No+1; ?></td>
                            <td class="text-center"><?php echo $record->TruckerName; ?></td>
                            <td class="text-center"><?php echo $record->JeepPlateNo; ?></td>
                            <td class="text-right"><?php echo number_format((float)$record->TotalBilled, 2, '.', ','); ?></td>
                            <td class="text-right"><?php echo number_format((float)$record->TotalAdmin, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)$NetOpWith10, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)$record->TotalCWT, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)$record->TotalFuel, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)$TotalTrucker, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)$record->TotalCollection, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)$balance, 2, '.', ','); ?></td>
						</tr>
						<?php 
							$TotalBillAmount = $TotalBillAmount + $record->TotalBilled;
							$TotalLessAdmin = $TotalLessAdmin + $record->TotalAdmin; 
							$TotalNetOpWith10 = $TotalNetOpWith10 + $NetOpWith10; 
							$TotalCWT = $TotalCWT + $record->TotalCWT; 
							$TotalFuel = $TotalFuel + $record->TotalFuel; 
							$TotalNet = $TotalNet + $TotalTrucker; 
							$TotalCollection = $TotalCollection + $record->TotalCollection; 
							$TotalBalance = $TotalBalance + $balance; 
						?>
					<?php endforeach; ?>
					<tr>
						<td colspan="3"><strong>TOTAL:</strong></td>
						<td class="text-right"><?php echo number_format((float)$TotalBillAmount, 2, '.', ','); ?></td>
						<td class="text-right"><?php echo number_format((float)$TotalLessAdmin, 2, '.', ','); ?></td>
						<td class="text-right"><?php echo number_format((float)$TotalNetOpWith10, 2, '.', ','); ?></td>
						<td class="text-right"><?php echo number_format((float)$TotalCWT, 2, '.', ','); ?></td>
						<td class="text-right"><?php echo number_format((float)$TotalFuel, 2, '.', ','); ?></td>
						<td class="text-right"><?php echo number_format((float)$TotalNet, 2, '.', ','); ?></td>
						<td class="text-right"><?php echo number_format((float)$TotalCollection, 2, '.', ','); ?></td>
						<td class="text-right"><?php echo number_format((float)$TotalBalance, 2, '.', ','); ?></td>
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