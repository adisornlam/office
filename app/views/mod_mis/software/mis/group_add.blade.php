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

{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">{{$title}}</div>
            <div class="panel-body">
                <div class="form-group">
                    {{Form::label('title', 'ชื่อกลุ่ม Software', array('class' => 'col-sm-2 control-label req'))}}
                    <div class="col-sm-3">
                        {{Form::text('title', NULL,array('class'=>'form-control','id'=>'title'))}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label col-lg-2" for="hsware_item">เลือก Software</label>
                    <div class="col-lg-6">
                        <?php
                        foreach (\DB::table('software_item')
                                ->orderBy('title', 'asc')
                                ->select(array('id', 'title'))
                                ->get() as $software_item) {
                            ?>
                            <div class="checkbox">
                                <label>
                                    {{Form::checkbox('software_id[]', $software_item->id)}}
                                    {{$software_item->title}}
                                </label>
                            </div>
                        <?php }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
                    </div>
                </div>
            </div>
        </div>
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
    $(function () {
        var options = {
            url: base_url + index_page + "mis/software/group/add",
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
            window.location.href = base_url + index_page + "mis/software/group";
        }
    }
</script>
@stop