<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs            = session('configs');
    $level              = session('level');

    (session('advert')) ? $advert = session('advert') : $advert = null;

 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        $('.timepicker').timepicker({
            minuteStep: 60,
            disableFocus: true,
            template: 'dropdown'
        });
        
        function processingNowNotification() {
            swal({
                    title: "Are you sure want to send <b>notification expiry point now</b> ?",
                    text: "Your will not be able to recover this data!",
                    type: "warning",
                    html : true,
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes!",
                    closeOnConfirm: false
                },
                function(){
                    var token  	= "{{ csrf_token() }}";
                    $.ajax({
                        type : "POST",
                        url : "{{ url('transaction/setting/expiry-point/processing-now') }}",
                        data : "_token="+token,
                        success : function(result) {
                            if (result.status == "success") {
                                swal("Success!", "Success sent notification expiry point.", "success")
                            }
                            else if(result.message !== null){
                                swal("Error!", result.message, "error")
                            }
                            else {
                                swal("Error!", "Something went wrong. Failed processing now send notification.", "error")
                            }
                        }
                    });
                }
            );
        }

        function processingNowAdjustment() {
            swal({
                    title: "Are you sure want to processing <b>adjustment point now</b> ?",
                    text: "Your will not be able to recover this data!",
                    type: "warning",
                    html : true,
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes!",
                    closeOnConfirm: false
                },
                function(){
                    var token  	= "{{ csrf_token() }}";
                    $.ajax({
                        type : "POST",
                        url : "{{ url('transaction/setting/adjustment-point/processing-now') }}",
                        data : "_token="+token,
                        success : function(result) {
                            if (result.status == "success") {
                                swal("Success!", "Success processing adjustment.", "success")
                            }
                            else if(result.message !== null){
                                swal("Error!", result.message, "error")
                            }
                            else {
                                swal("Error!", "Something went wrong. Failed processing now send notification.", "error")
                            }
                        }
                    });
                }
            );
        }
    </script>
@endsection

@section('content')
	<div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>
    
    @include('layouts.notifications')

    <div class="portlet light form-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-green"></i>
                <span class="caption-subject font-green bold uppercase">Setting Date & Time Expiry {{env('POINT_NAME', 'Points')}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" action="{{ url('transaction/setting/expiry-point') }}" method="post">
                {{ csrf_field() }}
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Send Notification Point
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="This value for setting date and time for send notification to user" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">date</span>
                                    <select class="form-control select2" name="notification_date" placeholder="Date" equired>
                                        <option></option>
                                        @for($i=1;$i<=31;$i++)
                                            <option value="{{$i}}" @if($result['date_send_notification_expiry_point']['date'] == $i) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">time</span>
                                    <input type="text" readonly style="background-color: white" class="form-control timepicker" name="notification_time" @if(!empty($result['date_send_notification_expiry_point']['time'])) value="{{date('h:i A', strtotime($result['date_send_notification_expiry_point']['time']))}}" @else value="{{date('h:i A', strtotime('00:00'))}}" @endif placeholder="Time" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a onclick="processingNowNotification()" class="btn yellow-lemon">Processing Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Adjustment Point
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="This value for setting date and time for adjustment point user" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">date</span>
                                    <select class="select2 form-control" name="adjustment_date" placeholder="Date" required>
                                        <option></option>
                                        @for($i=1;$i<=31;$i++)
                                            <option value="{{$i}}" @if($result['date_adjustment_point_user']['date'] == $i) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">time</span>
                                    <input type="text" readonly style="background-color: white" class="form-control timepicker" name="adjustment_time" placeholder="Time" @if(!empty($result['date_adjustment_point_user']['time'])) value="{{date('h:i A', strtotime($result['date_adjustment_point_user']['time']))}}" @else value="{{date('h:i A', strtotime('00:00'))}}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a onclick="processingNowAdjustment()" class="btn yellow-lemon">Processing Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-10">
                            <button type="submit" class="btn green">
                                <i class="fa fa-check"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
