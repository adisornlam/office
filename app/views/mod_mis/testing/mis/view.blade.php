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
                        <a href="javascript:;" rel="mis/testing/group/add" class="btn btn-primary link_dialog" title="เพิ่มกลุ่ม" role="button"><i class="fa fa-plus"></i> เพิ่มกลุ่ม (F8)</a
                    </div>
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
                    <table id="testing-list" class="table table-striped table-bordered"></table>
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
        $("#testing-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": base_url + index_page + "mis/testing/view/listall/{{$id}}",
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                //{"data": "fullname", "title": "ชื่อ - นามสกุล", "width": "30%", "orderable": false, "searchable": true},
                //{"data": "department", "title": "ฝ่าย/แผนก", "width": "10%", "orderable": false, "searchable": true},
                {"data": "typing_th", "title": "พิมพ์ดีดไทย พิมพ์ได้", "width": "15%", "orderable": false, "searchable": true},
                {"data": "typing_th_wrong", "title": "พิมพ์ดีดไทย พิมพ์ผิด", "width": "15%", "orderable": false, "searchable": true},
                {"data": "typing_en", "title": "พิมพ์ดีดอังกฤษ พิมพ์ได้", "width": "15%", "orderable": false, "searchable": true},
                {"data": "typing_en_wrong", "title": "พิมพ์ดีดอังกฤษ พิมพ์ผิด", "width": "15%", "orderable": false, "searchable": true}
            ]
        });
    });
</script>
@stop