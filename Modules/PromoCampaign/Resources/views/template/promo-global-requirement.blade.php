@include('promocampaign::template.promo-shipment-method', ['promo_source' => $promo_source])
{{-- @include('promocampaign::template.promo-payment-method', ['promo_source' => $promo_source]) --}}

@section('global-requirement')
	<div class="portlet light bordered" id="promo-global-form">
		<div class="portlet-title">
			<div class="caption font-blue ">
				<span class="caption-subject bold uppercase">GLobal Rule</span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="form-group" style="height: 55px;display: inline;">
				@yield('promo-shipment-method')
				@yield('promo-payment-method')
			</div>
		</div>
	</div>
@endsection

@section('global-requirement-script')
	@yield('promo-shipment-method-script')
	@yield('promo-payment-method-script')
@endsection