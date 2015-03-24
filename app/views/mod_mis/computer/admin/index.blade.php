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
                        <a href="javascript:;" rel="mis/computer/dialog" class="btn btn-primary link_dialog" title="เพิ่ม Computer" role="button"><i class="fa fa-plus"></i> เพิ่ม Computer (F8)</a>        
                        <a href="javascript:;" rel="mis/computer/dialog_notebook" class="btn btn-primary link_dialog" title="เพิ่ม Notebook" role="button"><i class="fa fa-plus"></i> เพิ่ม Notebook</a>     
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
                            {{ \Form::select('company_id', array('' => 'เลือกบริษัท') +$company, (isset($_COOKIE['computer_company_id'])?$_COOKIE['computer_company_id']:null), array('class' => 'form-control', 'id' => 'company_id')); }}
                        </div>
                    </div>      
                    <div class="form-group">
                        <div class="col-sm-5">
                            {{ \Form::select('disabled', array(''=>'เลือกสถานะ',0=>'Active',1=>'Inactive'), (isset($_COOKIE['computer_disabled'])?$_COOKIE['computer_disabled']:null), array('class' => 'form-control', 'id' => 'disabled')); }}
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
                    <table id="computer-list" class="table table-striped table-bordered"></table>
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
        var oTable = $("#computer-list").dataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            "ajax": {
                "url": base_url + index_page + "mis/computer/listall",
                "data": function (d) {
                    d.company_id = $('#company_id').val();
                    d.status = $('#disabled').val();
                }
            },
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "serial_code", "title": "เลขระเบียน", "width": "10%", "orderable": false, "searchable": true},
                {"data": "title", "title": "ชื่อเครื่อง", "width": "10%", "orderable": false, "searchable": true},
                {"data": "fullname", "title": "เจ้าของเครื่อง", "width": "20%", "orderable": false, "searchable": true},
                {"data": "company", "title": "บริษัท", "width": "15%", "orderable": false, "searchable": true},
                {"data": "ip_address", "title": "IP Address", "width": "10%", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ],
            dom: 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "../assets/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "copy",
                        "mColumns": [1, 2, 3, 4]
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [1, 2, 3, 4],
                        "sFileName": "export_computer_" + $.now() + ".csv"
                    }
                ]
            }
        });
        $('#company_id').on('change', function () {
            if ($(this).val() !== '') {
                $.cookie('computer_company_id', $(this).val());
                delay(function () {
                    oTable.fnDraw();
                }, 500);
            } else {
                oTable.fnDraw();
            }
        });
        $('#disabled').on('change', function () {
            $.cookie('computer_disabled', $(this).val());
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