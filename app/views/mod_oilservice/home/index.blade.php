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
    <h1>Oil Analysis <small>Report</small></h1>
</div>
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="oilservice_analysis_report_list">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-flask"></i>
            </div>
            <div class="value">
                <h1 class=" count2">
                    0
                </h1>
                <p>รายการวิเคราะห์น้ำมันไฮดรอลิค</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="oilservice_analysis_report_add">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-plus"></i>
            </div>
            <div class="value">
                <p>&nbsp;</p>
                <p>เพิ่มรายการวิเคราะห์</p>
            </div>
        </section>
    </div>
</div>
@stop

@section('script_code')
<script type="text/javascript">
    $('#oilservice_analysis_report_list').click(function () {
        window.location.href = base_url + index_page + 'oilservice/analysis';
    });

    $('#oilservice_analysis_report_add').click(function () {
        window.location.href = base_url + index_page + 'oilservice/analysis/add';
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