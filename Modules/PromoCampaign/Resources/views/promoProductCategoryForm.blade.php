@section('promoProductCategoryForm')
<div class="row">
	<div class="col-md-6">
		<div id="selectProduct2" class="form-group" style="width: 100%!important">
			<label for="multipleProduct2" class="control-label">Main Category<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih kategori produk yang akan dijadikan syarat promo" data-container="body" data-html="true"></i></label>
			<select id="multipleCategory" name="category_product" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true" data-value="{{ ($result['promo_campaign_productcategory_category_requirements']??false) ? json_encode( ([$result['promo_campaign_productcategory_category_requirements']['id_product_category']] ?? ([$result['promo_campaign_productcategory_category_requirements'][0]['id_product_category']]??'') ) ) :''}}" style="width: 100%!important">
			</select>
		</div>
	</div>
</div>
<div id="ruleSection3">
	<label class="control-label">Promo Rule
	<span class="required" aria-required="true"> * </span>
	<i class="fa fa-question-circle tooltips" data-original-title="Masukan rentang jumlah produk dan benefit yang didapatkan dalam promo ini" data-container="body"></i></label><br>
<div class="row">
	<div class="col-md-2 text-center">
		<label>Min. Qty <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk dalam kategori minimal untuk mendapatkan benefit" data-container="body"></i></label>
	</div>
	<div class="col-md-10">
		<div class="col-md-6 text-center">
			<label>Benefit <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang akan dikenakan diskon setelah pembelian </br></br> Free : jumlah product termurah dalam pembelian yang diberikan </br></br> Discount : Besar diskon yang diberikan pada produk termurah. Persentase akan dihitung dari harga produk + harga modifier" data-html="true" data-container="body"></i></label>
		</div>
		<div class="col-md-1 text-center">
		</div>
	</div>
</div>
<div id="ruleSectionBody3">
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group" style="width: 100%!important">
			<label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
				<input type="checkbox" id="autoapply" name="autoapply" value="1" 
				@if ( old('autoapply') == "1" || ($result['promo_campaign_productcategory_category_requirements']??false)==1 )
					checked 
				@endif> Auto Apply
				<i class="fa fa-question-circle tooltips" data-original-title="Promo otomatis dipasang apabila belum ada promo lain yang terpasang" data-container="body"></i>
				<span></span>
			</label>
		</div>
	</div>
</div>
<div class="form-group">
	<button type="button" class="btn btn-primary new">Add New</button>
</div>
</div>
@endSection

