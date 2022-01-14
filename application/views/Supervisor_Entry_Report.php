<?php 
    header('Content-type: application/excel');
    $filename = $soaNumber . '-' . date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records){
		$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		foreach($records as $record){
			$SOANumber = $record->soaNumber;
			$month_num = substr($record->pmy,4);
			$a_date = substr($record->pmy,0,4) . "-" . substr($record->pmy,4) . "-1";
			$period = $record->period == 1 ? "1-15" : "16-" . date("t", strtotime($a_date));
			$period_covered = $months[(int)$month_num - 1] . " " . $period . " " . substr($record->pmy,0,4);
			$Prepared_by = $record->preparedBy;
			$Prepared_by_desig = $record->preparedByPosition;
			$Confirmed_by = $record->confirmedBy;
			$Confirmed_by_desig = $record->confirmedByPosition;
			$Approved_by = $record->approvedBy;
			$Approved_by_desig = $record->approvedByPosition;
			break;
		}
	}
	$total = 0;
	$total_hc = 0;
	$total_leave = 0;
	$total_nd = 0;
	$total_rdnd = 0;
	$total_st = 0;
	$total_rdst = 0;
	$leave_hrs = 0;
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
	
			@page { sheet-size: Folio-L; }
			
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
				background-color:grey;
			}
	
		</style>
		<body>
			<?php if($records): //var_dump($records);?>
			<table width="100%">
				<tr>
					<td style="border:none;padding:0px;text-align:right;width:25%;border-bottom:3px solid black;padding-bottom:10px;" rowspan="3">
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
					<td style="border:none;text-align:center;border-bottom:3px solid black;padding-bottom:10px;">TIN # : 411-478-949</td>
					<td style="border:none;border-bottom:3px solid black;padding-bottom:10px;"></td>
				</tr>
			</table>
			<h4 style="text-align:center;">STATEMENT OF ACCOUNT</h4>
			<br>
			<br>
			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="width:10%;"></td>
					<td style="width:40%;"></td>
					<td style="width:10%;"><b>SOA #</b></td>
					<td style="width:40%;"><?php echo $SOANumber; ?></td>
				</tr>
				<tr>
					<td style="width:10%;"><b>Period Covered :</b></td>
					<td style="width:40%;"><u><?php echo $period_covered; ?></u></td>
					<td style="width:10%;"></td>
					<td style="width:40%;"></td>
				</tr>
				<tr>
					<td style="width:10%;"><b>Location :</b></td>
					<td style="width:40%;"><u><?php echo "NFC JUICING PLANT(SUPERVISOR)"; ?></u></td>
					<td style="width:10%;"></td>
					<td style="width:40%;"></td>
				</tr>
			</table>
			<br>
			<br>
			<br>
			<table width="100%">
				<thead>
					<tr>
						<th>ACTIVITY</th>
						<th>NAME</th>
						<th>GL ACCOUNT</th>
						<th>CC</th>
						<th>HC</th>
						<th>ACTUAL HR/s. Worked</th>
						<th>LEAVE W/OUT PAY (HRS)</th>
						<th>ND</th>
						<th>FIXED QUIN. RATE</th>
						<th>ADD: ND AMOUNT</th>
						<th>LESS: LEAVE W/OUT PAY</th>
						<th>TOTAL BILLING AMOUNT</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
					<tr>
						<td style="text-align:center;border:1px solid black;"><?php echo $record->activity; ?></td>
						<td style="text-align:center;border:1px solid black;"><?php echo $record->Name; ?></td>
						<td style="text-align:center;border:1px solid black;"><?php echo $record->gl; ?></td>
						<td style="text-align:center;border:1px solid black;"><?php echo $record->cc; ?></td>
						<td style="text-align:center;border:1px solid black;"><?php echo $record->headCount; ?></td>
						<td style="text-align:center;border:1px solid black;"><?php echo $record->rdst; ?></td>
						<td style="text-align:center;border:1px solid black;"><?php echo $record->leaveNoPayHrs; ?></td>
						<td style="text-align:right;border:1px solid black;"><?php echo $record->rdnd; ?></td>
						<td style="text-align:right;border:1px solid black;"><?php echo $record->c_totalst; ?></td>
						<td style="text-align:right;border:1px solid black;"><?php echo $record->c_totalnd; ?></td>
						<td style="text-align:right;border:1px solid black;"><?php echo $record->TotalLeave; ?></td>
						<td style="text-align:right;border:1px solid black;"><?php echo number_format($record->c_totalAmt, 2, '.', ','); ?></td>
					</tr>
					<?php $total_hc = $total_hc + $record->headCount; ?>
					<?php $total_rdst = $total_rdst + $record->rdst; ?>
					<?php $leave_hrs = $leave_hrs + $record->leaveNoPayHrs; ?>
					<?php $total_rdnd = $total_rdnd + $record->rdnd; ?>
					<?php $total_st = $total_st + $record->c_totalst; ?>
					<?php $total_nd = $total_nd + $record->c_totalnd; ?>
					<?php $total_leave = $total_leave + $record->TotalLeave; ?>
					<?php $total = $total + $record->c_totalAmt; ?>
					<?php endforeach; ?>
					<tr>
						<td style="text-align:center;"></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;border-bottom:2px double black;"><?php echo number_format($total_hc, 2, '.', ','); ?></td>
						<td style="text-align:center;border-bottom:2px double black;"><?php echo number_format($total_rdst, 2, '.', ','); ?></td>
						<td style="text-align:center;border-bottom:2px double black;"><?php echo number_format($leave_hrs, 2, '.', ','); ?></td>
						<td style="text-align:right;border-bottom:2px double black;"><?php echo number_format($total_rdnd, 2, '.', ','); ?></td>
						<td style="text-align:right;border-bottom:2px double black;"><?php echo number_format($total_st, 2, '.', ','); ?></td>
						<td style="text-align:right;border-bottom:2px double black;"><?php echo number_format($total_nd, 2, '.', ','); ?></td>
						<td style="text-align:right;border-bottom:2px double black;"><?php echo number_format($total_leave, 2, '.', ','); ?></td>
						<td style="text-align:right;border-bottom:2px double black;"><?php echo number_format($total, 2, '.', ','); ?></td>
					</tr>
				</tbody>
			</table>
			<br>
			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="width:30%;">Prepared By:</td>
					<td></td>
					<td style="width:30%;">Confirmed By:</td>
					<td></td>
					<td style="width:30%;">Approved By:</td>
				</tr>
				<tr>
					<td style="width:30%;"><br><?php echo strtoupper($Prepared_by); ?></td>
					<td></td>
					<td style="width:30%;"><br><?php echo strtoupper($Confirmed_by); ?></td>
					<td></td>
					<td style="width:30%;"><br><?php echo strtoupper($Approved_by); ?></td>
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