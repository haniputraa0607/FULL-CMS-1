<?php 
	use App\Lib\MyHelper;
 ?>
{{-- @include('deals::deals.participate_filter') --}}
@section('detail-participate')
<div class="portlet-body form">
	{{-- @yield('filter') --}}
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Participant</span>
            </div>
        </div>
        <div class="portlet-body form">
        	<div class="table-scrollable">
				<table class="table table-striped table-bordered table-hover">
            {{-- <table class="table table-striped table-bordered table-hover order-column" id="participate_tables"> --}}
	                <thead>
	                    <tr>
	                        <th> Promotion Name </th>
	                        <th> type </th>
	                        <th> Detail </th>
	                    </tr>
	                </thead>
	                <tbody>
	                @if (!empty($promotion))
	                @php
	                	// dd($promotion);
	                @endphp
	                @foreach($promotion as $value)
	                	@php
	                		$value['id_deals'] = MyHelper::createSlug($value['deals']['id_deals'], $value['deals']['created_at'])
	                	@endphp
	                    <tr>
	                        <td nowrap> {{ $value['promotion']['promotion_name'] }} </td>
	                        <td nowrap> {{ $value['promotion']['promotion_type'] }} </td>
	                        <td nowrap>
	                        	<a href="{{ url('promotion/') }}/step3/{{ $value['id_promotion'] }}" class="btn btn-sm blue">promotion</i></a>
	                        	<a href="{{ url('promotion-deals/'.$value['id_deals']) }}" class="btn btn-sm blue">deals</i></a>
	                        </td>
	                    </tr>
	                @endforeach
	                </tbody>
	                @endif
	            </table>
        	</div>
            @if ($promotionPaginator)
            {{ $promotionPaginator->fragment('participate')->links() }}
          @endif
        </div>
    </div>
</div>
@endsection
