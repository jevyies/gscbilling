<?php 
header('Content-type: application/excel');
$filename = 'Uploaded DAR -'. date('mdY') .'.xls';
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
	
			@page { sheet-size: Letter; }
			
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
        <table style="margin-bottom:10px;" width="100%">
            <thead>
                <tr>
                    <th>DOC DATE</th>
                    <th>SOA NUMBER</th>
                    <th>UPLOADED AMOUNT</th>
                    <th>PAYROLL AMOUNT</th>
                    <th>DIFFERENCE</th>
                    <th>REMARKS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $record): ?>
					<?php if($record->CT > 1): ?>
                    <tr style="background-color:red;">
                        <td><?php echo date("d-M-Y", strtotime($record->DocDate)); ?></td>
                        <td><?php echo $record->SOA_Number; ?></td>
                        <td style=""><?php echo number_format($record->SAmount, 2, '.', ','); ?></td>
                        <td><?php echo number_format($record->CAmount, 2, '.', ','); ?></td>
                        <td><?php echo number_format($record->SAmount - $record->CAmount, 2, '.', ','); ?></td>
                        <td><?php echo $record->DARID > 0 ? 'Retrieved' : 'Not in the system or status is not yet transmitted'; ?></td>
                    </tr>
					<?php else: ?>
						<tr>
							<td><?php echo date("d-M-Y", strtotime($record->DocDate)); ?></td>
							<td><?php echo $record->SOA_Number; ?></td>
							<td style=""><?php echo number_format($record->SAmount, 2, '.', ','); ?></td>
							<td><?php echo number_format($record->CAmount, 2, '.', ','); ?></td>
							<td><?php echo number_format($record->SAmount - $record->CAmount, 2, '.', ','); ?></td>
							<td><?php echo $record->DARID > 0 ? 'Retrieved' : 'Not in the system or status is not yet transmitted'; ?></td>
						</tr>
					<?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        </body>
    </html>
        