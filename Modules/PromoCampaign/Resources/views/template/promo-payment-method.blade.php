@php
	switch ($promo_source) {
		case 'promo_campaign':
			$data = $result;
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
@endphp

@section('promo-payment-method')
<div class="form-group row">
	<div class="">
		<div class="col-md-6">
			<label class="control-label">Payment method</label>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih metode pembayaran" data-container="body" data-html="true"></i>
			<div class="mt-radio-inline">
				<label class="mt-radio mt-radio-outline"> All Payment Method
					<input type="radio" value="all_payment" name="filter_payment" @if(isset($data['is_all_payment']) && $data['is_all_payment'] === 1) checked @endif required/>
					<span></span>
				</label>
				<label class="mt-radio mt-radio-outline"> Selected Payment Method
					<input type="radio" value="selected_payment" name="filter_payment" id="checkbox-selected-payment" @if(empty($data['is_all_payment']) && $data['is_all_payment'] === 0)) checked @endif required/>
					<span></span>
				</label>
			</div>
			<div id="select-payment" 
				@if ( $data['is_all_payment'] !== 0  ) 
	        		style="display: none;" 
	        	@endif>
				<label class="control-label">Select Payment Method</label>
				<select name="payment_method[]" class="form-control select2 select2-hidden-accessible col-md-6" multiple="" tabindex="-1" aria-hidden="true">
					@php
						$selected_payment = [];
						if (old('payment_method')) {
							$selected_payment = old('payment_method');
						}
						elseif (!empty($data[$promo_source.'_payment_method'])) {
							$selected_payment = array_column($data[$promo_source.'_payment_method'], 'payment_method');
						}
					@endphp
	                @if (!empty($payment_list))
	                    @foreach($payment_list as $payment)
	                        <option value="{{ $payment['payment_method'] }}" 
	                        	@if ( $selected_payment??false ) 
	                        		@if( in_array($payment['payment_method'], $selected_payment) ) selected 
	                        		@endif 
	                        	@endif
	                        >{{ $payment['text'] }}</option>
	                    @endforeach
	                @endif
				</select>
			</div>
		</div>
	</div>
</div>
@endsection

@section('promo-payment-method-script')
<script type="text/javascript">
	$('input[name=filter_payment]').on('click', function(){
		let payment = $(this).val();
		if(payment == 'selected_payment') {
			$('#select-payment').show().prop('required', false);
		}
		else {
			$('#select-payment').hide().prop('required', false);
		}
	});
</script>
@endsection