<?php 
header('Content-type: application/excel');
$filename = 'Labnotin Transmittal -'. date('mdY') .'.xls';
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
	
			@page { sheet-size: Letter; }
			
			@page {
				margin-top: 1cm;
				margin-bottom: 1.5cm;
				margin-left: 1.5cm;
				margin-right: 1.5cm;
				odd-footer-name: html_myFooter;
			}
			
			h1.bigsection {
					page-break-before: always;
					page: bigger;
			}

			.main_t td{
				font-size:100%;
			}

            .sig_t td{
				border:none;
			}

			th {
				font-size: 90%;
				text-align:center;
			}
	
		</style>
		<body>
            <?php $for = "GSMPC COPY"; ?>
            <?php for($i=1;$i<4;$i++): ?>
            <?php foreach($records as $record): ?>
            <table width="100%" style="margin-bottom:30px;" class="main_t">
                <tr>
                    <td colspan="2" style="border:none;">
                        <strong>GSMPC GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong>
                    </td>
                </tr>
                <tr>
                    <td style="border:none;"><strong>BORJA ROAD DAMILAG, MANOLO FORTICH,BUKIDNON</strong></td>
                    <td style="border:none;"><strong><?php echo $for; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;"><strong>TIN # 411-478-949-000</strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;">Period Covered: <?php echo $details['period_date']; ?><strong></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;"><strong>TRANSMITTAL #: <?php echo $details['transmittal_no']; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;"><strong>DATE TRANSMITTED: <?php echo date('F j, Y', strtotime($details['date_transmitted'])); ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;">TO: DMPI ACCOUNTING<strong></strong></td>
                </tr>
            </table>
            <table width="100%" style="margin-bottom:10px;">
                <thead>
                    <tr>
                        <th>ITEM #</th>
                        <th>DOCUMENT DATE</th>
                        <th>DEPARTMENT</th>
                        <th>GSMPC SOA NO.</th>
                        <th>ST</th>
                        <th>HC</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center;">1</td>
                        <td style=""><?php echo date('F j, Y', strtotime($details['document_date'])); ?></td>
                        <td style="">CAMP ADMIN (LABNOTIN)</td>
                        <td style=""><?php echo $record->SOANo; ?></td>
                        <td style=""><?php echo $record->total_hrs; ?></td>
                        <td style="">1</td>
                        <td style="text-align:right;"><?php echo number_format($record->total_amount + ($record->total_amount * ($record->admin_percentage/100)), 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <br>
            <br>
            <table width="100%" style="margin-bottom:10px;font-size:100%;" class="sig_t">
                <tr>
                    <td style="width:40%;">PREPARED & CHECKED BY:</td>
                    <td style="width:10%;"></td>
                    <td style="width:40%;">RECEIVED & APPROVED BY:</td>
                </tr>
                <tr>
                    <td style="padding-top:10px;"></td>
                    <td style="padding-top:10px;"></td>
                    <td style="padding-top:10px;"></td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid black;font-weight:bold;"><?php echo $details['Prepared_by'].'/'.$details['Checked_by']; ?></td>
                    <td style=""></td>
                    <td style="border-bottom:1px solid black;font-weight:bold;"><?php echo $details['Received_by'].'/'.$details['Approved_by']; ?></td>
                </tr>
                <tr>
                    <td style=""><?php echo $details['Prepared_by_desig'].'/'.$details['Checked_by_desig']; ?></td>
                    <td style=""></td>
                    <td style=""><?php echo $details['Received_by_desig'].'/'.$details['Approved_by_desig']; ?></td>
                </tr>
                <tr>
                    <td style="padding-top:20px;"></td>
                    <td style="padding-top:20px;"></td>
                    <td style="padding-top:20px;"></td>
                </tr>
                <tr>
                    <td style="width:40%;">APPROVED BY:</td>
                    <td style="width:10%;"></td>
                    <td style="width:40%;"></td>
                </tr>
                <tr>
                    <td style="padding-top:10px;"></td>
                    <td style="padding-top:10px;"></td>
                    <td style="padding-top:10px;"></td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid black;font-weight:bold;"><?php echo $details['Approved_by_2']; ?></td>
                    <td style=""></td>
                    <td style=""></td>
                </tr>
                <tr>
                    <td style=""><?php echo $details['Approved_by_2_desig']; ?></td>
                    <td style=""></td>
                    <td style=""></td>
                </tr>
            </table>
            <?php if($i != 3): ?>
            <pagebreak />
            <?php endif; ?>
            <?php $for = "DMPI COPY"; ?>
            <?php endforeach; ?>
            <?php endfor; ?>
        </body>
</html>
