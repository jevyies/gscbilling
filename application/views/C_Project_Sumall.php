<?php 
    header('Content-type: application/excel');
    $filename = 'ProjectSumAll-'. date('mdY') .'.xls';
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
			<table width="100%">
				<tr>
					<td style="width:100%;text-align:center;">
						<h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
						<h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
						<h3 style="text-align:center;text-decoration:underline;">Sum of all project</h3>
					</td>
				</tr>
			</table><br><br>
			<table width="100%" class="main_t">
				<thead>
					<tr style="background:lightgreen;">
						<th style="width:10%;padding:20px 0;">Project</th>
						<th style="width:10%;padding:20px 0;">Project Batch</th>
						<th style="width:10%;padding:20px 0;">Contract Price</th>
						<th style="width:10%;padding:20px 0;">Project Completion</th>
						<th style="width:10%;padding:20px 0;">Monthly Revenue</th>
						<th style="width:10%;padding:20px 0;">Direct Materials</th>
						<th style="width:10%;padding:20px 0;">Direct Labor</th>
						<th style="width:10%;padding:20px 0;">Overhead</th>
						<th style="width:10%;padding:20px 0;">Total Direct Cost</th>
						<th style="width:10%;padding:20px 0;">Profit to Date</th>
						<th style="width:10%;padding:20px 0;">P.O AMOUNT REMAINING/NET/LOSS</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
					<tr>
						<td style="text-align:left;"><?php echo $record->ItemDesc; ?></td>
						<td style="text-align:center;"><?php echo $record->batchNo; ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->SUMASS, 2, '.', ','); ?></td>
						<td style="text-align:center;"><?php echo $record->completion; ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->monthly_rev, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->dm_total, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->dl_total, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->ov_total, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->direct_cost, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->profit, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->balance, 2, '.', ','); ?></td>
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
			<!-- <table width="100%">
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
								<td style="font-weight:bold;text-align:center;"><?php// echo $prepared_by; ?></td>
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
			</table> -->
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