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
@endif
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <a href="javascript:;" class="btn btn-primary link_dialog" rel="users/roles/add" role="button" title="เพิ่มสิทธิ์การใช้งาน"><i class="fa fa-plus"></i> เพิ่มสิทธิ์การใช้งาน</a> 
            </div>
        </section>
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
                    <table id="role-list" class="table table-striped table-bordered"></table>
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
        $("#role-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": base_url + index_page + "users/roles/listall",
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "name", "title": "หัวข้อ", "width": "20%", "orderable": false, "searchable": true},
                {"data": "description", "title": "คำอธิบาย", "width": "30%", "orderable": false, "searchable": true},
                {"data": "level", "title": "ระดับ", "width": "5%", "orderable": false, "searchable": true},
                {"data": "created_at", "title": "วันที่สร้าง", "width": "15%", "orderable": true, "searchable": true},
                {"data": "updated_at", "title": "วันที่แก้ไข", "width": "15%", "orderable": true, "searchable": true}
            ]
        });
    });

</script>
@stop