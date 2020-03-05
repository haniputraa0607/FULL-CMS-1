@extends('layouts.main')
<?php
use App\Lib\MyHelper;
$configs    		= session('configs');
$grantedFeature     = session('granted_features');
?>
@section('page-style')

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .text-color-blue {

        }
        .text-color-red {

        }
    </style>
@endsection

@section('page-script')

    <!-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script>
    	$('#promo-code-checkbox').on('switchChange.bootstrapSwitch',function(){
	        var state=$(this).bootstrapSwitch('state');
	        if(state){
	            $('#promo-code-true').show();
	            $('#promo-code-false').hide();
	        }else{
	            $('#promo-code-true').hide();
	            $('#promo-code-false').show();
	        }
	    });
	    $('#voucher-online-checkbox').on('switchChange.bootstrapSwitch',function(){
	        var state=$(this).bootstrapSwitch('state');
	        if(state){
	            $('#voucher-online-true').show();
	            $('#voucher-online-false').hide();
	        }else{
	            $('#voucher-online-true').hide();
	            $('#voucher-online-false').show();
	        }
	    });
	    $('#voucher-offline-checkbox').on('switchChange.bootstrapSwitch',function(){
	        var state=$(this).bootstrapSwitch('state');
	        if(state){
	            $('#voucher-offline-true').show();
	            $('#voucher-offline-false').hide();
	        }else{
	            $('#voucher-offline-true').hide();
	            $('#voucher-offline-false').show();
	        }
	    });
	    $('#promo-code-checkbox').trigger('switchChange.bootstrapSwitch');
	    $('#voucher-online-checkbox').trigger('switchChange.bootstrapSwitch');
	    $('#voucher-offline-checkbox').trigger('switchChange.bootstrapSwitch');
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

    <div class="portlet light bordered">
    	<div class="portlet-title">
			<div class="caption font-blue ">
				<i class="icon-settings font-blue "></i>
				<span class="caption-subject bold uppercase">Promo Cashback Setting</span>
			</div>
		</div>
		<div class="portlet-body">
			<form role="form" class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
				<div class="form-body">
					<div class="form-group row">
						<label class="col-md-3 control-label text-left" style="text-align: left;">Promo Code
	                        <span class="required" aria-required="true"> * </span>
	                        <i class="fa fa-question-circle tooltips" data-original-title="Status fitur referral" data-container="body"></i>
	                    </label>
	                    <div class="col-md-9">
							<div class="form-group">
	                    		<span style="margin-right: 5px;">:</span>
	                            <input type="checkbox" id="promo-code-checkbox" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" data-off-text="Inactive" value="1" name="promo_code_cashback" @if(old('promo_code_cashback')=='1' || !empty($cashback['promo code get point'])) checked @endif>
	                            <span class="help-block" id="promo-code-true" style="margin-left: 12px;"> Customer <span class="text-success font-weight-bold">will get</span> cashback when making transactions using Promo Code </span>
	                            <span class="help-block" id="promo-code-false" style="margin-left: 12px;"> Customer <span class="text-danger font-weight-bold">will not get</span> cashback when making transactions using Promo Code </span>
	                        </div>
	                    </div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 control-label text-left" style="text-align: left;">Voucher Online
	                        <span class="required" aria-required="true"> * </span>
	                        <i class="fa fa-question-circle tooltips" data-original-title="Status fitur referral" data-container="body"></i>
	                    </label>
	                    <div class="col-md-9">
							<div class="form-group">
	                    		<span style="margin-right: 5px;">:</span>
	                            <input type="checkbox" id="voucher-online-checkbox" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" data-off-text="Inactive" value="1" name="voucher_online_cashback" @if(old('voucher_online_cashback')=='1' || !empty($cashback['voucher online get point'])) checked @endif>
	                            <span class="help-block" id="voucher-online-true" style="margin-left: 12px;"> Customer <span class="text-success font-weight-bold">will get</span> cashback when making transactions using Voucher Online </span>
	                            <span class="help-block" id="voucher-online-false" style="margin-left: 12px;"> Customer <span class="text-danger font-weight-bold">will not get</span> cashback when making transactions using Voucher Online </span>
	                        </div>
	                    </div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 control-label text-left" style="text-align: left;">Voucher Offline
	                        <span class="required" aria-required="true"> * </span>
	                        <i class="fa fa-question-circle tooltips" data-original-title="Status fitur referral" data-container="body"></i>
	                    </label>
	                    <div class="col-md-9">
							<div class="form-group">
	                    		<span style="margin-right: 5px;">:</span>
	                            <input type="checkbox" id="voucher-offline-checkbox" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" data-off-text="Inactive" value="1" name="voucher_offline_cashback" @if(old('voucher_offline_cashback')=='1' || !empty($cashback['voucher offline get point'])) checked @endif>
	                            <span class="help-block" id="voucher-offline-true" style="margin-left: 12px;"> Customer <span class="text-success font-weight-bold">will get</span> cashback when making transactions using Promo Code </span>
	                            <span class="help-block" id="voucher-offline-false" style="margin-left: 12px;"> Customer <span class="text-danger font-weight-bold">will not get</span> cashback when making transactions using Promo Code </span>
	                        </div>
	                    </div>
					</div>
					<input type="hidden" name="update" value="1">
					
				</div>
				<div class="form-actions" style="text-align:center">
					{{ csrf_field() }}
					<button type="submit" class="btn blue" id="checkBtn">Submit</button>
				</div>
			</form>
		</div>
    </div>
@endsection