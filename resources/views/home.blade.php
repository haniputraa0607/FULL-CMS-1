@extends('layouts.main')

@section('page-style')
	<style type="text/css">
		.chartdiv {
			width   : 100%;
			height  : 400px;
		}
	</style>

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script>
	AmCharts.addInitHandler(function(chart) {
		// check if there are graphs with autoColor: true set
		var warna = [
            '#FF0F00',
            '#FF6600',
            '#FF9E01',
            '#FCD202',
            '#F8FF01',
            '#B0DE09',
            '#04D215',
            '#0D8ECF',
            '#0D52D1',
            '#2A0CD0',
        ];
		for(var i = 0; i < chart.graphs.length; i++) {
			var graph = chart.graphs[i];
			if (graph.autoColor !== true)
			continue;
			var colorKey = "autoColor-"+i;
			graph.lineColorField = colorKey;
			graph.fillColorsField = colorKey;
			for(var x = 0; x < chart.dataProvider.length; x++) {
			var color = warna[x]
			chart.dataProvider[x][colorKey] = color;
			}
		}

	}, ["serial"]);
</script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/table-datatables-scroller.min.js')}}" type="text/javascript"></script>
	<script>
		$('.sample').DataTable({
                "searching": false,
                "paging": false,
                "ordering": false,
                "info": false,
				"scrollY": 150,
        });
	</script>
@endsection

