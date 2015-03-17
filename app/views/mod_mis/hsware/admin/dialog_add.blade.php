<form name="form-add" action="{{URL::to('mis/hsware/add')}}" method="get" role="form" class="form-horizontal">
    <div class="form-group">
        {{Form::label('group_id', 'กลุ่มอุปกรณ์', array('class' => 'col-sm-3 control-label'));}}
        <div class="col-sm-5">
            {{ \Form::select('group_id', $group, (isset($_COOKIE['hsware_group_id'])?$_COOKIE['hsware_group_id']:null), array('class' => 'form-control', 'id' => 'group_id')); }}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            {{Form::submit('ถัดไป',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
        </div>
    </div>
    {{ (\Input::has('spare')?Form::hidden('spare',1):null)}}
</form>