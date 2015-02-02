{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('name', 'หัวข้อ', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
        {{Form::text('name', NULL,array('class'=>'form-control','id'=>'name'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('description', 'คำอธิบาย', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-9">
        {{Form::text('description', NULL,array('class'=>'form-control','id'=>'description'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('level', 'ระดับ', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-3">
        {{Form::text('level', NULL,array('class'=>'form-control','id'=>'level'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('menu', 'สิทธิ์การเข้าถึง', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-offset-3 col-lg-10">
        @foreach($result_menu as $menu)
        <div class="checkbox">
            <label>
                {{Form::checkbox('menu_id[]', $menu->id)}} {{$menu->title}}
            </label>
        </div>
        @foreach(\Menu::where('sub_id', $menu->id)->orderBy('rank')->get() as $item)
        <label class="checkbox-inline col-lg-offset-1">
            {{Form::checkbox('menu_id[]', $item->id)}} {{$item->title}}
        </label>
        @endforeach
        @endforeach
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
        {{Form::button('บันทึกการเปลี่ยนแปลง',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
    $('#btnSave').click(function() {
        $.ajax({
            type: "post",
            url: base_url + index_page +"users/backend/roles/add",
            data: $('#form-add input:not(#btnSave)').serializeArray(),
            success: function(data) {
                if (data.error.status == false) {
                    $('form .form-group').removeClass('has-error');
                    $('form .help-block').remove();
                    $.each(data.error.message, function(key, value) {
                        $('#' + key).parent().parent().addClass('has-error');
                        $('#' + key).after('<p class="help-block">' + value + '</p>');
                    });
                } else {
                    window.location.href = base_url + index_page +"users/backend/roles";
                }
            }
        });
    });
</script>