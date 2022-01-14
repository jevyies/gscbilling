<?php 
    header('Content-type: application/excel');
    $filename = 'Volume Report From '. $from .' to '.$to.'.xls';
	header('Content-Disposition: attachment; filename='.$filename);

	$total = 0;
?>
	<html xmlns:x="urn:schemas-microsoft-com:office:excel">
		<head>
		</head>
		<style>
			body {
				font-family: 'Arial Black';
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
					<!-- <td style="width:20%;"><img src="gsclogo.png" alt="GSC Logo" style="width:8%;"></td> -->
					<td style="width:120%;text-align:center;" colspan="8">
						<h1 style="text-align:center;">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</h1>
						<h4 style="text-align:center;">BORJA ROAD, DAMILAG, MANOLO FORTICH, BUKIDNON</h4>
						<br>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:left;"><h3><br><br>Date From: <?php echo $from; ?> To <?php echo $to; ?><b><br></h3></td>
				</tr>
			</table>
			<table width="100%" class="main_t">
				<thead>
					<tr style="border: 1px solid black;">
						<th style="width:10%;padding:20px 0;">DATE PERFORMED</th>
						<th style="width:10%;padding:20px 0;">Volume Type</th>
						<th style="width:10%;padding:20px 0;">Control No</th>
						<th style="width:10%;padding:20px 0;">PO Number</th>
						<th style="width:10%;padding:20px 0;">DESCRIPTION</th>
						<th style="width:10%;padding:20px 0;">Quantity</th>
						<th style="width:10%;padding:20px 0;">Unit</th>
						<th style="width:15%;padding:20px 0;">Rate</th>
                        <th style="width:15%;padding:20px 0;">Net Value</th>
					</tr>
				</thead>
				<tbody>
                    <?php foreach($records as $record): ?>
                    <?php 
                        if($record->volumeType == 1){
                            $volume = 'CHECK DAM';
                        }elseif($record->volumeType == 2){
                            $volume = 'DAIRY';
                        }else{
                            $volume = 'PAPAYA';
                        }
                    ?>
					<tr style="border: 1px solid black;">
						<td style="text-align:center;"><?php echo $record->datePerformed;  ?></td>
						<td style="text-align:center;"><?php  echo $volume; ?></td>
						<td style="text-align:center;"><?php  echo $record->controlNo; ?></td>
						<td style="text-align:center;"><?php echo $record->poNumber; ?></td>
						<td style="text-align:center;"><?php echo $record->activity; ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->qty, 2, '.', ','); ?></td>
						<td style="text-align:center;"><?php echo $record->unit; ?></td>
                        <td style="text-align:right;"><?php echo number_format($record->rate, 2, '.', ','); ?></td>
                        <td style="text-align:right;"><?php echo  number_format($record->amount, 2, '.', ','); ?></td>
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