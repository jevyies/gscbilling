<?php 
    header('Content-type: application/excel');
    $filename = 'ProjectTO-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	//if($records != 'fail'){
	//	foreach($records as $record){
	//		$prepared_by = $record->prepared_by;
	//		$transmittal_no = $record->transmittal_no;
	//		break;
	//	}
	//}
	//$total = 0;
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
			<?php if($records != 'fail'): ?>
			<?php //var_dump($records); ?>
			<table width="100%">
				<tr>
					<td style="width:100%;text-align:center;">
						<h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
						<h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
						<h3 style="text-align:center;">DMPI PROJECTS</h3>
						<h3 style="text-align:center;"><?php echo date('F Y', strtotime($selectMonth)); ?></h3>
					</td>
				</tr>
			</table><br><br>
			<table width="100%" class="main_t">
				<thead>
					<tr style="background:lightgreen;">
						<th style="width:100px;padding:20px 0;">Project</th>
						<th style="width:100px;padding:20px 0;">P.O no.</th>
						<th style="width:100px;padding:20px 0;">Total Amount</th>
						<th style="width:100px;padding:20px 0;">BILLED</th>
						<th style="width:100px;padding:20px 0;">UNBILLED</th>
						<th style="width:100px;padding:20px 0;">COLLECTED</th>
						<th style="width:100px;padding:20px 0;">BALANCE</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
						<tr>
						<td style="text-align:left;padding:10px;"><?php echo $record['ItemDesc']; ?></td>
						<td style="text-align:left;padding:10px;"><?php echo $record['DocumentNum']; ?></td>
						<td style="text-align:right;padding:10px;"><?php echo $record['Amt'] == 0 ? '-' : number_format((float)$record['Amt'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:10px;"><?php echo $record['Amt'] == 0 ? '-' : number_format((float)$record['Amt'] * ($record['completion']/100), 2, '.', ','); ?></td>
						<td style="text-align:right;padding:10px;"><?php echo $record['Amt'] == 0 ? '-' : number_format((float)$record['Amt'] - ($record['Amt'] * ($record['completion']/100)), 2, '.', ','); ?></td>
						<td style="text-align:right;padding:10px;"><?php echo number_format((float)$record['total_paid'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:10px;"><?php echo $record['Amt'] - $record['total_paid'] == 0 ? '-' : number_format((float)$record['Amt'] - $record['total_paid'], 2, '.', ','); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
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