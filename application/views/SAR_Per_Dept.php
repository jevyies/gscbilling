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
							<th style="text-align:center;">BILLING DATE</th>
							<th style="text-align:center;">CONTROL #</th>
							<th style="text-align:center;">TRANSMITTAL DATE</th>
							<th style="text-align:center;">BILLING STATEMENT</th>
							<th style="text-align:center;">TRANSMITTAL NUMBER</th>
							<th style="text-align:center;">DEPARTMENT/OPERATION</th>
							<th style="text-align:center;">P.O</th>
							<th style="text-align:center;">ACTIVITY/DESCRIPTION</th>
							<th style="text-align:center;">GL ACCOUNT</th>
							<th style="text-align:center;">COST CENTER</th>
							<th style="text-align:center;">RATE</th>
							<th style="text-align:center;">AMOUNT</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($records as $record): ?>
							<tr>
                                <td style="text-align:center;"><?php echo $record->soaDate; ?></td>
                                <td style="text-align:center;"><?php echo $record->controlNo; ?></td>
                                <td style="text-align:center;"><?php echo $record->TransmittalDate; ?></td>
                                <td style="text-align:center;"><?php echo $record->soaNumber; ?></td>
                                <td style="text-align:center;"><?php echo $record->TransmittalNo; ?></td>
                                <?php if($record->volumeType == 1): ?>
                                    <td style="text-align:center;"><?php echo 'CHECK DAM'; ?></td>
                                <?php elseif($record->volumeType == 2): ?>
                                    <td style="text-align:center;"><?php echo 'DAIRY'; ?></td>
                                <?php else: ?>
                                    <td style="text-align:center;"><?php echo 'PAPAYA'; ?></td>
                                <?php endif;?>
                                <td style="text-align:center;"><?php echo $record->poNumber; ?></td>
                                <td style="text-align:center;"><?php echo $record->activity; ?></td>
                                <td style="text-align:center;"><?php echo $record->gl; ?></td>
                                <td style="text-align:center;"><?php echo $record->costCenter; ?></td>
                                <td style="text-align:right;"><?php echo number_format($record->rate, 2, '.', ','); ?></td>
                                <td style="text-align:right;"><?php echo number_format($record->amount, 2, '.', ','); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</body>
	</html>
	