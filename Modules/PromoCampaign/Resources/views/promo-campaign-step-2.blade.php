@php 
	date_default_timezone_set('Asia/Jakarta');
@endphp
@extends('layouts.main-closed')
@include('promocampaign::bulkForm')
@include('promocampaign::buyXgetYForm')
@include('promocampaign::promoProductCategoryForm')
@include('promocampaign::warning-image')
@include('promocampaign::template.discount-delivery', ['promo_source' => 'promo_campaign'])
{{-- @include('promocampaign::template.promo-global-requirement', ['promo_source' => 'promo_campaign']) --}}
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
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.d-none {
			display: none;
		}
		.width-60-percent {
			width: 60%;
		}
		.width-100-percent {
			width: 100%;
		}
		.width-voucher-img {
			max-width: 200px;
			width: 100%;
		}
		.v-align-top {
			vertical-align: top;
		}
		.p-t-10px {
			padding-top: 10px;
		}
		.page-container-bg-solid .page-content {
			background: #fff!important;
		}
		.text-decoration-none {
			text-decoration: none!important;
		}
		.p-l-0{
			padding-left: 0px;
		}
		.p-r-0{
			padding-right: 0px;
		}
		.p-l-r-0{
			padding-left: 0px;
			padding-right: 0px;
		}
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/table-datatables-buttons.js') }}" type="text/javascript"></script>
	
	@php
		$is_all_product 	= null;
		$product 			= null;
		$is_all_outlet 		= null;
		$outlet			 	= null;

		if (isset($result['is_all_outlet']) && $result['is_all_outlet'] == "0") {
			$is_all_outlet = $result['is_all_outlet'];
			$outlet = [];
			for ($i=0; $i < count($result['outlets']); $i++) { 
				$outlet[] = $result['outlets'][$i]['id_outlet'];
			}
		}
		if (isset($result['promo_campaign_product_discount_rules']['is_all_product']) && $result['promo_campaign_product_discount_rules']['is_all_product'] == "0") {
			$is_all_product = $result['promo_campaign_product_discount_rules']['is_all_product'];
			$product = [];
			for ($i=0; $i < count($result['promo_campaign_product_discount']); $i++) { 
				$product[] = $result['promo_campaign_product_discount'][$i]['id_product'];
			}
		}

		$datenow = date("Y-m-d H:i:s");
		if ($result??false) {
            $date_start = $result['date_start'];
            $date_end   = $result['date_end'];
        }elseif($result['vouchers']??false){
            $date_start = $result['vouchers']['voucher_publish_start'];
            $date_end   = $result['vouchers']['voucher_publish_end'];
        }else{
            $date_start = null;
            $date_end   = null;
        }
	@endphp
	<script>
	$(document).ready(function() {
		listProduct=[];
		listCategory=[];
		listProductSingle=[];
		productLoad = 0;
		categoryLoad = 0;
		product_type = '{!! $result['product_type'] !!}';

		$.ajax({
			type: "GET",
			url: "getData",
			data : {
				get : 'Product',
				type : 'Single'
			},
			dataType: "json",
			success: function(data){
				if (data.status == 'fail') {
					$.ajax(this)
					return
				}
				listProductSingle=data;
				reOrder2();
				reOrder3();
			}
		});
		// if (productLoad == 0) {
		// }

		var is_all_product = '{!!$is_all_product!!}'
		if (is_all_product == 0 && is_all_product.length != 0) {
			$('#productDiscount').show()
			$('#selectProduct').show()
			if (productLoad == 0) {
				$.ajax({
					type: "GET",
					url: "getData",
					data : {
						get : 'Product',
						type : product_type
					},
					dataType: "json",
					success: function(data){
						if (data.status == 'fail') {
							$.ajax(this)
							return
						}
						productLoad = 1;
						listProduct=data;
						$.each(data, function( key, value ) {
							$('#multipleProduct').append("<option id='product"+value.id_product+"' value='"+value.id_product+"'>"+value.product+"</option>");
							$('#multipleProduct2,#multipleProduct3').append("<option value='"+value.id_product+"'>"+value.product+"</option>");
						});
						$('#multipleProduct').prop('required', true)
						$('#multipleProduct').prop('disabled', false)
					},
					complete: function(data){
						if (data.responseJSON.status != 'fail') {
							selectedProduct = JSON.parse('{!!json_encode($product)!!}')
							$.each(selectedProduct, function( key, value ) {
								$("#product"+value+"").attr('selected', true)
							});
						}
					}
				});
			} else {
				$('#multipleProduct').prop('required', true)
				$('#multipleProduct').prop('disabled', false)
			}
		}

		$.ajax({
			type: "GET",
			url: "getData",
			data : {
				get : 'Outlet'
			},
			dataType: "json",
			success: function(data){
				if (data.status == 'fail') {
					$.ajax(this)
					return
				}
				listOutlet=data;
				$.each(data, function( key, value ) {
					$('#multipleOutlet').append("<option id='outlet"+value.id_outlet+"' value='"+value.id_outlet+"'>"+value.outlet+"</option>");
				});

			},
			complete: function(data){
				if (data.responseJSON.status != 'fail') {
					selectedOutlet = JSON.parse('{!!json_encode($outlet)!!}')
					$.each(selectedOutlet, function( key, value ) {
						$("#outlet"+value+"").attr('selected', true)
					});
				}
			}
		});

		$('input[name=filter_user]').change(function() {
			user = $('input[name=filter_user]:checked').val()
			$('input[name=specific_user]').prop('required', false)
			$('input[name=specific_user]').prop('disabled', true)
			if (user == 'Specific User') {
				$('#specific-user').show()				
 
			} else {
				$('#specific-user').hide()
			}
		});

		$('#selectProduct').hide()
		function loadProduct(selector,callback){
			if (productLoad == 0) {
				var valuee=$(selector).data('value');
				$.ajax({
					type: "GET",
					url: "getData",
					data : {
						get : 'Product',
						type : product_type
					},
					dataType: "json",
					success: function(data){
						listProduct=data;
						productLoad = 1;
						$.each(data, function( key, value ) {
							if(valuee.indexOf(value.id_product)>-1){
								var more='selected';
							}else{
								var more='';
							}
							$('#multipleProduct,#multipleProduct2,#multipleProduct3').append("<option value='"+value.id_product+"' "+more+">"+value.product+"</option>");
						});
						$(selector).prop('required', true)
						$(selector).prop('disabled', false)
						if(callback){callback()}
					}
				});
			}
		}

		function loadCategory(selector,callback){
			if (categoryLoad == 0) {
				var valuee=$(selector).data('value');
				$.ajax({
					type: "GET",
					url: "getData",
					data : {
						get : 'Category',
						type : product_type
					},
					dataType: "json",
					success: function(data){
						listCategory=data;
						categoryLoad = 1;
						$.each(data, function( key, value ) {
							if(valuee.indexOf(value.id_product_category)>-1){
								var more='selected';
							}else{
								var more='';
							}
							$('#multipleCategory').append("<option value='"+value.id_product_category+"' "+more+">"+value.product_category_name+"</option>");
						});
						$(selector).prop('required', true)
						$(selector).prop('disabled', false)
						if(callback){callback()}
					}
				});
			}
		}

		function changeTriger () {
			$('#tabContainer .tabContent').hide();
			promo_type = $('select[name=promo_type] option:selected').val();
			// $('#tabContainer input:not(input[name="promo_type"]),#tabContainer select').prop('disabled',true);
			$('#productDiscount, #bulkProduct, #buyXgetYProduct, #promoProductCategory, #discount-delivery').hide().find('input, textarea, select').prop('disabled', true);

			if (promo_type == 'Product Discount') {
				product = $('select[name=filter_product] option:selected').val();
				$('#productDiscount').show().find('input, textarea, select').prop('disabled', false);
				if (product == 'All Product') {
					$('#multipleProduct').find('select').prop('disabled', true);
				}else {
					$('#multipleProduct').prop('disabled', false);
				}
			}else if(promo_type == 'Tier discount'){

				reOrder();
				$('#bulkProduct').show().find('input, textarea, select').prop('disabled', false);
				loadProduct('#multipleProduct2');
			}else if(promo_type=='Buy X Get Y'){

				reOrder2();
				$('#buyXgetYProduct').show().find('input, textarea, select').prop('disabled', false);
				loadProduct('#multipleProduct3',reOrder2);
			}else if(promo_type=='Promo Product Category'){

				reOrder3();
				$('#promoProductCategory').show().find('input, textarea, select').prop('disabled', false);
				loadCategory('#multipleCategory',reOrder3);
			}
			else if(promo_type == 'Discount delivery'){

				$('#discount-delivery').show().find('input, textarea, select').prop('disabled', false);
			}
		}

		$('select[name=promo_type]').change(changeTriger);
		$('select[name=filter_product]').change(function() {
			product = $('select[name=filter_product] option:selected').val()
			$('#multipleProduct').prop('required', false)
			$('#multipleProduct').prop('disabled', true)
			if (product == 'Selected') {
				$('#selectProduct').show()
				if (productLoad == 0) {
					$.ajax({
						type: "GET",
						url: "getData",
						data : {
							get : 'Product',
							type : product_type
						},
						dataType: "json",
						success: function(data){
							productLoad = 1;
							listProduct=data;
							$.each(data, function( key, value ) {
								$('#multipleProduct,#multipleProduct2,#multipleProduct3').append("<option value='"+value.id_product+"'>"+value.product+"</option>");
							});
							$('#multipleProduct').prop('required', true)
							$('#multipleProduct').prop('disabled', false)
						}
					});
				} else {
					$('#multipleProduct').prop('required', true)
					$('#multipleProduct').prop('disabled', false)
				}
			} else {
				$('#selectProduct').hide()
			}
		});
		$('input[name=discount_type]').change(function() {
			discount_value = $('input[name=discount_type]:checked').val();
			$('#product-discount-div').show();
			if (discount_value == 'Nominal') {
				$('input[name=discount_value]').removeAttr('max').val('').attr('placeholder', '100.000').inputmask({removeMaskOnSubmit: "true", placeholder: "", alias: "currency", digits: 0, rightAlign: false});
				$('#product-discount-value').text('Discount Nominal');
				$('#product-discount-addon, #product-discount-percent-max-div').hide();
				$('#product-addon-rp').show();
				$('#product-discount-group').addClass('col-md-12');
				$('#product-discount-group').removeClass('col-md-5');
				$('input[name=max_percent_discount]').val('');
			} else {
				$('input[name=discount_value]').attr('max', 100).val('').attr('placeholder', '50').inputmask({
					removeMaskOnSubmit: true,
					placeholder: "",
					alias: 'integer',
					min: '0',
					max: '100',
					allowMinus : false,
					allowPlus : false
				});
				$('#product-discount-value').text('Discount Percent Value');
				$('#product-addon-rp').hide();
				$('#product-discount-addon, #product-discount-percent-max-div').show();
				$('#product-discount-group').addClass('col-md-5');
				$('#product-discount-group').removeClass('col-md-12');
			}
			$('input[name=discount_value]').removeAttr("style");
		});

		$('input[name=discount_global_type]').change(function() {
			discount_value = $('input[name=discount_global_type]:checked').val()
			if (discount_value == 'Nominal') {
				$('input[name=discount_global_value]').removeAttr('max')
			} else {
				$('input[name=discount_global_value]').attr('max', 100)
			}
		});
		
		var is_all_product = '{!!$is_all_product!!}'
		if (is_all_product == 0 && is_all_product.length != 0) {
			$('#productDiscount').show()
			$('#selectProduct').show()
			if (productLoad == 0) {
				$.ajax({
					type: "GET",
					url: "getData",
					data : {
						get : 'Product',
						type : product_type
					},
					dataType: "json",
					success: function(data){
						if (data.status == 'fail') {
							$.ajax(this)
							return
						}
						productLoad = 1;
						listProduct=data;
						$.each(data, function( key, value ) {
							$('#multipleProduct').append("<option id='product"+value.id_product+"' value='"+value.id_product+"'>"+value.product+"</option>");
							$('#multipleProduct2,#multipleProduct3').append("<option value='"+value.id_product+"'>"+value.product+"</option>");
						});
						$('#multipleProduct').prop('required', true)
						$('#multipleProduct').prop('disabled', false)
					},
					complete: function(data){
						if (data.responseJSON.status != 'fail') {
							selectedProduct = JSON.parse('{!!json_encode($product)!!}')
							$.each(selectedProduct, function( key, value ) {
								$("#product"+value+"").attr('selected', true)
							});
						}
					}
				});
			} else {
				$('#multipleProduct').prop('required', true)
				$('#multipleProduct').prop('disabled', false)
			}
		}
		$('button[type="submit"]').on('click',function(){
			changeTriger();
		});
		changeTriger();

		$('.digit_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: 0,
			max: '999999999'
		});

		$('input[name=filter_outlet]').on('click', function(){
			outlet = $(this).val();

			if(outlet == 'Selected') {
				$('#selectOutlet').show();
			}
			else {
				$('#selectOutlet').hide();
			}
		});
	});
	</script>
	@yield('child-script')
	@yield('child-script2')
	@yield('child-script3')
	@yield('warning-image-script')
	@yield('discount-delivery-script')
	@yield('global-requirement-script')
	<style>
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
		-webkit-appearance: none; 
		margin: 0; 
	}
	</style>

	@if( !empty($result['promo_campaign_reports']) && isset($result['step_complete']))
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('#promotype-form').find('input, textarea').prop('disabled', true);
			$('#user-search-form').find('input, textarea').prop('disabled', true);
		});
	</script>
	@endif

	@if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Percent")
	<script>
		$('input[name=discount_value]').attr('placeholder', '50').inputmask({
			removeMaskOnSubmit: true,
			placeholder: "",
			alias: 'integer',
			min: '0',
			max: '100',
			allowMinus : 'false',
			allowPlus : 'false',
			rightAlign: "false"
		});
	</script>
	@else
	<script>
		$('input[name=discount_value]').inputmask({placeholder: "", removeMaskOnSubmit: "true", alias: "currency", digits: 0, rightAlign: false});
	</script>
	@endif
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{('/')}}">Home</a>
			@if (!empty($title))
                <i class="fa fa-circle"></i>
            @endif
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
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="mt-element-step">
			<div class="row step-line">
				<div class="col-md-6 mt-step-col first">
					<a href="{{ ($result['id_promo_campaign'] ?? false) ? url('promo-campaign/step1/'.$result['id_promo_campaign']) : '' }}" class="text-decoration-none">
						<div class="mt-step-number bg-white">1</div>
						<div class="mt-step-title uppercase font-grey-cascade">Campaign Info</div>
						<div class="mt-step-content font-grey-cascade">Campaign Name, Title, Type & Total</div>
					</a>
				</div>
				<div class="col-md-6 mt-step-col active last">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Campaign Detail</div>
					<div class="mt-step-content font-grey-cascade">Detail Campaign Information</div>
				</div>
			</div>
		</div>
	</div>
	<form role="form" action="" method="POST" enctype="multipart/form-data">
		<div class="col-md-12">
			{{-- DETAIL CAMPAIGN INFORMATION --}}
			<div class="col-md-7">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Information</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row static-info">
							<div class="col-md-4 name">Campaign</div>
							<div class="col-md-8 value">: {{ isset($result['campaign_name']) ? $result['campaign_name'] : '' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Campaign Type</div>
							<div class="col-md-8 value">: {{ !empty($result['vouchers']) ? 'Voucher' : 'Promo code' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Tag</div>
							@if(isset($result['promo_campaign_have_tags']))
							@php
								$tagID = [];
								for ($i = 0; $i < count($result['promo_campaign_have_tags']); $i++) {
									$tagID[] = $result['promo_campaign_have_tags'][$i]['promo_campaign_tag']['tag_name'];
								}
							@endphp
							@endif
							<div class="col-md-8 value">: {{implode(', ',$tagID)}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Start Date</div>
							<div class="col-md-8 value">: @if(isset($result['date_start'])) {{date("d F Y", strtotime($result['date_start']))}}&nbsp;{{date("H:i", strtotime($result['date_start']))}} @endif</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">End Date</div>
							<div class="col-md-8 value">: @if(isset($result['date_end'])){{date("d F Y", strtotime($result['date_end']))}}&nbsp;{{date("H:i", strtotime($result['date_end']))}} @endif</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Limit Usage</div>
							<div class="col-md-8 value">: {{ $result['limitation_usage']??false != 0 ? number_format($result['limitation_usage']).' Times Usage' : 'Unlimited'}} </div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Product Type</div>
							<div class="col-md-8 value">: {{ $result['product_type']??'Single'}} </div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Total Coupon</div>
							<div class="col-md-8 value">: {{ isset($result['total_coupon']) ? number_format($result['total_coupon']) : '' }} Coupons</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Type Code</div>
							<div class="col-md-8 value">: {{ isset($result['code_type']) ? $result['code_type'] : '' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Creator</div>
							<div class="col-md-8 value">: {{ isset($result['user']['name']) ? $result['user']['name'] : '' }}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Level</div>
							<div class="col-md-8 value">: {{ isset($result['user']['level']) ? $result['user']['level'] : ''}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-4 name">Created</div>
							<div class="col-md-8 value">: @if(isset($result['created_at'])) {{date("d F Y", strtotime($result['created_at']))}}&nbsp;{{date("H:i", strtotime($result['created_at']))}} @endif</div>
						</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4"></div>
						<div class="col-md-4 value">
							<a class="btn blue col-md-12" href="{{url('/')}}/promo-campaign/step1/{{$result['id_promo_campaign']}}">Edit Promo Campaign Information</a>
						</div>
						<div class="col-md-4"></div>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Filter Promo</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="form-group" style="height: 130px;">
							<label class="control-label">Filter User</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="User yang dapat menggunakan promo code" data-container="body"></i>
							<div class="mt-radio-list">
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code berlaku untuk semua user" data-container="body"></i> All User
									<input type="radio" value="All User" name="filter_user" @if(isset($result['user_type']) && $result['user_type'] == "All user") checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code hanya berlaku untuk user baru yang belum pernah melakukan transaksi" data-container="body"></i> New User
									<input type="radio" value="New User" name="filter_user" @if(isset($result['user_type']) && $result['user_type'] == "New user" ) checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code hanya berlaku untuk user yang memiliki nomor telepon yang dimasukkan" data-container="body"></i> Specific User
									<input type="radio" value="Specific User" name="filter_user" @if(isset($result['user_type']) && $result['user_type'] == "Specific user") checked @endif required/>
									<span></span>
								</label>
							</div>
						</div>
						<div id="specific-user" class="form-group" @if($result['user_type'] != 'Specific user') style="display: none;" @endif>
							<label>Add User</label>
							<textarea class="form-control" rows="3" name="specific_user" placeholder="081xxxxxxxxx, 082xxxxxxxxx, ..." style="resize: vertical;">{{ $result['specific_user'] }}</textarea>
							<p class="help-block">Comma ( , ) separated for multiple phone number</p>
						</div>
						<div class="form-group" style="height: 55px;">
							<label class="control-label">Filter Outlet</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="Outlet yang dapat menggunakan promo code" data-container="body"></i>
							<div class="mt-radio-inline">
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code berlaku di semua outlet" data-container="body"></i> All Outlet
									<input type="radio" value="All Outlet" name="filter_outlet" @if(isset($result['is_all_outlet']) && $result['is_all_outlet'] == "1") checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code hanya berlaku untuk outlet tertentu" data-container="body"></i> Selected Outlet
									<input type="radio" value="Selected" name="filter_outlet" @if(isset($result['is_all_outlet']) && $result['is_all_outlet'] == "0") checked @endif required/>
									<span></span>
								</label>
							</div>
						</div>
						
						<div id="selectOutlet" class="form-group" @if($result['is_all_outlet'] != 1 || empty($result['outlets'])) style="display: none;" @endif>
							<label for="multipleOutlet" class="control-label">Select Outlet</label>
							<select id="multipleOutlet" name="multiple_outlet[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true"></select>
						</div>

					</div>
				</div>
			</div>

			{{-- PROMO TYPE FORM --}}
			<div class="col-md-12">
				
				{{-- Global Requirement --}}
				@yield('warning-image')

				{{-- Global Requirement --}}
				@yield('global-requirement')

				<div class="portlet light bordered" id="promotype-form">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Promo Type</span>
						</div>
					</div>
					<div class="portlet-body" id="tabContainer">
						<input type="hidden" name="product_type" value="{{ $result['product_type'] }}">
						<div class="form-group" style="height: 55px;display: inline;">
							<div class="row">
								<div class="col-md-3">
									<label class="control-label">Promo Type</label>
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe promo
									</br>
									</br> Product Discount : Promo berlaku untuk semua product atau product tertentu tanpa jumlah minimum
									</br>
									</br> Bulk/Tier Product : Promo hanya berlaku untuk suatu product setelah melakukan pembelian dalam jumlah yang telah ditentukan
									</br>
									</br> Buy X get Y : Promo hanya berlaku untuk product tertentu
									</br>
									</br> Promo Product Category: Promo hanya berlaku untuk kategori product tertentu
									</br>
									</br> Discount Delivery : Promo berupa potongan harga untuk biaya pengiriman" 
									data-container="body" data-html="true"></i>
									<select class="form-control" name="promo_type" required>
										<option value="" disabled {{ empty($result['promo_campaign_product_discount_rules']) && empty($result['promo_campaign_tier_discount_rules']) && empty($result['promo_campaign_buyxgety_rules']) ? 'selected' : '' }}> Select Promo Type </option>
										<option value="Product Discount" {{ !empty($result['promo_campaign_product_discount_rules']) ? 'selected' : '' }} title="Promo berlaku untuk semua product atau product tertentu tanpa jumlah minimum"> Product Discount </option>
										<option value="Tier discount" {{ !empty($result['promo_campaign_tier_discount_rules']) ? 'selected' : '' }} title="Promo hanya berlaku untuk suatu product setelah melakukan pembelian dalam jumlah yang telah ditentukan"> Bulk/Tier Product </option>
										<option value="Buy X Get Y" {{ !empty($result['promo_campaign_buyxgety_rules']) ? 'selected' : '' }} title="Promo hanya berlaku untuk product tertentu"> Buy X Get Y </option>
										<option value="Promo Product Category" {{ !empty($result['promo_campaign_productcategory_rules']) ? 'selected' : '' }} title="Promo hanya berlaku untuk kategori product tertentu"> Promo Product Category </option>
										<option value="Discount delivery" 
											@if ( old('promo_type') && old('promo_type') == 'Discount delivery' ) selected 
											@elseif ( !empty($result['promo_campaign_discount_delivery_rules']) ) selected 
											@endif
											title="Promo berupa potongan harga untuk total transaksi / delivery"
											> Discount Delivery </option>
		                            </select>
								</div>
							</div>
						</div>
						<div style="display: inline;">
							<div id="productDiscount" class="p-t-10px"> 
								<div class="form-group">
									<div class="row">
										<div class="col-md-3">
											<label class="control-label">Filter Product</label>
											<span class="required" aria-required="true"> * </span>
											<i class="fa fa-question-circle tooltips" data-original-title="Pilih produk yang akan diberikan diskon </br></br>All Product : Promo code berlaku untuk semua product </br></br>Selected Product : Promo code hanya berlaku untuk product tertentu" data-container="body" data-html="true"></i>
											<select class="form-control" name="filter_product">
												<option value="All Product"  @if(isset($result['promo_campaign_product_discount_rules']['is_all_product']) && $result['promo_campaign_product_discount_rules']['is_all_product'] == "1") selected @endif required> All Product </option>
												<option value="Selected" @if(isset($result['promo_campaign_product_discount_rules']['is_all_product']) && $result['promo_campaign_product_discount_rules']['is_all_product'] == "0") selected @endif> Selected Product </option>
				                            </select>
										</div>
									</div>
								</div>
								<div id="selectProduct" class="form-group row" style="width: 100%!important">
									<div class="">
										<div class="col-md-6">
											<label for="multipleProduct" class="control-label">Select Product</label>
											<select id="multipleProduct" name="multiple_product[]" class="form-control select2 select2-hidden-accessible col-md-6" multiple="" tabindex="-1" aria-hidden="true" style="width: 100%!important" @if(isset($result['promo_campaign_product_discount_rules']['is_all_product']) && $result['promo_campaign_product_discount_rules']['is_all_product'] == "0") required @endif>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label">Max product discount per transaction</label>
									<i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal masing-masing produk yang dapat dikenakan diskon dalam satu transaksi </br></br>Note : isi dengan 0 jika jumlah maksimal produk tidak dibatasi" data-container="body" data-html="true"></i>
									<div class="row">
										<div class="col-md-2">
											
											<input type="text" class="form-control text-center digit_mask" name="max_product" placeholder="" @if(isset($result['promo_campaign_product_discount_rules']['max_product']) && $result['promo_campaign_product_discount_rules']['max_product'] != "") value="{{$result['promo_campaign_product_discount_rules']['max_product']}}" @elseif(old('max_product') != "") value="{{old('max_product')}}" @endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
											
										</div>
									</div>
								</div>
								<div class="form-group" style="height: 90px;">
									<label class="control-label">Discount Type</label>
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Pilih jenis diskon untuk produk </br></br>Nominal : Diskon berupa potongan nominal, jika total diskon melebihi harga produk akan dikembalikan ke harga produk </br></br>Percent : Diskon berupa potongan persen" data-container="body" data-html="true"></i>
									<div class="mt-radio-list">
										<label class="mt-radio mt-radio-outline"> Nominal
											<input type="radio" value="Nominal" name="discount_type" @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Nominal") checked @endif required/>
											<span></span>
										</label>
										<label class="mt-radio mt-radio-outline"> Percent
											<input type="radio" value="Percent" name="discount_type" @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Percent") checked @endif required/>
											<span></span>
										</label>
									</div>
								</div>
								<div class="form-group" id="product-discount-div" @if(empty($result['promo_campaign_product_discount_rules'])) style="display: none;" @endif >
									<div class="row">
										<div class="col-md-3">
											<label class="control-label" id="product-discount-value">Discount Value</label>
											<span class="required" aria-required="true"> * </span>
											<i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon yang diberikan. Persentase akan dihitung dari harga produk + harga modifier" data-container="body"></i>
											<div class="input-group @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Percent") col-md-5 @else col-md-12 @endif" id="product-discount-group">
												<div class="input-group-addon" id="product-addon-rp" @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Percent") style="display: none;" @endif>IDR</div>
												<input required type="text" class="form-control text-center" name="discount_value" placeholder="" @if(isset($result['promo_campaign_product_discount_rules']['discount_value']) && $result['promo_campaign_product_discount_rules']['discount_value'] != "") value="{{$result['promo_campaign_product_discount_rules']['discount_value']}}" @elseif(old('discount_value') != "") value="{{old('discount_value')}}" @endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
												<div class="input-group-addon" id="product-discount-addon" @if(isset($result['promo_campaign_product_discount_rules']['discount_type']) && $result['promo_campaign_product_discount_rules']['discount_type'] == "Nominal") style="display: none;" @endif>%</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group" id="product-discount-percent-max-div" style="{{ ($result['promo_campaign_product_discount_rules']['discount_type']??false) == "Percent" ? '' : "display: none" }}">
									<div class="row">
										<div class="col-md-3">
											<label class="control-label" id="product-discount-value">Max Percent Discount</label>
											<i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon maksimal yang bisa didapatkan ketika menggunakan promo. Kosongkan jika maksimal persen mengikuti harga produk " data-container="body"></i>
											<div class="input-group col-md-12">

												<div class="input-group-addon">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}}</div>

												<input type="text" class="form-control text-center digit_mask" name="max_percent_discount" placeholder="" value="{{$result['promo_campaign_product_discount_rules']['max_percent_discount']}}" min="0" oninput="validity.valid||(value='');" autocomplete="off">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="bulkProduct" class="p-t-10px">
								@yield('bulkForm')
							</div>
							<div id="buyXgetYProduct" class="p-t-10px">
								@yield('buyXgetYForm')
							</div>
							<div id="promoProductCategory" class="p-t-10px">
								@yield('promoProductCategoryForm')
							</div>
							<div id="discount-delivery" class="p-t-10px">
								@yield('discount-delivery')
							</div>
						</div>
					</div>
				</div>
			</div>
			@if( empty($result['promo_campaign_reports']) || empty($result['step_complete']) )
			<div class="col-md-12" style="text-align:center;">
				<div class="form-actions">
					{{ csrf_field() }}
					<button type="submit" class="btn blue"> Save </button>
				</div>
			</div>
			@else
			<div class="col-md-12" style="text-align:center;">
				<div class="form-actions">
					<a href="{{ ($result['id_promo_campaign'] ?? false) ? url('promo-campaign/detail/'.$result['id_promo_campaign']) : '' }}" class="btn blue">Detail</a>
				</div>
			</div>
			@endif
		</div>
	</form>
</div>
@endsection