{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('name', 'ชื่อบริษัท', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
        {{Form::text('title', $item->title,array('class'=>'form-control','id'=>'title'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('company_code', 'รหัสบริษัท', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-3">
        {{Form::text('company_code', $item->company_code,array('class'=>'form-control','id'=>'company_code'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('address1', 'ที่อยู่ 1', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-8">
        {{Form::text('address1', $item->address1,array('class'=>'form-control','id'=>'address1'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('address2', 'ที่อยู่ 2', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-8">
        {{Form::text('address2', $item->address2,array('class'=>'form-control','id'=>'address2'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('province', 'จังหวัด', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-5">
        {{ \Form::select('province', array('' => 'กรุณาเลือกจังหวัด') + DB::table('province')
                                ->orderBy('province_name', 'asc')
                                ->lists('province_name', 'province_id'), $item->province, array('class' => 'form-control', 'id' => 'province')); }}
    </div>
</div>
<div class="form-group">
    {{Form::label('amphur', 'อำเภอ', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-5">
        {{ \Form::select('amphur', array('' =>'กรุณาเลือกอำเภอ'), $item->amphur, array('class' => 'form-control', 'id' => 'amphur'));}}
    </div>
</div>
<div class="form-group">
    {{Form::label('district', 'ตำบล', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-5">
        {{ \Form::select('district', array('' =>'กรุณาเลือกตำบล'), $item->district, array('class' => 'form-control', 'id' => 'district'));}}
    </div>
</div>
<div class="form-group">
    {{Form::label('zipcode', 'รหัสไปรษณีย์', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-5">
        {{ \Form::select('zipcode', array('' => 'กรุณาเลือกรหัสไปรษณีย์'), $item->zipcode, array('class' => 'form-control', 'id' => 'zipcode'));}}
    </div>
</div>
<div class="form-group">
    {{Form::label('email', 'อีเมล์', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
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
    {{Form::label('fax', 'แฟกซ์', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-4">
        {{Form::text('fax', $item->fax,array('class'=>'form-control','id'=>'fax'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('disabled', '&nbsp;', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-3">
        {{Form::checkbox('disabled', 1,($item->disabled==0?TRUE:FALSE))}} เปิดใช้งาน
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
    </div>
</div>
{{Form::hidden('id',$item->id)}}
{{ Form::close() }}
<script type="text/javascript">
    $(function () {
        var edit_province = <?php echo ($item->province > 0 ? $item->province : 0); ?>;
        var edit_amphur = <?php echo ($item->amphur > 0 ? $item->amphur : 0); ?>;
        var edit_district = <?php echo ($item->district > 0 ? $item->district : 0); ?>;
        if ($('#province').val()) {
            $.get("{{ url('get/amphur')}}",
                    {option: edit_province},
            function (data) {
                var amphur = $('#amphur');
                amphur.empty();
                $.each(data, function (index, element) {
                    var amphur_select = (element.amphur_id === '' + edit_amphur + '' ? "selected" : "");
                    amphur.append("<option value='" + element.amphur_id + "' " + amphur_select + ">" + element.amphur_name + "</option>");
                });
            });

            $.get("{{ url('get/district')}}",
                    {option: edit_amphur},
            function (data) {
                var district = $('#district');
                district.empty();
                $.each(data, function (index, element) {
                    var district_select = (element.district_id === '' + edit_district + '' ? "selected" : "");
                    district.append("<option value='" + element.district_id + "' " + district_select + ">" + element.district_name + "</option>");
                });
            });
        }
    });
    $('#btnSave').click(function () {
        $.ajax({
            type: "post",
            url: base_url + index_page + "users/company/edit/<?php echo $item->id; ?>",
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