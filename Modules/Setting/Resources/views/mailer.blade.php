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
		<p>This menu is used to set the SMTP configuration used for sending email.</p>
	</div>
	<br>
	<form role="form" class="form-horizontal" action="{{url('setting/mailer')}}" method="POST" enctype="multipart/form-data">
		<div class="form-body">
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label">
						Mail Host
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Email server smtp host" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input class="form-control" type="text" name="value[mailer_smtp_host]" value="{{$data['mailer_smtp_host']??''}}" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-body">
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label">
						Port
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Email server smtp port" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<input class="form-control" type="number" name="value[mailer_smtp_port]" value="{{$data['mailer_smtp_port']??''}}" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-body">
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label">
						Encryption
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Email server smtp encryption" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<input class="form-control" type="text" name="value[mailer_smtp_encryption]" value="{{$data['mailer_smtp_encryption']??''}}" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-body">
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label">
						Username
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="SMTP username" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input class="form-control" type="text" name="value[mailer_smtp_username]" value="{{$data['mailer_smtp_username']??''}}" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-body">
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label">
						Password
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="SMTP password" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input class="form-control" type="password" name="value[mailer_smtp_password]" value="{{$data['mailer_smtp_password']??''}}" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-actions">
			{{ csrf_field() }}
			<div class="row col-md-12" style="text-align: center;margin-top: 3%;">
				<button type="submit" class="btn green">Save</button>
			</div>
		</div>
	</form>
@endsection