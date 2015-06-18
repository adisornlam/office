<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$item->serial_code}}</title>
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
            <h3>ข้อมูลอุปกรณ์ {{$item->group_title}}</h3>
            <table border="0" width="100%" class="myTable">
                <tr>
                    <td width="20%">
                        <strong>ชื่ออุปกรณ์</strong> 
                    </td>
                    <td>
                        <p>{{$item->title}} {{\HswareItem::get_submodel($item->sub_model)}}</p>
                    </td>
                    <td width="20%">
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
                        <strong>ประกัน</strong>
                    </td>                   
                    <td>
                        <p>&nbsp;</p>
                    </td>
                    <td><strong>วันที่เริ่มใช้งาน</strong></td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <h3>รายละเอียดอุปกรณ์</h3>
            <table border="0" width="100%" class="myTable">       
                @foreach($spec_label as $item_label)
                <tr>
                    <td width="20%">
                        <strong>{{Form::label('', $item_label->title, array('class' => 'col-sm-2 control-label'))}}</strong> 
                    </td>
                    <td>
                        <?php
                        $val = $item->{$item_label->name};
                        ?>
                        @if($item_label->option_id>0)
                        @if($val>0)
                        {{\HswareSpecOptionItem::find($val)->title}}
                        @endif
                        @else
                        {{$val}}
                        @endif

                    </td>                    
                </tr>
                @endforeach
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
