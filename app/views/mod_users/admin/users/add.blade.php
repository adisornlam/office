{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">ข้อมูลทั่วไป</a></li>
        <li role="presentation"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">ข้อมูลเข้าระบบ</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general">
            <div class="panel-body">
                <div class="form-group">
                    {{Form::label('firstname', 'ชื่อ', array('class' => 'col-sm-3 control-label req'))}}
                    <div class="col-sm-5">
                        {{Form::text('firstname', NULL,array('class'=>'form-control','id'=>'firstname'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('lastname', 'นามสกุล', array('class' => 'col-sm-3 control-label req'))}}
                    <div class="col-sm-5">
                        {{Form::text('lastname', NULL,array('class'=>'form-control','id'=>'lastname'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('codes', 'รหัสพนักงาน', array('class' => 'col-sm-3 control-label'))}}
                    <div class="col-sm-4">
                        {{Form::text('codes', NULL,array('class'=>'form-control','id'=>'codes'))}}
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
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="inputSuccess">วันเกิด</label>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-lg-3">
                                {{Form::selectRange('day', 1, 31,null,array('class' => 'form-control', 'id' => 'day'))}}
                            </div>
                            <div class="col-lg-5">
                                {{Form::selectMonth('month',null,array('class' => 'form-control', 'id' => 'month'))}}
                            </div>
                            <div class="col-lg-4">
                                {{Form::selectRange('yeas', date('Y')-60, date('Y')-18,null,array('class' => 'form-control', 'id' => 'yeas'))}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('company_id', 'บริษัท', array('class' => 'col-sm-3 control-label req'));}}
                    <div class="col-sm-7">
                        {{ \Form::select('company_id', array('' => 'กรุณาเลือกบริษัท') + \Company::lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'company_id')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('department_id', 'ฝ่าย/แผนก', array('class' => 'col-sm-3 control-label'));}}
                    <div class="col-sm-7">
                        {{ \Form::select('department_id', array('' =>'กรุณาเลือกฝ่าย/แผนก'), null, array('class' => 'form-control', 'id' => 'department_id'));}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('position_id', 'ตำแหน่ง', array('class' => 'col-sm-3 control-label'));}}
                    <div class="col-sm-7">
                        {{ \Form::select('position_id', array('' =>'กรุณาเลือกตำแหน่ง'), null, array('class' => 'form-control', 'id' => 'position_id'));}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('disabled', '&nbsp;', array('class' => 'col-sm-3 control-label'))}}
                    <div class="col-sm-3">
                        <label>
                            {{Form::checkbox('disabled', 1)}} เปิดใช้งาน
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('verified', '&nbsp;', array('class' => 'col-sm-3 control-label'))}}
                    <div class="col-sm-3">
                        <label>
                            {{Form::checkbox('verified', 1)}} ตรวจสอบ
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="login">
            <div class="panel-body">
                <div class="form-group">
                    {{Form::label('role_id', 'กลุ่ม', array('class' => 'col-sm-3 control-label req'));}}
                    <div class="col-sm-5">
                        {{ \Form::select('role_id', array('' => 'เลือกกลุ่ม') + DB::table('roles')
                                ->lists('name', 'id'), null, array('class' => 'form-control', 'id' => 'role_id')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('username', 'ชื่อผู้ใช้', array('class' => 'col-sm-3 control-label req'))}}
                    <div class="col-sm-6">
                        {{Form::text('username', NULL,array('class'=>'form-control','id'=>'username'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('password', 'รหัสผ่าน', array('class' => 'col-sm-3 control-label req'))}}
                    <div class="col-sm-6">
                        {{Form::password('password',array('class' => 'form-control'))}}
                    </div>
                </div>
            </div>
        </div>      
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
            {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnDialogSave'))}}    
        </div>
    </div>
</div>
{{ Form::close() }}
{{HTML::script('js/jquery.form.min.js')}}
<script type="text/javascript">
    $('body').on('shown.bs.modal', '.modal', function () {
        $('#firstname').focus();
    });

    $('#form-add #company_id').change(function () {
        $.get("{{ url('get/department')}}",
                {option: $(this).val()},
        function (data) {
            var department = $('#department_id');
            department.empty();
            department.append("<option value=''>กรุณาเลือกฝ่าย/แผนก</option>");
            $.each(data, function (index, element) {
                department.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });

            $('#department_id').change(function () {
                $.get("{{ url('get/position')}}",
                        {option: $(this).val()},
                function (data) {
                    var position = $('#position_id');
                    position.empty();
                    position.append("<option value=''>กรุณาเลือกตำแหน่ง</option>");
                    $.each(data, function (index, element) {
                        position.append("<option value='" + element.id + "'>" + element.title + "</option>");
                    });
                });
            });

        });
    });

    $(function () {
        var options = {
            url: base_url + index_page + "users/add",
            success: showResponse
        };
        $('#btnDialogSave').click(function () {
            $('#form-add').ajaxSubmit(options);
        });
    });

    function showResponse(response, statusText, xhr, $form) {
        if (response.error.status === false) {
            $('form .form-group').removeClass('has-error');
            $('form .help-block').remove();
            $('#btnDialogSave').removeAttr('disabled');
            $.each(response.error.message, function (key, value) {
                $('#' + key).parent().parent().addClass('has-error');
                $('#' + key).after('<p class="help-block">' + value + '</p>');
            });
        } else {
            window.location.href = base_url + index_page + "users";
        }
    }
</script>