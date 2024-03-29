@section('promoProductCategoryForm')
@php
	$category_products = [];
	if(isset($result['deals_productcategory_category_requirements'])){
		if(isset($result['deals_productcategory_category_requirements']['product_category'])){
			$category_products = array_column($result['deals_productcategory_category_requirements']['product_category'], 'id_product_category');
		}
	}
@endphp
<div class="row">
	<div class="col-md-6">
		<div id="selectProduct2" class="form-group" style="width: 100%!important">
			<label for="multipleProduct2" class="control-label">Main Category<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih kategori produk yang akan dijadikan syarat promo" data-container="body" data-html="true"></i></label>
			<select id="category_product" name="category_product[]" class="form-control select2-multiple select2-hidden-accessible" tabindex="-1" aria-hidden="true" multiple="multiple" data-value="{{ json_encode($category_products??[]) }}" style="width: 100%!important">
			</select>
		</div>
	</div>
</div>
{{--  <div class="row">
	<div class="col-md-6">
		<div id="selectVariant" class="form-group" style="width: 100%!important">
			<label for="variant" class="control-label">Product Variant
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih variant produk yang akan dijadikan syarat promo" data-container="body" data-html="true"></i></label>
			<div class="row">
				<div class="col-md-10">
					@php
						$variant_products = [];
						if (old('product_variants[]')) {
							$variant_products = old('product_variants[]');
						}
						elseif(isset($result['deals_productcategory_category_requirements'])){
							if(isset($result['deals_productcategory_category_requirements']['product_variant'])){
								$variant_products = array_column($result['deals_productcategory_category_requirements']['product_variant'], 'id_product_variant');
							}
						}
					@endphp
					<select id="product_variants" name="product_variants[]" class="form-control select2-multiple select2-hidden-accessible" tabindex="-1" aria-hidden="true" multiple="multiple" style="width: 100%!important">
						@foreach ($variants as $key_variant_1 => $parent)
						<optgroup label="{{ $parent['product_variant_name'] }}">
							@foreach ($parent['children'] as $key_variant_2 => $children)
							<option value="{{ $children['id_product_variant'] }}" 

							@if ($variant_products) @if(in_array($children['id_product_variant'], $variant_products)) selected @endif @endif
							>
							@if($children['product_variant_name']=='general_size') 
								Without Variant Size 
							@elseif($children['product_variant_name']=='general_type') 
								Without Variant Type 
							@else 
								{{ $children['product_variant_name'] }} 
							@endif
						</option>
							@endforeach
						</optgroup>
						@endforeach
					</select>
				</div>
				<div class="col-md-2 text-center">
					<button type="button" class="btn btn-danger btn-sm" id="remove-variant"><i class="fa fa-trash-o"></i></button>
			</div>
			</div>
		</div>
	</div>
</div>  --}}

