@extends('layouts.master')

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
                        <a href="javascript:;" rel="contact/add" class="btn btn-primary link_dialog" title="เพิ่มหมวดหมู่" role="button"><i class="fa fa-plus"></i> เพิ่มผู้ติดต่อ</a>
                        <a href="{{URL::to('contact/group')}}" class="btn btn-primary" role="button"><i class="fa fa-list"></i> กลุ่มผู้ติดต่อ</a>
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
                    <table id="contact-list" class="table table-striped table-bordered"></table>
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
        $("#contact-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": base_url + index_page + "contact/listall",
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "list_title", "title": "บริษัท", "width": "30%", "orderable": false, "searchable": true},
                {"data": "fullname", "title": "ผู้ติดต่อ", "width": "20%", "orderable": false, "searchable": true},
                {"data": "phone", "title": "เบอร์ติดต่อ", "width": "10%", "orderable": false, "searchable": true},
                {"data": "mobile", "title": "โทรศัพท์", "sClass": "text-center", "width": "10%", "orderable": false, "searchable": true},
                {"data": "email", "title": "อีเมล์", "width": "15%", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "8%", "sClass": "text-center", "orderable": true, "searchable": true}
            ]
        });
    });
</script>
@stop