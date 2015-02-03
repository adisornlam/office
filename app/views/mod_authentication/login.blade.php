@extends('layouts.login')
@section('content')
{{Form::open(array('id'=>'form-signin','class'=>'form-signin','role'=>'form','method' => 'post'))}}
<h2 class="form-signin-heading">sign in now</h2>
<div class="login-wrap">
    {{Form::text('username',null,array('id'=>'username','class'=>'form-control','placeholder'=>'อีเมล์ / ชื่อผู้ใช้งาน'))}}
    {{Form::password('password',array('class'=>'form-control','placeholder'=>'รหัสผ่าน','id'=>'password'))}}
    <label class="checkbox">
        {{Form::checkbox('remember', 1)}}  Remember me
        <span class="pull-right">
            <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
        </span>
    </label>
    <a href="javascript:;" class="btn btn-lg btn-login btn-block" id="btnLogin"> เข้าสู่ระบบ </a>
</div>
{{ Form::close() }}
@stop
@section('script_code')
<script type="text/javascript">
    var protocol = window.location.protocol;
    var base_url = protocol + "//" + document.location.hostname + "/office/";
    var index_page = "";
    $(function () {
        $('#btnLogin').click(function () {
            $.ajax({
                type: "post",
                url: base_url + index_page + "login",
                data: $('#form-signin input:not(#btnLogin)').serializeArray(),
                success: function (data) {
                    if (data.error.status == false) {
                        $('form .form-group').removeClass('has-error');
                        $('form .help-block').remove();
                        $.each(data.error.message, function (key, value) {
                            $('#' + key).addClass('has-error');
                            $('#' + key).after('<p class="help-block">' + value + '</p>');
                        });
                    } else {
                        window.location.href = base_url;
                    }
                },
                error: function (err) {
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $('#show_error').remove();
                    $('#form-signin').before('<div class="alert alert-danger" role="alert" id="show_error"><strong>Error</strong> ' + err.responseJSON.error.message + '</div>');
                }
            });
        });
    });

    $(document).keyup(function (e) {
        if (e.keyCode == 13) {
            $.ajax({
                type: "post",
                url: base_url + index_page + "login",
                data: $('#form-signin input:not(#btnLogin)').serializeArray(),
                success: function (data) {
                    if (data.error.status == false) {
                        $('form .form-group').removeClass('has-error');
                        $('form .help-block').remove();
                        $.each(data.error.message, function (key, value) {
                            $('#' + key).addClass('has-error');
                            $('#' + key).after('<p class="help-block">' + value + '</p>');
                        });
                    } else {
                        window.location.href = base_url;
                    }
                },
                error: function (err) {
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $('#show_error').remove();
                    $('#form-signin').before('<div class="alert alert-danger" role="alert" id="show_error"><strong>Error</strong> ' + err.responseJSON.error.message + '</div>');
                }
            });
        }
    });
</script>
@stop