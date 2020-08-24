<?php
	use App\Lib\MyHelper;
	$configs  = session('configs');
	date_default_timezone_set('Asia/Jakarta');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    @php
    	$outlet 	= [];
		$product 	= [];
    	$promo 		= $data['promo_reference']??null;
    	if (isset($data['outlet_type']) && $data['outlet_type'] == "specific") {
			$outlet_type = $data['outlet_type'];
			$outlet = [];
			for ($i=0; $i < count($data['outlets']); $i++) { 
				$outlet[] = $data['outlets'][$i]['id_outlet'];
			}
		}
		if (!empty($data['products'])) {
			foreach ($data['products'] as $value) {
				$product[] = [
					'id' => $value['id_product'],
					'qty' => $value['pivot']['qty']
				];
			}
		}
    @endphp

    <script type="text/javascript">

    	var ajax_product_data = [];
    	var token  = "{{ csrf_token() }}";
    	var brand = [];
    	var product = JSON.parse('{!!json_encode($product)!!}');
    	var promo = JSON.parse('{!!json_encode($promo)!!}');
    	var outlet = JSON.parse('{!!json_encode($outlet)!!}');

    	function addProduct(selected_product = null, qty = null) {
			let count 	= $('#data-product > div').length;
			let id 		= count;
			let result 	= id+1;
			let selected = '';
			let qty_val = qty ?? '';
			let product_option = '';
			$.each(ajax_product_data, function( key, value ) {
				selected = '';
				if (selected_product && value.id_product == selected_product) {
					selected = 'selected';
				}

				product_option += "<option id='product"+value.id_product+"' value='"+value.id_brand+"-"+value.id_product+"' "+selected+">"+value.product+"</option>";
			});

			var listDetail = '\
		    <div class="product'+result+'" style="padding-bottom: 50px;">\
		        <div data-repeater-item class="mt-overflow">\
		            <div class="mt-repeater-cell">\
		                <div class="col-md-9" style="padding-left: 0px; padding-right: 0px">\
							<select name="product['+count+'][id]" class="form-control product-selector select2" id="select-product'+result+'" placeholder="Select product" style="width: 100%!important" onChange="updateProductValue()">';
			listDetail +=  product_option;
			listDetail +=  '</select>\
						</div>\
						<div class="col-md-2" style="padding-left: 15px; padding-right: 0px">\
							<input type="text" class="form-control text-center qty_mask" min="1" name="product['+count+'][qty]" value="'+qty_val+'" required autocomplete="off">\
						</div>\
						<div class="col-md-1">\
		                    <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="delProduct('+result+')">\
		                        <i class="fa fa-close"></i>\
		                    </a>\
		                </div>\
		            </div>\
		        </div>\
		    </div>';

			$('#data-product').append(listDetail).fadeIn(3000);
			$('#select-product'+result).select2({
		      placeholder: "Select Product",
		      allowClear: true
		    });
		}

		function delProduct(no) {
			$('.product'+no).remove();
		}

		function loadOutlet(){
			$.ajax({
				type: "post",
				url: "{{url('redirect-complex/get-data')}}",
				data : {
					"get" 	: 'Outlet',
					"brand" : brand,
					"_token" : token
				},
				dataType: "json",
				success: function(data){
					removeChildElement('select-outlet');
					if (data.status == 'fail') {
						$.ajax(this)
						return
					}
					listOutlet=data;
					$.each(data, function( key, value ) {
						$('#select-outlet').append("<option id='outlet"+value.id_outlet+"' value='"+value.id_outlet+"'>"+value.outlet+"</option>");
					});

				},
				complete: function(data){
					if (data.responseJSON.status != 'fail') {
						
						$.each(outlet, function( key, value ) {
							$("#outlet"+value+"").attr('selected', true)
						});
					}
				}
			});
		}

		function loadProduct(){
			$.ajax({
				type: "POST",
				url: "{{url('redirect-complex/get-data')}}",
				data : {
					"get" : 'Product',
					"type" : 'Single',
					"brand": brand,
					"_token" : token
				},
				dataType: "json",
				success: function(data){
					removeChildElement('data-product');
					if (data.status == 'fail') {
						$.ajax(this)
						return
					}
					ajax_product_data = data;

					$.each(product, function( key, value ) {
						addProduct(value['id'], value['qty']);
					});
				}
			});
		}

		function loadPromo(){
			$.ajax({
				type: "POST",
				url: "{{url('redirect-complex/get-data')}}",
				data : {
					"get" 	: 'promo',
					"type" 	: 'promo_campaign',
					"brand" : brand,
					"outlet" : outlet,
					"product" : product,
					"_token" : token
				},
				dataType: "json",
				success: function(data){
					removeChildElement('select-promo');
					if (data.status == 'fail') {
						$.ajax(this)
						return
					}
					let selected = '';
					$('#select-promo').append("<option id='promo0' value='0'> Not Using Promo</option>");
					$.each(data, function( key, value ) {
						selected = '';
						if (promo && value.id_promo == promo) {
							selected = 'selected';
						}
						$('#select-promo').append("<option id='promo"+value.id_promo+"' value='"+value.id_promo+"' "+selected+">"+value.promo+"</option>");
					});
				}
			});
		}

		function removeChildElement(id) {
			const parent_element = document.getElementById(id);
			while (parent_element.firstChild) {
				parent_element.removeChild(parent_element.lastChild);
			}
		}

		function updateProductValue() {
			let temp_product = $('#data-product select').serializeArray();
			product = [];
			$.each(temp_product, function( key, value ) {
				product.push(value.value);
			});
			//loadPromo();
		}

		function updateOutletValue() {
			outlet = $('#select-outlet').val();
			loadPromo();
		}

        $(document).ready(function() {
			loadProduct();
	    	loadOutlet();
	    	loadPromo();

	    	$("#form-outlet, #form-product, #form-promo").hide();
	        $('input[name=outlet_type]').on('click', function(){
				outlet_type = $(this).val();

				if(outlet_type == 'specific') {
					$('#selectOutlet').show();
				}
				else {
					$('#selectOutlet').hide();
					outlet = null;
				}
				loadPromo();
			});

			$('#select-brand').on('change', function(){
				brand = $(this).val();
				loadOutlet();
				loadProduct();
				loadPromo();

				if (brand != null && brand.length > 0) {
					$("#form-outlet, #form-product, #form-promo").show();
				}
				else {
					$("#form-outlet, #form-product, #form-promo").hide();
				}
			});
	    	$("#select-brand").change();
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
                <span>{{$title}}</span>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $sub_title }}</span>
            </li>
        </ul>
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">New Redirect Complex</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
            	<input type="hidden" name="id_redirect_complex_reference" value="{{ $data['id_redirect_complex_reference']??null }}">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Redirect Complex Name" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Redirect Complex Name" class="form-control" name="name" value="{{ old('name')??$data['name']??null }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    @if(MyHelper::hasAccess([97], $configs))
	                    <div class="form-group" id="form-brand" >
	                        <label class="col-md-3 control-label">Select Brand
	                        	<span class="required" aria-required="true"> * </span>
	                            <i class="fa fa-question-circle tooltips" data-original-title="Select Brand" data-container="body"></i>
	                        </label>
	                        <div class="col-md-7">
								<select id="select-brand" name="brand[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true">
									<option></option>
									@php
										$selected_brand = [];
										if (old('brand')) {
											$selected_brand = old('brand');
										}
										elseif (!empty($data['brands'])) {
											$selected_brand = array_column($data['brands'], 'id_brand');
										}
									@endphp
	                                @if (!empty($brand_list))
	                                    @foreach($brand_list as $brand)
	                                        <option value="{{ $brand['id_brand'] }}" 
	                                        	@if ( $selected_brand??false ) 
	                                        		@if( in_array($brand['id_brand'], $selected_brand) ) selected 
	                                        		@endif 
	                                        	@endif
	                                        >{{ $brand['name_brand'] }}</option>
	                                    @endforeach
	                                @endif
								</select>
	                        </div>
	                    </div>
	                @endif
	                <div id="form-outlet">
	                    <div class="form-group">
	                    	<label class="col-md-3 control-label">Outlet Type
	                            <span class="required" aria-required="true"> * </span>
	                            <i class="fa fa-question-circle tooltips" data-original-title="Type of method to get outlet" data-container="body"></i>
	                        </label>
	                        <div class="col-md-7" style="margin-bottom: -20px">
								<div class="mt-radio-inline">
									<label class="mt-radio mt-radio-outline">
										<i class="fa fa-question-circle tooltips" data-original-title="near me" data-container="body"></i> Near Me
										<input type="radio" value="near me" name="outlet_type" 
										@if ( old('outlet_type') )
											@if( old('outlet_type') == "near me") checked @endif
										@elseif ( isset($data['outlet_type']) && $data['outlet_type'] == "near me") checked 
										@endif 
										required/>
										<span></span>
									</label>
									<label class="mt-radio mt-radio-outline">
										<i class="fa fa-question-circle tooltips" data-original-title="Promo code hanya berlaku untuk outlet tertentu" data-container="body"></i> Specific
										<input type="radio" value="specific" name="outlet_type" 
										@if ( old('outlet_type') )
											@if( old('outlet_type') == "specific") checked @endif
										@elseif ( isset($data['outlet_type']) && $data['outlet_type'] == "specific") checked 
										@endif 
										required/>
										<span></span>
									</label>
								</div>
	                        </div>
						</div>
						<div class="form-group" id="selectOutlet" @if((old('outlet_type')??$data['outlet_type']??true) == 'near me')) style="display: none;" @endif>
	                        <label class="col-md-3 control-label">Select Outlet
	                        	<span class="required" aria-required="true"> * </span>
	                            <i class="fa fa-question-circle tooltips" data-original-title="Select outlet" data-container="body"></i>
	                        </label>
	                        <div class="col-md-7">
								<select id="select-outlet" name="outlet[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true" onchange="updateOutletValue()"></select>
	                        </div>
	                    </div>
	                </div>
                    <div class="form-group" id="form-product">
                        <label class="col-md-3 control-label">Product </label>
                        <div class="col-md-7">
                        	<div id="data-product" style="padding-right: 15px">
                        	</div>
                        	<a href="javascript:;" data-repeater-create class="btn btn-success" onclick="addProduct();updateProductValue()"><i class="fa fa-plus"></i> New Product</a>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="form-promo">
					<label class="col-md-3 control-label">Promo Code </label>
					<div class="col-md-4">
						<select id="select-promo" name="promo" class="form-control select2">
							<option value="0">Not using Promo</option>
						</select>
					</div>
				</div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection