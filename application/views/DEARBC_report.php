<?php 
header('Content-type: application/excel');
$filename = 'GSCDEARBC-'. date('mdY') .'.xls';
header('Content-Disposition: attachment; filename='.$filename);
$total_rd_st = 0;
$total_rd_ot = 0;
$total_rd_nd = 0;
$total_rd_ndot = 0;
$total_shol_st = 0;
$total_shol_ot = 0;
$total_shol_nd = 0;
$total_shol_ndot = 0;
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
$total_extra = 0;
$total_silpat = 0;
$total_adjustment = 0;
$total_incentive = 0;
$total_addpay = 0;
$total_volumepay = 0;
$total_allowance = 0;
$total_cola = 0;
$total_grosspay = 0;
$total_sss_ec = 0;
$total_sss_er = 0;
$total_phic_er = 0;
$total_hdmf_er = 0;
$total_total = 0;
foreach($records as $record){
    $paystation = $record->paystation;
    $period_date = $record->period_date;
    $admin_percentage = $record->admin_percentage;
    $prepared_by = $record->prepared_by;
    $checked_by = $record->checked_by;
    $approved_by = $record->approved_by;
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
            /* border:1px solid #285d8c; */
        }

        th {
            font-size: 90%;
            text-align:center;
        }

    </style>
    <body>
        <table width="100%" style="margin-bottom:20px;">
            <tr>
                <td style="border:none;padding:0px;text-align:right;width:25%" rowspan="4">
                    <img style="width:100px;height:50px;" src="<?php echo base_url(); ?>assets/images/logo.png">
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
                <td style="border:none;padding:0px;text-align:center;">TIN Number: 411-478-949</td>
                <td style="border:none;"></td>
            </tr>
        </table>
        <br>
        <br>
        <h5><?php echo $paystation; ?></h5>
        <h5><?php echo $period_date; ?></h5>
        <table width="100%" border="1">
            <thead>
                <tr>
                    <th>EMPLOYEE's</td>
                    <td colspan="29">PAYROLL DETAILS</td>
                    <td>EC</td>
                    <td colspan="3">EMPLOYER SHARE</td>
                    <td></td>
                </tr>
                <tr>
                    <td>NAME</td>
                    <td>BASIC</td>
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
                    <td>Extra</td>
                    <td>SIL/PAT</td>
                    <td>Adjustment</td>
                    <td>Incentive</td>
                    <td>AddPay</td>
                    <td>VolumePay</td>
                    <td>Allowances</td>
                    <td>COLA</td>
                    <td>GROSSPAY</td>
                    <td>SSS</td>
                    <td>SSS</td>
                    <td>PHIC</td>
                    <td>HDMF</td>
                    <td>TOTAL</td>
                </tr>
            </thead>
            <tbody>
                <?php if($records): ?>
                <?php foreach($records as $record): ?>
                <tr>
                    <td><?php echo strtoupper($record->Name); ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_st != 0 ? number_format($record->rd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_ot != 0 ? number_format($record->rd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_nd != 0 ? number_format($record->rd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->rd_ndot != 0 ? number_format($record->rd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_st != 0 ? number_format($record->shol_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_ot != 0 ? number_format($record->shol_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_nd != 0 ? number_format($record->shol_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->shol_ndot != 0 ? number_format($record->shol_ndot, 2, '.', ',') : ""; ?></td>
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
                    <td style="text-align:right;"><?php echo $record->extra != 0 ? number_format($record->extra, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->silpat != 0 ? number_format($record->silpat, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->adjustment != 0 ? number_format($record->adjustment, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->incentive != 0 ? number_format($record->incentive, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->addpay != 0 ? number_format($record->addpay, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->volumepay != 0 ? number_format($record->volumepay, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->allowance != 0 ? number_format($record->allowance, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->cola != 0 ? number_format($record->cola, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->grosspay != 0 ? number_format($record->grosspay, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->sss_ec != 0 ? number_format($record->sss_ec, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->sss_er != 0 ? number_format($record->sss_er, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->phic_er != 0 ? number_format($record->phic_er, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->hdmf_er != 0 ? number_format($record->hdmf_er, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $record->total != 0 ? number_format($record->total, 2, '.', ',') : ""; ?></td>
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
                $total_extra = $total_extra + $record->extra;
                $total_silpat = $total_silpat + $record->silpat;
                $total_adjustment = $total_adjustment + $record->adjustment;
                $total_incentive = $total_incentive + $record->incentive;
                $total_addpay = $total_addpay + $record->addpay;
                $total_volumepay = $total_volumepay + $record->volumepay;
                $total_allowance = $total_allowance + $record->allowance;
                $total_cola = $total_cola + $record->cola;
                $total_grosspay = $total_grosspay + $record->grosspay;
                $total_sss_ec = $total_sss_ec + $record->sss_ec;
                $total_sss_er = $total_sss_er + $record->sss_er;
                $total_phic_er = $total_phic_er + $record->phic_er;
                $total_hdmf_er = $total_hdmf_er + $record->hdmf_er;
                $total_total = $total_total + $record->total;
                ?>
                <?php endforeach; ?>
                <tr>
                    <td style="text-align:right;">TOTAL:</td>
                    <td style="text-align:right;"><?php echo $total_rd_st != 0 ? number_format($total_rd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rd_ot != 0 ? number_format($total_rd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rd_nd != 0 ? number_format($total_rd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rd_ndot != 0 ? number_format($total_rd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_shol_st != 0 ? number_format($total_shol_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_shol_ot != 0 ? number_format($total_shol_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_shol_nd != 0 ? number_format($total_shol_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_shol_ndot != 0 ? number_format($total_shol_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rhol_st != 0 ? number_format($total_rhol_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rhol_ot != 0 ? number_format($total_rhol_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rhol_nd != 0 ? number_format($total_rhol_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rhol_ndot != 0 ? number_format($total_rhol_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_shrd_st != 0 ? number_format($total_shrd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_shrd_ot != 0 ? number_format($total_shrd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_shrd_nd != 0 ? number_format($total_shrd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_shrd_ndot != 0 ? number_format($total_shrd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rhrd_st != 0 ? number_format($total_rhrd_st, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rhrd_ot != 0 ? number_format($total_rhrd_ot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rhrd_nd != 0 ? number_format($total_rhrd_nd, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_rhrd_ndot != 0 ? number_format($total_rhrd_ndot, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_extra != 0 ? number_format($total_extra, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_silpat != 0 ? number_format($total_silpat, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_adjustment != 0 ? number_format($total_adjustment, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_incentive != 0 ? number_format($total_incentive, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_addpay != 0 ? number_format($total_addpay, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_volumepay != 0 ? number_format($total_volumepay, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_allowance != 0 ? number_format($total_allowance, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_cola != 0 ? number_format($total_cola, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_grosspay != 0 ? number_format($total_grosspay, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_sss_ec != 0 ? number_format($total_sss_ec, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_sss_er != 0 ? number_format($total_sss_er, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_phic_er != 0 ? number_format($total_phic_er, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_hdmf_er != 0 ? number_format($total_hdmf_er, 2, '.', ',') : ""; ?></td>
                    <td style="text-align:right;"><?php echo $total_total != 0 ? number_format($total_total, 2, '.', ',') : ""; ?></td>
                </tr>
                <?php if($admin_percentage != 0): ?>
                <tr>
                    <td colspan="34" style="text-align:right;border:none;">Amount Billed (<?php echo $admin_percentage ?>% Admin Fee) (<?php echo number_format($total_total * ($admin_percentage/100), 2, '.', ','); ?>):</td>
                    <td style="text-align:right;"><?php echo $total_total != 0 ? number_format(($total_total) + ($total_total * ($admin_percentage/100)), 2, '.', ',') : ""; ?></td>
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
                <td style="width:30%;">Checked By:</td>
                <td></td>
                <td style="width:30%;">Approved By:</td>
            </tr>
            <tr>
                <td style="width:30%;"><br><?php echo strtoupper($prepared_by); ?></td>
                <td></td>
                <td style="width:30%;"><br><?php echo strtoupper($checked_by); ?></td>
                <td></td>
                <td style="width:30%;"><br><?php echo strtoupper($approved_by); ?></td>
            </tr>
            <tr>
                <td style="width:30%;"><br><br><br>Received By:</td>
                <td></td>
                <td style="width:30%;"></td>
                <td></td>
                <td style="width:30%;"></td>
            </tr>
            <tr>
                <td style="width:30%;"></td>
                <td></td>
                <td style="width:30%;"></td>
                <td></td>
                <td style="width:30%;"></td>
            </tr>
        </table>
    </body>
</html>