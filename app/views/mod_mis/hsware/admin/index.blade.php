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
                        <a href="javascript:;" rel="mis/hsware/dialog" class="btn btn-primary link_dialog" title="เลือกกลุ่มอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มรายการ (F8)</a>
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
                    <div class="form-group">
                        <div class="col-sm-8">
                            {{ \Form::select('company_id', array(''=>'เลือกบริษัท')+$company,(isset($_COOKIE['hsware_company_id'])?$_COOKIE['hsware_company_id']:null), array('class' => 'form-control', 'id' => 'company_id')); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            {{ \Form::select('group_id', array(''=>'เลือกกลุ่มอุปกรณ์')+$group, (isset($_COOKIE['hsware_group_id'])?$_COOKIE['hsware_group_id']:null), array('class' => 'form-control', 'id' => 'group_id')); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            {{ \Form::select('status', array(''=>'เลือกสถานะ',1=>'Active',0=>'Inactive'), (isset($_COOKIE['hsware_status'])?$_COOKIE['hsware_status']:null), array('class' => 'form-control', 'id' => 'status')); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            {{Form::checkbox('spare', 1,NULL,['id'=>'spare'])}} อะไหล่
                        </div>
                    </div>
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
                    <table id="hsware-list" class="table table-striped table-bordered"></table>
                </div>
            </div>
        </section>
    </div>
</div>
@stop

@section('script')
{{HTML::script('assets/datatables/1.10.5/js/jquery.dataTables.min.js')}}
{{HTML::script('assets/datatables/1.10.4/js/dataTables.bootstrap.js')}}
{{HTML::script('assets/data-tables/DT_bootstrap.js')}}
{{HTML::script('assets/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $(function () {
        $('.dropdown-toggle').dropdown();
        var oTable = $("#hsware-list").dataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            stateSave: true,
            "ajax": {
                "url": base_url + index_page + "mis/hsware/listall",
                "data": function (d) {
                    d.group_id = $('#group_id').val();
                    d.company_id = $('#company_id').val();
                    d.status = $('#status').val();
                    d.spare = $("#spare").is(':checked') ? 1 : null;
                }
            },
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "serial_code", "title": "เลขระเบียน", "width": "10%", "orderable": true, "searchable": true},
                {"data": "serial_no", "title": "S/N", "width": "10%", "orderable": true, "searchable": true},
                {"data": "title", "title": "รายการ", "width": "30%", "orderable": false, "searchable": true},
                {"data": "computer_title", "title": "ชื่อเครื่อง", "width": "15%", "orderable": false, "searchable": true},
                {"data": "fullname", "title": "ผู้ใช้งาน", "width": "15%", "orderable": false, "searchable": true},
                {"data": "locations", "title": "Location", "sClass": "text-center", "width": "10%", "orderable": false, "searchable": true},
                {"data": "group_title", "title": "กลุ่มอุปกรณ์", "sClass": "text-center", "width": "10%", "orderable": false, "searchable": false},
                {"data": "warranty_date", "title": "วันหมดประกัน", "sClass": "text-center", "width": "12%", "orderable": false, "searchable": false},
                {"data": "spare", "title": "อะไหล่", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": false},
                {"data": "status", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": false}
            ],
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "../assets/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "copy",
                        "mColumns": [1, 2, 3, 4, 5, 6, 7]
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [1, 2, 3, 4, 5, 6, 7],
                        "sFileName": "export_hardware-software_" + $.now() + ".csv"
                    }
                ]
            }
        });

        $('#group_id').on('change', function () {
            if ($(this).val() !== '') {
                $.cookie('hsware_group_id', $(this).val());
                delay(function () {
                    oTable.fnDraw();
                }, 500);
            } else {
                oTable.fnDraw();
            }
        });
        $('#company_id').on('change', function () {
            if ($(this).val() !== '') {
                $.cookie('hsware_company_id', $(this).val());
                delay(function () {
                    oTable.fnDraw();
                }, 500);
            } else {
                oTable.fnDraw();
            }
        });
        $('#status').on('change', function () {
            if ($(this).val() !== '') {
                $.cookie('hsware_status', $(this).val());
                delay(function () {
                    oTable.fnDraw();
                }, 500);
            } else {
                oTable.fnDraw();
            }
        });

        $('#spare').click(function () {
            delay(function () {
                oTable.fnDraw();
            }, 500);
        });
    });
</script>
@stop