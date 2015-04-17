{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('title', 'รุ่น/ยี่ห้อ', array('class' => 'col-sm-3 control-label req'))}}
    <div class="col-sm-8">
        {{Form::text('title', NULL,array('class'=>'form-control','id'=>'title','autofocus'))}}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnDialogSave'))}}    
    </div>
</div>
{{Form::hidden('group_id',\Input::get('group_id'))}}
{{ Form::close() }}
<script type="text/javascript">
    $('body').on('shown.bs.modal', '.modal', function () {
        $('#title').focus();
    });
    $('#btnDialogSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "mis/hsware/group/model/add",
            data: $('#form-add, select input:not(#btnSave)').serializeArray(),
            success: function (data) {
                if (data.error.status == false) {
                    $('#btnDialogSave').removeAttr('disabled');
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $.each(data.error.message, function (key, value) {
                        $('#' + key).parent().parent().addClass('has-error');
                        $('#' + key).after('<p class="help-block">' + value + '</p>');
                    });
                } else {
                    $('#myModal').modal('hide');
                    $('#myModal').on('hidden.bs.modal', function (e) {
                        $.get("{{ url('get/getmodel')}}",
                                {option: <?php echo \Input::get('group_id'); ?>},
                        function (data) {
                            var submodel = $('#model_id<?php echo \Input::get('group_id'); ?>');
                            submodel.empty();
                            submodel.append("<option value=''>กรุณาเลือกรายการ</option>");
                            $.each(data, function (index, element) {
                                submodel.append("<option value='" + element.id + "'>" + element.title + "</option>");
                            });
                        });
                    });
                }
            }
        });
    });
</script>