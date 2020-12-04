@extends('layouts.main-closed')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>
	$(document).ready(function() {
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	});

	function scheduleIdStore(id_outlet){
		document.getElementById('id_outlet_schedule').value = id_outlet;
	}

	function centang(no){
		alert(no);
	}

	function checkUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = true;
		}
	}

	function uncheckUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = false;
		}
	}

	function viewLogDetail(url, status, request, response, ip, useragent){
		document.getElementById("log-url").value = url;
		document.getElementById("log-status").value = status;
		document.getElementById("log-request").innerHTML = request;
		document.getElementById("log-response").innerHTML = response;
		document.getElementById("log-ip").value = ip;
		document.getElementById("log-useragent").value = useragent;
	}
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
		</li>
	</ul>
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
	<div class="portlet light">
	<div class="portlet-body">
		<div class="tab-pane" id="profileupdate">
			<div class="row profile-account">
				<div class="col-md-3">
					<ul class="ver-inline-menu tabbable margin-bottom-10">
						<li class="active">
							<a data-toggle="tab" href="#tab_1-1">
								<i class="fa fa-cog"></i> Personal info </a>
							<span class="after"> </span>
						</li>
						<li>
							<a data-toggle="tab" href="#tab_2-2">
								<i class="fa fa-picture-o"></i> Change Photo </a>
						</li>
						<li>
							<a data-toggle="tab" href="#tab_3-3">
								<i class="fa fa-lock"></i> Change Password </a>
						</li>
					</ul>
				</div>
				<div class="col-md-9">
					<div class="tab-content">
						<div id="tab_1-1" class="tab-pane active">
							<form role="form" action="{{url('user/detail')}}/{{$profile['phone']}}" method="POST">
							{{ csrf_field() }}
								<div class="form-group">
									<label class="control-label">Name</label>

									<input type="text" name="name" placeholder="User Name (Required)" class="form-control" value="{{$profile['name']}}" />
								</div>
								<div class="form-group">
									<label class="control-label">Phone</label>
									<input type="hidden" name="phone" value="{{$profile['phone']}}" />
									<input type="text"  class="form-control" value="{{$profile['phone']}}" disabled />
								</div>
								<div class="form-group">
									<label class="control-label">Email</label>
									<input type="text" name="email" placeholder="Email (Required & Unique)" class="form-control" value="{{$profile['email']}}" />
								</div>
								<div class="form-group">
									<label class="control-label">City</label>
									<select name="id_city" class="form-control input-sm select2" placeholder="Search City">
										<option value="">Select...</option>
										@if(isset($city))
											@foreach($city as $row)
												<option value="{{$row['id_city']}}" @if(isset($profile['id_city'])) @if($row['id_city'] == $profile['id_city']) selected @endif @endif>{{$row['city_name']}}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Gender</label>
									<select name="gender" class="form-control input-sm select2">
										<option value="">Select...</option>
										<option value="Male" @if(isset($profile['gender'])) @if($profile['gender'] == 'Male') selected @endif @endif>Male</option>
										<option value="Female" @if(isset($profile['gender'])) @if($profile['gender'] == 'Female') selected @endif @endif>Female</option>
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Birthday</label>
									<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
										<input type="text" class="form-control form-filter input-sm date-picker" readonly name="birthday" placeholder="From"  value="{{date('d/m/Y', strtotime($profile['birthday']))}}">
										<span class="input-group-btn">
											<button class="btn btn-sm default" type="button">
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>
								</div>
								<div class="margiv-top-10">
									<button class="btn green"> Save Changes </button>
								</div>
							</form>
						</div>
						<div id="tab_2-2" class="tab-pane">
							<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" enctype="multipart/form-data" method="POST" >
							{{ csrf_field() }}
								<div class="form-group">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
											@if($profile['photo'] != "")
												<img src="{{$profile['photo']}}" alt="{{$profile['name']}}'s Photo" />
											@else
												<img src="{{env('S3_URL_VIEW') }}{{ ('images/default-avatar.png')}}" alt="{{$profile['name']}} Has no Photo" />
											@endif
										</div>

										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
										<div>
											<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file"  accept="image/*" name="photo"> </span>
											<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
										</div>
									</div>
								</div>
								<div class="margin-top-10">
									<button class="btn green"> Save Changes </button>
								</div>
							</form>
						</div>
						<div id="tab_3-3" class="tab-pane">
							<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" method="POST">
							{{ csrf_field() }}
								<div class="form-group">
									<label class="control-label">New Password</label>
									<input type="password" class="form-control" maxLength="6" name="password_new" /> </div>
								<div class="form-group">
									<label class="control-label">Re-type New Password</label>
									<input type="password" class="form-control" maxLength="6" name="password_new_confirmation" /> </div>
								<div class="margin-top-10">
									<button class="btn green"> Save Changes </button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!--end col-md-9-->
			</div>
		</div>
		</div>
		</div>
		<!--end tab-pane-->
	</div>
</div>
@endsection