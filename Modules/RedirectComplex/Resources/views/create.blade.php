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
    $outlet = [];
    	if (isset($data['outlet_type']) && $data['outlet_type'] == "specific") {
			$outlet_type = $data['outlet_type'];
			$outlet = [];
			for ($i=0; $i < count($data['outlets']); $i++) { 
				$outlet[] = $data['outlets'][$i]['id_outlet'];
			}
		}
    @endphp

    <script type="text/javascript">

    	var product_option = '';

    	function addProduct() {
			var count = $('#data-product > div').length;
			var id = count;
			var result = id+1;
			
			var listDetail = '\
		    <div class="product'+result+'" style="padding-bottom: 50px;">\
		        <div data-repeater-item class="mt-overflow">\
		            <div class="mt-repeater-cell">\
		                <div class="col-md-9" style="padding-left: 0px; padding-right: 0px">\
							<select name="product['+count+'][id]" class="form-control product-selector select2" id="select-product'+result+'" placeholder="Select product" style="width: 100%!important">';
			listDetail +=  product_option;
			listDetail +=  '</select>\
						</div>\
						<div class="col-md-2" style="padding-left: 15px; padding-right: 0px">\
							<input type="text" class="form-control text-center qty_mask" min="1" name="product['+count+'][qty]" value="" required autocomplete="off">\
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
				type: "GET",
				url: "{{url('promo-campaign/step2/getData')}}",
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
						$('#specific-outlet').append("<option id='outlet"+value.id_outlet+"' value='"+value.id_outlet+"'>"+value.outlet+"</option>");
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
		}

		function loadProduct(){
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
					$.each(data, function( key, value ) {
						product_option += "<option id='product"+value.id_product+"' value='"+value.id_product+"'>"+value.product+"</option>";
					});
				}
			});
		}

		function loadPromo(){
			$.ajax({
				type: "GET",
				url: "{{url('promo-campaign/step2/getData')}}",
				data : {
					get : 'promo',
					type : 'promo_campaign'
				},
				dataType: "json",
				success: function(data){
					if (data.status == 'fail') {
						$.ajax(this)
						return
					}
					$.each(data, function( key, value ) {
						$('#promo').append("<option id='promo"+value.id_promo+"' value='"+value.id_promo+"'>"+value.promo+"</option>");
					});
				}
			});
		}

        $(document).ready(function() {
	        $('input[name=outlet_type]').on('click', function(){
				outlet = $(this).val();

				if(outlet == 'specific') {
					$('#selectOutlet').show();
				}
				else {
					$('#selectOutlet').hide();
				}
			});

			loadProduct();
	    	loadOutlet();
	    	loadPromo();
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
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Redirect Complex Name" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Category Name" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                    	<label class="col-md-3 control-label">Outlet Type
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Type of method to get outlet" data-container="body"></i>
                        </label>
                        <div class="col-md-7" style="margin-bottom: -20px">
							<div class="mt-radio-inline">
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="near me" data-container="body"></i> Near Me
									<input type="radio" value="near me" name="outlet_type" @if(isset($result['outlet_type']) && $result['outlet_type'] == "near_me") checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline">
									<i class="fa fa-question-circle tooltips" data-original-title="Promo code hanya berlaku untuk outlet tertentu" data-container="body"></i> Specific
									<input type="radio" value="specific" name="outlet_type" @if(isset($result['outlet_type']) && $result['outlet_type'] == "specific") checked @endif required/>
									<span></span>
								</label>
							</div>
                        </div>
					</div>
					<div class="form-group" id="selectOutlet" @if(($result['outlet_type']??false) != 'near me' && empty($result['outlets'])) style="display: none;" @endif>
                        <label class="col-md-3 control-label">Select Outlet
                        	<span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Select outlet" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
							<select id="specific-outlet" name="outlet[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Product </label>
                        <div class="col-md-7">
                        	<div id="data-product" style="padding-right: 15px">
                        	</div>
                        	<a href="javascript:;" data-repeater-create class="btn btn-success" onclick="addProduct()"><i class="fa fa-plus"></i> New Product</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-md-3 control-label">Promo Code </label>
					<div class="col-md-4">
						<select name="promo" id="promo" class="form-control select2">
							<option value="0">Select Promo Code</option>
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