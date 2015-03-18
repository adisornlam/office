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
                            @if(!\Input::has('spare'))
                            <div class="form-group">
                                {{Form::label('disabled', '&nbsp;', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-3">
                                    <label>
                                        {{Form::checkbox('spare', 1,($item->spare==1?TRUE:FALSE))}} อะไหล่
                                    </label>
                                </div>
                            </div>
                            @else
                            {{ (\Input::has('spare')?Form::hidden('spare',1):null)}}
                            @endif
                            <div class="form-group">
                                {{Form::label('model_id', 'ยี่ห้อ/รุ่น', array('class' => 'col-sm-2 control-label req'));}}
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            {{ \Form::select('model_id',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',$item->group_id)->lists('title', 'id'), $item->model_id, array('class' => 'form-control', 'id' => 'model_id')); }}
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id={{$item->group_id}}" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hidden">
                                {{Form::label('sub_model', 'รุ่น', array('class' => 'col-sm-2 control-label'));}}
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            {{ \Form::select('sub_model', array('' =>'กรุณาเลือกรุ่น'), null, array('class' => 'form-control', 'id' => 'sub_model'));}}
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="#" id="btnAddSubModel" class="btn btn-primary" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มรุ่นอุปกรณ์</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('company_id', 'สินทรัพย์บริษัท', array('class' => 'col-sm-2 control-label'));}}
                                <div class="col-sm-3">
                                    {{ \Form::select('company_id', $company, $item->company_id, array('class' => 'form-control', 'id' => 'company_id')); }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('serial_code', 'เลขระเบียน', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    {{Form::text('serial_code',  $item->serial_code,array('class'=>'form-control','id'=>'serial_code'))}}
                                </div>
                            </div>
                            @if(in_array($item->group_id, array(11,12,13,14,15,20,24)))
                            <div class="form-group">
                                {{Form::label('access_no', 'ACC NO', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-3">
                                    {{Form::text('access_no', $item->access_no,array('class'=>'form-control','id'=>'access_no'))}}
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                {{Form::label('serial_no', 'Serial Number', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-3">
                                    {{Form::text('serial_no', $item->serial_no,array('class'=>'form-control','id'=>'serial_no'))}}
                                </div>
                            </div>
                            @if(in_array($item->group_id, array(11,12,13,14,15,20,24)))
                            <div class="form-group">
                                {{Form::label('locations', 'ตำแหน่งวาง', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    {{ \Form::select('locations', $place,$item->locations, array('class' => 'form-control', 'id' => 'locations')); }}
                                </div>
                            </div>   
                            @endif 
                            <div class="form-group">
                                {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    <div class="input-group date form_datetime-component">
                                        {{Form::text('warranty_date', ($item->warranty_date!='0000-00-00'?$item->warranty_date:''),array('class'=>'form-control datepicker','id'=>'warranty_date'))}}
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
                                        {{Form::text('register_date',  $item->register_date,array('class'=>'form-control datepicker','id'=>'register_date'))}}
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
                                        {{Form::checkbox('disabled', 1,($item->disabled==0?TRUE:FALSE))}} เปิดใช้งาน
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
                                    <?php
                                    $val = $item->{$item_label->name};
                                    ?>
                                    @if($item_label->option_id>0)
                                    {{Form::select($item_label->name,
                                                \DB::table('hsware_spec_option')
                                                ->join('hsware_spec_option_item', 'hsware_spec_option.id', '=', 'hsware_spec_option_item.option_id')
                                                ->select('hsware_spec_option_item.title','hsware_spec_option_item.id')
                                                ->where('option_id',$item_label->option_id)
                                                ->lists('title','id'),
                                                $val,array('class'=>'form-control'))}}
                                    @else

                                    {{Form::text($item_label->name,$val,array('class'=>'form-control'))}}
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
                                    {{($item->photo1?HTML::image($item->photo1,$item->title,array('width'=>200)):'')}}
                                    <input type="file" class="default" name="photo1" />
                                    <input type="hidden" name="photo1_hidden" value="{{$item->photo1}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">รูปภาพประกอบที่ 2</label>
                                <div class="col-md-4">
                                    {{($item->photo2?HTML::image($item->photo2,$item->title,array('width'=>200)):'')}}
                                    <input type="file" class="default" name="photo2" />
                                    <input type="hidden" name="photo2_hidden" value="{{$item->photo2}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">รูปภาพประกอบที่ 3</label>
                                <div class="col-md-4">
                                    {{($item->photo3?HTML::image($item->photo3,$item->title,array('width'=>200)):'')}}
                                    <input type="file" class="default" name="photo3" />
                                    <input type="hidden" name="photo3_hidden" value="{{$item->photo3}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">รูปภาพประกอบที่ 4</label>
                                <div class="col-md-4">
                                    {{($item->photo4?HTML::image($item->photo4,$item->title,array('width'=>200)):'')}}
                                    <input type="file" class="default" name="photo4" />
                                    <input type="hidden" name="photo4_hidden" value="{{$item->photo4}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">รูปภาพประกอบที่ 5</label>
                                <div class="col-md-4">
                                    {{($item->photo5?HTML::image($item->photo5,$item->title,array('width'=>200)):'')}}
                                    <input type="file" class="default" name="photo5" />
                                    <input type="hidden" name="photo5_hidden" value="{{$item->photo5}}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
{{Form::hidden('group_id',$item->group_id)}}
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
    $('#model_id').change(function () {
        $('#btnAddSubModel').attr('href', base_url + index_page + 'mis/hsware/group/model/sub/' + $(this).val());
        $.get("{{ url('get/submodel')}}",
                {option: $(this).val()},
        function (data) {
            var submodel = $('#sub_model');
            submodel.parent().parent().parent().parent().removeClass('hidden');
            submodel.empty();
            submodel.append("<option value=''>กรุณาเลือกรุ่น</option>");
            $.each(data, function (index, element) {
                submodel.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });
    $(function () {
        var model_id = <?php echo ($item->model_id > 0 ? $item->model_id : 0); ?>;
        var sub_model = <?php echo ($item->sub_model > 0 ? $item->sub_model : 0); ?>;
        $('#btnAddSubModel').attr('href', base_url + index_page + 'mis/hsware/group/model/sub/' + model_id);
        if ($('#model_id').val()) {
            $.get("{{ url('get/submodel')}}",
                    {option: model_id},
            function (data) {
                var submodel = $('#sub_model');
                submodel.parent().parent().parent().parent().removeClass('hidden');
                submodel.empty();
                $.each(data, function (index, element) {
                    var sub_model_select = (element.id == '' + sub_model + '' ? "selected='selected'" : "");
                    submodel.append("<option value='" + element.id + "' " + sub_model_select + ">" + element.title + "</option>");
                });
            });
        }
        var options = {
            url: base_url + index_page + "mis/hsware/edit/{{$item->id}}",
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
            $('#spinner_loading').hide();
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