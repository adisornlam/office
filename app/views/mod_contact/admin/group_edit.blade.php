{{HTML::style('assets/bootstrap-datepicker/css/datepicker3.css')}}

{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('type_id', 'บริษัท', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-6">
        {{ \Form::select('type_id', array('' => 'กรุณาเลือกประเภท') + $contact_type, $item->type_id, array('class' => 'form-control', 'id' => 'type_id')); }}
    </div>
</div>
<div class="form-group">
    {{Form::label('title', 'ชื่อบริษัท', array('class' => 'col-sm-3 control-label req'))}}
    <div class="col-sm-8">
        {{Form::text('title', $item->title,array('class'=>'form-control','id'=>'title'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('address', 'ที่อยู่', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
        {{Form::text('address', $item->address,array('class'=>'form-control','id'=>'address'))}}
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
    {{Form::label('email', 'อีเมล์', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
        {{Form::text('email', $item->email,array('class'=>'form-control','id'=>'email'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('remark', 'หมายเหตุ', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-8">
        {{Form::text('remark', $item->remark,array('class'=>'form-control','id'=>'remark'))}}
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
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'th'
    });
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "contact/group/edit/{{$item->id}}",
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
                    window.location.href = base_url + index_page + "contact/group";
                }
            }
        });
    });
</script>