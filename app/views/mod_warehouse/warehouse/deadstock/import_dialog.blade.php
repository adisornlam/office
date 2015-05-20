{{HTML::style('assets/bootstrap-datepicker/css/datepicker3.css')}}
{{Form::open(array('name'=>'form-add','id'=>'form-add','method' => 'POST','role'=>'form','class'=>'form-horizontal','files'=>true))}}
<div class="form-group">
    {{Form::label('import_date', 'วันที่นำเข้าข้อมูล', array('class' => 'col-sm-3 control-label'))}}
    <div class="col-sm-4">
        <div class="input-group date form_datetime-component">
            {{Form::text('import_date', NULL,array('class'=>'form-control datepicker','id'=>'import_date'))}}
            <span class="input-group-btn">
                <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    {{Form::label('company_id', 'เลือกไฟล์อัพโหลด', array('class' => 'col-sm-3 control-label'));}}
    <div class="col-sm-8">
        <input type="file" class="default" name="deadstock_file" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        {{Form::button('นำเข้าข้อมูล',array('class'=>'btn btn-primary btn-lg','id'=>'btnDialogSave'))}}    
    </div>
</div>
{{Form::close()}}
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
{{HTML::script('js/jquery.form.min.js')}}
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'th'
    });
    $(function () {
        var options = {
            url: base_url + index_page + "warehouse/deadstock/import_dialog",
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
            window.location.href = base_url + index_page + "warehouse/deadstock/import_temp";
        }
    }
</script>