<?php 
header('Content-type: application/excel');
$filename = 'GSC RETRO ADJUSTMENT -'. date('mdY') .'.xls';
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
                    <td colspan="49" style="border:none;width:">
                        <strong>GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="49" style="border:none;"><strong>FOR THE YEAR <?php echo Date('Y'); ?></strong></td>
                </tr>
                <tr>
                    <td colspan="49" style="border:none;"><strong>RX-20 RETRO-ADJUSTMENT OF GSMPC ( JANUARY 1, <?php echo Date('Y'); ?>) SSS PREMIUM</strong></td>
                </tr>
            </table>
            <table width="100%" style="margin-bottom:10px;">
                <thead>
                    <tr style="border:1px solid black;">
                        <th rowspan="2" style="background:yellow;">DOC DATE</th>
                        <th rowspan="2" style="background:yellow;">Reference Doc Number</th>
                        <th rowspan="2" style="background:yellow;">ACTIVITY</th>
                        <th rowspan="2" style="background:yellow;">GL</th>
                        <th rowspan="2" style="background:yellow;">C/C</th>
                        <th colspan="20" style="background:yellow;">HOURS RENDERED</th>
                        <th colspan="20" style="background:red;">OLD RATE</th>
                        <th colspan="20" style="background:rgb(0,112,192);">NEW RATE</th>
                        <th colspan="20" style="background:rgb(146,208,80);">DIFFERENCE</th>
                        <th rowspan="2" style="background:yellow;">ADJUSTMENT</th>
                        <th rowspan="2" style="background:yellow;">VAT</th>
                        <th rowspan="2" style="background:yellow;">TOTAL ADJUSTMENT</th>
                        <th rowspan="2" style="background:yellow;">ACTUAL SOA AMOUNT</th>
                    </tr>
                    <tr style="border:1px solid black;">
                        <!-- Hours Rendered -->
                        <th style="background:yellow;">ST</th>
                        <th style="background:yellow;">OT</th>
                        <th style="background:yellow;">ND</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">SHOL</th>
                        <th style="background:yellow;">SHOL-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">SHRD</th>
                        <th style="background:yellow;">SHRD-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">RHOL</th>
                        <th style="background:yellow;">RHOL-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">RHRD</th>
                        <th style="background:yellow;">RHRD-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <!-- Old Rate -->
                        <th style="background:yellow;">ST</th>
                        <th style="background:yellow;">OT</th>
                        <th style="background:yellow;">ND</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">SHOL</th>
                        <th style="background:yellow;">SHOL-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">SHRD</th>
                        <th style="background:yellow;">SHRD-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">RHOL</th>
                        <th style="background:yellow;">RHOL-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">RHRD</th>
                        <th style="background:yellow;">RHRD-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <!-- New Rate -->
                        <th style="background:yellow;">ST</th>
                        <th style="background:yellow;">OT</th>
                        <th style="background:yellow;">ND</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">SHOL</th>
                        <th style="background:yellow;">SHOL-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">SHRD</th>
                        <th style="background:yellow;">SHRD-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">RHOL</th>
                        <th style="background:yellow;">RHOL-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">RHRD</th>
                        <th style="background:yellow;">RHRD-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <!-- Difference -->
                        <th style="background:yellow;">ST</th>
                        <th style="background:yellow;">OT</th>
                        <th style="background:yellow;">ND</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">SHOL</th>
                        <th style="background:yellow;">SHOL-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">SHRD</th>
                        <th style="background:yellow;">SHRD-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">RHOL</th>
                        <th style="background:yellow;">RHOL-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                        <th style="background:yellow;">RHRD</th>
                        <th style="background:yellow;">RHRD-OT</th>
                        <th style="background:yellow;">NP</th>
                        <th style="background:yellow;">NP OT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($records as $record): ?>
                        <tr style="border:1px solid black;">
                            <td><?php echo $record->soaDate; ?></td>
                            <td><?php echo $record->soaNumber; ?></td>
                            <td><?php echo $record->activity; ?></td>
                            <td><?php echo $record->gl; ?></td>
                            <td><?php echo $record->cc; ?></td>
                            <td><?php echo $record->rdst_hrs; ?></td>
                            <td><?php echo $record->rdot_hrs; ?></td>
                            <td><?php echo $record->rdnd_hrs; ?></td>
                            <td><?php echo $record->rdndot_hrs; ?></td>
                            <td><?php echo $record->sholst_hrs; ?></td>
                            <td><?php echo $record->sholot_hrs; ?></td>
                            <td><?php echo $record->sholnd_hrs; ?></td>
                            <td><?php echo $record->sholndot_hrs; ?></td>
                            <td><?php echo $record->shrdst_hrs; ?></td>
                            <td><?php echo $record->shrdot_hrs; ?></td>
                            <td><?php echo $record->shrdnd_hrs; ?></td>
                            <td><?php echo $record->shrdndot_hrs; ?></td>
                            <td><?php echo $record->rholst_hrs; ?></td>
                            <td><?php echo $record->rholot_hrs; ?></td>
                            <td><?php echo $record->rholnd_hrs; ?></td>
                            <td><?php echo $record->rholndot_hrs; ?></td>
                            <td><?php echo $record->rhrdst_hrs; ?></td>
                            <td><?php echo $record->rhrdot_hrs; ?></td>
                            <td><?php echo $record->rhrdnd_hrs; ?></td>
                            <td><?php echo $record->rhrdndot_hrs; ?></td>

                            <td><?php echo $record->rdst_old; ?></td>
                            <td><?php echo $record->rdot_old; ?></td>
                            <td><?php echo $record->rdnd_old; ?></td>
                            <td><?php echo $record->rdndot_old; ?></td>
                            <td><?php echo $record->sholst_old; ?></td>
                            <td><?php echo $record->sholot_old; ?></td>
                            <td><?php echo $record->sholnd_old; ?></td>
                            <td><?php echo $record->sholndot_old; ?></td>
                            <td><?php echo $record->shrdst_old; ?></td>
                            <td><?php echo $record->shrdot_old; ?></td>
                            <td><?php echo $record->shrdnd_old; ?></td>
                            <td><?php echo $record->shrdndot_old; ?></td>
                            <td><?php echo $record->rholst_old; ?></td>
                            <td><?php echo $record->rholot_old; ?></td>
                            <td><?php echo $record->rholnd_old; ?></td>
                            <td><?php echo $record->rholndot_old; ?></td>
                            <td><?php echo $record->rhrdst_old; ?></td>
                            <td><?php echo $record->rhrdot_old; ?></td>
                            <td><?php echo $record->rhrdnd_old; ?></td>
                            <td><?php echo $record->rhrdndot_old; ?></td>

                            <td><?php echo $record->rdst_new; ?></td>
                            <td><?php echo $record->rdot_new; ?></td>
                            <td><?php echo $record->rdnd_new; ?></td>
                            <td><?php echo $record->rdndot_new; ?></td>
                            <td><?php echo $record->sholst_new; ?></td>
                            <td><?php echo $record->sholot_new; ?></td>
                            <td><?php echo $record->sholnd_new; ?></td>
                            <td><?php echo $record->sholndot_new; ?></td>
                            <td><?php echo $record->shrdst_new; ?></td>
                            <td><?php echo $record->shrdot_new; ?></td>
                            <td><?php echo $record->shrdnd_new; ?></td>
                            <td><?php echo $record->shrdndot_new; ?></td>
                            <td><?php echo $record->rholst_new; ?></td>
                            <td><?php echo $record->rholot_new; ?></td>
                            <td><?php echo $record->rholnd_new; ?></td>
                            <td><?php echo $record->rholndot_new; ?></td>
                            <td><?php echo $record->rhrdst_new; ?></td>
                            <td><?php echo $record->rhrdot_new; ?></td>
                            <td><?php echo $record->rhrdnd_new; ?></td>
                            <td><?php echo $record->rhrdndot_new; ?></td>

                            <td><?php echo $record->rdst_diff; ?></td>
                            <td><?php echo $record->rdot_diff; ?></td>
                            <td><?php echo $record->rdnd_diff; ?></td>
                            <td><?php echo $record->rdndot_diff; ?></td>
                            <td><?php echo $record->sholst_diff; ?></td>
                            <td><?php echo $record->sholot_diff; ?></td>
                            <td><?php echo $record->sholnd_diff; ?></td>
                            <td><?php echo $record->sholndot_diff; ?></td>
                            <td><?php echo $record->shrdst_diff; ?></td>
                            <td><?php echo $record->shrdot_diff; ?></td>
                            <td><?php echo $record->shrdnd_diff; ?></td>
                            <td><?php echo $record->shrdndot_diff; ?></td>
                            <td><?php echo $record->rholst_diff; ?></td>
                            <td><?php echo $record->rholot_diff; ?></td>
                            <td><?php echo $record->rholnd_diff; ?></td>
                            <td><?php echo $record->rholndot_diff; ?></td>
                            <td><?php echo $record->rhrdst_diff; ?></td>
                            <td><?php echo $record->rhrdot_diff; ?></td>
                            <td><?php echo $record->rhrdnd_diff; ?></td>
                            <td><?php echo $record->rhrdndot_diff; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </body>
</html>
