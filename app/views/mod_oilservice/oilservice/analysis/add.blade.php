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
                        {{Form::label('viscosity', 'Viscosity', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',1)->get() as $item_viscosity)
                            <label class="radio-inline">
                                {{Form::radio('viscosity',$item_viscosity->wieht,(\Input::get('viscosity')==$item_viscosity->wieht?TRUE:FALSE))}} {{$item_viscosity->wieht}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('viscosity', 'NAS', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',2)->get() as $item_nas)
                            <label class="radio-inline">
                                {{Form::radio('nas',$item_nas->wieht,(\Input::get('nas')==$item_nas->wieht?TRUE:FALSE))}} {{$item_nas->wieht}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('colour', 'Colour', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',3)->get() as $item_colour)
                            <label class="radio-inline">
                                {{Form::radio('colour',$item_colour->wieht,(\Input::get('colour')==$item_colour->wieht?TRUE:FALSE))}} {{$item_colour->wieht}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('moisture', 'Moisture', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',4)->get() as $item_moisture)
                            <label class="radio-inline">
                                {{Form::radio('moisture',$item_moisture->wieht,(\Input::get('moisture')==$item_moisture->wieht?TRUE:FALSE))}} {{$item_moisture->wieht}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('oxidation', 'Oxidation', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',5)->get() as $item_oxidation)
                            <label class="radio-inline">
                                {{Form::radio('oxidation',$item_oxidation->wieht,(\Input::get('oxidation')==$item_oxidation->wieht?TRUE:FALSE))}} {{$item_oxidation->wieht}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('nitration', 'Nitration', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',6)->get() as $item_nitration)
                            <label class="radio-inline">
                                {{Form::radio('nitration',$item_nitration->wieht,(\Input::get('nitration')==$item_nitration->wieht?TRUE:FALSE))}} {{$item_nitration->wieht}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('tan', 'TAN', array('class' => 'col-sm-2 control-label req'))}}
                        <div class="col-sm-9">
                            @foreach(\DB::table('oil_status_item')->where('group_id',7)->get() as $item_tan)
                            <label class="radio-inline">
                                {{Form::radio('tan',$item_tan->wieht,(\Input::get('tan')==$item_tan->wieht?TRUE:FALSE))}} {{$item_tan->wieht}}
                            </label>
                            @endforeach        
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-3">
                            {{Form::submit('แสดงผลการวิเคราะห์',array('class'=>'btn btn-primary btn-lg'))}}    
                            {{Form::button('ล้างรายการใหม่',array('class'=>'btn btn-lg','id'=>'btnReset'))}}    
                        </div>
                    </div>
                </div>
            </section>
        </div>    
    </div>

    @if(\Request::isMethod('post'))
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    ผลการวิเคราะห์
                </header>
                <div class="panel-body">                    
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Viscosity</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                {{$viscosity_rp}}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">NAS</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                {{$nas_rp}}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Colour</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                {{$colour_rp}}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Moisture</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                {{$moisture_rp}}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Oxidation</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                {{$oxidation_rp}}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Nitration</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                {{$nitration_rp}}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">TAN</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                {{$tan_rp}}
                            </p>
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
                        <div class="col-sm-offset-2 col-sm-10">
                            {{Form::button('บันทึกผลการวิเคราะห์',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
                        </div>
                    </div>                         
                </div>
            </section>
        </div>
    </div>
</form>
@endif
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
            url: base_url + index_page + "oilservice/analysis/save",
            success: showResponse
        };
        $('#btnSave').click(function () {
            $('#form-add, textarea').ajaxSubmit(options);
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
            window.location.href = base_url + index_page + "oilservice/analysis";
        }
    }
</script>
@stop