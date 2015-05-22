@extends('layouts.master')

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

<div class="page-header">
    <h1>Dead Stock <small>Report</small></h1>
</div>
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="warehouse_deadstock_list">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-cubes"></i>
            </div>
            <div class="value">
                <h1 class=" count2">
                    {{$deadstock_count}}
                </h1>
                <p>รายการสินค้าคงค้าง</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="warehouse_deadstock_report_list">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart"></i>
            </div>
            <div class="value">
                <p>ประวัติรายการ Dead Stock</p>
            </div>
        </section>
    </div>
</div>
@stop

@section('script_code')
<script type="text/javascript">
    $('#warehouse_deadstock_list').click(function () {
        window.location.href = base_url + index_page + 'warehouse/deadstock';
    });

    $('#warehouse_deadstock_report_list').click(function () {
        window.location.href = base_url + index_page + 'warehouse/deadstock/report';
    });
//    $('#oilservice_analysis_report_add').click(function () {
//        var data = {
//            url: 'oilservice/analysis/add',
//            title: 'เพิ่มรายการวิเคราะห์'
//        };
//        genModal(data);
//    });
</script>
@stop