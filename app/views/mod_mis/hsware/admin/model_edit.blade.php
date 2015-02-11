{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('group_id', 'กลุ่มอุปกรณ์', array('class' => 'col-sm-3 control-label req'));}}
    <div class="col-sm-5">
        {{ \Form::select('group_id',array('' => 'เลือกกลุ่ม') +  \HswareGroup::lists('title', 'id'), $item->group_id, array('class' => 'form-control', 'id' => 'group_id')); }}
    </div>
</div>
<div class="form-group">
    {{Form::label('title', 'ชื่อ', array('class' => 'col-sm-3 control-label req'))}}
    <div class="col-sm-8">
        {{Form::text('title', $item->title,array('class'=>'form-control','id'=>'title','autofocus'))}}
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
{{ Form::close() }}
<script type="text/javascript">
    $('body').on('shown.bs.modal', '.modal', function () {
        $('#group_id').focus();
    });
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "mis/hsware/group/model/edit/{{$item->id}}",
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
                    window.location.href = base_url + index_page + "mis/hsware/group/model";
                }
            }
        });
    });
</script>