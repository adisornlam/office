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
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block1">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-desktop"></i>
            </div>
            <div class="value">
                <h1 class="count">
                    0
                </h1>
                <p>ระเบียนคอมพิวเตอร์</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block2">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-wrench"></i>
            </div>
            <div class="value">
                <h1 class=" count2">
                    0
                </h1>
                <p>แจ้งซ่อมอุปกรณ์</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block3">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-server"></i>
            </div>
            <div class="value">
                <h1 class=" count3">
                    0
                </h1>
                <p>ขอข้อมูลจาก Server</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block4">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-keyboard-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    0
                </h1>
                <p>ขอใช้อุปกรณ์สารสนเทศ</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block5">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-users"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    0
                </h1>
                <p>ผู้ใช้งานระบบ</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block6">
        <section class="panel">
            <div class="symbol orage">
                <i class="fa fa-microphone"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    0
                </h1>
                <p>จองห้องประชุม</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block7">
        <section class="panel">
            <div class="symbol purple">
                <i class="fa fa-pie-chart"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    0
                </h1>
                <p>ข้อมูลรายงาน</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block8">
        <section class="panel">
            <div class="symbol grey">
                <i class="fa fa-hdd-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    0
                </h1>
                <p>Backup ข้อมูล</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block9">
        <section class="panel">
            <div class="symbol blue2">
                <i class="fa fa-check-square-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    0
                </h1>
                <p>ข้อสอบภาพปฏิบัติ</p>
            </div>
        </section>
    </div>
</div>
@stop

@section('script_code')
<script type="text/javascript">
    $('#block1').click(function () {
        window.location.href = base_url + index_page + 'mis/computer';
    });

    $('#block9').click(function () {
        window.location.href = base_url + index_page + 'mis/testing';
    });
</script>
@stop