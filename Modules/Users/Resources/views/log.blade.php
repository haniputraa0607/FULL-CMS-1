@extends('layouts.main')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script>
	function centang(no){
		alert(no);
	}

	function checkUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = true;
		}
	}

	function uncheckUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = false;
		}
	}

	// function viewLogDetail(url, status, request, response, ip, useragent){
	function viewLogDetail(id_log, log_type){
		$.get("{{url('user/ajax/log')}}"+'/'+id_log+'/'+log_type, function(result){
			console.log(result)
			if(result){
				document.getElementById("log-url").value = result.url;
				document.getElementById("log-status").value = result.response_status;
				document.getElementById("log-request").innerHTML = JSON.stringify(JSON.parse(result.request), null, 4);
				document.getElementById("log-response").innerHTML = JSON.stringify(JSON.parse(result.response), null, 4);
				document.getElementById("log-ip").value = result.ip;
				document.getElementById("log-useragent").value = result.useragent;
				$('#logModal').modal('show');
			}
		})
	}
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
            <i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="{{url('/user')}}">User</a>
            <i class="fa fa-circle"></i>
		</li>
		<li class="active"><a href="{{url('/user/activity')}}">Log Activity</a></li>
	</ul>
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<form role="form" action="{{ url('user/activity') }}" method="post">
			{{ csrf_field() }}
			@include('filter-log')
		</form>
	</div>
	<div class="col-md-12">
		<div class="portlet light portlet-fit bordered" >
			<div class="portlet-body">
				@if(Session::has('form-log'))
					<?php
						$search_param = Session::get('form-log');
						$search_param = array_filter($search_param);
					?>
					<div class="alert alert-block alert-success fade in">
						<button type="button" class="close" data-dismiss="alert"></button>
						<h4 class="alert-heading">Displaying search result with parameter(s):</h4>
						@if(isset($search_param['conditions']))
						@foreach($search_param['conditions'] as $row)
							<p>{{ucwords(str_replace("_"," ",$row['subject']))}}
							@if($row['parameter'] != "") {{str_replace("-"," - ",$row['operator'])}}{{str_replace("-"," - ",$row['parameter'])}}
							@else : {{str_replace("-"," - ",$row['operator'])}}
							@endif
							</p>
						@endforeach
						@endif
						<br>
						<p>
							<a href="{{ url('user/search/reset') }}" class="btn yellow">Reset</a>
						</p>
					</div>
				@endif
				<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-bottom:20px;">
					<form action="{{ url('user/activity') }}" method="post">
					{{ csrf_field() }}
					<div class="col-md-2" style="padding-left:0px;padding-right:0px;">
						<select name="take" class="form-control select2">
							<option value="10" @if($take == 10) selected @endif>Show 10 Data</option>
							<option value="50" @if($take == 50) selected @endif>Show 50 Data</option>
							<option value="100" @if($take == 100) selected @endif>Show 100 Data</option>
							<option value="9999999999" @if($take == 9999999999) selected @endif>Show ALL Data</option>
						</select>
					</div>
					<div class="col-md-3" style="padding-left:0px;padding-right:0px;">
						<select name="order_field" class="form-control select2">
							<option value="id" @if($order_field == 'id') selected @endif>Order by ID</option>
							<option value="name" @if($order_field == 'name') selected @endif>Order by Name</option>
							<option value="phone" @if($order_field == 'phone') selected @endif>Order by Phone</option>
							<option value="email" @if($order_field == 'email') selected @endif>Order by Email</option>
							<option value="subject" @if($order_field == 'subject') selected @endif>Order by Subject</option>
							<option value="created_at" @if($order_field == 'created_at') selected @endif>Order by Created At</option>
							<option value="response_status" @if($order_field == 'status') selected @endif>Order by Status</option>
							<option value="request" @if($order_field == 'request') selected @endif>Order by Request</option>
							<option value="response" @if($order_field == 'response') selected @endif>Order by Response</option>
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

				<div class="portlet light portlet-fit bordered">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-red sbold uppercase">Log Activity User</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tabbable-line tabbable-full-width">
							<ul class="nav nav-tabs">
								<li class=" @if(!isset($tipe)) active @endif">
									<a href="#log_mobile" data-toggle="tab"> Mobile </a>
								</li>
								<li class=" @if(isset($tipe) && $tipe == 'backend') active @endif">
									<a href="#log_backend" data-toggle="tab"> Backend </a>
								</li>
							</ul>
						</div>
						<div class="tab-content" style="margin-top:20px">
							<div class="tab-pane @if(!isset($tipe)) active @endif" id="log_mobile">
								<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover">
										<thead>
										<tr>
											<th scope="col" style="width:450px !important"> No </th>
											<th scope="col"> Actions </th>
											<th scope="col"> Date Time </th>
											<th scope="col"> Name </th>
											<th scope="col"> Phone </th>
											<th scope="col"> Status </th>
											<th scope="col"> Subject </th>
											<th scope="col"> Email </th>
											<th scope="col"> IP </th>
											<th scope="col"> User Agent </th>

										</tr>
										</thead>
										<tbody>
										<form action="{{ url('user') }}" method="post">
											{{ csrf_field() }}
											@if(!empty($content['mobile']))
												@foreach($content['mobile'] as $no => $data)

													@if($data['response_status'] == 'fail')
														<tr style="color:red">
													@else
														<tr>
															@endif
															<td> {{$no+1}}
															</td>
															<td>
																<a class="btn btn-block green btn-xs" onClick="viewLogDetail('{{$data['id_log_activities_apps']}}','apps')" href="#"><i class="icon-pencil"></i> Detail </a>
																<a class="btn btn-block red btn-xs" href="{{ url('user/delete/logApp', $data['id_log_activities_apps']) }}" data-toggle="confirmation" data-placement="top"><i class="icon-tag"></i> Delete </a>
															</td>
															<td> {!!str_replace(" ","&nbsp;", date('d F Y H:i', strtotime($data['created_at'])))!!} </td>
															<td> {!!str_replace(" ","&nbsp;", $data['name'])!!} </td>
															<td> {{$data['phone']}} </td>
															<td> {{$data['response_status']}} </td>
															<td> {!!str_replace(" ","&nbsp;", $data['subject'])!!} </td>
															<td> {!!str_replace(" ","&nbsp;", $data['email'])!!} </td>
															<td> {{$data['ip']}} </td>
															<td> {!!str_replace(" ","&nbsp;", $data['useragent'])!!} </td>
														</tr>
													@endforeach
											@else
												<td colspan="12" style="text-align:center"> Data is empty</td>
											@endif
										</tbody>
									</table>
								</div>
								<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:25px">
									<div class="col-md-5" style="padding-left:0px;padding-right:0px;">

									</div>
									<div class="col-md-3" style="padding-left:0px;padding-right:0px;">

									</div>
									<div class="col-md-4" style="padding-left:0px;padding-right:0px;">
										<div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
											<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
												@if($page <= 1) <li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
												@else <li class="page-first"><a href="{{url('user')}}/activity/{{$page-1}}">«</a></li>
												@endif

												@if($last == $total['mobile']) <li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
												@else <li class="page-last"><a href="{{url('user')}}/activity/{{$page+1}}">»</a></li>
												@endif
											</ul>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane @if(isset($tipe) && $tipe == 'backend') active @endif" id="log_backend">
								<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover">
										<thead>
										<tr>
											<th scope="col" style="width:450px !important"> No </th>
											<th scope="col"> Actions </th>
											<th scope="col"> Date Time </th>
											<th scope="col"> Name </th>
											<th scope="col"> Phone </th>
											<th scope="col"> Status </th>
											<th scope="col"> Subject </th>
											<th scope="col"> Email </th>
											<th scope="col"> IP </th>
											<th scope="col"> User Agent </th>

										</tr>
										</thead>
										<tbody>
										<form action="{{ url('user') }}" method="post">
											{{ csrf_field() }}
											@if(!empty($content['be']))
												@foreach($content['be'] as $no => $data)

													@if($data['response_status'] == 'fail')
														<tr style="color:red">
													@else
														<tr>
															@endif
															<td> {{$no+1}}
															</td>
															<td>
																<a class="btn btn-block green btn-xs" onClick="viewLogDetail('{{$data['id_log_activities_be']}}','be')" href="#"><i class="icon-pencil"></i> Detail </a>
																<a class="btn btn-block red btn-xs" href="{{ url('user/delete/logBE', $data['id_log_activities_be']) }}" data-toggle="confirmation" data-placement="top"><i class="icon-tag"></i> Delete </a>
															</td>
															<td> {!!str_replace(" ","&nbsp;", date('d F Y H:i', strtotime($data['created_at'])))!!} </td>
															<td> {!!str_replace(" ","&nbsp;", $data['name'])!!} </td>
															<td> {{$data['phone']}} </td>
															<td> {{$data['response_status']}} </td>
															<td> {!!str_replace(" ","&nbsp;", $data['subject'])!!} </td>
															<td> {!!str_replace(" ","&nbsp;", $data['email'])!!} </td>
															<td> {{$data['ip']}} </td>
															<td> {!!str_replace(" ","&nbsp;", $data['useragent'])!!} </td>
														</tr>
														@endforeach
														@else
															<td colspan="12" style="text-align:center"> Data is empty</td>
										@endif
										</tbody>
									</table>
								</div>
								<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:25px">
									<div class="col-md-5" style="padding-left:0px;padding-right:0px;">

									</div>
									<div class="col-md-3" style="padding-left:0px;padding-right:0px;">

									</div>
									<div class="col-md-4" style="padding-left:0px;padding-right:0px;">
										<div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
											<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
												@if($page <= 1) <li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
												@else <li class="page-first"><a href="{{url('user')}}/activity/{{$page-1}}">«</a></li>
												@endif

												@if($last == $total['be']) <li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
												@else <li class="page-last"><a href="{{url('user')}}/activity/{{$page+1}}">»</a></li>
												@endif
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			</form>

		</div>
	</div>
</div>


<div class="modal fade" id="logModal" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Request & Response Detail</h4>
			</div>
			<div class="modal-body form">
				<form role="form">
					<div class="form-body">
						<div class="form-group">
							<label>URL</label>
							<input type="text" class="form-control" readonly id="log-url">
						</div>
						<div class="form-group">
							<label>Status</label>
							<input type="text" class="form-control" readonly id="log-status">
						</div>
						<div class="form-group">
							<label>IP Address</label>
							<input type="text" class="form-control" readonly id="log-ip">
						</div>
						<div class="form-group">
							<label>User Agent</label>
							<input type="text" class="form-control" readonly id="log-useragent">
						</div>
						<div class="form-group">
							<label>Request</label>
							<pre  id="log-request"></pre>
						</div>
						<div class="form-group">
							<label>Response</label>
							<pre id="log-response"></pre>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@endsection