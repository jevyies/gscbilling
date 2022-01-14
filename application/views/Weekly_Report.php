<?php 
header('Content-type: application/excel');
$filename = 'WEEKLY REPORT.xls';
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
            </table>
            <table width="100%" style="margin-bottom:10px;">
                <thead>
                    <tr>
                        <th>ITEM #</th>
                        <th>DOCUMENT DATE</th>
                        <th>SOA NO</th>
                        <th>DATE TRANSMITTED TO OPERATION</th>
                        <th>DATE SIGNED BY SUPERVISOR</th>
                        <th>DATE SIGNED BY MANAGER</th>
                        <th>DATE RECEIVED DATA CONTROLLER</th>
                        <th>DATE RECEIVED BILLING CLERK</th>
                        <th>DATE RECEIVED BY DMPI ACCOUNTING</th>
                        <th>TRANSMITTAL NO</th>
                        <th>ACTIVITY</th>
                        <th>DEPARTMENT</th>
                        <th>REMARKS</th>
                        <th>GSC SOA NO</th>
                        <th>ST</th>
                        <th>OT</th>
                        <th>ND</th>
                        <th>NDOT</th>
                        <th>HC</th>
                        <th>TOTAL</th>
                        <th></th>
                        <th>FROM DOC. DATE TO OPERATION</th>
                        <th>FROM CLERK OPERATION TO SUPERVISOR DMPI</th>
                        <th>FROM SUPERVISOR  TO MANAGER DMPI</th>
                        <th>FROM MANAGER TO GSC DATA CONTROLLER</th>
                        <th>FROM DATA CONTROLLER TO DMPI ACCTG.</th>
                        <th>FROM DOC.DATE TO DMPI ACCTG.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $No = 1; ?>
                    <?php $GrandTotal = 0; ?>
                    <?php $TotalTDDate = 0; ?>
                    <?php $TotalSTDate = 0; ?>
                    <?php $TotalMSDate = 0; ?>
                    <?php $TotalDMDate = 0; ?>
                    <?php $TotalDDatDate = 0; ?>
                    <?php $TotalDDocDate = 0; ?>

                    <?php $TotalST = 0; ?>
                    <?php $TotalOT = 0; ?>
                    <?php $TotalND = 0; ?>
                    <?php $TotalNDOT = 0; ?>

                    <?php $TDDateHit = 0; ?>
                    <?php $TDDateMiss = 0; ?>

                    <?php $STDateHit = 0; ?>
                    <?php $STDateMiss = 0; ?>

                    <?php $MSDateHit = 0; ?>
                    <?php $MSDateMiss = 0; ?>

                    <?php $DMDateHit = 0; ?>
                    <?php $DMDateMiss = 0; ?>

                    <?php $DDatDateHit = 0; ?>
                    <?php $DDatDateMiss = 0; ?>

                    <?php $DDocDateHit = 0; ?>
                    <?php $DDocDateMiss = 0; ?>

                    <?php foreach($records as $record): ?>
                        <tr>
                            <td style="text-align:right;"><?php echo $No++; ?></td>
                            <td style="text-align:center;"><?php echo $record->soaDate === '0000-00-00' ? '' : date('j-M-y', strtotime($record->soaDate)); ?></td>
                            <td style="text-align:center;"><?php echo $record->soaNumber; ?></td>
                            <td style="text-align:center;"><?php echo $record->TransmittedDate === '0000-00-00' ? '' : date('j-M-y', strtotime($record->TransmittedDate)); ?></td>
                            <td style="text-align:center;"><?php echo $record->SupervisorDate === '0000-00-00' ? '' : date('j-M-y', strtotime($record->SupervisorDate)); ?></td>
                            <td style="text-align:center;"><?php echo $record->ManagerDate === '0000-00-00' ? '' : date('j-M-y', strtotime($record->ManagerDate)); ?></td>
                            <td style="text-align:center;"><?php echo $record->DataControllerDate === '0000-00-00' ? '' : date('j-M-y', strtotime($record->DataControllerDate)); ?></td>
                            <td style="text-align:center;"><?php echo $record->BillingClerkDate === '0000-00-00' ? '' : date('j-M-y', strtotime($record->BillingClerkDate)); ?></td>
                            <td style="text-align:center;"><?php echo $record->DMPIReceivedDate === '0000-00-00' ? '' : date('j-M-y', strtotime($record->DMPIReceivedDate)); ?></td>
                            <td style="text-align:center;"><?php echo $record->TransmittalNo; ?></td>
                            <td style="text-align:center;"><?php echo $record->activity ;?></td>
                            <td style="text-align:center;"><?php echo $record->nonBatch == 1 ? $record->location : $record->location ;?></td>
                            <td style="text-align:center;"><?php echo $period;?></td>
                            <td style="text-align:center;"><?php echo $record->soaNumber; ?></td>
                            <td style="text-align:center;"><?php echo $record->st; ?></td>
                            <td style="text-align:center;"><?php echo $record->ot; ?></td>
                            <td style="text-align:center;"><?php echo $record->nd; ?></td>
                            <td style="text-align:center;"><?php echo $record->ndot; ?></td>
                            <td style="text-align:center;"><?php echo $record->hc; ?></td>
                            <td style="text-align:center;"><?php echo number_format($record->total_amount, 2, '.', ','); ?></td>
                            <td></td>
                            <td><?php echo $record->TDDate; ?></td>
                            <td><?php echo $record->STDate; ?></td>
                            <td><?php echo $record->MSDate; ?></td>
                            <td><?php echo $record->DMDate; ?></td>
                            <td><?php echo $record->DDatDate; ?></td>
                            <td><?php echo $record->DDocDate; ?></td>
                        </tr>
                        <?php $GrandTotal = $GrandTotal + $record->total_amount; ?>
                        <?php $TotalTDDate = $TotalTDDate + $record->TDDate; ?>
                        <?php $TotalSTDate = $TotalSTDate + $record->STDate; ?>
                        <?php $TotalMSDate = $TotalMSDate + $record->MSDate; ?>
                        <?php $TotalDMDate = $TotalDMDate + $record->DMDate; ?>
                        <?php $TotalDDatDate = $TotalDDatDate + $record->DDatDate; ?>
                        <?php $TotalDDocDate = $TotalDDocDate + $record->DDocDate; ?>

                        <?php $TotalST = $TotalST + $record->st; ?>
                        <?php $TotalOT = $TotalOT + $record->ot; ?>
                        <?php $TotalND = $TotalND + $record->nd; ?>
                        <?php $TotalNDOT = $TotalNDOT + $record->ndot; ?>

                        <?php $record->TDDate > 2 ? $TDDateMiss++ : $TDDateHit++; ?>
                        <?php $record->STDate > 2 ? $STDateMiss++ : $STDateHit++; ?>
                        <?php $record->MSDate > 2 ? $MSDateMiss++ : $MSDateHit++; ?>
                        <?php $record->DMDate > 2 ? $DMDateMiss++ : $DMDateHit++; ?>
                        <?php $record->DDatDate > 2 ? $DDatDateMiss++ : $DDatDateHit++; ?>
                        <?php $record->DDocDate > 5 ? $DDocDateMiss++ : $DDocDateHit++; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="19"></td>
                        <td><?php echo number_format($GrandTotal, 2, '.', ','); ?></td>
                        <td>Average in DAYS</td>
                        <td><?php echo $TotalTDDate/count($records); ?></td>
                        <td><?php echo $TotalSTDate/count($records); ?></td>
                        <td><?php echo $TotalMSDate/count($records); ?></td>
                        <td><?php echo $TotalDMDate/count($records); ?></td>
                        <td><?php echo $TotalDDatDate/count($records); ?></td>
                        <td><?php echo $TotalDDocDate/count($records); ?></td>
                    </tr>
                    <tr>
                        <td colspan="20"></td>
                        <td>Hit</td>
                        <td><?php echo ($TDDateHit/count($records)) * 100; ?>%</td>
                        <td><?php echo ($STDateHit/count($records)) * 100; ?>%</td>
                        <td><?php echo ($MSDateHit/count($records)) * 100; ?>%</td>
                        <td><?php echo ($DMDateHit/count($records)) * 100; ?>%</td>
                        <td><?php echo ($DDatDateHit/count($records)) * 100; ?>%</td>
                        <td><?php echo ($DDocDateHit/count($records)) * 100; ?>%</td>
                    </tr>
                    <tr>
                        <td colspan="20"></td>
                        <td>Miss</td>
                        <td><?php echo ($TDDateMiss/count($records)) * 100; ?>%</td>
                        <td><?php echo ($STDateMiss/count($records)) * 100; ?>%</td>
                        <td><?php echo ($MSDateMiss/count($records)) * 100; ?>%</td>
                        <td><?php echo ($DMDateMiss/count($records)) * 100; ?>%</td>
                        <td><?php echo ($DDatDateMiss/count($records)) * 100; ?>%</td>
                        <td><?php echo ($DDocDateMiss/count($records)) * 100; ?>%</td>
                    </tr>
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
