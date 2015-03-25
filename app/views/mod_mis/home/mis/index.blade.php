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
    <h1>ระเบียนคอมพิวเตอร์ <small>จัดการระบบระเบียนคอมพิวเตอร์</small></h1>
</div>
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="computer_list">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-desktop"></i>
            </div>
            <div class="value">
                <h1 class="computer_count">
                    {{$compouter_count}}
                </h1>
                <p>ระเบียนคอมพิวเตอร์</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="computer_add">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-plus"></i>
            </div>
            <div class="value">
                <p>&nbsp;</p>
                <p>เพิ่มคอมพิวเตอร์</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="hsware_list">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-list"></i>
            </div>
            <div class="value">
                <h1 class="hsware_count">
                    {{$hsware_count}}
                </h1>
                <p>รายการ Hardware</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="hsware_add_spare">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-plus"></i>
            </div>
            <div class="value">
                <p>&nbsp;</p>
                <p>เพิ่มรายการอะไหล่</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="hsware_group_list">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-list"></i>
            </div>
            <div class="value">
                <h1 class=" count2">
                    {{$hsware_group_count}}
                </h1>
                <p>รายการกลุ่มอุปกรณ์</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="hsware_model_list">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-list"></i>
            </div>
            <div class="value">
                <h1 class=" count2">
                    {{$hsware_model_count}}
                </h1>
                <p>รายการยี่ห้อรุ่น</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="software_list">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-windows"></i>
            </div>
            <div class="value">
                <h1 class="software_count">
                    {{$software_count}}
                </h1>
                <p>รายการ Software</p>
            </div>
        </section>
    </div>
</div>

<div class="page-header">
    <h1>Supplier <small>รายการรับมอบอุปกรณ์จากตัวแทนจำหน่าย</small></h1>
</div>
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="deliver_list">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-list"></i>
            </div>
            <div class="value">
                <h1 class="deliver_count">
                    0
                </h1>
                <p>รายการรับมอบอุปกรณ์</p>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="deliver_add">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-plus"></i>
            </div>
            <div class="value">
                <p>&nbsp;</p>
                <p>เพิ่มรายการรับมอบอุปกรณ์</p>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="supplier_list">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-list"></i>
            </div>
            <div class="value">
                <h1 class="supplier_count">
                    {{$supplier_count}}
                </h1>
                <p>รายการตัวแทนจำหน่าย</p>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="supplier_add">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-plus"></i>
            </div>
            <div class="value">
                <p>&nbsp;</p>
                <p>เพิ่มตัวแทนจำหน่าย</p>
            </div>
        </section>
    </div>

</div>
<div class="page-header">
    <h1>แบบฟอร์ม <small>รายการแบบฟอร์มเอกสารออนไลน์ต่างๆ</small></h1>
</div>
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="purchase_request_list">
        <section class="panel">
            <div class="symbol orage">
                <i class="fa fa-list"></i>
            </div>
            <div class="value">
                <h1 class="purchase_request_count">
                    0
                </h1>
                <p>รายการขอซื้อ</p>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="purchase_request_add">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-plus"></i>
            </div>
            <div class="value">
                <p>&nbsp;</p>
                <p>เพิ่มรายการขอซื้อ</p>
            </div>
        </section>
    </div>
</div>
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
<div class="page-header">
    <h1>Monitoring <small>ตรวจสอบและติดตามข้อมูล</small></h1>
</div>
<div class="row state-overview">    
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
                    {{$users_count}}
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
    <div class="col-lg-3 col-sm-6" style="cursor: pointer;" id="block10">
        <section class="panel">
            <div class="symbol green2">
                <i class="fa fa-bullhorn"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    0
                </h1>
                <p>แจ้งข่าวสาร / ประชาสัมพันธ์</p>
            </div>
        </section>
    </div>
</div>

@stop

@section('script_code')
<script type="text/javascript">
    $('#computer_list').click(function () {
        window.location.href = base_url + index_page + 'mis/computer';
    });
    $('#computer_add').click(function () {
        var data = {
            url: 'mis/computer/dialog',
            title: 'เลือกบริษัท'
        };
        genModal(data);
    });
    $('#hsware_list').click(function () {
        window.location.href = base_url + index_page + 'mis/hsware';
    });
    $('#hsware_add_spare').click(function () {
        //window.location.href = base_url + index_page + 'mis/hsware/add?group_id=2&spare=1';
        var data = {
            url: 'mis/hsware/dialog',
            title: 'เลือกกลุ่มอุปกรณ์',
            v: {spare: 1}
        };
        genModal(data);
    });
    $('#hsware_group_list').click(function () {
        window.location.href = base_url + index_page + 'mis/hsware/group';
    });
    $('#hsware_model_list').click(function () {
        window.location.href = base_url + index_page + 'mis/hsware/group/model';
    });
    $('#software_list').click(function () {
        window.location.href = base_url + index_page + 'mis/software';
    });
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
    $('#deliver_list').click(function () {
        window.location.href = base_url + index_page + 'mis/deliver';
    });
    $('#deliver_add').click(function () {
        window.location.href = base_url + index_page + 'mis/deliver/add';
    });
    $('#supplier_list').click(function () {
        window.location.href = base_url + index_page + 'mis/supplier';
    });
    $('#supplier_add').click(function () {
        var data = {
            url: 'mis/supplier/add',
            title: 'เพิ่ม Supplier'
        };
        genModal(data);
    });
    $('#purchase_request_list').click(function () {
        window.location.href = base_url + index_page + 'mis/purchaserequest';
    });
    $('#purchase_request_add').click(function () {
        window.location.href = base_url + index_page + 'mis/purchaserequest/add';
    });
    $('#block5').click(function () {
        window.location.href = base_url + index_page + 'users';
    });
    $('#block9').click(function () {
        window.location.href = base_url + index_page + 'mis/testing';
    });
    $('#block10').click(function () {
        window.location.href = base_url + index_page + 'post';
    });
</script>
@stop