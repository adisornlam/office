{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('title', 'ชื่อเมนู', array('class' => 'col-sm-3 control-label req'))}}
    <div class="col-sm-8">
        {{Form::text('title', $item->title,array('class'=>'form-control','id'=>'title'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('url', 'URL', array('class' => 'col-sm-3 control-label req'))}}
    <div class="col-sm-6">
        {{Form::text('url', $item->url,array('class'=>'form-control','id'=>'url'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('module', 'Module', array('class' => 'col-sm-3 control-label req'))}}
    <div class="col-sm-4">
        {{Form::text('module', $item->module,array('class'=>'form-control','id'=>'module'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('rank', 'ลำดับ', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-2">
        {{Form::text('rank', $item->rank,array('class'=>'form-control','id'=>'rank'))}}
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
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "setting/backend/menu/edit/{{$item->id}}",
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
                    window.location.href = base_url + index_page + "setting/backend/menu/{{($sub_id>0?'sub/'.$sub_id:'')}}";
                }
            }
        });
    });
</script>