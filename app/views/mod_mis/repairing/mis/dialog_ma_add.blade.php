<form name="form-add" action="{{URL::to('mis/repairing/ma/add')}}" method="get" role="form" class="form-horizontal">
    <div class="form-group">
        {{Form::label('group_id', 'ประเภท MA', array('class' => 'col-sm-3 control-label'));}}
        <div class="col-sm-8">
            {{ \Form::select('group_id', $group,null, array('class' => 'form-control', 'id' => 'group_id')); }}
        </div>
    </div>
    <div class="form-group">
        {{Form::label('company_id', 'สินทรัพย์บริษัท', array('class' => 'col-sm-3 control-label'));}}
        <div class="col-sm-8">
            {{ \Form::select('company_id',\Company::lists('title', 'id'),null, array('class' => 'form-control', 'id' => 'company_id')); }}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            {{Form::submit('ถัดไป',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
        </div>
    </div>
</form>