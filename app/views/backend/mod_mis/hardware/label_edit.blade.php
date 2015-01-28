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
                        {{ \Form::select('category_id',$category, $item->category_id, array('class' => 'form-control', 'id' => 'category_id')); }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_01" class="col-sm-2 control-label">Label 1</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_01" name="label_01" type="text" value="{{$item->label_01}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_02" class="col-sm-2 control-label">Label 2</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_02" name="label_02" type="text" value="{{$item->label_02}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_03" class="col-sm-2 control-label">Label 3</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_03" name="label_03" type="text" value="{{$item->label_03}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_04" class="col-sm-2 control-label">Label 4</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_04" name="label_04" type="text" value="{{$item->label_04}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_05" class="col-sm-2 control-label">Label 5</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_05" name="label_05" type="text" value="{{$item->label_05}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_06" class="col-sm-2 control-label">Label 6</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_06" name="label_06" type="text" value="{{$item->label_06}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_07" class="col-sm-2 control-label">Label 7</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_07" name="label_07" type="text" value="{{$item->label_07}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_08" class="col-sm-2 control-label">Label 8</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_08" name="label_08" type="text" value="{{$item->label_08}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_09" class="col-sm-2 control-label">Label 9</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_09" name="label_09" type="text" value="{{$item->label_09}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_10" class="col-sm-2 control-label">Label 10</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_10" name="label_10" type="text" value="{{$item->label_10}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_11" class="col-sm-2 control-label">Label 11</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_11" name="label_11" type="text" value="{{$item->label_11}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_12" class="col-sm-2 control-label">Label 12</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_12" name="label_12" type="text" value="{{$item->label_12}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_13" class="col-sm-2 control-label">Label 13</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_13" name="label_13" type="text" value="{{$item->label_13}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_14" class="col-sm-2 control-label">Label 14</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_14" name="label_14" type="text" value="{{$item->label_14}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_15" class="col-sm-2 control-label">Label 15</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_15" name="label_15" type="text" value="{{$item->label_15}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_16" class="col-sm-2 control-label">Label 16</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_16" name="label_16" type="text" value="{{$item->label_16}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_17" class="col-sm-2 control-label">Label 17</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_17" name="label_17" type="text" value="{{$item->label_17}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_18" class="col-sm-2 control-label">Label 18</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_18" name="label_18" type="text" value="{{$item->label_18}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_19" class="col-sm-2 control-label">Label 19</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_19" name="label_19" type="text" value="{{$item->label_19}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="label_20" class="col-sm-2 control-label">Label 20</label>
                    <div class="col-sm-3">
                        <input class="form-control" id="label_20" name="label_20" type="text" value="{{$item->label_20}}">
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('disabled', '&nbsp;', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-2">
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
                {{Form::hidden('id',$item->id)}}
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
            url: base_url + index_page + "mis/backend/hardware/label/edit/{{$item->id}}",
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