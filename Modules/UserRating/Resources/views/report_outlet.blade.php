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
	table.table-feedback td{
		vertical-align: middle !important;
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
		$("#end_date").datetimepicker({
			format: "dd MM yyyy",
			autoclose: true,
		});
		$('a.more').on('click',function(){
			moveTo($(this).data('target'));
		});
		$('#transaction-type-input').on('change',function(){
			var name = $(this).attr('name');
			var status = $(this).val();
			$('#dumpInput').attr('name',name).val(status);
			$('#dumpSubmit').click();
		});
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
	<a href="{{url('user-rating/report')}}" class="btn blue"><i class="fa fa-chevron-left"></i> Show Summary</a>
</div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject font-dark sbold uppercase font-blue">Report Rating</span>
		</div>
		<div class="actions">
            <div class="form-group">
            	<select class="select2 form-control" id="transaction-type-input" name="transaction_type">
            		<option value="all">All Transaction</option>
            		<option value="online" {{$transaction_type == 'online' ? 'selected' : ''}}>Online Transaction</option>
            		<option value="offline" {{$transaction_type == 'offline' ? 'selected' : ''}}>Offline Transaction</option>
            	</select>
            </div>
        </div>
	</div>
	<div class="portlet-body">
		<div class="hidden">
			<form action="{{url('user-rating/report')}}" method="POST">
				@csrf
				<input type="text" id="dumpInput">
				<input type="submit" id="dumpSubmit">
			</form>
		</div>
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
			<div class="row">
				<div class="col-md-2 control-label">Order By</div>
				<div class="col-md-3">
					<div class="form-group">
						<select name="order" class="form-control">
							<option value="outlet_name" @if($order == 'outlet_name') selected @endif>Name</option>
							@for($i = 5; $i>0;$i--)
							<option value="rating{{$i}}" @if($order == 'rating'.$i) selected @endif>Total {{$i}} Star</option>
							@endfor
						</select>
					</div>
				</div>
				<div class="col-md-2 control-label">Search</div>
				<div class="col-md-3">
					<div class="form-group">
						<input type="text" name="search" placeholder="Search Outlet" class="form-control" value="{{$search}}">
					</div>
				</div>
			</div>
		</form>
		<div class="tabbable-line tab-custom">
			<table class="table table-striped table-bordered table-hover table-feedback">
				<thead>
					<tr>
						<th rowspan="2" class="text-center" style="vertical-align: middle;"> Outlet Name </th>
						<th colspan="5" class="text-center"> Total Rating </th>
						<th rowspan="2" class="text-center" style="vertical-align: middle;"> Action </th>
					</tr>
					<tr>
						<th class="text-center"> <i class="fa fa-star"></i> 1 </th>
						<th class="text-center"> <i class="fa fa-star"></i> 2 </th>
						<th class="text-center"> <i class="fa fa-star"></i> 3 </th>
						<th class="text-center"> <i class="fa fa-star"></i> 4 </th>
						<th class="text-center"> <i class="fa fa-star"></i> 5 </th>
					</tr>
				</thead>
				<tbody>
					@if($outlet_data)
					@foreach($outlet_data['data']??[] as $outlet)
					<tr>
						<td>{{$outlet['outlet_code'].' - '.$outlet['outlet_name']}}</td>
						<td class="text-center">{{$outlet['rating1']}}</td>
						<td class="text-center">{{$outlet['rating2']}}</td>
						<td class="text-center">{{$outlet['rating3']}}</td>
						<td class="text-center">{{$outlet['rating4']}}</td>
						<td class="text-center">{{$outlet['rating5']}}</td>
						<td><a class="btn green" href="{{url('user-rating/report/outlet/'.$outlet['outlet_code'])}}">Detail</a></td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="6" class="text-center"><em class="text-muted">No Feedback Found</em></td>
					</tr>
					@endif
				</tbody>
			</table>
			<div class="row">
	            <div class="col-md-offset-8 col-md-4 text-right">
	                <div class="pagination">
	                    <ul class="pagination">
	                         <li class="page-first{{$prev_page?'':' disabled'}}"><a href="{{$prev_page?:'javascript:void(0)'}}">«</a></li>
	                        
	                         <li class="page-last{{$next_page?'':' disabled'}}"><a href="{{$next_page?:'javascript:void(0)'}}">»</a></li>
	                    </ul>
	                </div>
	            </div>
			</div>
		</div>
	</div>
</div>
@endsection