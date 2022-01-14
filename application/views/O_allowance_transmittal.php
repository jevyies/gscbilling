<?php 
    header('Content-type: application/excel');
    $filename = 'TransmittalReport-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records != 'fail'){
		foreach($records as $record){
			$transmittal_no = $record->transmittal_no;
			$prepared_by = $record->prepared_by;
			$prepared_by_desig = $record->prepared_by_desig;
			$checked_by = $record->checked_by;
			$checked_by_desig = $record->checked_by_desig;
			$received_by = $record->received_by;
			$received_by_desig = $record->received_by_desig;
			$approved_by = $record->approved_by;
			$approved_by_desig = $record->approved_by_desig;
			$date_transmitted = $record->date_transmitted;
			break;
		}
	}
	$total = 0;
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
					<td style="width:20%;">
						<!-- <img src="http://192.168.1.250/epis/static/img/gsclogo.png" alt="GSC Logo" style="width:8%;"> -->
					</td>
					<td style="width:80%;text-align:center;padding-left:-20%;">
						<h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
						<h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
						<h3 style="text-align:center;text-decoration:underline;">TRANSMITTAL FORM <?php echo $type; ?></h3>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;"><br><br>Transmittal No: <b><?php echo $transmittal_no; ?></b><br>Date Transmitted to Accounting: <b><?php echo date('F j, Y', strtotime($date_transmitted)); ?></b></td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="background:lightgreen;">
						<th style="width:10%;padding:20px 0;">SOA #</th>
						<th style="width:10%;padding:20px 0;">Billed Date</th>
						<th style="width:10%;padding:20px 0;">Invoice #</th>
						<th style="width:10%;padding:20px 0;">Invoice Date</th>
						<th style="width:10%;padding:20px 0;">BILLED TO</th>
						<th style="width:10%;padding:20px 0;">BILLED AMOUNT</th>
						<th style="width:15%;padding:20px 0;">STATUS</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
					<tr>
						<td style="text-align:center;"><?php echo $record->SOANo; ?></td>
						<td style="text-align:center;"><?php echo date("F j, Y", strtotime($record->date_created)); ?></td>
						<td style="text-align:center;"><?php echo $record->invoice_number; ?></td>
						<td style="text-align:center;"><?php echo $record->invoice_date; ?></td>
						<td style="text-align:left;">Del Monte Philippines, Inc.</td>
						<td style="text-align:right;"><?php echo number_format((float)$record->billed_amount, 2, '.', ','); ?></td>
						<td style="text-align:right;"></td>
					</tr>
					<?php $total = $total + $record->billed_amount; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="5" style="text-align:right;color:red;border:none;font-weight:bold;">TOTAL AMOUNT</td>
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
						<table width="100%">
							<tr>
								<td style="width:20%;font-weight:bold;">Prepared/Checked By:</td>
								<td style="width:5%;font-weight:bold;"></td>
								<td style="width:20%;font-weight:bold;">Received By:</td>
								<td style="width:5%;font-weight:bold;"></td>
								<td style="width:20%;font-weight:bold;">Approved By:</td>
								<td style="width:5%;font-weight:bold;"></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td style="font-weight:bold;text-align:center;"><?php echo strtoupper($prepared_by.'/ '.$checked_by); ?></td>
								<td style="font-weight:bold;"></td>
								<td style="font-weight:bold;text-align:center;"><?php echo strtoupper($received_by); ?></td>
								<td style="font-weight:bold;"></td>
								<td style="font-weight:bold;text-align:center;"><?php echo strtoupper($approved_by); ?></td>
								<td style="font-weight:bold;"></td>
							</tr>
							<tr>
								<td style="border-top:1px solid black;text-align:center;"><?php echo strtoupper($prepared_by_desig.'/ '.$checked_by_desig); ?></td>
								<td style=""></td>
								<td style="border-top:1px solid black;text-align:center;"><?php echo strtoupper($received_by_desig); ?></td>
								<td style=""></td>
								<td style="border-top:1px solid black;text-align:center;"><?php echo strtoupper($approved_by_desig); ?></td>
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