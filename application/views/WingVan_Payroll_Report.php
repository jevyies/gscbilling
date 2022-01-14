<?php 
    header('Content-type: application/excel');
    $filename = 'WingVan Payroll Report -'. date('mdY') .'.xls';
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
        $Unit = $record->vehicle_name;
        break;
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
						<th style="text-align:center;" rowspan="4">DR NO.</th>
						<th style="text-align:center;" rowspan="4">Remarks</th>
						<th style="text-align:center;" colspan="10"><?php echo 'Wing Van '.$Unit; ?></th>
						<th style="text-align:center;"></th>
                        <th style="text-align:center;" colspan="15">GSC SHOP</th>
                        <th style="text-align:center;" rowspan="4">GROSS INCOME</th>
                    </tr>
                    <tr>
                        <th style="text-align:center;" rowspan="2">No. of Bags</th>
                        <th style="text-align:center;">RATE/HR</th>
                        <th style="text-align:center;" rowspan="2">SUB-TOTAL</th>
                        <th style="text-align:center;" colspan="6">DEDUCTIONS</th>
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
                    <tr>
                        <th style="text-align:center;">389.00</th>
                        <th style="text-align:center;">FUEL COST</th>
                        <th style="text-align:center;">Loadrs/Unl</th>
                        <th style="text-align:center;">HELPER</th>
                        <th style="text-align:center;">ADMIN COST</th>
                        <th style="text-align:center;">MAINTENANCE COST</th>
                        <th style="text-align:center;" rowspan="2">SUB-TOTAL</th>
                        <th style="text-align:center;" colspan="2">REGULAR DAY</th>
                        <th style="text-align:center;" colspan="2">SUN/SHOL</th>
                        <th style="text-align:center;" colspan="2">RHOL</th>
                        <th style="text-align:center;" rowspan="2">HOL. PAY</th>
                        <th style="text-align:center;" colspan="2">REGULAR DAY</th>
                        <th style="text-align:center;" colspan="2">SUN/SHOL</th>
                        <th style="text-align:center;" colspan="2">LEGAL HOL.</th>
                    </tr>
                    <tr>
                        <th style="text-align:center;">14.00</th>
                        <th style="text-align:center;">23.00</th>
                        <th style="text-align:center;">19.00</th>
                        <th style="text-align:center;">30.76</th>
                        <th style="text-align:center;">35.00</th>
                        <th style="text-align:center;">32.00</th>
                        <th style="text-align:center;">10%</th>
                        <th style="text-align:center;">10%</th>
                        <th style="text-align:center;">25%</th>
                        <th style="text-align:center;">ST</th>
                        <th style="text-align:center;">OT</th>
                        <th style="text-align:center;">ST</th>
                        <th style="text-align:center;">OT</th>
                        <th style="text-align:center;">ST</th>
                        <th style="text-align:center;">OT</th>
                        <th style="text-align:center;">47.88</th>
                        <th style="text-align:center;">59.85</th>
                        <th style="text-align:center;">4.79</th>
                        <th style="text-align:center;">5.99</th>
                        <th style="text-align:center;">62.25</th>
                        <th style="text-align:center;">80.92</th>
                        <th style="text-align:center;">95.77</th>
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
                    <?php foreach($records as $record): ?>
                        <?php $SubTotal = $record->LessFuel + $record->LessAdmin + $record->MaintenanceCost + $record->Helper; ?>
                        <?php $NetDeduct = $record->amount - $SubTotal; ?>
                        <?php $PercentDeduct = $NetDeduct * .25; ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $record->date; ?></td>
                            <?php if($record->OVLType === 'TRIP'): ?>
                                <td style="text-align:center;"><?php echo $record->dr_no; ?></td>
                            <?php else: ?>
                                <td style="text-align:center;"><?php echo 'ADMIN'; ?></td>
                            <?php endif; ?>
                            
                            <td style="text-align:center;"><?php echo $record->po_route_to; ?></td>
                            <?php if($record->OVLType === 'TRIP'): ?>
                                <td style="text-align:center;"><?php echo $record->no_trips > 0 ? $record->no_trips : '-'; ?></td>
                            <?php else: ?>
                                <td style="text-align:center;"><?php echo '-'; ?></td>
                            <?php endif; ?>
                            <td style="text-align:right;"><?php echo $record->amount > 0 ? number_format((float)$record->amount, 2, '.', ',') : '-'; ?></td>
                            <td style="text-align:right;"><?php echo $record->amount > 0 ? number_format((float)$record->amount, 2, '.', ',') : '-'; ?></td>
                            <td style="text-align:right;"></td>
                            <td style="text-align:right;"><?php echo $record->LessFuel > 0 ? number_format((float)$record->LessFuel, 2, '.', ',') : '-'; ?></td>
                            <td style="text-align:right;"><?php echo $record->LessAdmin > 0 ? number_format((float)$record->LessAdmin, 2, '.', ',') : '-'; ?></td>
                            <td style="text-align:right;"><?php echo $record->MaintenanceCost > 0 ? number_format((float)$record->MaintenanceCost, 2, '.', ',') : '-'; ?></td>
                            <td style="text-align:right;"><?php echo $record->Helper > 0 ? number_format((float)$record->Helper, 2, '.', ',') : '-'; ?></td>
                            <td style="text-align:right;"><?php echo $SubTotal > 0 ? number_format((float)$SubTotal, 2, '.', ',') : '-'; ?></td>
                            <td style="text-align:right;"><?php echo $NetDeduct > 0 ? number_format((float)$NetDeduct, 2, '.', ',') : '-'; ?></td>
                            <td style="text-align:right;"><?php echo $PercentDeduct > 0 ? number_format((float)$PercentDeduct, 2, '.', ',') : '-'; ?></td>
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
                            <?php if($record->OVLType === 'TRIP'): ?>
                                <td style="text-align:right;"><?php echo ''; ?></td>
                            <?php else: ?>
                                <td style="text-align:right;"><?php echo $record->Labor > 0 ? number_format((float)$record->Labor, 2, '.', ',') : '-'; ?></td>
                            <?php endif; ?>
                            <?php if($record->OVLType === 'TRIP'): ?>
                                <td style="text-align:right;"><?php echo $PercentDeduct > 0 ? number_format((float)$PercentDeduct, 2, '.', ',') : '-'; ?></td>
                            <?php else: ?>
                                <td style="text-align:right;"><?php echo $record->Labor > 0 ? number_format((float)$record->Labor, 2, '.', ',') : '-'; ?></td>
                            <?php endif; ?>
                            
                        </tr>
                        <?php $TotalRate = $TotalRate + $record->amount; ?>
                        <?php $TotalFuel = $TotalFuel + $record->LessFuel; ?>
                        <?php $TotalAdmin = $TotalAdmin + $record->LessAdmin; ?>
                        <?php $TotalMaintenance = $TotalMaintenance + $record->MaintenanceCost; ?>
                        <?php $TotalHelper = $TotalHelper + $record->Helper; ?>
                        <?php $TotalSubTotal = $TotalSubTotal + $SubTotal; ?>
                        <?php $TotalNetDeduct = $TotalNetDeduct + $NetDeduct; ?>
                        <?php if($record->OVLType === 'TRIP') : ?>
                            <?php $GrandTotal = $GrandTotal + $PercentDeduct; ?>
                        <?php else: ?>
                            <?php $GrandTotal = $GrandTotal + $record->Labor; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td style="text-align:center;"></td>
                        <td style="text-align:right;"><?php echo $TotalRate > 0 ? number_format((float)$TotalRate, 2, '.', ',') : ''; ?></td>
                        <td style="text-align:right;"><?php echo $TotalRate > 0 ? number_format((float)$TotalRate, 2, '.', ',') : ''; ?></td>
                        <td style="text-align:right;"><?php echo $TotalFuel > 0 ? number_format((float)$TotalFuel, 2, '.', ',') : ''; ?></td>
                        <td style="text-align:right;"><?php echo $TotalFuel > 0 ? number_format((float)$TotalFuel, 2, '.', ',') : ''; ?></td>
                        <td style="text-align:right;"><?php echo $TotalAdmin > 0 ? number_format((float)$TotalAdmin, 2, '.', ',') : ''; ?></td>
                        <td style="text-align:right;"><?php echo $TotalMaintenance > 0 ? number_format((float)$TotalMaintenance, 2, '.', ',') : ''; ?></td>
                        <td style="text-align:right;"><?php echo $TotalHelper > 0 ? number_format((float)$TotalHelper, 2, '.', ',') : ''; ?></td>
                        <td style="text-align:right;"><?php echo $TotalSubTotal > 0 ? number_format((float)$TotalSubTotal, 2, '.', ',') : ''; ?></td>
                        <!-- <td style="text-align:right;"><?php echo $TotalNetDeduct > 0 ? number_format((float)$TotalNetDeduct, 2, '.', ',') : ''; ?></td> -->
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
                        <td style="text-align:right;"><?php echo number_format((float)$GrandTotal, 2, '.', ','); ?></td>
                    </tr>
				</tbody>
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