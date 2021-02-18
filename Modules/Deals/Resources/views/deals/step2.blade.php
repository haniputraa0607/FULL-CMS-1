<?php
	use App\Lib\MyHelper;
    $configs    		= session('configs');
 ?>
@extends('layouts.main-closed')
@include('deals::deals.tier-discount')
@include('deals::deals.buyxgety-discount')
@include('promocampaign::template.discount-delivery', ['promo_source' => $deals_type])
{{-- @include('promocampaign::template.promo-global-requirement', ['promo_source' => $deals_type]) --}}
@section('page-style')
	<link href="{{ secure_url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ secure_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
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
	<script src="{{ secure_url('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ secure_url('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/pages/scripts/table-datatables-buttons.js') }}" type="text/javascript"></script>
	
	@php
		$is_all_product 	= null;
		$product 			= null;
		$is_all_outlet 		= null;
		$outlet			 	= null;

		if (isset($result['deals_product_discount_rules']['is_all_product']) && $result['deals_product_discount_rules']['is_all_product'] == "0") {
			$is_all_product = $result['deals_product_discount_rules']['is_all_product'];
			$product = [];
			for ($i=0; $i < count($result['deals_product_discount']); $i++) { 
				$product[] = $result['deals_product_discount'][$i]['id_product'];
			}
		}

		$datenow = date("Y-m-d H:i:s");
		if ($result??false) {
            $date_start = $result['deals_start'];
            $date_end   = $result['deals_end'];
        }elseif($result['vouchers']??false){
            $date_start = $result['deals_publish_start'];
            $date_end   = $result['deals_publish_end'];
        }else{
            $date_start = null;
            $date_end   = null;
        }
	@endphp
	<script>
	$(document).ready(function() {
		listProduct=[];
		listProductSingle=[];
		productLoad = 0;
		product_type = '{!! $result['product_type']??'single' !!}';
		brand = '{!!$result['id_brand']!!}';

		$.ajax({
			type: "GET",
			url: "{{url('promo-campaign/step2/getData')}}",
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
			}
		});

		$('#selectProduct').hide()
		function loadProduct(selector,callback){
			if (productLoad == 0) {
				var valuee=$(selector).data('value');
				$.ajax({
					type: "GET",
					url: "{{url('promo-campaign/step2/getData')}}",
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
		function changeTriger () {
			$('#tabContainer .tabContent').hide();
			promo_type = $('select[name=promo_type] option:selected').val();
			// $('#tabContainer input:not(input[name="promo_type"]),#tabContainer select').prop('disabled',true);
			$('#productDiscount, #bulkProduct, #buyXgetYProduct, #discount-delivery').hide().find('input, textarea, select').prop('disabled', true);

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
						url: "{{url('promo-campaign/step2/getData')}}",
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
					url: "{{url('promo-campaign/step2/getData')}}",
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

		$('input[name=deals_promo_id_type]').click(function() {
			nilai = $('input[name=deals_promo_id_type]:checked').val()
            $('.dealsPromoTypeShow').show();

            $('input[name=deals_promo_id_promoid]').val('');
            $('input[name=deals_promo_id_nominal]').val('');

            console.log(nilai);
            if (nilai == "promoid") {
            	console.log(1);
                $('input[name=deals_promo_id_promoid]').show().prop('required', true);
                $('#promoid-inputgroup').hide().prop('required', true);

                $('input[name=deals_promo_id_nominal]').hide().removeAttr('required', true);
            }
            else {
            	console.log(0);
                $('input[name=deals_promo_id_nominal]').show().prop('required', true);
                $('#promoid-inputgroup').show().prop('required', true);

                $('input[name=deals_promo_id_promoid]').hide().removeAttr('required', true);
            }
        });

		$(".file-image").change(function(e) {
			var widthImg  = 100;
			var heightImg = 100;

			var _URL = window.URL || window.webkitURL;
			var image, file;

			if ((file = this.files[0])) {
				image = new Image();

				image.onload = function() {
					if ( this.width == widthImg && this.height == heightImg ) {
						$('#use_global').prop('checked',false);
					}
					else {
						$('#use_global').prop('checked',true);
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
	});
	</script>
	@yield('child-script')
	@yield('child-script2')
	@yield('discount-delivery-script')
	@yield('global-requirement-script')
	<style>
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
		-webkit-appearance: none; 
		margin: 0; 
	}
	</style>

	@if( strtotime($datenow) > strtotime($date_start) && isset($result['campaign_complete']))
	<script type="text/javascript">
		$(document).ready(function() {
			console.log('ok');
			$('#promotype-form').find('input, textarea').prop('disabled', true);
			$('#user-search-form').find('input, textarea').prop('disabled', true);
		});
	</script>
	@endif

	@if(isset($result['deals_product_discount_rules']['discount_type']) && $result['deals_product_discount_rules']['discount_type'] == "Percent")
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

    {{-- PROMO TYPE FORM --}}
	<form role="form" action="" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="product_type" value="{{ $result['product_type']??'single' }}">
	<input type="hidden" name="deals_type" value="{{ $result['deals_type']??$deals_type??'' }}">
	<div class="portlet light bordered" id="promotype-form">
		<div class="col-md-12">
            <div class="mt-element-step">
                <div class="row step-line">
                    <div id="step-online">
	                    <div class="col-md-4 mt-step-col first">
	                        <div class="mt-step-number bg-white">1</div>
	                        <div class="mt-step-title uppercase font-grey-cascade">Info</div>
	                        <div class="mt-step-content font-grey-cascade">Title, Image, Periode</div>
	                    </div>
	                    <div class="col-md-4 mt-step-col active">
	                        <div class="mt-step-number bg-white">2</div>
	                        <div class="mt-step-title uppercase font-grey-cascade">Rule</div>
	                        <div class="mt-step-content font-grey-cascade">discount rule</div>
	                    </div>
	                    <div class="col-md-4 mt-step-col last">
		                    <div class="mt-step-number bg-white">3</div>
		                    <div class="mt-step-title uppercase font-grey-cascade">Content</div>
		                    <div class="mt-step-content font-grey-cascade">Detail Content Deals</div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="portlet-title">
			<div class="caption font-blue ">
				<span class="caption-subject bold uppercase">{{ $result['deals_title'] }}</span>
			</div>
		</div>
		{{-- WARNING IMAGE RULE --}}
		@if( ($result['is_online']??false) == 1)
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<span class="caption-subject bold uppercase">{{ 'Warning Image' }}</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="fileinput fileinput-new col-md-6" data-provides="fileinput">
								<div class="mt-checkbox-inline">
	                                <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
	                                    <input type="checkbox" id="use_global" name="use_global" value="1" 
	                                    @if ( old('use_global') == "1" || empty($result['deals_warning_image']) )
	                                        checked 
	                                    @endif> Use GLobal
	                                	<i class="fa fa-question-circle tooltips" data-original-title="Gambar warning akan menggunakan gambar promo warning global. Gambar yang sudah disimpan pada deals ini akan dihapus" data-container="body"></i>
	                                    <span></span>
	                                </label>
	                            </div>
								<label class="control-label">Image
	                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan ketika ada peringatan error pada penggunaan voucher, jika tidak diisi maka akan menggunakan gambar promo warning global" data-container="body"></i>
									<br>
									<span class="required" aria-required="true"> (100 * 100) (PNG Only) </span>
								</label><br>
								<div class="fileinput-new thumbnail">
									@if(!empty($result['deals_warning_image']) || !empty($warning_image))
										<img src="{{ env('S3_URL_API').($result['deals_warning_image']??$warning_image) }}" alt="">
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
							<div class="preview col-md-6 pull-right" style="right: 0;top: 70px; position: sticky">
				                <img id="img_preview" src="{{env('S3_URL_VIEW')}}img/setting/warning_image_preview.png" class="img-responsive">
				            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	    @endif
	    {{-- END OF WARNING IMAGE RULE --}}

		{{-- OFFLINE RULE --}}
		@if( ($result['is_offline']??false) == 1)
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<span class="caption-subject bold uppercase">{{ 'Voucher Offline Rules' }}</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="form-group" style="height: 90px;">
					<label class="control-label">Promo Type</label>
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Tipe promosi berdasarkan Promo ID atau nominal promo" data-container="body" data-html="true"></i>
					<div class="mt-radio-list">
						<label class="mt-radio mt-radio-outline dealsPromoType"> Promo ID
							<input type="radio" name="deals_promo_id_type" value="promoid" required @if ($result['deals_promo_id_type'] == "promoid") checked @endif>
							<span></span>
						</label>
						<label class="mt-radio mt-radio-outline dealsPromoType"> Nominal
							<input type="radio" id="radio16" name="deals_promo_id_type" class="md-radiobtn dealsPromoType" value="nominal" required @if ($result['deals_promo_id_type'] == "nominal") checked @endif>
							<span></span>
						</label>
					</div>
				</div>
				<div class="form-group dealsPromoTypeShow" @if (empty($result['deals_promo_id'])) style="display: none;" @endif>
					<div class="row">
	                    <div class="col-md-3">
	                    	<div class="input-group col-md-12" id="offline-input">
	                    		<div class="input-group-addon" id="promoid-inputgroup" @if ($result['deals_promo_id_type'] == "promoid") style="display: none;" @endif>{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}}</div>
		                        <input type="text" class="form-control" name="deals_promo_id_promoid" value="{{ $result['deals_promo_id']??'' }}" placeholder="Input Promo ID" @if ($result['deals_promo_id_type'] == "nominal") style="display: none;" @endif style="text-align: center!important;" autocomplete="off">

		                        <input type="text" class="form-control digit_mask" name="deals_promo_id_nominal" value="{{ $result['deals_promo_id']??'' }}" placeholder="Input nominal" @if ($result['deals_promo_id_type'] == "promoid") style="display: none;" @endif style="text-align: center!important;" autocomplete="off">
	                    	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	    @endif
	    {{-- END OF OFFLINE RULE --}}

	    {{-- ONLINE RULE --}}
        @if( ($result['is_online']??false) == 1)

        	{{-- Global Requirement --}}
			@yield('global-requirement')
			
	        <div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<span class="caption-subject bold uppercase">{{ 'Voucher Online Rules' }}</span>
					</div>
				</div>
				<div class="portlet-body" id="tabContainer">
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
								</br> Buy X get Y : Promo hanya berlaku untuk product tertentu" data-container="body" data-html="true"></i>
								<select class="form-control" name="promo_type" required>
									<option value="" disabled {{ 
										( 	empty($result['deals_product_discount_rules']) && 
											empty($result['deals_tier_discount_rules']) && 
											empty($result['deals_buyxgety_rules']) 
										) ||
										( 	empty($result['deals_promotion_product_discount_rules']) && 
											empty($result['deals_promotion_tier_discount_rules']) && 
											empty($result['deals_promotion_buyxgety_rules']) )
										? 'selected' : '' 
									}}> Select Promo Type </option>
									<option value="Product Discount" {{ 
										!empty($result['deals_product_discount_rules']) || 
										!empty($result['deals_promotion_product_discount_rules']) 
										? 'selected' : '' 
									}} title="Promo berlaku untuk semua product atau product tertentu tanpa jumlah minimum"> Product Discount </option>
									<option value="Tier discount" {{ 
										!empty($result['deals_tier_discount_rules']) ||
										!empty($result['deals_promotion_tier_discount_rules'])
										? 'selected' : '' 
									}} title="Promo hanya berlaku untuk suatu product setelah melakukan pembelian dalam jumlah yang telah ditentukan"> Bulk/Tier Product </option>
									<option value="Buy X Get Y" {{ 
										!empty($result['deals_buyxgety_rules']) || 
										!empty($result['deals_promotion_buyxgety_rules']) 
										? 'selected' : '' 
									}} title="Promo hanya berlaku untuk product tertentu"> Buy X Get Y </option>
									<option value="Discount delivery" 
										@if ( old('promo_type') && old('promo_type') == 'Discount delivery' ) selected 
										@elseif ( !empty($result['deals_discount_delivery_rules']) || !empty($result['deals_promotion_discount_delivery_rules']) ) selected 
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
											<option value="All Product"  
												@if(
													(	isset($result['deals_product_discount_rules']['is_all_product']) && 
														$result['deals_product_discount_rules']['is_all_product'] == "1" ) ||
													(	isset($result['deals_promotion_product_discount_rules']['is_all_product']) && 
														$result['deals_promotion_product_discount_rules']['is_all_product'] == "1" )
													) selected 
												@endif required> All Product </option>
											<option value="Selected" 
												@if( 
													(	isset($result['deals_product_discount_rules']['is_all_product']) && 
														$result['deals_product_discount_rules']['is_all_product'] == "0" ) ||
													(	isset($result['deals_promotion_product_discount_rules']['is_all_product']) && 
														$result['deals_promotion_product_discount_rules']['is_all_product'] == "0") 
													) selected 
												@endif> Selected Product </option>
			                            </select>
									</div>
								</div>
							</div>
							<div id="selectProduct" class="form-group row" style="width: 100%!important">
								<div class="">
									<div class="col-md-6">
										<label for="multipleProduct" class="control-label">Select Product</label>
										<select id="multipleProduct" name="multiple_product[]" class="form-control select2 select2-hidden-accessible col-md-6" multiple="" tabindex="-1" aria-hidden="true" style="width: 100%!important" 
											@if( 
												(	isset($result['deals_product_discount_rules']['is_all_product']) && 
													$result['deals_product_discount_rules']['is_all_product'] == "0" ) ||
												(	isset($result['deals_promotion_product_discount_rules']['is_all_product']) && 
													$result['deals_promotion_product_discount_rules']['is_all_product'] == "0" )
												) required 
											@endif>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Max product discount per transaction</label>
								<i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal masing-masing produk yang dapat dikenakan diskon dalam satu transaksi </br></br>Note : Kosongkan jika jumlah maksimal produk tidak dibatasi" data-container="body" data-html="true"></i>
								<div class="row">
									<div class="col-md-2">
										
										<input type="text" class="form-control text-center digit_mask" name="max_product" placeholder="" 
											@if(
												( 	isset($result['deals_product_discount_rules']['max_product']) && 
													$result['deals_product_discount_rules']['max_product'] != "" ) ||
												( 	isset($result['deals_promotion_product_discount_rules']['max_product']) && 
													$result['deals_promotion_product_discount_rules']['max_product'] != "" )
												) value="{{$result['deals_product_discount_rules']['max_product']??$result['deals_promotion_product_discount_rules']['max_product']}}" 
											@elseif(old('max_product') != "") value="{{old('max_product')}}" 
											@endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
										
									</div>
								</div>
							</div>
							<div class="form-group" style="height: 90px;">
								<label class="control-label">Discount Type</label>
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Pilih jenis diskon untuk produk </br></br>Nominal : Diskon berupa potongan nominal, jika total diskon melebihi harga produk akan dikembalikan ke harga produk </br></br>Percent : Diskon berupa potongan persen" data-container="body" data-html="true"></i>
								<div class="mt-radio-list">
									<label class="mt-radio mt-radio-outline"> Nominal
										<input type="radio" value="Nominal" name="discount_type" 
											@if(
												(	isset($result['deals_product_discount_rules']['discount_type']) && 
													$result['deals_product_discount_rules']['discount_type'] == "Nominal" ) ||
												(	isset($result['deals_promotion_product_discount_rules']['discount_type']) && 
													$result['deals_promotion_product_discount_rules']['discount_type'] == "Nominal" )
												) checked 
											@endif required/>
										<span></span>
									</label>
									<label class="mt-radio mt-radio-outline"> Percent
										<input type="radio" value="Percent" name="discount_type" 
											@if(
												(	isset($result['deals_product_discount_rules']['discount_type']) && 
													$result['deals_product_discount_rules']['discount_type'] == "Percent" ) || 
												(	isset($result['deals_promotion_product_discount_rules']['discount_type']) && 
													$result['deals_promotion_product_discount_rules']['discount_type'] == "Percent")
												) checked 
											@endif required/>
										<span></span>
									</label>
								</div>
							</div>
							<div class="form-group" id="product-discount-div" 
								@if(!empty($result['deals_product_discount_rules']) || 
									!empty($result['deals_promotion_product_discount_rules']))
								@else style="display: none;" 
								@endif >
								<div class="row">
									<div class="col-md-3">
										<label class="control-label" id="product-discount-value">Discount Value</label>
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon yang diberikan. Persentase akan dihitung dari harga produk + harga modifier" data-container="body"></i>
										<div class="input-group 
											@if(
												(	isset($result['deals_product_discount_rules']['discount_type']) && 
													$result['deals_product_discount_rules']['discount_type'] == "Percent" ) ||
												(	isset($result['deals_promotion_product_discount_rules']['discount_type']) && 
													$result['deals_promotion_product_discount_rules']['discount_type'] == "Percent" )
												) col-md-5 
											@else col-md-12 
											@endif" id="product-discount-group">
											<div class="input-group-addon" id="product-addon-rp" 
												@if(
													(	isset($result['deals_product_discount_rules']['discount_type']) && 
														$result['deals_product_discount_rules']['discount_type'] == "Percent" ) ||
													(	isset($result['deals_promotion_product_discount_rules']['discount_type']) && 
														$result['deals_promotion_product_discount_rules']['discount_type'] == "Percent" )
													) style="display: none;" 
												@endif>{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}}</div>
											<input required type="text" class="form-control text-center" name="discount_value" placeholder="" 
												@if(
													(	isset($result['deals_product_discount_rules']['discount_value']) && 
														$result['deals_product_discount_rules']['discount_value'] != "" ) ||
													(	isset($result['deals_promotion_product_discount_rules']['discount_value']) && 
														$result['deals_promotion_product_discount_rules']['discount_value'] != "" )
													) value="{{ $result['deals_product_discount_rules']['discount_value']??$result['deals_promotion_product_discount_rules']['discount_value'] }}" 
												@elseif(old('discount_value') != "") value="{{old('discount_value')}}" 
												@endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
											<div class="input-group-addon" id="product-discount-addon" 
												@if( 
													(	isset($result['deals_product_discount_rules']['discount_type']) && 
														$result['deals_product_discount_rules']['discount_type'] == "Nominal" ) ||
													(	isset($result['deals_promotion_product_discount_rules']['discount_type']) && 
														$result['deals_promotion_product_discount_rules']['discount_type'] == "Nominal" )
												) style="display: none;" 
												@endif>%</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group" id="product-discount-percent-max-div" style="{{ ($result['deals_product_discount_rules']['discount_type']??$result['deals_promotion_product_discount_rules']['discount_type']??false) == "Percent" ? '' : "display: none" }}">
								<div class="row">
									<div class="col-md-3">
										<label class="control-label" id="product-discount-value">Max Percent Discount</label>
										<i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon maksimal yang bisa didapatkan ketika menggunakan promo. </br></br>Note : Kosongkan jika maksimal persen mengikuti harga produk " data-container="body" data-html="true"></i>
										<div class="input-group col-md-12">

											<div class="input-group-addon">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}}</div>

											<input type="text" class="form-control text-center digit_mask" name="max_percent_discount" placeholder="" value="{{ $result['deals_product_discount_rules']['max_percent_discount']??$result['deals_promotion_product_discount_rules']['max_percent_discount']??'' }}" min="0" oninput="validity.valid||(value='');" autocomplete="off">
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
						<div id="discount-delivery" class="p-t-10px">
							@yield('discount-delivery')
						</div>
					</div>
				</div>
			</div>
		@endif
		{{-- END OF ONLINE RULE --}}

		<div class="" style="height: 40px;">
			@if( ($result['deals_total_claimed']??false) == 0 || $deals_type == 'Promotion')
			<div class="col-md-12" style="text-align:center;">
				<div class="form-actions">
					{{ csrf_field() }}
					<button type="submit" class="btn blue"> Save </button>
				</div>
			</div>
			@else
			<div class="col-md-12" style="text-align:center;">
				<div class="form-actions">
					<a href="{{ ($result['id_deals'] ?? false) ? url('deals/detail/'.$result['id_deals']) : '' }}" class="btn blue">Detail</a>
				</div>
			</div>
			@endif
		</div>	
	</div>

	</form>


@endsection