<?php 
    header('Content-type: application/excel');
    $filename = 'TransmittalReport-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records != 'fail'){
		foreach($records as $record){
			$transmittal_no = $record->transmittal_no;
			$invoice_number = $record->invoice_number;
			$date_transmitted = $record->date_transmitted;
			$period = $record->Period;
			$year = substr($period, 0, 4);
			$month_number = substr($period, 4, 2);
			$period_number = substr($period, 7, 1);
			$month_name = date('F', mktime(0, 0, 0, (int)$month_number, 10));
			if($period_number == 2){
				$day_start = '16';
				$day_end = date("t", strtotime($year.'-'.$month_number.'-'.'01'));
			}else{
				$day_start = '01';
				$day_end = '15';
			}
			$period_covered = strtoupper($month_name).' '.$day_start.'-'.$day_end.', '.$year;
			$period_covered_number = $month_number.'/'.$day_start.'-'.$day_end.'/'.substr($year, 2, 2);
			break;
		}
	}
	$total = 0;
	$total_hc = 0;
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
				margin-left: 1cm;
				margin-right: 1cm;
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
			<h4 style="text-align:center;"><b>GENERAL SERVICES MULTIPURPOSE COOPERATIVE</b><br><br>Borja Road, Damilag, M.F. Bukidnon<br><br>BILLING TRANSMITTAL</h4>
			<br>
			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="width:60%;padding-bottom:none;">Period Covered: <?php echo $period_covered; ?></td>
					<td style="width:40%;padding-bottom:none;">Billing Statement #: <?php echo $invoice_number; ?></td>
				</tr>
				<tr>
					<td colspan="2" style="padding-bottom:none;">Date Transmitted: <?php echo date('F j, Y', strtotime($date_transmitted)); ?></td>
				</tr>
				<tr>
					<td colspan="2" style="padding-bottom:none;"><b>TRANSMITTAL #: <?php echo $transmittal_no; ?></b></td>
				</tr>
				<tr>
					<td colspan="2" style="padding-bottom:none;">To Accounting</td>
				</tr>
			</table>
			<br>
			<br>
			<br>
			<br>
			<table width="100%" class="main_t">
				<thead>
					<tr>
						<th style="">ITEM #</th>
						<th style="">DOCUMENT DATE</th>
						<th style="">DEPARTMENT</th>
						<th style="">GSMPC SOA #</th>
						<th style="">ST</th>
						<th style="">HC</th>
						<th style="">TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; ?>
					<?php foreach($records as $record): ?>
					<?php
						$period = $record->Period;
						$year = substr($period, 0, 4);
						$month_number = substr($period, 4, 2);
						$period_number = substr($period, 7, 1);
						$month_name = date('F', mktime(0, 0, 0, (int)$month_number, 10));
						if($period_number == 2){
							$day_start = '16';
							$day_end = date("t", strtotime($year.'-'.$month_number.'-'.'01'));
						}else{
							$day_start = '01';
							$day_end = '15';
						}
						$period_covered = strtoupper($month_name).' '.$day_start.'-'.$day_end.', '.$year;
						$period_covered_number = $month_number.'/'.$day_start.'-'.$day_end.'/'.substr($year, 2, 2);
					?>
					<tr>
						<td style="text-align:center;"><?php echo $no; ?></td>
						<td style="text-align:center;"><?php echo $period_covered_number; ?></td>
						<td style="text-align:center;"><?php echo $record->Location; ?></td>
						<td style="text-align:center;"><?php echo $record->SOANo; ?></td>
						<td style="text-align:center;"><?php echo $record->ST; ?></td>
						<td style="text-align:center;"><?php echo $record->HC; ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->billed_amount, 2, '.', ','); ?></td>
					</tr>
					<?php $total = $total + $record->billed_amount; ?>
					<?php $total_hc = $total_hc + $record->HC; ?>
					<?php $no++; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="5" style="border:none;"></td>
						<td style="text-align:center;border-bottom:3px double black;"><?php echo $total_hc; ?></td>
						<td style="text-align:right;border-bottom:3px double black;"><?php echo number_format((float)$total, 2, '.', ','); ?></td>
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
						<table width="100%">
							<tr>
								<td style="width:40%;font-weight:bold;">PREPARED & CHECKED BY:</td>
								<td style="width:10%;font-weight:bold;"></td>
								<td style="width:40%;font-weight:bold;">RECEIVED & APPROVED BY:</td>
								<td style="width:10%;font-weight:bold;"></td>
							</tr>
							<tr>
								<td><br><br></td>
							</tr>
							<tr>
								<td style="font-weight:bold;text-align:center;font-weight:bold;"><?php echo strtoupper($prepared_by.'/ '.$checked_by); ?></td>
								<td style="font-weight:bold;"></td>
								<td style="font-weight:bold;text-align:center;"><?php echo strtoupper($received_by.'/ '.$approved_by); ?></td>
								<td style="font-weight:bold;"></td>
							</tr>
							<tr>
								<td style="border-top:1px solid black;text-align:center;">GSMPC-ACCOUNTING STAFF</td>
								<td style=""></td>
								<td style="border-top:1px solid black;text-align:center;">DMPI PLANTATION ACCOUNTING SUPERVISOR</td>
								<td style=""></td>
							</tr>
							<tr>
								<td><br><br><br><br></td>
							</tr>
							<tr>
								<td style="width:40%;font-weight:bold;">APPROVED BY:</td>
								<td style="width:10%;font-weight:bold;"></td>
								<td style="width:40%;font-weight:bold;"></td>
								<td style="width:10%;font-weight:bold;"></td>
							</tr>
							<tr>
								<td><br><br></td>
							</tr>
							<tr>
								<td style="font-weight:bold;text-align:center;font-weight:bold;"><?php echo strtoupper($approved_by2); ?></td>
								<td style="font-weight:bold;"></td>
								<td style="font-weight:bold;text-align:center;"></td>
								<td style="font-weight:bold;"></td>
							</tr>
							<tr>
								<td style="border-top:1px solid black;text-align:center;">GSMPC-GENERAL MANAGER</td>
								<td style=""></td>
								<td style=""></td>
								<td style=""></td>
							</tr>
						</table>
					</td>
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