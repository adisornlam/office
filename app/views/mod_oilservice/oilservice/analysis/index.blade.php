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
{{Form::open(array('name'=>'form-search','id'=>'form-search','method' => 'POST','role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">
                    {{ \Form::select('type_id', array('' => 'ประเภทน้ำมัน') + \DB::table('oil_type_item')->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'type_id')); }}
                    {{ \Form::select('machine_id', array('' => 'ประเภทเครื่องจักร'), null, array('class' => 'form-control', 'id' => 'machine_id')); }}
                    {{ \Form::select('nas', array(''=>'NAS'), null, array('class' => 'form-control', 'id' => 'nas')); }}
                    {{ \Form::select('colour', array(''=>'Colour')+ \DB::table('oil_status_item')->where('group_id',3)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'colour')); }}
                    {{ \Form::select('kind_id', array('' => 'เลือกชนิดน้ำมัน',32=>'32',46=>'46',68=>'68',100=>'100'), null, array('class' => 'form-control', 'id' => 'kind_id')); }}
                    {{ \Form::select('viscosity', array(''=>'Viscosity')+\DB::table('oil_status_item')->where('group_id',4)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'viscosity')); }}                  
                    {{ \Form::select('tan', array(''=>'TAN')+ \DB::table('oil_status_item')->where('group_id',5)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'tan')); }}
                    {{ \Form::select('moisture', array(''=>'Moisture')+ \DB::table('oil_status_item')->where('group_id',6)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'moisture')); }}
                    {{ \Form::select('oxidation', array(''=>'Oxidation')+\DB::table('oil_status_item')->where('group_id',7)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'oxidation')); }}
                    {{ \Form::select('nitration', array(''=>'Nitration')+\DB::table('oil_status_item')->where('group_id',8)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'nitration')); }}
                    {{ \Form::select('density', array(''=>'Density')+\DB::table('oil_status_item')->where('group_id',9)->lists('title', 'id'), null, array('class' => 'form-control hidden', 'id' => 'density')); }}
                    {{ \Form::select('intensity', array(''=>'Intensity')+\DB::table('oil_status_item')->where('group_id',10)->lists('title', 'id'), null, array('class' => 'form-control hidden', 'id' => 'intensity')); }}
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{$title}}
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table id="analysis-list" class="table table-bordered hover"></table>
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
        var oTable = $("#analysis-list").dataTable({
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "pageLength": 25,
            stateSave: true,
            "ajax": {
                "url": base_url + index_page + "oilservice/analysis/listall",
                "data": function (d) {
                    d.viscosity = $('#viscosity').val();
                    d.nas = $('#nas').val();
                    d.colour = $('#colour').val();
                    d.moisture = $('#moisture').val();
                    d.oxidation = $('#oxidation').val();
                    d.nitration = $('#nitration').val();
                    d.tan = $('#tan').val();
                    d.type_id = $('#type_id').val();
                    d.machine_id = $('#machine_id').val();
                    d.kind_id = $('#kind_id').val();
                    d.density = $('#density').val();
                    d.intensity = $('#intensity').val();
                }
            },
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "nas_text", "title": "NAS", "width": "7%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "colour_text", "title": "Colour", "width": "7%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "viscosity_text", "title": "Viscosity", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "tan_text", "title": "TAN", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "moisture_text", "title": "Moisture", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "oxidation_text", "title": "Oxidation", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "nitration_text", "title": "Nitration", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "density_text", "title": "Density", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "intensity_text", "title": "Intensity", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "diagnose", "title": "วินิจฉัย", "width": "30%", "orderable": false, "searchable": false, "type": "html"},
                {"data": "solve", "title": "การแก้ปัญหา", "width": "30%", "orderable": false, "searchable": false, "type": "html"}
            ],
            dom: 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "../assets/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "copy",
                        "mColumns": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                        "bSelectedOnly": true
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                        "sFileName": "Report_Analysis_" + $.now() + ".csv",
                        "bSelectedOnly": true
                    }
                ]
            }
        });
        $('#viscosity, #nas, #colour, #moisture, #oxidation, #nitration, #tan').on('change', function () {
            if ($(this).val() !== '') {
                delay(function () {
                    oTable.fnDraw();
                }, 500);
            } else {
                oTable.fnDraw();
            }
        });
    });

    $('#machine_id').change(function () {
        $.get("{{ url('get/getOilNas')}}",
                {option: $(this).val(), group_id: 1, type_id: $('#type_id').val()}, function (data) {
            var nas = $('#nas');
            nas.empty();
            nas.append("<option value=''>NAS</option>");
            $.each(data, function (index, element) {
                nas.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });

    });

    $('#type_id').change(function () {
        if ($(this).val() == 3) {
            $('#density').removeClass('hidden');
            $('#intensity').removeClass('hidden');
            $('#colour').addClass('hidden');
            $('#moisture').addClass('hidden');
            $('#tan').addClass('hidden');
        } else {
            $('#density').addClass('hidden');
            $('#intensity').addClass('hidden');
            $('#colour').removeClass('hidden');
            $('#moisture').removeClass('hidden');
            $('#tan').removeClass('hidden');
        }
        $.get("{{ url('get/getOilMachine')}}",
                {option: $(this).val()}, function (data) {
            var machine = $('#machine_id');
            machine.empty();
            machine.append("<option value=''>เลือกประเภทเครื่องจักร</option>");
            $.each(data, function (index, element) {
                machine.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });

        $.get("{{ url('get/getOilNas')}}",
                {option: $('#machine_id').val(), group_id: 1, type_id: $('#type_id').val()}, function (data) {
            var nas = $('#nas');
            nas.empty();
            nas.append("<option value=''>NAS</option>");
            $.each(data, function (index, element) {
                nas.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });
</script>
@stop