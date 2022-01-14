<?php 
    header('Content-type: application/excel');
    $filename = 'ProjectLedger-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	$total_dc = 0;
	$total_dm = 0;
	$total_dl = 0;
	$total_o = 0;
?>
	<html xmlns:x="urn:schemas-microsoft-com:office:excel">
		<head>
		</head>
		<style>
			body {
				font-family: 'Courier New';
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
	
			@page { sheet-size: Legal; }
			
			@page {
				margin-top: 1cm;
				margin-bottom: 1cm;
				margin-left: 2.5cm;
				margin-right: 2.5cm;
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
			<?php if($records != 'fail'): ?>
			<table width="100%">
				<tr>
					<td style="width:100%;text-align:center;">
						<h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
						<h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
						<h3 style="text-align:center;text-decoration:underline;">Project Ledger</h3>
					</td>
				</tr>
			</table><br><br>
			<table width="100%">
				<?php foreach($records as $record):?>
				<tr>
					<td colspan="3"><b>Project Name: <?php echo $record['ItemDesc']; ?></b></td>
				</tr>
				<tr>
					<td colspan="3"><b>PO #: <?php echo $record['DocumentNum']; ?></b></td>
				</tr>
				<tr>
					<td colspan="3"><b>Contract Price: <?php echo number_format((float)$record['Amt'], 2, '.', ','); ?></b></td>
				</tr>
				<tr>
					<td colspan="3"><b>Date Started: <?php echo date('m-d-Y', strtotime($record['DelDate'])); ?></b></td>
				</tr>
				<tr>
					<td colspan="3"><b>Date Finished:</b></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="2">Contract Price</td>
					<td style="text-align:right;"><?php echo number_format((float)$record['Amt'], 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="2">Percentage of Completion</td>
					<td style="text-align:right;"><?php echo $record['completion'] . '%'; ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="2">Todate Revenue</td>
					<td style="text-align:right;"><?php echo number_format((float)$record['Amt'] * ($record['completion']/100), 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3">Less: Direct Cost to Date</td>
				</tr>
				<tr>
					<td colspan="3">Direct Materials</td>
				</tr>
				<?php if(count($record['direcr_materials']) > 0): ?>
					<?php $count_dm = 0; ?>
					<?php foreach($record['direcr_materials'] as $dm): ?>
						<?php $total_dm += $dm->Amount; ?>
						<?php $total_dc += $dm->Amount; ?>
						<?php $count_dm += 1; ?>
						<tr>
							<td><?php echo $dm->Expensetype; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$dm->Amount, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo $count_dm == count($record['direcr_materials']) ? number_format((float)$total_dm, 2, '.', ',') : ''; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3">Direct Labor</td>
				</tr>
				<?php if(count($record['direcr_labor']) > 0): ?>
					<?php $count_dl = 0; ?>
					<?php foreach($record['direcr_labor'] as $dl): ?>
						<?php $total_dl += $dl->Amount; ?>
						<?php $total_dc += $dl->Amount; ?>
						<?php $count_dl += 1; ?>
						<tr>
							<td><?php echo $dl->Expensetype; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$dl->Amount, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo $count_dl == count($record['direcr_labor']) ? number_format((float)$total_dl, 2, '.', ',') : ''; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3">Overhead</td>
				</tr>
				<?php if(count($record['overhead']) > 0): ?>
					<?php $count_o = 0; ?>
					<?php foreach($record['overhead'] as $o): ?>
						<?php $total_o += $o->Amount; ?>
						<?php $total_dc += $o->Amount; ?>
						<?php $count_o += 1; ?>
						<tr>
							<td><?php echo $o->Expensetype; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$o->Amount, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo $count_o == count($record['overhead']) ? number_format((float)$total_o, 2, '.', ',') : ''; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="2">Total Direct Cost</td>
					<td style="text-align:right;"><?php echo number_format((float)$total_dc, 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="2">Project Gain/Loss</td>
					<td style="text-align:right;"><?php echo number_format((float)($record['Amt'] * ($record['completion']/100)) - $total_dc, 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="2">Total Billed</td>
					<td style="text-align:right;"><?php echo number_format((float)$record['total_billed'], 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td colspan="2">Total Unbilled</td>
					<td style="text-align:right;"><?php echo number_format((float)$record['Amt'] - $record['total_billed'], 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="2">Total Collection</td>
					<td style="text-align:right;"><?php echo number_format((float)$record['total_paid'], 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="2">Total Outstanding Balance</td>
					<td style="text-align:right;"><?php echo number_format((float)$record['Amt'] - $record['total_paid'], 2, '.', ','); ?></td>
				</tr>
				<?php endforeach; ?>
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