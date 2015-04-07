@extends('layouts.master')
@section('style')
{{HTML::style('css/star-rating.min.css')}}
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
        <section class="panel">
            <header class="panel-heading">
                {{$title}}
            </header>
            <div class="panel-body">    
                <form class="form-horizontal tasi-form" method="get">
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">วันที่แจ้ง</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$item->created_at}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">ผู้แจ้งเรื่อง</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$user->firstname}} {{$user->lastname}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">ประเภทอุปกรณ์</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$group->title}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">รายละเอียด</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$item->desc}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">ผู้รับเรื่อง</label>
                        <div class="col-sm-9">
                            @if($item->receive_user!=0)
                            {{$receive_user->firstname}} {{$receive_user->lastname}}
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@if ($item->status>=2)
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                รายงานการให้บริการ
            </header>
            <div class="panel-body">
                <form class="form-horizontal tasi-form" method="get">
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">ใช้เวลาในการดำเนินการ</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                <?php
                                $created = \Carbon::createFromTimeStamp(strtotime($item->created_at));
                                $updated = \Carbon::createFromTimeStamp(strtotime($item->updated_at));
                                echo $updated->diffInHours($created);
                                ?> ชั่วโมง
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">รายละเอียด</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">{{$item->desc2}}</p>
                        </div>
                    </div>     
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">สถานะ</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">
                                @if($item->status_success==1)
                                ดำเนินการซ่อม / แก้ไข เรียบร้อย ใช้งานได้ตามปกติ
                                @elseif ($item->status_success==2)
                                ดำเนินการซ่อมตามสถานที่ที่แจ้ง
                                @elseif ($item->status_success==3)
                                ส่งซ่อมภายนอก
                                @if($item->status_radio==1)
                                ไม่มีค่าใช้จ่าย อยู่ในรับประกัน
                                @elseif ($item->status_radio==2)
                                มีค่าใช้จ่าย จำนวน {{$item->cost}} บาท
                                @else

                                @endif
                                @elseif ($item->status_success==4)
                                ไม่สามารถซ่อมได้ / ใช้งานได้ เนื่องจาก {{$item->remark}}
                                @else

                                @endif
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                ให้คะแนนความพึงพอใจในการให้บริการ
            </header>
            <div class="panel-body">
                <input id="input-id" type="number" class="rating" min=0 max=5 step=1 data-size="lg" >
            </div>
        </section>
    </div>
</div>
@endif
@stop

@section('script')
{{HTML::script('js/star-rating.min.js')}}
@stop

@section('script_code')
<script type="text/javascript">
    $('#input-id').rating('refresh', {disabled: false, showClear: false, showCaption: true});
    $('#input-id').on('rating.change', function (event, value, caption) {
        $.ajax({
            type: "post",
            url: base_url + index_page + "mis/repairing/update/rating/<?php echo \Request::segment(4); ?>",
            data: {val: value},
            success: function (data) {
                if (data.error.status == true) {
                    window.location.href = window.location.href;
                }
            }
        });
    });
<?php if ($item->rating > 0) { ?>
        $('#input-id').rating('update', <?php echo $item->rating; ?>);
        $('#input-id').rating('create', {disabled: true, showClear: false});
<?php } ?>
</script>
@stop