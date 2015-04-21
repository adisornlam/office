@extends('layouts.master')
@section('style')
{{HTML::style('css/star-rating.min.css')}}
{{HTML::style('assets/bootstrap-datepicker/css/datepicker3.css')}}
{{HTML::style('css/bootstrap-select.min.css')}}
@stop
@section('content')
@if(isset($breadcrumbs))
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            @foreach ($breadcrumbs as $key => $val)
            @if ($val === reset($breadcrumbs))
            <li><a href="{{URL::to($val)}}"><i class="fa fa-home"></i> {{$key}}</a></li>
            @elseif ($val === end($breadcrumbs))
            <li class="active">{{$key}}</li>
            @else
            <li><a href="{{URL::to($val)}}"> {{$key}}</a></li>
            @endif
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{$title}}
            </header>
            <div class="panel-body">    
                <form class="form-horizontal tasi-form" method="get">
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">วันที่แจ้ง</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$item->created_at}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">ผู้แจ้งเรื่อง</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$user->firstname}} {{$user->lastname}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">ประเภทอุปกรณ์</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$group->title}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">รายละเอียด</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$item->desc}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">ผู้รับเรื่อง</label>
                        <div class="col-sm-9">
                            @if($item->receive_user==0)
                            {{Form::button('รับรายการแจ้งซ่อม',array('class'=>'btn btn-primary','id'=>'btnReceive'))}}    
                            @else
                            {{$receive_user->firstname}} {{$receive_user->lastname}}
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@if($item->status==1)
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                รายงานการให้บริการ
            </header>
            <div class="panel-body">    
                {{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}         
                <div class="form-group">
                    {{Form::label('type_id', 'ประเภทดำเนินการ', array('class' => 'col-sm-2 control-label req'))}}
                    <div class="col-sm-5">
                        <label class="radio-inline">
                            <input type="radio" name="type_id" class="type_id" value="1" checked="checked"> ซ่อม
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type_id" class="type_id" value="2"> เปลี่ยน
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type_id" class="type_id" value="3"> เคลม
                        </label>
                    </div>
                </div>       
                <div class="form-group">
                    {{Form::label('computer_id', 'เลขระเบียน', array('class' => 'col-sm-2 control-label req'))}}
                    <div class="col-sm-3">
                        {{ \Form::select('computer_id', array(''=>'ค้นหาเลขระเบียน')+$computer,null, array('class' => 'form-control selectpicker', 'id' => 'computer_id','data-live-search'=>'true','data-style'=>'btn-info')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('publem_id', 'กลุ่มปัญหา', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-3">
                        {{ \Form::select('publem_id', array(''=>'เลือกกลุ่มปัญหา')+$publem, null, array('class' => 'form-control', 'id' => 'publem_id')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('desc2', 'รายละเอียด', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-4">
                        {{Form::textarea('desc2', NULL,array('class'=>'form-control','id'=>'desc2','rows'=>10))}}
                    </div>
                </div>   
                <div class="form-group hidden">
                    {{Form::label('hsware_id', 'อะไหล่', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-3">
                        {{ \Form::select('hsware_id', array('' => 'กรุณาเลือกอะไหล่') , null, array('class' => 'form-control', 'id' => 'hsware_id')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('status', 'สถานะ', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-3">
                        {{ \Form::select('status', array(''=>'เลือกสถานะ',1=>'ดำเนินการซ่อม / แก้ไข เรียบร้อย ใช้งานได้ตามปกติ',2=>'ดำเนินการซ่อมตามสถานที่ที่แจ้ง',3=>'ส่งซ่อมภายนอก',4=>'ไม่สามารถซ่อมได้ / ใช้งานได้ เนื่องจาก'), null, array('class' => 'form-control', 'id' => 'status')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('success_at', 'วันที่ซ่อมเสร็จ', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-2">
                        <div class="input-group date form_datetime-component">
                            {{Form::text('success_at', date('Y-m-d'),array('class'=>'form-control datepicker','id'=>'success_at','placeholder'=>'วันที่ซ่อมเสร็จ'))}}
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group hidden" id="status_radio">
                    <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">&nbsp;</label>
                    <div class="col-lg-10">
                        <div class="radio">
                            <label>
                                {{Form::radio('status_radio_1', 1,true,['class'=>'status_radio'])}} ไม่มีค่าใช้จ่าย อยู่ในรับประกัน
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                {{Form::radio('status_radio_1', 2,false,['class'=>'status_radio'])}} มีค่าใช้จ่าย
                            </label>
                        </div>
                        <div class="col-lg-2">
                            <input type="text" placeholder="จำนวนบาท" name="cost" id="cost" class="form-control" disabled>
                        </div>
                    </div>
                </div>                
                <div class="form-group hidden" id="div_remark">
                    {{Form::label('remark', 'หมายเหตุ', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-7">
                        {{Form::text('remark', NULL,array('class'=>'form-control','id'=>'remark'))}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </section>
    </div>
</div>
@elseif ($item->status>=2)
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                รายงานการให้บริการ
            </header>
            <div class="panel-body">
                <form class="form-horizontal tasi-form" method="get">
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">ใช้เวลาในการดำเนินการ</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                <?php
                                $created = \Carbon::createFromTimeStamp(strtotime($item->created_at));
                                $updated = \Carbon::createFromTimeStamp(strtotime($item->updated_at));
                                echo $updated->diffInHours($created);
                                ?> ชั่วโมง
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">รายละเอียด</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$item->desc2}}</p>
                        </div>
                    </div>     
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">สถานะ</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                @if($item->status_success==1)
                                ดำเนินการซ่อม / แก้ไข เรียบร้อย ใช้งานได้ตามปกติ
                                @elseif ($item->status_success==2)
                                ดำเนินการซ่อมตามสถานที่ที่แจ้ง
                                @elseif ($item->status_success==3)
                                ส่งซ่อมภายนอก
                                @if($item->status_radio==1)
                                ไม่มีค่าใช้จ่าย อยู่ในรับประกัน
                                @elseif ($item->status_radio==2)
                                มีค่าใช้จ่าย จำนวน {{$item->cost}} บาท
                                @else

                                @endif
                                @elseif ($item->status_success==4)
                                ไม่สามารถซ่อมได้ / ใช้งานได้ เนื่องจาก {{$item->remark}}
                                @else

                                @endif
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                ให้คะแนนความพึงพอใจในการให้บริการ
            </header>
            <div class="panel-body">
                <input id="input-id" type="number" class="rating" min=0 max=5 step=1 data-size="lg" >
            </div>
        </section>
    </div>
</div>
@endif
@stop

@section('script')
{{HTML::script('js/star-rating.min.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
{{HTML::script('js/bootstrap-select.min.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'th'
    });
    $('#status').change(function () {
        $('#status_radio').addClass('hidden');
        $('#div_remark').addClass('hidden');
        if ($(this).val() == 3) {
            $('#status_radio').removeClass('hidden');
        } else if ($(this).val() == 4) {
            $('#div_remark').removeClass('hidden');
        } else {
            $('#status_radio').addClass('hidden');
        }
    });
    $('.status_radio').click(function () {
        if ($(this).val() == 1) {
            $('#cost').attr('disabled', 'disabled');
        }
        if ($(this).val() == 2) {
            $('#cost').removeAttr('disabled');
        }
    });

    $('.type_id').click(function () {
        if ($(this).val() == 2) {
            $('#hsware_id').parent().parent().removeClass('hidden');
        } else {
            $('#hsware_id').parent().parent().addClass('hidden');
        }
    });

    $('#publem_id').change(function () {
        $.get("{{ url('get/hswareddl')}}",
                {option: $(this).val(), company_id:<?php echo (isset($receive_user->company_id) ? $receive_user->company_id : 0); ?>},
        function (data) {
            var hsware_id = $('#hsware_id');
            hsware_id.empty();
            hsware_id.append("<option value=''>กรุณาเลือกอะไหล่</option>");
            $.each(data, function (index, element) {
                hsware_id.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $('#btnReceive').click(function () {
        var data = {
            title: 'ยืนยันรับรายการแจ้งซ่อม',
            type: 'confirm',
            text: 'คุณต้องการรับรายการแจ้งซ่อมใช่หรือไม่ ?'
        };
        genModal(data);
        $('body').on('click', '#myModal #button-confirm', function () {
            var data3 = {
                url: 'mis/repairing/receive/<?php echo \Request::segment(4); ?>'
            };
            var rs = getDataUrl(data3);
            var obj = $.parseJSON(rs);
            if (obj.error.status === true)
            {
                $('#myModal').modal('hide');
                $('#myModal').on('hidden.bs.modal', function (e) {
                    window.location.href = window.location.href;
                });
            }

        });
    });
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "mis/repairing/view/<?php echo \Request::segment(4); ?>",
            data: $('#form-add, select, textarea input:not(#btnSave)').serializeArray(),
            success: function (data) {
                if (data.error.status == false) {
                    $('#btnSave').removeAttr('disabled');
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $.each(data.error.message, function (key, value) {
                        $('#' + key).parent().parent().addClass('has-error');
                        $('#' + key).after('<p class="help-block">' + value + '</p>');
                    });
                } else {
                    window.location.href = base_url + index_page + "mis/repairing";
                }
            }
        });
    });
<?php if ($item->rating > 0) { ?>
        $('#input-id').rating('update', <?php echo $item->rating; ?>);
        $('#input-id').rating('create', {disabled: true, showClear: false});
<?php } ?>
</script>
@stop