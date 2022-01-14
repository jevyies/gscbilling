<?php 
header('Content-type: application/excel');
$filename = 'GSCBCC-'. date('mdY') .'.xls';
header('Content-Disposition: attachment; filename='.$filename);
$total_rd_st = 0;
$total_rd_ot = 0;
$total_rd_nd = 0;
$total_rd_ndot = 0;
$total_shol_st = 0;
$total_shol_ot = 0;
$total_shol_nd = 0;
$total_shol_ndot = 0;
$total_holiday_pay = 0;
$total_rhol_st = 0;
$total_rhol_ot = 0;
$total_rhol_nd = 0;
$total_rhol_ndot = 0;
$total_shrd_st = 0;
$total_shrd_ot = 0;
$total_shrd_nd = 0;
$total_shrd_ndot = 0;
$total_rhrd_st = 0;
$total_rhrd_ot = 0;
$total_rhrd_nd = 0;
$total_rhrd_ndot = 0;
$total_rhol_st2x = 0;
$total_rhol_ot2x = 0;
$total_rhol_nd2x = 0;
$total_rhol_ndot2x = 0;
$total_rholrd_st2x = 0;
$total_rholrd_ot2x = 0;
$total_rholrd_nd2x = 0;
$total_rholrd_ndot2x = 0;

$total_st = 0;
$total_ot = 0;
$total_nd = 0;
$total_ndot = 0;

