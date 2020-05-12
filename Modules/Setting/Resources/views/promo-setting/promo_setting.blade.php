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
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')

    <!-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script>
    	$(".file-image").change(function(e) {
			var widthImg  = 100;
			var heightImg = 100;

			var _URL = window.URL || window.webkitURL;
			var image, file;

			if ((file = this.files[0])) {
				image = new Image();

				image.onload = function() {
					if ( this.width == widthImg && this.height == heightImg ) {
						// image.src = _URL.createObjectURL(file);
					}
					else {
						toastr.warning("Please check dimension of your image.");
						$(this).val("");
						// $('#remove_square').click()
						// image.src = _URL.createObjectURL();

						$('#field_image').val("");
						$('#div_image').children('img').attr('src', 'https://www.placehold.it/100x100/EFEFEF/AAAAAA&amp;text=no+image');

						console.log($(this).val())
						// console.log(document.getElementsByName('news_image_luar'))
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
				<span class="caption-subject bold uppercase">Warning Image</span>
			</div>
		</div>
		<div class="portlet-body">
			<form role="form" class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
				<div class="form-body">
					<div class="form-group col-md-12">
						<label class="control-label col-md-4">Image
							<br>
							<span class="required" aria-required="true"> (100*100) </span>
						</label><br>
						<div class="fileinput fileinput-new col-md-4" data-provides="fileinput">
							<div class="fileinput-new thumbnail">
								@if(isset($warning_image))
									<img src="{{ env('S3_URL_VIEW').$warning_image}}" alt="">
								@else
									<img src="https://www.placehold.it/100x100/EFEFEF/AAAAAA&amp;text=no+image" alt="">
								@endif
							</div>
							<div class="fileinput-preview fileinput-exists thumbnail" id="div_image" style="max-width: 500px; max-height: 250px;"></div>
							<div>
								<span class="btn default btn-file">
								<span class="fileinput-new"> Select image </span>
								<span class="fileinput-exists"> Change </span>
								<input type="file" class="file file-image" id="field_image" accept="image/*" name="promo_warning_image">
								</span>
								<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions" style="text-align:center">
					{{ csrf_field() }}
					<button type="submit" class="btn blue" id="checkBtn">Submit</button>
				</div>
			</form>
		</div>
    </div>
@endsection