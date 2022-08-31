<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
 ?>
 @extends('layouts.main-closed')


 @section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

	@php
		$code_type 			= null;
		$prefix_code 		= null;
		$number_last_code 	= null;
		$tag				= null;
		if (isset($result)) {
			$code_type 	= $result['code_type'];
			$tag		= $result['promo_campaign_have_tags'];
			if ($result['code_type'] == 'Multiple') {
				$prefix_code 		= $result['prefix_code'];
				$number_last_code 	= $result['number_last_code'];
			}

		} elseif (old() != "") {
			$code_type = old('code_type');
			if (old('code_type') == 'Multiple') {
			$prefix_code 		= old('prefix_code');
			$number_last_code 	= old('number_last_code');
			}
		}
	@endphp
	<script>
	function delay(callback, ms) {
		var timer = 0;
		return function() {
			var context = this, args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function () {
			callback.apply(context, args);
			}, ms || 0);
		};
	}

	function permut(total_set, each){
		total_set = parseInt(total_set);
		each = parseInt(each);
		let limit = total_set - each;
    	let permut = 1;
    	let arr = [];
    	do {
			permut = permut * total_set;
			console.log([permut, total_set]);
			total_set -= 1; 
		}
		while (total_set > limit);
		console.log(permut, total_set, each);

		return permut;
    }

	$(document).ready(function() {
		promo_id = {!! $result['id_promo_campaign']??"false" !!}

		$('.digit_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '0',
			max: '999999999'
		});

		$('.digit_random').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '1',
			max: '20'
		});

		$.ajax({
			type: "GET",
			url: "getTag",
			dataType: "json",
			success: function(data){
				if (data.status == 'fail') {
					$.ajax(this)
					return
				}
				productLoad = 1;
				$.each(data, function( key, value ) {
					$('#selectTag').append("<option id='tag"+value.id_promo_campaign_tag+"' value='"+value.tag_name+"'>"+value.tag_name+"</option>");
				});
				$('#multipleProduct').prop('required', true)
				$('#multipleProduct').prop('disabled', false)
			},
			complete: function(data){
				tag = JSON.parse('{!!json_encode($tag)!!}')
				$.each(tag, function( key, value ) {
					$("#tag"+value.promo_campaign_tag.id_promo_campaign_tag+"").attr('selected', true)
				});
			}
		});
		$("#selectTag").select2({
			placeholder: "Input tag",
			tags: true
		})
		$("#select-day").select2({
			placeholder: "Select days",
			tags: true
		})
		$("#start_date").datetimepicker({
			format: "dd MM yyyy - hh:ii",
			autoclose: true,
			startDate: new Date(),
			minuteStep: 5,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('#end_date').datetimepicker('setStartDate', minDate);
		});
		$("#end_date").datetimepicker({
			format: "dd MM yyyy - hh:ii",
			autoclose: true,
			minuteStep: 5,
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('#start_date').datetimepicker('setEndDate', minDate);
		});
		$('#singleCode').hide()
		$('#multipleCode').hide()
		$('#exampleCode').hide()
		$('#selectedDay').hide()
		var maxChar = 15
		$('input[name=code_type]').change(function() {
			code = $('input[name=code_type]:checked').val()
			$('#exampleCode').replaceWith("<span id='exampleCode'></span>")
			$('#singleCode').hide()
			$('#multipleCode').hide()
			$('#brandingCode').hide()
			$('#singlePromoCode').prop('required', false);
			$('#multiplePrefixCode').prop('required', false);
			$('#multipleNumberLastCode').prop('required', false);
			$('#multiplePrefixCode').val('')
			if (code == 'Single') {
				$(':input[type="submit"]').prop('disabled', false);
				$('#totalCoupon').removeClass( "has-error" );
				$('#alertTotalCoupon').hide();
				$('#singleCode').show()
				$('#singlePromoCode').prop('required', true);
				$('#singlePromoCode').keyup(function() {	
					$('#singlePromoCode').val(function () {
						return this.value.toUpperCase();
					})
				});
				$('#singlePromoCode').keyup(delay(function() {
					$.ajax({
						type: "GET",
						url: "check",
						data: {
							'type_code' 	: 'single',
							'search_code' 	: this.value,
							'promo_id' 		: promo_id
						},
						dataType: "json",
						success: function(msg){
							if (msg.status == 'available') {
								$(':input[type="submit"]').prop('disabled', false);
								$('#singleCode').children().removeClass( "has-error" );
								$('#alertSinglePromoCode').hide();
							} else {
								$(':input[type="submit"]').prop('disabled', true);
								$('#singleCode').children().addClass( "has-error" );
								$('#alertSinglePromoCode').show();
							}
						}
					});
				}, 1000));
			} else {
				$('#multipleCode').show()
				$('#number_last_code').show()
				$('input[name=total_coupon]').val('')
				$('#multipleNumberLastCode').prop('required', true);
				$('#multiplePrefixCode').keyup(function() {	
					$('#multiplePrefixCode').val (function () {
						return this.value.toUpperCase();
					})
				});
				$('#multiplePrefixCode').keyup(delay(function() {
					if ($(this).val()) {
						$.ajax({
							type: "GET",
							url: "check",
							data: {
								'type_code' 	: 'prefix',
								'search_code' 	: this.value,
								'promo_id' 		: promo_id
							},
							dataType: "json",
							success: function(msg){
								if (msg.status == 'available') {
									$(':input[type="submit"]').prop('disabled', false);
									$('#alertMultipleCode').removeClass( "has-error" );
									$('#alertMultiplePromoCode').hide();
								} else {
									$(':input[type="submit"]').prop('disabled', true);
									$('#alertMultipleCode').addClass( "has-error" );
									$('#alertMultiplePromoCode').show();
								}
							}
						});
						$('#exampleMultipleCode').show()
						$('#number_last_code').show()
						$('#multipleNumberLastCode').val('')
						$('#exampleCode').replaceWith("<span id='exampleCode'></span>")
						$('#multipleNumberLastCode').attr('max', maxChar - this.value.length)
					}
					else {
						$(':input[type="submit"]').prop('disabled', false);
						$('#alertMultipleCode').removeClass( "has-error" );
						$('#alertMultiplePromoCode').hide();
						$('#multipleNumberLastCode').attr('max', maxChar - this.value.length)
					}

				}, 1000));

				$('#multipleNumberLastCode').keyup(function() {
					prefix = ($('#multiplePrefixCode').val())
					last_code = ($('#multipleNumberLastCode').val())
					max = +$(this).attr('max');
					val = +$(this).val();

					if (val > max) {
						$('#multipleNumberLastCode').val(max);
						last_code = max;
					}

					if(val < 6) {
						$(':input[type="submit"]').prop('disabled', true);
						$('#number_last_code').addClass( "has-error" );
						$('#alertDigitRandom').show();
					}else{
						$(':input[type="submit"]').prop('disabled', false);
						$('#number_last_code').removeClass( "has-error" );
						$('#alertDigitRandom').hide();
					}

					console.log(last_code)
					var result           = '';
					var result1          = '';
					var result2          = '';
					var characters       = 'ABCDEFGHJKLMNPQRTUVWXY123456789';
					var charactersLength = characters.length;
					for ( var i = 0; i < last_code; i++ ) {
						result += characters.charAt(Math.floor(Math.random() * charactersLength));
						result2 += characters.charAt(Math.floor(Math.random() * charactersLength));
						result1 += characters.charAt(Math.floor(Math.random() * charactersLength));
					}
					$('#exampleCode').replaceWith("<span id='exampleCode'>"+prefix+result+"</span>")
					$('#exampleCode1').replaceWith("<span id='exampleCode1'>"+prefix+result1+"</span>")
					$('#exampleCode2').replaceWith("<span id='exampleCode2'>"+prefix+result2+"</span>")
				});

				$('#multipleNumberLastCode').keyup(function() {
					prefix = ($('#multiplePrefixCode').val())
					last_code = ($('#multipleNumberLastCode').val())
					max = +$(this).attr('max');
					val = +$(this).val();
					
					if (val > max) {
						$('#multipleNumberLastCode').val(max);
					}
				});

				$('input[name=total_coupon], #multipleNumberLastCode').keyup(function() {
					if (code != 'Single') {
						maxCharDigit = 28;
						// hitungKemungkinan = Math.pow(maxCharDigit, $('#multipleNumberLastCode').val())
						hitungKemungkinan = permut(maxCharDigit, $('#multipleNumberLastCode').val());
						console.log([hitungKemungkinan, $('#multipleNumberLastCode').val(), $('input[name=total_coupon]').inputmask('unmaskedvalue')]);
						if (hitungKemungkinan >= $('input[name=total_coupon]').inputmask('unmaskedvalue')) {
							$(':input[type="submit"]').prop('disabled', false);
							$('#totalCoupon').removeClass( "has-error" );
							$('#alertTotalCoupon').hide();
						} else {
							$(':input[type="submit"]').prop('disabled', true);
							$('#totalCoupon').addClass( "has-error" );
							$('#alertTotalCoupon').show();
						}
					}
				});
			}
		});

		$('#promo_day').change(function() {
            var promo_day = $('#promo_day option:selected').val();
			PromoDay(promo_day);
		});

		function PromoDay(value){
			if(value==1){
				$('#selectedDay').hide();
				$('#select-day').prop('required',false);
				$('#select-day').prop('disabled',true);
			}else if (value == 0) {
				$('#selectedDay').show();
				$('#select-day').prop('required',true);
				$('#select-day').prop('disabled',false);
			}
		}
		var global_promo_day = '{!! $result['is_all_days']??1 !!}'
		PromoDay(global_promo_day);
		var code_type = '{!!$code_type!!}'
		var prefix_code = '{!!$prefix_code!!}'
		var number_last_code = '{!!$number_last_code!!}'
		if (code_type == 'Single') {
			$('input[name=code_type]').trigger('change');
		} else if (code_type == 'Multiple') {
			$('input[name=code_type]').trigger('change');
			$('#multiplePrefixCode').val(prefix_code).trigger('keyup');
			$('#multipleNumberLastCode').val(number_last_code).trigger('keyup');
		}
	});
	</script>
	<style>
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
		-webkit-appearance: none; 
		margin: 0; 
	}
	</style>
	
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
				<div class="col-md-6 mt-step-col first active">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Campaign Info</div>
					<div class="mt-step-content font-grey-cascade">Campaign Name, Title, Type & Total</div>
				</div>
				<div class="col-md-6 mt-step-col last">
					<a href="{{ ($result['id_promo_campaign'] ?? false) ? url('promo-campaign/step2/'.$result['id_promo_campaign']) : '' }}" class="text-decoration-none">
						<div class="mt-step-number bg-white">2</div>
						<div class="mt-step-title uppercase font-grey-cascade">Campaign Detail</div>
						<div class="mt-step-content font-grey-cascade">Detail Campaign Information</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	
	<form role="form" action="" method="POST">
		<div class="col-md-1"></div>
		<div class="col-md-5">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Campaign Info</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="form-group">
						<label class="control-label">Name</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Campaign Name" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control" name="campaign_name" placeholder="Campaign Name" @if(isset($result['campaign_name']) && $result['campaign_name'] != "") value="{{$result['campaign_name']}}" @elseif(old('campaign_name') != "") value="{{old('campaign_name')}}" @endif autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Title</label>
						<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Title that will be displayed when promo campaign is used" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control" name="promo_title" placeholder="Promo Title" @if(isset($result['promo_title']) && $result['promo_title'] != "") value="{{$result['promo_title']}}" @elseif(old('promo_title') != "") value="{{old('promo_title')}}" @endif autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label for="selectTag" class="control-label">Tag</label>
						<i class="fa fa-question-circle tooltips" data-original-title="Tags that will be used to categorized promo campaign" data-container="body"></i>
						<select id="selectTag" name="promo_tag[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true"></select>
					</div>
					<div class="form-group">
						<label for="selectTag" class="control-label">Product Type</label>
						<i class="fa fa-question-circle tooltips" data-original-title="Product type that will be applied when promo code is used" data-container="body"></i>
						<select class="form-control" name="product_type">
							<option value="single" @if(isset($result['product_type']) && $result['product_type'] == "single") selected @endif required> Single </option>
							<option value="group" @if(isset($result['product_type']) && $result['product_type'] == "group") selected @endif> Group </option>
                        </select>
					</div>
					<div class="form-group">
						<label class="control-label">Start Date</label>
						<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Date when promo started" data-container="body"></i>
						<div class="input-group date bs-datetime">
							<input required autocomplete="off" id="start_date" type="text" class="form-control" name="date_start" placeholder="Start Date" @if(isset($result['date_start']) && $result['date_start'] != "") value="{{date('d F Y - H:i', strtotime($result['date_start']))}}" @elseif(old('date_start') != "") value="{{old('date_start')}}" @endif>
							<span class="input-group-addon">
								<button class="btn default date-set" type="button">
									<i class="fa fa-calendar"></i>
								</button>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">End Date</label>
						<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Date when promo ended" data-container="body"></i>
						<div class="input-group date bs-datetime">
							<input required autocomplete="off" id="end_date" type="text" class="form-control" name="date_end" placeholder="End Date" @if(isset($result['date_end']) && $result['date_end'] != "") value="{{date('d F Y - H:i', strtotime($result['date_end']))}}" @elseif(old('date_end') != "") value="{{old('date_end')}}" @endif>
							<span class="input-group-addon">
								<button class="btn default date-set" type="button">
									<i class="fa fa-calendar"></i>
								</button>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="selectTag" class="control-label">Promo Day</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Promo only can use in promo day" data-container="body"></i>
						<select class="form-control" id="promo_day" name="is_all_days" required>
							<option value="1" @if(isset($result['is_all_days']) && $result['is_all_days'] == "1") selected @endif> All Days </option>
							<option value="0" @if(isset($result['is_all_days']) && $result['is_all_days'] == "0") selected @endif> Selected Day </option>
                        </select>
					</div>
					<div id="selectedDay">
						<div class="form-group">
							<label class="control-label">Select Day</label>
							<i class="fa fa-question-circle tooltips" data-original-title="Select day promo can be applied" data-container="body"></i>
							<div class="input-group col-md-12">
								@php
									$selected_days = [];
									if (old('service')) {
										$selected_days = old('service');
									}
									elseif (!empty($result['promo_campaign_days'])) {
										$selected_days = array_column($result['promo_campaign_days'], 'day');
									}
								@endphp
								<select	select id="select-day" name="selected_day[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true">
									<option value="Monday" @if ($selected_days) @if(in_array('Monday', $selected_days)) selected @endif @endif>Monday</option>
									<option value="Tuesday" @if ($selected_days) @if(in_array('Tuesday', $selected_days)) selected @endif @endif>Tuesday</option>
									<option value="Wednesday" @if ($selected_days) @if(in_array('Wednesday', $selected_days)) selected @endif @endif>Wednesday</option>
									<option value="Thursday" @if ($selected_days) @if(in_array('Thursday', $selected_days)) selected @endif @endif>Thursday</option>
									<option value="Friday" @if ($selected_days) @if(in_array('Friday', $selected_days)) selected @endif @endif>Friday</option>
									<option value="Saturday" @if ($selected_days) @if(in_array('Saturday', $selected_days)) selected @endif @endif>Saturday</option>
									<option value="Sunday" @if ($selected_days) @if(in_array('Sunday', $selected_days)) selected @endif @endif>Sunday</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Generate Code</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="form-group" style="height: 90px;">
						<label class="control-label">Code Type</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Type of promo code that will be made" data-container="body"></i>
						<div class="mt-radio-list">
							<label class="mt-radio mt-radio-outline"> Single
								<input type="radio" value="Single" name="code_type" @if(isset($result['code_type']) && $result['code_type'] == "Single") checked @elseif(old('code_type') == "Single") checked @endif required/>
								<span></span>
							</label>
							<label class="mt-radio mt-radio-outline"> Multiple
								<input type="radio" value="Multiple" name="code_type" @if(isset($result['code_type']) && $result['code_type'] == "Multiple") checked  @elseif(old('code_type') == "Multiple") checked @endif required/>
								<span></span>
							</label>
						</div>
					</div>
					<div id="singleCode">
						<div class="form-group">
							<label class="control-label">Promo Code</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="Code that is used to apply promo" data-container="body"></i>
							<div class="input-group col-md-12">
								<input id="singlePromoCode" maxlength="15" type="text" class="form-control" name="promo_code" onkeyup="this.value=this.value.replace(/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]/g,'');" placeholder="Promo Code" @if(isset($result['promo_campaign_promo_codes'][0]['promo_code']) && $result['promo_campaign_promo_codes'][0]['promo_code'] != "") value="{{$result['promo_campaign_promo_codes'][0]['promo_code']}}" @elseif(old('promo_code') != "") value="{{old('promo_code')}}" @endif autocomplete="off">
								<p id="alertSinglePromoCode" style="display: none;" class="help-block">Code has already been made!</p>
							</div>
						</div>
					</div>
					<div id="multipleCode">
						<div class="form-group" id="alertMultipleCode">
							<label class="control-label">Prefix Code</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="Code that is added to the beginning of each generated code.
							</br>
							</br> Prefix code can be null.
							</br>
							</br> Prefix Code + Digit Random cannot exceed 15 characters." data-container="body" data-html="true"></i>
							<div class="input-group col-md-12">
								<input id="multiplePrefixCode" maxlength="9" type="text" class="form-control" name="prefix_code" onkeyup="this.value=this.value.replace(/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]/g,'');" placeholder="Prefix Code" @if(isset($result['prefix_code']) && $result['prefix_code'] != "") value="{{$result['prefix_code']}}" @elseif(old('prefix_code') != "") value="{{old('prefix_code')}}" @endif autocomplete="off">
								<p id="alertMultiplePromoCode" style="display: none;" class="help-block">Prefix code has already been made, it is recommended to create a new code!</p>
							</div>
						</div>
						<div class="form-group" id="number_last_code">
							<label class="control-label">Digit Random</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="Random Code that is added to the end of each generated code. Prefix Code + Digit Random cannot exceed 15 digits. Minimum 6 digit" data-container="body"></i>
							<div class="input-group col-md-12">
								<input id="multipleNumberLastCode" type="number" class="form-control" name="number_last_code" placeholder="Total Digit Random Last Code" @if(isset($result['number_last_code']) && $result['number_last_code'] != "") value="{{$result['number_last_code']}}" @elseif(old('number_last_code') != "") value="{{old('number_last_code')}}" @endif autocomplete="off" min="6" max="15">
								<p id="alertDigitRandom" style="display: none;" class="help-block">Digit Random minimum value is 6</p>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Example Code 
							<i class="fa fa-question-circle tooltips" data-original-title="Example of codes that will be made" data-container="body"></i></label>
							<div class="input-group col-md-12">
								<span id="exampleCode"></span>
							</div>
							<div class="input-group col-md-12">
								<span id="exampleCode1"></span>
							</div>
							<div class="input-group col-md-12">
								<span id="exampleCode2"></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Limit Usage</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Limit of one user can use promo code" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control digit_mask" name="limitation_usage" placeholder="Limit Usage" @if(isset($result['limitation_usage']) && $result['limitation_usage'] != "") value="{{$result['limitation_usage']}}" @elseif(old('limitation_usage') != "") value="{{old('limitation_usage')}}" @endif autocomplete="off">
						</div>
					</div>
					<div class="form-group" id="totalCoupon">
						<label class="control-label">Total Coupon</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Maximum total Coupons that can be used. Input 0 for unlimited coupons" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control digit_mask" name="total_coupon" placeholder="Total Coupon" value="{{$result['total_coupon']??old('total_coupon')}}" autocomplete="off">
							<p id="alertTotalCoupon" style="display: none;" class="help-block">Generate Random Total Coupon exceed maximum estimated number of codes!</p>
						</div>
					</div>
					@if (isset($result['id_promo_campaign']))
						<input type="hidden" name="id_promo_campaign" value="{{ $result['id_promo_campaign'] }}">
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-1"></div>
		<div class="col-md-12" style="text-align:center;">
			<div class="form-actions">
				{{ csrf_field() }}
				<button type="submit" class="btn blue">Next Step ></button>
			</div>
		</div>
	</form>
</div>
@endsection