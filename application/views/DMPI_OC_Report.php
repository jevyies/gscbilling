<?php 
header('Content-type: application/excel');
$filename = 'GSC Transmittal Billing -'. date('mdY') .'.xls';
header('Content-Disposition: attachment; filename='.$filename);
foreach($records as $record){
    $prepared_by = $record->preparedBy;
    $prepared_by_pos = $record->preparedByPosition;
    $confirmed_by = $record->confirmedBy;
    $confirmed_by_pos = $record->confirmedByPosition;
    $approved_by = $record->approvedBy;
    $approved_by_pos = $record->approvedByPosition;
    $soaNumber = $record->soaNumber;
    $soaDate = $record->soaDate;
    $dateTransmitted = $record->TransmittedDate;
    $transmittalNo = $record->TransmittalNo;
    break;
}
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
				margin-left: .5cm;
				margin-right: .5cm;
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
	
		</style>
		<body>
            <table width="100%" style="margin-bottom:30px;">
                <tr>
                    <td style="border:none;">
                        <strong>GSMPC GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong>
                    </td>
                </tr>
                <tr>
                    <td style="border:none;"><strong>BORJA ROAD DAMILAG, MANOLO FORTICH,BUKIDNON</strong></td>
                </tr>
                <tr>
                    <td style="border:none;"><strong>TIN # 411-478-949</strong></td>
                </tr>
                <tr>
                    <td style="border:none;">Period Covered: <?php echo $period; ?></td>
                </tr>
                <tr>
                    <td style="border:none;">Date Transmitted: <?php echo date('F j, Y', strtotime($dateTransmitted)); ?> </td>
                </tr>
                <tr>
                    <td style="border:none;"><strong>TRANSMITTAL #: <?php echo $transmittalNo; ?> </td>
                </tr>
            </table>
            <table width="100%" style="margin-bottom:10px;">
                <thead>
                    <tr>
                        <th rowspan="2">ITEM #</th>
                        <th rowspan="2">DOCUMENT DATE</th>
                        <th rowspan="2">SOA NO</th>
                        <th rowspan="2">DATE TRANSMITTED TO OPERATION</th>
                        <th rowspan="2">DATE SIGNED BY SUPERVISOR</th>
                        <th rowspan="2">DATE SIGNED BY MANAGER</th>
                        <th rowspan="2">DATE RECEIVED DATA CONTROLLER</th>
                        <th rowspan="2">DATE RECEIVED BILLING CLERK</th>
                        <th rowspan="2">DATE RECEIVED BY DMPI ACCOUNTING</th>
                        <th rowspan="2">TRANSMITTAL NO</th>
                        <th rowspan="2">ACTIVITY</th>
                        <th rowspan="2">FIELD</th>
                        <th rowspan="2">HAS/TONS</th>
                        <th colspan="2">ACCOUNT TO CHARGE</th>
                        <th colspan="20">HOURS RENDERED</th>
                        <th colspan="20">RATES</th>
                        <th colspan="4">AMOUNT</th>
                        <th rowspan="2">TOTAL</th>

                        <th rowspan="2">HC</th>
                        <th rowspan="2">REMARKS</th>
                        <th rowspan="2">DEPARTMENT</th>
                        <th rowspan="2">GSMPC SOA NO.</th>
                        <th rowspan="2">ST</th>
                        <th rowspan="2">OT</th>
                        <th rowspan="2">ND</th>
                        <th rowspan="2">NDOT</th>
                        <th rowspan="2">HC</th>
                        <th rowspan="2">TOTAL</th>
                    </tr>
                    <tr>
                        <th>GL</th>
                        <th>CC</th>
                        <th>RD-ST</th>
                        <th>RD-OT</th>
                        <th>RD-ND</th>
                        <th>RD-NDOT</th>
                        <th>SHOL-ST</th>
                        <th>SHOL-OT</th>
                        <th>SHOL-ND</th>
                        <th>SHOL-NDOT</th>
                        <th>SHRD-ST</th>
                        <th>SHRD-OT</th>
                        <th>SHRD-ND</th>
                        <th>SHRD-NDOT</th>
                        <th>RHOL-ST</th>
                        <th>RHOL-OT</th>
                        <th>RHOL-ND</th>
                        <th>RHOL-NDOT</th>
                        <th>RHRD-ST</th>
                        <th>RHRD-OT</th>
                        <th>RHRD-ND</th>
                        <th>RHRD-NDOT</th>
                        <th>RD-ST</th>
                        <th>RD-OT</th>
                        <th>RD-ND</th>
                        <th>RD-NDOT</th>
                        <th>SHOL-ST</th>
                        <th>SHOL-OT</th>
                        <th>SHOL-ND</th>
                        <th>SHOL-NDOT</th>
                        <th>SHRD-ST</th>
                        <th>SHRD-OT</th>
                        <th>SHRD-ND</th>
                        <th>SHRD-NDOT</th>
                        <th>RHOL-ST</th>
                        <th>RHOL-OT</th>
                        <th>RHOL-ND</th>
                        <th>RHOL-NDOT</th>
                        <th>RHRD-ST</th>
                        <th>RHRD-OT</th>
                        <th>RHRD-ND</th>
                        <th>RHRD-NDOT</th>
                        <th>ST</th>
                        <th>OT</th>
                        <th>ND</th>
                        <th>NDOT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $No = 1; ?>
                    <?php $rdst_total = 0; ?>
                    <?php $rdot_total = 0; ?>
                    <?php $rdnd_total = 0; ?>
                    <?php $rdndot_total = 0; ?>

                    <?php $sholst_total = 0; ?>
                    <?php $sholot_total = 0; ?>
                    <?php $sholnd_total = 0; ?>
                    <?php $sholndot_total = 0; ?>

                    <?php $shrdst_total = 0; ?>
                    <?php $shrdot_total = 0; ?>
                    <?php $shrdnd_total = 0; ?>
                    <?php $shrdndot_total = 0; ?>

                    <?php $rholst_total = 0; ?>
                    <?php $rholot_total = 0; ?>
                    <?php $rholnd_total = 0; ?>
                    <?php $rholndot_total = 0; ?>

                    <?php $rhrdst_total = 0; ?>
                    <?php $rhrdot_total = 0; ?>
                    <?php $rhrdnd_total = 0; ?>
                    <?php $rhrdndot_total = 0; ?>
                    
                    <?php $total_st = 0; ?>
                    <?php $total_ot = 0; ?>
                    <?php $total_nd = 0; ?>
                    <?php $total_ndot = 0; ?>
                    <?php $total_amt = 0; ?>


                    <?php foreach($records as $record): ?>
                    <tr>
                        <td><?php echo $record->headerID; ?></td>
                        <td><?php echo date('F j, Y', strtotime($record->soaDate)); ?></td>
                        <td><?php echo $record->soaNumber; ?></td>
                        <td><?php echo date('F j, Y', strtotime($record->TransmittedDate)); ?></td>
                        <td><?php echo date('F j, Y', strtotime($record->SupervisorDate)); ?></td>
                        <td><?php echo date('F j, Y', strtotime($record->ManagerDate)); ?></td>
                        <td><?php echo date('F j, Y', strtotime($record->DataControllerDate)); ?></td>
                        <td><?php echo date('F j, Y', strtotime($record->BillingClerkDate)); ?></td>
                        <td><?php echo date('F j, Y', strtotime($record->DMPIReceivedDate)); ?></td>
                        <td><?php echo $record->TransmittalNo; ?></td>
                        <td><?php echo $record->activity; ?></td>
                        <td><?php echo $record->field; ?></td>
                        <td></td>
                        <td><?php echo $record->gl; ?></td>
                        <td><?php echo $record->cc; ?></td>
                        <td><?php echo $record->rdst; ?></td>
                        <td><?php echo $record->rdot; ?></td>
                        <td><?php echo $record->rdnd; ?></td>
                        <td><?php echo $record->rdndot; ?></td>
                        <td><?php echo $record->sholst; ?></td>
                        <td><?php echo $record->sholot; ?></td>
                        <td><?php echo $record->sholnd; ?></td>
                        <td><?php echo $record->sholndot; ?></td>
                        <td><?php echo $record->shrdst; ?></td>
                        <td><?php echo $record->shrdot; ?></td>
                        <td><?php echo $record->shrdnd; ?></td>
                        <td><?php echo $record->shrdndot; ?></td>
                        <td><?php echo $record->rholst; ?></td>
                        <td><?php echo $record->rholot; ?></td>
                        <td><?php echo $record->rholnd; ?></td>
                        <td><?php echo $record->rholndot; ?></td>
                        <td><?php echo $record->rhrdst; ?></td>
                        <td><?php echo $record->rhrdot; ?></td>
                        <td><?php echo $record->rhrdnd; ?></td>
                        <td><?php echo $record->rhrdndot; ?></td>
                        <td><?php echo $record->rd_st; ?></td>
                        <td><?php echo $record->rd_ot; ?></td>
                        <td><?php echo $record->rd_nd; ?></td>
                        <td><?php echo $record->rd_ndot; ?></td>
                        <td><?php echo $record->shol_st; ?></td>
                        <td><?php echo $record->shol_ot; ?></td>
                        <td><?php echo $record->shol_nd; ?></td>
                        <td><?php echo $record->shol_ndot; ?></td>
                        <td><?php echo $record->shrd_st; ?></td>
                        <td><?php echo $record->shrd_ot; ?></td>
                        <td><?php echo $record->shrd_nd; ?></td>
                        <td><?php echo $record->shrd_ndot; ?></td>
                        <td><?php echo $record->rhol_st; ?></td>
                        <td><?php echo $record->rhol_ot; ?></td>
                        <td><?php echo $record->rhol_nd; ?></td>
                        <td><?php echo $record->rhol_ndot; ?></td>
                        <td><?php echo $record->rhrd_st; ?></td>
                        <td><?php echo $record->rhrd_ot; ?></td>
                        <td><?php echo $record->rhrd_nd; ?></td>
                        <td><?php echo $record->rhrd_ndot; ?></td>
                        <td><?php echo number_format($record->c_totalst, 2, '.', ','); ?></td>
                        <td><?php echo number_format($record->c_totalot, 2, '.', ','); ?></td>
                        <td><?php echo number_format($record->c_totalnd, 2, '.', ','); ?></td>
                        <td><?php echo number_format($record->c_totalndot, 2, '.', ','); ?></td>
                        <td><?php echo number_format($record->c_totalAmt, 2, '.', ','); ?></td>

                        <td></td>
                        <td><?php echo $record->headCount; ?></td>
                        <td><?php echo $record->Location; ?></td>
                        <td><?php echo $record->soaDate; ?></td>
                        <td><?php echo $record->THW_ST; ?></td>
                        <td><?php echo $record->THW_OT; ?></td>
                        <td><?php echo $record->THW_ND; ?></td>
                        <td><?php echo $record->THW_NDOT; ?></td>
                        <td><?php echo $record->headCount; ?></td>
                        <td><?php echo $record->c_totalAmt; ?></td>

                        <?php $rdst_total = $rdst_total + $record->rdst; ?>
                        <?php $rdot_total = $rdot_total + $record->rdot; ?>
                        <?php $rdnd_total = $rdnd_total + $record->rdnd; ?>
                        <?php $rdndot_total = $rdndot_total + $record->rdndot; ?>

                        <?php $sholst_total = $sholst_total + $record->sholst; ?>
                        <?php $sholot_total = $sholot_total + $record->sholot; ?>
                        <?php $sholnd_total = $sholnd_total + $record->sholnd; ?>
                        <?php $sholndot_total = $sholndot_total + $record->rdndot; ?>

                        <?php $shrdst_total = $shrdst_total + $record->shrdst; ?>
                        <?php $shrdot_total = $shrdot_total + $record->shrdot; ?>
                        <?php $shrdnd_total = $shrdnd_total + $record->shrdst; ?>
                        <?php $shrdndot_total = $shrdndot_total + $record->rdndot; ?>

                        <?php $rholst_total = $rholst_total + $record->rholst; ?>
                        <?php $rholot_total = $rholot_total + $record->rholot; ?>
                        <?php $rholnd_total = $rholnd_total + $record->rholnd; ?>
                        <?php $rholndot_total = $rholndot_total + $record->rdndot; ?>

                        <?php $rhrdst_total = $rhrdst_total + $record->rhrdst; ?>
                        <?php $rhrdot_total = $rhrdot_total + $record->rhrdot; ?>
                        <?php $rhrdnd_total = $rhrdnd_total + $record->rhrdnd; ?>
                        <?php $rhrdndot_total = $rhrdndot_total + $record->rhrdndot; ?>

                        <?php $total_st = $total_st + $record->c_totalst; ?>
                        <?php $total_ot = $total_ot + $record->c_totalot; ?>
                        <?php $total_nd = $total_nd + $record->c_totalnd; ?>
                        <?php $total_ndot = $total_ndot + $record->c_totalndot; ?>
                        <?php $total_amt = $total_amt + $record->c_totalAmt; ?>
                    </tr>
                    <?php $No++; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="14" style="text-align:right;border:none">Total</td>

                        <td><?php echo $rdst_total; ?></td>
                        <td><?php echo $rdot_total; ?></td>
                        <td><?php echo $rdnd_total; ?></td>
                        <td><?php echo $rdndot_total; ?></td>

                        <td><?php echo $sholst_total; ?></td>
                        <td><?php echo $sholot_total; ?></td>
                        <td><?php echo $sholnd_total; ?></td>
                        <td><?php echo $sholndot_total; ?></td>

                        <td><?php echo $shrdst_total; ?></td>
                        <td><?php echo $shrdot_total; ?></td>
                        <td><?php echo $shrdnd_total; ?></td>
                        <td><?php echo $shrdndot_total; ?></td>

                        <td><?php echo $rholst_total; ?></td>
                        <td><?php echo $rholot_total; ?></td>
                        <td><?php echo $rholnd_total; ?></td>
                        <td><?php echo $rholndot_total; ?></td>

                        <td><?php echo $rhrdst_total; ?></td>
                        <td><?php echo $rhrdot_total; ?></td>
                        <td><?php echo $rhrdnd_total; ?></td>
                        <td><?php echo $rhrdndot_total; ?></td>

                        <td colspan="20" style="border:none"></td>

                        <td><?php echo number_format($total_st, 2, '.', ','); ?></td>
                        <td><?php echo number_format($total_ot, 2, '.', ','); ?></td>
                        <td><?php echo number_format($total_nd, 2, '.', ','); ?></td>
                        <td><?php echo number_format($total_ndot, 2, '.', ','); ?></td>
                        <td><?php echo number_format($total_amt, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
            <table width="100%">
                <tr>
                    <td style="border:none">PREPARED BY:</td>
                </tr>
                <tr>
                    <td style="border:none;"><?php echo $prepared_by; ?></td>
                </tr>
                <tr>
                    <td style="border:none;"><?php echo $prepared_by_pos; ?></td>
                </tr>
                <tr>
                    <td style="border:none">RECEIVED BY:</td>
                </tr>
                <tr>
                    <td style="border:none;"><?php echo $prepared_by; ?></td>
                </tr>
                <tr>
                    <td style="border:none;"><?php echo $prepared_by_pos; ?></td>
                </tr>
            </table>
        </body>
</html>
