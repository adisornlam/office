@extends('backend.layouts.master')
@section('style')
{{HTML::style('assets/bootstrap-datepicker/css/datepicker3.css')}}
{{HTML::style('assets/fancybox/source/jquery.fancybox.css')}}
{{HTML::style('css/gallery.css')}}
@stop
@section('content')
@if(isset($breadcrumbs))
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            @foreach ($breadcrumbs as $key => $val)
            @if ($val === reset($breadcrumbs))
            <li><a href="{{URL::to($val)}}"><i class="fa fa-home"></i> {{$key}}</a></li>
            @elseif ($val === end($breadcrumbs))
            <li class="active">{{$key}}</li>
            @else
            <li><a href="{{URL::to($val)}}"> {{$key}}</a></li>
            @endif
            @endforeach
        </ul>
    </div>
</div>
@endif
<form class="form-horizontal tasi-form" method="get">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading tab-bg-dark-navy-blue tab-right ">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#info">
                                <i class="fa fa-info"></i>
                                ข้อมูลทั่วไป
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#option1">
                                <i class="fa fa-list"></i>
                                คุณสมบัติ
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#gallery">
                                <i class="fa fa-picture-o"></i>
                                รูปภาพอุปกรณ์
                            </a>
                        </li>
                    </ul>
                    <span class="hidden-sm wht-color">{{$title}}</span>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="info" class="tab-pane active">
                            <div class="panel-body">
                                <div class="form-group">
                                    {{Form::label('group_id', 'กลุ่มอุปกรณ์', array('class' => 'col-sm-2 control-label'));}}
                                    <div class="col-sm-10">
                                        <p class="form-control-static"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('company_id', 'สินทรัพย์บริษัท', array('class' => 'col-sm-2 control-label'));}}
                                    <div class="col-sm-10">
                                        <p class="form-control-static"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('hsware_code', 'เลขระเบียน', array('class' => 'col-sm-2 control-label'))}}
                                    <div class="col-sm-10">                                    
                                        <p class="form-control-static">{{$item->hsware_code}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('access_no', 'ACC NO', array('class' => 'col-sm-2 control-label'))}}
                                    <div class="col-sm-10">                                    
                                        <p class="form-control-static">{{$item->access_no}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('serial_no', 'Serial Number', array('class' => 'col-sm-2 control-label'))}}
                                    <div class="col-sm-10">                                    
                                        <p class="form-control-static">{{$item->serial_no}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('title', 'ชื่ออุปกรณ์', array('class' => 'col-sm-2 control-label req'))}}
                                    <div class="col-sm-5">                                    
                                        <p class="form-control-static">{{$item->title}}</p>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    {{Form::label('desc', 'คำอธิบาย', array('class' => 'col-sm-2 control-label'))}}
                                    <div class="col-sm-5">                                    
                                        {{$item->desc}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('warranty_date', 'วันหมดประกัน', array('class' => 'col-sm-2 control-label'))}}
                                    <div class="col-sm-2">
                                        <p class="form-control-static">{{$item->warranty_date}}</p>                                                                   
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('register_date', 'วันที่ลงทะเบียน', array('class' => 'col-sm-2 control-label'))}}
                                    <div class="col-sm-2">
                                        <p class="form-control-static">{{$item->register_date}}</p>
                                    </div>
                                </div>                            
                                <div class="form-group">
                                    {{Form::label('disabled', '&nbsp;', array('class' => 'col-sm-2 control-label'))}}
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{$item->disabled}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="option1" class="tab-pane">
                            <div class="panel-body">
                                @foreach($option as $item_option)
                                <div class="form-group">
                                    {{Form::label(null, $item_option->title, array('class' => 'col-sm-2 control-label'))}}
                                    <div class="col-sm-2">
                                        <?php
                                        if ($item_option->option_id != 0) {
                                            $val = $item_option->{$item_option->name};
                                            $v = \HswareSpecOptionItem::find($val)->title;
                                        } else {
                                            $v = $item_option->{$item_option->name};
                                        }
                                        ?>
                                        <p class="form-control-static">{{$v}}</p>                                                                   
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="gallery" class="tab-pane">
                            <div class="panel-body">
                                <ul class="grid cs-style-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                    <?php
                                    $name = 'photo' . $i;
                                    ?>
                                    @if($item->{$name})
                                    <li>
                                        <figure>
                                            {{($item->{$name}?HTML::image($item->{$name}):'')}}
                                            <figcaption>
                                                <h3>&nbsp;</h3>
                                                {{link_to($item->{$name},'ดูรูปใหญ่',array('class'=>'fancybox','rel'=>'group'))}}
                                            </figcaption>
                                        </figure>
                                    </li>
                                    @endif
                                    @endfor
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>
@stop

@section('script')
{{HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js')}}
{{HTML::script('js/jquery.form.min.js')}}

{{HTML::script('assets/fancybox/source/jquery.fancybox.js')}}
{{HTML::script('js/modernizr.custom.js')}}
{{HTML::script('js/toucheffects.js')}}

@stop

@section('script_code')
<script type="text/javascript">
    $(function () {
        //    fancybox
        jQuery(".fancybox").fancybox();
    });
</script>
@stop