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

<form class="form-horizontal tasi-form" method="post" id="form-add">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{$title}}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        {{Form::label('type_id', 'ประเภทน้ำมัน', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-2">
                            {{ \Form::select('type_id', array('' => 'เลือกประเภทน้ำมัน') + \DB::table('oil_type_item')->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'type_id')); }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('machine_id', 'ระบบเครื่องจักร', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-2">
                            {{ \Form::select('machine_id', array('' => 'เลือกประเภทเครื่องจักร') + \DB::table('oil_machine_type')->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'machine_id')); }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('nas', 'NAS', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-2">
                            {{ \Form::select('nas', array('' => 'เลือกรายการ NAS'), null, array('class' => 'form-control', 'id' => 'nas')); }}
                        </div>
                    </div>
                    <div class="form-group" id="colour">
                        {{Form::label('colour', 'Color', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',3)->get() as $item_tan)
                            <label class="radio-inline">
                                {{Form::radio('colour',$item_tan->id)}} {{$item_tan->title}}
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('viscosity', 'Viscosity', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-2">
                            {{ \Form::select('kind_id', array('' => 'เลือกชนิดน้ำมัน',32=>'32',46=>'46',68=>'68',100=>'100'), null, array('class' => 'form-control', 'id' => 'kind_id')); }}
                            {{ \Form::select('viscosity', array('' => 'เลือกรายการ Viscosity')+ \DB::table('oil_status_item')->where('group_id',4)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'viscosity')); }}
                        </div>
                    </div>                    
                    <div class="form-group" id="tan">
                        {{Form::label('tan', 'TAN', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',5)->get() as $item_tan)
                            <label class="radio-inline">
                                {{Form::radio('tan',$item_tan->id)}} {{$item_tan->title}}
                            </label>
                            @endforeach        
                        </div>
                    </div>                    
                    <div class="form-group" id="moisture">
                        {{Form::label('moisture', 'Moisture', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',6)->get() as $item_moisture)
                            <label class="radio-inline">
                                {{Form::radio('moisture',$item_moisture->id)}} {{$item_moisture->title}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('oxidation', 'Oxidation', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',7)->get() as $item_oxidation)
                            <label class="radio-inline">
                                {{Form::radio('oxidation',$item_oxidation->id)}} {{$item_oxidation->title}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('nitration', 'Nitration', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',8)->get() as $item_nitration)
                            <label class="radio-inline">
                                {{Form::radio('nitration',$item_nitration->id)}} {{$item_nitration->title}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group hidden" id="density">
                        {{Form::label('density', 'Density', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',9)->get() as $item_nitration)
                            <label class="radio-inline">
                                {{Form::radio('density',$item_nitration->id)}} {{$item_nitration->title}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group hidden" id="intensity">
                        {{Form::label('intensity', 'ความเข้มข้นของน้ำในน้ำมัน', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',10)->get() as $item_nitration)
                            <label class="radio-inline">
                                {{Form::radio('intensity',$item_nitration->id)}} {{$item_nitration->title}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('diagnose', 'วินิจฉัย', array('class' => 'col-sm-2 control-label'))}}
                        <div class="col-sm-4">
                            {{Form::textarea('diagnose', NULL,array('class'=>'form-control','id'=>'diagnose','rows'=>10))}}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('solve', 'การแก้ปัญหา', array('class' => 'col-sm-2 control-label'))}}
                        <div class="col-sm-4">
                            {{Form::textarea('solve', NULL,array('class'=>'form-control','id'=>'solve','rows'=>10))}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-3">
                            {{Form::button('บันทึกผลการวิเคราะห์',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
                            {{Form::button('ล้างรายการใหม่',array('class'=>'btn btn-lg','id'=>'btnReset'))}}    
                        </div>
                    </div>
                </div>
            </section>
        </div>    
    </div>
</form>
@stop

@section('script')
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
{{HTML::script('js/jquery.form.min.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $('#btnReset').click(function () {
        //$('input:radio').prop('checked', false);
        window.location.href = window.location.href;
    });
    $(function () {
        var options = {
            url: base_url + index_page + "oilservice/analysis/add",
            success: showResponse
        };
        $('#btnSave').click(function () {
            $('#form-add, textarea').ajaxSubmit(options);
        });
    });

    function showResponse(response, statusText, xhr, $form) {
        if (response.error.status === false) {
            $('#btnSave').removeAttr('disabled');
            alert(response.error.message);
        } else {
            window.location.href = base_url + index_page + "oilservice/analysis";
        }
    }

    $('#machine_id').change(function () {
        $.get("{{ url('get/getOilNas')}}",
                {option: $(this).val(), group_id: 1, type_id: $('#type_id').val()}, function (data) {
            var nas = $('#nas');
            nas.empty();
            nas.append("<option value=''>เลือกรายการ NAS</option>");
            $.each(data, function (index, element) {
                nas.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });

    });

    $('#type_id').change(function () {
        if ($(this).val() == 3) {
            $('#density').removeClass('hidden');
            $('#intensity').removeClass('hidden');
            $('#colour').addClass('hidden');
            $('#moisture').addClass('hidden');
            $('#tan').addClass('hidden');
        } else {
            $('#density').addClass('hidden');
            $('#intensity').addClass('hidden');
            $('#colour').removeClass('hidden');
            $('#moisture').removeClass('hidden');
            $('#tan').removeClass('hidden');
        }
        $.get("{{ url('get/getOilMachine')}}",
                {option: $(this).val()}, function (data) {
            var machine = $('#machine_id');
            machine.empty();
            machine.append("<option value=''>เลือกประเภทเครื่องจักร</option>");
            $.each(data, function (index, element) {
                machine.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });

        $.get("{{ url('get/getOilNas')}}",
                {option: $('#machine_id').val(), group_id: 1, type_id: $('#type_id').val()}, function (data) {
            var nas = $('#nas');
            nas.empty();
            nas.append("<option value=''>เลือกรายการ NAS</option>");
            $.each(data, function (index, element) {
                nas.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });
</script>
@stop