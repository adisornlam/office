@extends('backend.layouts.master')

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
                        <a href="javascript:;" rel="mis/backend/hsware/dialog" class="btn btn-primary link_dialog" title="เลือกกลุ่มอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มอุปกรณ์ (F8)</a>
                        <a href="{{URL::to('mis/backend/hsware/group')}}" class="btn btn-primary" role="button"><i class="fa fa-list"></i> กลุ่มอุปกรณ์</a>
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
                    <table id="hsware-list" class="table table-striped table-bordered"></table>
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
        $("#hsware-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": base_url + index_page + "mis/backend/hsware/listall",
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "access_no", "title": "ACC NO", "width": "10%", "orderable": false, "searchable": true},
                {"data": "title", "title": "รายการ", "width": "30%", "orderable": false, "searchable": true},
                {"data": "group_title", "title": "กลุ่มอุปกรณ์", "width": "20%", "orderable": false, "searchable": true},
                {"data": "warranty_date", "title": "วันหมดประกัน", "sClass": "text-center", "width": "10%", "orderable": false, "searchable": true},
                {"data": "register_date", "title": "วันลงทะเบียน", "sClass": "text-center", "width": "10%", "orderable": false, "searchable": true},
                {"data": "created_user", "title": "ผู้บันทึก", "width": "10%", "orderable": false, "searchable": true},
                {"data": "update_user", "title": "ผู้แก้ไข", "width": "10%", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ]
        });
    });
</script>
@stop