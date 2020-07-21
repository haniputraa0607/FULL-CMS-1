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
                <span class="caption-subject font-blue sbold uppercase">Promotion</span>
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
	                        <th> Send Time </th>
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
	                        <td>
                                @if(isset($value['promotion']['promotion_type']) && $value['promotion']['promotion_type'] == "Instant Campaign")
                                    {{date('d F Y', strtotime($value['promotion']['schedules'][0]['schedule_exact_date']))}} at {{substr($value['promotion']['schedules'][0]['schedule_time'],0,-3)}}
								@endif
								@if(isset($value['promotion']['promotion_type']) && $value['promotion']['promotion_type'] == "Scheduled Campaign")
                                    {{date('d F Y', strtotime($value['promotion']['schedules'][0]['schedule_exact_date']))}} at {{substr($value['promotion']['schedules'][0]['schedule_time'],0,-3)}}
								@endif

								@if(isset($value['promotion']['promotion_type']) && ($value['promotion']['promotion_type'] == "Recurring Campaign" || $value['promotion']['promotion_type'] == "Campaign Series"))
									@if(isset($value['promotion']['schedules'][0]['schedule_date_month']) && $value['promotion']['schedules'][0]['schedule_date_month'] != "")
										<?php
											$year = date('Y');
											$x = explode('-',$value['promotion']['schedules'][0]['schedule_date_month']);
										?>
										Every {{date('F', strtotime($year.'-'.$x[1].'-'.$x[0]))}}{{$x[0]}} each year at {{substr($value['promotion']['schedules'][0]['schedule_time'],0,-3)}}
									@endif
									@if(isset($value['promotion']['schedules'][0]['schedule_date_every_month']) && $value['promotion']['schedules'][0]['schedule_date_every_month'] != "")
										<?php
											$ends = array('th','st','nd','rd','th','th','th','th','th','th');
											if (($value['promotion']['schedules'][0]['schedule_date_every_month'] %100) >= 11 && ($value['promotion']['schedules'][0]['schedule_date_every_month']%100) <= 13)
											   $abbreviation = $value['promotion']['schedules'][0]['schedule_date_every_month']. 'th';
											else
											   $abbreviation = $value['promotion']['schedules'][0]['schedule_date_every_month']. $ends[$value['promotion']['schedules'][0]['schedule_date_every_month'] % 10];
										?>
										Every {{$abbreviation}} each month at {{substr($value['promotion']['schedules'][0]['schedule_time'],0,-3)}}
									@endif

									@if(isset($value['promotion']['schedules'][0]['schedule_day_every_week']) && $value['promotion']['schedules'][0]['schedule_day_every_week'] != "")
										<?php
											$ends = array('th','st','nd','rd','th','th','th','th','th','th');
											if (($value['promotion']['schedules'][0]['schedule_week_in_month'] %100) >= 11 && ($value['promotion']['schedules'][0]['schedule_week_in_month']%100) <= 13)
											   $abbreviation = $value['promotion']['schedules'][0]['schedule_week_in_month']. 'th';
											else
											   $abbreviation = $value['promotion']['schedules'][0]['schedule_week_in_month']. $ends[$value['promotion']['schedules'][0]['schedule_week_in_month'] % 10];
										?>
											Every {{$value['promotion']['schedules'][0]['schedule_day_every_week']}}

											@if($value['promotion']['schedules'][0]['schedule_week_in_month'] != 0)
												on {{$abbreviation}} week
											@else
												every week
											@endif
											at {{substr($value['promotion']['schedules'][0]['schedule_time'],0,-3)}}

									@endif

									@if(isset($value['promotion']['schedules'][0]['schedule_everyday']) && $value['promotion']['schedules'][0]['schedule_everyday'] == 'Yes')
										Every Day at {{substr($value['promotion']['schedules'][0]['schedule_time'],0,-3)}}
									@endif

								@endif
							</td>
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
