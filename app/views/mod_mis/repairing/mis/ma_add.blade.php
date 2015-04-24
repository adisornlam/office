@extends('layouts.master')
@section('style')
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
                    {{Form::label('desc', 'รายละเอียด', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-4">
                        {{Form::textarea('desc', NULL,array('class'=>'form-control','id'=>'desc','rows'=>10))}}
                    </div>
                </div>
                <div class="form-group hidden">
                    {{Form::label('software_id', 'Software', array('class' => 'col-sm-2 control-label'));}}
                    <div class="col-sm-3">
                        {{ \Form::select('software_id', array('' => 'เลือก Software')+\SoftwareItem::where('free',1)->where('disabled',0)->lists('title', 'id'),null, array('class' => 'form-control', 'id' => 'software_id')); }}
                    </div>
                </div>
                <div class="form-group hidden">
                    {{Form::label('license_group_id', 'Master License', array('class' => 'col-sm-2 control-label'));}}
                    <div class="col-sm-4">
                        {{ \Form::select('license_group_id', array('' => 'เลือก Software')+\DB::table('license_group')
                                    ->where('disabled',0)
                                    ->select('id', \DB::raw('CONCAT(master_key_title," (",master_key_code,") ",total) as title'))
                                    ->lists('title', 'id'),null, array('class' => 'form-control', 'id' => 'license_group_id')); }}
                    </div>
                </div>
                <div class="form-group hidden">
                    {{Form::label('license_id', 'License', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-4">
                        {{ \Form::select('license_id', array('' => 'กรุณาเลือก License') , null, array('class' => 'form-control', 'id' => 'license_id')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('sbit', 'BIT', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-1">
                        {{Form::text('sbit', NULL,array('class'=>'form-control','id'=>'sbit','placeholder'=>'32/64'))}}
                    </div>
                </div>
                <div class="form-group hidden">
                    {{Form::label('hsware_id', 'อะไหล่', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-3">
                        {{ \Form::select('hsware_id', array('' => 'กรุณาเลือกอะไหล่') , null, array('class' => 'form-control', 'id' => 'hsware_id')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('cost', 'ค่าใช้จ่าย', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-2">
                        {{Form::text('cost', NULL,array('class'=>'form-control','id'=>'cost'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('warranty', 'ประกัน', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-2">
                        <div class="input-group date form_datetime-component">
                            {{Form::text('warranty', null,array('class'=>'form-control datepicker','id'=>'warranty'))}}
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                        <span class="help-block">LT ไม่ต้องกำหนด</span>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('created_at', 'วันที่ลงทะเบียน', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-2">
                        <div class="input-group date form_datetime-component">
                            {{Form::text('created_at', date('Y-m-d'),array('class'=>'form-control datepicker','id'=>'created_at'))}}
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('status', 'สถานะ', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-2">
                        {{ \Form::select('status', array(''=>'เลือกสถานะ',0=>'รับเรื่องแล้ว',1=>'กำลังดำเนินการ',2=>'เรียบร้อยแล้ว'), null, array('class' => 'form-control', 'id' => 'status')); }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
                    </div>
                </div>
                {{Form::hidden('group_id',\Input::get('group_id'))}}
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
{{HTML::script('js/bootstrap-select.min.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $('.selectpicker').selectpicker();
    $('.datepicker').datepicker({
        autoclose: true, todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'th'
    });

    $('.type_id').click(function () {
        if ($(this).val() == 2) {
            $('#hsware_id').parent().parent().removeClass('hidden');
        } else {
            $('#hsware_id').parent().parent().addClass('hidden');
        }
    });

    $(function () {

        var options = {url: base_url + index_page + "mis/repairing/ma/add",
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
            window.location.href = base_url + index_page + "mis/repairing/ma";
        }
    }

    $('#publem_id').change(function () {
        if ($(this).val() != 31) {
            $('#software_id').parent().parent().addClass('hidden');
            $('#license_group_id').parent().parent().addClass('hidden');
            $('#license_id').parent().parent().addClass('hidden');
            $('#sbit').parent().parent().addClass('hidden');

            $.get("{{ url('get/hswareddl')}}",
                    {option: $(this).val(), company_id: <?php echo (\Input::get('company_id') ? \Input::get('company_id') : 0); ?>},
            function (data) {
                var hsware_id = $('#hsware_id');
                hsware_id.empty();
                hsware_id.append("<option value=''>กรุณาเลือกอะไหล่</option>");
                $.each(data, function (index, element) {
                    hsware_id.append("<option value='" + element.id + "'>" + element.title + "</option>");
                });
            });
        } else {
            $('#hsware_id').parent().parent().addClass('hidden');
            $('#software_id').parent().parent().removeClass('hidden');
            $('#license_group_id').parent().parent().removeClass('hidden');
            $('#license_id').parent().parent().removeClass('hidden');
            $('#sbit').parent().parent().removeClass('hidden');
        }
    });

    $('#license_group_id').change(function () {
        $.get("{{ url('get/licenseddl')}}",
                {option: $(this).val()},
        function (data) {
            var license_id = $('#license_id');
            license_id.empty();
            license_id.append("<option value=''>กรุณาเลือก License</option>");
            $.each(data, function (index, element) {
                license_id.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });
</script>
@stop