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
        <style type="text/css">
            body {
                font-family: 'tahoma', sans-serif; 
                font-size: 1em; 
                line-height: 1.7em;
                margin:0;
                padding:0;
                height:100%;
            }
            #wrapper {
                min-height:100%;
                position:relative;
            }
            #header {
                padding:10px;
            }
            #content {
                padding:10px;
                padding-bottom:80px;   /* Height of the footer element */
            }
            #footer {
                width:100%;
                height:80px;
                position:absolute;
                bottom:0;
                left:0;
            }
            p {
                border-bottom: 1px dashed #999;
                display: inline;
            }

        </style>
    </head>
    <body>
        <div id="header">
            <table border="0" width="100%">
                <tr>
                    <td align="left">
                        {{HTML::image('img/arf/logo_arf.jpg',null,array('width'=>300))}}
                    </td>
                    <td align="right">
                        {{HTML::image('img/arf/address_arf.jpg',null,array('width'=>300))}}
                    </td>
                </tr>
            </table>
        </div>
        <div id="content">
            <table border="0" width="100%" id="table_head">
                <tr>
                    <td width="20%">
                        <strong>ทรัพย์สินบริษัท</strong>
                    </td>
                    <td>
                        <p>{{$item->company}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>เลขระเบียน</strong>
                    </td>
                    <td>
                        <p>{{$item->serial_code}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>สถานที่ใช้งาน</strong> 
                    </td>
                    <td>
                        <p>{{$item->place}}</p>
                    </td>
                </tr>
            </table>
            <hr />
            <table border="0" width="100%" id="table_head">
                <tr>
                    <td width="20%">
                        <strong>Computer Name</strong> 
                    </td>
                    <td>
                        <p>{{$item->title}}</p>
                    </td>
                    <td>
                        <strong>เจ้าของเครื่อง</strong> 
                    </td>
                    <td>
                        <p>{{$item->fullname}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Access No</strong> 
                    </td>
                    <td>
                        <p>{{$item->access_no}}</p>
                    </td>
                    <td>
                        <strong>ตำแหน่ง</strong> 
                    </td>
                    <td>
                        <p>{{$item->position}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Mac Address</strong>
                    </td>                   
                    <td>
                        <p>{{$item->place}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>IP Address</strong>
                    </td>
                    <td>
                        <p>{{$item->ip_address}}</p>
                    </td>
                </tr>
            </table>
            <hr />
            <table border="0" width="100%" id="table_head">
                <?php
                foreach (\DB::table('hsware_group')
                        ->join('hsware_item', 'hsware_item.group_id', '=', 'hsware_group.id')
                        ->where('hsware_group.disabled', 0)
                        ->select(array('hsware_group.id', 'hsware_group.title'))
                        ->distinct()
                        ->get() as $group_item) {
                    ?>
                    <tr>
                        <td width="20%">
                            <strong>{{$group_item->title}}</strong> 
                        </td>
                        <td>
                            <?php
                            foreach (\DB::table('computer_hsware')
                                    ->leftJoin('hsware_item', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                                    ->join('hsware_model', 'hsware_model.id', '=', 'hsware_item.model_id')
                                    ->where('hsware_item.group_id', $group_item->id)
                                    ->where('computer_hsware.computer_id', $item->id)
                                    ->select(array(
                                        'hsware_item.id as id',
                                        'hsware_item.sub_model as sub_model',
                                        'hsware_item.serial_code as codes',
                                        'hsware_model.title as title',
                                        'hsware_item.status as status',
                                    ))
                                    ->get() as $hs_item) {
                                ?>
                                <p>{{$hs_item->codes}} {{$hs_item->title}} {{\HswareItem::get_submodel($hs_item->sub_model)}}  {{\HswareItem::get_hsware($hs_item->id)}}</p>
                            <?php } ?>
                        </td>                    
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div id="footer">
            <table border="0" width="100%">
                <tr>
                    <td align="left">
                        {{HTML::image('img/arf/address_footer.jpg',null,array('width'=>300))}}
                    </td>
                    <td align="right">
                        {{HTML::image('img/att/cer_att.jpg',null,array('width'=>300))}}
                    </td>
                </tr>
            </table>
        </div>

    </body>
</html>
