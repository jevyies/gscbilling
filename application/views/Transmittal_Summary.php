<?php 
header('Content-type: application/excel');
$filename = 'GSC Transmittal Billing -'. date('mdY') .'.xls';
header('Content-Disposition: attachment; filename='.$filename);

$transmittalDate = '';
$var = count($records);
foreach($records as $record){
	$transmittalDate = $record->DMPIReceivedDate;
	$pmy = $record->pmy;
	$period = $record->period;
	$prepared_by = $record->adminencodedby."/".$record->ConfirmationBy;
	break;
}
foreach($infos as $info){
	$received_by = $info->confirmedBy ? $info->confirmedBy : '';
	$received_by_pos = $info->confirmedByPosition ? $info->confirmedByPosition : '';
	$approved_by = $info->approvedBy ? $info->approvedBy : '';
	$approved_by_pos = $info->approvedByPosition ? $info->approvedByPosition : '';
	$approved_by2 = $info->approvedBy2 ? $info->approvedBy2 : '';
	$approved_by_pos2 = $info->approvedByPosition2 ? $info->approvedByPosition2 : '';
	$date_finalize = $info->date_finalize;
	$date_created = $info->date_created;
	break;
}
$year = substr($pmy, 0, 4);
$month = substr($pmy, 4, 6);
$soaDate = $latest_date;
$last_day = date("t", strtotime($soaDate));
$day = date("d", strtotime($soaDate));
$month_in_word = date("F", strtotime($soaDate));
if($day <= 15){
	$period_covered = $month_in_word . " 1-15, " . $year;
}else{
	$period_covered = $month_in_word . " 16-".$last_day.", " . $year;
}
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
            th{
                border: 1px solid black;
            }
			td {
				font-size: 90%;
				padding:5px;
				border: 1px solid black;
			}
	
			@page { sheet-size: Letter; }
			
			@page {
				margin-top: 1cm;
				margin-bottom: 1.5cm;
				margin-left: 1cm;
				margin-right: 1cm;
				odd-footer-name: html_myFooter;
			}
			
			h1.bigsection {
					page-break-before: always;
					page: bigger;
			}

			.main_t td{
				border:1px solid black;
			}

			th {
				font-size: 90%;
				text-align:center;
			}
			table.no-borders th{
				border: none;
			}
			table.no-borders td{
				border: none;
			}
		</style>
		<body>
			<?php if($copy == 1 || $copy == 2): ?>
			<div>
				<div style="margin:80px 0 20px 80px;">
					<h4 style="margin:0;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h4>
					<h4 style="margin-top:6px;margin-bottom:0;">Borja Road, Damilag, M.F. Bukidnon
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						GSMPC COPY
					</h4>
					<h4 style="margin:7px 0 0;">TIN # 411-478-949-000</h4>
					<p style="margin:7px 0 0;">Period Covered:<?php echo $period_covered; ?></p>
					<h4 style="margin:7px 0 0;">TRANSMITTAL #: <?php echo $transmittalNumber; ?></h4>
					<h4 style="margin:7px 0 0;">TRANSMITTAL DATE: <?php echo date("F j, Y", strtotime($transmittalDate)); ?></h4>
					<p style="margin:7px 0 0;">TO: DMPI ACCOUNTING</p>
				</div>
				<table style="margin-bottom:10px;">
					<thead>
						<tr>
							<th style="width:30px;">ITEM#</th>
							<th style="width:70px;">DOCUMENT DATE</th>
							<th style="width:180px;">DEPARTMENT</th>
							<th style="width:130px;">GSMPC SOA NO.</th>
							<th style="text-align:center;width:50px;">ST</th>
							<th style="text-align:center;width:50px;">OT</th>
							<th style="text-align:center;width:50px;">ND</th>
							<th style="text-align:center;width:50px;">NDOT</th>
							<th style="text-align:center;width:50px;">HC</th>
							<th style="text-align:center;width:110px;">TOTAL</th>
						</tr>
					</thead>
					<tbody>
						<?php $No = 0; ?>
						<?php $totalST = 0; ?>
						<?php $totalOT = 0; ?>
						<?php $totalND = 0; ?>
						<?php $totalNDOT = 0; ?>
						<?php $totalHC = 0; ?>
						<?php $totalAmount = 0; ?>
						<?php foreach($records as $record): ?>
							<tr>
								<td><?php echo($No = $No + 1); ?></td>
								<td><?php echo date("m-d-Y", strtotime($record->soaDate)); ?></td>
								<td><?php echo $record->Location; ?></td>
								<td><?php echo $record->soaNumber; ?></td>
								<td style="text-align:right;"><?php echo $record->gt_st > 0? number_format($record->gt_st, 2, '.', ',') : '-'; ?></td>
								<td style="text-align:right;"><?php echo $record->gt_ot > 0? number_format($record->gt_ot, 2, '.', ',') : '-'; ?></td>
								<td style="text-align:right;"><?php echo $record->gt_nd > 0? number_format($record->gt_nd, 2, '.', ',') : '-'; ?></td>
								<td style="text-align:right;"><?php echo $record->gt_ndot > 0? number_format($record->gt_ndot, 2, '.', ',') : '-'; ?></td>
								<td style="text-align:right;"><?php echo $record->HC > 0? number_format($record->HC, 2, '.', ',') : '-'; ?></td>
								<td style="text-align:right;"><?php echo $record->TotalAmt > 0? number_format($record->TotalAmt, 2, '.', ',') : '-'; ?></td>
								<?php $totalST = $totalST + $record->gt_st; ?>
								<?php $totalOT = $totalOT + $record->gt_ot; ?>
								<?php $totalND = $totalND + $record->gt_nd; ?>
								<?php $totalNDOT = $totalNDOT + $record->gt_ndot; ?>
								<?php $totalHC = $totalHC + $record->HC; ?>
								<?php $totalAmount = $totalAmount + $record->TotalAmt; ?>
							</tr>
							<!-- <?php //if($No % 35 == 0): ?>
								<pagebreak/>
							<?php //endif; ?> -->
						<?php endforeach; ?>
						<tr>
							<td style="border:none;" colspan="3"></td>
							<td style="border:none;"><strong>TOTAL</strong></td>
							<td style="text-align:right;"><?php echo number_format($totalST, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format($totalOT, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format($totalND, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format($totalNDOT, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format($totalHC, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format($totalAmount, 2, '.', ','); ?></td>
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
							<td colspan="4" style="font-size:13px;"><strong>PREPARED & CHECKED BY:</strong></td>
							<td colspan="4" style="font-size:13px;"><strong>RECEIVED BY:</strong></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($prepared_by); ?></strong></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($received_by); ?></strong></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo "GSMPC-ACCOUNTING STAFF"; ?></span></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $received_by_pos; ?></span></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
							<?php if($approved_by2): ?>
								<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($approved_by); ?></strong></td>
							<?php if($approved_by2): ?>
								<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($approved_by2); ?></strong></td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $approved_by_pos; ?> </td>
							<?php if($approved_by2): ?>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $approved_by_pos2; ?> </td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
					</table>
			</div>
			<?php endif; ?>
			<?php if($copy == 2): ?>
				<pagebreak />
				<div>
					<div style="margin:80px 0 20px 80px;">
						<h4 style="margin:0;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h4>
						<h4 style="margin-top:6px;margin-bottom:0;">Borja Road, Damilag, M.F. Bukidnon
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							DMPI 1 COPY
						</h4>
						<h4 style="margin:7px 0 0;">TIN # 411-478-949-000</h4>
						<p style="margin:7px 0 0;">Period Covered:<?php echo $period_covered; ?></p>
						<h4 style="margin:7px 0 0;">TRANSMITTAL #: <?php echo $transmittalNumber; ?></h4>
						<h4 style="margin:7px 0 0;">TRANSMITTAL DATE: <?php echo date("F j, Y", strtotime($transmittalDate)); ?></h4>
						<p style="margin:7px 0 0;">TO: DMPI ACCOUNTING</p>
					</div>
					<table style="margin-bottom:10px;">
						<thead>
							<tr>
								<th style="width:30px;">ITEM#</th>
								<th style="width:70px;">DOCUMENT DATE</th>
								<th style="width:180px;">DEPARTMENT</th>
								<th style="width:130px;">GSMPC SOA NO.</th>
								<th style="text-align:center;width:50px;">ST</th>
								<th style="text-align:center;width:50px;">OT</th>
								<th style="text-align:center;width:50px;">ND</th>
								<th style="text-align:center;width:50px;">NDOT</th>
								<th style="text-align:center;width:50px;">HC</th>
								<th style="text-align:center;width:110px;">TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php $No = 0; ?>
							<?php $totalST = 0; ?>
							<?php $totalOT = 0; ?>
							<?php $totalND = 0; ?>
							<?php $totalNDOT = 0; ?>
							<?php $totalHC = 0; ?>
							<?php $totalAmount = 0; ?>
							<?php foreach($records as $record): ?>
								<tr>
									<td><?php echo($No = $No + 1); ?></td>
									<td><?php echo date("m-d-Y", strtotime($record->soaDate)); ?></td>
									<td><?php echo $record->Location; ?></td>
									<td><?php echo $record->soaNumber; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_st > 0? number_format($record->gt_st, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_ot > 0? number_format($record->gt_ot, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_nd > 0? number_format($record->gt_nd, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_ndot > 0? number_format($record->gt_ndot, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->HC > 0? number_format($record->HC, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->TotalAmt > 0? number_format($record->TotalAmt, 2, '.', ',') : '-'; ?></td>
									<?php $totalST = $totalST + $record->gt_st; ?>
									<?php $totalOT = $totalOT + $record->gt_ot; ?>
									<?php $totalND = $totalND + $record->gt_nd; ?>
									<?php $totalNDOT = $totalNDOT + $record->gt_ndot; ?>
									<?php $totalHC = $totalHC + $record->HC; ?>
									<?php $totalAmount = $totalAmount + $record->TotalAmt; ?>
								</tr>
								<?php //if($No % 35 == 0): ?>
									<!-- <pagebreak/> -->
								<?php //endif; ?>
							<?php endforeach; ?>
							<tr>
								<td style="border:none;" colspan="3"></td>
								<td style="border:none;"><strong>TOTAL</strong></td>
								<td style="text-align:right;"><?php echo number_format($totalST, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalOT, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalND, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalNDOT, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalHC, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalAmount, 2, '.', ','); ?></td>
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
							<td colspan="4" style="font-size:13px;"><strong>PREPARED & CHECKED BY:</strong></td>
							<td colspan="4" style="font-size:13px;"><strong>RECEIVED BY:</strong></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($prepared_by); ?></strong></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($received_by); ?></strong></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo "GSMPC-ACCOUNTING STAFF"; ?></span></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $received_by_pos; ?></span></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
							<?php if($approved_by2): ?>
								<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($approved_by); ?></strong></td>
							<?php if($approved_by2): ?>
								<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($approved_by2); ?></strong></td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $approved_by_pos; ?> </td>
							<?php if($approved_by2): ?>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $approved_by_pos2; ?> </td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
					</table>
				</div>
				<pagebreak />
				<div>
					<div style="margin:80px 0 20px 80px;">
						<h4 style="margin:0;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h4>
						<h4 style="margin-top:6px;margin-bottom:0;">Borja Road, Damilag, M.F. Bukidnon
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							DMPI 2 COPY
						</h4>
						<h4 style="margin:7px 0 0;">TIN # 411-478-949-000</h4>
						<p style="margin:7px 0 0;">Period Covered:<?php echo $period_covered; ?></p>
						<h4 style="margin:7px 0 0;">TRANSMITTAL #: <?php echo $transmittalNumber; ?></h4>
						<h4 style="margin:7px 0 0;">TRANSMITTAL DATE: <?php echo date("F j, Y", strtotime($transmittalDate)); ?></h4>
						<p style="margin:7px 0 0;">TO: DMPI ACCOUNTING</p>
					</div>
					<table style="margin-bottom:10px;">
						<thead>
							<tr>
								<th style="width:30px;">ITEM#</th>
								<th style="width:70px;">DOCUMENT DATE</th>
								<th style="width:180px;">DEPARTMENT</th>
								<th style="width:130px;">GSMPC SOA NO.</th>
								<th style="text-align:center;width:50px;">ST</th>
								<th style="text-align:center;width:50px;">OT</th>
								<th style="text-align:center;width:50px;">ND</th>
								<th style="text-align:center;width:50px;">NDOT</th>
								<th style="text-align:center;width:50px;">HC</th>
								<th style="text-align:center;width:110px;">TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php $No = 0; ?>
							<?php $totalST = 0; ?>
							<?php $totalOT = 0; ?>
							<?php $totalND = 0; ?>
							<?php $totalNDOT = 0; ?>
							<?php $totalHC = 0; ?>
							<?php $totalAmount = 0; ?>
							<?php foreach($records as $record): ?>
								<tr>
									<td><?php echo($No = $No + 1); ?></td>
									<td><?php echo date("m-d-Y", strtotime($record->soaDate)); ?></td>
									<td><?php echo $record->Location; ?></td>
									<td><?php echo $record->soaNumber; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_st > 0? number_format($record->gt_st, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_ot > 0? number_format($record->gt_ot, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_nd > 0? number_format($record->gt_nd, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_ndot > 0? number_format($record->gt_ndot, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->HC > 0? number_format($record->HC, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->TotalAmt > 0? number_format($record->TotalAmt, 2, '.', ',') : '-'; ?></td>
									<?php $totalST = $totalST + $record->gt_st; ?>
									<?php $totalOT = $totalOT + $record->gt_ot; ?>
									<?php $totalND = $totalND + $record->gt_nd; ?>
									<?php $totalNDOT = $totalNDOT + $record->gt_ndot; ?>
									<?php $totalHC = $totalHC + $record->HC; ?>
									<?php $totalAmount = $totalAmount + $record->TotalAmt; ?>
								</tr>
								<?php //if($No % 35 == 0): ?>
									<!-- <pagebreak/> -->
								<?php //endif; ?>
							<?php endforeach; ?>
							<tr>
								<td style="border:none;" colspan="3"></td>
								<td style="border:none;"><strong>TOTAL</strong></td>
								<td style="text-align:right;"><?php echo number_format($totalST, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalOT, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalND, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalNDOT, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalHC, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalAmount, 2, '.', ','); ?></td>
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
							<td colspan="4" style="font-size:13px;"><strong>PREPARED & CHECKED BY:</strong></td>
							<td colspan="4" style="font-size:13px;"><strong>RECEIVED BY:</strong></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($prepared_by); ?></strong></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($received_by); ?></strong></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo "GSMPC-ACCOUNTING STAFF"; ?></span></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $received_by_pos; ?></span></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
							<?php if($approved_by2): ?>
								<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($approved_by); ?></strong></td>
							<?php if($approved_by2): ?>
								<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($approved_by2); ?></strong></td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $approved_by_pos; ?> </td>
							<?php if($approved_by2): ?>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $approved_by_pos2; ?> </td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
					</table>
				</div>
				<pagebreak />
				<div>
					<div style="margin:80px 0 20px 80px;">
						<h4 style="margin:0;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h4>
						<h4 style="margin-top:6px;margin-bottom:0;">Borja Road, Damilag, M.F. Bukidnon
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							OPERATION COPY
						</h4>
						<h4 style="margin:7px 0 0;">TIN # 411-478-949-000</h4>
						<p style="margin:7px 0 0;">Period Covered:<?php echo $period_covered; ?></p>
						<h4 style="margin:7px 0 0;">TRANSMITTAL #: <?php echo $transmittalNumber; ?></h4>
						<h4 style="margin:7px 0 0;">TRANSMITTAL DATE: <?php echo date("F j, Y", strtotime($transmittalDate)); ?></h4>
						<p style="margin:7px 0 0;">TO: DMPI ACCOUNTING</p>
					</div>
					<table style="margin-bottom:10px;">
						<thead>
							<tr>
								<th style="width:30px;">ITEM#</th>
								<th style="width:70px;">DOCUMENT DATE</th>
								<th style="width:180px;">DEPARTMENT</th>
								<th style="width:130px;">GSMPC SOA NO.</th>
								<th style="text-align:center;width:50px;">ST</th>
								<th style="text-align:center;width:50px;">OT</th>
								<th style="text-align:center;width:50px;">ND</th>
								<th style="text-align:center;width:50px;">NDOT</th>
								<th style="text-align:center;width:50px;">HC</th>
								<th style="text-align:center;width:110px;">TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php $No = 0; ?>
							<?php $totalST = 0; ?>
							<?php $totalOT = 0; ?>
							<?php $totalND = 0; ?>
							<?php $totalNDOT = 0; ?>
							<?php $totalHC = 0; ?>
							<?php $totalAmount = 0; ?>
							<?php foreach($records as $record): ?>
								<tr>
									<td><?php echo($No = $No + 1); ?></td>
									<td><?php echo date("m-d-Y", strtotime($record->soaDate)); ?></td>
									<td><?php echo $record->Location; ?></td>
									<td><?php echo $record->soaNumber; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_st > 0? number_format($record->gt_st, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_ot > 0? number_format($record->gt_ot, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_nd > 0? number_format($record->gt_nd, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->gt_ndot > 0? number_format($record->gt_ndot, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->HC > 0? number_format($record->HC, 2, '.', ',') : '-'; ?></td>
									<td style="text-align:right;"><?php echo $record->TotalAmt > 0? number_format($record->TotalAmt, 2, '.', ',') : '-'; ?></td>
									<?php $totalST = $totalST + $record->gt_st; ?>
									<?php $totalOT = $totalOT + $record->gt_ot; ?>
									<?php $totalND = $totalND + $record->gt_nd; ?>
									<?php $totalNDOT = $totalNDOT + $record->gt_ndot; ?>
									<?php $totalHC = $totalHC + $record->HC; ?>
									<?php $totalAmount = $totalAmount + $record->TotalAmt; ?>
								</tr>
								<?php //if($No % 35 == 0): ?>
									<!-- <pagebreak/> -->
								<?php // endif; ?>
							<?php endforeach; ?>
							<tr>
								<td style="border:none;" colspan="3"></td>
								<td style="border:none;"><strong>TOTAL</strong></td>
								<td style="text-align:right;"><?php echo number_format($totalST, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalOT, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalND, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalNDOT, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalHC, 2, '.', ','); ?></td>
								<td style="text-align:right;"><?php echo number_format($totalAmount, 2, '.', ','); ?></td>
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
							<td colspan="4" style="font-size:13px;"><strong>PREPARED & CHECKED BY:</strong></td>
							<td colspan="4" style="font-size:13px;"><strong>RECEIVED BY:</strong></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($prepared_by); ?></strong></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($received_by); ?></strong></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo "GSMPC-ACCOUNTING STAFF"; ?></span></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $received_by_pos; ?></span></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
							<?php if($approved_by2): ?>
								<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($approved_by); ?></strong></td>
							<?php if($approved_by2): ?>
								<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($approved_by2); ?></strong></td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td></td>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $approved_by_pos; ?> </td>
							<?php if($approved_by2): ?>
							<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $approved_by_pos2; ?> </td>
							<?php else: ?>
								<td colspan="3"></td>
							<?php endif; ?>
						</tr>
					</table>
				</div>
			<?php endif; ?>
			<?php if($preview > 0): ?>
				<?php if($copy == 2): ?>
				<htmlpagefooter name="myFooter" class="footer" style="display:none" >
					<div style="font-weight:bold;font-size:80%;">
						Date & Time Transmitted: <?php echo date("M d, Y h:i:s A", strtotime($date_finalize)); ?>
						Date & Time Created: <?php echo date("M d, Y h:i:s A", strtotime($date_created)); ?>
					</div>
				</htmlpagefooter>
				<?php endif; ?>
			<?php endif; ?>
		</body>
	</html>
	