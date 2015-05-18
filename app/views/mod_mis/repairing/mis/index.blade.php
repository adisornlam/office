@extends('layouts.master')

@section('style')
{{HTML::style('assets/advanced-datatable/media/css/demo_page.css')}}
{{HTML::style('assets/advanced-datatable/media/css/demo_table.css')}}
{{HTML::style('assets/data-tables/DT_bootstrap.css')}}
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
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">
                    <div class="btn-group">
                        <a href="javascript:;" rel="mis/repairing/add" class="btn btn-primary link_dialog" title="เพิ่มรายการแจ้งซ่อม" role="button"><i class="fa fa-plus"></i> เพิ่มรายการแจ้งซ่อม (F8)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{Form::open(array('name'=>'form-search','id'=>'form-search','method' => 'POST','role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">                    
                    <div class="form-group">
                        {{ \Form::select('repairing_group_id', array(''=>'เลือกกลุ่มอุปกรณ์')+\RepairingGroup::lists('title','id'),null, array('class' => 'form-control', 'id' => 'repairing_group_id')); }}
                    </div>
                    <div class="form-group">
                        {{Form::text('created_at_from', null,array('class'=>'form-control datepicker','id'=>'created_at_from','placeholder'=>'วันที่เริ่ม'))}} ถึง
                    </div>
                    <div class="form-group">
                        {{Form::text('created_at_to', null,array('class'=>'form-control datepicker','id'=>'created_at_to','placeholder'=>'วันที่สิ้นสุด'))}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{$title}}
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table id="repairing-list" class="table table-striped table-bordered"></table>
                </div>
            </div>
        </section>
    </div>
</div>
@stop

@section('script')
{{HTML::script('assets/datatables/1.10.4/js/jquery.dataTables.min.js')}}
{{HTML::script('assets/datatables/1.10.4/js/dataTables.bootstrap.js')}}
{{HTML::script('assets/data-tables/DT_bootstrap.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
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
        $('.dropdown-toggle').dropdown();
        var oTable = $("#repairing-list").dataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            "ajax": {
                "url": base_url + index_page + "mis/repairing/listall",
                "data": function (d) {
                    d.repairing_group_id = $('#repairing_group_id').val();
                    d.created_at_from = $('#created_at_from').val();
                    d.created_at_to = $('#created_at_to').val();
                }
            },
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "title", "title": "รายการ", "width": "35%", "orderable": false, "searchable": true},
                {"data": "group_title", "title": "อุปกรณ์", "width": "10%", "orderable": false, "searchable": true},
                {"data": "created_at", "title": "วันที่แจ้ง", "width": "13%", "orderable": true, "searchable": true},
                {"data": "created_user", "title": "ผู้แจ้งเรื่อง", "width": "15%", "orderable": true, "searchable": true},
                {"data": "receive_user", "title": "ผู้รับเรื่อง", "width": "10%", "sClass": "text-center", "orderable": true, "searchable": true},
                {"data": "rating", "title": "Rating", "width": "5%", "sClass": "text-center", "orderable": true, "searchable": true},
                {"data": "status", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ]
        });
        $('#created_at_from').change(function () {
            delay(function () {
                oTable.fnDraw();
            }, 500);
        });

        $('#created_at_to').change(function () {
            delay(function () {
                oTable.fnDraw();
            }, 500);
        });

        $('#repairing_group_id').change(function () {
            if ($(this).val() !== '') {
                delay(function () {
                    oTable.fnDraw();
                }, 500);
            } else {
                oTable.fnDraw();
            }
        });
    });


</script>
@stop