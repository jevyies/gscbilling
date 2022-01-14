<?php 
    header('Content-type: application/excel');
    $filename = 'OthersBillingReport-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records != 'fail'){
		foreach($records as $record){
			$SOANo = $record->SOANo;
			$Period = $record->Period;
			$Location = $record->Location;
			$date = date('F j, Y', strtotime($record->SOADate));
			$Prepared_by = $record->Prepared_by;
			$Prepared_by_desig = $record->Prepared_by_desig;
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
				font-size: 100%;
				padding: 5px;
				text-align:center;
			}
	
		</style>
		<body>
			<?php if($records != 'fail'): ?>
			<table width="100%">
				<tr>
					<td>
						<h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
						<h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
						<br>
						<h2 style="text-align:center;">STATEMENT OF ACCOUNT</h2>
					</td>
				</tr>
			</table>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="width:50%;font-weight:bold;font-size:120%;">Period Covered : <?php echo $Period; ?></td>
					<td style="width:50%;font-weight:bold;font-size:120%;">SOA# : <?php echo $SOANo; ?></td>
				</tr>
				<tr>
					<td style="width:50%;font-weight:bold;font-size:120%;">&nbsp;</td>
					<td style="width:50%;font-weight:bold;font-size:120%;">&nbsp;</td>
				</tr>
				<tr>
					<td style="width:50%;font-weight:bold;font-size:120%;">Location : <?php echo $Location; ?></td>
					<td style="width:50%;font-weight:bold;font-size:120%;">Date : <?php echo $date; ?></td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="background:lightgrey;">
						<th style="width:10%;padding:20px 0;">DESCRIPTION</th>
						<th style="width:8%;padding:20px 0;">GL No.</th>
						<th style="width:8%;padding:20px 0;">COST CENTER</th>
						<th style="width:8%;padding:20px 0;">QTY</th>
						<th style="width:8%;padding:20px 0;">UNIT</th>
						<th style="width:8%;padding:20px 0;">UNIT COST</th>
						<th style="width:8%;padding:20px 0;">ADMIN FEE</th>
						<th style="width:10%;padding:20px 0;">AMOUNT</th>
						<th style="width:8%;padding:20px 0;">SUPPLIER'S INVOICE</th>
						<th style="width:10%;padding:20px 0;">REMARKS</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
					<tr>
						<td><?php echo $record->Description ? $record->Description : $record->Activity; ?></td>
						<td style="text-align:center;"><?php echo $record->GL; ?></td>
						<td style="text-align:center;"><?php echo $record->CC; ?></td>
						<td style="text-align:center;"><?php echo $record->Qty; ?></td>
						<td style="text-align:center;"><?php echo $record->Unit; ?></td>
						<td style="text-align:center;"><?php echo number_format((float)$record->Price, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->subAmount - $record->Amount, 2, '.', ','); ?></td>
						<td style="text-align:right;"><?php echo number_format((float)$record->Amount, 2, '.', ','); ?></td>
						<td style="text-align:center;"><?php echo $record->InvoiceNo; ?></td>
						<td style="text-align:center;"><?php echo $record->remarks; ?></td>
					</tr>
					<?php $total = $total + $record->Amount; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="6" style="padding-left:35%;color:red;border:none;font-weight:bold;">TOTAL</td>
						<td style="border-left:none;border-bottom:3px double black;"></td>
						<td style="text-align:right;border-bottom:3px double black;"><?php echo number_format((float)$total, 2, '.', ','); ?></td>
						<td style="border:none;" colspan="2"></td>
					</tr>
				</tbody>
			</table>
			<br>
			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td>
						<table width="20%">
							<tr>
								<td style="width:100%;font-weight:bold;">Prepared By:</td>
							</tr>
							<tr>
								<td style="font-weight:bold;"><?php echo $Prepared_by; ?></td>
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