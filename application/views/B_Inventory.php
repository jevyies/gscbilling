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
                    <th>Item/ Parts</th>
                    <th>Account Group</th>
                    <th>Account Code</th>
                    <th>Account Name</th>
                    <th>Remaining Item/s</th>
                </tr>
            </thead>
            <tbody>
                <?php if($records): ?>
                <?php foreach($records as $record): ?>
                <tr>
                    <td><?php echo $record->EPLName; ?></td>
                    <td><?php echo $record->AccountGroup; ?></td>
                    <td><?php echo $record->SubCode; ?></td>
                    <td><?php echo $record->AccountName; ?></td>
                    <td><?php echo $record->Balance; ?></td>
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