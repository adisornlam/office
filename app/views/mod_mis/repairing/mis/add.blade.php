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
        {{Form::text('title', NULL,array('class'=>'form-control','id'=>'title','placeholder'=>'หัวข้อแจ้งซ่อม'))}}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        {{Form::textarea('desc', NULL,array('class'=>'form-control','id'=>'address','placeholder'=>'รายละเอียดการแจ้งซ่อม'))}}
    </div>    
</div>
<span class="label label-danger">หมายเหตุ</span>
<span>การแจ้งซ่อมเครื่องคอมพิวเตอร์ จะดำเนินการออกให้เมื่อไม่สามารถ แก้ไขปัญหาได้ภายในระยะเวลาที่กำหนด ซึ่งทาง MIS จะทำการออกใบแจ้งซ่อมให้ผู้แจ้งซ่อมไว้ให้กรณีทวงถาม</span>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
    $('body').on('shown.bs.modal', '.modal', function () {
        $('#title').focus();
    });
    $('#btnSave').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: "post",
            url: base_url + index_page + "mis/repairing/view/save",
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
                    window.location.href = base_url + index_page + "mis/repairing";
                }
            }
        });
    });
</script>