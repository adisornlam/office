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

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Forms Wizard
            </header>
            <div class="panel-body">
                <div class="stepy-tab">
                    <ul id="default-titles" class="stepy-titles clearfix">
                        <li id="default-title-0" class="current-step">
                            <div>ข้อมูลคอมพิวเตอร์</div>
                        </li>
                        <li id="default-title-1" class="">
                            <div>Mainboard</div>
                        </li>
                        <li id="default-title-2" class="">
                            <div>CPU</div>
                        </li>
                        <li id="default-title-3" class="">
                            <div>HDD</div>
                        </li>
                        <li id="default-title-4" class="">
                            <div>RAM</div>
                        </li>
                        <li id="default-title-4" class="">
                            <div>Monitor</div>
                        </li>
                    </ul>
                </div>
                {{Form::open(array('name'=>'form-add','id'=>'default','method' => 'POST','role'=>'form','class'=>'form-horizontal','files'=>true))}}
                <fieldset title="Info" class="step" id="default-step-0">
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('company_id', 'สินทรัพย์บริษัท', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-3">
                                {{ \Form::select('company_id', $company, \Input::get('company_id'), array('class' => 'form-control', 'id' => 'company_id')); }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('serial_code', 'เลขระเบียน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                {{Form::text('serial_code', NULL,array('class'=>'form-control','id'=>'serial_code'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('access_no', 'ACC NO', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-3">
                                {{Form::text('access_no', NULL,array('class'=>'form-control','id'=>'access_no'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('type_id', 'ประเภทคอมพิวเตอร์', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-5">
                                <label class="checkbox-inline">
                                    <input type="radio" name="type_id" class="type_id" value="1" checked=""> PC
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="type_id" class="type_id" value="2"> Notebook
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'ชื่อคอมพิวเตอร์', array('class' => 'col-sm-2 control-label req'))}}
                            <div class="col-sm-3">
                                {{Form::text('title', NULL,array('class'=>'form-control','id'=>'title'))}}
                            </div>
                        </div>   
                        <div class="form-group">
                            {{Form::label('ip_address', 'IP Address', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                {{Form::text('ip_address', NULL,array('class'=>'form-control','id'=>'ip_address'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('mac_lan', 'Mac Address Lan Local', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                {{Form::text('mac_lan', NULL,array('class'=>'form-control','id'=>'mac_lan'))}}
                            </div>
                        </div>
                        <div class="form-group hidden">
                            {{Form::label('mac_wireless', 'Mac Address Wireless', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                {{Form::text('mac_wireless', NULL,array('class'=>'form-control','id'=>'mac_wireless'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('locations', 'ตำแหน่งวาง', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                {{ \Form::select('locations', $place,null, array('class' => 'form-control', 'id' => 'locations')); }}
                            </div>
                        </div>   
                        <div class="form-group">
                            {{Form::label('register_date', 'วันที่ลงทะเบียน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('register_date', date('Y-m-d'),array('class'=>'form-control datepicker','id'=>'register_date'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
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
                    </div>
                </fieldset>
                <fieldset title="Mainboard" class="step" id="default-step-1" >
                    <legend> </legend>                       

                </fieldset>
                <fieldset title="CPU" class="step" id="default-step-2" >
                    <legend> </legend>

                </fieldset>
                <fieldset title="HDD" class="step" id="default-step-3" >
                    <legend> </legend>

                </fieldset>
                <fieldset title="RAM" class="step" id="default-step-4" >
                    <legend> </legend>

                </fieldset>
                <fieldset title="Monitor" class="step" id="default-step-5" >
                    <legend> </legend>

                </fieldset>
                <input type="submit" class="finish btn btn-danger" value="Finish"/>
                {{ Form::close() }}
            </div>
        </section>
    </div>
</div>
@stop

@section('script')
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
{{HTML::script('js/jquery.form.min.js')}}
{{HTML::script('js/jquery.stepy.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'th'
    });


    $('.type_id').click(function () {
        if ($(this).is(':checked')) {
            if ($(this).val() == 1) {
                $('#mac_lan').parent().parent().removeClass('hidden');
                $('#mac_wireless').parent().parent().addClass('hidden');
            } else {
                $('#mac_wireless').parent().parent().removeClass('hidden');
                $('#mac_lan').parent().parent().addClass('hidden');
            }
        }
    });


    $(function () {
        $('#default').stepy({
            backLabel: 'Previous',
            block: true,
            nextLabel: 'Next',
            titleClick: true,
            titleTarget: '.stepy-tab'
        });
        var options = {
            url: base_url + index_page + "mis/computer/add",
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
            window.location.href = base_url + index_page + "mis/computer";
        }
    }
</script>
@stop