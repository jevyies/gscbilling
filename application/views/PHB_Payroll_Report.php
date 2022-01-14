<?php 
    header('Content-type: application/excel');
    $filename = 'PHB Payroll Report -'. date('mdY') .'.xls';
    header('Content-Disposition: attachment; filename='.$filename);
    $x_from = explode('-', $from);
    $x_to = explode('-', $to);
    $diff = (int)($x_to[1]) - (int)($x_from[1]);
    if($diff > 0){
        $period = strtoupper(date('F j, Y', strtotime($from)) ." - ". date('F j, Y', strtotime($to)));
    }else{
        $period = strtoupper(date('F j', strtotime($from)) ."-". date('j, Y', strtotime($to)));
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
				font-size: 100%;
				padding:5px;
				/* border: 1px solid black; */
			}

			.padding-none {
				padding:none;
			}
	
			@page { sheet-size: Letter-L; }
			
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
			table.no-borders th{
				border: none;
			}
			table.no-borders td{
				border: none;
			}
	
		</style>
		<body>
			<?php if($records != 'fail'): ?>
			<table width="100%">
				<tr>
					<td colspan="11" style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</td>
				</tr>
				<tr>
					<td colspan="11" style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</td>
                </tr>
                <tr>
					<td colspan="11">Period: <?php echo $period; ?></td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="border:1px solid black;">
						<th style="padding:20px 0;width:9%" rowspan="2">DATE</th>
						<th style="padding:20px 0;width:8%" rowspan="2">UNIT</th>
						<th style="padding:20px 0;width:10%" rowspan="2">VL NO.</th>
						<th style="padding:20px 0;width:8%" rowspan="2">DRIVER</th>
						<th style="padding:20px 0;width:8%;text-align:center" colspan="2">TIME</th>
						<th style="padding:20px 0;width:8%" colspan="3">ODOMOTER</th>
						<th style="padding:20px 0;width:8%">FUEL</th>
						<th style="padding:20px 0;width:8%" rowspan="2">RATE</th>
						<th style="padding:20px 0;width:8%" rowspan="2">EXTRA ODO</th>
						<th style="padding:20px 0;width:8%" rowspan="2">EXTRA ODO AMOUNT</th>
						<th style="padding:20px 0;width:8%" rowspan="2">NET PAY</th>
                    </tr>
                    <tr style="border:1px solid black;">
                        <th style="text-align:center;">IN</th>
                        <th style="text-align:center;">OUT</th>
                        <th style="text-align:center;">IN</th>
                        <th style="text-align:center;">OUT</th>
                        <th style="text-align:center;">KM</th>
                        <th style="text-align:center;">LITERS</th>
                    </tr>
				</thead>
				<tbody>
                    <?php $TotalFuelLiters = 0; ?>
                    <?php $TotalLabor = 0; ?>
                    <?php $TotalExtraRun = 0; ?>
                    <?php $TotalExtraPay = 0; ?>
                    <?php $TotalNetPay = 0; ?>
                    <?php $No = 0; ?>
					<?php foreach($records as $record): ?>
						<?php $ExtraPay = $record->ExtraRun * 2; ?>
						<?php $NetPay = $record->Labor + $ExtraPay; ?>
                        <tr>
                            <td class="text-center"><?php echo Date('m-d-Y', strtotime($record->PHBVLDate)); ?></td>
                            <td class="text-center"><?php echo $record->PHBPlateNo; ?></td>
                            <td class="text-center"><?php echo $record->OVLNo; ?></td>
                            <td class="text-center"><?php echo $record->DriverName; ?></td>
                            <td class="text-center"><?php echo $record->TimeIn; ?></td>
							<td class="text-center"><?php echo $record->TimeOut; ?></td>
							<td class="text-right"><?php echo $record->startreading ? $record->startreading : '-'; ?></td>
							<td class="text-right"><?php echo $record->endreading ? $record->endreading : '-'; ?></td>
							<td class="text-right"><?php echo $record->totalrun ? $record->totalrun : '-'; ?></td>
							<td class="text-right"><?php echo $record->FuelLiters ? $record->FuelLiters : '-'; ?></td>
							<td class="text-right"><?php echo number_format((float)$record->Labor, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo $record->ExtraRun ? $record->ExtraRun : '-'; ?></td>
							<td class="text-right"><?php echo $ExtraPay ? number_format((float)$ExtraPay, 2, '.', ',') : '-'; ?></td>
							<td class="text-right"><?php echo number_format((float)$NetPay, 2, '.', ','); ?></td>
                        </tr>
                        <?php $TotalFuelLiters = $TotalFuelLiters + $record->FuelLiters; ?>
                        <?php $TotalLabor = $TotalLabor + $record->Labor; ?>
                        <?php $TotalExtraRun = $TotalExtraRun + $record->ExtraRun; ?>
                        <?php $TotalExtraPay = $TotalExtraPay + $ExtraPay; ?>
                        <?php $TotalNetPay = $TotalNetPay + $NetPay; ?>
						<?php $No++; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td>Total:</td>
                        <td class="text-right"><?php echo $No; ?></td>
                        <td colspan="6"></td>
                        <td class="text-right"><?php echo $TotalFuelLiters ? $TotalFuelLiters : '-'; ?></td>
                        <td class="text-right"><?php echo $TotalLabor ? number_format((float)$TotalLabor, 2, '.', ',') : '-'; ?></td>
                        <td class="text-right"><?php echo $TotalExtraRun ? number_format((float)$TotalExtraRun, 2, '.', ',') : '-'; ?></td>
                        <td class="text-right"><?php echo $TotalExtraPay ? number_format((float)$TotalExtraPay, 2, '.', ',') : '-'; ?></td>
                        <td class="text-right"><?php echo $TotalNetPay ? number_format((float)$TotalNetPay, 2, '.', ',') : '-'; ?></td>
                    </tr>
				</tbody>
			</table>
			<table>
				<tr>
					<td>
						<table class="no-borders" style="vertical-align:top;">
							<tr>
								<td style="width:470px;" >
									<table>
										<tr>
											<td style="width:100;"></td>
											<td style="width:170;"></td>
											<td style="width:100;"></td>
											<td style="width:100;"></td>
										</tr>
										<tr>
											<td style="font-size:13px;text-align:center;border-left:1px solid black;border-top:1px solid black;"><strong>Income</strong></td>
											<td colspan="3" style="font-size:14px;text-align:center;border-right:1px solid black;border-top:1px solid black;"><strong>PAYSLIP</strong></td>
										</tr>
										<tr>
											<td style="border-left:1px solid black;"></td>
											<td style="font-size:13px;"><?php echo $records[0]->PHBPlateNo; ?></td>
											<td></td>
											<td style="border-right:1px solid black;" class="text-right"><?php echo number_format((float)$TotalNetPay, 2, '.', ','); ?></td>
										</tr>
										<?php if($fa): ?>
										<tr>
											<td style="font-size:13px;text-align:center;border-left:1px solid black;"><strong>Add:</strong></td>
											<td style="font-size:13px;"><?php echo 'Fuel Adjustment As of '.Date('F j, Y', strtotime($fd)); ?></td>
											<td></td>
											<td style="border-right:1px solid black;" class="text-right"><?php echo number_format((float)$fa, 2, '.', ','); ?></td>
										</tr>
										<?php endif; ?>
										<?php if($oa): ?>
										<tr>
											<td style="border-left:1px solid black;"></td>
											<td style="font-size:13px;"><?php echo 'Other Adjustment ('.$or.')'; ?></td>
											<td></td>
											<td style="border-right:1px solid black;" class="text-right"><?php echo number_format((float)$oa, 2, '.', ','); ?></td>
										</tr>
										<?php endif; ?>
										<tr>
											<?php $other_amt = $oa ? $oa : 0; ?>
											<?php $fuel_amt = $fa ? $fa : 0; ?>
											<?php $gross_income = $TotalNetPay - ($other_amt + $fuel_amt); ?>
											<td colspan="3" style="font-size:13px;border-left:1px solid black;"><strong>Gross Income</strong></td>
											<td style="border-top:1px solid black;border-right:1px solid black;" class="text-right"><?php echo number_format((float)$gross_income, 2, '.', ','); ?></td>
										</tr>
										<tr>
											<td colspan="4" style="font-size:14px;padding-top:10px;border-left:1px solid black;border-right:1px solid black;"><strong>SYSTEM</strong></td>
										</tr>
										<tr>
											<?php $hrs = $sd * 8; ?>
											<?php $rate = $sr/8; ?>
											<?php $add_pay = $sr*$sd; ?>
											<td colspan="3" style="font-size:12px;color:blue;border-left:1px solid black;" class="text-center"><span style="border-bottom:1px solid blue;"><?php echo $hrs.'@'.number_format((float)$rate, 2, '.', ',').'/hr';?></span>&nbsp;&nbsp;<span style="border-bottom:1px solid blue;"><?php echo $sd.'@'.$sr.'/day';?></span></td>
											<td class="text-right" style="border-right:1px solid black;"><?php echo number_format((float)$add_pay, 2, '.', ','); ?></td>
										</tr>
										<tr>
											<td colspan="2" style="border-bottom:1px solid black;border-left:1px solid black;"></td>
											<td style="border-bottom:1px solid black;" class="text-right"><strong>ADD Pay:</strong></td>
											<td class="text-right" style="border-bottom:1px solid black;border-right:1px solid black;"><?php echo number_format((float)$gross_income - $add_pay, 2, '.', ','); ?></td>
										</tr>
									</table>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td style="width:300px;">
									<table width="100%">
										<tr>
											<td style="width:10%;"></td>
											<td style="width:90%;"></td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:13px;"><strong>PREPARED BY:</strong></td>
										</tr>
										<tr>
											<td></td>
											<td style="padding:20px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($pb); ?></strong></td>
										</tr>
										<tr>
											<td></td>
											<td style="padding:3px 5px 30px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $pbp; ?></span></td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:13px;"><strong>CHECKED BY:</strong></td>
										</tr>
										<tr>
											<td></td>
											<td style="padding:20px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($cb); ?></strong></td>
										</tr>
										<tr>
											<td></td>
											<td style="padding:3px 5px 30px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $cbp; ?></span></td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:13px;"><strong>APPROVED BY:</strong></td>
										</tr>
										<tr>
											<td></td>
											<td style="padding:20px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($ab); ?></strong></td>
										</tr>
										<tr>
											<td></td>
											<td style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $abp; ?></span></td>
										</tr>
									</table>
								</td>
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