{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal','files'=>true))}}
<div class="form-group">
    {{Form::label('deadstock_photo', 'รูปภาพที่ 1', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-8">
        <input type="file" class="default" name="deadstock_photo1" id="deadstock_photo1" />
    </div>
</div>
<div class="form-group">
    {{Form::label('deadstock_photo', 'รูปภาพที่ 2', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-8">
        <input type="file" class="default" name="deadstock_photo2" id="deadstock_photo2" />
    </div>
</div>
<div class="form-group">
    {{Form::label('deadstock_photo', 'รูปภาพที่ 3', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-8">
        <input type="file" class="default" name="deadstock_photo3" id="deadstock_photo3" />
    </div>
</div>
<div class="form-group">
    {{Form::label('deadstock_photo', 'รูปภาพที่ 4', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-8">
        <input type="file" class="default" name="deadstock_photo4" id="deadstock_photo4" />
    </div>
</div>
<div class="form-group">
    {{Form::label('deadstock_photo', 'รูปภาพที่ 5', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-8">
        <input type="file" class="default" name="deadstock_photo5" id="deadstock_photo5" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnDialogSave'))}}    
    </div>
</div>
{{Form::close()}}
{{HTML::script('js/jquery.form.min.js')}}
<script type="text/javascript">
    $(function () {
        var options = {
            url: base_url + index_page + "warehouse/deadstock/upload/photo/{{$id}}",
            success: showResponse
        };
        $('#btnDialogSave').click(function () {
            $('#btnDialogSave').attr('disabled', 'disabled');
            $('#form-add').ajaxSubmit(options);
            var data = {
                title: 'Loading',
                type: 'alert',
                text: '<div class="text-center"><p><i class="fa fa-spinner fa-spin fa-2x"></i></p></div>'
            };
            genModal(data);
        });
    });

    function showResponse(response, statusText, xhr, $form) {
        if (response.error.status === false) {

        } else {
            window.location.href = base_url + index_page + "warehouse/deadstock";
        }
    }
</script>