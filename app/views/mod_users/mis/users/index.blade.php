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
                <a href="javascript:;" rel="users/add" class="btn btn-primary link_dialog" title="เพิ่มผู้ใช้งาน" role="button"><i class="fa fa-plus"></i> เพิ่มผู้ใช้งาน (F8)</a>
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
                    <table id="users-list" class="table table-striped table-bordered"></table>
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
        $("#users-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": base_url + index_page + "users/listall",
            "order": [[6, 'desc']],
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "username", "title": "ชื่อผู้ใช้", "width": "8%", "orderable": false, "searchable": true},
                {"data": "fullname", "title": "ชื่อ-นามสกุล", "width": "15%", "orderable": false, "searchable": true},
                {"data": "department", "title": "ฝ่าย/แผนก", "width": "15%", "orderable": false, "searchable": true},
                {"data": "company", "title": "บริษัท", "width": "10%", "orderable": false, "searchable": true},
                {"data": "email", "title": "อีเมล์", "width": "15%", "orderable": false, "searchable": true},
                {"data": "mobile", "title": "เบอร์ติดต่อ", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "3%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "created_at", "title": "วันที่สร้าง", "width": "15%", "orderable": true, "searchable": true}
            ]
        });
    });
</script>
@stop