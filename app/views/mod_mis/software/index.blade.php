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
                        <a href="{{URL::to('mis/backend/software/add')}}" class="btn btn-primary" title="เพิ่มโปรแกรม/ซอฟต์แวร์" role="button"><i class="fa fa-plus"></i> เพิ่มโปรแกรม/ซอฟต์แวร์</a>
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
        $("#users-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": base_url + index_page + "mis/backend/software/listall",
            "order": [[5, 'desc']],
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "equipment_code", "title": "เลขทะเบียน", "width": "10%", "orderable": false, "searchable": true},
                {"data": "title", "title": "ชื่อโปรแกรม/ซอฟต์แวร์", "width": "20%", "orderable": false, "searchable": true},
                {"data": "cat_title", "title": "หมวดหมู่", "width": "10%", "orderable": false, "searchable": true},
                {"data": "register_date", "title": "วันลงทะเบียน", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": true},
                {"data": "created_user", "title": "ผู้บันทึก", "width": "10%", "orderable": false, "searchable": true},
                {"data": "updated_user", "title": "ผู้แก้ไข", "width": "10%", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ]
        });
    });

</script>
@stop