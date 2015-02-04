@extends('layouts.master')

@section('style')
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{$title}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            @foreach ($breadcrumbs as $key => $val)
            @if ($val === reset($breadcrumbs))
            <li><a href="{{URL::to($val)}}"><i class="icon-home"></i> {{$key}}</a></li>
            @elseif ($val === end($breadcrumbs))
            <li class="active">{{$key}}</li>
            @else
            <li><a href="{{URL::to($val)}}"> {{$key}}</a></li>
            @endif
            @endforeach
        </ul>
    </div>
</div>           
<div class="row">
    <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
        <form class="form-horizontal" role="form">
            <h3>ข้อมูลส่วนตัว</h3>
            <div class="form-group">
                {{Form::label('firstname', 'ชื่อ-นามสกุล:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-9">                   
                    <div class="row">
                        <div class="col-xs-5">
                            {{Form::text('firstname', $item->firstname,array('id'=>'firstname','class'=>'form-control','placeholder'=>'ชื่อ'))}}
                        </div>
                        <div class="col-xs-5">
                            {{Form::text('lastname', $item->lastname,array('id'=>'lastname','class'=>'form-control','placeholder'=>'นามสกุล'))}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('nickname', 'ชื่อเล่น:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-xs-5">
                            {{Form::text('nickname', $item->nickname,array('id'=>'nickname','class'=>'form-control'))}}
                        </div>
                        <div class="col-xs-5">
                            {{Form::text('idcard', $item->idcard,array('id'=>'idcard','class'=>'form-control','placeholder'=>'เลขบัตรประจำตัวประชาชน'))}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('birthday', 'วันเดือนปีเกิด:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-xs-5">
                            {{Form::text('birthday', $item->birthday,array('id'=>'birthday','class'=>'form-control'))}}
                        </div>
                        <div class="col-xs-5">
                            {{Form::text('mobile', $item->mobile,array('id'=>'mobile','class'=>'form-control','placeholder'=>'เบอร์ติดต่อ'))}} 
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('email', 'อีเมล์:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-6">
                    {{Form::text('email', $item->email,array('id'=>'email','class'=>'form-control'))}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('address', 'ที่อยู่:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-8">
                    {{Form::text('address', $item->address,array('id'=>'address','class'=>'form-control'))}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('province', 'จังหวัด:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-xs-5">
                            {{ \Form::select('province', array('' => 'เลือกจังหวัด') + DB::table('province')
                                ->orderBy('province_name', 'asc')
                                ->lists('province_name', 'province_id'), null, array('class' => 'form-control', 'id' => 'province')); }}
                        </div>
                        <div class="col-xs-5">
                            {{ \Form::select('amphur', array('' => 'เลือกอำเภอ'), null, array('class' => 'form-control', 'id' => 'amphur'));}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('district', 'ตำบล:', array('class' => 'col-lg-3 control-label'));}}
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-xs-5">
                            {{ \Form::select('district', array('' => 'เลือกตำบล'), null, array('class' => 'form-control', 'id' => 'district'));}}
                        </div>
                        <div class="col-xs-5">
                            {{ \Form::select('zipcode', array('' => 'เลือกรหัสไปรษณีย์'), null, array('class' => 'form-control', 'id' => 'zipcode'));}}
                        </div>
                    </div>
                </div>
            </div>     
            <h3>ข้อมูลเข้าสู่ระบบ</h3>
            <div class="form-group">
                {{Form::label('role_id', 'กลุ่ม', array('class' => 'col-lg-3 control-label'));}}
                <div class="col-lg-5">
                    {{ \Form::select('role_id', DB::table('roles')
                                ->lists('name', 'id'), $item->roles->role_id, array('class' => 'form-control', 'id' => 'role_id')); }}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('username', 'ชื่อผู้ใช้:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-6">
                    {{Form::text('username', $item->username,array('id'=>'username','class'=>'form-control','disabled'=>'disabled'))}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('password', 'รหัสผ่าน:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-6">
                    {{Form::password('password',array('id'=>'password','class'=>'form-control'))}}
                </div>
            </div>
            <h3>ข้อมูลส่วนงาน</h3>
            <div class="form-group">
                {{Form::label('company', 'บริษัท:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-5">
                    {{ \Form::select('company', array('' => 'เลือกบริษัท') + DB::table('company')
                                ->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'company')); }}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('department', 'ฝ่าย/แผนก:', array('class' => 'col-lg-3 control-label'))}}
                <div class="col-lg-5">
                    {{ \Form::select('department', array('' => 'เลือกฝ่าย/แผนก') + DB::table('department')
                        ->where('type','department')
                ->where('disabled',0)
                                ->lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'department')); }}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                    {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg'))}}                    
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('script')
@stop

@section('script_code')
<script type="text/javascript">
    $(function () {
        $('#province').change(function () {
            $.get("{{ url('get/amphur')}}",
                    {option: $(this).val()},
            function (data) {
                var amphur = $('#amphur');
                amphur.empty();
                amphur.append("<option value=''>เลือกอำเภอ</option>");
                $.each(data, function (index, element) {
                    amphur.append("<option value='" + element.amphur_id + "'>" + element.amphur_name + "</option>");
                });
            });
        });

        $('#amphur').change(function () {
            $.get("{{ url('get/district')}}",
                    {option: $(this).val()},
            function (data) {
                var district = $('#district');
                district.empty();
                district.append("<option value=''>เลือกตำบล</option>");
                $.each(data, function (index, element) {
                    district.append("<option value='" + element.district_id + "'>" + element.district_name + "</option>");
                });
            });
        });

        $('#amphur').change(function () {
            $.get("{{ url('get/zipcode')}}",
                    {option: $(this).val()},
            function (data) {
                var zipcode = $('#zipcode');
                zipcode.empty();
                zipcode.append("<option value=''>เลือกรหัสไปรษณีย์</option>");
                $.each(data, function (index, element) {
                    zipcode.append("<option value='" + element.post_code + "'>" + element.post_code + "</option>");
                });
            });
        });
    });
</script>
@stop