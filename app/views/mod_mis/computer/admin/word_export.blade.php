<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=testing.doc");
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
    </head>
    <body>
        <div id="header">
            <table border="0" width="100%">
                <tr>
                    <td align="left">
                        {{HTML::image('img/att/logo_att.jpg',null,array('width'=>300))}}
                    </td>
                    <td align="right">
                        {{HTML::image('img/att/adds_att.jpg',null,array('width'=>300))}}
                    </td>
                </tr>
            </table>
        </div>
        <div id="content">
            <table cellspacing="0"  cellpadding="0" border="1" width="100%">
                <tr>
                    <td>
                        ทรัพย์สินบริษัท {{$company}}
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
        </div>
        <div id="footer">
            <table border="0" width="100%">
                <tr>
                    <td align="left">
                        {{HTML::image('img/att/adds_att.jpg',null,array('width'=>300))}}
                    </td>
                    <td align="right">
                        {{HTML::image('img/att/cer_att.jpg',null,array('width'=>300))}}
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
