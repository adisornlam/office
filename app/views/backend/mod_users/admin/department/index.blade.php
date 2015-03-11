@extends('backend.layouts.master')

@section('style')
{{HTML::style('assets/advanced-datatable/media/css/demo_page.css')}}
{{HTML::style('assets/advanced-datatable/media/css/demo_table.css')}}
{{HTML::style('assets/data-tables/DT_bootstrap.css')}}
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{$title}}
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table id="department-list" class="table table-striped table-bordered"></table>
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
        $("#department-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": base_url + index_page + "users/backend/department/listall",
            "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "id", "width": "2%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "title", "title": "หัวข้อ", "width": "40%", "orderable": false, "searchable": true},
                {"data": "weight", "title": "ลำดับ", "width": "3%", "orderable": false, "searchable": true},
                {"data": "disabled", "title": "สถานะ", "width": "3%", "sClass": "text-center", "orderable": false, "searchable": false},
                {"data": "created_at", "title": "วันที่สร้าง", "width": "10%", "orderable": true, "searchable": true},
                {"data": "updated_at", "title": "วันที่แก้ไข", "width": "10%", "orderable": true, "searchable": true}
            ]
        });
    });

</script>
@stop