$total_total = 0;
$count = 1;
foreach($records as $record){
    $SOANo = $record->SOANo;
    $period_date = $record->period_date;
    $admin_percentage = $record->admin_percentage;
    $Prepared_by = $record->Prepared_by;
    $Prepared_by_desig = $record->Prepared_by_desig;
    $Checked_by = $record->Checked_by;
    $Checked_by_desig = $record->Checked_by_desig;
    $Approved_by = $record->Approved_by;
    $Approved_by_desig = $record->Approved_by_desig;
    $Noted_by = $record->Noted_by;
    $Noted_by_desig = $record->Noted_by_desig;
    break;
}
?>
<html xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
	</head>
    <style>
        body {
            font-family: 'Arial, Helvetica, sans-serif';
        }

        table {
            border-spacing: -1px;
            border-width:thin;
        }
        th{
            /* border: 1px solid #285d8c; */
        }
        td {
            font-size: 90%;
            padding:5px;
            /* border: 1px solid #285d8c; */
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
            border:1px solid black;
        }

    </style>
    <body>
        <table width="100%" style="margin-bottom:20px;">
            <tr>
                <td style="border:none;padding:0px;text-align:right;width:25%" rowspan="4">
                    <img style="width:100px;height:60px;" src="<?php echo base_url(); ?>assets/images/logo.png">
                </td>
                <td style="border:none;padding:0px;width:50%;text-align:center;font-size:130%;"><strong>GSMPC GENERAL SERVICES MULTIPURPOSE COOPERATIVE</strong></td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:2px;text-align:center;font-size:110%;"><strong style="border-bottom:1px solid black;">STATEMENT OF ACCOUNT</strong></td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:3px;text-align:center;">Telephone number: 088-223-3862</td>
                <td style="border:none;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:3px;text-align:center;">TIN Number: 411-478-949</td>
                <td style="border:none;"></td>
            </tr>
        </table>
        <br>
        <br>
        <table width="100%">
            <tr>
                <td style="width:45%;">PERIOD COVERAGE: <?php echo $period_date; ?></td>
                <td style="width:20%;"></td>
                <td style="width:45%;">Control #: <?php echo $SOANo; ?></td>
            </tr>
        </table>
        <table width="100%" class="main_t">
            <thead>
                <tr>
                    <td>ITEM</td>
                    <td>DATE</td>
                    <td rowspan="2">NAME</td>
                    <td rowspan="2">FIELD</td>
                    <td colspan="29" style="text-align:center;">HOURS RENDERED</td>
                    <td colspan="28" style="text-align:center;">RATE</td>
                    <td colspan="4" style="text-align:center;">AMOUNT</td>
                    <td rowspan="2">TOTAL</td>
                </tr>
                <tr>
                    <td>#</td>
                    <td>PERFORMED</td>
                    <td>BASIC</td>
                    <td>OT</td>
                    <td>ND</td>
                    <td>ND-OT</td>
                    <td>SRD/SHOL</td>
                    <td>SRD/SHOL-OT</td>
                    <td>SRD/SHOL-ND</td>
                    <td>SRD/SHOL-ND-OT</td>
                    <td>HP</td>
                    <td>RHOL</td>
                    <td>RHOL-OT</td>
                    <td>RHOL-ND</td>
                    <td>RHOL-ND-OT</td>
                    <td>SHRD</td>
                    <td>SHRD-OT</td>
                    <td>SHRD-ND</td>
                    <td>SHRD-ND-OT</td>
                    <td>RHRD</td>
                    <td>RHRD-OT</td>
                    <td>RHRD-ND</td>
                    <td>RHRD-ND-OT</td>
                    <td>2x RHOL-ST</td>
                    <td>2x RHOL-OT</td>
                    <td>2x RHOL-ND</td>
                    <td>2x RHOL-NDOT</td>
                    <td>2x RHOLRD-ST</td>
                    <td>2x RHOLRD-OT</td>
                    <td>2x RHOLRD-ND</td>
                    <td>2x RHOLRD-NDOT</td>
                    <td>ST</td>
                    <td>OT</td>
                    <td>ND</td>
                    <td>ND-OT</td>
                    <td>SRD/SHOL</td>
                    <td>SRD/SHOL-OT</td>
                    <td>SRD/SHOL-ND</td>
                    <td>SRD/SHOL-ND-OT</td>
                    <td>RHOL</td>
                    <td>RHOL-OT</td>
                    <td>RHOL-ND</td>
                    <td>RHOL-ND-OT</td>
                    <td>SHRD</td>
                    <td>SHRD-OT</td>
                    <td>SHRD-ND</td>
                    <td>SHRD-ND-OT</td>
                    <td>RHRD</td>
                    <td>RHRD-OT</td>
                    <td>RHRD-ND</td>
                    <td>RHRD-ND-OT</td>
                    <td>2x RHOL-ST</td>
                    <td>2x RHOL-OT</td>
                    <td>2x RHOL-ND</td>
                    <td>2x RHOL-NDOT</td>
                    <td>2x RHOLRD-ST</td>
                    <td>2x RHOLRD-OT</td>
                    <td>2x RHOLRD-ND</td>
                    <td>2x RHOLRD-NDOT</td>
                    <td>ST</td>
                    <td>OT</td>
                    <td>ND</td>
                    <td>NDOT</td>
                </tr>
            </thead>
            <tbody>
                <?php if($records): ?>
                <?php foreach($records as $record): ?>
                <tr>
                    <td style="text-align:center;"><?php echo $count; ?></td>
                    <td style="text-align:center;"><?php echo $record->period_date; ?></td>
                    <td><?php echo strtoupper($record->Name); ?></td>
                    <td style="text-align:center;"><?php echo $record->Activity; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_st != 0 ? number_format($record->rd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_ot != 0 ? number_format($record->rd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_nd != 0 ? number_format($record->rd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_ndot != 0 ? number_format($record->rd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_st != 0 ? number_format($record->shol_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_ot != 0 ? number_format($record->shol_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_nd != 0 ? number_format($record->shol_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_ndot != 0 ? number_format($record->shol_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->holiday_pay != 0 ? number_format($record->holiday_pay, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_st != 0 ? number_format($record->rhol_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_ot != 0 ? number_format($record->rhol_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_nd != 0 ? number_format($record->rhol_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_ndot != 0 ? number_format($record->rhol_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shrd_st != 0 ? number_format($record->shrd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shrd_ot != 0 ? number_format($record->shrd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shrd_nd != 0 ? number_format($record->shrd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shrd_ndot != 0 ? number_format($record->shrd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhrd_st != 0 ? number_format($record->rhrd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhrd_ot != 0 ? number_format($record->rhrd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhrd_nd != 0 ? number_format($record->rhrd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhrd_ndot != 0 ? number_format($record->rhrd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_st2x != 0 ? number_format($record->rhol_st2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_ot2x != 0 ? number_format($record->rhol_ot2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_nd2x != 0 ? number_format($record->rhol_nd2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_ndot2x != 0 ? number_format($record->rhol_ndot2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rholrd_st2x != 0 ? number_format($record->rholrd_st2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rholrd_ot2x != 0 ? number_format($record->rholrd_ot2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rholrd_nd2x != 0 ? number_format($record->rholrd_nd2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rholrd_ndot2x != 0 ? number_format($record->rholrd_ndot2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_st_r != 0 ? number_format($record->rd_st_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_ot_r != 0 ? number_format($record->rd_ot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_nd_r != 0 ? number_format($record->rd_nd_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_ndot_r != 0 ? number_format($record->rd_ndot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_st_r != 0 ? number_format($record->shol_st_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_ot_r != 0 ? number_format($record->shol_ot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_nd_r != 0 ? number_format($record->shol_nd_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_ndot_r != 0 ? number_format($record->shol_ndot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_st_r != 0 ? number_format($record->rhol_st_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_ot_r != 0 ? number_format($record->rhol_ot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_nd_r != 0 ? number_format($record->rhol_nd_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_ndot_r != 0 ? number_format($record->rhol_ndot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shrd_st_r != 0 ? number_format($record->shrd_st_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shrd_ot_r != 0 ? number_format($record->shrd_ot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shrd_nd_r != 0 ? number_format($record->shrd_nd_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shrd_ndot_r != 0 ? number_format($record->shrd_ndot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhrd_st_r != 0 ? number_format($record->rhrd_st_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhrd_ot_r != 0 ? number_format($record->rhrd_ot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhrd_nd_r != 0 ? number_format($record->rhrd_nd_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhrd_ndot_r != 0 ? number_format($record->rhrd_ndot_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_st2x_r != 0 ? number_format($record->rhol_st2x_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_ot2x_r != 0 ? number_format($record->rhol_ot2x_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_nd2x_r != 0 ? number_format($record->rhol_nd2x_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rhol_ndot2x_r != 0 ? number_format($record->rhol_ndot2x_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rholrd_st2x_r != 0 ? number_format($record->rholrd_st2x_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rholrd_ot2x_r != 0 ? number_format($record->rholrd_ot2x_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rholrd_nd2x_r != 0 ? number_format($record->rholrd_nd2x_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rholrd_ndot2x_r != 0 ? number_format($record->rholrd_ndot2x_r, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo number_format(($record->holiday_pay * $record->rd_st_r) + ($record->rd_st * $record->rd_st_r) + ($record->shol_st * $record->shol_st_r) + ($record->rhol_st * $record->rhol_st_r) + ($record->shrd_st * $record->shrd_st_r) + ($record->rhrd_st * $record->rhrd_st_r) + ($record->rhol_st2x * $record->rhol_st2x_r) + ($record->rholrd_st2x * $record->rholrd_st2x_r), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(($record->rd_ot * $record->rd_ot_r) + ($record->shol_ot * $record->shol_ot_r) + ($record->rhol_ot * $record->rhol_ot_r) + ($record->shrd_ot * $record->shrd_ot_r) + ($record->rhrd_ot * $record->rhrd_ot_r) + ($record->rhol_ot2x * $record->rhol_ot2x_r) + ($record->rholrd_ot2x * $record->rholrd_ot2x_r), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(($record->rd_nd * $record->rd_nd_r) + ($record->shol_nd * $record->shol_nd_r) + ($record->rhol_nd * $record->rhol_nd_r) + ($record->shrd_nd * $record->shrd_nd_r) + ($record->rhrd_nd * $record->rhrd_nd_r) + ($record->rhol_nd2x * $record->rhol_nd2x_r) + ($record->rholrd_nd2x * $record->rholrd_nd2x_r), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(($record->rd_ndot * $record->rd_ndot_r) + ($record->shol_ndot * $record->shol_ndot_r) + ($record->rhol_ndot * $record->rhol_ndot2x_r) + ($record->shrd_ndot * $record->shrd_ndot_r) + ($record->rhrd_ndot * $record->rhrd_ndot_r) + ($record->rhol_ndot2x * $record->rhol_ndot2x_r) + ($record->rholrd_ndot2x * $record->rholrd_ndot2x_r), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(($record->holiday_pay * $record->rd_st_r) + ($record->rd_st * $record->rd_st_r) + ($record->shol_st * $record->shol_st_r) + ($record->rhol_st * $record->rhol_st_r) + ($record->shrd_st * $record->shrd_st_r) + ($record->rhrd_st * $record->rhrd_st_r) + ($record->rhol_st2x * $record->rhol_st2x_r) + ($record->rholrd_st2x * $record->rholrd_st2x_r) + ($record->rd_ot * $record->rd_ot_r) + ($record->shol_ot * $record->shol_ot_r) + ($record->rhol_ot * $record->rhol_ot_r) + ($record->shrd_ot * $record->shrd_ot_r) + ($record->rhrd_ot * $record->rhrd_ot_r) + ($record->rhol_ot2x * $record->rhol_ot2x_r) + ($record->rholrd_ot2x * $record->rholrd_ot2x_r) + ($record->rd_nd * $record->rd_nd_r) + ($record->shol_nd * $record->shol_nd_r) + ($record->rhol_nd * $record->rhol_nd_r) + ($record->shrd_nd * $record->shrd_nd_r) + ($record->rhrd_nd * $record->rhrd_nd_r) + ($record->rhol_nd2x * $record->rhol_nd2x_r) + ($record->rholrd_nd2x * $record->rholrd_nd2x_r) + ($record->rd_ndot * $record->rd_ndot_r) + ($record->shol_ndot * $record->shol_ndot_r) + ($record->rhol_ndot * $record->rhol_ndot2x_r) + ($record->shrd_ndot * $record->shrd_ndot_r) + ($record->rhrd_ndot * $record->rhrd_ndot_r) + ($record->rhol_ndot2x * $record->rhol_ndot2x_r) + ($record->rholrd_ndot2x * $record->rholrd_ndot2x_r), 2, '.', ','); ?></td>
                </tr>
                <?php 
                $total_rd_st = $total_rd_st + $record->rd_st;
                $total_rd_ot = $total_rd_ot + $record->rd_ot;
                $total_rd_nd = $total_rd_nd + $record->rd_nd;
                $total_rd_ndot = $total_rd_ndot + $record->rd_ndot;
                $total_shol_st = $total_shol_st + $record->shol_st;
                $total_shol_ot = $total_shol_ot + $record->shol_ot;
                $total_shol_nd = $total_shol_nd + $record->shol_nd;
                $total_shol_ndot = $total_shol_ndot + $record->shol_ndot;
                $total_holiday_pay = $total_holiday_pay + $record->holiday_pay;
                $total_rhol_st = $total_rhol_st + $record->rhol_st;
                $total_rhol_ot = $total_rhol_ot + $record->rhol_ot;
                $total_rhol_nd = $total_rhol_nd + $record->rhol_nd;
                $total_rhol_ndot = $total_rhol_ndot + $record->rhol_ndot;
                $total_shrd_st = $total_shrd_st + $record->shrd_st;
                $total_shrd_ot = $total_shrd_ot + $record->shrd_ot;
                $total_shrd_nd = $total_shrd_nd + $record->shrd_nd;
                $total_shrd_ndot = $total_shrd_ndot + $record->shrd_ndot;
                $total_rhrd_st = $total_rhrd_st + $record->rhrd_st;
                $total_rhrd_ot = $total_rhrd_ot + $record->rhrd_ot;
                $total_rhrd_nd = $total_rhrd_nd + $record->rhrd_nd;
                $total_rhrd_ndot = $total_rhrd_ndot + $record->rhrd_ndot;
                $total_rhol_st2x = $total_rhol_st2x + $record->rhol_st2x;
                $total_rhol_ot2x = $total_rhol_ot2x + $record->rhol_ot2x;
                $total_rhol_nd2x = $total_rhol_nd2x + $record->rhol_nd2x;
                $total_rhol_ndot2x = $total_rhol_ndot2x + $record->rhol_ndot2x;
                $total_rholrd_st2x = $total_rholrd_st2x + $record->rholrd_st2x;
                $total_rholrd_ot2x = $total_rholrd_ot2x + $record->rholrd_ot2x;
                $total_rholrd_nd2x = $total_rholrd_nd2x + $record->rholrd_nd2x;
                $total_rholrd_ndot2x = $total_rholrd_ndot2x + $record->rholrd_ndot2x;
                $total_st = $total_st + ($record->holiday_pay * $record->rd_st_r) + ($record->rd_st * $record->rd_st_r) + ($record->shol_st * $record->shol_st_r) + ($record->rhol_st * $record->rhol_st_r) + ($record->shrd_st * $record->shrd_st_r) + ($record->rhrd_st * $record->rhrd_st_r) + ($record->rhol_st2x * $record->rhol_st2x_r) + ($record->rholrd_st2x * $record->rholrd_st2x_r);
                $total_ot = $total_ot + ($record->rd_ot * $record->rd_ot_r) + ($record->shol_ot * $record->shol_ot_r) + ($record->rhol_ot * $record->rhol_ot_r) + ($record->shrd_ot * $record->shrd_ot_r) + ($record->rhrd_ot * $record->rhrd_ot_r) + ($record->rhol_ot2x * $record->rhol_ot2x_r) + ($record->rholrd_ot2x * $record->rholrd_ot2x_r);
                $total_nd = $total_nd + ($record->rd_nd * $record->rd_nd_r) + ($record->shol_nd * $record->shol_nd_r) + ($record->rhol_nd * $record->rhol_nd_r) + ($record->shrd_nd * $record->shrd_nd_r) + ($record->rhrd_nd * $record->rhrd_nd_r) + ($record->rhol_nd2x * $record->rhol_nd2x_r) + ($record->rholrd_nd2x * $record->rholrd_nd2x_r);
                $total_ndot = $total_ndot + ($record->rd_ndot * $record->rd_ndot_r) + ($record->shol_ndot * $record->shol_ndot_r) + ($record->rhol_ndot * $record->rhol_ndot2x_r) + ($record->shrd_ndot * $record->shrd_ndot_r) + ($record->rhrd_ndot * $record->rhrd_ndot_r) + ($record->rhol_ndot2x * $record->rhol_ndot2x_r) + ($record->rholrd_ndot2x * $record->rholrd_ndot2x_r);
                $total_total = $total_total + ($total_st + $total_ot + $total_nd + $total_ndot);
                $count = $count + 1;
                ?>
                <?php endforeach; ?>
                <tr>
                    <td style="text-align:right;border:none;"></td>
                    <td style="text-align:right;border:none;"></td>
                    <td style="text-align:right;border:none;"></td>
                    <td style="text-align:right;border:none;"></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rd_st != 0 ? number_format($total_rd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rd_ot != 0 ? number_format($total_rd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rd_nd != 0 ? number_format($total_rd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rd_ndot != 0 ? number_format($total_rd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_shol_st != 0 ? number_format($total_shol_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_shol_ot != 0 ? number_format($total_shol_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_shol_nd != 0 ? number_format($total_shol_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_shol_ndot != 0 ? number_format($total_shol_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_holiday_pay != 0 ? number_format($total_holiday_pay, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhol_st != 0 ? number_format($total_rhol_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhol_ot != 0 ? number_format($total_rhol_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhol_nd != 0 ? number_format($total_rhol_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhol_ndot != 0 ? number_format($total_rhol_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_shrd_st != 0 ? number_format($total_shrd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_shrd_ot != 0 ? number_format($total_shrd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_shrd_nd != 0 ? number_format($total_shrd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_shrd_ndot != 0 ? number_format($total_shrd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhrd_st != 0 ? number_format($total_rhrd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhrd_ot != 0 ? number_format($total_rhrd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhrd_nd != 0 ? number_format($total_rhrd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhrd_ndot != 0 ? number_format($total_rhrd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhol_st2x != 0 ? number_format($total_rhol_st2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhol_ot2x != 0 ? number_format($total_rhol_ot2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhol_nd2x != 0 ? number_format($total_rhol_nd2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rhol_ndot2x != 0 ? number_format($total_rhol_ndot2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rholrd_st2x != 0 ? number_format($total_rholrd_st2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rholrd_ot2x != 0 ? number_format($total_rholrd_ot2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rholrd_nd2x != 0 ? number_format($total_rholrd_nd2x, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_rholrd_ndot2x != 0 ? number_format($total_rholrd_ndot2x, 2, '.', ',') : ""; ?></td>
                    <td colspan="28" style="border:none;"></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_st != 0 ? number_format($total_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_ot != 0 ? number_format($total_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_nd != 0 ? number_format($total_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_ndot != 0 ? number_format($total_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_st + $total_ot + $total_nd + $total_ndot != 0 ? number_format($total_st + $total_ot + $total_nd + $total_ndot, 2, '.', ',') : ""; ?></td>
                </tr>
                <?php if($admin_percentage != 0): ?>
                <tr>
                    <td colspan="64" style="border:none;text-align:right">Amount Billed (<?php echo $admin_percentage ?>% Admin Fee) (<?php echo number_format(($total_st + $total_ot + $total_nd + $total_ndot) * ($admin_percentage/100), 2, '.', ','); ?>):</td>
                    <td style="text-align:right;border:none;border-bottom:3px solid black;"><?php echo $total_st + $total_ot + $total_nd + $total_ndot != 0 ? number_format($total_st + $total_ot + $total_nd + $total_ndot + (($total_st + $total_ot + $total_nd + $total_ndot) * ($admin_percentage/100)), 2, '.', ',') : ""; ?></td>
                </tr>
                <?php endif; ?>
                <?php endif; ?>
            </tbody>
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
    </body>
</html>