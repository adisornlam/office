{{Form::open(array('name'=>'form-add','id'=>'form-add','role'=>'form','class'=>'form-horizontal'))}}
<div class="form-group">
    {{Form::label('name', 'หัวข้อ', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-6">
        {{Form::text('name', $item->name,array('class'=>'form-control','id'=>'name'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('description', 'คำอธิบาย', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-9">
        {{Form::text('description', $item->description,array('class'=>'form-control','id'=>'description'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('level', 'ระดับ', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-3">
        {{Form::text('level', $item->level,array('class'=>'form-control','id'=>'level'))}}
    </div>
</div>
<div class="form-group">
    {{Form::label('menu', 'สิทธิ์การเข้าถึง', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-offset-3 col-lg-10">
        @foreach($result_menu as $menu)
        <div class="checkbox">
            <label>
                {{Form::checkbox('menu_id[]', $menu->id,(in_array($menu->id,$result_menurole)?TRUE:FALSE))}} {{$menu->title}}
            </label>
        </div>
        @foreach(\Menu::where('sub_id', $menu->id)->orderBy('rank')->get() as $menu2)
        <label class="checkbox-inline col-lg-offset-1">
            {{Form::checkbox('menu_id[]', $menu2->id,(in_array($menu2->id,$result_menurole)?TRUE:FALSE))}} {{$menu2->title}}
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
{{Form::hidden('id',$item->id)}}
{{ Form::close() }}
<script type="text/javascript">
    $('#btnSave').click(function () {
        $.ajax({
            type: "post",
            url: base_url + index_page + "users/roles/edit/{{\Request::segment(5)}}",
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
                    window.location.href = base_url + index_page + "users/roles";
                }
            }
        });
    });
</script>