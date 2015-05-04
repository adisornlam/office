<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>New Repairing</title>
        <style type="text/css">
            .tg  {border-collapse:collapse;border-spacing:0;}
            .tg td{font-family:Arial, sans-serif;font-size:20px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
        </style>
    </head>
    <body>
        <table class="tg" width="100%">
            <tr>
                <td class="tg">ผู้แจ้ง</td>
                <td class="tg"><?php echo $fullname; ?></td>
            </tr>
            <tr>
                <td class="tg">วันเวลาแจ้ง</td>
                <td class="tg"><?php echo $created_at; ?></td>
            </tr>
            <tr>
                <td class="tg">รายละเอียด</td>
                <td class="tg"><?php echo $desc; ?></td>
            </tr>
        </table>
        <p><a href="https://150.128.128.16/office/mis/repairing/view/<?php echo $id; ?>">คลิกที่นี่ เพื่อจัดการรายการแจ้งซ่อมใหม่</a></p>
    </body>
</html>
