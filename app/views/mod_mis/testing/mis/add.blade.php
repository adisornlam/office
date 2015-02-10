{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('user_id', 'ผู้เข้าสอบ', array('class' => 'col-sm-3 control-label req'))}}
    <div class="col-sm-9">
        <div class="row">
            <div class="col-lg-3">
                {{Form::text('user_code', NULL,array('class'=>'form-control','id'=>'user_code'))}}
            </div>
            <div class="col-lg-8">
                {{ \Form::select('users_id', array('' => 'ค้นหาผู้เข้าสอบ') + \DB::table('users')
                            ->select(array('codes',\DB::raw('CONCAT(users.codes," - ",users.firstname," ",users.lastname) as fullname')))
                    ->where('users.codes','!=','')
                            ->lists('fullname', 'codes'), null, array('class' => 'form-control', 'id' => 'users_id')); }}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    {{Form::label('typing_th', 'ภาษาไทย', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-9">
        <div class="row">
            <div class="col-lg-3">
                {{Form::text('typing_th', NULL,array('class'=>'form-control','id'=>'typing_th','placeholder'=>'พิมพ์ได้'))}}
            </div>
            <div class="col-lg-3">
                {{Form::text('typing_th_wrong', NULL,array('class'=>'form-control','id'=>'typing_th_wrong','placeholder'=>'พิมพ์ผิด'))}}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    {{Form::label('typing_en', 'ภาษาอังกฤษ', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-9">
        <div class="row">
            <div class="col-lg-3">
                {{Form::text('typing_en', NULL,array('class'=>'form-control','id'=>'typing_en','placeholder'=>'พิมพ์ได้'))}}
            </div>
            <div class="col-lg-3">
                {{Form::text('typing_en_wrong', NULL,array('class'=>'form-control','id'=>'typing_en_wrong','placeholder'=>'พิมพ์ผิด'))}}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
    $('body').on('shown.bs.modal', '.modal', function () {
        $('#user_code').focus();
    });
    $('#user_code').keypress(function () {
        $.get("{{ url('get/found_user_code')}}",
                {option: $(this).val()},
        function (data) {
            var amphur = $('#amphur');
            amphur.empty();
            amphur.append("<option value=''>กรุณาเลือกอำเภอ</option>");
            $.each(data, function (index, element) {
                amphur.append("<option value='" + element.amphur_id + "'>" + element.amphur_name + "</option>");
            });
        });
    });
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "mis/testing/add",
            data: $('#form-add input:not(#btnSave)').serializeArray(),
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
                    window.location.href = base_url + index_page + "mis/testing";
                }
            }
        });
    });
</script>