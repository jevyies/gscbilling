<?php 
    header('Content-type: application/excel');
    $filename = 'ProjectOngoing-'. date('mdY') .'.xls';
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
						<h3 style="text-align:center;text-decoration:underline;">ONGOING PROJECTS</h3>
						<h3 style="text-align:center;text-decoration:underline;">AS OF <?php echo date('F j, Y'); ?></h3>
					</td>
				</tr>
			</table><br><br>
			<table width="100%" class="main_t">
				<thead>
					<tr>
						<th colspan="3" style="border:none;"></th>
						<th colspan="8" style="font-weight:bold;">EXPENSES</th>
						<th colspan="8" style="border:none;"></th>
					</tr>
					<tr style="background:lightgreen;">
						<th rowspan="2" style="width:10%;padding:20px 0;">Project</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">P.O no.</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">Total Amount</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">Contracted Labor</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">Professional Fee</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">Gov't remittance</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">Fuel</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">Driver</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">CLERK</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">Materials</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">MEAL/HAUL</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">TOTAL EXPENSES</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">Net/Loss</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">STARTED</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">COMPLETED</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">BILLED</th>
						<th colspan="3" style="width:10%;padding:20px 0;">COLLECTED</th>
						<th rowspan="2" style="width:10%;padding:20px 0;">BALANCE</th>
					</tr>
					<tr>
						<!-- <th colspan="16" style="border:none;border-left:1px solid black;"></th> -->
						<th style="width:10%;padding:20px 0;">Amount</th>
						<th style="width:10%;padding:20px 0;">OR No.</th>
						<th style="width:10%;padding:20px 0;">Check Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
					<tr>
						<td style="text-align:left;padding:5px;"><?php echo $record['ItemDesc']; ?></td>
						<td style="text-align:left;padding:5px;"><?php echo $record['DocumentNum']; ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['Amt'] == 0 ? '-' : number_format((float)$record['Amt'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['cl'] == 0 ? '-' :  number_format((float)$record['cl'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['pf'] == 0 ? '-' :  number_format((float)$record['pf'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['gr'] == 0 ? '-' :  number_format((float)$record['gr'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['f'] == 0 ? '-' :  number_format((float)$record['f'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['d'] == 0 ? '-' :  number_format((float)$record['d'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['c'] == 0 ? '-' :  number_format((float)$record['c'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['m'] == 0 ? '-' :  number_format((float)$record['m'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['mh'] == 0 ? '-' :  number_format((float)$record['mh'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['total_expenses'] == 0 ? '-' :  number_format((float)$record['total_expenses'], 2, '.', ','); ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['Amt'] - $record['total_expenses'] == 0 ? '-' :  number_format((float)$record['Amt'] - $record['total_expenses'], 2, '.', ','); ?></td>
						<td style="text-align:center;padding:5px;"><?php echo date('d-m-Y', strtotime($record['DelDate'])); ?></td>
						<td style="text-align:center;padding:5px;"></td>
						<td style="text-align:center;padding:5px;"><?php echo $record['billed_date']; ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['amount']; ?></td>
						<td style="text-align:center;padding:5px;"><?php echo $record['ORNo']; ?></td>
						<td style="text-align:center;padding:5px;"><?php echo $record['check_date']; ?></td>
						<td style="text-align:right;padding:5px;"><?php echo $record['Amt'] - $record['total_paid'] == 0 ? '-' : number_format((float)$record['Amt'] - $record['total_paid'], 2, '.', ','); ?></td>
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