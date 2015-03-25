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

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{$title}}
            </header>
            <div class="panel-body">
                <div class="stepy-tab">
                    <ul id="default-titles" class="stepy-titles clearfix">
                        <li id="default-title-0" class="current-step">
                            <div>ข้อมูลคอมพิวเตอร์</div>
                        </li>
                        <li id="default-title-1" class="">
                            <div>Mainboard</div>
                        </li>
                        <li id="default-title-2" class="">
                            <div>CPU</div>
                        </li>
                        <li id="default-title-3" class="">
                            <div>HDD</div>
                        </li>
                        <li id="default-title-4" class="">
                            <div>RAM</div>
                        </li>
                        <li id="default-title-5" class="">
                            <div>VGA</div>
                        </li>
                        <li id="default-title-6" class="">
                            <div>SOUND</div>
                        </li>
                        <li id="default-title-7" class="">
                            <div>PW SUPPLY</div>
                        </li>
                        <li id="default-title-8" class="">
                            <div>CASE</div>
                        </li>
                        <li id="default-title-9" class="">
                            <div>Monitor</div>
                        </li>
                        <li id="default-title-10" class="">
                            <div>UPS</div>
                        </li>
                        <li id="default-title-11" class="">
                            <div>SOFTWARE</div>
                        </li>
                        <li id="default-title-12" class="">
                            <div>USER</div>
                        </li>
                    </ul>
                </div>
                {{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal default'))}}
                <fieldset title="Info" class="step" id="default-step-0">
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('company_id', 'สินทรัพย์บริษัท', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-3">
                                {{ \Form::select('company_id', $company, \Input::get('company_id'), array('class' => 'form-control', 'id' => 'company_id')); }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('serial_code', 'เลขระเบียน', array('class' => 'col-sm-2 control-label req'))}}
                            <div class="col-sm-2">
                                {{Form::text('serial_code', NULL,array('class'=>'form-control','id'=>'serial_code'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('access_no', 'ACC NO', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-3">
                                {{Form::text('access_no', NULL,array('class'=>'form-control','id'=>'access_no'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'ชื่อคอมพิวเตอร์', array('class' => 'col-sm-2 control-label req'))}}
                            <div class="col-sm-3">
                                {{Form::text('title', NULL,array('class'=>'form-control','id'=>'title'))}}
                            </div>
                        </div>   
                        <div class="form-group">
                            {{Form::label('ip_address', 'IP Address', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                {{Form::text('ip_address', NULL,array('class'=>'form-control','id'=>'ip_address'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('mac_lan', 'Mac Address Lan Local', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                {{Form::text('mac_lan', NULL,array('class'=>'form-control','id'=>'mac_lan'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('locations', 'ตำแหน่งวาง', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                {{ \Form::select('locations', $place,null, array('class' => 'form-control', 'id' => 'locations')); }}
                            </div>
                        </div>   
                        <div class="form-group">
                            {{Form::label('register_date', 'วันที่ลงทะเบียน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('register_date', date('Y-m-d'),array('class'=>'form-control datepicker','id'=>'register_date'))}}
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
                                    {{Form::checkbox('disabled', 1,TRUE)}} เปิดใช้งาน
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset title="Mainboard" class="step" id="default-step-1" >
                    <legend> </legend>                       
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'ยี่ห้อ/รุ่น', array('class' => 'col-sm-2 control-label req'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[2][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',2)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id2')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=2" class="btn btn-primary link_dialog" title="เพิ่มยี่ห้ออุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            {{Form::label('sub_model', 'รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('sub_model[2][]', array('' =>'กรุณาเลือกรุ่น'), null, array('class' => 'form-control', 'id' => 'sub_model2'));}}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" id="btnAddSubModel2" rel="" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มรุ่นอุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[2][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset title="CPU" class="step" id="default-step-2" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'ยี่ห้อ/รุ่น', array('class' => 'col-sm-2 control-label req'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[8][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',8)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id8')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=8" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            {{Form::label('sub_model', 'รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('sub_model[8][]', array('' =>'กรุณาเลือกรุ่น'), null, array('class' => 'form-control', 'id' => 'sub_model8'));}}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" id="btnAddSubModel8" rel="" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มรุ่นอุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach(\DB::table('hsware_spec_label')->where('group_id',8)->get() as $item_label)
                        <div class="form-group">
                            {{Form::label('', $item_label->title, array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-3">              
                                @if($item_label->option_id>0)
                                {{Form::select($item_label->name.'[8][]',
                                                array('' => 'กรุณาเลือกรายการ') +\DB::table('hsware_spec_option')
                                                ->join('hsware_spec_option_item', 'hsware_spec_option.id', '=', 'hsware_spec_option_item.option_id')
                                                ->select('hsware_spec_option_item.title','hsware_spec_option_item.id')
                                                ->where('option_id',$item_label->option_id)
                                                ->orderBy('title', 'asc')
                                                ->lists('title','id'),
                                                NULL,array('class'=>'form-control'))}}
                                @else
                                {{Form::text($item_label->name.'[8][]',null,array('class'=>'form-control'))}}
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[8][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset title="HDD" class="step" id="default-step-3" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'HDD 1', array('class' => 'col-sm-2 control-label req'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[22][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',22)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id22')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=22" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        @foreach(\DB::table('hsware_spec_label')->where('group_id',22)->get() as $item_label)
                        <div class="form-group">
                            {{Form::label('', $item_label->title, array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-3">              
                                @if($item_label->option_id>0)
                                {{Form::select($item_label->name.'[22][]',
                                                array('' => 'กรุณาเลือกรายการ') +\DB::table('hsware_spec_option')
                                                ->join('hsware_spec_option_item', 'hsware_spec_option.id', '=', 'hsware_spec_option_item.option_id')
                                                ->select('hsware_spec_option_item.title','hsware_spec_option_item.id')
                                                ->where('option_id',$item_label->option_id)
                                                ->orderBy('title', 'asc')
                                                ->lists('title','id'),
                                                NULL,array('class'=>'form-control'))}}
                                @else
                                {{Form::text($item_label->name.'[22][]',null,array('class'=>'form-control'))}}
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[22][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset title="RAM" class="step" id="default-step-4" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'RAM 1', array('class' => 'col-sm-2 control-label req'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[3][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',3)->lists('title', 'id'), null, array('class' => 'form-control')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=3" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach(\DB::table('hsware_spec_label')->where('group_id',3)->get() as $item_label)
                        <div class="form-group">
                            {{Form::label('', $item_label->title, array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-3">              
                                @if($item_label->option_id>0)
                                {{Form::select($item_label->name.'[3][]',
                                                array('' => 'กรุณาเลือกรายการ') +\DB::table('hsware_spec_option')
                                                ->join('hsware_spec_option_item', 'hsware_spec_option.id', '=', 'hsware_spec_option_item.option_id')
                                                ->select('hsware_spec_option_item.title','hsware_spec_option_item.id')
                                                ->where('option_id',$item_label->option_id)
                                                ->orderBy('title', 'asc')
                                                ->lists('title','id'),
                                                NULL,array('class'=>'form-control'))}}
                                @else
                                {{Form::text($item_label->name.'[3][]',null,array('class'=>'form-control'))}}
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            {{Form::label('model_id', 'RAM 2', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[3][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',3)->lists('title', 'id'), null, array('class' => 'form-control')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach(\DB::table('hsware_spec_label')->where('group_id',3)->get() as $item_label)
                        <div class="form-group">
                            {{Form::label('', $item_label->title, array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-3">              
                                @if($item_label->option_id>0)
                                {{Form::select($item_label->name.'[3][]',
                                                array('' => 'กรุณาเลือกรายการ') +\DB::table('hsware_spec_option')
                                                ->join('hsware_spec_option_item', 'hsware_spec_option.id', '=', 'hsware_spec_option_item.option_id')
                                                ->select('hsware_spec_option_item.title','hsware_spec_option_item.id')
                                                ->where('option_id',$item_label->option_id)
                                                ->orderBy('title', 'asc')
                                                ->lists('title','id'),
                                                NULL,array('class'=>'form-control'))}}
                                @else
                                {{Form::text($item_label->name.'[3][]',null,array('class'=>'form-control'))}}
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[3][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset title="VGA" class="step" id="default-step-5" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'ยี่ห้อ/รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[6][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',6)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id6')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=6" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            {{Form::label('sub_model', 'รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('sub_model[6][]', array('' =>'กรุณาเลือกรุ่น'), null, array('class' => 'form-control', 'id' => 'sub_model6'));}}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" id="btnAddSubModel6" rel="" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มรุ่นอุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[6][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>                    
                </fieldset>
                <fieldset title="SOUND" class="step" id="default-step-6" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'ยี่ห้อ/รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[5][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',5)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id5')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=5" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            {{Form::label('sub_model', 'รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('sub_model[5][]', array('' =>'กรุณาเลือกรุ่น'), null, array('class' => 'form-control', 'id' => 'sub_model5'));}}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" id="btnAddSubModel5" rel="" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มรุ่นอุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[5][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset title="PW SUPPLY" class="step" id="default-step-7" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'ยี่ห้อ/รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[7][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',7)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id7')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=7" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            {{Form::label('sub_model', 'รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('sub_model[7][]', array('' =>'กรุณาเลือกรุ่น'), null, array('class' => 'form-control', 'id' => 'sub_model7'));}}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" id="btnAddSubModel7" rel="" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มรุ่นอุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach(\DB::table('hsware_spec_label')->where('group_id',7)->get() as $item_label)
                        <div class="form-group">
                            {{Form::label('', $item_label->title, array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-3">              
                                @if($item_label->option_id>0)
                                {{Form::select($item_label->name.'[7][]',
                                                array('' => 'กรุณาเลือกรายการ') +\DB::table('hsware_spec_option')
                                                ->join('hsware_spec_option_item', 'hsware_spec_option.id', '=', 'hsware_spec_option_item.option_id')
                                                ->select('hsware_spec_option_item.title','hsware_spec_option_item.id')
                                                ->where('option_id',$item_label->option_id)
                                                ->orderBy('title', 'asc')
                                                ->lists('title','id'),
                                                NULL,array('class'=>'form-control'))}}
                                @else
                                {{Form::text($item_label->name.'[7][]',null,array('class'=>'form-control'))}}
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[7][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset title="CASE" class="step" id="default-step-8" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'ยี่ห้อ/รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[26][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',26)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id26')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=26" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            {{Form::label('sub_model', 'รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('sub_model[26][]', array('' =>'กรุณาเลือกรุ่น'), null, array('class' => 'form-control', 'id' => 'sub_model26'));}}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" id="btnAddSubModel26" rel="" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มรุ่นอุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[26][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset title="Monitor" class="step" id="default-step-9" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'ยี่ห้อ/รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[14][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',14)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id14')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=14" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            {{Form::label('sub_model', 'รุ่น', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('sub_model[14][]', array('' =>'กรุณาเลือกรุ่น'), null, array('class' => 'form-control', 'id' => 'sub_model14'));}}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" id="btnAddSubModel14" rel="" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มรุ่นอุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach(\DB::table('hsware_spec_label')->where('group_id',14)->get() as $item_label)
                        <div class="form-group">
                            {{Form::label('', $item_label->title, array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-3">              
                                @if($item_label->option_id>0)
                                {{Form::select($item_label->name.'[14][]',
                                                array('' => 'กรุณาเลือกรายการ') +\DB::table('hsware_spec_option')
                                                ->join('hsware_spec_option_item', 'hsware_spec_option.id', '=', 'hsware_spec_option_item.option_id')
                                                ->select('hsware_spec_option_item.title','hsware_spec_option_item.id')
                                                ->where('option_id',$item_label->option_id)
                                                ->orderBy('title', 'asc')
                                                ->lists('title','id'),
                                                NULL,array('class'=>'form-control'))}}
                                @else
                                {{Form::text($item_label->name.'[14][]',null,array('class'=>'form-control'))}}
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[14][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>
                </fieldset>      
                <fieldset title="UPS" class="step" id="default-step-10" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'UPS', array('class' => 'col-sm-2 control-label'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('model_id[13][]',array('' => 'เลือกยี่ห้อ') +  \DB::table('hsware_model')->where('group_id',13)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'model_id13')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" rel="mis/hsware/group/model/dialog/add?group_id=13" class="btn btn-primary link_dialog" title="เพิ่มรุ่นอุปกรณ์" role="button"><i class="fa fa-plus"></i> เพิ่มยี่ห้ออุปกรณ์</a>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        @foreach(\DB::table('hsware_spec_label')->where('group_id',13)->get() as $item_label)
                        <div class="form-group">
                            {{Form::label('', $item_label->title, array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-3">              
                                @if($item_label->option_id>0)
                                {{Form::select($item_label->name.'[13][]',
                                                array('' => 'กรุณาเลือกรายการ') +\DB::table('hsware_spec_option')
                                                ->join('hsware_spec_option_item', 'hsware_spec_option.id', '=', 'hsware_spec_option_item.option_id')
                                                ->select('hsware_spec_option_item.title','hsware_spec_option_item.id')
                                                ->where('option_id',$item_label->option_id)
                                                ->orderBy('title', 'asc')
                                                ->lists('title','id'),
                                                NULL,array('class'=>'form-control'))}}
                                @else
                                {{Form::text($item_label->name.'[13][]',null,array('class'=>'form-control'))}}
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                            <div class="col-sm-2">
                                <div class="input-group date form_datetime-component">
                                    {{Form::text('warranty_date[13][]', NULL,array('class'=>'form-control datepicker'))}}
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span class="help-block">LT ไม่ต้องกำหนด</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset title="SOFTWARE" class="step" id="default-step-11" >
                    <legend> </legend>                       
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('model_id', 'กลุ่มโปรแกรมติดตั้ง', array('class' => 'col-sm-2 control-label req'));}}
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{ \Form::select('software_group_id',array('' => 'เลือกกลุ่มติดตั้ง Software') +  \DB::table('software_group_item')->where('disabled',0)->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'software_group_id')); }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{{URL::to('mis/software/group/add')}}" class="btn btn-primary link_dialog" title="เพิ่มกลุ่มติดตั้ง Software" role="button"><i class="fa fa-plus"></i> เพิ่มกลุ่มติดตั้ง Software</a>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </fieldset>
                <fieldset title="USER" class="step" id="default-step-12" >
                    <legend> </legend>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label col-lg-2" for="hsware_item">เลือกผู้ใช้งาน</label>
                            <div class="col-lg-6">
                                <?php
                                foreach (\DB::table('users')
                                        ->join('position_item', 'users.position_id', '=', 'position_item.id')
                                        ->join('department_item', 'users.department_id', '=', 'department_item.id')
                                        ->where('users.company_id', \Input::get('company_id'))
                                        ->where('users.computer_status', 0)
                                        ->orderBy('department_item.id')
                                        ->select(array(
                                            'users.id as id',
                                            \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
                                            'position_item.title as position',
                                            'department_item.title as department'
                                        ))
                                        ->get() as $user_item) {
                                    ?>
                                    <div class="checkbox">
                                        <label>
                                            {{Form::checkbox('user_item[]', $user_item->id)}}
                                            {{$user_item->fullname}} <strong>แผนก</strong> {{$user_item->department}} <strong>ตำแหน่ง</strong> {{$user_item->position}}
                                        </label>
                                    </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <a href="javascript:;" class="finish btn btn-danger" role="button" id="btnSave">Finish</a>
                {{ Form::close() }}
            </div>
        </section>
    </div>
</div>
@stop

@section('script')
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
{{HTML::script('js/jquery.validate.min.js')}}
{{HTML::script('js/jquery.form.min.js')}}
{{HTML::script('js/jquery.stepy.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true, todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'th'
    });

    $('#model_id2').change(function () {
        $('#btnAddSubModel2').attr('rel', 'mis/hsware/group/model/sub/add/' + $(this).val() + '?group_id=2');
        $.get("{{ url('get/submodel')}}",
                {option: $(this).val()}, function (data) {
            var submodel = $('#sub_model2');
            submodel.parent().parent().parent().parent().removeClass('hidden');
            submodel.empty();
            submodel.append("<option value=''>กรุณาเลือกรุ่น</option>");
            $.each(data, function (index, element) {
                submodel.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $('#model_id8').change(function () {
        $('#btnAddSubModel8').attr('rel', 'mis/hsware/group/model/sub/add/' + $(this).val() + '?group_id=8');
        $.get("{{ url('get/submodel')}}",
                {option: $(this).val()}, function (data) {
            var submodel = $('#sub_model8');
            submodel.parent().parent().parent().parent().removeClass('hidden');
            submodel.empty();
            submodel.append("<option value=''>กรุณาเลือกรุ่น</option>");
            $.each(data, function (index, element) {
                submodel.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $('#model_id14').change(function () {
        $('#btnAddSubModel14').attr('rel', 'mis/hsware/group/model/sub/add/' + $(this).val() + '?group_id=14');
        $.get("{{ url('get/submodel')}}",
                {option: $(this).val()}, function (data) {
            var submodel = $('#sub_model14');
            submodel.parent().parent().parent().parent().removeClass('hidden');
            submodel.empty();
            submodel.append("<option value=''>กรุณาเลือกรุ่น</option>");
            $.each(data, function (index, element) {
                submodel.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $('#model_id6').change(function () {
        $('#btnAddSubModel6').attr('rel', 'mis/hsware/group/model/sub/add/' + $(this).val() + '?group_id=6');
        $.get("{{ url('get/submodel')}}",
                {option: $(this).val()}, function (data) {
            var submodel = $('#sub_model6');
            submodel.parent().parent().parent().parent().removeClass('hidden');
            submodel.empty();
            submodel.append("<option value=''>กรุณาเลือกรุ่น</option>");
            $.each(data, function (index, element) {
                submodel.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $('#model_id5').change(function () {
        $('#btnAddSubModel5').attr('rel', 'mis/hsware/group/model/sub/add/' + $(this).val() + '?group_id=5');
        $.get("{{ url('get/submodel')}}",
                {option: $(this).val()}, function (data) {
            var submodel = $('#sub_model5');
            submodel.parent().parent().parent().parent().removeClass('hidden');
            submodel.empty();
            submodel.append("<option value=''>กรุณาเลือกรุ่น</option>");
            $.each(data, function (index, element) {
                submodel.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $('#model_id7').change(function () {
        $('#btnAddSubModel7').attr('rel', 'mis/hsware/group/model/sub/add/' + $(this).val() + '?group_id=7');
        $.get("{{ url('get/submodel')}}",
                {option: $(this).val()}, function (data) {
            var submodel = $('#sub_model7');
            submodel.parent().parent().parent().parent().removeClass('hidden');
            submodel.empty();
            submodel.append("<option value=''>กรุณาเลือกรุ่น</option>");
            $.each(data, function (index, element) {
                submodel.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $('#model_id26').change(function () {
        $('#btnAddSubModel26').attr('rel', 'mis/hsware/group/model/sub/add/' + $(this).val() + '?group_id=26');
        $.get("{{ url('get/submodel')}}",
                {option: $(this).val()}, function (data) {
            var submodel = $('#sub_model26');
            submodel.parent().parent().parent().parent().removeClass('hidden');
            submodel.empty();
            submodel.append("<option value=''>กรุณาเลือกรุ่น</option>");
            $.each(data, function (index, element) {
                submodel.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $('#company_id').change(function () {
        $.get("{{ url('get/getSerialCom')}}",
                {company_id: $(this).val()}, function (data) {
            $('#serial_code').val(data);
            $('#title').val(data);
        });
    });


    $(function () {
        $('.default').stepy({
            backLabel: 'Previous',
            block: true,
            nextLabel: 'Next', titleClick: true,
            titleTarget: '.stepy-tab',
            validate: true
        });

        $('.default').validate({
            errorPlacement: function (error, element) {
                //$('.default div.stepy-error').append(error);
            }, rules: {
                'serial_code': 'required',
                'title': 'required',
                'model_id[2][]': 'required',
                'model_id[8][]': 'required',
                'model_id[22][]': 'required'
            }
        });

        $.get("{{ url('get/getSerialCom')}}",
                {company_id: $('#company_id').val()}, function (data) {
            $('#serial_code').val(data);
            $('#title').val(data);
        });

        var options = {url: base_url + index_page + "mis/computer/add_wizard",
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