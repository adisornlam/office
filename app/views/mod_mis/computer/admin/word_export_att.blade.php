<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <style type="text/css">
            body {
                font-family: 'tahoma', sans-serif; 
                font-size: 12pt; 
                line-height: 1.7em;
                margin:0;
                padding:0;
                height:100%;
                background: white; 
            }
            #wrapper {
                min-height:100%;
                position:relative;
            }

            #content {
                padding:10px;
                padding-bottom:80px;   /* Height of the footer element */
            }
            #footer {
                width:100%;
                height:150px;
                position:absolute;
                bottom:0;
                left:0;
            }
            table.myTable { border-collapse:collapse; }
            table.myTable td, table.myTable th { border:1px solid black;padding:5px; }
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
            <table border="0" width="100%" class="myTable">
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
            <h3>ข้อมูลคอมพิวเตอร์</h3>
            <table border="0" width="100%" class="myTable">
                <tr>
                    <td width="20%">
                        <strong>Com Name</strong> 
                    </td>
                    <td>
                        <p>{{strtoupper($item->title)}}</p>
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
                        <p>{{$item->mac_lan}}</p>
                    </td>
                    <td><strong>Wireless Lan</strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><strong>IP Address</strong></td>
                    <td><p>{{$item->ip_address}}</p></td>
                    <td><strong>Location</strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><strong>วันที่เริ่มใช้งาน</strong></td>
                    <td>{{$item->register_date}}</td>
                    <td><strong>Supplier</strong></td>
                    <td><p>{{$item->supplier}}</p></td>
                </tr>
            </table>
            <h3>รายการอุปกรณ์</h3>
            <table border="0" width="100%" class="myTable">
                <?php
                foreach (\DB::table('hsware_group')
                        ->join('hsware_item', 'hsware_item.group_id', '=', 'hsware_group.id')
                        ->where('hsware_group.disabled', 0)
                        ->select(array('hsware_group.id', 'hsware_group.title'))
                        ->distinct()
                        ->get() as $group_item) {

                    if (\DB::table('computer_hsware')
                                    ->leftJoin('hsware_item', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                                    ->where('hsware_item.group_id', $group_item->id)
                                    ->where('computer_hsware.computer_id', $item->id)
                                    ->select(array(
                                        'hsware_item.id as id'
                                    ))->count() > 0) {
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
                                            'hsware_item.warranty_date as warranty'
                                        ))
                                        ->get() as $hs_item) {
                                    ?>
                                    <p>
                                        {{$hs_item->codes}} {{$hs_item->title}} {{\HswareItem::get_submodel($hs_item->sub_model)}}  {{\HswareItem::get_hsware($hs_item->id)}}  @if($hs_item->warranty=="0000-00-00") ประกัน LT @elseif($hs_item->warranty) วันหมดประกัน {{$hs_item->warranty}} @else ประกัน LT @endif
                                    </p>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php }
                }
                ?>
            </table>
        </div>
        <div id="footer">
            <table border="0" width="100%">
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
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
