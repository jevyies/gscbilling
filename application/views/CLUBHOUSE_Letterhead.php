<?php 
    header('Content-type: application/excel');
    $filename = 'SLERSLetterhead-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records){
		foreach($records as $record){
			$date = $record->date_created;
			$transmittal_no = $record->transmittal_no;
			$period_covered = $record->period_date;
			$date_transmitted = date('F j, Y', strtotime($record->date_updated));
			$letter_to = $record->letter_to;
			$SOANo = $record->SOANo;
			$Total_Billing = $record->Total_Billing;
			$MHRS = $record->MHRS;
			$HC = $record->HC;
			$admin_percentage = $record->admin_percentage;
			$body = $record->body;
			$body2 = $record->body2;
			$Prepared_by = $record->Prepared_by;
			$Noted_by = $record->Noted_by;
			$Checked_by = $record->Checked_by;
			$Approved_by = $record->Approved_by;
			$Confirmed_by = $record->Confirmed_by;
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
	
			@page { sheet-size: Letter; }
			
			@page {
				margin-top: 1cm;
				margin-bottom: 1cm;
				margin-left: 1.5cm;
				margin-right: 1.5cm;
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
			<?php if($records): ?>
			<table width="100%" style="margin-bottom:5%;">
				<tr>
					<td style="border:none;padding:0px;text-align:right;width:25%;border-bottom:3px solid black;padding-bottom:10px;" rowspan="4">
						<img style="width:100px;height:80px;" src="<?php echo base_url(); ?>assets/images/logo.png">
					</td>
					<td style="border:none;width:70%;text-align:center;font-size:130%;"><strong>GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong></td>
					<td style="border:none;"></td>
				</tr>
				<tr>
					<td style="border:none;text-align:center;font-size:110%;">Borja Road, Damilag, Manolo Fortich, Bukidnon</td>
					<td style="border:none;"></td>
				</tr>
				<tr>
					<td style="border:none;text-align:center;">TIN # : 411-478-949</td>
					<td style="border:none;"></td>
				</tr>
				<tr>
					<td style="border:none;text-align:center;border-bottom:3px solid black;padding-bottom:10px;"><h3>BILLING TRANSMITTAL</h3></td>
					<td style="border:none;border-bottom:3px solid black;padding-bottom:10px;"></td>
				</tr>
			</table>
			<h5>PERIOD COVERED: <?php echo strtoupper($period_covered); ?></h5>
			<h5>DATE TRANSMITTED: <?php echo strtoupper($date_transmitted); ?></h5>
			<h5>TRANSMITTAL #: <?php echo strtoupper($transmittal_no); ?></h5>
			<h5>TO: <?php echo strtoupper($letter_to); ?></h5>
			<br>
			<br>
			<br>
			<table width="100%" border="1">
				<tr>
					<th style="width:5%;">No.</th>
					<th style="width:25%;">Doc. Date</th>
					<th style="width:15%;">SOA No.</th>
					<th style="width:20%;">Department</th>
					<th style="width:10%;">MHRS</th>
					<th style="width:10%;">HC</th>
					<th style="width:15%;">Amount</th>
				</tr>
				<tr>
					<td>1.</td>
					<td><?php echo $period_covered; ?></td>
					<td><?php echo $SOANo; ?></td>
					<td style="text-align:center;"><?php echo $letter_to; ?></td>
					<td style="text-align:center;"><?php echo $MHRS; ?></td>
					<td style="text-align:center;"><?php echo $HC; ?></td>
					<td style="text-align:right;"><?php echo number_format($Total_Billing, 2, '.', ','); ?></td>
				</tr>
				<?php if($admin_percentage != 0): ?>
				<tr>
					<td colspan="4" style="text-align:right;"><?php echo $admin_percentage ?>% ADMIN FEE:</td>
					<td colspan="3" style="text-align:right;"><?php echo number_format($Total_Billing * ($admin_percentage/100), 2, '.', ','); ?></td>
				</tr>
				<?php endif; ?>
				<tr>
					<td colspan="4" style="text-align:right;"><b>TOTAL BILLING</b></td>
					<td style="text-align:center;"><?php echo $MHRS; ?></td>
					<td style="text-align:center;"><?php echo $HC; ?></td>
					<td style="text-align:right;"><b><?php echo number_format($Total_Billing + ($Total_Billing * ($admin_percentage/100)), 2, '.', ','); ?></b></td>
				</tr>
			</table>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="width:40%;">PREPARED BY & CHECKED BY:</td>
					<td></td>
					<td style="width:40%;">NOTED BY:</td>
				</tr>
				<tr>
					<td style="width:40%;"><br><br><b><u><?php echo strtoupper($Prepared_by).'/'.strtoupper($Checked_by); ?></u></b><br>GSMPC-ACCOUNTING CLERK</td>
					<td></td>
					<td style="width:40%;"><br><br><b><u><?php echo strtoupper($Noted_by); ?></u></b><br>GSMPC-GENERAL MANAGER</td>
				</tr>
				<tr>
					<td style="width:40%;"><br><br><br>CONFIRMED BY:</td>
					<td></td>
					<td style="width:40%;"><br><br><br>APPROVED BY:</td>
				</tr>
				<tr>
					<td style="width:40%;"><br><br><b><u><?php echo strtoupper($Confirmed_by); ?></u></b><br>SUPERVISOR CLUBHOUSE</td>
					<td></td>
					<td style="width:40%;"><br><br><b><u><?php echo strtoupper($Approved_by); ?></u></b><br>MANAGER, CLUBHOUSE</td>
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