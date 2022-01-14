<?php 
    header('Content-type: application/excel');
    $filename = 'CONSTRUCTIONBillingLetterhead-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records){
		foreach($records as $record){
			$date = $record->date_created;
			$transmittal_no = $record->transmittal_no;
			$period_covered = $record->period_date;
			$billing_statement = $record->billing_statement;
			$date_transmitted = date('F j, Y', strtotime($record->date_transmitted));
			$letter_to = $record->letter_to;
			$SOANo = $record->SOANo;
			$Total_Billing = $record->Total_Billing;
			$MHRS = $record->MHRS;
			$HC = $record->HC;
			$admin_percentage = $record->admin_percentage;
			$body = $record->body;
			$body2 = $record->body2;
			$Prepared_by = $record->Prepared_by;
			$Approved_by_t = $record->Approved_by_t;
			$Approved_by_desig_t = $record->Approved_by_desig_t;
			$Checked_by_t = $record->Checked_by_t;
			$Checked_by_desig_t = $record->Checked_by_desig_t;
			$Received_by_t = $record->Received_by_t;
			$Received_by_desig_t = $record->Received_by_desig_t;
			$ProjectName = $record->ProjectName;
			break;
		}
	}
	$total = 0;
	$total1 = 0;
	$total2 = 0;
	$total3 = 0;
	$total4 = 0;
	$total5 = 0;
	$total6 = 0;
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
            <?php for($i=1;$i<5;$i++): ?>
				<?php $no = 1; ?>
				<?php  
					$total = 0;
					$total1 = 0;
					$total2 = 0;
					$total3 = 0;
					$total4 = 0;
					$total5 = 0;
					$total6 = 0;
				?>
				<table width="100%" style="margin-bottom:30px;" class="main_t">
					<tr>
						<td colspan="2" style="border:none;">
							<strong>GSMPC GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong>
						</td>
					</tr>
					<tr>
						<td style="border:none;"><strong>BORJA ROAD DAMILAG, MANOLO FORTICH,BUKIDNON</strong></td>
						<?php if($i == 1): ?>
						<td style="border:none;"><strong>DMPI-ACCTG1</strong></td>
						<?php elseif($i == 2): ?>
						<td style="border:none;"><strong>DMPI-ACCTG2</strong></td>
						<?php elseif($i == 3): ?>
						<td style="border:none;"><strong>DMPI-OPERATION</strong></td>
						<?php elseif($i == 4): ?>
						<td style="border:none;"><strong>GSMPC</strong></td>
						<?php endif; ?>
					</tr>
					<tr>
						<td colspan="2" style="border:none;"><strong>TIN # 411-478-949-000</strong></td>
					</tr>
					<tr>
						<td colspan="2" style="border:none;"><strong>TRANSMITTAL #: <?php echo $transmittal_no; ?></strong></td>
					</tr>
					<tr>
						<td colspan="2" style="border:none;"><strong>DATE TRANSMITTED: <?php echo $date_transmitted; ?></strong></td>
					</tr>
					<tr>
						<td colspan="2" style="border:none;"><strong>PERIOD COVERED: <?php echo $period_covered; ?></strong></td>
					</tr>
					<tr>
						<td colspan="2" style="border:none;"><strong>BILLING STATEMENT #: <?php echo $billing_statement; ?></strong></td>
					</tr>
				</table>
				<br>
				<h4>Project Name: <?php echo $ProjectName; ?></h4>
				<br>
				<br>
				<table width="100%" border="1">
					<tr>
						<th style="width:5%;">ITEM #</th>
						<th style="width:12%;">DOCUMENT DATE</th>
						<th style="width:12%;">DEPARTMENT</th>
						<th style="width:12%;">GSC SOA #</th>
						<th style="width:12%;">ST</th>
						<th style="width:12%;">OT</th>
						<th style="width:12%;">ND</th>
						<th style="width:12%;">ND OT</th>
						<th style="width:12%;">HC</th>
						<th style="width:12%;">TOTAL</th>
					</tr>
					<?php foreach($records as $record): ?>
					<tr>
						<td style="text-align:center;"><?php echo $no; ?></td>
						<td style="text-align:center;"><?php echo date('m/d/Y', strtotime($record->Date)); ?></td>
						<td style="text-align:left;">CIVIL ENGINEERING DEPT.</td>
						<td style="text-align:center;"><?php echo $record->SOANo; ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->ST, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->OT, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->ND, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->NDOT, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo $record->HC; ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->Total_Billing, 2, '.', ','); ?></td>
					</tr>
					<?php $total1 += $record->ST; ?>
					<?php $total2 += $record->OT; ?>
					<?php $total3 += $record->ND; ?>
					<?php $total4 += $record->NDOT; ?>
					<?php $total5 += $record->HC; ?>
					<?php $total6 += $record->Total_Billing; ?>
					<?php $no++; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="4" style="text-align:right;"><b>TOTAL:<b></td>
						<td style="text-align:right;font-weight:bold;"><?php echo number_format((float)$total1, 2, '.', ','); ?></td>
						<td style="text-align:right;font-weight:bold;"><?php echo number_format((float)$total2, 2, '.', ','); ?></td>
						<td style="text-align:right;font-weight:bold;"><?php echo number_format((float)$total3, 2, '.', ','); ?></td>
						<td style="text-align:right;font-weight:bold;"><?php echo number_format((float)$total4, 2, '.', ','); ?></td>
						<td style="text-align:right;font-weight:bold;"><?php echo number_format((float)$total5, 2, '.', ','); ?></td>
						<td style="text-align:right;font-weight:bold;"><?php echo number_format((float)$total6, 2, '.', ','); ?></td>
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
						<td style="width:60%;">PREPARED BY & CHECKED BY:</td>
						<td></td>
						<td style="width:40%;">RECEIVED BY:</td>
					</tr>
					<tr>
						<td style="width:40%;"><br><br><b><?php echo strtoupper($Prepared_by) . '/' . strtoupper($Checked_by_t); ?></b><br><em>BILLING IN-CHARGE</em></td>
						<td></td>
						<td style="width:40%;"><br><br><b><?php echo strtoupper($Received_by_t); ?></b><br><em><?php echo strtoupper($Checked_by_desig_t); ?></em></b></td>
					</tr>
					<tr>
						<td style="width:40%;"><br><br><br>APPROVED BY:</td>
						<td></td>
						<td style="width:40%;"><br><br><br>DATE: <span style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
					</tr>
					<tr>
						<td style="width:40%;"><br><br><b><?php echo strtoupper($Approved_by_t); ?></b><br><em><?php echo strtoupper($Approved_by_desig_t); ?></em></td>
						<td></td>
						<td style="width:40%;"></td>
					</tr>
				</table>
				<?php if($i != 4): ?>
				<pagebreak />
				<?php endif; ?>
            <?php endfor; ?>
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