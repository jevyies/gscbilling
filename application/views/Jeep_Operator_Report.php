<?php 
    header('Content-type: application/excel');
    $filename = 'Jeep Operator Billing-'. date('mdY') .'.xls';
    header('Content-Disposition: attachment; filename='.$filename);
    $ReleasedDate = '';
    $x_from = explode('-', $from);
    $x_to = explode('-', $to);
    $diff = (int)($x_to[0]) - (int)($x_from[0]);
    if($diff > 0){
        $period = strtoupper(date('F j, Y', strtotime($from)) ." - ". date('F j, Y', strtotime($to)));
    }else{
        $period = strtoupper(date('F j', strtotime($from)) ."-". date('j, Y', strtotime($to)));
    }
    foreach($records as $record){
        $ReleasedDate = strtoupper(Date('F j, Y', strtotime($record->ReleaseDate)));
        $Trucker = $record->TruckerName;
        break;
    }
    $TotalRate =  0; 
    $TotalCWT = 0; 
    $TotalFuel =  0; 
    $TotalAmount = 0; 
	$TotalLog = 0;
	foreach($logs as $log){
		$TotalLog += $log->amount;
	}
?>
	<html xmlns:x="urn:schemas-microsoft-com:office:excel">
		<head>
		</head>
		<style>
			body {
				font-family: 'Courier New';
			}
            .text-center{
                text-align: center;
            }
            .text-right{
                text-align: right;
            }
			table {
				border-spacing: -1px;
				border-width:thin;
			}

			td {
				font-size: 90%;
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
				margin-left: 0.5cm;
				margin-right: 0.5cm;
				/* odd-footer-name: html_myFooter; */
			}
			
			h1.bigsection {
					page-break-before: always;
					page: bigger;
			}

			.main_t td, th{
				font-size: 90%;
				border:1px solid black;
				padding: 2px;
			}

			th {
				font-size: 90%;
				padding: 5px;
				text-align:center;
				font-style: italic;
			}
			table.no-borders th{
				border: none;
			}
			table.no-borders td{
				border: none;
			}
			.main_t{
				margin-bottom: 30px;
			}
	
		</style>
		<body>
			<?php if($records != 'fail'): ?>
			<table width="100%">
				<tr>
					<td colspan="8" style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</td>
				</tr>
				<tr>
					<td colspan="8" style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</td>
                </tr>
                <tr>
					<td colspan="8" style="text-align:center;padding:10px;">JEEPNEY'S VEHICLE LOG BILLING</td>
                </tr>
                <tr>
					<td colspan="8" style="text-align:right;padding-bottom:20px;"><?php echo Date('m/d/Y'); ?></td>
                </tr>
                <tr>
					<td colspan="8"><strong>NAME:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Trucker; ?></td>
                </tr>
                <tr>
					<td colspan="8"><strong>Period:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $period; ?></td>
                </tr>
                <tr>
					<td colspan="8"><strong>Date Released:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ReleasedDate; ?></td>
                </tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="border:1px solid black;">
						<th style="padding:5px 0;width:8%">Date</th>
						<th style="padding:5px 0;width:10%">OVL Log</th>
						<th style="padding:5px 0;width:8%">Driver</th>
						<th style="padding:5px 0;width:10%">Plate No.</th>
						<th style="padding:5px 0;width:8%">Rate/Day</th>
						<th style="padding:5px 0;width:8%">2% CWT</th>
						<th style="padding:5px 0;width:8%">Less Fuel</th>
						<th style="padding:5px 0;width:8%">Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalNo = 0; ?>
					<?php foreach($records as $record): ?>
					    <?php $Bill = $record->CollectedAmount > 0 ? $record->CollectedAmount : $record->BillAmount; ?>
						<?php $ten_percent = $Bill * .10; ?>
						<?php $rate = $Bill - $ten_percent; ?>
						<?php $Amount = $Bill - ($ten_percent + $record->LessFuel + $record->CWT); ?>
                        <tr>
                            <td class="text-center"><?php echo $record->JVLDate; ?></td>
                            <td class="text-center"><?php echo $record->OVLNo; ?></td>
                            <td class="text-center"><?php echo $record->DriverName; ?></td>
                            <td class="text-center"><?php echo $record->JeepPlateNo; ?></td>
                            <td class="text-right"><?php echo number_format((float)$rate, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)($record->CWT), 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)($record->LessFuel), 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)$Amount, 2, '.', ','); ?></td>
                        </tr>
                        <?php $TotalRate = $TotalRate + $rate; ?>
                        <?php $TotalCWT = $TotalCWT + $record->CWT; ?>
                        <?php $TotalFuel = $TotalFuel + $record->LessFuel; ?>
                        <?php $TotalAmount = $TotalAmount + $Amount; ?>
						<?php $totalNo++; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" style="text-align:left;border:none;">Total No. of Days: <?php echo $totalNo; ?></td>
                        <td colspan="2" style="text-align:right;border:none;"></td>
                        <td class="text-right" style="border:none;border-bottom:1px solid black;">&nbsp;</td>
                        <td class="text-right" style="border:none;border-bottom:1px solid black;">&nbsp;</td>
                        <td class="text-right" style="border:none;border-bottom:1px solid black;">&nbsp;</td>
                        <td class="text-right" style="border:none;border-bottom:1px solid black;">&nbsp;</td>
                    </tr>
					<tr>
                        <td colspan="4" style="text-align:right;border:none;">Grand Total</td>
                        <td class="text-right" style="border:none;border-bottom:2px solid black;"><strong><?php echo number_format((float)$TotalRate, 2, '.', ','); ?></strong></td>
                        <td class="text-right" style="border:none;border-bottom:2px solid black;"><strong><?php echo number_format((float)$TotalCWT, 2, '.', ','); ?></strong></td>
                        <td class="text-right" style="border:none;border-bottom:2px solid black;"><strong><?php echo number_format((float)$TotalFuel, 2, '.', ','); ?></strong></td>
                        <td class="text-right" style="border:none;border-bottom:2px solid black;"><strong><?php echo number_format((float)$TotalAmount, 2, '.', ','); ?></strong></td>
                    </tr>
					<tr>
						<td colspan="5" style="text-align:right;border:none;"></td>
						<td style="text-align:right;border:none;border-bottom:1px solid black;">LESS FUEL:</td>
                        <td colspan="2" class="text-right" style="border:none;border-bottom:1px solid black;"><strong><?php echo number_format((float)$TotalLog, 2, '.', ','); ?></strong></td>
					</tr>
					<tr>
						<td colspan="5" style="text-align:right;border:none;"></td>
						<td style="text-align:right;border:none;border-bottom:2px solid black;"><strong>NET PAY</strong></td>
                        <td colspan="2" class="text-right" style="border:none;border-bottom:2px solid black;"><strong><?php echo number_format((float)$TotalAmount-$TotalLog, 2, '.', ','); ?></strong></td>
					</tr>
				</tbody>
			</table>
			<?php if(!empty($logs)): ?>
				<table class="main_t">
					<tr>
						<th>DATE</th>
						<th>LOG#</th>
						<th>AMOUNT</th>
					</tr>
						<?php foreach($logs as $log): ?>
							<tr>
								<td class="text-center"><?php echo $log->entry_date; ?></td>
								<td class="text-center"><?php echo $log->log; ?></td>
								<td class="text-right"><?php echo number_format((float)$log->amount, 2, '.', ','); ?></td>
							</tr>
						<?php endforeach;?>
				</table>
			<?php endif; ?>
			<table>
				<tr>
					<td>
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
								<td colspan="4" style="font-size:13px;"><strong>PREPARED BY:</strong></td>
								<td colspan="4" style="font-size:13px;"><strong>CHECKED BY:</strong></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($pb); ?></strong></td>
								<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($cb); ?></strong></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $pbp; ?></span></td>
								<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $cbp; ?></span></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
								<td colspan="4" style="font-size:13px;"><strong>NOTED BY:</strong></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($ab); ?></strong></td>
								<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($nb); ?></strong></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $abp; ?> </td>
								<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $nbp; ?> </td>
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