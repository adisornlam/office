{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('name', 'ชื่อบริษัท', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
        {{Form::text('title', NULL,array('class'=>'form-control','id'=>'title'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('company_code', 'รหัสบริษัท', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-3">
        {{Form::text('company_code', NULL,array('class'=>'form-control','id'=>'company_code'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('address1', 'ที่อยู่ 1', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-8">
        {{Form::text('address1', NULL,array('class'=>'form-control','id'=>'address1'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('address2', 'ที่อยู่ 2', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-8">
        {{Form::text('address2', NULL,array('class'=>'form-control','id'=>'address2'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('province', 'จังหวัด', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-5">
        {{ \Form::select('province', array('' => 'กรุณาเลือกจังหวัด') + DB::table('province')
                                ->orderBy('province_name', 'asc')
                                ->lists('province_name', 'province_id'), null, array('class' => 'form-control', 'id' => 'province')); }}
    </div>
</div>
<div class="form-group">
    {{Form::label('amphur', 'อำเภอ', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-5">
        {{ \Form::select('amphur', array('' =>'กรุณาเลือกอำเภอ'), null, array('class' => 'form-control', 'id' => 'amphur'));}}
    </div>
</div>
<div class="form-group">
    {{Form::label('district', 'ตำบล', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-5">
        {{ \Form::select('district', array('' =>'กรุณาเลือกตำบล'), null, array('class' => 'form-control', 'id' => 'district'));}}
    </div>
</div>
<div class="form-group">
    {{Form::label('zipcode', 'รหัสไปรษณีย์', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-5">
        {{ \Form::select('zipcode', array('' => 'กรุณาเลือกรหัสไปรษณีย์'), null, array('class' => 'form-control', 'id' => 'zipcode'));}}
    </div>
</div>
<div class="form-group">
    {{Form::label('email', 'อีเมล์', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
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
    {{Form::label('fax', 'แฟกซ์', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-4">
        {{Form::text('fax', NULL,array('class'=>'form-control','id'=>'fax'))}}
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
        $.ajax({
            type: "post",
            url: base_url + index_page + "users/company/add",
            data: $('#form-add, select input:not(#btnSave)').serializeArray(),
            success: function (data) {
                if (data.error.status == false) {
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $.each(data.error.message, function (key, value) {
                        $('#' + key).parent().parent().addClass('has-error');
                        $('#' + key).after('<p class="help-block">' + value + '</p>');
                    });
                } else {
                    window.location.href = base_url + index_page + "users/company";
                }
            }
        });
    });
    $('#province').change(function () {
        $.get("{{ url('get/amphur')}}",
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

    $('#amphur').change(function () {
        $.get("{{ url('get/district')}}",
                {option: $(this).val()},
        function (data) {
            var district = $('#district');
            district.empty();
            district.append("<option value=''>กรุณาเลือกตำบล</option>");
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
            zipcode.append("<option value=''>กรุณาเลือกรหัสไปรษณีย์</option>");
            $.each(data, function (index, element) {
                zipcode.append("<option value='" + element.post_code + "'>" + element.post_code + "</option>");
            });
        });
    });
</script>