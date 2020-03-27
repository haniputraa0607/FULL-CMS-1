<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')
@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script>
	$('.table-scrollable').on('show.bs.dropdown', function () {
		$('.table-scrollable').css( "overflow", "inherit" );
	});

	$('.table-scrollable').on('hide.bs.dropdown', function () {
		$('.table-scrollable').css( "overflow", "auto" );
	})
	$(document).ready(function(){
		$('.select2').select2();
	});
</script>
@yield('child-script')
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
		</li>
	</ul>
</div>
@include('layouts.notifications')
@yield('filter')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light portlet-fit bordered" >
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-blue sbold uppercase"><i class="fa fa-list"></i> {{$table_title}} </span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-bottom:20px;">
					<form action="{{ url('point-injection') }}" method="post">
						{{ csrf_field() }}
						<div class="col-md-2" style="padding-left:0px;padding-right:0px;">
							<select name="take" class="form-control select2">
								<option value="10" @if($take == 10) selected @endif>Show 10 Data</option>
								<option value="50" @if($take == 50) selected @endif>Show 50 Data</option>
								<option value="100" @if($take == 100) selected @endif>Show 100 Data</option>
								<option value="9999999999" @if($take == 9999999999) selected @endif>Show All Data</option>
							</select>
						</div>
						<div class="col-md-3" style="padding-left:0px;padding-right:0px;">
							<select name="order_field" class="form-control select2">
								<option value="point_injections.id_point_injection" @if($order_field == 'point_injections.id_point_injection') selected @endif>Order by ID</option>
								<option value="point_injections.title" @if($order_field == 'point_injections.title') selected @endif>Order by Title</option>
								<option value="point_injections.start_date" @if($order_field == 'point_injections.start_date') selected @endif>Order by Date Start</option>
								<option value="point_injections.created_at" @if($order_field == 'point_injections.created_at') selected @endif>Order by Date Created</option>
							</select>
						</div>
						<div class="col-md-2" style="padding-left:0px;padding-right:0px">
							<select name="order_method" class="form-control select2">
								<option value="desc" @if($order_method == 'desc') selected @endif>Desc</option>
								<option value="asc" @if($order_method == 'asc') selected @endif>Asc</option>
							</select>
						</div>
						<div class="col-md-1" style="padding-left:0px;padding-right:0px;text-align:right">
							<button type="submit" class="btn yellow">Show</button>
						</div>
					</form>
				</div>
				<div class="col-md-12" style="text-align:right;margin-right:0px;padding-right:0px;margin-bottom:20px;">
				</div>
				<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th scope="col" style="width:20px !important"> No </th>
								<th scope="col" style="width:100px !important"> Title </th>
								<th scope="col"> Creator </th>
								<th scope="col" style="width:200px !important"> Created </th>
								<th scope="col"> Send Type </th>
								<th scope="col"> Start Date </th>
								<th scope="col"> Send Time </th>
								<th scope="col"> Total Point </th>
								<th scope="col" style="width:20px !important"> Action </th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($content))
							@foreach($content as $no => $data)
							<tr>
								<td> {{$no+1}} </td>
								<td> {{$data['title']}} </td>
								<td> {{$data['user']['name']}} </td>
								<td> {{date("d F Y", strtotime($data['created_at']))}}&nbsp;{{date("H:i", strtotime($data['created_at']))}} </td>
								<td> {{$data['send_type']}} </td>
								<td> {{date("d F Y", strtotime($data['start_date']))}} </td>
								<td> {{date("H:i", strtotime($data['send_time']))}} </td>
								<td> {{number_format($data['total_point'])}} </td>
								<td>
									<div class="btn-group pull-right">
										<button class="btn blue btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Actions
										<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu pull-right">
											<li>
												<a href="{{ url('point-injection/review') }}/{{ $data['id_point_injection'] }}">
												<i class="fa fa-edit"></i> Review Information </a>
											</li>
											@if (implode(' ',[$data['start_date'], $data['send_time']]) >= date("Y-m-d H:i"))
											<li>
												<a href="{{ url('point-injection/edit') }}/{{ $data['id_point_injection'] }}">
												<i class="fa fa-edit"></i> Edit Information </a>
											</li>
											<li>
												<a href="{{ url('point-injection/delete') }}/{{ $data['id_point_injection'] }}">
												<i class="fa fa-trash"></i> Delete Point Injection </a>
											</li>
                                            @endif
											@if(MyHelper::hasAccess([243], $grantedFeature))
											<li>
												<a href="{{ url('point-injection/report') }}/{{ $data['id_point_injection'] }}">
													<i class="fa fa-edit"></i> Report Point Injection </a>
											</li>
											@endif
										</ul>
									</div>
								</td>
							</tr>
							@endforeach
							@endif

						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:20px">
				<div class="col-md-12" style="padding-left:0px;padding-right:0px;">
					<div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
						<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
							@if($page <= 1) <li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
							@else <li class="page-first"><a href="{{url('point-injection')}}/page/{{$page-1}}">«</a></li>
							@endif

							@if($last == $count) <li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
							@else <li class="page-last"><a href="{{url('point-injection')}}/page/{{$page+1}}">»</a></li>
							@endif
						</ul>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection