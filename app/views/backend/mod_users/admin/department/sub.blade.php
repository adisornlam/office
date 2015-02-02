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
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">
                    <div class="btn-group">
                        <a href="javascript:;" class="btn btn-primary link_dialog" rel="users/backend/department/sub/add/{{$sub_id}}" role="button" title="เพิ่มแผนก"><i class="fa fa-plus"></i> เพิ่มแผนก</a>
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
                <table id="role-list" class="table table-striped table-bordered"></table>
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
        $("#role-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": base_url + index_page + "users/backend/department/listall",
                "data": function (d) {
                    d.sub_id = <?php echo $sub_id; ?>;
                }
            },
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "title", "title": "หัวข้อ", "width": "50%", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "created_at", "title": "วันที่สร้าง", "width": "15%", "orderable": true, "searchable": true},
                {"data": "updated_at", "title": "วันที่แก้ไข", "width": "15%", "orderable": true, "searchable": true}
            ]
        });
    });

</script>
@stop