<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Export PDF</title>
        <style type="text/css">
            body {
                margin-top: 0;
            }
        </style>
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
                        สินทรัพย์บริษัท ABC
                    </td>
                    <td>
                        {{$item->company}}
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