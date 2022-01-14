<?php 
    header('Content-type: application/excel');
    $filename = $filename . '-'. date('mdY') .'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
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

        @page { sheet-size: A4-L; }
        
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
        <table width="100%" class="main_t">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Item/ Parts</th>
                    <th>Reference</th>
                    <th>Control #</th>
                    <th>Quantity</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php if($records): ?>
                <?php foreach($records as $record): ?>
                <tr>
                    <td><?php echo $record->date_created; ?></td>
                    <td><?php echo $record->EPLName; ?></td>
                    <td><?php echo $record->reference; ?></td>
                    <td><?php echo $record->refControlNo; ?></td>
                    <td><?php echo $record->item_count; ?></td>
                    <td><?php echo $record->Remarks; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- footer -->
        <htmlpagefooter name="myFooter" class="footer" style="display:none">
            <div style="text-align: center;font-weight:bold;font-size:90%;">
                <!-- Page {PAGENO} of {nbpg} -->
            </div>
        </htmlpagefooter>
    </body>
</html>