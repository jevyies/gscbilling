<?php 
	header('Content-type: application/excel');
	$filename = 'ProjectDetail-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records != 'fail'){
		foreach($records as $record){
			$DocumentNum = $record->DocumentNum;
			$last_desc = '';
			$total_po = 0;
			break;
		}
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
						<h3 style="text-align:center;text-decoration:underline;">PROJECT DETAILS</h3>
					</td>
				</tr>
			</table><br><br>
			<table width="100%" class="main_t">
				<thead>
					<tr style="background:lightgreen;">
						<th style="width:10%;padding:20px 0;">Batch#</th>
						<th style="width:10%;padding:20px 0;">Month Started</th>
						<th style="width:10%;padding:20px 0;">Date Started</th>
						<th style="width:10%;padding:20px 0;">Description</th>
						<th style="width:10%;padding:20px 0;">PO #</th>
						<th style="width:10%;padding:20px 0;">Contract Revenue</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
					<?php if($DocumentNum != $record->DocumentNum or $record->DocumentNum == ''): ?>
						<tr>
							<td style="text-align:center;"><?php echo $last_batch; ?></td>
							<td style="text-align:left;"><?php echo $last_month; ?></td>
							<td style="text-align:left;"><?php echo $last_date; ?></td>
							<td style="text-align:left;"><?php echo rtrim($last_desc, ', '); ?></td>
							<td style="text-align:left;"><?php echo $DocumentNum; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$total_po, 2, '.', ','); ?></td>
						</tr>
						<?php  
							$DocumentNum = $record->DocumentNum;
							$last_desc = '';
							$total_po = 0;
						?>
					<?php endif; ?>
					<?php
					$last_batch = $record->batchNo;
					$last_month = date("M.Y", strtotime($record->DocumentDate));
					$last_date = date("F j, Y", strtotime($record->DocumentDate));
					$last_desc .= $record->ItemDesc . ', ';
					$total_po += $record->total_Amt;
					?>
					<?php endforeach; ?>
						<tr>
							<td style="text-align:center;"><?php echo $last_batch; ?></td>
							<td style="text-align:left;"><?php echo $last_month; ?></td>
							<td style="text-align:left;"><?php echo $last_date; ?></td>
							<td style="text-align:left;"><?php echo rtrim($last_desc, ', '); ?></td>
							<td style="text-align:left;"><?php echo $DocumentNum; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$total_po, 2, '.', ','); ?></td>
						</tr>
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