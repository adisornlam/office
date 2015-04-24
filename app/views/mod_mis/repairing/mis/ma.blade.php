@extends('layouts.master')

@section('style')
{{HTML::style('assets/advanced-datatable/media/css/demo_page.css')}}
{{HTML::style('assets/advanced-datatable/media/css/demo_table.css')}}
{{HTML::style('assets/data-tables/DT_bootstrap.css')}}
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
                        <a href="javascript:;" rel="mis/repairing/ma/dialog" class="btn btn-primary link_dialog" title="เพิ่มรายการ MA" role="button"><i class="fa fa-plus"></i> เพิ่มรายการ MA (F8)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{$title}}
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table id="ma-list" class="table table-striped table-bordered"></table>
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
@stop

@section('script_code')
<script type="text/javascript">
    $(function () {
        $('.dropdown-toggle').dropdown();
        var oTable = $("#ma-list").dataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            "ajax": {
                "url": base_url + index_page + "mis/repairing/ma/listall"
            },
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "title", "title": "รายการ", "width": "10%", "orderable": false, "searchable": true},
                {"data": "serial_code", "title": "เลขระเบียน", "width": "10%", "orderable": false, "searchable": true},
                {"data": "computer", "title": "คอมพิวเตอร์", "width": "10%", "orderable": false, "searchable": true},
                {"data": "group_title", "title": "คอมพิวเตอร์/อุปกรณ์", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": true},
                {"data": "company", "title": "บริษัท", "width": "15%", "orderable": false, "searchable": true},
                {"data": "created_user", "title": "ผู้ดำเนินการ", "width": "15%", "sClass": "text-center", "orderable": true, "searchable": true},
                {"data": "created_at", "title": "วันที่ดำเนินการ", "width": "10%", "orderable": true, "searchable": true},
                {"data": "status", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ]
        });
    });


</script>
@stop