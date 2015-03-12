@extends('layouts.master')
@section('style')
{{HTML::style('assets/advanced-datatable/media/css/demo_page.css')}}
{{HTML::style('assets/advanced-datatable/media/css/demo_table.css')}}
{{HTML::style('assets/data-tables/DT_bootstrap.css')}}
{{HTML::style('css/style-responsive.css')}}
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
            <header class="panel-heading">
                {{$title}}
            </header>
            <div class="panel-body">
                <div class="form-group">
                    {{Form::label('company_id', 'สินทรัพย์บริษัท', array('class' => 'col-sm-2 control-label req'));}}
                    <div class="col-sm-3">
                        {{ \Form::select('company_id', $company, \Input::get('company_id'), array('class' => 'form-control', 'id' => 'company_id')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('codes', 'เลขที่เอกสาร', array('class' => 'col-sm-2 control-label req'))}}
                    <div class="col-sm-2">
                        {{Form::text('codes', NULL,array('class'=>'form-control','id'=>'codes'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('title', 'เรื่อง', array('class' => 'col-sm-2 control-label req'))}}
                    <div class="col-sm-5">
                        {{Form::text('title', NULL,array('class'=>'form-control','id'=>'title'))}}
                    </div>
                </div>   
                <div class="form-group">
                    {{Form::label('title', 'เหตุผลขอซื้อ', array('class' => 'col-sm-2 control-label req'))}}
                    <div class="col-sm-8">
                        {{Form::text('title', NULL,array('class'=>'form-control','id'=>'title'))}}
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<section class="panel">
    <header class="panel-heading">
        รายการที่สั่งซื้อ
    </header>
    <div class="panel-body">
        <div class="adv-table editable-table ">
            <div class="clearfix">
                <div class="btn-group">
                    <button id="editable-sample_new" class="btn green">
                        Add New <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="space15"></div>
            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                <thead>
                    <tr>
                        <th width="30%">รายการ</th>
                        <th width="40%">เหตุผลการใช้งาน</th>
                        <th width="5%">จำนวน</th>
                        <th width="10%">บาท/หน่วย</th>
                        <th width="10%">รวม</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td>Jondi Rose</td>
                        <td>Alfred Jondi Rose</td>
                        <td>1234</td>
                        <td class="center">super user</td>
                        <td class="center">super user</td>
                        <td><a class="edit" href="javascript:;">Edit</a></td>
                        <td><a class="delete" href="javascript:;">Delete</a></td>
                    </tr>
                    <tr class="">
                        <td>Dulal</td>
                        <td>Jonathan Smith</td>
                        <td>434</td>
                        <td class="center">new user</td>
                        <td class="center">super user</td>
                        <td><a class="edit" href="javascript:;">Edit</a></td>
                        <td><a class="delete" href="javascript:;">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
{{ Form::close() }}
@stop


@section('script')
{{HTML::script('assets/datatables/1.10.4/js/jquery.dataTables.min.js')}}
{{HTML::script('assets/datatables/1.10.4/js/dataTables.bootstrap.js')}}
{{HTML::script('assets/data-tables/DT_bootstrap.js')}}
{{HTML::script('js/respond.min.js')}}

{{HTML::script('js/jquery.form.min.js')}}
{{HTML::script('js/editable-table.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $(function () {
        EditableTable.init();
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