<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{url('/')}}">Home</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				{{$title}}
			</li>
		</ul>
	</div>
	<br>

	<h1 class="page-title">
		{{$title}}
	</h1>

	@include('layouts.notifications')
	<br>
	<div class="m-heading-1 border-green m-bordered">
		<p>This menu is used to setting time expired for OTP and Email verify.</p>
	</div>
	<br>
	<form role="form" class="form-horizontal" action="{{url('setting/time-expired')}}" method="POST" enctype="multipart/form-data">
		<div class="form-body">
			@if(MyHelper::hasAccess([256], $grantedFeature) && isset($result['expired_otp']))
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-3 control-label">
						Time Expired OTP
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="time expired after user request OTP. Time in minute" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-3">
					<div class="input-group">
						<input class="form-control" type="text" name="expired_otp" value="{{$result['expired_otp']}}" required>
						<span class="input-group-addon">minute</span>
					</div>
				</div>
			</div>
			@endif
			@if(MyHelper::hasAccess([257], $grantedFeature) && isset($result['expired_time_email']))
				<div class="form-group">
					<div class="input-icon right">
						<label class="col-md-3 control-label">
							Time Expired Email
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="time expired after user request verify email. Time in minute" data-container="body"></i>
						</label>
					</div>
					<div class="col-md-3">
						<div class="input-group">
							<input class="form-control" type="text" name="expired_time_email" value="{{$result['expired_time_email']}}" required>
							<span class="input-group-addon">minute</span>
						</div>
					</div>
				</div>
			@endif
		</div>

		<div class="form-actions">
			{{ csrf_field() }}
			<div class="row col-md-12" style="text-align: center;margin-top: 3%;">
				<button type="submit" class="btn green">Submit</button>
			</div>
		</div>
	</form>
@endsection