<div id="ruleSection3">
	<label class="control-label">Promo Variant
	<span class="required" aria-required="true"> * </span>
	<i class="fa fa-question-circle tooltips" data-original-title="Pilih variant produk yang akan dijadikan syarat deal" data-container="body"></i></label><br>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-3" style="padding-left: 20px;">
			<label>Size <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Ukuran produk yang akan dikenakan deal" data-container="body"></i></label>
		</div>
		<div class="col-md-3 text-center">
			<label>Type <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Tipe produk yang akan dikenakan deal" data-container="body"></i></label>
		</div>
	</div>
	<div id="ruleSectionBody4">
		@if (!empty($result['deals_productcategory_category_requirements']['product_variant']))
			@foreach ($result['deals_productcategory_category_requirements']['product_variant'] as $key_var => $variant_rule)
				<div class="row" data-id="{{ $key_var }}">
					<div class="col-md-1 text-center">
							<button type="button" class="btn btn-danger btn-sm" @if($key_var == 0) disabled @endif onclick="deleteVariant({{ $key_var }})"><i class="fa fa-trash-o"></i></button>
					</div>
					<div class="col-md-3" style="padding-left: 0px;">
						<div class="form-group">
							<select class="form-control" id="variant-rule" name="variants[{{ $key_var }}][size]" required>
								<option value="" selected disabled>Select Variant Size</option>
								@foreach ($variants as $key_variant_1 => $parent)
									@if ($parent['product_variant_code']=='size')
										@foreach ($parent['children'] as $key_variant_2 => $children)
										<option value="{{ $children['id_product_variant'] }}" @if($variant_rule['size'] == $children['id_product_variant']) selected @endif>@if($children['product_variant_name']=='general_size') Without Variant Size @else {{ $children['product_variant_name'] }} @endif</option>
										@endforeach
									@endif
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-1" style="padding-left: 0px;">
					</div>
					<div class="col-md-3" style="padding-left: 0px;">
						<div class="form-group">
							<select class="form-control" id="variant-rule" name="variants[{{ $key_var }}][type]" required>
								<option value="" selected disabled>Select Variant Type</option>
								@foreach ($variants as $key_variant_1 => $parent)
									@if ($parent['product_variant_code']=='type')
										@foreach ($parent['children'] as $key_variant_2 => $children)
										<option value="{{ $children['id_product_variant'] }}" @if($variant_rule['type'] == $children['id_product_variant']) selected @endif>@if($children['product_variant_name']=='general_type') Without Variant Type @else {{ $children['product_variant_name'] }} @endif</option>
										@endforeach
									@endif
								@endforeach
							</select>
						</div>
					</div>
				</div>
			@endforeach
		@else
		<div class="row" data-id="0">
			<div class="col-md-1 text-center">
					<button type="button" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash-o"></i></button>
			</div>
			<div class="col-md-3" style="padding-left: 0px;">
				<div class="form-group">
					<select class="form-control" id="variant-rule" name="variants[0][size]" required>
						<option value="" selected disabled>Select Variant Size</option>
						@foreach ($variants as $key_variant_1 => $parent)
							@if ($parent['product_variant_code']=='size')
								@foreach ($parent['children'] as $key_variant_2 => $children)
								<option value="{{ $children['id_product_variant'] }}">@if($children['product_variant_name']=='general_size') Without Variant Size @else {{ $children['product_variant_name'] }} @endif</option>
								@endforeach
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-1" style="padding-left: 0px;">
			</div>
			<div class="col-md-3" style="padding-left: 0px;">
				<div class="form-group">
					<select class="form-control" id="variant-rule" name="variants[0][type]" required>
						<option value="" selected disabled>Select Variant Type</option>
						@foreach ($variants as $key_variant_1 => $parent)
							@if ($parent['product_variant_code']=='type')
								@foreach ($parent['children'] as $key_variant_2 => $children)
								<option value="{{ $children['id_product_variant'] }}">@if($children['product_variant_name']=='general_type') Without Variant Type @else {{ $children['product_variant_name'] }} @endif</option>
								@endforeach
							@endif
						@endforeach
					</select>
				</div>
			</div>
		</div>
		@endif
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-primary new-variant" onclick="addVariantRule()">Add New Variant Rule</button>
	</div>
	<label class="control-label">Promo Rule
	<span class="required" aria-required="true"> * </span>
	<i class="fa fa-question-circle tooltips" data-original-title="Masukan rentang jumlah produk dan benefit yang didapatkan dalam promo ini" data-container="body"></i></label><br>
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-2" style="padding-left: 20px;">
			<label>Min. Qty <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk dalam kategori minimal untuk mendapatkan benefit" data-container="body"></i></label>
		</div>
		<div class="col-md-3 text-center">
			<label>Benefit <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang akan dikenakan diskon setelah pembelian </br></br> Free : jumlah product termurah dalam pembelian yang diberikan </br></br> Discount : Besar diskon yang diberikan pada produk termurah. Persentase akan dihitung dari harga produk + harga modifier" data-html="true" data-container="body"></i></label>
		</div>
		<div class="col-md-2 text-center">
			<label>Benefit. Qty <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang akan mendapat benefit" data-container="body"></i></label>
		</div>
	</div>
	<div id="ruleSectionBody3">
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-primary new">Add New</button>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group" style="width: 100%!important">
				<label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
					<input type="checkbox" id="auto_apply" name="auto_apply" value="1" 
					@if ( old('auto_apply') == "1" || ($result['deals_productcategory_category_requirements']['auto_apply']??false)==1 )
						checked 
					@endif> Auto Apply
					<i class="fa fa-question-circle tooltips" data-original-title="Promo otomatis dipasang apabila belum ada promo lain yang terpasang" data-container="body"></i>
					<span></span>
				</label>
			</div>
		</div>
	</div>
