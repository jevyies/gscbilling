<?php 
    header('Content-type: application/excel');
    $filename = 'OVL Payroll Report -'. date('mdY') .'.xls';
    header('Content-Disposition: attachment; filename='.$filename);
    $x_from = explode('-', $from);
    $x_to = explode('-', $to);
    $diff = (int)($x_to[1]) - (int)($x_from[1]);
    if($diff > 0){
        $period = strtoupper(date('F j, Y', strtotime($from)) ." - ". date('F j, Y', strtotime($to)));
    }else{
        $period = strtoupper(date('F j', strtotime($from)) ."-". date('j, Y', strtotime($to)));
    }
    foreach($records as $record){
        $DriverName = $record->DriverName;
        $Chapa = $record->Chapa;
        $Unit = $record->OVLPlateNo;
        break;
    }
    $Overall_Trip = 0;
    $Overall_InCharge = 0;
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
					<td colspan="18" style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</td>
				</tr>
				<tr>
					<td colspan="18" style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</td>
                </tr>
                <tr>
					<td colspan="18">Name: <?php echo $DriverName; ?></td>
                </tr>
                <tr>
					<td colspan="18">Location: GSC Transport Driver</td>
                </tr>
                <tr>
					<td colspan="18">Unit: <?php echo $Unit; ?></td>
                </tr>
                <tr>
					<td colspan="18">Period: <?php echo $period; ?></td>
                </tr>
                <tr>
					<td colspan="18">CHAPA: <?php echo $Chapa; ?></td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="border:1px solid black;">
						<th style="text-align:center;" rowspan="4">DATE</th>
						<th style="text-align:center;" rowspan="4">OVL NO.</th>
						<th style="text-align:center;" rowspan="4">Remarks</th>
						<th style="text-align:center;" colspan="9"><?php echo $Unit; ?></th>
						<th style="text-align:center;"></th>
                        <th style="text-align:center;" colspan="15">GSC SHOP</th>
                        <th style="text-align:center;" rowspan="4">GROSS INCOME</th>
                    </tr>
                    <tr style="border:1px solid black;">
                        <th style="text-align:center;" rowspan="3">HOURS RENDERED</th>
                        <th style="text-align:center;" rowspan="2">RATE/HR</th>
                        <th style="text-align:center;" rowspan="3">SUB-TOTAL</th>
                        <th style="text-align:center;" colspan="5">DEDUCTIONS</th>
                        <th style="text-align:center;" rowspan="3">NET FROM DEDUCTIONS</th>
                        <th style="text-align:center;" rowspan="2">TOTAL</th>
                        <th style="text-align:center;" colspan="7">HOURS RENDERED</th>
                        <th style="text-align:center;" >ST RATE/HR</th>
                        <th style="text-align:center;" >OT RATE/HR</th>
                        <th style="text-align:center;" >ST RATE/HR</th>
                        <th style="text-align:center;" >OT RATE/HR</th>
                        <th style="text-align:center;" >ST RATE/HR</th>
                        <th style="text-align:center;" >OT RATE/HR</th>
                        <th style="text-align:center;" rowspan="2">HOL. PAY</th>
                        <th style="text-align:center;" rowspan="3">TOTAL</th>
                    </tr>
                    <tr style="border:1px solid black;">
                        <th style="text-align:center;">FUEL COST</th>
                        <th style="text-align:center;">ADMIN COST</th>
                        <th style="text-align:center;">MAINTENANCE COST</th>
                        <th style="text-align:center;" rowspan="2">HELPER</th>
                        <th style="text-align:center;" rowspan="2">SUB-TOTAL</th>
                        <th style="text-align:center;" colspan="2">REGULAR DAY</th>
                        <th style="text-align:center;" colspan="2">SUN/SHOL</th>
                        <th style="text-align:center;" colspan="2">RHOL</th>
                        <th style="text-align:center;" rowspan="2">HOL. PAY</th>
                        <th style="text-align:center;" colspan="2">REGULAR DAY</th>
                        <th style="text-align:center;" colspan="2">SUN/SHOL</th>
                        <th style="text-align:center;" colspan="2">LEGAL HOL.</th>
                    </tr>
                    <tr style="border:1px solid black;">
                        <th style="text-align:center;">389.00</th>
                        <th style="text-align:center;">30.24</th>
                        <th style="text-align:center;">10%</th>
                        <th style="text-align:center;">10%</th>
                        <th style="text-align:center;">25%</th>
                        <th style="text-align:center;">ST</th>
                        <th style="text-align:center;">OT</th>
                        <th style="text-align:center;">ST</th>
                        <th style="text-align:center;">OT</th>
                        <th style="text-align:center;">ST</th>
                        <th style="text-align:center;">OT</th>
                        <th style="text-align:center;">44.75</th>
                        <th style="text-align:center;">55.94</th>
                        <th style="text-align:center;">58.18</th>
                        <th style="text-align:center;">75.63</th>
                        <th style="text-align:center;">89.50</th>
                        <th style="text-align:center;">116.35</th>
                        <th style="text-align:center;">44.75</th>
                    </tr>
				</thead>
                <tbody>
                    <tr>
                        <td colspan="18">&nbsp;</td>
                    </tr>
                    <?php $TotalHrs = 0; ?>
                    <?php $TotalRate = 0; ?>
                    <?php $TotalFuel = 0; ?>
                    <?php $TotalAdmin = 0; ?>
                    <?php $TotalMaintenance = 0; ?>
                    <?php $TotalHelper = 0; ?>
                    <?php $TotalSubTotal = 0; ?>
                    <?php $TotalNetDeduct = 0; ?>
                    <?php $GrandTotal = 0; ?>
                    <?php $TotalPercentDeduct = 0; ?>
                    <?php $No = 0; ?>
                    <?php foreach($records as $record): ?>
                        <?php $SubTotal = $record->LessFuel + $record->LessAdmin + $record->MaintenanceCost + $record->Helper; ?>
                        <?php $NetDeduct = $record->PGrossAmount - $SubTotal; ?>
                        <?php $PercentDeduct = $NetDeduct * .25; ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $record->OVLVLDate; ?></td>
                            <td style="text-align:center;"><?php echo $record->OVLNo; ?></td>
                            <td style="text-align:center;"><?php echo $record->LocationTo; ?></td>
                            <?php if($record->OVLType === 'TRIP'): ?>
                                <td style="text-align:center;"><?php echo $record->NumberOfHours2 == 0 ? '-' : $record->NumberOfHours2; ?></td>
                            <?php else: ?>
                                <td style="text-align:center;"><?php echo '-'; ?></td>
                            <?php endif; ?>
                            <td style="text-align:right;"><?php echo $record->PGrossAmount == 0 ? '-' : number_format((float)$record->PGrossAmount, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo $record->PGrossAmount == 0 ? '-' : number_format((float)$record->PGrossAmount, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo $record->LessFuel == 0 ? '-' : number_format((float)$record->LessFuel, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo $record->LessAdmin == 0 ? '-' : number_format((float)$record->LessAdmin, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo $record->MaintenanceCost == 0 ? '-' : number_format((float)$record->MaintenanceCost, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo $record->Helper == 0 ? '-' : number_format((float)$record->Helper, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo $SubTotal == 0 ? '-' : number_format((float)$SubTotal, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo $NetDeduct == 0 ? '-' : number_format((float)$NetDeduct, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo $PercentDeduct == 0 ? '-' : number_format((float)$PercentDeduct, 2, '.', ','); ?></td>
                            <?php if($record->OVLType === 'TRIP'): ?>
                                <td style="text-align:center;"><?php echo '-'; ?></td>
                            <?php else: ?>
                                <td style="text-align:center;"><?php echo $record->NumberOfHours2 == 0 ? '-' : $record->NumberOfHours2; ?></td>
                            <?php endif; ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php if($record->OVLType === 'TRIP'): ?>
                                <td style="text-align:right;"><?php echo ''; ?></td>
                            <?php else: ?>
                                <td style="text-align:right;"><?php echo $record->Labor == 0 ? '-' : number_format((float)$record->Labor, 2, '.', ','); ?></td>
                            <?php endif; ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php if($record->OVLType === 'TRIP'): ?>
                                <td style="text-align:right;"><?php echo ''; ?></td>
                            <?php else: ?>
                                <td style="text-align:right;"><?php echo $record->Labor == 0 ? '-' : number_format((float)$record->Labor, 2, '.', ','); ?></td>
                            <?php endif; ?>
                            <?php if($record->OVLType === 'TRIP'): ?>
                                <td style="text-align:right;"><?php echo $PercentDeduct == 0 ? '-' : number_format((float)$PercentDeduct, 2, '.', ','); ?></td>
                            <?php else: ?>
                                <td style="text-align:right;"><?php echo $record->Labor == 0 ? '-' : number_format((float)$record->Labor, 2, '.', ','); ?></td>
                            <?php endif; ?>
                            
                        </tr>
                        <?php $TotalRate = $TotalRate + $record->PGrossAmount; ?>
                        <?php $TotalFuel = $TotalFuel + $record->LessFuel; ?>
                        <?php $TotalAdmin = $TotalAdmin + $record->LessAdmin; ?>
                        <?php $TotalMaintenance = $TotalMaintenance + $record->MaintenanceCost; ?>
                        <?php $TotalHelper = $TotalHelper + $record->Helper; ?>
                        <?php $TotalSubTotal = $TotalSubTotal + $SubTotal; ?>
                        <?php $TotalNetDeduct = $TotalNetDeduct + $NetDeduct; ?>
                        <?php $TotalPercentDeduct += $PercentDeduct; ?>
                        <?php if($record->OVLType === 'TRIP') : ?>
                            <?php $Overall_Trip += $PercentDeduct; ?>
                            <?php $GrandTotal = $GrandTotal + $PercentDeduct; ?>
                        <?php else: ?>
                            <?php $Overall_InCharge += $record->Labor; ?>
                            <?php $GrandTotal = $GrandTotal + $record->Labor; ?>
                        <?php endif; ?>
                        <?php $No++; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td>Total</td>
                        <td><?php echo $No; ?></td>
                        <td></td>
                        <td style="text-align:center;"></td>
                        <td style="text-align:right;"><?php echo $TotalRate == 0 ? '-' : number_format((float)$TotalRate, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo $TotalRate == 0 ? '-' : number_format((float)$TotalRate, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo $TotalFuel == 0 ? '-' : number_format((float)$TotalFuel, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo $TotalAdmin == 0 ? '-' : number_format((float)$TotalAdmin, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo $TotalMaintenance == 0 ? '-' : number_format((float)$TotalMaintenance, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo $TotalHelper == 0 ? '-' : number_format((float)$TotalHelper, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo $TotalSubTotal == 0 ? '-' : number_format((float)$TotalSubTotal, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo $TotalNetDeduct == 0 ? '-' : number_format((float)$TotalNetDeduct, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo $TotalPercentDeduct == 0 ? '-' : number_format((float)$TotalPercentDeduct, 2, '.', ','); ?></td>
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
                        <td style="text-align:right;"><?php echo number_format((float)$GrandTotal, 2, '.', ','); ?></td>
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
											<td style="font-size:13px;"><?php echo $Unit; ?></td>
											<td></td>
											<td style="border-right:1px solid black;" class="text-right"><?php echo number_format((float)$Overall_Trip, 2, '.', ','); ?></td>
										</tr>
                                        <tr>
											<td style="border-left:1px solid black;"></td>
											<td style="font-size:13px;">GSC Shop/Admin</td>
											<td></td>
											<td style="border-right:1px solid black;" class="text-right"><?php echo number_format((float)$Overall_InCharge, 2, '.', ','); ?></td>
										</tr>
										<?php if($la): ?>
										<tr>
											<td style="font-size:13px;text-align:center;border-left:1px solid black;"><strong>Add:</strong></td>
											<td style="font-size:13px;">Labor Amount</td>
											<td></td>
											<td style="border-right:1px solid black;" class="text-right"><?php echo number_format((float)$la, 2, '.', ','); ?></td>
										</tr>
										<?php endif; ?>
										<?php if($oa): ?>
										<tr>
											<td style="border-left:1px solid black;"><strong></strong></td>
											<td style="font-size:13px;"><?php echo $or; ?></td>
											<td></td>
											<td style="border-right:1px solid black;" class="text-right"><?php echo number_format((float)$oa, 2, '.', ','); ?></td>
										</tr>
                                        <?php endif; ?>
                                        <?php if($fa): ?>
										<tr>
											<td style="border-left:1px solid black;"><strong>Less:</strong></td>
											<td style="font-size:13px;">Adj Fuel Deduction</td>
											<td></td>
											<td style="border-right:1px solid black;" class="text-right"><?php echo number_format((float)$fa, 2, '.', ','); ?></td>
										</tr>
										<?php endif; ?>
										<tr>
											<?php $other_amt = $oa ? $oa : 0; ?>
											<?php $fuel_amt = $fa ? $fa : 0; ?>
											<?php $labor_amt = $la ? $la : 0; ?>
											<?php $gross_income = $GrandTotal + $other_amt + $labor_amt - $fuel_amt; ?>
											<td colspan="3" style="font-size:13px;border-left:1px solid black;"><strong></strong></td>
											<td style="border-top:1px solid black;border-right:1px solid black;" class="text-right"><?php echo number_format((float)$gross_income, 2, '.', ','); ?></td>
										</tr>
										<tr>
											<td colspan="4" style="font-size:14px;padding-top:10px;border-left:1px solid black;border-right:1px solid black;"><strong>SYSTEM</strong></td>
										</tr>
										<tr>
											<?php $hrs = $sd * 8; ?>
											<?php $rate = $sr/8; ?>
											<?php $add_pay = $sr*$sd; ?>
											<td colspan="3" style="font-size:12px;border-left:1px solid black;" class="text-center"><span style="border-bottom:1px solid blue;color:blue;"><?php echo $hrs.'@'.number_format((float)$rate, 2, '.', ',').'/hr';?></span>&nbsp;&nbsp;&nbsp;(<span style=""><?php echo $sd.'@'.$sr;?></span>/day)</td>
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