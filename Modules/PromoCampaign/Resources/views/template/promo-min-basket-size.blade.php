@section('min-basket-size')
<div class="form-group">
	<label class="control-label">Min basket size</label>
	<i class="fa fa-question-circle tooltips" data-original-title="Syarat minimum basket size atau total harga product (subtotal) sebelum dikenakan promo dan biaya pengiriman. Subtotal diambil dari subtotal dari brand yang dipilih. Kosongkan jika tidak ada syarat jumlah minimum basket size" data-container="body" data-html="true"></i>
	<div class="row">
		<div class="col-md-3">
			<div class="input-group" >
				<div class="input-group-addon">IDR</div>
				<input type="text" class="form-control text-center digit_mask" name="min_basket_size" placeholder="" 
					@if(old('min_basket_size') != "") value="{{old('min_basket_size')}}" 
					@elseif(isset($result['min_basket_size'])) value="{{$result['min_basket_size']}}" 
					@endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
			</div>
		</div>
	</div>
</div>
@overwrite