@section('child-script3')
<script type="text/javascript">

	var lastError3='';
	var template3='<div class="row" data-id="::n::">\
		<div class="col-md-2">\
			<div class="col-md-2">\
			</div>\
			<div class="col-md-7 form-group">\
				<input type="text" class="form-control ::classMinQty:: text-center qty_mask" min="1" name="promo_rule[::n::][min_qty_requirement]" value="::min_qty::" required autocomplete="off">\
			</div>\
			<p class="text-danger help-block" style="padding-bottom:10px;margin-top:-10px">::error1::</p>\
		</div>\
		<div class="col-md-10">\
			<div class="col-md-6">\
				<div class="form-group">\
					<select class="form-control benefit" name="promo_rule[::n::][benefit_type]">\
						<option value="free" ::selected_free::> Free Product</option>\
						<option value="nominal" ::selected_nominal::> Nominal Discount </option>\
						<option value="percent" ::selected_percent::> Percent Discount </option>\
					</select>\
				</div>\
			</div>\
			<div class="col-md-1">\
				<button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash-o"></i></button>\
			</div>\
		</div>\
		<div class="col-md-2">\
		</div>\
		<div class="col-md-10">\
			<div class="col-md-6">\
				<div class="col-md-6 p-l-0 text-right">\
					<label>Discount<span class="required" aria-required="true"> * </span></label>\
				</div>\
				<div class="col-md-6 p-l-r-0">\
					<div class="form-group ::hide_qty::">\
						<div class="input-group">\
							<input type="text" class="form-control benefit_qty text-center digit_mask" min="0" name="promo_rule[::n::][benefit_qty]" value="::benefit_qty::" ::required_qty:: placeholder="Benefit Qty" autocomplete="off">\
							<div class="input-group-addon">qty</div>\
						</div>\
					</div>\
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
		</div>\
		<div class="::hide_percent_max::">\
			<div class="col-md-2">\
			</div>\
			<div class="col-md-10">\
				<div class="col-md-6">\
					<div class="col-md-6 p-l-0 text-right">\
						<label>Max Discount</label>\
					</div>\
					<div class="col-md-6 p-l-r-0">\
						<div class="form-group">\
							<div class="input-group">\
								<div class="input-group-addon">{{env('COUNTRY_CODE') == 'SG' ? 'SGD' : 'IDR'}}</div>\
								<input type="text" class="form-control digit_mask text-center" min="0" name="promo_rule[::n::][max_percent_discount]" value="::max_percent_discount::"  placeholder="100000" autocomplete="off">\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>\
	</div>';

	@if(isset($result['promo_campaign_productcategory_rules']))
		database3={!!json_encode($result['promo_campaign_productcategory_rules'])!!};
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
		eval(ncol+'=val');
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
			var hide_qty = '';
			var hide_nominal = '';
			var hide_percent = '';
			var selected_free = '';
			var selected_nominal = '';
			var hide_percent_max = '';
			var selected_percent = '';
			var required_qty = '';
			var required_nominal = '';
			var required_percent = '';
			var max_percent_discount = it['max_percent_discount'];
			var it_min_qty = it['min_qty_requirement']+'';
			it_min_qty = it_min_qty.replace(/,/g , '');
			it_min_qty = parseInt(it_min_qty);

			if(it['benefit_type'] == "free"){

				hide_nominal = 'd-none';
				hide_percent = 'd-none';
				hide_percent_max = 'd-none';
				selected_free = 'selected';
				required_qty = 'required';
				discount_value = 100;
				discount_nominal_value = ''
				max_percent_discount = ''

			}else if(it['benefit_type'] == "percent") {

				hide_qty = 'd-none';
				hide_nominal = 'd-none';
				hide_percent_max = '';
				selected_percent = 'selected';
				required_percent = 'required';
				discount_nominal_value = ''

			}else if(it['benefit_type'] == "nominal") {

				hide_qty = 'd-none';
				hide_percent = 'd-none';
				hide_percent_max = 'd-none';
				selected_nominal = 'selected';
				required_nominal = 'required';
				discount_value = '';
				max_percent_discount = ''

			}else {

				if (it['discount_type'] == 'nominal') {

					discount_nominal_value = it['discount_nominal'] ? it['discount_nominal'] : it['discount_value'];
					hide_qty = 'd-none';
					hide_percent = 'd-none';
					hide_percent_max = 'd-none';
					hide_nominal = '';
					selected_nominal = 'selected';
					required_qty = '';
					required_nominal = 'required';
					discount_value = '';
					max_percent_discount = ''
					
				}else if (it['discount_type'] =='percent' && it['discount_value'] != 100) {

					discount_percent_value = it['discount_percent'] ? it['discount_percent'] : it['discount_value'];
					hide_qty = 'd-none';
					hide_nominal = 'd-none';
					hide_percent = '';
					hide_percent_max = '';
					selected_percent = 'selected';
					required_percent = 'required';
					discount_nominal_value = ''

				}else {
					hide_nominal = 'd-none';
					hide_percent = 'd-none';
					hide_percent_max = 'd-none';
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
			.replace('::hide_percent_max::', hide_percent_max)
			.replace('::max_percent_discount::', max_percent_discount);

			if(it_min_qty-last<=0){
				if(!lastErrorReal){
					edited=edited.replace('::error1::','Min. Quantity should be greater than '+last).replace('::classMinQty::','red');
					errorNow='min_qty'+id;
					$('button[type="submit"]').prop('disabled', true);
				}
				status=false;
			}else{
				edited=edited.replace('::error::','');
			}
			edited=edited.replace('::classMinQty::','').replace('::error1::','').replace('::error2::','');
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
		console.log('123');
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
		$('#promoProductCategory').on('change','input,select',function(){
			var col=$(this).prop('name');
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
			if($('input[name=promo_type]:checked').val()=='Promo Product Category'){
				return reOrder3();
			}
		});
	});
</script>
@endsection