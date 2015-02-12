<form name="form-add" action="{{URL::to('mis/computer/add')}}" method="get" role="form" class="form-horizontal">
    <div class="form-group">
        {{Form::label('company_id', 'บริษัท', array('class' => 'col-sm-3 control-label'));}}
        <div class="col-sm-5">
            {{ \Form::select('company_id', $company, null, array('class' => 'form-control', 'id' => 'company_id')); }}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            {{Form::submit('ถัดไป',array('class'=>'btn btn-primary btn-lg','id'=>'btnSave'))}}    
        </div>
    </div>
</form>