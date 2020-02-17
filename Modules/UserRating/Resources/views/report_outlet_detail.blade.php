@extends('layouts.main')

@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<style>
	.tab-custom{
		border: 1px solid #eef1f5 !important;
	}
	.tab-custom .tab-content{
		padding: 0 !important;
	}
	.tab-content.scroll{
		max-height: 75vh;
		overflow-y: auto;
	}
	.tab-content thead{
		position: sticky;
		top: 0;
		background: white;
		border-bottom: 1px solid grey;
	}
	#slider{
		height: 400px;
		position: relative;
		overflow: hidden;
	}
	#slider .slide{
		width: 100%;
		left: 0;
		top: -150%;
		display: inline-block;
		transition-duration: .5s;
		position: absolute;
	}
	#slider.total_summary #total_summary{
		top: 0;
	}
	#slider.positive_summary #positive_summary{
		top: 0;
	}
	#slider.neutral_summary #neutral_summary{
		top: 0;
	}
	#slider.negative_summary #negative_summary{
		top: 0;
	}
</style>
@endsection

@section('page-script')
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script>
	$(document).ready(function(){		
		$("#start_date").datetimepicker({
			format: "dd MM yyyy",
			autoclose: true,
		});
		$(document).on('shown.bs.tab','a[data-toggle="tab"]', function (e) { console.log($(this).data('value')); });
	});
	$(document).ready(function(){		
		$("#end_date").datetimepicker({
			format: "dd MM yyyy",
			autoclose: true,
		});
		$('a.more').on('click',function(){
			moveTo($(this).data('target'));
		});
	});
	$('.checkbox-reload').on('change',function(){
		var name = $(this).attr('name');
		var status = $(this).is(':checked')?1:0;
		$('#dumpInput').attr('name',name).val(status);
		$('#dumpSubmit').click();
	})
</script>

<script type="text/javascript">

	var chart = AmCharts.makeChart("chartdiv", {
		"type": "pie",
		"theme": "light",
		"dataProvider": [
		{
			"name":"5 Star",
			"total":{{$reportData['outlet_data']['rating5']}},
			"color":"#32c5d2"
		},
		{
			"name":"4 Star",
			"total":{{$reportData['outlet_data']['rating4']}},
			"color":"#36D7B7"
		},
		{
			"name":"3 Star",
			"total":{{$reportData['outlet_data']['rating3']}},
			"color":"#F7CA18"
		},
		{
			"name":"2 Star",
			"total":{{$reportData['outlet_data']['rating2']}},
			"color":"#EF4836"
		},
		{
			"name":"1 Star",
			"total":{{$reportData['outlet_data']['rating1']}},
			"color":"#D91E18"
		}
		],
		"alignLabels": false,
		"valueField": "total",
		"titleField": "name",
		"colorField": "color",
		"balloon": {
			"fixedPosition": true
		},
		"export": {
			"enabled": false
		},
		"legend": {
		    "useGraphSettings": true,
		    "position": "right"
		},
		"titles": [
		{
			"text": "User Rating Summary",
			"size": 15
		}
		]
	});
</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>{{ $title }}</span>
			@if (!empty($sub_title))
			<i class="fa fa-circle"></i>
			@endif
		</li>
		@if (!empty($sub_title))
		<li>
			<span>{{ $sub_title }}</span>
		</li>
		@endif
	</ul>
</div><br>

@include('layouts.notifications')
<div class="form-group">
	<a href="{{url('user-rating/report/outlet')}}" class="btn blue"><i class="fa fa-chevron-left"></i> Show All Outlet</a>
	<a href="{{url('user-rating/report')}}" class="btn blue"><i class="fa fa-circle-o"></i> Show Summary</a>
