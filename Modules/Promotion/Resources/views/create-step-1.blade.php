<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
 @extends('layouts.main-closed')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>

	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery.input-ip-address-control-1.0.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-input-mask.min.js') }}" type="text/javascript"></script>
	<script>
	$('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one Campaign Media.");
        return false;
      }

    });

	function showform(type){
		if(type == 'instant'){
			document.getElementById('scheduled_date').style.display = 'none';
			document.getElementById('scheduled_time').style.display = 'none';
			document.getElementById('recurring').style.display = 'none';
			document.getElementById('recurring-periode').style.display = 'none';
			document.getElementById('date-periode').style.display = 'none';
			document.getElementById('series').style.display = 'none';
			document.getElementById('mask_number').value = 0;

			document.getElementById('recurring_date_month').style.display = 'none';
			document.getElementById('recurring_day_week').style.display = 'none';
			document.getElementById('recurring_week_month').style.display = 'none';
		}
		if(type == 'scheduled'){
			document.getElementById('scheduled_date').style.display = 'block';
			document.getElementById('scheduled_time').style.display = 'block';
			document.getElementById('recurring').style.display = 'none';
			document.getElementById('recurring-periode').style.display = 'none';
			document.getElementById('date-periode').style.display = 'none';
			document.getElementById('series').style.display = 'none';
			document.getElementById('mask_number').value = 0;

			document.getElementById('recurring_date_month').style.display = 'none';
			document.getElementById('recurring_date_year').style.display = 'none';
			document.getElementById('recurring_day_week').style.display = 'none';
			document.getElementById('recurring_week_month').style.display = 'none';
		}
		if(type == 'recurring'){
			document.getElementById('scheduled_date').style.display = 'none';
			document.getElementById('scheduled_time').style.display = 'block';
			document.getElementById('recurring').style.display = 'block';
			document.getElementById('recurring-periode').style.display = 'block';
			document.getElementById('date-periode').style.display = 'block';
			document.getElementById('series').style.display = 'none';
			document.getElementById('mask_number').value = 0;
		}
		if(type == 'series'){
			document.getElementById('scheduled_date').style.display = 'none';
			document.getElementById('scheduled_time').style.display = 'block';
			document.getElementById('recurring').style.display = 'block';
			document.getElementById('recurring-periode').style.display = 'block';
			document.getElementById('date-periode').style.display = 'block';
			document.getElementById('series').style.display = 'block';
			document.getElementById('mask_number').value = 1;

			document.getElementById('recurring_date_month').style.display = 'none';
			document.getElementById('recurring_date_year').style.display = 'none';
			document.getElementById('recurring_day_week').style.display = 'none';
			document.getElementById('recurring_week_month').style.display = 'none';

			document.getElementById('user_limit').style.display = 'none';
		}else{
			document.getElementById('user_limit').style.display = 'block';
		}
	}

	function showRecurring(type){
		if(type == 'date_every_month'){
			document.getElementById('recurring_date_month').style.display = 'block';
			document.getElementById('recurring_date_year').style.display = 'none';
			document.getElementById('recurring_day_week').style.display = 'none';
			document.getElementById('recurring_week_month').style.display = 'none';
			document.getElementById('scheduled_time').style.display = 'block';
		}

		if(type == 'date_every_year'){
			document.getElementById('recurring_date_month').style.display = 'none';
			document.getElementById('recurring_date_year').style.display = 'block';
			document.getElementById('recurring_day_week').style.display = 'none';
			document.getElementById('recurring_week_month').style.display = 'none';
			document.getElementById('scheduled_time').style.display = 'block';
		}

		if(type == 'day_every_week'){
			document.getElementById('recurring_date_month').style.display = 'none';
			document.getElementById('recurring_date_year').style.display = 'none';
			document.getElementById('recurring_day_week').style.display = 'block';
			document.getElementById('recurring_week_month').style.display = 'block';
			document.getElementById('scheduled_time').style.display = 'block';
		}

		if(type == 'everyday'){
			document.getElementById('recurring_date_month').style.display = 'none';
			document.getElementById('recurring_date_year').style.display = 'none';
			document.getElementById('recurring_day_week').style.display = 'none';
			document.getElementById('recurring_week_month').style.display = 'none';
		}
	}

	function showPeriode(status){
		if(status.checked){
			document.getElementById('date-periode').style.display = 'block';
		} 
		else {
			document.getElementById('date-periode').style.display = 'none';
		}
	}

	$(".form_datetime").datetimepicker({
        format: "d-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep:1
    });
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
		<div class="mt-element-step">
			<div class="row step-line">
				<div class="col-md-4 mt-step-col first active">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Info</div>
					<div class="mt-step-content font-grey-cascade">Promotion Setup</div>
				</div>
				<div class="col-md-4 mt-step-col ">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Content</div>
					<div class="mt-step-content font-grey-cascade">Promotion Content</div>
				</div>
				<div class="col-md-4 mt-step-col last">
					<div class="mt-step-number bg-white">3</div>
					<div class="mt-step-title uppercase font-grey-cascade">Summary</div>
					<div class="mt-step-content font-grey-cascade">Promotion Result</div>
				</div>
			</div>
		</div>
	</div>
	<form role="form" action="" method="POST">
		<div class="col-md-8 col-md-offset-2">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Promotion Setup</span>
					</div>
				</div>
				<div class="portlet-body form">
					<div class="form-body">
						<div class="form-group">
							<label>Promotion Name</label>
							<input type="text" class="form-control" placeholder="Promotion Name" name="promotion_name" required @if(isset($result['promotion_name']) && $result['promotion_name'] != "") value="{{$result['promotion_name']}}" @endif style="width:50%">
						</div>
						<div class="form-group">
							<label>Promotion Type</label>
							<div class="md-radio-list">
								<div class="md-radio">
									<input type="radio" id="instant_campaign" name="promotion_type" value="Instant Campaign" class="md-radiobtn"
									@if(isset($result['promotion_type']) && $result['promotion_type'] == "Instant Campaign")
										checked
									@else
										@if(!isset($result['promotion_type'])) checked @endif
									@endif
									onClick="showform('instant');">
									<label for="instant_campaign" class="tooltips" data-placement="right" data-original-title="Pilih ini jika Anda ingin mengirim 1 campaign sekarang">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> Instant Campaign </label>
								</div>
								<div class="md-radio">
									<input type="radio" id="scheduled_campaign" name="promotion_type" value="Scheduled Campaign" class="md-radiobtn" onClick="showform('scheduled');" @if(isset($result['promotion_type']) && $result['promotion_type'] == "Scheduled Campaign") checked @endif>
									<label for="scheduled_campaign" class="tooltips" data-placement="right" data-original-title="Pilih ini jika Anda ingin mengirim 1 campaign pada waktu yang ditentukan">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> Scheduled Campaign </label>

								</div>
								<div class="md-radio">
									<input type="radio" id="recurring_campaign" name="promotion_type" value="Recurring Campaign" class="md-radiobtn" onClick="showform('recurring');" @if(isset($result['promotion_type']) && $result['promotion_type'] == "Recurring Campaign") checked @endif>
									<label for="recurring_campaign" class="tooltips" data-placement="right" data-original-title="Pilih ini jika Anda ingin mengirim campaign berulang kali setiap waktu yang ditentukan">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> Recurring Campaign </label>
								</div>
								<div class="md-radio">
									<input type="radio" id="campaign_series" name="promotion_type" value="Campaign Series" class="md-radiobtn" onClick="showform('series');" @if(isset($result['promotion_type']) && $result['promotion_type'] == "Campaign Series") checked @endif>
									<label for="campaign_series" class="tooltips" data-placement="right" data-original-title="Pilih ini jika Anda ingin mengirim campaign berseri">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> Campaign Series </label>
								</div>
							</div>
						</div>
						<div class="form-group" id="series" @if(isset($result['promotion_type'])) @if($result['promotion_type'] == "Campaign Series") style="display:block;width:30%" @else style="display:none;width:30%" @endif @else style="display:none;width:30%" @endif>
							<label>Number of Campaign</label>
							<input class="form-control" id="mask_number" type="text" name="promotion_series" placeholder="10" @if(isset($result['promotion_series']) && $result['promotion_series'] != "") value="{{$result['promotion_series']}}" @endif />
						</div>

						<div class="form-group" id="scheduled_date" @if(isset($result['promotion_type']) && $result['promotion_type'] == "Scheduled Campaign") style="display:block;" @else style="display:none;" @endif>
							<label>Scheduled Date</label>
							<div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" style="width:40%">
								<input type="text" name="schedule_date" class="form-control" readonly @if(isset($result['schedules'][0]['schedule_exact_date']) && $result['schedules'][0]['schedule_exact_date'] != "") value="{{date('d-m-Y', strtotime($result['schedules'][0]['schedule_exact_date']))}}" @endif>
								<span class="input-group-btn">
									<button class="btn default" type="button">
										<i class="fa fa-calendar"></i>
									</button>
								</span>
							</div>
						</div>

						<div class="form-group" id="recurring-periode" @if(isset($result['promotion_type'])) @if($result['promotion_type'] == "Recurring Campaign" || $result['promotion_type'] == "Campaign Series") style="display:block;"  @else style="display:none;" @endif @else style="display:none;" @endif>
							<div>
								<label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px"> Use Periode
									<input type="checkbox" name="use_periode[]" class="same" data-check="periode" onChange="showPeriode(this);" @if(isset($result['schedules'][0]['date_start']) && isset($result['schedules'][0]['date_end']) ) checked @endif/>
								  	<span></span>
								</label>
							</div>				
						</div>
						<div class="form-group" id="date-periode" @if(isset($result['schedules'][0]['date_start']) && isset($result['schedules'][0]['date_end']) ) style="display:block;" @else style="display:none;" @endif>
	                        <label> Promotion Periode <span class="required" aria-required="true"> * </span></label>
	                        <div class="row">
		                        <div class="col-md-5">
		                            <div class="input-icon right">
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control" name="date_start" value="{{ !empty($result['schedules'][0]['date_start']) || old('date_start') ? date('d-M-Y H:i', strtotime(old('date_start')??$result['schedules'][0]['date_start'])) : ''}}" required autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-question-circle tooltips" data-original-title="Date promotion started" data-container="body"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-md-5">
		                            <div class="input-icon right">
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control" name="date_end" value="{{ !empty($result['schedules'][0]['date_end']) || old('date_end') ? date('d-M-Y H:i', strtotime(old('date_end')??$result['schedules'][0]['date_end'])) : ''}}" required autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-question-circle tooltips" data-original-title="Date promotion ended" data-container="body"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                        </div>
	                        </div>
	                    </div>
						<div class="form-group" id="recurring" @if(isset($result['promotion_type'])) @if($result['promotion_type'] == "Recurring Campaign" || $result['promotion_type'] == "Campaign Series") style="display:block;"  @else style="display:none;" @endif @else style="display:none;" @endif>
							<label>Recurring Rule</label>
							<select name="recurring_rule" class="form-control input-sm select2" data-placeholder="Select Recurring Rule" onChange="showRecurring(this.value);">
								<option value="">Select...</option>
								<option value="date_every_year" @if(isset($result['schedules'][0]['schedule_date_month']) && $result['schedules'][0]['schedule_date_month'] != "") selected @endif>Every specific date every year (Date 1-31 / Month January - December)</option>
								<option value="date_every_month" @if(isset($result['schedules'][0]['schedule_date_every_month']) && $result['schedules'][0]['schedule_date_every_month'] != "") selected @endif>Every specific date every month (Date 1-31)</option>
								<option value="day_every_week" @if(isset($result['schedules'][0]['schedule_day_every_week']) && $result['schedules'][0]['schedule_day_every_week'] != "") selected @endif>Every specific day every week (Monday - Sunday / Week 1 - 5 / Every Week)</option>
								<option value="everyday" @if(isset($result['schedules'][0]['schedule_everyday']) && $result['schedules'][0]['schedule_everyday'] == "Yes") selected @endif>Everyday</option>
							</select>
						</div>

						<div class="form-group" id="recurring_date_year" @if(isset($result['schedules'][0]['schedule_date_month']) && $result['schedules'][0]['schedule_date_month'] != "") style="display:block;" @else style="display:none;" @endif>
							<label>Date / Month for Every Year</label>
							<div class="input-group input-medium date date-picker" data-date-format="dd-mm" data-date-start-date="+0d" style="width:40%">
								<input type="text" name="schedule_date_month" class="form-control" readonly @if(isset($result['schedules'][0]['schedule_date_month']) && $result['schedules'][0]['schedule_date_month'] != "") value="{{$result['schedules'][0]['schedule_date_month']}}" @endif>
								<span class="input-group-btn">
									<button class="btn default" type="button">
										<i class="fa fa-calendar"></i>
									</button>
								</span>
							</div>
						</div>

						<div class="form-group" id="recurring_date_month" @if(isset($result['schedules'][0]['schedule_date_every_month']) && $result['schedules'][0]['schedule_date_every_month'] != "") style="display:block;" @else style="display:none;" @endif>
							<label>Date for Every Month</label>
							<select name="schedule_date_every_month" class="form-control input-sm select2" data-placeholder="Date">
								<option value="">Select...</option>
								@for($x=1;$x<=31;$x++)
									@if(isset($result['schedules'][0]['schedule_date_every_month']))
										@if($result['schedules'][0]['schedule_date_every_month'] == $x)
											<option value="{{$x}}" selected>{{$x}}</option>
										@else
											<option value="{{$x}}" >{{$x}}</option>
										@endif
									@else
										<option value="{{$x}}" >{{$x}}</option>
									@endif
								@endfor
							</select>
						</div>

						<div class="form-group" id="recurring_day_week" @if(isset($result['schedules'][0]['schedule_day_every_week']) && $result['schedules'][0]['schedule_day_every_week'] != "") style="display:block;" @else style="display:none;" @endif>
							<label>Day for Every Week</label>
							<select name="schedule_day_every_week" class="form-control input-sm select2" data-placeholder="Days">
								<option value="">Select...</option>
								<option value="Monday" @if(isset($result['schedules'])) @if($result['schedules'][0]['schedule_day_every_week'] == 'Monday') selected @endif @endif>Monday</option>
								<option value="Tuesday" @if(isset($result['schedules'])) @if($result['schedules'][0]['schedule_day_every_week'] == 'Tuesday') selected @endif @endif>Tuesday</option>
								<option value="Wednesday" @if(isset($result['schedules'])) @if($result['schedules'][0]['schedule_day_every_week'] == 'Wednesday') selected @endif @endif>Wednesday</option>
								<option value="Thursday" @if(isset($result['schedules'])) @if($result['schedules'][0]['schedule_day_every_week'] == 'Thursday') selected @endif @endif>Thursday</option>
								<option value="Friday" @if(isset($result['schedules'])) @if($result['schedules'][0]['schedule_day_every_week'] == 'Friday') selected @endif @endif>Friday</option>
								<option value="Saturday" @if(isset($result['schedules'])) @if($result['schedules'][0]['schedule_day_every_week'] == 'Saturday') selected @endif @endif>Saturday</option>
								<option value="Sunday" @if(isset($result['schedules'])) @if($result['schedules'][0]['schedule_day_every_week'] == 'Sunday') selected @endif @endif>Sunday</option>

							</select>
						</div>

						<div class="form-group" id="recurring_week_month" @if(isset($result['schedules'][0]['schedule_day_every_week']) && $result['schedules'][0]['schedule_day_every_week'] != "") style="display:block;" @else style="display:none;" @endif>
							<label>Week for Every Month</label>
							<select name="schedule_week_in_month" class="form-control input-sm select2" data-placeholder="Week">
								<option value="">Select...</option>
								<option value="0" @if(isset($result['schedules'])) @if($result['schedules'][0]['schedule_week_in_month'] == 0) selected @endif @endif>Every Week</option>
								@for($x=1;$x<=5;$x++)
									@if(isset($result['schedules'][0]['schedule_week_in_month']))
										@if($result['schedules'][0]['schedule_week_in_month'] == $x)
											<option value="{{$x}}" selected>{{$x}}</option>
										@else
											<option value="{{$x}}" >{{$x}}</option>
										@endif
									@else
										<option value="{{$x}}" >{{$x}}</option>
									@endif
								@endfor
							</select>
						</div>

						<div class="form-group" id="scheduled_time"
						   @if(isset($result['promotion_type']))
							@if($result['promotion_type'] == "Scheduled Campaign" ||
							 $result['promotion_type'] == "Recurring Campaign" ||
							 $result['promotion_type'] == "Campaign Series") ||
								style="display:block;" @else style="display:none;"
							@endif
							@else
								style="display:none;"
							@endif
							>
							<label>Time to Send Campaign</label>
							<div class="input-group" style="width:40%">
								<input type="text" name="schedule_time" readonly class="form-control timepicker timepicker-24" @if(isset($result['schedules'][0]['schedule_time']) && $result['schedules'][0]['schedule_time'] != "") value="{{date('H:i', strtotime($result['schedules'][0]['schedule_time']))}}" @else value="" @endif>
								<span class="input-group-btn">
									<button class="btn default" type="button">
										<i class="fa fa-clock-o"></i>
									</button>
								</span>
							</div>
						</div>
						<!--
						<div class="form-group">
							<label>Use Voucher in this promotion?</label>
							<div class="md-radio-list">
								<div class="md-radio">
									<input type="radio" id="ya" name="promotion_vouchers" value="Yes" class="md-radiobtn" required>
									<label for="ya" class="tooltips" data-placement="right" data-original-title="Pilih ini jika promotion ini sekaligus mengirimkan voucher">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> Ya </label>
								</div>
								<div class="md-radio">
									<input type="radio" id="tidak" name="promotion_vouchers" value="No" class="md-radiobtn" checked required>
									<label for="tidak" class="tooltips" data-placement="right" data-original-title="Pilih ini jika promotion ini tidak mengirimkan voucher">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> Tidak </label>
								</div>
							</div>
						</div>
						-->

						<div class="form-group" id="user_limit" @if(isset($result['promotion_type'])) @if($result['promotion_type'] == "Campaign Series") style="display:none" @endif @endif>
							<label>Each user can only receive 1 time ?</label>
							<div class="md-radio-list">
								<div class="md-radio">
									<input type="radio" id="yes" name="promotion_user_limit" value="1" class="md-radiobtn" @if(isset($result['promotion_user_limit']) && $result['promotion_user_limit'] == "1") checked @endif>
									<label for="yes" class="tooltips" data-placement="right" data-original-title="Pilih 'Yes' jika tiap user hanya dapat menerima promotion ini 1 kali">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> Yes </label>
								</div>
								<div class="md-radio">
									<input type="radio" id="no" name="promotion_user_limit" value="0" class="md-radiobtn" @if(isset($result['promotion_user_limit']) && $result['promotion_user_limit'] == "0") checked @endif>
									<label for="no" class="tooltips" data-placement="right" data-original-title="Pilih 'No' jika tiap user dapat menerima promotion ini terus menerus">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> No </label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8 col-md-offset-2">
			{{ csrf_field() }}
			@if(isset($result['promotion_rule_parents']))
				<?php
					$search_param = $result['promotion_rule_parents'];
					$search_param = array_filter($search_param);
					$conditions = $search_param;
				?>
			@else
				@if(Session::has('form'))
				<?php
					$search_param = Session::get('form');
					$search_param = array_filter($search_param);
					if(isset($search_param['conditions'])){
						$conditions = $search_param['conditions'];
					} else {
						$conditions = "";
					}
				?>
				@else
				<?php
				//@if(isset($result['rules']))
				// @else
					$conditions = "";
				?>
				@endif
			@endif
			<?php $tombolsubmit = 'hidden'; ?>
			@include('filter')
		</div>
		<div class="col-md-8 col-md-offset-2">
			<div class="portlet light bordered">
				<div class="form-actions">
					<div class="row">
					{{ csrf_field() }}
						<div class="col-md-offset-4 col-md-8">
							<a href="{{URL::to('promotion')}}" class="btn default">Cancel</a>
							@if(MyHelper::hasAccess([112], $grantedFeature))
							<button type="submit" class="btn blue">Next Step</button>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection