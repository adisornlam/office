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
                        <button name="btnImportSave" id="btnImportSave" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> บันทึกการนำเข้าข้อมูล</button>
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
                    <table id="deadstock_temp-list" class="table table-striped table-bordered"></table>
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
        var oTable = $("#deadstock_temp-list").dataTable({
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "pageLength": 25,
            stateSave: true,
            "ajax": {
                "url": base_url + index_page + "warehouse/deadstock/import_temp/listall"
            },
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "type", "title": "Type", "width": "5%", "sClass": "text-center", "orderable": false, "searchable": true},
                {"data": "brand", "title": "Brand", "sClass": "text-center", "orderable": false, "searchable": true},
                {"data": "code_no", "title": "Code", "width": "7%", "orderable": false, "searchable": true},
                {"data": "description", "title": "Description", "width": "15%", "orderable": false, "searchable": true},
                {"data": "xp5", "title": "XP 5", "orderable": false, "searchable": false},
                {"data": "xp51_12", "title": "XP5  1-12", "orderable": false, "searchable": false},
                {"data": "xp5a", "title": "XPA", "orderable": false, "searchable": false},
                {"data": "unit", "title": "Unit", "orderable": false, "searchable": false},
                {"data": "price_per_unit", "title": "Price Per Unit", "width": "5%", "orderable": false, "searchable": false},
                {"data": "total_value", "title": "Total Value", "width": "5%", "orderable": false, "searchable": false},
                {"data": "dead1", "title": "1 Year 1-365 Day", "width": "12%", "orderable": false, "searchable": false},
                {"data": "dead2", "title": "2-3 Year 366-731 Day", "width": "12%", "orderable": false, "searchable": false},
                {"data": "dead3", "title": "2-3 Year 732-1097 Day", "width": "12%", "orderable": false, "searchable": false},
                {"data": "dead4", "title": "3 Year Up 1097 Day", "width": "12%", "orderable": false, "searchable": false},
                {"data": "dead5", "title": "3 Year Up (A) 1097 Day Up(A)", "width": "12%", "orderable": false, "searchable": false},
                {"data": "summary", "title": "Summary", "width": "5%", "orderable": false, "searchable": false}
            ]
        });
    });
    $('#btnImportSave').click(function () {
        $('#btnDialogSave').attr('disabled', 'disabled');
        var data = {
            title: 'Loading',
            type: 'alert',
            text: '<div class="text-center"><p><i class="fa fa-spinner fa-spin fa-2x"></i></p></div>'
        };
        genModal(data);
        $.ajax({
            type: "post",
            url: base_url + index_page + 'warehouse/deadstock/import_save',
            data: {check: 1},
            cache: false,
            async: false,
            success: function (result) {
                try {
                    if (result.error.status === true) {
                        window.location.href = base_url + index_page + "warehouse/deadstock";
                    } else {
                        window.location.href = base_url + index_page + "warehouse/deadstock/import_temp";
                    }
                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function (e) {
                alert('Error while request..');
            }
        });
    });
</script>
@stop