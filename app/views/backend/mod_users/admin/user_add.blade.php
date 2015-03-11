{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('firstname', 'ชื่อ', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-8">
        {{Form::text('firstname', NULL,array('class'=>'form-control','id'=>'firstname'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('lastname', 'นามสกุล', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-8">
        {{Form::text('lastname', NULL,array('class'=>'form-control','id'=>'lastname'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('email', 'อีเมล์', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-8">
        {{Form::text('email', NULL,array('class'=>'form-control','id'=>'email'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('phone', 'เบอร์ติดต่อ', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-4">
        {{Form::text('phone', NULL,array('class'=>'form-control','id'=>'phone'))}}
    </div>
</div>
<hr />
<div class="form-group">
    {{Form::label('role_id', 'กลุ่ม', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-5">
        {{ \Form::select('role_id', array('' => 'เลือกกลุ่ม') + DB::table('roles')
                                ->lists('name', 'id'), null, array('class' => 'form-control', 'id' => 'role_id')); }}
    </div>
</div>
<div class="form-group">
    {{Form::label('username', 'ชื่อผู้ใช้', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
        {{Form::text('username', NULL,array('class'=>'form-control','id'=>'username'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('password', 'รหัสผ่าน', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
        {{Form::password('password',array('class' => 'form-control'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('disabled', '&nbsp;', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-3">
        {{Form::checkbox('disabled', 1)}} เปิดใช้งาน
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "users/backend/add",
            data: $('#form-add, select input:not(#btnSave)').serializeArray(),
            success: function (data) {
                if (data.error.status == false) {
                    $('#btnSave').removeAttr('disabled');
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $.each(data.error.message, function (key, value) {
                        $('#' + key).parent().parent().addClass('has-error');
                        $('#' + key).after('<p class="help-block">' + value + '</p>');
                    });
                } else {
                    window.location.href = base_url + index_page + "users/backend";
                }
            },
            error: function (err) {
                $('form .form-group').removeClass('has-error');
                $('form .help-block').remove();
                $('#show_error').remove();
                $('#form-add').before('<div class="alert alert-danger" role="alert" id="show_error"><strong>Error</strong> ' + err.responseJSON.error.message + '</div>');
            }
        });
    });
</script>