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
    <h1>MA <small>ดูแลและบำรุงรักษา</small></h1>
</div>
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="repairing_list">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-wrench"></i>
            </div>
            <div class="value">
                <h1 class=" count2">
                    {{$repairing_count}}
                </h1>
                <p>รายการแจ้งซ่อมอุปกรณ์</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="repairing_add">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-plus"></i>
            </div>
            <div class="value">
                <p>&nbsp;</p>
                <p>แบบฟอร์มแจ้งซ่อม</p>
            </div>
        </section>
    </div>
</div>
@stop

@section('script_code')
<script type="text/javascript">
    $('#repairing_list').click(function () {
        window.location.href = base_url + index_page + 'mis/repairing';
    });
    $('#repairing_add').click(function () {
        var data = {
            url: 'mis/repairing/add',
            title: 'แจ้งซ่อมอุปกรณ์'
        };
        genModal(data);
    });
</script>
@stop