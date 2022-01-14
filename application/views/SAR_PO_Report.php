<?php 
header('Content-type: application/excel');
$filename = 'GSC SAR Report per Department -'. date('mdY') .'.xls';
header('Content-Disposition: attachment; filename='.$filename);

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
            th{
                border: 1px solid black;
            }
			td {
				font-size: 90%;
				padding:5px;
				border: 1px solid black;
			}
	
			@page { sheet-size: Legal-L; }
			
			@page {
				margin-top: 1cm;
				margin-bottom: 1.5cm;
				margin-left: 1cm;
				margin-right: 1cm;
				odd-footer-name: html_myFooter;
			}
			
			h1.bigsection {
					page-break-before: always;
					page: bigger;
			}

			.main_t td{
				border:1px solid black;
			}

			th {
				font-size: 90%;
				text-align:center;
			}
			table.no-borders th{
				border: none;
			}
			table.no-borders td{
				border: none;
			}
		</style>
		<body>
			<div>
				<table style="margin-bottom:10px;width:100%;">
					<thead>
						<tr style="border:1px solid black;">
							<th style="text-align:left;padding:5px;">PO number</th>
							<th style="text-align:left;padding:5px;">Activity</th>
							<th style="text-align:center;">Quantity</th>
							<th style="text-align:center;">BUn</th>
							<th style="text-align:left;">Rate</th>
							<th style="text-align:left;">NetValue</th>
							<th style="text-align:left;">Balance qty</th>
							<th style="text-align:left;">Balance Value</th>
							<th style="text-align:left;">Department</th>
						</tr>
					</thead>
					<tbody>
                        <?php foreach($records as $record): ?>
                            <?php $netValue = $record->poRate * $record->poQty; ?>
                            <?php $balanceQty = $record->poQty - $record->totalQty; ?>
                            <?php $balanceAmt = $balanceQty * $record->poRate; ?>
							<tr>
                                <td style="text-align:right;"><?php echo $record->poNumber; ?></td>
                                <td style="text-align:left;"><?php echo $record->activity.' - '.$record->batchDaytype; ?></td>
                                <td style="text-align:right;"><?php echo number_format($record->poQty, 2, '.', ','); ?></td>
                                <td style="text-align:center;"><?php echo $record->unit; ?></td>
                                <td style="text-align:right;"><?php echo number_format($record->poRate, 2, '.', ','); ?></td>
                                <td style="text-align:right;"><?php echo number_format($netValue, 2, '.', ','); ?></td>
                                <td style="text-align:right;"><?php echo number_format($balanceQty, 2, '.', ','); ?></td>
                                <td style="text-align:right;"><?php echo number_format($balanceAmt, 2, '.', ','); ?></td>
                                <?php if($record->volumeType == 1): ?>
                                    <td style="text-align:center;"><?php echo 'CHECK DAM'; ?></td>
                                <?php elseif($record->volumeType == 2): ?>
                                    <td style="text-align:center;"><?php echo 'DAIRY'; ?></td>
                                <?php else: ?>
                                    <td style="text-align:center;"><?php echo 'PAPAYA'; ?></td>
                                <?php endif;?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</body>
	</html>
	