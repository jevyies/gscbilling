<?php 
    header('Content-type: application/excel');
    $filename = 'DARReactivated-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);

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
					<!-- <td style="width:20%;"><img src="http://192.168.1.250/epis/static/img/gsclogo.png" alt="GSC Logo" style="width:8%;"></td> -->
					<td style="width:120%;text-align:center;">
						<h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
						<h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
						<br>
						<h2 style="text-align:center;text-decoration:underline;">DAR REACTIVATED SOA</h3>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:left;"><h3><br><br>Date From: <?php echo $from; ?> To <?php echo $to; ?><br></b></h3></td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr>
						<th style="width:10%;padding:20px 0;">Date</th>
						<th style="width:10%;padding:20px 0;">Time</th>
						<th style="width:10%;padding:20px 0;">SOA #</th>
						<th style="width:10%;padding:20px 0;">SOA Amount</th>
                        <th style="width:10%;padding:20px 0;">ST</th>
						<th style="width:10%;padding:20px 0;">OT</th>
                        <th style="width:10%;padding:20px 0;">ND</th>
                        <th style="width:10%;padding:20px 0;">ND OT</th>
						<th style="width:15%;padding:20px 0;">Reactivated By</th>
                        <th style="width:15%;padding:20px 0;">Reason Of Reactivation</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
						<tr>
							<td style="text-align:center;"><?php echo date('Y-m-d',strtotime($record['dtls'][0]->Datetime_reactivation));  ?></td>
							<td style="text-align:center;"><?php  echo date('h:m:s A',strtotime($record['dtls'][0]->Datetime_reactivation)); ?></td>
							<td rowspan="<?php echo count($record['dtls']); ?>" style="text-align:center;"><?php echo $record['soaNumber']; ?></td>
							<td rowspan="<?php echo count($record['dtls']); ?>" style="text-align:right;"><?php echo number_format((float)$record['TOTAL_AMT'], 2, '.', ','); ?></td>
							<td rowspan="<?php echo count($record['dtls']); ?>" style="text-align:right;"><?php echo number_format((float)$record['ST'], 2, '.', ','); ?></td>
							<td rowspan="<?php echo count($record['dtls']); ?>" style="text-align:right;"><?php echo number_format((float)$record['OT'], 2, '.', ','); ?></td>
							<td rowspan="<?php echo count($record['dtls']); ?>" style="text-align:right;"><?php echo number_format((float)$record['ND'], 2, '.', ','); ?></td>
							<td rowspan="<?php echo count($record['dtls']); ?>" style="text-align:right;"><?php echo number_format((float)$record['ND_OT'], 2, '.', ','); ?></td>
							<td style="text-align:center;"><?php echo $record['dtls'][0]->reactivatedBy; ?></td>
							<td style="text-align:center;"><?php  echo $record['dtls'][0]->reasonofreactivation; ?></td>
						</tr>
						<?php if(count($record['dtls']) > 1): ?>
							<?php for($i = 1; $i <= (count($record['dtls']) - 1); $i++): ?>
								<tr>
									<td style="text-align:center;"><?php echo date('Y-m-d',strtotime($record['dtls'][$i]->Datetime_reactivation));  ?></td>
									<td style="text-align:center;"><?php  echo date('h:m:s A',strtotime($record['dtls'][$i]->Datetime_reactivation)); ?></td>
									<td style="text-align:center;"><?php echo $record['dtls'][$i]->reactivatedBy; ?></td>
									<td style="text-align:center;"><?php  echo $record['dtls'][$i]->reasonofreactivation; ?></td>
								</tr>
							<?php endfor; ?>
						<?php endif; ?>
						<?php $total = $total + $record['TOTAL_AMT']; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="3" style="text-align:right;color:red;border:none;font-weight:bold;">TOTAL AMOUNT</td>
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
								<td style="font-weight:bold;text-align:center;"><?php echo $preparedby; ?></td>
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