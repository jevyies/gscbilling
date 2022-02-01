<?php 
    header('Content-type: application/excel');
    $filename = 'Jeep Standard Report -'. date('mdY') .'.xls';
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
				/* odd-footer-name: html_myFooter; */
			}
			
			h1.bigsection {
					page-break-before: always;
					page: bigger;
			}

			.main_t td, th{
				font-size: 90%;
				border:1px solid black;
				padding: 2px;
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
			.main_t{
				margin-bottom: 30px;
			}
		</style>
		<body>
			<?php if($records != 'fail'): ?>
			<table width="100%">
				<tr>
					<td colspan="14" style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</td>
				</tr>
				<tr>
					<td colspan="14" style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="background:lightgreen;">
						<th style="padding:5px 0;width:8%">BILLED DATE</th>
						<th style="padding:5px 0;width:10%">OVL / DELIVERY RECEIPT</th>
						<th style="padding:5px 0;width:8%">CHARGE INVOICE NO.</th>
						<th style="padding:5px 0;width:10%">DESCRIPTION</th>
						<th style="padding:5px 0;width:8%">BILLED TO</th>
						<th style="padding:5px 0;width:8%">BILLED AMOUNT</th>
						<th style="padding:5px 0;width:8%">COLLECTION</th>
						<th style="padding:5px 0;width:8%">CHECK NO.</th>
						<th style="padding:5px 0;width:8%">CHECK DATE</th>
						<th style="padding:5px 0;width:8%">PO No</th>
						<th style="padding:5px 0;width:8%">Ref. No</th>
						<th style="padding:5px 0;width:8%">OR. No</th>
						<th style="padding:5px 0;width:8%">BALANCE</th>
						<th style="padding:5px 0;width:8%">STATUS</th>
					</tr>
				</thead>
				<tbody>
                    <?php foreach($records as $record): ?>
                        <?php $balance = $record->BillAmount - $record->CollectedAmount; ?>
                        <tr>
                            <td class="text-center"><?php echo $record->JVLDate; ?></td>
                            <td class="text-center"><?php echo $record->OVLNo; ?></td>
                            <td class="text-center"><?php echo $record->GLCode; ?></td>
                            <td class="text-center"><?php echo $record->JeepPlateNo; ?></td>
                            <td class="text-center"><?php echo 'DMPI'; ?></td>
                            <td class="text-right"><?php echo number_format((float)$record->BillAmount, 2, '.', ','); ?></td>
                            <td class="text-right"><?php echo number_format((float)$record->CollectedAmount, 2, '.', ','); ?></td>
                            <td class="text-center"><?php echo $record->CheckNumber; ?></td>
                            <td class="text-center"><?php echo $record->CheckDate; ?></td>
                            <td class="text-center"><?php echo $record->PONo; ?></td>
                            <td class="text-center"><?php echo $record->RefNo; ?></td>
                            <td class="text-center"><?php echo $record->ORNo; ?></td>
                            <td class="text-right"><?php echo number_format((float)$balance, 2, '.', ','); ?></td>
                            <td class="text-center" ><?php echo $balance > 0 ? 'UNPAID' : 'PAID'; ?></td>
                        </tr>
					<?php endforeach; ?>
				</tbody>
			</table>
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