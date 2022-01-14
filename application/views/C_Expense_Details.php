<?php 
    header('Content-type: application/excel');
    $filename = 'ExpenseDetails-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	$total_dm = 0;
	$total_o = 0;
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

			td {
				font-size: 100%;
				padding:5px;
				/* border: 1px solid black; */
			}

			.padding-none {
				padding:none;
			}
	
			@page { sheet-size: Legal; }
			
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
					<td style="width:100%;text-align:center;">
						<h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
						<h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
						<h3 style="text-align:center;text-decoration:underline;">Expense Detail</h3>
					</td>
				</tr>
			</table><br><br>
			<h4><b>Project Name: <?php echo $records['project_name']; ?></b></h4>
			<?php //var_dump(count($records)); ?>
			<table width="100%" class="main_t">
				<tr>
					<th>DATE</th>
					<th>REFERENCE #</th>
					<th>SUPPLIER</th>
					<th>DESCRIPTION</th>
					<th>QTY</th>
					<th>UOM</th>
					<th>UNIT COST</th>
					<th>DISCOUNT</th>
					<th>AMOUNT</th>
					<th>REMARKS</th>
				</tr>
				<?php if(count($records['direcr_materials']) > 0): ?>
					<tr>
						<td colspan="10">DIRECT MATERIALS</td>
					</tr>
					<?php foreach($records['direcr_materials'] as $dm): ?>
						<tr>
							<td style=""><?php echo date('m-d-Y', strtotime($dm->date)); ?></td>
							<td style=""><?php echo $dm->reference; ?></td>
							<td style=""><?php echo $dm->supplier; ?></td>
							<td style=""><?php echo $dm->description; ?></td>
							<td style=""><?php echo $dm->qty; ?></td>
							<td style=""><?php echo $dm->uom; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$dm->price, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$dm->discount, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$dm->amtdue, 2, '.', ','); ?></td>
							<td style=""><?php echo $dm->remarks; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				<?php if(count($records['overhead']) > 0): ?>
					<tr>
						<td colspan="10">OVERHEAD</td>
					</tr>
					<?php foreach($records['overhead'] as $o): ?>
						<tr>
							<td style=""><?php echo date('m-d-Y', strtotime($o->date)); ?></td>
							<td style=""><?php echo $o->reference; ?></td>
							<td style=""><?php echo $o->supplier; ?></td>
							<td style=""><?php echo $o->description; ?></td>
							<td style=""><?php echo $o->qty; ?></td>
							<td style=""><?php echo $o->uom; ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$o->price, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$o->discount, 2, '.', ','); ?></td>
							<td style="text-align:right;"><?php echo number_format((float)$o->amtdue, 2, '.', ','); ?></td>
							<td style=""><?php echo $o->remarks; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
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