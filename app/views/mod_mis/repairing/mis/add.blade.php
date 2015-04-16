{{HTML::style('assets/bootstrap-datepicker/css/datepicker3.css')}}
{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('group_id', 'อุปกรณ์แจ้งซ่อม', array('class' => 'col-sm-3 control-label req'))}}
    <div class="col-sm-9">
        @foreach(\DB::table('repairing_group')->get() as $item_group)
        <label class="radio-inline">
            <input type="radio" name="group_id" value="{{$item_group->id}}"> {{$item_group->title}}
        </label>
        @endforeach        
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        {{Form::textarea('desc', NULL,array('class'=>'form-control','id'=>'desc','placeholder'=>'รายละเอียดการแจ้งซ่อม'))}}
    </div>    
</div>
<div class="form-group">
    {{Form::label('company_id', 'บริษัท', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-7">
        {{ \Form::select('company_id', array('' => 'กรุณาเลือกบริษัท') + \Company::lists('title', 'id'), null, array('class' => 'form-control', 'id' => 'company_id')); }}
    </div>
</div>
<div class="form-group">
    {{Form::label('department_id', 'ฝ่าย/แผนก', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-7">
        {{ \Form::select('department_id', array('' =>'กรุณาเลือกฝ่าย/แผนก'), null, array('class' => 'form-control', 'id' => 'department_id'));}}
    </div>
</div>
<div class="form-group">
    {{Form::label('user_id', 'ผู้แจ้งซ่อม', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-7">
        {{ \Form::select('user_id', array('' =>'กรุณาเลือกผู้แจ้งซ่อม'), null, array('class' => 'form-control', 'id' => 'user_id'));}}
    </div>
</div>
<div class="form-group">
    {{Form::label('created_at', 'วันที่แจ้งซ่อม', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-4">
        <div class="input-group date form_datetime-component">
            {{Form::text('created_at', date('Y-m-d'),array('class'=>'form-control datepicker','id'=>'created_at','placeholder'=>'วันที่แจ้งซ่อม'))}}
            <span class="input-group-btn">
                <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
    </div>
</div>
{{ Form::close() }}

{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'th'
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
                $.get("{{ url('get/userddl')}}",
                        {option: $(this).val()},
                function (data) {
                    var user = $('#user_id');
                    user.empty();
                    user.append("<option value=''>กรุณาเลือกผู้ใช้งาน</option>");
                    $.each(data, function (index, element) {
                        user.append("<option value='" + element.id + "'>" + element.title + "</option>");
                    });
                });
            });

        });
    });

    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "mis/repairing/add",
            data: $('#form-add, textarea input:not(#btnSave)').serializeArray(),
            success: function (data) {
                if (data.error.status == false) {
                    $('#btnSave').removeAttr('disabled');
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $.each(data.error.message, function (key, value) {
                        $('#' + key).parent().addClass('has-error');
                        $('#' + key).after('<p class="help-block">' + value + '</p>');
                    });
                } else {
                    window.location.href = base_url + index_page + "mis/repairing/view/" + data.error.repairing_id;
                }
            }
        });
    });
</script>