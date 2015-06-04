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
{{Form::open(array('name'=>'form-search','id'=>'form-search','method' => 'POST','role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">  
                    <div class="form-group">
                        {{ \Form::select('type_id', array(''=>'Type')+\DB::table('warehouse_type')->select(array('code_no as id',\DB::raw('CONCAT("(",code_no,") ",title) as title')))->lists('title','id'),null, array('class' => 'form-control', 'id' => 'type_id')); }}
                    </div>
                    <div class="form-group">
                        {{ \Form::select('brand_id', array(''=>'Brand')+\DB::table('warehouse_brand')->select(array('code_no as id',\DB::raw('CONCAT("(",code_no,") ",title) as title')))->lists('title','id'), null, array('class' => 'form-control', 'id' => 'brand_id')); }}
                    </div>
                    <div class="form-group">
                        {{ \Form::select('import_date_from', array(''=>'Date From')+$import_date_from,null, array('class' => 'form-control', 'id' => 'import_date_from')); }}
                    </div>
                    <div class="form-group">
                        {{ \Form::select('import_date_to', array(''=>'Date To')+$import_date_to,null, array('class' => 'form-control', 'id' => 'import_date_to')); }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">

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
                    <table id="deadstock-list" class="table table-striped table-bordered"></table>
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
{{HTML::script('assets/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $(function () {
        $('.dropdown-toggle').dropdown();
        var oTable = $("#deadstock-list").dataTable({
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "pageLength": 10,
            stateSave: true,
            "ajax": {
                "url": base_url + index_page + "warehouse/deadstock/report/listall",
                "data": function (d) {
                    d.type_id = $('#type_id').val();
                    d.brand_id = $('#brand_id').val();
                    d.import_date_from = $('#import_date_from').val();
                    d.import_date_to = $('#import_date_to').val();
                }
            },
            "columns": [
                {"data": "type_title", "title": "Type", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": true},
                {"data": "brand", "title": "Brand", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": true},
                {"data": "code_no", "title": "Code", "width": "7%", "orderable": false, "searchable": true},
                {"data": "description", "title": "Description", "width": "20%", "orderable": false, "searchable": true},
                {"data": "xp5", "title": "XP 5", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "xp51_12", "title": "XP5  1-12", "sClass": "text-center", "width": "5%", "orderable": false, "searchable": false},
                {"data": "xp5a", "title": "XPA", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "unit", "title": "Unit", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "dead1", "title": "1 Year 1-365 Day", "width": "7%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "dead2", "title": "2-3 Year 366-731 Day", "width": "7%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "dead3", "title": "2-3 Year 732-1097 Day", "width": "7%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "dead4", "title": "3 Year Up 1097 Day", "width": "7%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "dead5", "title": "3 Year Up (A) 1097 Day Up(A)", "width": "8%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "import_date", "title": "Date", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ],
            dom: 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": base_url + "assets/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "copy",
                        "mColumns": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                        "bSelectedOnly": true
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                        "sFileName": "Report_Analysis_" + $.now() + ".csv",
                        "bSelectedOnly": true
                    }
                ]
            }
        });
        $('#import_date_from').on('change', function () {
            $('#import_date_to').find('option:first').attr('selected', 'selected');
            if ($(this).val() !== '') {
                delay(function () {
                    oTable.fnDraw();
                }, 500);
            } else {
                oTable.fnDraw();
            }
        });
        $('#import_date_to').on('change', function () {
            if ($(this).val() !== '') {
                delay(function () {
                    oTable.fnDraw();
                }, 500);
            } else {
                oTable.fnDraw();
            }
        });
        $('#type_id').on('change', function () {
            if ($(this).val() !== '') {
                delay(function () {
                    oTable.fnDraw();
                }, 500);
            } else {
                oTable.fnDraw();
            }
        });
        $('#brand_id').on('change', function () {
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