<?php
$id_product = $product[0]['id_product'];
?>
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="formWithPrice2">
  <div class="form-body">

  	<div class="form-group" style="padding-left:20px">
		<label class="bold" style="width:30%">Outlet</label>
		<label class="bold" style="width:10%">Price</label>
		<!--<label class="bold" style="width:10%">Price Base</label>-->
		<!--<label class="bold" style="width:10%">Price Tax</label>-->
		<label class="bold" style="width:15%">Visible</label>
		<label class="bold" style="width:15%">Stock</label>
		<label class="bold" style="width:10%">POS Status</label>
	</div>
		@foreach($outlet as $key => $ou)
		<?php $marker = 0; ?>
        <div class="form-group" style="padding-left:20px">
            <label class=""  style="width:30%">{{$ou['outlet_name']}}</label>
			@foreach($ou['product_prices'] as $keyPrice => $price)
			@if($price['id_product'] == $id_product)
					<?php $marker = 1;?>
					<div style="width:10%; display:inline-block">
						<input type="hidden" name="id_product_price[]" value="{{ $price['id_product_price'] }}">
						<input type="hidden" name="id_outlet[]" value="{{ $ou['id_outlet'] }}">
						<input type="text" class="form-control nominal dinamic_price product-price" name="product_price[]" value="{{ $price['product_price'] }}" data-id="{{$ou['id_outlet']}}">
					</div>
					<div style="width:10%; display:none">
						<input type="text" class="form-control nominal price_float product-price-base" name="product_price_base[]" value="{{ $price['product_price_base'] }}" id="price_base_{{$ou['id_outlet']}}" readonly>
					</div>
					<div style="width:10%; display:none">
						<input type="text" class="form-control nominal price_float product-price-tax" name="product_price_tax[]" value="{{ $price['product_price_tax'] }}" id="price_tax_{{$ou['id_outlet']}}" readonly>
					</div>
					<div style="width:15%; display:inline-block">
						<select class="form-control product-visibility" name="product_visibility[]">
							<option></option>
							<option value="Visible" @if($price['product_visibility'] == 'Visible') selected @endif>Visible</option>
							<option value="Hidden" @if($price['product_visibility'] == 'Hidden') selected @endif>Hidden</option>
						</select>
						<input type="hidden" value="{{$price['product_visibility']}}" class="product-visibility-value">
					</div>
					<div style="width:15%; display:inline-block">
						<select class="form-control product-stock" name="product_stock_status[]">
							<option value="Available" @if($price['product_stock_status'] == 'Available') selected @endif>Available</option>
							<option value="Sold Out" @if($price['product_stock_status'] != 'Available') selected @endif>Sold Out</option>
						</select>
						<input type="hidden" value="{{$price['product_stock_status']}}" class="product-stock-value">
					</div>
					<div style="width:10%; display:inline-block">
						<input type="text" class="form-control nominal" value="{{ $price['product_status'] }}" disabled>
					</div>
				@endif
			@endforeach
			@if($marker == 0)
				<div style="width:10%; display:inline-block">
					<input type="hidden" name="id_product_price[]" value="0">
					<input type="hidden" name="id_outlet[]" value="{{ $ou['id_outlet'] }}">
					<input type="text" class="form-control nominal price product-price" name="product_price[]" value="0" data-id="{{$ou['id_outlet']}}">
				</div>
				<div style="width:10%; display:none">
					<input type="text" class="form-control nominal price_float product-price-base" name="product_price_base[]" value="0" id="price_base_{{$ou['id_outlet']}}" readonly>
				</div>
				<div style="width:10%; display:none">
					<input type="text" class="form-control nominal price_float product-price-tax" name="product_price_tax[]" value="0" id="price_tax_{{$ou['id_outlet']}}" readonly>
				</div>
				<div style="width:15%; display:inline-block">
					<select class="form-control product-visibility" name="product_visibility[]">
						<option></option>
						<option value="Visible">Visible</option>
						<option value="Hidden">Hidden</option>
					</select>
					<input type="hidden" value="Hidden" class="product-visibility-value">
				</div>
				<div style="width:15%; display:inline-block">
					<select class="form-control product-stock" name="product_stock_status[]">
						<option value="Available" selected>Available</option>
						<option value="Sold Out">Sold Out</option>
					</select>
					<input type="hidden" value="Available" class="product-stock-value">
				</div>
				<div style="width:10%; display:inline-block">
					<input type="text" class="form-control nominal" value="Active" disabled>
				</div>
			@endif
			<div style="width:15%; display:inline-block; vertical-align: text-top;">
				<label class="mt-checkbox mt-checkbox-outline"> Same for all Outlet
					<input type="checkbox" name="sameall[]" class="same" data-check="ampas"/>
					<span></span>
				</label>
			</div>
        </div>
		@endforeach
	</div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-md-offset-10 col-md-2">
            <input type="hidden" name="id_product" value="{{ $id_product }}">
            <button type="submit" class="btn green" id="submit">Submit</button>
          </div>
      </div>
  </div>
</form>