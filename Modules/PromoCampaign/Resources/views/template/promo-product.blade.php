@php

	switch ($promo_source) {
		case 'promo_campaign':
			$data = $result;
			$promo_rules = $result['promo_campaign_tier_discount_rules'] ?: null;
			break;
		
		case 'Promotion':
			$data = $result;
			$promo_source = 'deals_promotion';
			break;

		default:
			$data = $result;
			$promo_source = 'deals';
			break;
	}

	switch ($promo_type) {
		case 'tier-discount':
			$promo_rules 	= ($result['promo_campaign_tier_discount_rules'] ?? $result['deals_tier_discount_rules'] ?? $result['deals_promotion_tier_discount_rules']) ?: null;
			$is_all_product = $result['promo_campaign_tier_discount_rules'][0]['is_all_product'] 
								?? $result['deals_tier_discount_rules'][0]['is_all_product'] 
								?? $result['deals_promotion_tier_discount_rules'][0]['is_all_product'] 
								?? 1;
			break;
		
		case 'bxgy':
			$promo_rules 	= ($result['promo_campaign_buyxgety_rules'] ?? $result['deals_buyxgety_rules'] ?? $result['deals_promotion_buyxgety_rules']) ?: null;
			$is_all_product = $result['promo_campaign_buyxgety_rules'][0]['is_all_product'] 
								?? $result['deals_buyxgety_rules'][0]['is_all_product'] 
								?? $result['deals_promotion_buyxgety_rules'][0]['is_all_product'] 
								?? 1;
			break;

		default:
			$promo_rules = null;
			$is_all_product = 1;
			break;
	}

	$brands = array_column($result['brands'], 'id_brand');
	$product_type 		= $result['product_type'] ?? 'single';

@endphp

@section('promo-product')
	<div class="form-group">
		<div class="row">
			<div class="col-md-3">
				<label class="control-label">Filter Product</label>
				<span class="required" aria-required="true"> * </span>
				<i class="fa fa-question-circle tooltips" data-original-title="Pilih produk yang akan diberikan diskon </br></br>All Product : Promo code berlaku untuk semua product </br></br>Selected Product : Promo code hanya berlaku untuk product tertentu" data-container="body" data-html="true"></i>
				<select class="form-control" id="filter-product-{{ $promo_type }}" name="filter_product">
					<option value="all_product"  @if($is_all_product) selected @endif required> All Product </option>
					<option value="selected" @if(!$is_all_product) selected @endif> Selected Product </option>
	            </select>
			</div>
		</div>
	</div>

	<div id="select-product-{{ $promo_type }}">
		<div class="form-group row" style="width: 100%!important">
			<div class="">
				<div class="col-md-6">
					<label for="multiple-product-{{ $promo_type }}" class="control-label">Select Product</label>
					<select id="multiple-product-{{ $promo_type }}" name="multiple_product[]" class="form-control select2 select2-hidden-accessible col-md-6" multiple="" tabindex="-1" aria-hidden="true" style="width: 100%!important" @if(!$is_all_product) required @endif>
					</select>
				</div>
			</div>
		</div>

		<div>
			<label class="control-label">Product Rule</label>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih rule yang berlaku ketika transaksi menggunakan syarat product" data-container="body" data-html="true"></i>
			<div class="mt-radio-list">
				<label class="mt-radio mt-radio-outline"> All items must be present
					<input type="radio" value="and" name="product_rule" @if(($result['product_rule']??false) === 'and' && !empty($promo_rules)) checked @endif/>
					<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>semua</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
					<span></span>
				</label>
				<label class="mt-radio mt-radio-outline"> One of the items must exist
					<input type="radio" value="or" name="product_rule" @if(($result['product_rule']??false) === 'or' && !empty($promo_rules)) checked @endif/>
					<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>salah satu</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
					<span></span>
				</label>
			</div>
		</div>
	</div>
@overwrite

@section('promo-product-script')
	<script type="text/javascript">
		$(document).ready(function() {
			let is_all_product = {{ $is_all_product }};
			let promo_type = "{{ $promo_type }}";
			let brand = JSON.parse('{!!json_encode($brands)!!}');
			let product_type = '{!!$product_type!!}';
			if (is_all_product != 0) {
				$('#select-product-'+promo_type).hide();
			}

			$('#filter-product-'+promo_type).change(function() {
				product = $('#filter-product-'+promo_type+' option:selected').val()
				$('#multiple-product-'+promo_type).prop('required', false)
				$('#multiple-product-'+promo_type).prop('disabled', true)
				if (product == 'selected') {
					$('#select-product-'+promo_type).show()
					if (true) {
						$.ajax({
							type: "GET",
							url: "{{url('promo-campaign/step2/getData')}}",
							data : {
								"get" : 'Product',
								"brand" : brand,
								"product_type" : product_type
							},
							dataType: "json",
							success: function(data){
								// productLoad = 1;
								listProduct=data;
								$.each(data, function( key, value ) {
									$('#multiple-product-'+promo_type).append("<option value='"+value.id_brand+'-'+value.id_product+'-'+value.id_product_variant_group+"'>"+value.product+"</option>");
								});
								$('#multiple-product-'+promo_type).prop('required', true)
								$('#multiple-product-'+promo_type).prop('disabled', false)
							}
						});
					} else {
						$('#multiple-product-'+promo_type).prop('required', true)
						$('#multiple-product-'+promo_type).prop('disabled', false)
					}
				} else {
					$('#select-product-'+promo_type).hide()
				}
			});
		});
	</script>
@overwrite