</div>
@endSection

@section('child-script3')
<script type="text/javascript">

	@if (!empty($result['deals_productcategory_category_requirements']['product_variant']))
		var noRule = {{ count($result['deals_productcategory_category_requirements']['product_variant']) }};
		variants={!!json_encode($result['deals_productcategory_category_requirements']['product_variant'])!!};
	@else
		var noRule = 1;
		variants = [];
	@endif

	function deleteVariant(no){
		if(no != 0){
			$(`#ruleSectionBody4 div[data-id=${no}]`).remove();
		}
	}

	function addVariantRule(){
		var html = `
            <div class="row" data-id="${noRule}">
				<div class="col-md-1 text-center">
						<button type="button" class="btn btn-danger btn-sm" onclick="deleteVariant(${noRule})"><i class="fa fa-trash-o"></i></button>
				</div>
				<div class="col-md-3" style="padding-left: 0px;">
					<div class="form-group">
						<select class="form-control" id="variant-rule" name="variants[${noRule}][size]" required>
							<option value="" selected disabled>Select Variant Size</option>
							@foreach ($variants as $key_variant_1 => $parent)
								@if ($parent['product_variant_code']=='size')
									@foreach ($parent['children'] as $key_variant_2 => $children)
									<option value="{{ $children['id_product_variant'] }}">@if($children['product_variant_name']=='general_size') Without Variant Size @else {{ $children['product_variant_name'] }} @endif</option>
									@endforeach
								@endif
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-1" style="padding-left: 0px;">
				</div>
				<div class="col-md-3" style="padding-left: 0px;">
					<div class="form-group">
						<select class="form-control" id="variant-rule" name="variants[${noRule}][type]" required>
							<option value="" selected disabled>Select Variant Type</option>
							@foreach ($variants as $key_variant_1 => $parent)
								@if ($parent['product_variant_code']=='type')
									@foreach ($parent['children'] as $key_variant_2 => $children)
									<option value="{{ $children['id_product_variant'] }}">@if($children['product_variant_name']=='general_type') Without Variant Type @else {{ $children['product_variant_name'] }} @endif</option>
									@endforeach
								@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>
		`;
		noRule++;
        $('#ruleSectionBody4').append(html);
	}

	var lastError3='';
	var template3='<div class="row" data-id="::n::">\
		<div class="col-md-1 text-center">\
				<button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash-o"></i></button>\
		</div>\
		<div class="col-md-2">\
			<div class="col-md-7">\
				<div class="form-group">\
					<input type="text" class="form-control ::classMinQty:: text-center qty_mask" min="1" name="promo_rule[::n::][min_qty_requirement]" value="::min_qty::" required autocomplete="off">\
				</div>\
				<p class="text-danger help-block" style="padding-bottom:10px;margin-top:-10px">::error1::</p>\
			</div>\
		</div>\
		<div class="col-md-3" style="padding-left: 0px;">\
			<div class="form-group">\
				<select class="form-control benefit" name="promo_rule[::n::][benefit_type]">\
					<option value="free" ::selected_free::> Free Product</option>\
					<option value="nominal" ::selected_nominal::> Nominal Discount </option>\
					<option value="percent" ::selected_percent::> Percent Discount </option>\
				</select>\
			</div>\
		</div>\
		<div class="col-md-2">\
			<div class="col-md-2">\
			</div>\
			<div class="col-md-7">\
				<div class="form-group">\
					<input type="text" class="form-control benefit_qty ::classBenQty:: text-center digit_mask" min="0" name="promo_rule[::n::][benefit_qty]" value="::benefit_qty::" ::required_qty:: autocomplete="off">\
				</div>\
				<p class="text-danger help-block" style="padding-bottom:10px;margin-top:-10px">::errorBen::</p>\
			</div>\
		</div>\
		<div class="col-md-4 ::hide_qty::">\
			<div class="col-md-4 text-left">\
				<label>Discount<span class="required" aria-required="true"> * </span></label>\
			</div>\
			<div class="col-md-8">\
				<div class="form-group ::hide_nominal::">\
					<div class="input-group">\
						<div class="input-group-addon">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}}</div>\
						<input type="text" class="form-control digit_mask text-center" min="0" name="promo_rule[::n::][discount_nominal]" value="::discount_nominal::" ::required_nominal:: placeholder="100000" autocomplete="off">\
					</div>\
				</div>\
				<div class="form-group ::hide_percent::">\
					<div class="input-group">\
						<input type="number" class="form-control discount_value max100 benefit_percent text-center" min="0" max="100" name="promo_rule[::n::][discount_percent]" value="::discount_percent::" ::discount_prop:: ::required_percent:: style="padding-left: 7px;padding-right: 7px;text-align: center;" placeholder="50" autocomplete="off">\
						<div class="input-group-addon">%</div>\
					</div>\
				</div>\
			</div>\
		</div>\
	</div>';

	@if(isset($result['deals_productcategory_rules']))
		database3={!!json_encode($result['deals_productcategory_rules'])!!};
	@else
		database3=[];
	@endif
	function add3(id){
		if(!isNaN(id)){
			database3.splice(id+1,0,{});
		}else{
			database3.splice(0,0,{});
		}
		reOrder();
		reOrder2();
	}
	function update3(col,val){
		var ncol=col.replace('promo_rule','database3').replace(/\[/g,'["').replace(/\]/g,'"]');
		if(ncol!='category_product[""]' || ncol!='product_variants[""]'){
			console.log('er')
			eval(ncol+'=val');
		}
	}
	function reOrder3(drawIfTrue=true){
		var html='';
		var last=0;
		var status=true;
		var lastErrorReal='';
		if(database3.length<1||database3[0]==undefined){
			database3=[];
			add3();
		}
		database3.forEach(function(it,id){
			var edited=template3;
			var errorNow='';
			var discount_value=it['discount_value'];
			var discount_nominal_value=it['discount_nominal'];
			var discount_percent_value=it['discount_percent'];
			var qty = it['benefit_qty'];
			var hide_qty = 'd-none';
			var hide_nominal = '';
			var hide_percent = '';
			var selected_free = '';
			var selected_nominal = '';
            
			var selected_percent = '';
			var required_qty = '';
			var required_nominal = '';
			var required_percent = '';
			var max_percent_discount = it['max_percent_discount'];
			var it_min_qty = it['min_qty_requirement']+'';
			it_min_qty = it_min_qty.replace(/,/g , '');
			it_min_qty = parseInt(it_min_qty);
			var benefit_qty = it['benefit_qty']+'';
			benefit_qty = benefit_qty.replace(/,/g , '');
			benefit_qty = parseInt(benefit_qty);

			if(it['benefit_type'] == "free"){

				hide_nominal = 'd-none';
				hide_percent = 'd-none';
				selected_free = 'selected';
				required_qty = 'required';
				discount_value = 100;
				discount_nominal_value = ''
				max_percent_discount = ''

			}else if(it['benefit_type'] == "percent") {

				hide_qty = '';
				hide_nominal = 'd-none';
				selected_percent = 'selected';
				required_percent = 'required';
				discount_nominal_value = ''

			}else if(it['benefit_type'] == "nominal") {

				hide_qty = '';
				hide_percent = 'd-none';
				selected_nominal = 'selected';
				required_nominal = 'required';
				discount_value = '';
				max_percent_discount = ''

			}else {

				if (it['discount_type'] == 'nominal') {

					discount_nominal_value = it['discount_nominal'] ? it['discount_nominal'] : it['discount_value'];
					hide_qty = '';
					hide_percent = 'd-none';
					hide_nominal = '';
					selected_nominal = 'selected';
					required_qty = '';
					required_nominal = 'required';
					discount_value = '';
					max_percent_discount = ''
					
				}else if (it['discount_type'] =='percent' && it['discount_value'] != 100) {

					discount_percent_value = it['discount_percent'] ? it['discount_percent'] : it['discount_value'];
					hide_qty = '';
					hide_nominal = 'd-none';
					hide_percent = '';
					selected_percent = 'selected';
					required_percent = 'required';
					discount_nominal_value = ''

				}else {
					hide_nominal = 'd-none';
					hide_percent = 'd-none';
					hide_qty = 'd-none';
					selected_free = 'selected';
					discount_value = 100;
					discount_nominal_value = ''
					discount_percent_value = '';
					max_percent_discount = ''

				}

			}

			$('button[type="submit"]').prop('disabled', false);
			if( (it['discount_value']-100)>0 && it['discount_type'] == "percent"){
				discount_value=100;
			}
			edited=edited.replace(/::n::/g,id)
			.replace('::min_qty::',it['min_qty_requirement'])
			.replace('::discount_value::',discount_value)
			.replace('::benefit_qty::',it['benefit_qty'])
			.replace('::hide_qty::', hide_qty)
			.replace('::hide_nominal::', hide_nominal)
			.replace('::hide_percent::', hide_percent)
			.replace('::selected_free::', selected_free)
			.replace('::selected_nominal::', selected_nominal)
			.replace('::selected_percent::', selected_percent)
			.replace('::discount_nominal::',discount_nominal_value?discount_nominal_value:'')
			.replace('::discount_percent::',discount_percent_value?discount_percent_value:'')
			.replace('::required_qty::',required_qty)
			.replace('::required_nominal::',required_nominal)
			.replace('::required_percent::',required_percent)
			.replace('::max_percent_discount::', max_percent_discount);

			if(it_min_qty-last<=0){
				if(!lastErrorReal){
					edited=edited.replace('::error1::','Min. Quantity should be greater than '+last).replace('::classMinQty::','red');
					errorNow='min_qty'+id;
					$('button[type="submit"]').prop('disabled', true);
				}
				status=false;
			}else if(benefit_qty>it_min_qty){
				if(!lastErrorReal){
					edited=edited.replace('::errorBen::','Benefit Quantity should be greater than '+it_min_qty).replace('::classBenQty::','red');
					errorNow='benefit_qty'+id;
					$('button[type="submit"]').prop('disabled', true);
				}
				status=false;
			}else{
				edited=edited.replace('::error::','');
			}
			if(!status){
				$('button[type="submit"]').prop('disabled', true);
			}
			edited=edited.replace('::classMinQty::','').replace('::classBenQty::','').replace('::error1::','').replace('::errorBen::','');
			if(!lastErrorReal){
				lastErrorReal=errorNow;
			}
			
			last=it['min_qty_requirement'];
			html+=edited;
		})
		if(lastErrorReal!=lastError3||(status&&drawIfTrue)){
			lastError3=lastErrorReal;
			$('#ruleSectionBody3').html(html);
		}

		$('.digit_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '0',
			max: '999999999'
		});
		$('.qty_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '0',
			max: '999999999'
		});

		return status;
	}
	$(document).ready(function(){
		$('#promoProductCategory').on('click','.new',function(){
			if(!reOrder3()){
				return false;
			}
			database3.push({});
			reOrder3();
		});
		$('#promoProductCategory').on('keyup','.max100',function(){
			if($(this).val()>100){
				$(this).val(100);
			}
		});
		$('#promoProductCategory').on('click','.remove',function(){
			var id=$($(this).parents('.row')[0]).data('id');
			delete database3[id];
			database3=database3.filter(function(x){return x!==undefined;});
			reOrder3();
		});
		$('#promoProductCategory').on('click','#remove-variant',function(){
			var delete_variant = $('#product_variants').val('').change();
			var col= 'product_variants[]';
			var val= null;
			update3(col,val);
			reOrder3();
		});
		$('#promoProductCategory').on('change','input,select',function(){
			var col=$(this).prop('name');
			console.log(col);
			var val=$(this).val();
			update3(col,val);
			reOrder3();
		});
		$('#promoProductCategory').on('change','input[name="discount_type"]',function(){
			if($('input[name="discount_type"]:checked').val()=='Percent'){
				$('.discount_value').prop('max','100');
			}else{
				$('.discount_value').removeProp('max');
			}
		});
		$('button[type="submit"]').on('click',function(){
			if($('input[name=promo_type]:checked').val()=='Category Discount'){
				return reOrder3();
			}
		});
	});
</script>
@endsection