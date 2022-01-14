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
	
			@page { sheet-size: Letter; }
			
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
						<th style="padding:20px 0;width:8%" >DATE OF PAYMENT</th>
						<th style="padding:20px 0;width:8%" >UNIT</th>
						<th style="padding:20px 0;width:10%" >VL NO.</th>
						<th style="padding:20px 0;width:8%" >DRIVER</th>
						<th style="padding:20px 0;width:8%" >EXTRA ODO</th>
						<th style="padding:20px 0;width:8%" >EXTRA ODO AMOUNT</th>
						<!-- <th style="padding:20px 0;width:8%" >NET PAY</th> -->
                    </tr>
				</thead>
				<tbody>
                    <?php $TotalFuelLiters = 0; ?>
                    <?php $TotalLabor = 0; ?>
                    <?php $TotalExtraRun = 0; ?>
                    <?php $TotalExtraPay = 0; ?>
                    <?php $TotalNetPay = 0; ?>
					<?php foreach($records as $record): ?>
						<?php $ExtraPay = $record->ExtraRun * 2; ?>
						<?php $NetPay = $record->Labor + $ExtraPay; ?>
                        <tr>
                            <td class="text-center"><?php echo $record->CheckDate; ?></td>
                            <td class="text-center"><?php echo $record->PHBPlateNo; ?></td>
                            <td class="text-center"><?php echo $record->OVLNo; ?></td>
                            <td class="text-center"><?php echo $record->DriverName; ?></td>
							<td class="text-right"><?php echo $record->ExtraRun; ?></td>
							<td class="text-right"><?php echo number_format((float)$ExtraPay, 2, '.', ','); ?></td>
							<!-- <td class="text-right"><?php //echo number_format((float)$NetPay, 2, '.', ','); ?></td> -->
                        </tr>
                        <?php $TotalFuelLiters = $TotalFuelLiters + $record->FuelLiters; ?>
                        <?php $TotalLabor = $TotalLabor + $record->Labor; ?>
                        <?php $TotalExtraRun = $TotalExtraRun + $record->ExtraRun; ?>
                        <?php $TotalExtraPay = $TotalExtraPay + $ExtraPay; ?>
                        <?php //$TotalNetPay = $TotalNetPay + $NetPay; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4">Total</td>
                        <td class="text-right"><?php echo number_format((float)$TotalExtraRun, 2, '.', ','); ?></td>
                        <td class="text-right"><?php echo number_format((float)$TotalExtraPay, 2, '.', ','); ?></td>
                        <!-- <td class="text-right"><?php //echo number_format((float)$TotalNetPay, 2, '.', ','); ?></td> -->
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