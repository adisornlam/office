@extends('layouts.master')

@section('style')

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
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">
                    <div class="btn-group">
                        <a href="javascript:;" rel="warehouse/deadstock/import_dialog" class="btn btn-primary link_dialog" title="นำเข้าข้อมูล" role="button"><i class="fa fa-cloud-upload"></i> นำเข้าข้อมูล</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{Form::open(array('name'=>'form-search','id'=>'form-search','method' => 'POST','role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="pull-left">      
                    {{ \Form::select('type_id', array(''=>'Type')+\DB::table('warehouse_type')->select(array('code_no as id',\DB::raw('CONCAT("(",code_no,") ",title) as title')))->lists('title','id'),null, array('class' => 'form-control', 'id' => 'type_id')); }}
                    {{ \Form::select('brand_id', array(''=>'Brand')+\DB::table('warehouse_brand')->select(array('code_no as id',\DB::raw('CONCAT("(",code_no,") ",title) as title')))->lists('title','id'), null, array('class' => 'form-control', 'id' => 'brand_id')); }}
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{$title}}
            </header>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Unit</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@stop

@section('script')

@stop

@section('script_code')
<script type="text/javascript">

</script>
@stop