<?php 
    header('Content-type: application/excel');
    $filename = 'BCCLetterhead-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	if($records){
		foreach($records as $record){
			$date = $record->date_created;
			$letter_to = $record->letter_to;
			$SOANo = $record->SOANo;
			$Total_Billing = $record->Total_Billing;
			$admin_percentage = $record->admin_percentage;
			$body = $record->body;
			$body2 = $record->body2;
			$Prepared_by = $record->Prepared_by;
			$Noted_by = $record->Noted_by;
			$Checked_by = $record->Checked_by;
			$Approved_by = $record->Approved_by;
			break;
		}
	}
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
	
			@page { sheet-size: Letter; }
			
			@page {
				margin-top: 1cm;
				margin-bottom: 1cm;
				margin-left: 3cm;
				margin-right: 3cm;
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
			<?php if($records): ?>
			<table width="100%" style="margin-bottom:10%;">
				<tr>
					<td style="border:none;padding:0px;text-align:right;width:25%;border-bottom:3px solid black;padding-bottom:10px;" rowspan="3">
						<img style="width:100px;height:80px;" src="<?php echo base_url(); ?>assets/images/logo.png">
					</td>
					<td style="border:none;width:70%;text-align:center;font-size:130%;"><strong>GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong></td>
					<td style="border:none;"></td>
				</tr>
				<tr>
					<td style="border:none;text-align:center;font-size:110%;">Borja Road, Damilag, Manolo Fortich, Bukidnon</td>
					<td style="border:none;"></td>
				</tr>
				<tr>
					<td style="border:none;text-align:center;border-bottom:3px solid black;padding-bottom:10px;">TIN # : 411-478-949</td>
					<td style="border:none;border-bottom:3px solid black;padding-bottom:10px;"></td>
				</tr>
			</table>
			<h4><?php echo date('F j, Y', strtotime($date)); ?></h4>
			<br>
			<br>
			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="width:10%;padding-bottom:45px;">TO:</td>
					<td style="width:90%;"><?php echo $letter_to; ?></td>
				</tr>
				<tr>
					<td colspan="2"><br><br><?php echo $body; ?></td>
				</tr>
			</table>
			<br>
			<br>
			<br>
			<?php if($records): ?>
			<table width="100%">
				<tr>
					<td style="width:80%;font-size:120%;"><?php echo $SOANo; ?></td>
					<td style="width:20%;text-align:right;font-size:120%;"><?php echo number_format($Total_Billing, 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td style="width:60%;font-size:120%;">AMOUNTING TO: </td>
					<td style="width:35%;text-align:right;font-weight:bold;border-top:3px solid black;font-size:120%;">Php <?php echo number_format($Total_Billing, 2, '.', ','); ?></td>
				</tr>
				<?php if($admin_percentage != 0): ?>
				<tr>
					<td style="width:60%;text-align:right;"><?php echo $admin_percentage ?>% Admin Fee: </td>
					<td style="width:35%;text-align:right;font-weight:bold;">Php <?php echo number_format($Total_Billing * ($admin_percentage/100), 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td style="width:60%;font-size:120%;text-align:right;">TOTAL BILLED: </td>
					<td style="width:35%;text-align:right;font-weight:bold;font-size:120%;">Php <?php echo number_format($Total_Billing + ($Total_Billing * ($admin_percentage/100)), 2, '.', ','); ?></td>
				</tr>
				<?php endif; ?>
			</table>
			<?php endif; ?>
			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="width:100%;"><?php echo $body2; ?></td>
				</tr>
			</table>
			<br>
			<br>
			<br>
			<br>
			<table width="100%">
				<tr>
					<td style="width:30%;">Prepared By:</td>
					<td></td>
					<td style="width:30%;">Noted By:</td>
					<td></td>
					<td style="width:30%;">Checked By:</td>
				</tr>
				<tr>
					<td style="width:30%;"><br><?php echo strtoupper($Prepared_by); ?></td>
					<td></td>
					<td style="width:30%;"><br><?php echo strtoupper($Noted_by); ?></td>
					<td></td>
					<td style="width:30%;"><br><?php echo strtoupper($Checked_by); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><br><br><br>Approved By:</td>
					<td></td>
					<td style="width:30%;"></td>
					<td></td>
					<td style="width:30%;"></td>
				</tr>
				<tr>
					<td style="width:30%;"><br><?php echo strtoupper($Approved_by); ?></td>
					<td></td>
					<td style="width:30%;"></td>
					<td></td>
					<td style="width:30%;"></td>
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