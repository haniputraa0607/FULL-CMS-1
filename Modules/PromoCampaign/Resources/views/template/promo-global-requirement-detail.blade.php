@php
	switch ($promo_source) {
		case 'promo_campaign':
			$data_global = $result;
			break;
		
		default:
			$data_global = $deals;
			break;
	}

	$payment_list_text = [];
	foreach ($payment_list??[] as $key => $value) {
		$payment_list_text[$value['payment_method']] = $value['text'];
	}
@endphp

<div class="row static-info">
    <div class="col-md-4 name">Shipment Method</div>
    <div class="col-md-1 value">:</div>
    <div class="col-md-7 value" style="margin-left: -35px">
    	@if ($data_global['is_all_shipment'] == '1')
            <div style="margin-left: -5px">All Shipment</div>
        @elseif ($data_global['is_all_shipment'] == '0')
        	@foreach ($data_global[$promo_source.'_shipment_method'] as $val)
        		<div style="margin-bottom: 10px">{{ '- '.$val['shipment_method'] }}</div>
        	@endforeach
        @else
            -
        @endif
    </div>
</div>
<div class="row static-info">
    <div class="col-md-4 name">Min Basket Size</div>
    <div class="col-md-8 value">: 
            {{ ($data_global['min_basket_size'] == 0) ? 'no min basket size' : 'IDR '.number_format($data_global['min_basket_size']) }}
    </div>
</div>
{{-- <div class="row static-info">
    <div class="col-md-4 name">Payment Method</div>
    <div class="col-md-1 value">:</div>
    <div class="col-md-7 value" style="margin-left: -35px">
    	@if ($data_global['is_all_payment'] == '1')
            <div style="margin-left: -5px">All Payment Method</div>
        @elseif ($data_global['is_all_payment'] == '0')
        	@foreach ($data_global[$promo_source.'_payment_method'] as $val)
        		<div style="margin-bottom: 10px">{{ '- '.($payment_list_text[$val['payment_method']] ?? $val['payment_method']) }}</div>
        	@endforeach
        @else
            -
        @endif
    </div>
</div> --}}