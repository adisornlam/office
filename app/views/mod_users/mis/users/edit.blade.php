{{HTML::style('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}
{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">ข้อมูลทั่วไป</a></li>
        <li role="presentation"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">ข้อมูลเข้าระบบ</a></li>
        <li role="presentation"><a href="#avatar" aria-controls="avatar" role="tab" data-toggle="tab">รูปโปรไฟล์</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general">
            <div class="panel-body">
                <div class="form-group">
                    {{Form::label('firstname', 'ชื่อ', array('class' => 'col-sm-3 control-label req'))}}
                    <div class="col-sm-9">
                        {{Form::text('firstname', $item->firstname,array('class'=>'form-control','id'=>'firstname'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('lastname', 'นามสกุล', array('class' => 'col-sm-3 control-label req'))}}
                    <div class="col-sm-9">
                        {{Form::text('lastname', $item->lastname,array('class'=>'form-control','id'=>'lastname'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('codes', 'รหัสพนักงาน', array('class' => 'col-sm-3 control-label req'))}}
                    <div class="col-sm-4">
                        {{Form::text('codes', $item->codes,array('class'=>'form-control','id'=>'codes'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('email', 'อีเมล์', array('class' => 'col-sm-3 control-label'))}}
                    <div class="col-sm-8">
                        {{Form::text('email', $item->email,array('class'=>'form-control','id'=>'email'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('phone', 'เบอร์ติดต่อ', array('class' => 'col-sm-3 control-label'))}}
                    <div class="col-sm-4">
                        {{Form::text('phone', $item->phone,array('class'=>'form-control','id'=>'phone'))}}
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
                        {{ \Form::select('company_id', array('' => 'กรุณาเลือกบริษัท') + \Company::lists('title', 'id'), $item->company_id, array('class' => 'form-control', 'id' => 'company_id')); }}
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
                        {{Form::checkbox('disabled', 1,($item->disabled==0?TRUE:FALSE))}} เปิดใช้งาน
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('verified', '&nbsp;', array('class' => 'col-sm-3 control-label'))}}
                    <div class="col-sm-3">
                        {{Form::checkbox('verified', 1,($item->verified==1?TRUE:FALSE))}} ตรวจสอบ
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnDialogSave'))}}    
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="login">
            <div class="panel-body">
                <div class="form-group">
                    {{Form::label('role_id', 'กลุ่ม', array('class' => 'col-sm-3 control-label req'));}}
                    <div class="col-sm-5">
                        {{ \Form::select('role_id[]', \DB::table('roles')
                                ->lists('name', 'id'), $role_id, array('class' => 'form-control', 'id' => 'role_id','multiple' => true)); }}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('username', 'ชื่อผู้ใช้', array('class' => 'col-sm-3 control-label req'))}}
                    <div class="col-sm-6">
                        {{Form::text('username', $item->username,array('class'=>'form-control','id'=>'username'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('password', 'รหัสผ่าน', array('class' => 'col-sm-3 control-label'))}}
                    <div class="col-sm-6">
                        {{Form::password('password',array('class' => 'form-control'))}}
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="avatar">
            <div class="panel-body">
                <div class="form-group last">
                    <label class="control-label col-md-3">รูปโปรไฟล์</label>
                    <div class="col-md-9">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-white btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                    <input type="file" class="default" name="avatar" />
                                </span>
                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                            </div>
                        </div>
                        <span class="label label-danger">NOTE!</span>
                        <span>
                            ขนาดรูปโปรไฟล์ไม่เกิน 512 KB นะค่ะ
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
{{ Form::close() }}
{{HTML::script('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}
{{HTML::script('js/jquery.form.min.js')}}
<script type="text/javascript">
    $('body').on('shown.bs.modal', '.modal', function () {
        $('#firstname').focus();
    });

    $('#form-add #company_id').change(function () {
        $.get("{{ url('get/department')}}",
                {option: $(this).val()},
        function (data) {
            var department = $('#form-add #department_id');
            department.empty();
            department.append("<option value=''>กรุณาเลือกฝ่าย/แผนก</option>");
            $.each(data, function (index, element) {
                department.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $('#form-add #department_id').change(function () {
        $.get("{{ url('get/position')}}",
                {option: $(this).val()},
        function (data) {
            var position = $('#form-add #position_id');
            position.empty();
            position.append("<option value=''>กรุณาเลือกตำแหน่ง</option>");
            $.each(data, function (index, element) {
                position.append("<option value='" + element.id + "'>" + element.title + "</option>");
            });
        });
    });

    $(function () {
        var department_id = <?php echo ($item->department_id ? $item->department_id : 0); ?>;
        var position_id = <?php echo ($item->position_id ? $item->position_id : 0); ?>;
        $.get("{{ url('get/department')}}",
                {option: $('#form-add #company_id').val()},
        function (data) {
            var department = $('#form-add #department_id');
            department.empty();
            department.append("<option value=''>กรุณาเลือกฝ่าย/แผนก</option>");
            $.each(data, function (index, element) {
                var department_select = (element.id === '' + department_id + '' ? "selected" : "");
                department.append("<option value='" + element.id + "' " + department_select + ">" + element.title + "</option>");
            });

            $.get("{{ url('get/position')}}",
                    {option: $('#form-add #department_id').val()},
            function (data) {
                var position = $('#form-add #position_id');
                position.empty();
                position.append("<option value=''>กรุณาเลือกตำแหน่ง</option>");
                $.each(data, function (index, element) {
                    var position_select = (element.id === '' + position_id + '' ? "selected" : "");
                    position.append("<option value='" + element.id + "' " + position_select + ">" + element.title + "</option>");
                });
            });

        });

        var options = {
            url: base_url + index_page + "users/edit/{{$item->id}}",
            success: showResponse
        };
        $('#btnDialogSave').click(function () {
            $('#form-add').ajaxSubmit(options);
        });
    });

    function showResponse(response, statusText, xhr, $form) {
        if (response.error.status === false) {
            $('#form-add .form-group').removeClass('has-error');
            $('#form-add .help-block').remove();
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