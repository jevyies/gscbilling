<?php 
    header('Content-type: application/excel');
    $filename = 'shabu-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records){
		foreach($records as $record){
			$admin_percentage = $record->admin_percentage;
			$date = $record->Date;
			$Payment_for = $record->Payment_for;
			$letter_to = $record->letter_to;
			$period_covered = $record->period_date;
			$SOANo = $record->SOANo;
			$Prepared_by = $record->Prepared_by;
			$Checked_by = $record->Checked_by;
			$Noted_by = $record->Noted_by;
			$Approved_by = $record->Approved_by;
			$Approved_by_2 = $record->Approved_by_2;
			$Approved_by_3 = $record->Approved_by_3;
			$Prepared_by_desig = $record->Prepared_by_desig;
			$Checked_by_desig = $record->Checked_by_desig;
			$Noted_by_desig = $record->Noted_by_desig;
			$Approved_by_desig = $record->Approved_by_desig;
			$Approved_by_2_desig = $record->Approved_by_2_desig;
			$Approved_by_3_desig = $record->Approved_by_3_desig;
			$last_activity = $record->Activity;
			$last_gl = $record->gl;
			$last_cc = $record->cc;
			$last_rate_hr = $record->rate_hr;
			break;
		}
	}
	$last_day = "";
	$last_day_join = "";
	$last_date = "";
	$last_year = "";
	$sub_total = 0;
	$sub_total_hrs = 0;
	$total = 0;
	$total_hrs = 0;
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
				margin-left: 2cm;
				margin-right: 2cm;
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
			<table width="100%" style="margin-bottom:10%;">
				<tr>
					<td style="border:none;padding:0px;text-align:right;width:25%;padding-bottom:10px;" rowspan="5">
						<img style="width:100px;height:80px;" src="<?php echo base_url(); ?>assets/images/logo.png">
					</td>
					<td style="border:none;width:50%;text-align:center;font-size:130%;"><strong>GENERAL SERVICES COOPERATIVE</strong></td>
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
					<td style="border:none;text-align:center;">FOR THE YEAR <?php echo date('Y', strtotime($date)); ?></td>
					<td style="border:none;"></td>
				</tr>
				<tr>
					<td style="border:none;text-align:center;font-size:125%;">STATEMENT OF ACCOUNT</td>
					<td style="border:none;"></td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td style="width:45%;">Payment for <u><b><?php echo $Payment_for; ?></b></u></td>
					<td style="width:20%;"></td>
					<td style="width:35%;">Date: <?php echo date('F j, Y', strtotime($date)); ?></td>
				</tr>
				<tr>
					<td>Period Covered: <?php echo $period_covered; ?></td>
					<td></td>
					<td>Control #: <?php echo $SOANo; ?></td>
				</tr>
			</table>
			<br>
			<br>
			<table width="100%">
				<thead>
					<tr>
						<th rowspan="2">ACTIVITY/ OPERATION</th>
						<th rowspan="2">DATE PERFORMED</th>
						<th colspan="2">ACCOUNT TO CHARGE</th>
						<th colspan="2">ACCOMPLISHMENT</th>
						<th rowspan="2">AMOUNT BILLED</th>
					</tr>
					<tr>
						<th>GL Account</th>
						<th>Cost Center</th>
						<th>Hr/s.</th>
						<th>Rate/hr.</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
					<?php if($last_activity != $record->Activity or $last_gl != $record->gl or $last_cc != $record->cc): ?>
					<tr>
						<td style="border:1px solid black;"><?php echo $last_activity; ?></td>
						<td style="border:1px solid black;"><?php echo strtoupper($last_date) . ' ' . $last_day_join . ' ' . $last_year; ?></td>
						<td style="border:1px solid black;"><?php echo $last_gl; ?></td>
						<td style="border:1px solid black;"><?php echo $last_cc; ?></td>
						<td style="text-align:center;border:1px solid black;"><?php echo $sub_total_hrs; ?></td>
						<td style="text-align:right;border:1px solid black;"><?php echo number_format((float)$last_rate_hr, 2, '.', ','); ?></td>
						<td style="text-align:right;border:1px solid black;"><?php echo number_format((float)$sub_total, 2, '.', ','); ?></td>
					</tr>
					<?php
						$last_activity = $record->Activity;
						$last_gl = $record->gl;
						$last_cc = $record->cc;
						$last_rate_hr = $record->rate_hr;
						$sub_total = 0;
						$sub_total_hrs = 0;
						$last_day = "";
						$last_date = "";
						$last_year = "";
					?>
					<?php endif; ?>
					<?php
						// sumpay date e.g JAN 1,2,3 2021
						if($last_date == ""){
							$last_day = date('j', strtotime($record->date));
							$last_day_join = date('j', strtotime($record->date)) . ',';
							$last_date = date('M', strtotime($record->date));
							$last_year = date('Y' , strtotime($record->date));
						}else{
							if($last_day != date('j', strtotime($record->date))){
								$last_day_join = $last_day_join . date('j', strtotime($record->date)) . ',';
							}
						}
					?>
					<?php $sub_total = $sub_total + $record->amount_billed; ?>
					<?php $sub_total_hrs = $sub_total_hrs + $record->hrs; ?>
					<?php $total = $total + $record->amount_billed; ?>
					<?php $total_hrs = $total_hrs + $record->hrs; ?>
					<?php endforeach; ?>
					<tr>
						<td style="border:1px solid black;"><?php echo $last_activity; ?></td>
						<td style="border:1px solid black;"><?php echo strtoupper($last_date) . ' ' . $last_day_join . ' ' . $last_year; ?></td>
						<td style="border:1px solid black;"><?php echo $last_gl; ?></td>
						<td style="border:1px solid black;"><?php echo $last_cc; ?></td>
						<td style="text-align:center;border:1px solid black;"><?php echo $sub_total_hrs; ?></td>
						<td style="text-align:right;border:1px solid black;"><?php echo number_format((float)$last_rate_hr, 2, '.', ','); ?></td>
						<td style="text-align:right;border:1px solid black;"><?php echo number_format((float)$sub_total, 2, '.', ','); ?></td>
					</tr>
					<tr>
						<td style=""></td>
						<td style=""></td>
						<td style=""></td>
						<td style=""></td>
						<td style="text-align:center;border:1px solid black;font-weight:bold;"><?php echo $total_hrs; ?></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;border:1px solid black;font-weight:bold;"><?php echo number_format((float)$total, 2, '.', ','); ?></td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="5" style="text-align:right;font-weight:bold;">TOTAL BILLING</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;border:1px solid black;font-weight:bold;"><?php echo number_format((float)$total, 2, '.', ','); ?></td>
					</tr>
					<tr>
						<td colspan="5" style="text-align:right;font-weight:bold;"><?php echo $admin_percentage; ?>% Admin Fee</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;font-weight:bold;"><?php echo number_format((float)$total * ($admin_percentage/100), 2, '.', ','); ?></td>
					</tr>
					<tr>
						<td colspan="5" style="text-align:right;font-weight:bold;">TOTAL GROSS BILLING</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;border:1px solid black;font-weight:bold;"><?php echo number_format((float)$total + ($total * ($admin_percentage/100)), 2, '.', ','); ?></td>
					</tr>
				</tbody>
			</table>
			<br>
			<br>
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
					<td style="width:50%;">PREPARED & CHECKED BY:</td>
					<td style="width:15%;"></td>
					<td style="width:35%;">CONFIRMED BY:</td>
				</tr>
				<tr>
					<td style=""><br><u><b><?php echo strtoupper($Prepared_by) . '/ <br>' . strtoupper($Checked_by); ?></b></u><br><?php echo strtoupper($Prepared_by_desig) . '/ <br>' . strtoupper($Checked_by_desig); ?></td>
					<td></td>
					<td style=""><br><u><b><?php echo strtoupper($Approved_by_2); ?></b></u><br><?php echo strtoupper($Approved_by_2_desig); ?></td>
				</tr>
				<tr>
					<td style=""><br><br><br>NOTED BY:</td>
					<td></td>
					<td style=""><br><br><br></td>
				</tr>
				<tr>
					<td style=""><br><u><b><?php echo strtoupper($Noted_by); ?></b></u><br><?php echo strtoupper($Noted_by_desig); ?></td>
					<td></td>
					<td style=""><br><u><b></td>
				</tr>
				<tr>
					<td style=""><br><br><br>APPROVED BY:</td>
					<td></td>
					<td style=""><br><br><br>APPROVED FOR PAYMENT BY:</td>
				</tr>
				<tr>
					<td style=""><br><u><b><?php echo strtoupper($Approved_by); ?></b></u><br><?php echo strtoupper($Approved_by_desig); ?></td>
					<td></td>
					<td style=""><br><u><b><?php echo strtoupper($Approved_by_3); ?></b></u><br><?php echo strtoupper($Approved_by_3_desig); ?></td>
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