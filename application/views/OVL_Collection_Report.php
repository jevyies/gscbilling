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
					<td colspan="15" style="text-align:center;"><strong>OVL Collection Report</strong></td>
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
						<?php $Balance = $record->BillAmount - $record->CollectedAmount; ?>
                        <tr style="border:1px solid black;">
                            <td class="text-center"><?php echo $record->OVLVLDate; ?></td>
                            <td class="text-center"><?php echo $record->OVLNo; ?></td>
							<td class="text-right"><?php echo number_format((float)$record->BillAmount, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo number_format((float)$record->CollectedAmount, 2, '.', ','); ?></td>
							<td class="text-right"><?php echo $record->CheckDate; ?></td>
							<td class="text-right"><?php echo $record->ORCRNumber; ?></td>
							<td class="text-right"><?php echo $record->RefNo; ?></td>
							<td class="text-right"><?php echo number_format((float)$Balance, 2, '.', ','); ?></td>
                        </tr>
                        <?php $TotalCollected = $TotalCollected + $record->CollectedAmount; ?>
                        <?php $TotalBill = $TotalBill + $record->BillAmount; ?>
                        <?php $TotalBalance = $TotalBalance + $Balance; ?>
                    <?php endforeach; ?>
                    <tr style="border:1px solid black;">
                        <td colspan="2">Total</td>
                        <td class="text-right"><?php echo number_format((float)$TotalBill, 2, '.', ','); ?></td>
                        <td class="text-right"><?php echo number_format((float)$TotalCollected, 2, '.', ','); ?></td>
						<td colspan="3"></td>
						<td class="text-right"><?php echo number_format((float)$TotalBalance, 2, '.', ','); ?></td>
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