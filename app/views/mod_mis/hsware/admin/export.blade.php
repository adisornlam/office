<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="export_' . time() . '.xls"'); #ชื่อไฟล์
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"  xmlns:x="urn:schemas-microsoft-com:office:excel"  xmlns="http://www.w3.org/TR/REC-html40">
    <html>
        <head>
            <meta charset="UTF-8">
                <title></title>
        </head>
        <body>
            <TABLE  x:str BORDER="1">

                <TR>

                    <TD><b>AAA</b></TD>

                    <TD><b>AAA</b></TD>

                    <TD><b>AAA</b></TD>

                </TR>

                <TR>

                    <TD>BBB</TD>

                    <TD>BBB</TD>

                    <TD>BBB</TD>

                </TR>

                <TR>

                    <TD>001</TD>

                    <TD>002</TD>

                    <TD>003</TD>

                </TR>

                <TR>

                    <TD>ภาษาไทย</TD>

                    <TD>ภาษาไทย</TD>

                    <TD>ภาษาไทย</TD>

                </TR>

            </TABLE>

        </body>
    </html>