</div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject font-dark sbold uppercase font-blue">Report Feedback Outlet {{$reportData['outlet_data']['outlet_name']}}</span>
		</div>
	</div>
	<div class="portlet-body">
		<form action="{{url('user-rating/report')}}" class="form-horizontal" method="POST">
			@csrf
			<div class="row">
				<label class="col-md-2 control-label">Date Start</label>
				<div class="col-md-3">
					<div class="form-group">
						<div class="input-group">
							<input required autocomplete="off" id="start_date" type="text" class="form-control" name="date_start" placeholder="Start Date" value="{{$date_start}}">
							<span class="input-group-btn">
								<button class="btn default date-set" type="button">
									<i class="fa fa-calendar"></i>
								</button>
							</span>
						</div>
					</div>
				</div>
				<label class="col-md-2 control-label">Date End</label>
				<div class="col-md-3">
					<div class="form-group">
						<div class="input-group">
							<input required autocomplete="off" id="end_date" type="text" class="form-control" name="date_end" placeholder="End Date" value="{{$date_end}}">
							<span class="input-group-btn">
								<button class="btn default date-set" type="button">
									<i class="fa fa-calendar"></i>
								</button>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-2"><button class="btn green">Apply</button></div>
			</div>
		</form>		<div class="row" style="margin-bottom: 20px">
			@php $col = '4' @endphp
			<div class="col-md-{{$col}}">
				<div class="dashboard-stat blue">
					<div class="visual">
						<i class="fa fa-star-o"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{array_sum([$reportData['outlet_data']['rating1'],$reportData['outlet_data']['rating2'],$reportData['outlet_data']['rating3'],$reportData['outlet_data']['rating4'],$reportData['outlet_data']['rating5']])}}</span> 
						</div>
						<div class="desc">
							Total User Rating
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-{{$col}}">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-thumbs-o-up"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$reportData['outlet_data']['rating5']??0}}</span> 
						</div>
						<div class="desc">
							<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> 5
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-{{$col}}">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-thumbs-o-up"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$reportData['outlet_data']['rating4']??0}}</span> 
						</div>
						<div class="desc">
							<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> 4
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-{{$col}}">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-thumbs-o-up"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$reportData['outlet_data']['rating3']??0}}</span> 
						</div>
						<div class="desc">
							<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> 3
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-{{$col}}">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-thumbs-o-up"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$reportData['outlet_data']['rating2']??0}}</span> 
						</div>
						<div class="desc">
							<i class="fa fa-star"></i> <i class="fa fa-star"></i> 2
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-{{$col}}">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-thumbs-o-up"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$reportData['outlet_data']['rating1']??0}}</span> 
						</div>
						<div class="desc">
							<i class="fa fa-star"></i> 1
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="slider" class="total_summary">
			<div class="slide" id="total_summary">
				<div id="chartdiv" style="height: 400px"></div>
			</div>
			<div class="slide" id="summary1">
				<div id="chartdiv1" style="height: 400px"></div>
			</div>
			<div class="slide" id="summary2">
				<div id="chartdiv2" style="height: 400px"></div>
			</div>
			<div class="slide" id="summary3">
				<div id="chartdiv3" style="height: 400px"></div>
			</div>
			<div class="slide" id="summary4">
				<div id="chartdiv4" style="height: 400px"></div>
			</div>
			<div class="slide" id="summary5">
				<div id="chartdiv5" style="height: 400px"></div>
			</div>
		</div>
		<div>
			<div class="hidden">
				<form action="{{url('user-rating/report')}}" method="POST">
					@csrf
					<input type="text" id="dumpInput">
					<input type="submit" id="dumpSubmit">
				</form>
			</div>
			<div style="width: 136px;padding: 13px 13px 0 0" class="pull-right">
				<div class="md-checkbox">
					<input type="checkbox" id="checkbox1" name="notes_only" class="md-checkboxbtn checkbox-reload" @if($notes_only) checked @endif>
					<label for="checkbox1">
						<span></span>
						<span class="check"></span>
						<span class="box"></span> With notes </label>
						<i class="fa fa-question-circle tooltips" data-original-title="jika dicentang maka akan menampilkan yang mengisikan catatan" data-container="body"></i>
					</label>
				</div>
			</div>
		</div>
		<div class="tabbable-line tab-custom">
			<ul class="nav nav-tabs ">
				<li class="active">
					<a href="#tab_5star" data-toggle="tab" aria-expanded="false" data-value="5"> 5 Star </a>
				</li>
				<li>
					<a href="#tab_4star" data-toggle="tab" aria-expanded="false" data-value="4"> 4 Star </a>
				</li>
				<li>
					<a href="#tab_3star" data-toggle="tab" aria-expanded="false" data-value="3"> 3 Star </a>
				</li>
				<li>
					<a href="#tab_2star" data-toggle="tab" aria-expanded="false" data-value="2"> 2 Star </a>
				</li>
				<li>
					<a href="#tab_1star" data-toggle="tab" aria-expanded="false" data-value="1"> 1 Star </a>
				</li>
			</ul>
			<div class="tab-content scroll">
				@for($i = 5; $i>0 ; $i--)
				<div class="tab-pane {{$i==5?'active':''}}" id="tab_{{$i}}star" data-value="{{$i}}">
					<table class="table table-hover table-feedback">
						<thead>
							<tr>
								<th> Create Feedback Date </th>
								<th> Receipt Number </th>
								<th> User </th>
								<th> Grand Total </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							@if($reportData['rating_item']['data'][$i]??false)
							@foreach($reportData['rating_item']['data'][$i] as $feedback)
							<tr>
								<td>{{date('d M Y',strtotime($feedback['created_at']))}}</td>
								<td><a href="{{url('transaction/detail'.'/'.$feedback['transaction']['id_transaction'].'/'.strtolower($feedback['transaction']['trasaction_type']))}}">{{$feedback['transaction']['transaction_receipt_number']}}</a></td>
								<td><a href="{{url('user/detail'.'/'.$feedback['user']['phone'])}}">{{$feedback['user']['name']}}</a></td>
								<td>Rp {{number_format($feedback['transaction']['transaction_grandtotal'],0,',','.')}}</td>
								<td><a href="{{url('user-rating/detail/'.$feedback['id_user_rating'])}}" class="btn blue">Detail</a></td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="6" class="text-center"><em class="text-muted">No Feedback Found</em></td>
							</tr>
							@endif
							<tr>
								<td colspan="5" class="text-center">
									<form action="{{url('user-rating')}}" method="POST">
										@csrf
										<input type="hidden" name="rule[0][subject]" value="star">
										<input type="hidden" name="rule[0][operator]" value="=">
										<input type="hidden" name="rule[0][parameter]" value="{{$i}}">
										<input type="hidden" name="rule[2][subject]" value="notes_only">
										<input type="hidden" name="rule[2][parameter]" value="{{$notes_only?'1':'0'}}">
										<input type="hidden" name="rule[3][subject]" value="review_date">
										<input type="hidden" name="rule[3][operator]" value=">=">
										<input type="hidden" name="rule[3][parameter]" value="{{date('Y-m-d',strtotime($date_start))}}">
										<input type="hidden" name="rule[4][subject]" value="review_date">
										<input type="hidden" name="rule[4][operator]" value="<=">
										<input type="hidden" name="rule[4][parameter]" value="{{date('Y-m-d',strtotime($date_end))}}">
										<input type="hidden" name="rule[5][subject]" value="outlet">
										<input type="hidden" name="rule[5][operator]" value="{{$reportData['outlet_data']['id_outlet']}}">
										<input type="hidden" name="operator" value="and">
										<input type="hidden" name="redirect" value="user-rating">
										<button class="btn btn-block"> Show all </button>
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				@endfor
			</div>
		</div>
		</div>
	</div>
</div>
@endsection