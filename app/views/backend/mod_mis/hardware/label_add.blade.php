@extends('backend.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{$title}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            @foreach ($breadcrumbs as $key => $val)
            @if ($val === reset($breadcrumbs))
            <li><a href="{{URL::to($val)}}"><i class="icon-home"></i> {{$key}}</a></li>
            @elseif ($val === end($breadcrumbs))
            <li class="active">{{$key}}</li>
            @else
            <li><a href="{{URL::to($val)}}"> {{$key}}</a></li>
            @endif
            @endforeach
        </ul>
    </div>
</div>    
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                {{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
                <div class="form-group">
                    {{Form::label('category_id', 'หมวดหมู่', array('class' => 'col-sm-2 control-label req'));}}
                    <div class="col-sm-3">
                        {{ \Form::select('category_id', array('' => 'เลือกหมวดหมู่') + $category, null, array('class' => 'form-control', 'id' => 'category_id')); }}
                    </div>
                </div>
                @for($i=1; $i<=20; $i++)
                <div class="form-group">
                    {{Form::label(($i<10?'label_0'.$i:'label_'.$i), 'Label '.$i, array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-3">
                        {{Form::text(($i<10?'label_0'.$i:'label_'.$i), NULL,array('class'=>'form-control','id'=>($i<10?'label_0'.$i:'label_'.$i)))}}
                    </div>
                </div>
                @endfor
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop

@section('script_code')
<script type="text/javascript">
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "mis/backend/hardware/label/add",
            data: $('#form-add, select input:not(#btnSave)').serializeArray(),
            success: function (data) {
                if (data.error.status == false) {
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $('#btnSave').removeAttr('disabled');
                    $.each(data.error.message, function (key, value) {
                        $('#' + key).parent().parent().addClass('has-error');
                        $('#' + key).after('<p class="help-block">' + value + '</p>');
                    });
                } else {
                    window.location.href = base_url + index_page + "mis/backend/hardware/label";
                }
            }
        });
    });
</script>
@stop