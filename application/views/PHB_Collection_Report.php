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
					<td colspan="15" style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</td>
				</tr>
				<tr>
					<td colspan="15" style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</td>
				</tr>
				<tr>
					<td colspan="15" style="text-align:center;"><strong>PHB Collection Report</strong></td>
                </tr>
                <tr>
					<td colspan="15">Period: <?php echo $period; ?></td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="border:1px solid black;">
						<th style="padding:20px 0;" rowspan="2">DATE</th>
						<th style="padding:20px 0;" rowspan="2">VL NO.</th>
						<th style="padding:20px 0;" rowspan="2">ACTUAL KM RUN</th>
						<th style="padding:20px 0;" rowspan="2">DMPI KM RUN</th>
						<th style="padding:20px 0;" rowspan="2">BILLED AMOUNT</th>
						<th style="padding:20px 0;" colspan="5">DMPI PAYMENTS</th>
					</tr>
					<tr style="border:1px solid black;">
						<th>COLLECTED</th>
						<th>CHECK DATE</th>
						<th>OR. NO.</th>
						<th>REF. NO.</th>
						<th>BALANCE</th>
					</tr>
				</thead>
				<tbody>
                    <?php $TotalBalance = 0; ?>
                    <?php $TotalBill = 0; ?>
                    <?php $TotalCollected = 0; ?>
					<?php foreach($records as $record): ?>
						<?php $BillAmount = $record->CollectedAmount > 0 ? $record->CollectedAmount : $record->BillAmount; ?>
						<?php $Balance = $BillAmount - $record->CollectedAmount; ?>
                        <tr style="border:1px solid black;">
                            <td class="text-center"><?php echo $record->PHBVLDate; ?></td>
                            <td class="text-center"><?php echo $record->OVLNo; ?></td>
							<td class="text-right"><?php echo $record->totalrun; ?></td>
							<td class="text-right"><?php echo $record->totalactualrun; ?></td>
							<td class="text-right"><?php echo number_format((float)$BillAmount, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)$record->CollectedAmount, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo $record->CheckDate; ?></td>
							<td class="text-right"><?php echo $record->ORCRNumber; ?></td>
							<td class="text-right"><?php echo $record->RefNo; ?></td>
							<td class="text-right"><?php echo number_format((float)$Balance, 2, '.', ','); ?></td>
                        </tr>
                        <?php $TotalCollected = $TotalCollected + $record->CollectedAmount; ?>
                        <?php $TotalBill = $TotalBill + $BillAmount; ?>
                        <?php $TotalBalance = $TotalBalance + $Balance; ?>
                    <?php endforeach; ?>
                    <tr style="border:1px solid black;">
                        <td colspan="4">Total</td>
                        <td class="text-right"><?php echo number_format((float)$TotalBill, 2, '.', ','); ?></td>
                        <td class="text-right"><?php echo number_format((float)$TotalCollected, 2, '.', ','); ?></td>
						<td colspan="3"></td>
						<td class="text-right"><?php echo number_format((float)$TotalBalance, 2, '.', ','); ?></td>
                    </tr>
				</tbody>
			</table>
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
								<td colspan="4"></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4" style="padding:10px 5px 0;font-size:12px;"><strong style="border-bottom:1px solid black;"><?php echo strtoupper($ab); ?></strong></td>
								<td colspan="4"></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4" style="padding:3px 5px 10px;font-size:12px;"><span style="border-top:1px solid black;"><?php echo $abp; ?> </td>
								<td colspan="4"></td>
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