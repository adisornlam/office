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
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">
                    <div class="btn-group">
                        <a href="javascript:;" rel="setting/backend/menu/add/{{\Request::segment(5)}}" class="btn btn-primary link_dialog" title="เพิ่ม Menu" role="button"><i class="fa fa-plus"></i> เพิ่ม Menu</a>
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
                    <table id="domain-list" class="table table-striped table-bordered"></table>
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
        $("#domain-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": base_url + index_page + "setting/backend/menu/sub/listall/{{$id}}",
            "order": [[4, 'asc']],
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "title", "title": "รายการ", "width": "40%", "orderable": false, "searchable": true},
                {"data": "url", "title": "URL", "width": "10%", "orderable": false, "searchable": true},
                {"data": "module", "title": "Module", "width": "10%", "orderable": false, "searchable": true},
                {"data": "rank", "title": "ลำดับ", "sClass": "text-center", "width": "5%", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ]
        });
    });
</script>
@stop