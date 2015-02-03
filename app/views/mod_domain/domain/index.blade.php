@extends('backend.layouts.master')

@section('style')
{{HTML::style('assets/advanced-datatable/media/css/demo_page.css')}}
{{HTML::style('assets/advanced-datatable/media/css/demo_table.css')}}
{{HTML::style('assets/data-tables/DT_bootstrap.css')}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">
                    <div class="btn-group">
                        <a href="javascript:;" rel="domain/backend/add" class="btn btn-primary link_dialog" title="เพิ่ม Domain" role="button"><i class="fa fa-plus"></i> เพิ่ม Domain</a>
                        <a href="{{URL::to('domain/backend/server')}}" class="btn btn-primary" role="button"><i class="fa fa-list"></i> รายการ Server</a>
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
            "ajax": base_url + index_page + "domain/backend/listall",
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "company_title", "title": "บริษัท", "width": "20%", "orderable": false, "searchable": true},
                {"data": "domain_title", "title": "โดเมน", "width": "20%", "orderable": false, "searchable": true},
                {"data": "server_title", "title": "ISP Server", "width": "20%", "orderable": false, "searchable": true},
                {"data": "domain_expire", "title": "วันก่อนหมด(วัน)", "sClass": "text-center", "width": "10%", "orderable": false, "searchable": true},
                {"data": "domain_expire_date", "title": "วันหมดอายุ", "sClass": "text-center", "width": "10%", "orderable": false, "searchable": true},
                {"data": "contact_name", "title": "ผู้ติดต่อ", "width": "10%", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ]
        });
    });
</script>
@stop