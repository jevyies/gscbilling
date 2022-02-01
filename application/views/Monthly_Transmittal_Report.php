<?php 
header('Content-type: application/excel');
$filename = 'GSC Transmittal Billing -'. date('mdY') .'.xls';
header('Content-Disposition: attachment; filename='.$filename);
// $transmittalNo = '';
// $last_transmittal = '';
// foreach($records as $record){
//     if(strtoupper($last_transmittal) != strtoupper($record['TransmittalNo'])){
//         $transmittalNo = strtoupper($record['TransmittalNo']).', '.$transmittalNo;
//     }
//     $last_transmittal = strtoupper($record['TransmittalNo']);
// }
// $TransmittalNumbers = rtrim($transmittalNo, ", ");
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
                <!-- <?php //if($from !== ''): ?>
                    <tr>
                        <td style="border:none;">Period Covered: <?php //echo $period; ?></td>
                    </tr>
                <?php //endif; ?>
                <tr>
                    <td style="border:none;"><strong>TRANSMITTAL #: <?php //echo $TransmittalNumbers; ?> </td>
                </tr> -->
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
                        <th colspan="5">ACCOUNT TO CHARGE</th>
                        <th colspan="24">HOURS RENDERED</th>
                        <th colspan="24">RATES</th>
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
                        <th>CCC</th>
                        <th>IOA</th>
                        <th>IOC</th>
                        <th>RD-ST</th>
                        <th>RD-OT</th>
                        <th>RD-ND</th>
                        <th>RD-NDOT</th>
                        <th>SHOL-ST</th>
                        <th>SHOL-OT</th>
                        <th>SHOL-ND</th>
                        <th>SHOL-NDOT</th>
                        <th>RHOL-ST</th>
                        <th>RHOL-OT</th>
                        <th>RHOL-ND</th>
                        <th>RHOL-NDOT</th>
                        <th>RT-ST</th>
                        <th>RT-OT</th>
                        <th>RT-ND</th>
                        <th>RT-NDOT</th>
                        <th>SHRD-ST</th>
                        <th>SHRD-OT</th>
                        <th>SHRD-ND</th>
                        <th>SHRD-NDOT</th>
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
                        <th>RHOL-ST</th>
                        <th>RHOL-OT</th>
                        <th>RHOL-ND</th>
                        <th>RHOL-NDOT</th>
                        <th>RT-ST</th>
                        <th>RT-OT</th>
                        <th>RT-ND</th>
                        <th>RT-NDOT</th>
                        <th>SHRD-ST</th>
                        <th>SHRD-OT</th>
                        <th>SHRD-ND</th>
                        <th>SHRD-NDOT</th>
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
                    <?php foreach($records as $hdr): ?>
                        <?php $row_number = count($hdr['dtls']); ?>
                        <?php $dtl_no = 1; ?>
                        <?php $rdst_total = 0; ?>
                        <?php $rdot_total = 0; ?>
                        <?php $rdnd_total = 0; ?>
                        <?php $rdndot_total = 0; ?>

                        <?php $rtst_total = 0; ?>
                        <?php $rtot_total = 0; ?>
                        <?php $rtnd_total = 0; ?>
                        <?php $rtndot_total = 0; ?>

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
                        <?php $total_hc = 0; ?>
                        <?php foreach($hdr['dtls'] as $record): ?>
                            <?php if($dtl_no != $row_number): ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo date('m/d/y', strtotime($record->soaDate)); ?></td>
                                    <td><?php echo $record->soaNumber; ?></td>
                                    <td><?php echo $record->TransmittedDate !== '0000-00-00' ? date('m/d/y', strtotime($record->TransmittedDate)) : ''; ?></td>
                                    <td><?php echo $record->SupervisorDate !== '0000-00-00' ? date('m/d/y', strtotime($record->SupervisorDate)) : ''; ?></td>
                                    <td><?php echo $record->ManagerDate !== '0000-00-00' ? date('m/d/y', strtotime($record->ManagerDate)) : ''; ?></td>
                                    <td><?php echo $record->DataControllerDate !== '0000-00-00' ? date('m/d/y', strtotime($record->DataControllerDate)) : ''; ?></td>
                                    <td><?php echo $record->BillingClerkDate !== '0000-00-00' ? date('m/d/y', strtotime($record->BillingClerkDate)) : ''; ?></td>
                                    <td><?php echo $record->DMPIReceivedDate !== '0000-00-00' ? date('m/d/y', strtotime($record->DMPIReceivedDate)) : ''; ?></td>
                                    <td><?php echo $record->TransmittalNo; ?></td>
                                    <td><?php echo $record->activity; ?></td>
                                    <td><?php echo $record->field; ?></td>
                                    <td></td>
                                    <td><?php echo $record->gl; ?></td>
                                    <td><?php echo $record->cc; ?></td>
                                    <td><?php echo $record->ccc; ?></td>
                                    <td><?php echo $record->ioa; ?></td>
                                    <td><?php echo $record->ioc; ?></td>
                                    <td><?php echo $record->rdst; ?></td>
                                    <td><?php echo $record->rdot; ?></td>
                                    <td><?php echo $record->rdnd; ?></td>
                                    <td><?php echo $record->rdndot; ?></td>
                                    <td><?php echo $record->sholst; ?></td>
                                    <td><?php echo $record->sholot; ?></td>
                                    <td><?php echo $record->sholnd; ?></td>
                                    <td><?php echo $record->sholndot; ?></td>
                                    <td><?php echo $record->rholst; ?></td>
                                    <td><?php echo $record->rholot; ?></td>
                                    <td><?php echo $record->rholnd; ?></td>
                                    <td><?php echo $record->rholndot; ?></td>
                                    <td><?php echo $record->rtst; ?></td>
                                    <td><?php echo $record->rtot; ?></td>
                                    <td><?php echo $record->rtnd; ?></td>
                                    <td><?php echo $record->rtndot; ?></td>
                                    <td><?php echo $record->shrdst; ?></td>
                                    <td><?php echo $record->shrdot; ?></td>
                                    <td><?php echo $record->shrdnd; ?></td>
                                    <td><?php echo $record->shrdndot; ?></td>
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
                                    <td><?php echo $record->rhol_st; ?></td>
                                    <td><?php echo $record->rhol_ot; ?></td>
                                    <td><?php echo $record->rhol_nd; ?></td>
                                    <td><?php echo $record->rhol_ndot; ?></td>
                                    <td><?php echo $record->rt_st; ?></td>
                                    <td><?php echo $record->rt_ot; ?></td>
                                    <td><?php echo $record->rt_nd; ?></td>
                                    <td><?php echo $record->rt_ndot; ?></td>
                                    <td><?php echo $record->shrd_st; ?></td>
                                    <td><?php echo $record->shrd_ot; ?></td>
                                    <td><?php echo $record->shrd_nd; ?></td>
                                    <td><?php echo $record->shrd_ndot; ?></td>
                                    <td><?php echo $record->rhrd_st; ?></td>
                                    <td><?php echo $record->rhrd_ot; ?></td>
                                    <td><?php echo $record->rhrd_nd; ?></td>
                                    <td><?php echo $record->rhrd_ndot; ?></td>
                                    <!-- <td><?php //echo number_format($record->rdst + $record->sholst + $record->shrdst + $record->rholst + $record->rhrdst, 2, '.', ','); ?></td>
                                    <td><?php //echo number_format($record->rdot + $record->sholot + $record->shrdot + $record->rholot + $record->rhrdot, 2, '.', ','); ?></td>
                                    <td><?php //echo number_format($record->rdnd + $record->sholnd + $record->shrdnd + $record->rholnd + $record->rhrdnd, 2, '.', ','); ?></td>
                                    <td><?php //echo number_format($record->rdndot + $record->sholndot + $record->shrdndot + $record->rholndot + $record->rhrdndot, 2, '.', ','); ?></td> -->
                                    <td><?php echo number_format($record->c_totalst, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($record->c_totalot, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($record->c_totalnd, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($record->c_totalndot, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($record->c_totalAmt, 2, '.', ','); ?></td>
                                    <td><?php echo $record->headCount; ?></td>
                                    <td></td>
                                    <td><?php echo $record->Location; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <?php $rdst_total = $rdst_total + $record->rdst; ?>
                                    <?php $rdot_total = $rdot_total + $record->rdot; ?>
                                    <?php $rdnd_total = $rdnd_total + $record->rdnd; ?>
                                    <?php $rdndot_total = $rdndot_total + $record->rdndot; ?>

                                    <?php $rtst_total = $rtst_total + $record->rtst; ?>
                                    <?php $rtot_total = $rtot_total + $record->rtot; ?>
                                    <?php $rtnd_total = $rtnd_total + $record->rtnd; ?>
                                    <?php $rtndot_total = $rtndot_total + $record->rtndot; ?>

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
                                    <?php $total_hc = $total_hc + $record->headCount; ?>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <?php $rdst_total = $rdst_total + $record->rdst; ?>
                                    <?php $rdot_total = $rdot_total + $record->rdot; ?>
                                    <?php $rdnd_total = $rdnd_total + $record->rdnd; ?>
                                    <?php $rdndot_total = $rdndot_total + $record->rdndot; ?>

                                    <?php $rtst_total = $rtst_total + $record->rtst; ?>
                                    <?php $rtot_total = $rtot_total + $record->rtot; ?>
                                    <?php $rtnd_total = $rtnd_total + $record->rtnd; ?>
                                    <?php $rtndot_total = $rtndot_total + $record->rtndot; ?>

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
                                    <?php $total_hc = $total_hc + $record->headCount; ?>

                                    <td><?php echo $No; ?></td>
                                    <td><?php echo date('m/d/y', strtotime($record->soaDate)); ?></td>
                                    <td><?php echo $record->soaNumber; ?></td>
                                    <td><?php echo $record->TransmittedDate !== '0000-00-00' ? date('m/d/y', strtotime($record->TransmittedDate)) : ''; ?></td>
                                    <td><?php echo $record->SupervisorDate !== '0000-00-00' ? date('m/d/y', strtotime($record->SupervisorDate)) : ''; ?></td>
                                    <td><?php echo $record->ManagerDate !== '0000-00-00' ? date('m/d/y', strtotime($record->ManagerDate)) : ''; ?></td>
                                    <td><?php echo $record->DataControllerDate !== '0000-00-00' ? date('m/d/y', strtotime($record->DataControllerDate)) : ''; ?></td>
                                    <td><?php echo $record->BillingClerkDate !== '0000-00-00' ? date('m/d/y', strtotime($record->BillingClerkDate)) : ''; ?></td>
                                    <td><?php echo $record->DMPIReceivedDate !== '0000-00-00' ? date('m/d/y', strtotime($record->DMPIReceivedDate)) : ''; ?></td>
                                    <td><?php echo $record->TransmittalNo; ?></td>
                                    <td><?php echo $record->activity; ?></td>
                                    <td><?php echo $record->field; ?></td>
                                    <td></td>
                                    <td><?php echo $record->gl; ?></td>
                                    <td><?php echo $record->cc; ?></td>
                                    <td><?php echo $record->ccc; ?></td>
                                    <td><?php echo $record->ioa; ?></td>
                                    <td><?php echo $record->ioc; ?></td>
                                    <td><?php echo $record->rdst; ?></td>
                                    <td><?php echo $record->rdot; ?></td>
                                    <td><?php echo $record->rdnd; ?></td>
                                    <td><?php echo $record->rdndot; ?></td>
                                    <td><?php echo $record->sholst; ?></td>
                                    <td><?php echo $record->sholot; ?></td>
                                    <td><?php echo $record->sholnd; ?></td>
                                    <td><?php echo $record->sholndot; ?></td>
                                    <td><?php echo $record->rholst; ?></td>
                                    <td><?php echo $record->rholot; ?></td>
                                    <td><?php echo $record->rholnd; ?></td>
                                    <td><?php echo $record->rholndot; ?></td>
                                    <td><?php echo $record->rtst; ?></td>
                                    <td><?php echo $record->rtot; ?></td>
                                    <td><?php echo $record->rtnd; ?></td>
                                    <td><?php echo $record->rtndot; ?></td>
                                    <td><?php echo $record->shrdst; ?></td>
                                    <td><?php echo $record->shrdot; ?></td>
                                    <td><?php echo $record->shrdnd; ?></td>
                                    <td><?php echo $record->shrdndot; ?></td>
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
                                    <td><?php echo $record->rhol_st; ?></td>
                                    <td><?php echo $record->rhol_ot; ?></td>
                                    <td><?php echo $record->rhol_nd; ?></td>
                                    <td><?php echo $record->rhol_ndot; ?></td>
                                    <td><?php echo $record->rt_st; ?></td>
                                    <td><?php echo $record->rt_ot; ?></td>
                                    <td><?php echo $record->rt_nd; ?></td>
                                    <td><?php echo $record->rt_ndot; ?></td>
                                    <td><?php echo $record->shrd_st; ?></td>
                                    <td><?php echo $record->shrd_ot; ?></td>
                                    <td><?php echo $record->shrd_nd; ?></td>
                                    <td><?php echo $record->shrd_ndot; ?></td>
                                    <td><?php echo $record->rhrd_st; ?></td>
                                    <td><?php echo $record->rhrd_ot; ?></td>
                                    <td><?php echo $record->rhrd_nd; ?></td>
                                    <td><?php echo $record->rhrd_ndot; ?></td>
                                    <td><?php echo number_format($record->c_totalst, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($record->c_totalot, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($record->c_totalnd, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($record->c_totalndot, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($record->c_totalAmt, 2, '.', ','); ?></td>
                                    <td><?php echo $record->headCount; ?></td>
                                    <td></td>
                                    <td><?php echo $record->Location; ?></td>
                                    <td><?php echo $record->soaNumber; ?></td>
                                    <td><?php echo number_format($rdst_total + $sholst_total + $shrdst_total + $rholst_total + $rhrdst_total + $rtst_total, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($rdot_total + $sholot_total + $shrdot_total + $rholot_total + $rhrdot_total + $rtot_total, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($rdnd_total + $sholnd_total + $shrdnd_total + $rholnd_total + $rhrdnd_total + $rtnd_total, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($rdndot_total + $sholndot_total + $shrdndot_total + $rholndot_total + $rhrdndot_total + $rtndot_total, 2, '.', ','); ?></td>
                                    <td><?php echo $total_hc; ?></td>
                                    <td><?php echo number_format($total_amt, 2, '.', ','); ?></td>
                                    <?php $No++; ?>
                                </tr>
                            <?php endif; ?> 
                            <?php $dtl_no++; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- <table width="100%">
                <tr>
                    <td style="border:none">PREPARED BY:</td>
                </tr>
                <tr>
                    <td style="border:none;"><?php //echo $preparedby; ?></td>
                </tr>
                <tr>
                    <td style="border:none;"></td>
                </tr>
                <tr>
                    <td style="border:none">RECEIVED BY:</td>
                </tr>
                <tr>
                    <td style="border:none;"></td>
                </tr>
                <tr>
                    <td style="border:none;"></td>
                </tr>
            </table> -->
        </body>
</html>
