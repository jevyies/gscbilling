<?php 
    header('Content-type: application/excel');
    $filename = 'TransmittalReport-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records != 'fail'){
		foreach($records as $record){
			$transmittal_no = $record->transmittal_no;
			$invoice_number = $record->invoice_number;
			$date_transmitted = $record->date_transmitted;
			$period = explode('-',$record->SOADate);
			$year = $period[0];
			$month_number = $period[1];
			if($period[2] >= 1 and $period[2] <= 15){
				$period_number = 1;
			}else{
				$period_number = 2;
			}
			$month_name = date('F', mktime(0, 0, 0, (int)$month_number, 10));
			if($period_number == 2){
				$day_start = '16';
				$day_end = date("Y-m-t", strtotime($year.'-'.$month_number.'-'.'01'));
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
	$total_st = 0;
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
				<?php $for = "GSMPC COPY"; ?>
            <?php for($i=1;$i<4;$i++): ?>
			<?php $no = 1; ?>
			<?php  
				$total = 0;
				$total_st = 0;
				$total_hc = 0;	
			?>
            <table width="100%" style="margin-bottom:30px;" class="main_t">
                <tr>
                    <td colspan="2" style="border:none;">
                        <strong>GSMPC GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong>
                    </td>
                </tr>
                <tr>
                    <td style="border:none;"><strong>BORJA ROAD DAMILAG, MANOLO FORTICH,BUKIDNON</strong></td>
                    <td style="border:none;"><strong><?php echo $for; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;"><strong>TIN # 411-478-949-000</strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;">Period Covered: <?php echo $period_covered; ?><strong></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;"><strong>TRANSMITTAL #: <?php echo $transmittal_no; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;"><strong>DATE TRANSMITTED: <?php echo $date_transmitted; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;">TO: DMPI ACCOUNTING<strong></strong></td>
                </tr>
            </table>
            <table width="100%" style="margin-bottom:10px;">
                <thead>
                    <tr>
                        <th>ITEM #</th>
                        <th>DOCUMENT DATE</th>
                        <th>DEPARTMENT</th>
                        <th>GSMPC SOA NO.</th>
                        <th>ST</th>
                        <th>HC</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
					<?php foreach($records as $record): ?>
                    <tr>
                        <td style="text-align:center;border:1px solid black;"><?php echo $no; ?></td>
                        <td style="border:1px solid black;"><?php echo date('F j, Y', strtotime($record->SOADate)); ?></td>
                        <td style="border:1px solid black;">INCENTIVES TONS(BH)</td>
                        <td style="border:1px solid black;t"><?php echo $record->SOANo; ?></td>
                        <td style="text-align:center;border:1px solid black;"><?php echo $record->ST; ?></td>
                        <td style="text-align:center;border:1px solid black;"><?php echo $record->HC; ?></td>
                        <td style="text-align:right;border:1px solid black;"><?php echo number_format($record->billed_amount, 2, '.', ','); ?></td>
                    </tr>
					<?php $total_st = $total_st + $record->ST; ?>
					<?php $total_hc = $total_hc + $record->HC; ?>
					<?php $total = $total + $record->billed_amount; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="3" style="text-align:center;"></td>
						<td style="text-align:center;font-weight:bold;">TOTAL</td>
						<td style="text-align:center;border:1px solid black;font-weight:bold;"><?php echo $total_st; ?></td>
						<td style="text-align:center;border:1px solid black;font-weight:bold;"><?php echo $total_hc; ?></td>
						<td style="text-align:right;border:1px solid black;font-weight:bold;"><?php echo number_format($total, 2, '.', ','); ?></td>
					</tr>
                </tbody>
            </table>
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
            <?php if($i != 3): ?>
            <pagebreak />
            <?php endif; ?>
            <?php $for = "DMPI COPY"; ?>
			<?php $no++; ?>
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