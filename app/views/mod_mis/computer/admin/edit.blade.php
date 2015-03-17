@extends('layouts.master')
@section('style')
{{HTML::style('assets/bootstrap-datepicker/css/datepicker3.css')}}
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

{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal','files'=>true))}}
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading tab-bg-dark-navy-blue tab-right ">
                <ul class="nav nav-tabs pull-right">
                    <li class="active">
                        <a data-toggle="tab" href="#info">
                            <i class="fa fa-info"></i>
                            ข้อมูลทั่วไป
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#option1">
                            <i class="fa fa-list"></i>
                            เลือกอุปกรณ์คอมพิวเตอร์
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#gallery">
                            <i class="fa fa-user"></i>
                            ผู้ใช้งาน
                        </a>
                    </li>
                </ul>
                <span class="hidden-sm wht-color">{{$title}}</span>
            </header>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="info" class="tab-pane active">
                        <div class="panel-body">
                            <div class="form-group">
                                {{Form::label('company_id', 'สินทรัพย์บริษัท', array('class' => 'col-sm-2 control-label'));}}
                                <div class="col-sm-3">
                                    {{ \Form::select('company_id', $company, $item->company_id, array('class' => 'form-control', 'id' => 'company_id')); }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('serial_code', 'เลขระเบียน', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    {{Form::text('serial_code', $item->serial_code,array('class'=>'form-control','id'=>'serial_code'))}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('access_no', 'ACC NO', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-3">
                                    {{Form::text('access_no', $item->access_no,array('class'=>'form-control','id'=>'access_no'))}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('type_id', 'ประเภทคอมพิวเตอร์', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-5">
                                    <label class="checkbox-inline">     
                                        {{Form::radio('type_id', 1,($item->type_id==1?TRUE:FALSE),array('class'=>'type_id'))}} PC
                                    </label>
                                    <label class="checkbox-inline">
                                        {{Form::radio('type_id', 2,($item->type_id==2?TRUE:FALSE),array('class'=>'type_id'))}} Notebook
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('title', 'ชื่อคอมพิวเตอร์', array('class' => 'col-sm-2 control-label req'))}}
                                <div class="col-sm-5">
                                    {{Form::text('title', $item->title,array('class'=>'form-control','id'=>'title'))}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('ip_address', 'IP Address', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    {{Form::text('ip_address', $item->ip_address,array('class'=>'form-control','id'=>'ip_address'))}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('mac_lan', 'Mac Address Lan Local', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    {{Form::text('mac_lan', $item->mac_lan,array('class'=>'form-control','id'=>'mac_lan'))}}
                                </div>
                            </div>
                            <div class="form-group hidden">
                                {{Form::label('mac_wireless', 'Mac Address Wireless', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    {{Form::text('mac_wireless', $item->mac_wireless,array('class'=>'form-control','id'=>'mac_wireless'))}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('locations', 'ตำแหน่งวาง', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    {{ \Form::select('locations', $place,$item->locations, array('class' => 'form-control', 'id' => 'locations')); }}
                                </div>
                            </div>   
                            <div class="form-group">
                                {{Form::label('register_date', 'วันที่ลงทะเบียน', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-2">
                                    <div class="input-group date form_datetime-component">
                                        {{Form::text('register_date', $item->register_date,array('class'=>'form-control datepicker','id'=>'register_date'))}}
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>                                     
                            <div class="form-group">
                                {{Form::label('disabled', '&nbsp;', array('class' => 'col-sm-2 control-label'))}}
                                <div class="col-sm-3">
                                    <label>
                                        {{Form::checkbox('disabled', 1,($item->disabled==0?TRUE:FALSE))}} เปิดใช้งาน
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="option1" class="tab-pane">
                        <div class="panel-body">
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">อุปกรณ์ที่เลือก</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">เลือกเพิ่มเติม</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">
                                        <div class="panel-body">
                                            <?php
                                            foreach (\DB::table('hsware_group')
                                                    ->join('hsware_item', 'hsware_item.group_id', '=', 'hsware_group.id')
                                                    ->where('hsware_group.disabled', 0)
                                                    ->select(array('hsware_group.id', 'hsware_group.title'))
                                                    ->distinct()
                                                    ->get() as $group_item) {
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label col-lg-2" for="hsware_item">{{$group_item->title}}</label>
                                                    <div class="col-lg-6">
                                                        <?php
                                                        foreach (\DB::table('computer_hsware')
                                                                ->leftJoin('hsware_item', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                                                                ->join('hsware_model', 'hsware_model.id', '=', 'hsware_item.model_id')
                                                                ->where('hsware_item.group_id', $group_item->id)
                                                                ->where('computer_hsware.computer_id', $item->id)
                                                                ->select(array(
                                                                    'hsware_item.id as id',
                                                                    'hsware_item.sub_model as sub_model',
                                                                    'hsware_item.serial_code as codes',
                                                                    'hsware_model.title as title',
                                                                    'hsware_item.status as status',
                                                                ))
                                                                ->get() as $hs_item) {
                                                            ?>
                                                            <div class="checkbox">
                                                                <label>
                                                                    {{Form::checkbox('hsware_item[]', $hs_item->id,($hs_item->status==1?TRUE:FALSE))}}
                                                                    {{$hs_item->codes}} {{$hs_item->title}} {{\HswareItem::get_submodel($hs_item->sub_model)}}  {{\HswareItem::get_hsware($hs_item->id)}}
                                                                </label>
                                                            </div>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile">
                                        <div class="panel-body">
                                            <a href="javascript:;" rel="mis/hsware/dialog" class="btn btn-primary link_dialog" title="เพิ่มอุปกรณ์ใหม่" role="button"><i class="fa fa-plus"></i> เพิ่มอุปกรณ์ใหม่</a>
                                            <?php
                                            foreach (\DB::table('hsware_group')
                                                    ->join('hsware_item', 'hsware_item.group_id', '=', 'hsware_group.id')
                                                    ->where('hsware_group.disabled', 0)
                                                    ->select(array('hsware_group.id', 'hsware_group.title'))
                                                    ->distinct()
                                                    ->get() as $group_item2) {
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label col-lg-2" for="hsware_item">{{$group_item2->title}}</label>
                                                    <div class="col-lg-6">
                                                        <?php
                                                        foreach (\DB::table('hsware_item')
                                                                ->join('hsware_model', 'hsware_model.id', '=', 'hsware_item.model_id')
                                                                ->where('hsware_item.group_id', $group_item2->id)
                                                                ->where('hsware_item.spare', 0)
                                                                ->where('hsware_item.status', 0)
                                                                ->select(array(
                                                                    'hsware_item.id as id',
                                                                    'hsware_item.sub_model as sub_model',
                                                                    'hsware_item.serial_code as codes',
                                                                    'hsware_model.title as title',
                                                                    'hsware_item.status as status',
                                                                ))
                                                                ->get() as $hs_item2) {
                                                            ?>
                                                            <div class="checkbox">
                                                                <label>
                                                                    {{Form::checkbox('hsware_item[]', $hs_item2->id,($hs_item2->status==1?TRUE:FALSE))}}
                                                                    {{$hs_item2->codes}} {{$hs_item2->title}}  {{\HswareItem::get_hsware($hs_item2->id)}}
                                                                </label>
                                                            </div>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="gallery" class="tab-pane">
                        <div class="panel-body">
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home1" aria-controls="home1" role="tab" data-toggle="tab">ผู้ใช้งาน</a></li>
                                    <li role="presentation"><a href="#profile1" aria-controls="profile1" role="tab" data-toggle="tab">เปลี่ยนผู้ใช้งาน</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home1">
                                        <div class="panel-body">
                                            <p>{{$item->fullname}} {{$item->position}}</p>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile1">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label col-lg-2" for="hsware_item">เลือกผู้ใช้งาน</label>
                                                <div class="col-lg-6">
                                                    <?php
                                                    foreach (\DB::table('users')
                                                            ->join('position_item', 'users.position_id', '=', 'position_item.id')
                                                            ->where('users.company_id', $item->company_id)
                                                            ->where('users.computer_status', 0)
                                                            ->select(array(
                                                                'users.id as id',
                                                                \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
                                                                'position_item.title as position',
                                                                'users.computer_status as status'
                                                            ))
                                                            ->get() as $user_item) {
                                                        ?>
                                                        <div class="radio">
                                                            <label>
                                                                {{Form::radio('user_item[]', $user_item->id)}}
                                                                {{$user_item->fullname}} <strong>ตำแหน่ง</strong> {{$user_item->position}}
                                                            </label>
                                                        </div>
                                                    <?php }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
{{ Form::close() }}
@stop

@section('script')
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
{{HTML::script('js/jquery.form.min.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'th'
    });
    $(function () {
        var options = {
            url: base_url + index_page + "mis/computer/edit/{{$item->id}}",
            success: showResponse
        };
        $('#btnSave').click(function () {
            $('#form-add').ajaxSubmit(options);
        });
    });

    function showResponse(response, statusText, xhr, $form) {
        if (response.error.status === false) {
            $('form .form-group').removeClass('has-error');
            $('form .help-block').remove();
            $('#btnSave').removeAttr('disabled');
            $.each(response.error.message, function (key, value) {
                $('#' + key).parent().parent().addClass('has-error');
                $('#' + key).after('<p class="help-block">' + value + '</p>');
            });
        } else {
            window.location.href = base_url + index_page + "mis/computer";
        }
    }
</script>
@stop