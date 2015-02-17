@extends('layouts.master')
@section('style')
{{HTML::style('assets/bootstrap-datepicker/css/datepicker3.css')}}
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

{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal','files'=>true))}}
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading tab-bg-dark-navy-blue tab-right ">
                <ul class="nav nav-tabs pull-right">
                    <li class="active">
                        <a data-toggle="tab" href="#info">
                            <i class="fa fa-info"></i>
                            ข้อมูลทั่วไป
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#option1">
                            <i class="fa fa-list"></i>
                            คุณสมบัติ
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#gallery">
                            <i class="fa fa-picture-o"></i>
                            รูปภาพอุปกรณ์
                        </a>
                    </li>
                </ul>
                <span class="hidden-sm wht-color">{{$title}}</span>
            </header>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="info" class="tab-pane active">
                        <div class="panel-body">
                            <div class="form-group">
                                {{Form::label('group_id', 'กลุ่มอุปกรณ์', array('class' => 'col-sm-2 control-label req'));}}
                                <div class="col-sm-3">
                                    {{ \Form::select('group_id', $group, \Input::get('group_id'), array('class' => 'form-control', 'id' => 'group_id')); }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('company_id', 'สินทรัพย์บริษัท', array('class' => 'col-sm-2 control-label'));}}
                                <div class="col-sm-3">
                                    {{ \Form::select('company_id', $company, NULL, array('class' => 'form-control', 'id' => 'company_id')); }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('model_id', 'ยี่ห้อ/รุ่น', array('class' => 'col-sm-2 control-label req'));}}
                                <div class="col-sm-3">
                                    {{ \Form::select('model_id',array('' => 'เลือกยี่ห้อ/รุ่น') +  \DB::table('hsware_model')->where('group_id',\Input::get('group_id'))->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id')); }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('access_no', 'ACC NO', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-3">
                                    {{Form::text('access_no', NULL,array('class'=>'form-control','id'=>'access_no'))}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('serial_no', 'Serial Number', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-3">
                                    {{Form::text('serial_no', NULL,array('class'=>'form-control','id'=>'serial_no'))}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    <div class="input-group date form_datetime-component">
                                        {{Form::text('warranty_date', NULL,array('class'=>'form-control datepicker','id'=>'warranty_date'))}}
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                    <span class="help-block">LT ไม่ต้องกำหนด</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('register_date', 'วันที่ลงทะเบียน', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    <div class="input-group date form_datetime-component">
                                        {{Form::text('register_date', NULL,array('class'=>'form-control datepicker','id'=>'register_date'))}}
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>         
                            <div class="form-group">
                                {{Form::label('count', 'จำนวนรายการ', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-1">
                                    {{Form::text('count', 1,array('class'=>'form-control','id'=>'count'))}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('disabled', '&nbsp;', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-3">
                                    <label>
                                        {{Form::checkbox('disabled', 1,TRUE)}} เปิดใช้งาน
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="option1" class="tab-pane">
                        <div class="panel-body">
                            @foreach($spec_label as $item_label)
                            <div class="form-group">
                                {{Form::label('', $item_label->title, array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-3">   
                                    @if($item_label->option_id>0)
                                    {{Form::select($item_label->name,
                                                \DB::table('hsware_spec_option')
                                                ->join('hsware_spec_option_item', 'hsware_spec_option.id', '=', 'hsware_spec_option_item.option_id')
                                                ->select('hsware_spec_option_item.title','hsware_spec_option_item.id')
                                                ->where('option_id',$item_label->option_id)
                                                ->lists('title','id'),
                                                NULL,array('class'=>'form-control'))}}
                                    @else
                                    {{Form::text($item_label->name,null,array('class'=>'form-control'))}}
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="gallery" class="tab-pane">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-md-2">รูปภาพประกอบที่ 1</label>
                                <div class="col-md-4">
                                    <input type="file" class="default" name="photo1" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">รูปภาพประกอบที่ 2</label>
                                <div class="col-md-4">
                                    <input type="file" class="default" name="photo2" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">รูปภาพประกอบที่ 3</label>
                                <div class="col-md-4">
                                    <input type="file" class="default" name="photo3" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">รูปภาพประกอบที่ 4</label>
                                <div class="col-md-4">
                                    <input type="file" class="default" name="photo4" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">รูปภาพประกอบที่ 5</label>
                                <div class="col-md-4">
                                    <input type="file" class="default" name="photo5" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
{{ Form::close() }}
@stop

@section('script')
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
{{HTML::script('js/jquery.form.min.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'th'
    });
    $(function () {
        var options = {
            url: base_url + index_page + "mis/hsware/add",
            success: showResponse
        };
        $('#btnSave').click(function () {
            $('#form-add').ajaxSubmit(options);
        });
    });

    function showResponse(response, statusText, xhr, $form) {
        if (response.error.status === false) {
            $('form .form-group').removeClass('has-error');
            $('form .help-block').remove();
            $('#btnSave').removeAttr('disabled');
            $.each(response.error.message, function (key, value) {
                $('#' + key).parent().parent().addClass('has-error');
                $('#' + key).after('<p class="help-block">' + value + '</p>');
            });
        } else {
            window.location.href = base_url + index_page + "mis/hsware";
        }
    }
</script>
@stop