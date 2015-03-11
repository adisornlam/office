@extends('backend.layouts.master')

@section('style')
{{HTML::style('assets/backend/datatables/1.10.4/css/dataTables.bootstrap.css')}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{$title}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">
                    <div class="btn-group">
                        <a href="javascript:;" rel="mis/backend/dialog/add" class="btn btn-primary link_dialog" title="เลือกหมวดหมู่" role="button"><i class="fa fa-plus"></i> เพิ่มอุปกรณ์</a>
                        <a href="{{URL::to('mis/backend/hardware/category')}}" class="btn btn-primary" role="button"><i class="fa fa-cubes"></i> หมวดหมู่อุปกรณ์</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default borderless">
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="txtSearch" name="txtSearch" placeholder="ค้นหา">
                    </div>
                    <div class="col-sm-2">
                        {{ \Form::select('category_id', array(''=>'เลือกหมวดหมู่')+$category, null, array('class' => 'form-control', 'id' => 'category_id')); }}
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-default btn-circle" type="button" id="btnRefresh" value="products/backend/order"><i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table id="users-list" class="table table-striped table-bordered"></table>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
{{HTML::script('assets/backend/datatables/1.10.4/js/jquery.dataTables.min.js')}}
{{HTML::script('assets/backend/datatables/1.10.4/js/dataTables.bootstrap.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $(function () {
        $('.dropdown-toggle').dropdown();
        var oTable = $("#users-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": base_url + index_page + "mis/backend/listall",
                "data": function (d) {
                    d.category_id = $('#category_id').val();
                    d.txtSearch = $('#txtSearch').val();
                }
            },
            "order": [[5, 'desc']],
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "equipment_code", "title": "เลขทะเบียน", "width": "10%", "orderable": false, "searchable": true},
                {"data": "title", "title": "ชื่ออุปกรณ์", "width": "20%", "orderable": false, "searchable": true},
                {"data": "cat_title", "title": "หมวดหมู่", "width": "10%", "orderable": false, "searchable": true},
                {"data": "register_date", "title": "วันลงทะเบียน", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": true},
                {"data": "created_user", "title": "ผู้บันทึก", "width": "10%", "orderable": false, "searchable": true},
                {"data": "updated_user", "title": "ผู้แก้ไข", "width": "10%", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ]
        });
        $('#txtSearch').keyup(function () {
            delay(function () {
                oTable.fnDraw();
            }, 500);
        });

        $('#category_id', function () {
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