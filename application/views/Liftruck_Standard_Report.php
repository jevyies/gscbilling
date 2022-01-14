<?php 
	header('Content-type: application/excel');
    $filename = 'LiftTruck Standard Report -'. date('mdY') .'.xls';
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
						<th style="padding:20px 0;width:10%">SOA / DELIVERY RECEIPT</th>
						<th style="padding:20px 0;width:8%">CHARGE INVOICE NO.</th>
						<th style="padding:20px 0;width:10%">DESCRIPTION</th>
						<th style="padding:20px 0;width:8%">BILLED TO</th>
						<th style="padding:20px 0;width:8%">BILLED AMOUNT</th>
						<th style="padding:20px 0;width:8%">COLLECTION</th>
						<th style="padding:20px 0;width:8%">CHECK NO.</th>
						<th style="padding:20px 0;width:8%">CHECK DATE</th>
						<th style="padding:20px 0;width:8%">PO No</th>
						<th style="padding:20px 0;width:8%">Ref. No</th>
						<th style="padding:20px 0;width:8%">OR. No</th>
						<th style="padding:20px 0;width:8%">BALANCE</th>
						<th style="padding:20px 0;width:8%">STATUS</th>
					</tr>
				</thead>
				<tbody>
                    <?php foreach($records as $record): ?>
                        <?php 
                            $last_amount = 0;
                            $last_check_card_no = '';
                            $last_payment_date = '';
                            $last_or_ref_no = '';
                         ?>
                        <?php $balance = $record->BilledAmount; ?>
                        <?php $total_balance = $record->BilledAmount - $record->CollectedAmount; ?>
                        <?php 
                            foreach($record->payments as $payment): 
                                $last_id = $payment->id;
                                $last_mode = $payment->mode;
                                $last_payment_date = $payment->payment_date;
                                $last_or_ref_no = $payment->or_ref_no;
                                $last_check_card_no = $payment->check_card_no;
                                $last_check_card_bank_name = $payment->check_card_bank_name;
                                $last_amount = $payment->amount;
                                $balance = $balance - $last_amount;
                                break;
                            endforeach; 
                        ?>
                        <tr>
                            <td class="text-center" rowspan="<?php echo count($record->payments); ?>"><?php echo $record->soa_date; ?></td>
                            <td class="text-center" rowspan="<?php echo count($record->payments); ?>"><?php echo $record->series_no; ?></td>
                            <td class="text-center" rowspan="<?php echo count($record->payments); ?>"><?php echo $record->charge_invoice_no; ?></td>
                            <td class="text-center" rowspan="<?php echo count($record->payments); ?>"><?php echo $record->details; ?></td>
                            <td class="text-center" rowspan="<?php echo count($record->payments); ?>"><?php echo $record->billed_name; ?></td>
                            <td class="text-right" rowspan="<?php echo count($record->payments); ?>"><?php echo number_format((float)$record->BilledAmount, 2, '.', ','); ?></td>
                            <td class="text-right"><?php echo number_format((float)$last_amount, 2, '.', ','); ?></td>
                            <td class="text-center"><?php echo $last_check_card_no; ?></td>
                            <td class="text-center"><?php echo $last_payment_date; ?></td>
                            <td class="text-center"></td>
                            <td class="text-center"><?php echo $last_or_ref_no; ?></td>
                            <td class="text-center"></td>
                            <td class="text-right"><?php echo number_format((float)$balance, 2, '.', ','); ?></td>
                            <td class="text-center" rowspan="<?php echo count($record->payments); ?>"><?php echo $total_balance > 0 ? 'UNPAID' : 'PAID'; ?></td>
                            <?php if(count($record->payments) > 1): ?>
                                <?php foreach($record->payments as $payment): ?>
                                    <?php if($last_id != $payment->id): ?>
                                        <?php $balance = $balance - $payment->amount; ?>
                                        <tr>
                                            <td class="text-right"><?php echo number_format((float)$payment->amount, 2, '.', ','); ?></td>
                                            <td class="text-center"><?php echo $payment->check_card_no; ?></td>
                                            <td class="text-center"><?php echo $payment->payment_date; ?></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"><?php echo $payment->or_ref_no; ?></td>
                                            <td class="text-center"></td>
                                            <td class="text-right"><?php echo number_format((float)$balance, 2, '.', ','); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php $last_id = $payment->id; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
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