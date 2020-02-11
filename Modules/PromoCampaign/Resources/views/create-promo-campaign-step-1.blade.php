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
	$(document).ready(function() {
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
							'type_code' : 'single',
							'search_code' : this.value
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
				$('#multiplePrefixCode').prop('required', true);
				$('#multipleNumberLastCode').prop('required', true);
				$('#multiplePrefixCode').keyup(function() {	
					$('#multiplePrefixCode').val (function () {
						return this.value.toUpperCase();
					})
				});
				$('#multiplePrefixCode').keyup(delay(function() {
					$.ajax({
						type: "GET",
						url: "check",
						data: {
							'type_code' : 'prefix',
							'search_code' : this.value
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
				}, 1000));
				$('#multipleNumberLastCode').keyup(function() {
					prefix = ($('#multiplePrefixCode').val())
					last_code = ($('#multipleNumberLastCode').val())
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
				$('input[name=total_coupon]').keyup(function() {
					maxCharDigit = 28;
					hitungKemungkinan = Math.pow(maxCharDigit, $('#multipleNumberLastCode').val())
					if (hitungKemungkinan >= $('input[name=total_coupon]').inputmask('unmaskedvalue')) {
						$(':input[type="submit"]').prop('disabled', false);
						$('#totalCoupon').removeClass( "has-error" );
						$('#alertTotalCoupon').hide();
					} else {
						$(':input[type="submit"]').prop('disabled', true);
						$('#totalCoupon').addClass( "has-error" );
						$('#alertTotalCoupon').show();
					}
				});
			}
		});
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
						<i class="fa fa-question-circle tooltips" data-original-title="Nama Campaign" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control" name="campaign_name" placeholder="Campaign Name" @if(isset($result['campaign_name']) && $result['campaign_name'] != "") value="{{$result['campaign_name']}}" @elseif(old('campaign_name') != "") value="{{old('campaign_name')}}" @endif autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Title</label>
						<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Judul Promo" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control" name="promo_title" placeholder="Promo Title" @if(isset($result['promo_title']) && $result['promo_title'] != "") value="{{$result['promo_title']}}" @elseif(old('promo_title') != "") value="{{old('promo_title')}}" @endif autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label for="selectTag" class="control-label">Tag</label>
						<i class="fa fa-question-circle tooltips" data-original-title="Kode tag digunakan untuk mengkategorikan kode promo" data-container="body"></i>
						<select id="selectTag" name="promo_tag[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true"></select>
					</div>
					<div class="form-group">
						<label class="control-label">Start Date</label>
						<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Waktu dimulai berlakunya promo" data-container="body"></i>
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
                        <i class="fa fa-question-circle tooltips" data-original-title="Waktu selesai berlakunya promo" data-container="body"></i>
						<div class="input-group date bs-datetime">
							<input required autocomplete="off" id="end_date" type="text" class="form-control" name="date_end" placeholder="End Date" @if(isset($result['date_end']) && $result['date_end'] != "") value="{{date('d F Y - H:i', strtotime($result['date_end']))}}" @elseif(old('date_end') != "") value="{{old('date_end')}}" @endif>
							<span class="input-group-addon">
								<button class="btn default date-set" type="button">
									<i class="fa fa-calendar"></i>
								</button>
							</span>
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
						<i class="fa fa-question-circle tooltips" data-original-title="Tipe kode promo yang dibuat" data-container="body"></i>
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
							<i class="fa fa-question-circle tooltips" data-original-title="Kode promo yang dibuat" data-container="body"></i>
							<div class="input-group col-md-12">
								<input id="singlePromoCode" maxlength="15" type="text" class="form-control" name="promo_code" onkeyup="this.value=this.value.replace(/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]/g,'');" placeholder="Promo Code" @if(isset($result['promo_code']) && $result['promo_campaign_promo_code']['promo_code'] != "") value="{{$result['promo_campaign_promo_code']['promo_code']}}" @elseif(old('promo_code') != "") value="{{old('promo_code')}}" @endif autocomplete="off">
								<p id="alertSinglePromoCode" style="display: none;" class="help-block">Kode sudah pernah dibuat!</p>
							</div>
						</div>
					</div>
					<div id="multipleCode">
						<div class="form-group" id="alertMultipleCode">
							<label class="control-label">Prefix Code</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="Kode prefix untuk judul kode" data-container="body"></i>
							<div class="input-group col-md-12">
								<input id="multiplePrefixCode" maxlength="15" type="text" class="form-control" name="prefix_code" onkeyup="this.value=this.value.replace(/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]/g,'');" placeholder="Prefix Code" @if(isset($result['prefix_code']) && $result['prefix_code'] != "") value="{{$result['prefix_code']}}" @elseif(old('prefix_code') != "") value="{{old('prefix_code')}}" @endif autocomplete="off">
								<p id="alertMultiplePromoCode" style="display: none;" class="help-block">Kode prefix sudah pernah dibuat, lebih disarankan untuk membuat kode baru!</p>
							</div>
						</div>
						<div class="form-group" id="number_last_code">
							<label class="control-label">Digit Random</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="Jumlah digit yang digenerate secara otomatis untuk akhiran kode" data-container="body"></i>
							<div class="input-group col-md-12">
								<input id="multipleNumberLastCode" type="number" class="form-control" name="number_last_code" placeholder="Total Digit Random Last Code" @if(isset($result['number_last_code']) && $result['number_last_code'] != "") value="{{$result['number_last_code']}}" @elseif(old('number_last_code') != "") value="{{old('number_last_code')}}" @endif autocomplete="off" oninput="validity.valid||(value='');" min="6" max="15">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Example Code 
							<i class="fa fa-question-circle tooltips" data-original-title="Contoh Kode yang digenerate secara otomatis" data-container="body"></i></label>
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
						<i class="fa fa-question-circle tooltips" data-original-title="Limit penggunaan kode promo" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control digit_mask" name="limitation_usage" placeholder="Limit Usage" @if(isset($result['limitation_usage']) && $result['limitation_usage'] != "") value="{{$result['limitation_usage']}}" @elseif(old('limitation_usage') != "") value="{{old('total_coupon')}}" @endif autocomplete="off">
						</div>
					</div>
					<div class="form-group" id="totalCoupon">
						<label class="control-label">Total Coupon</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Total kode kupon yang dibuat" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control digit_mask" name="total_coupon" placeholder="Total Coupon" @if(isset($result['total_coupon']) && $result['total_coupon'] != "") value="{{$result['total_coupon']}}" @elseif(old('total_coupon') != "") value="{{old('total_coupon')}}" @endif autocomplete="off">
							<p id="alertTotalCoupon" style="display: none;" class="help-block">Generate Random Total Coupon sangat tidak memungkinkan!</p>
						</div>
					</div>
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