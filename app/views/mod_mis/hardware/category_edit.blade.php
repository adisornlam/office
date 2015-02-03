{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('name', 'หัวข้อ', array('class' => 'col-sm-3 control-label req'))}}
    <div class="col-sm-6">
        {{Form::text('title', $item->title,array('class'=>'form-control','id'=>'title'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('description', 'คำอธิบาย', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-9">
        {{Form::text('description', $item->description,array('class'=>'form-control','id'=>'description'))}}
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
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "mis/backend/hardware/category/edit/{{$item->id}}",
            data: $('#form-add input:not(#btnSave)').serializeArray(),
            success: function (data) {
                if (data.error.status == false) {
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $.each(data.error.message, function (key, value) {
                        $('#' + key).parent().parent().addClass('has-error');
                        $('#' + key).after('<p class="help-block">' + value + '</p>');
                    });
                } else {
                    window.location.href = base_url + index_page + "mis/backend/hardware/category";
                }
            }
        });
    });
</script>