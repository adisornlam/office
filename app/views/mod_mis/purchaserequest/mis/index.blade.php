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
                        <a href="{{URL::to('mis/purchaserequest/add')}}" class="btn btn-primary" title="เพิ่ม ใบขอซื้อ" role="button"><i class="fa fa-plus"></i> เพิ่ม รายการขอซื้อ (F8)</a>
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
                    <table id="supplier-list" class="table table-striped table-bordered"></table>
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
        var oTable = $("#supplier-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": base_url + index_page + "mis/purchaserequest/listall"
            },
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "codes", "title": "เลขที่สั่งซื้อ", "width": "10%", "orderable": false, "searchable": true},
                {"data": "title", "title": "รายการ", "width": "20%", "orderable": false, "searchable": true},
                {"data": "company", "title": "บริษัท", "width": "20%", "orderable": false, "searchable": true},
                {"data": "remark", "title": "หมายเหตุ", "width": "20%", "orderable": false, "searchable": true},
                {"data": "status", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true},
                {"data": "created_at", "title": "วันที่สร้าง", "sClass": "text-center", "width": "12%", "orderable": true, "searchable": true},
                {"data": "disabled", "title": "", "width": "8%", "sClass": "text-center", "orderable": true}
            ]
        });
    });


</script>
@stop