@section('content')

	<?php
		use App\Lib\MyHelper;
		$grantedFeature     = session('granted_features');
	?>

	@if(MyHelper::hasAccess([1], $grantedFeature))
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{url('/')}}">Home</a>
			</li>
		</ul>
	</div>
	<h1 class="page-title">
		<i class="fa fa-home font-blue"></i>
		<span class="caption-subject font-blue-sharp sbold">{{$title}}</span>
	</h1>
	<div class="portlet light">
		<div class="portlet-body">
			@include('layouts.notifications')
			Hello<br>
			<b>{{Session::get('name')}}</b><br>
			<b>{{Session::get('phone')}}</b><br><br>

			<?php setlocale(LC_MONETARY, 'id_ID'); ?>
			<?php date_default_timezone_set("Asia/Jakarta");
			$thn = $year;
			$bln = $month;

			$m_start    = date('m', strtotime($bln));
			$date_start = $thn.'-'.$m_start.'-01';

			$m_end      = date('m-t', strtotime($bln));
			$date_end   = $thn.'-'.$m_end;

			$thnnow = date('Y');
			$thnnowminspuluh = $thnnow - 20;
			?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="glyphicon glyphicon-stats"></i>
						<span class="caption-subject bold">Summary Data Filter</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						@if($thn == 'alltime' || strpos($thn, 'last') !== false)
							<div class="col-lg-3" style="margin-top:20px"></div>
						@else
							<div class="col-lg-2" style="margin-top:20px"></div>
						@endif
						<div class="col-lg-3" style="text-align:right;margin-top:20px">
							@if(strpos($thn, 'last') !== false)
								<select id="bulane" class="form-control" name="thn" onChange="gantiHome(this.value);">
									<option value="last7days" @if($thn == 'last7days') selected @endif>Last 1 Week</option>
									<option value="last30days" @if($thn == 'last30days') selected @endif>Last 30 Days</option>
									<option value="last3months" @if($thn == 'last3months') selected @endif>Last 3 Months</option>
								</select>
							@else
								<a href="{{URL::to('home')}}/last30days" class="btn grey btn-block">Last 30 Days</a>
							@endif
						</div>
						<div class="col-lg-3" style="text-align:right;margin-top:20px">
							@if($thn == 'alltime')
								<a href="{{URL::to('home')}}/alltime" class="btn green btn-block">All Time</a>
							@else
								<a href="{{URL::to('home')}}/alltime" class="btn grey btn-block">All Time</a>
							@endif
						</div>
						@if($thn == 'alltime' || strpos($thn, 'last') !== false)
							<div class="col-lg-3" style="text-align:right;margin-top:20px">
								<a href="{{URL::to('home/'.date('Y').'/'.date('m'))}}" class="btn grey btn-block">This Month</a>
							</div>
						@else
						<div class="col-lg-2" style="text-align:right;margin-top:20px">
							<select id="bulane" class="form-control" name="month" onChange="gantiHome();">
								<option value="1" @if($bln == '1') selected @endif>January</option>
								<option value="2" @if($bln == '2') selected @endif>February</option>
								<option value="3" @if($bln == '3') selected @endif>March</option>
								<option value="4" @if($bln == '4') selected @endif>April</option>
								<option value="5" @if($bln == '5') selected @endif>May</option>
								<option value="6" @if($bln == '6') selected @endif>June</option>
								<option value="7" @if($bln == '7') selected @endif>July</option>
								<option value="8" @if($bln == '8') selected @endif>August</option>
								<option value="9" @if($bln == '9') selected @endif>September</option>
								<option value="10" @if($bln == '10') selected @endif>October</option>
								<option value="11" @if($bln == '11') selected @endif>November</option>
								<option value="12" @if($bln == '12') selected @endif>December</option>
							</select>
						</div>
						<div class="col-lg-2" style="text-align:right;margin-top:20px">
						<select id="tahune" class="form-control" name="year" onChange="gantiHome();">
							@for($x = $thnnow; $x >= $thnnowminspuluh; $x-- )
							<option value="{{$x}}" @if($x == $thn) selected @endif>{{$x}}</option>
							@endfor
						</select>
						</div>
						@endif
					</div>
				</div>
			</div>

			@if(isset($dashboard['dashboard']) && !empty($dashboard['dashboard']))
				@foreach ($dashboard['dashboard'] as $item)
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="glyphicon glyphicon-stats"></i>
								<span class="caption-subject bold">
									{{$item['section_title']}}
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-12">
									@foreach ($item['dashboard_card'] as $card)
										@if(strpos($card['card_name'], 'Top 10') !== false)
										<div class="col-lg-12 col-xs-12 col-sm-12" style="margin-bottom:0;margin-top:20px">
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption">
														<i class="icon-share font-red-sunglo hide"></i>
														<span class="caption-subject font-dark bold uppercase">{{$card['card_name']}}</span>
													</div>
												</div>
												<div class="portlet-body">
													@if(strpos($card['card_name'], 'Table') !== false)
														<table class="table table-striped table-bordered table-hover order-column sample" style="margin-bottom:0">
															@if (!empty($card['value']))
																<thead>
																	<tr>
																		@php $head = array_keys($card['value'][0]); @endphp
																		@foreach(array_keys($card['value'][0]) as $header)
																			@if($header != 'id')
																				<th> {{ ucfirst(str_replace('_', ' ', $header)) }} </th>
																			@endif
																		@endforeach
																		<th>action</th>
																	</tr>
																</thead>
																<tbody>
																	@foreach($card['value'] as $value)
																		<tr>
																			@foreach($value as $q => $v)
																				@if($q != 'id')
																					@if(is_numeric($v) && substr($v, 0, 1) != '0')
																					<td>{{ number_format($v,0,',','.') }}</td>
																					@else
																					<td>{{ $v }}</td>
																					@endif
																				@endif
																			@endforeach
																			<td>
																				<a style="font-size: 9px;" class="btn btn-block yellow btn-xs"
																					@if(strpos($card['card_name'], 'User') !== false || strpos($card['card_name'], 'Customer') !== false)
																						href="{{ url('report/customer/detail/'.$value[$head[1]].'/transactions') }}">
																					@elseif(strpos($card['card_name'], 'Product') !== false)
																						href="{{ url('report/product/detail/'.$value[$head[1]].'/'.$card['url']) }}">
																					@elseif(strpos($card['card_name'], 'Outlet') !== false)
																						href="{{ url('report/outlet/detail/'.$value[$head[1]].'/'.$card['url']) }}">
																					@endif
																					<i class="icon-pencil"></i>
																					Detail
																				</a>
																			</td>
																		</tr>
																	@endforeach
																</tbody>
															@endif
														</table>
													@else
														<div id="chart-{{$card['id_dashboard_card']}}" class="chartdiv"></div>
														@if(!empty($card['value']))
														<script type="text/javascript">
															<?php
																$header = array_keys($card['value'][0]);
															?>
															<?php $dataGraphic =  json_encode($card['value']); ?>
															var chart = AmCharts.makeChart("chart-{{$card['id_dashboard_card']}}", {
															"type": "serial",
															"theme": "light",
															"marginRight": 70,
															"dataProvider": {!! $dataGraphic !!},
															"startDuration": 1,
															"graphs": [{
																"balloonText": "<b>[[category]]: [[value]]</b>",
																"fillAlphas": 0.9,
																"lineAlpha": 0.2,
																"type": "column",
																"valueField": "{{end($header)}}",
																"autoColor": true
															}],
															"chartCursor": {
																"categoryBalloonEnabled": false,
																"cursorAlpha": 0,
																"zoomable": false
															},
															"categoryField": "{{$header[0]}}",
															"categoryAxis": {
																"gridPosition": "start",
																"labelRotation": 45
															},
															"export": {
																"enabled": true
															}

															});
														</script>
														@endif
													@endif
												</div>
											</div>
										</div>
										@else
											<div class="col-md-4" style="margin-top:20px">
												<div class="dashboard-stat grey">
													<div class="visual">
														@if($card['card_name'] == 'Total Transaction Count')
															<i class="fa fa-check-square"></i>
														@elseif($card['card_name'] == 'Total Transaction Value')
															<i class="fa fa-money"></i>
														@elseif($card['card_name'] == 'Average Transaction')
															<i class="fa fa-balance-scale"></i>
														@elseif($card['card_name'] == 'Average Transaction per Day')
															<i class="fa fa-calculator"></i>
														@elseif($card['card_name'] == 'New Customer')
															<i class="fa fa-user-plus"></i>
														@elseif($card['card_name'] == 'Total IOS Customer')
															<i class="fa fa-apple"></i>
														@elseif($card['card_name'] == 'Total Android Customer')
															<i class="fa fa-android"></i>
														@elseif($card['card_name'] == 'Total Male Customer')
															<i class="fa fa-male"></i>
														@elseif($card['card_name'] == 'Total Female Customer')
															<i class="fa fa-female"></i>
														@elseif($card['card_name'] == 'Total Customer Not Verified' || $card['card_name'] == 'Total Customer Email Not Verified')
															<i class="fa fa-times-circle"></i>
														@elseif($card['card_name'] == 'Total Customer' || $card['card_name'] == 'Total User')
															<i class="fa fa-users"></i>
														@elseif($card['card_name'] == 'Total Customer Subscribed')
															<i class="fa fa-lock"></i>
														@elseif($card['card_name'] == 'Total Customer Unsubscribed')
															<i class="fa fa-unlock"></i>
														@elseif(strpos($card['card_name'], 'Admin') !== false)
															<i class="fa fa-user-secret"></i>
														@else
															<i class="fa fa-check-square"></i>
														@endif
													</div>
													<div class="details">
														<div class="number">
															<span data-counter="counterup" data-value="{{$card['value']}}">{{number_format($card['value'], 0, '.', ',')}}</span> </div>
														<div class="desc" style="font-size: 14px;">
															{{$card['card_name']}}
														</div>
													</div>

													@if(strpos($card['card_name'], 'Customer') !== false || strpos($card['card_name'], 'Admin') !== false || strpos($card['card_name'], 'User') !== false)
														<a class="more" href="{{url('report/customer/summary/?'.$card['url'])}}" style="font-size: 9px;">
															@if(strpos($card['card_name'], 'New') !== false )
																Register Within {{$dashboard['daterange']}}
															@else
																@if(strpos($dashboard['daterange'], 'days') !== false || strpos($dashboard['daterange'], 'months') !== false || strpos($dashboard['daterange'], 'time') !== false)
																	@if(strlen($card['card_name'].' (All Time)') > 21)
																		{{ substr(str_replace('Total', '', $card['card_name']),0,25) }} ... (All Time)
																	@else
																		{{ str_replace('Total', '', $card['card_name']) }} (All Time)
																	@endif
																@else
																	@if(strlen($card['card_name'].'(Until '.$dashboard['daterange'].')') > 21)
																		{{ substr(str_replace('Total', '', $card['card_name']),0,15) }} ... (Until {{$dashboard['daterange']}})
																	@else
																		{{ str_replace('Total', '', $card['card_name']) }} (Until {{$dashboard['daterange']}})
																	@endif
																@endif
															@endif
															<i class="m-icon-swapright m-icon-white"></i>
														</a>
													@else
														<a style="font-size: 9px;" class="more"
															@if(strpos($card['card_name'], 'Transaction') !== false )
																href="{{url('report/global/?'.$card['url'])}}">
																@if(strpos($dashboard['daterange'], 'months') !== false || strpos($dashboard['daterange'], 'days') !== false)
																	Last {{$dashboard['daterange']}}
																@else
																	{{$dashboard['daterange']}}
																@endif
															@endif
															<i class="m-icon-swapright m-icon-white"></i>
														</a>
													@endif
												</div>
											</div>
										@endif
									@endforeach
								</div>
							</div>
						</div>
					</div>
				@endforeach
		@endif

	</div>
	<script>
	function gantiHome(thn = null){
		if(thn == null){
			var bulane = document.getElementById('bulane').value;
			var tahune = document.getElementById('tahune').value;
			var lokasine = "{{URL::to('home')}}/"+tahune+"/"+bulane;
		}else{
			var lokasine = "{{URL::to('home')}}/"+thn;
		}
		window.location.href = lokasine;
	}
	</script>
	@endif

@endsection
