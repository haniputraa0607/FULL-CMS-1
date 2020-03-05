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

@section('page-script')
	<script>
		$(".file").change(function(e) {
			var type      = $(this).data('type');
			var widthImg  = 0;
			var heightImg = 0;
			var _URL = window.URL || window.webkitURL;
			var image, file;

			if ((file = this.files[0])) {
				image = new Image();
				var size = file.size/1024;

				image.onload = function() {
					if (this.width !== this.height) {
						toastr.warning("Please check dimension of your photo. Recommended dimensions are 1:1");
						$("#removeImage").trigger( "click" );
					}
					if (this.width > 500 ||  this.height > 500) {
						toastr.warning("Please check dimension of your photo. The maximum height and width 100px.");
						$("#removeImage").trigger( "click" );
					}

					if (size > 10) {
						toastr.warning("The maximum size is 10 KB");
						$("#removeImage").trigger( "click" );
					}
				};
				image.src = _URL.createObjectURL(file);
			}
		});
	</script>
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
		<div class="row">
			<div class="col-md-6">
				Maintenance Mode Setting
			</div>
		</div>
	</h1>

	@include('layouts.notifications')
	<br>
	<div class="m-heading-1 border-green m-bordered">
		<p>This menu is used to active/inactive maintenance mode, set message to show, and set image.</p>
	</div>
	<br>
	<form role="form" class="form-horizontal" action="{{url('setting/maintenance-mode')}}" method="POST" enctype="multipart/form-data">
		<div class="form-body">
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-2 control-label">
						Status
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="active or inactive maintenance" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-4">
					<input type="checkbox" @if($status == 1) checked @endif class="make-switch" id="status" name="status" data-size="small" data-on-text="Active" data-off-text="Inactive">
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-2 control-label">
						Message
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="message to display in apps when maintenance mode active" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-4">
					<input class="form-control" type="text" name="message" value="{{$message}}" required>
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-2 control-label">
						Image
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="image to display in apps when maintenance mode active" data-container="body"></i>
						<span class="required" aria-required="true"> (500*500) <br> PNG Only <br> max size 10 KB</span>
					</label>
				</div>
				<div class="col-md-9">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
							<img src="{{$image}}" alt="">
						</div>
						<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100px; max-height: 100px;"> </div>
						<div>
						<div>
							<span class="btn default btn-file">
								<span class="fileinput-new"> Select image </span>
								<span class="fileinput-exists"> Change </span>
								<input type="file" accept="image/*" id="field_image" class="file" name="image">
							</span>
							<a href="javascript:;" id="removeImage" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-actions">
			{{ csrf_field() }}
			<div class="row col-md-12" style="text-align: center;margin-top: 3%;">
				<button type="submit" class="btn green">Submit</button>
			</div>
		</div>
	</form>
@endsection