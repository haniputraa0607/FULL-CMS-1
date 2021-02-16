@include('promocampaign::template.promo-min-basket-size')
@php
	switch ($promo_source) {
		case 'promo_campaign':
			$promo_rule = $result['promo_campaign_discount_delivery_rules'] ?: null;
			break;
		
		case 'Promotion':
			$promo_source = 'deals_promotion';
			break;

		default:
			$promo_source = 'deals';
			break;
	}

	$promo_rule = ($result['deals_promotion_discount_delivery_rules'] ?? $result['deals_discount_delivery_rules'] ?? $result['promo_campaign_discount_delivery_rules'] ?? []) ?: null;
@endphp

@section('discount-delivery')

@yield('min-basket-size')

<div class="form-group" style="height: 90px;">
	<label class="control-label">Discount Type</label>
	<span class="required" aria-required="true"> * </span>
	<i class="fa fa-question-circle tooltips" data-original-title="Pilih jenis diskon </br></br>Nominal : Diskon berupa potongan nominal, jika total diskon melebihi harga subtotal akan dikembalikan ke harga subtotal </br></br>Percent : Diskon berupa potongan persen" data-container="body" data-html="true"></i>
	<div class="mt-radio-list">
		<label class="mt-radio mt-radio-outline"> Nominal
			<input type="radio" value="Nominal" name="discount_type" 
				@if( (old('discount_type')??$promo_rule['discount_type']??false) == "Nominal") checked @endif required/>
			<span></span>
		</label>
		<label class="mt-radio mt-radio-outline"> Percent
			<input type="radio" value="Percent" name="discount_type" @if( (old('discount_type')??$promo_rule['discount_type']??false) == "Percent") checked @endif required/>
			<span></span>
		</label>
	</div>
</div>
<div class="form-group" id="discount-delivery-div" @if( !(old('discount_value')??$promo_rule??false) ) style="display: none;" @endif >
	<div class="row">
		<div class="col-md-3">
			<label class="control-label" id="discount-delivery-value">Discount Value</label>
			<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon yang diberikan. Persentase akan dihitung dari subtotal" data-container="body"></i>
			<div class="input-group @if( (old('discount_type')??$promo_rule['discount_type']??false) == "Percent") col-md-5 @else col-md-12 @endif" id="discount-delivery-group">
				<div class="input-group-addon" id="delivery-addon-rp" @if( (old('discount_type')??$promo_rule['discount_type']??false) == "Percent") style="display: none;" @endif>IDR</div>
				<input required type="text" class="form-control text-center" name="discount_value" placeholder="" value="{{ old('discount_value')??$promo_rule['discount_value']??null }}" min="0" oninput="validity.valid||(value='');" autocomplete="off">
				<div class="input-group-addon" id="discount-delivery-addon" @if( (old('discount_type')??$promo_rule['discount_type']??false) == "Nominal") style="display: none;" @endif>%</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group" id="discount-delivery-percent-max-div" style="{{ (old('discount_type')??$promo_rule['discount_type']??false) == "Percent" ? '' : "display: none" }}">
	<div class="row">
		<div class="col-md-3">
			<label class="control-label" id="discount-delivery-value">Max Percent Discount</label>
			<i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon maksimal yang bisa didapatkan ketika menggunakan promo. Kosongkan jika maksimal persen mengikuti harga subtotal " data-container="body"></i>
			<div class="input-group col-md-12">

				<div class="input-group-addon">IDR</div>

				<input type="text" class="form-control text-center digit_mask" name="max_percent_discount" placeholder="" value="{{ old('max_percent_discount')??$promo_rule['max_percent_discount']??null }}" min="0" oninput="validity.valid||(value='');" autocomplete="off">
			</div>
		</div>
	</div>
</div>
@endSection

@section('discount-delivery-script')
<script type="text/javascript">
	$(document).ready(function() {
	$('input[name=discount_type]').change(function() {
			discount_value = $('input[name=discount_type]:checked').val();
			$('#discount-delivery-div').show();
			if (discount_value == 'Nominal') {
				$('input[name=discount_value]').removeAttr('max').val('').attr('placeholder', '100.000').inputmask({removeMaskOnSubmit: "true", placeholder: "", alias: "currency", digits: 0, rightAlign: false});
				$('#discount-delivery-value').text('Discount Nominal');
				$('#discount-delivery-addon, #discount-delivery-percent-max-div').hide();
				$('#delivery-addon-rp').show();
				$('#discount-delivery-group').addClass('col-md-12');
				$('#discount-delivery-group').removeClass('col-md-5');
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
				$('#discount-delivery-value').text('Discount Percent Value');
				$('#delivery-addon-rp').hide();
				$('#discount-delivery-addon, #discount-delivery-percent-max-div').show();
				$('#discount-delivery-group').addClass('col-md-5');
				$('#discount-delivery-group').removeClass('col-md-12');
			}
			$('input[name=discount_value]').removeAttr("style");
		});
	});
</script>
@endSection