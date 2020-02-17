<div style="display: inline;">
	<div id="productDiscount" class="p-t-10px"> 
		<div class="form-group">
			<div class="row">
				<div class="col-md-3">
					<label class="control-label">Filter Product</label>
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Pilih produk yang akan diberikan diskon </br></br>All Product : Promo code berlaku untuk semua product </br></br>Selected Product : Promo code hanya berlaku untuk product tertentu" data-container="body" data-html="true"></i>
					<select class="form-control" name="filter_product">
						<option value="All Product"  @if(isset($result['deals_product_discount_rules']['is_all_product']) && $result['deals_product_discount_rules']['is_all_product'] == "1") selected @endif required> All Product </option>
						<option value="Selected" @if(isset($result['deals_product_discount_rules']['is_all_product']) && $result['deals_product_discount_rules']['is_all_product'] == "0") selected @endif> Selected Product </option>
                    </select>
				</div>
			</div>
		</div>
		<div id="selectProduct" class="form-group row" style="width: 100%!important">
			<div class="">
				<div class="col-md-6">
					<label for="multipleProduct" class="control-label">Select Product</label>
					<select id="multipleProduct" name="multiple_product[]" class="form-control select2 select2-hidden-accessible col-md-6" multiple="" tabindex="-1" aria-hidden="true" style="width: 100%!important" @if(isset($result['deals_product_discount_rules']['is_all_product']) && $result['deals_product_discount_rules']['is_all_product'] == "0") required @endif>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label">Max product discount per transaction</label>
			<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal masing-masing produk yang dapat dikenakan diskon dalam satu transaksi </br></br>Note : isi dengan 0 jika jumlah maksimal produk tidak dibatasi" data-container="body" data-html="true"></i>
			<div class="row">
				<div class="col-md-2">
					
					<input required type="text" class="form-control text-center digit_mask" name="max_product" placeholder="max product" @if(isset($result['deals_product_discount_rules']['max_product']) && $result['deals_product_discount_rules']['max_product'] != "") value="{{$result['deals_product_discount_rules']['max_product']}}" @elseif(old('max_product') != "") value="{{old('max_product')}}" @endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
					
				</div>
			</div>
		</div>
		<div class="form-group" style="height: 90px;">
			<label class="control-label">Discount Type</label>
			<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih jenis diskon untuk produk </br></br>Nominal : Diskon berupa potongan nominal, jika total diskon melebihi harga produk akan dikembalikan ke harga produk </br></br>Percent : Diskon berupa potongan persen" data-container="body" data-html="true"></i>
			<div class="mt-radio-list">
				<label class="mt-radio mt-radio-outline"> Nominal
					<input type="radio" value="Nominal" name="discount_type" @if(isset($result['deals_product_discount_rules']['discount_type']) && $result['deals_product_discount_rules']['discount_type'] == "Nominal") checked @endif required/>
					<span></span>
				</label>
				<label class="mt-radio mt-radio-outline"> Percent
					<input type="radio" value="Percent" name="discount_type" @if(isset($result['deals_product_discount_rules']['discount_type']) && $result['deals_product_discount_rules']['discount_type'] == "Percent") checked @endif required/>
					<span></span>
				</label>
			</div>
		</div>
		<div class="form-group" id="product-discount-div" @if(empty($result['deals_product_discount_rules'])) style="display: none;" @endif >
			<div class="row">
				<div class="col-md-3">
					<label class="control-label" id="product-discount-value">Discount Value</label>
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon yang diberikan" data-container="body"></i>
					<div class="input-group @if(isset($result['deals_product_discount_rules']['discount_type']) && $result['deals_product_discount_rules']['discount_type'] == "Percent") col-md-5 @else col-md-12 @endif" id="product-discount-group">
						<div class="input-group-addon" id="product-addon-rp" @if(isset($result['deals_product_discount_rules']['discount_type']) && $result['deals_product_discount_rules']['discount_type'] == "Percent") style="display: none;" @endif>IDR</div>
						<input required type="text" class="form-control text-center" name="discount_value" placeholder="Discount Value" @if(isset($result['deals_product_discount_rules']['discount_value']) && $result['deals_product_discount_rules']['discount_value'] != "") value="{{$result['deals_product_discount_rules']['discount_value']}}" @elseif(old('discount_value') != "") value="{{old('discount_value')}}" @endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
						<div class="input-group-addon" id="product-discount-addon" @if(isset($result['deals_product_discount_rules']['discount_type']) && $result['deals_product_discount_rules']['discount_type'] == "Nominal") style="display: none;" @endif>%</div>
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
</div>