@extends('layouts.main')
@include('infinitescroll')
@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
@yield('is-style')
@endsection

@section('page-plugin')
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<!-- <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script> -->
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@yield('is-script')
<script>
	function reloadData($all=true,callback=null){
		if($all){
			ISReset($('#table-user'));
		}
		$.post({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
			},
			url: "{!!url('referral/report/user-summary')!!}",
			data: {
				ajax:1,
				phone: "{{$report['phone']}}"
			},
			success: function(response){
				var xcolor = color;
				new_chart = response.data.map(function(vrb){
					vrb.trx_date = new Date(vrb.trx_date).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"});
					var index = Math.floor(Math.random()*color.length);
					vrb.color = color[index];
					xcolor.splice(index,1);
					return vrb;
				});
				chart_user.dataProvider = new_chart;
				chart_user.validateData();
			}
		}).always( data => {
			if(typeof(callback) == 'function'){
				callback(data);
			}
		});	
	}
	function priceCell(table,response){
		$(`.page${table.data('page')+1} .price`).inputmask('numeric',{
			removeMaskOnSubmit: true,
			min:0,
			prefix: "Rp",
			autoGroup: true,
			radixPoint: ",",
			groupSeparator: ".",
			rightAlign: false
		});
		table.parents('.is-container').find('.total-record').text(response.total?response.total:0).val(response.total?response.total:0);
		$('.is-container .total-record').inputmask('numeric',{
			removeMaskOnSubmit: true,
			min:0,
			autoGroup: true,
			radixPoint: ",",
			groupSeparator: ".",
			rightAlign: false
		});
	}
	template = {
		user: function(item){
			return `
			<tr class="page${item.page}">
			<td>${item.increment}</td>
			<td>${new Date(item.created_at).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit"})}</td>
			<td><a href="/user/detail/${item.id_user}">${item.user.name} (${item.user.phone})</a></td>
			<td><a href="transaction/detail/${item.transaction.id_transaction}/${item.transaction.trasaction_type}">${item.transaction.transaction_receipt_number}</a></td>
			<td><span class="price">${item.transaction.transaction_grandtotal}</span></td>
			<td><span class="price">${item.referrer_bonus?item.referrer_bonus:0}</span></td>
			</tr>
			`;
		}
	};
	var chart_user = AmCharts.makeChart("chart-user", {
		"type": "serial",
		"theme": "none",
		"marginRight": 70,
		"dataProvider": [
		],
		"valueAxes": [{
			"axisAlpha": 0,
			"position": "left",
			"title": "Number of Referred User"
		}],
		"startDuration": 1,
		"graphs": [{
			"balloonText": "<b>[[category]]: [[value]]</b>",
			"fillColorsField": "color",
			"fillAlphas": 0.9,
			"lineAlpha": 0.2,
			"type": "column",
			"valueField": "total"
		}],
		"chartCursor": {
			"categoryBalloonEnabled": false,
			"cursorAlpha": 0,
			"zoomable": false
		},
		"categoryField": "trx_date",
		"categoryAxis": {
			"gridPosition": "start",
			"labelRotation": 45
		},
		"export": {
			"enabled": false
		},
		"titles": [
		{
			"text": "Referral Transaction Chart",
			"size": 15
		}]
	});
	var color = ["#e1e5ec","#2f353b","#3598dc","#578ebe","#2C3E50","#22313F","#67809F","#4B77BE","#4c87b9","#5e738b","#5C9BD1","#94A0B2","#32c5d2","#1BBC9B","#1BA39C","#36D7B7","#44b6ae","#26C281","#3faba4","#4DB3A2","#2ab4c0","#29b4b6","#E5E5E5","#e9edef","#fafafa","#555555","#95A5A6","#BFBFBF","#ACB5C3","#bfcad1","#525e64","#e7505a","#E08283","#E26A6A","#e35b5a","#D91E18","#EF4836","#d05454","#f36a5a","#e43a45","#c49f47","#E87E04","#f2784b","#f3c200","#F7CA18","#F4D03F","#c8d046","#c5bf66","#c5b96b","#8E44AD","#8775a7","#BF55EC","#8E44AD","#9B59B6","#9A12B3","#8775a7","#796799","#8877a9"];
	$(document).ready(function(){
		$('.price').inputmask('numeric',{
			removeMaskOnSubmit: true,
			min:0,
			prefix: "Rp",
			autoGroup: true,
			radixPoint: ",",
			groupSeparator: ".",
			rightAlign: false
		});
		$("#end_date,#start_date").datetimepicker({
			format: "dd MM yyyy",
			autoclose: true,
		});
		$(document).on('submit','#form-user',function(e){
			var formdata = $(this).serializeArray();
			var senddata = {ajax:1};
			formdata.forEach(function(input){
				senddata[input.name] = input.value;
			});
			$(this).find('.filter-btn').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>').attr('disabled','disabled');
			$.post({
				url: "{{url('referral/report')}}",
				data: senddata,
				success:response => {
					if(response.status == 'success'){
						reloadData(true,() => {
							$(this).find('.filter-btn').html('Apply').removeAttr('disabled');
						});
					}else{
						alert("Failed apply filter");
					}
				},
				error: function(err){
					alert("Failed apply filter");
					$(this).find('.filter-btn').html('Apply').removeAttr('disabled');
				}
			});
			e.preventDefault();
		});
		reloadData(false);
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
	<a href="{{url('referral/report')}}" class="btn blue"><i class="fa fa-chevron-left"></i> Show Referral Code List</a>
</div>
<div class="portlet light portlet-fit bordered">
	<div class="portlet-title">
		<div class="caption w-100">
			<span class="caption-subject font-blue sbold uppercase"> Referral Detail for {{$report['name']}} ({{$report['phone']}})</span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row" style="margin-bottom: 15px;">
			<div class="col-md-4">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-star-o"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$report['referral_code']}}</span> 
						</div>
						<div class="desc">
							Referral Code
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-user-plus"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0">{{$report['number_transaction']}}</span> 
						</div>
						<div class="desc">
							Number of Referred User
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-dollar"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="0"><span class="price">{{$report['cashback_earned']}}</span></span> 
						</div>
						<div class="desc">
							Total Cashback Earned
						</div>
					</div>
				</div>
			</div>
		</div>
		<form action="{{url('referral/report')}}" class="form-horizontal" method="POST" id="form-user">
			<input type="hidden" name="type" value="user">
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
				<div class="col-md-2"><button class="btn green filter-btn">Apply</button></div>
			</div>
		</form>
		<div class="container-fluid">
			<div id="chart-user" style="height: 400px"></div>
		</div>
		<div class="table-responsive is-container">
			<div class="table-infinite">
				<table class="table table-hover" data-template="user" data-page="0" data-is-loading="0" data-is-last="0" data-url="{{ url('referral/report/user?phone='.$report['phone']) }}" data-callback="priceCell" id="table-user">
					<thead>
						<tr class="header-table">
							<th style="width: 1%">No</th>
							<th data-order="promo_campaign_referral_transactions.created_at">Date</th>
							<th data-order="id_user">Referred User</th>
							<th>Transaction Receipt Number</th>
							<th data-order="referred_bonus">Grand Total</th>
							<th data-order="referrer_bonus">Earned Cashback</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div><span class="text-muted">Total record: </span><span class="total-record"></span></div>
		</div>
	</div>
</div>
@endsection
