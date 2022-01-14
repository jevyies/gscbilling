<?php 
	header('Content-type: application/excel');
    $filename = 'VanRental Standard Report -'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
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
					<td style="width:100%;text-align:center;" colspan="14">
						<h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
						<h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
					</td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="background:lightgreen;">
						<th style="padding:20px 0;width:8%">BILLED DATE</th>
						<!-- <th style="padding:20px 0;width:10%">DELIVERY RECEIPT</th> -->
						<th style="padding:20px 0;width:8%">CHARGE INVOICE NO.</th>
						<th style="padding:20px 0;width:10%">DESCRIPTION</th>
						<th style="padding:20px 0;width:8%">BILLED AMOUNT</th>
						<th style="padding:20px 0;width:8%">COLLECTION</th>
						<th style="padding:20px 0;width:8%">CHECK NO.</th>
						<th style="padding:20px 0;width:8%">CHECK DATE</th>
						<th style="padding:20px 0;width:8%">PO No</th>
						<th style="padding:20px 0;width:8%">OR. No</th>
						<th style="padding:20px 0;width:8%">BALANCE</th>
						<th style="padding:20px 0;width:8%">STATUS</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($records as $record): ?>
						<?php $collection = $record->collected > $record->amount ? $record->amount : $record->collected; ?>
						<?php $balance = $record->amount - $collection; ?>
						<tr style="border:1px solid black;">
							<td style="text-align:center;"><?php echo $record->date; ?></td>
							<!-- <td style="text-align:center;"><?php echo ''; ?></td> -->
							<td style="text-align:center;"><?php echo $record->invoice_no; ?></td>
							<td style="text-align:center;"><?php echo $record->vehicle_name; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$record->amount, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$collection, 2, '.', ','); ?></td>
							<td style="text-align:center;"><?php echo $record->check_no; ?></td>
							<td style="text-align:center;"><?php echo $record->check_date; ?></td>
							<td style="text-align:center;"><?php echo $record->po_no; ?></td>
							<td style="text-align:center;"><?php echo $record->ref_no; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$balance, 2, '.', ','); ?></td>
							<td style="text-align:center;"><?php echo $balance > 0 ? 'UNPAID' : 'PAID'; ?></td>
						</tr>
					<?php endforeach; ?>
					<?php foreach($monthly as $rec): ?>
						<?php $collection = $rec->collected > $rec->amount ? $rec->amount : $rec->collected; ?>
						<?php $balance = $rec->amount - $collection; ?>
						<tr style="border:1px solid black;">
							<td style="text-align:center;"><?php echo $rec->req_date; ?></td>
							<!-- <td style="text-align:center;"><?php echo ''; ?></td> -->
							<td style="text-align:center;"><?php echo $rec->charge_invoice_no; ?></td>
							<td style="text-align:center;"><?php echo $rec->particulars; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$rec->amount, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$collection, 2, '.', ','); ?></td>
							<td style="text-align:center;"><?php echo $rec->check_no; ?></td>
							<td style="text-align:center;"><?php echo $rec->check_date; ?></td>
							<td style="text-align:center;"><?php echo $rec->po_no; ?></td>
							<td style="text-align:center;"><?php echo $rec->ref_no; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$balance, 2, '.', ','); ?></td>
							<td style="text-align:center;"><?php echo $balance > 0 ? 'UNPAID' : 'PAID'; ?></td>
						</tr>
					<?php endforeach; ?>
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