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
                        <a href="javascript:;" rel="domain/backend/add" class="btn btn-primary link_dialog" title="เพิ่ม Domain" role="button"><i class="fa fa-plus"></i> เพิ่ม Computer</a>
                        <a href="{{URL::to('mis/backend/hsware')}}" class="btn btn-primary" role="button"><i class="fa fa-list"></i> รายการอุปกรณ์</a>
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
                    <table id="computer-list" class="table table-striped table-bordered"></table>
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
//    $(function () {
//        $('.dropdown-toggle').dropdown();
//        var oTable = $("#computer-list").dataTable({
//            "processing": true,
//            "serverSide": true,
//            "ajax": {
//                "url": base_url + index_page + "mis/backend/computer/listall",
//                "data": function (d) {
//                    d.category_id = $('#category_id').val();
//                    d.txtSearch = $('#txtSearch').val();
//                }
//            },
//            "columnDefs": [{
//                    "targets": "_all",
//                    "defaultContent": ""
//                }],
//            "columns": [
//                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
//                {"data": "equipment_code", "title": "เลขทะเบียน", "width": "10%", "orderable": false, "searchable": true},
//                {"data": "title", "title": "ชื่ออุปกรณ์", "width": "20%", "orderable": false, "searchable": true},
//                {"data": "cat_title", "title": "หมวดหมู่", "width": "10%", "orderable": false, "searchable": true},
//                {"data": "register_date", "title": "วันลงทะเบียน", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": true},
//                {"data": "created_user", "title": "ผู้บันทึก", "width": "10%", "orderable": false, "searchable": true},
//                {"data": "updated_user", "title": "ผู้แก้ไข", "width": "10%", "orderable": false, "searchable": true},
//                {"data": "disabled", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
//            ]
//        });
//        $('#txtSearch').keyup(function () {
//            delay(function () {
//                oTable.fnDraw();
//            }, 500);
//        });
//
//        $('#category_id', function () {
//            if ($(this).val() !== '') {
//                delay(function () {
//                    oTable.fnDraw();
//                }, 500);
//            } else {
//                oTable.fnDraw();
//            }
//        });
//    });


</script>
@stop