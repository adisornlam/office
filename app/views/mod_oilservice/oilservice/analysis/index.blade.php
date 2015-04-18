@extends('layouts.master')

@section('style')
{{HTML::style('assets/advanced-datatable/media/css/demo_page.css')}}
{{HTML::style('assets/advanced-datatable/media/css/demo_table.css')}}
{{HTML::style('assets/data-tables/DT_bootstrap.css')}}
{{HTML::style('assets/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}
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
                        <a href="{{URL::to('oilservice/analysis/add')}}" class="btn btn-primary" title="เพิ่มรายการวิเคราะห์" role="button"><i class="fa fa-plus"></i> เพิ่มรายการวิเคราะห์</a>
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
                    <table id="analysis-list" class="table table-bordered"></table>
                </div>
            </div>
        </section>
    </div>
</div>
@stop

@section('script')
{{HTML::script('assets/datatables/1.10.4/js/jquery.dataTables.min.js')}}
{{HTML::script('assets/datatables/1.10.4/js/dataTables.bootstrap.js')}}
{{HTML::script('assets/datatables/1.10.4/js/dataTables.editor.min.js')}}
{{HTML::script('assets/data-tables/DT_bootstrap.js')}}
{{HTML::script('assets/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $(function () {
        $('.dropdown-toggle').dropdown();
        $("#analysis-list").dataTable({
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "pageLength": 25,
            stateSave: true,
            "ajax": base_url + index_page + "oilservice/analysis/listall",
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "viscosity", "title": "Viscosity", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "nas", "title": "NAS", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "colour", "title": "Colour", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "moisture", "title": "Moisture", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "oxidation", "title": "Oxidation", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "nitration", "title": "Mitration", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "tan", "title": "TAN", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "viscosity_text", "title": "Viscosity", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "nas_text", "title": "NAS", "width": "15%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "colour_text", "title": "Colour", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "moisture_text", "title": "Moisture", "width": "15%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "oxidation_text", "title": "Oxidation", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "nitration_text", "title": "Nitration", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "tan_text", "title": "TAN", "width": "10%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "created_at", "title": "วันที่สร้าง", "width": "10%", "orderable": true, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ],
            dom: 'T<"clear">lfrtip',
            "tableTools": {
                "sRowSelect": "multi",
                "sSwfPath": "../assets/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "copy",
                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                        "bSelectedOnly": true
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                        "sFileName": "Report_Analysis_" + $.now() + ".csv",
                        "bSelectedOnly": true
                    }
                ]
            }
        });

        console.log(editor);
    });
</script>
@stop