{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    <div class="col-sm-12">
        {{Form::textarea('diagnose', $item->diagnose,array('class'=>'form-control','id'=>'title','placeholder'=>'วินิจฉัย'))}}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        {{Form::textarea('solve', $item->solve,array('class'=>'form-control','id'=>'solve','placeholder'=>'การแก้ปัญหา'))}}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
    $('body').on('shown.bs.modal', '.modal', function () {
        $('#diagnose').focus();
    });
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "oilservice/analysis/edit/{{$item->id}}",
            data: $('#form-add, textarea input:not(#btnSave)').serializeArray(),
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
                    window.location.href = base_url + index_page + "oilservice/analysis";
                }
            }
        });
    });
</script>