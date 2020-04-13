<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
 ?>
 @extends('layouts.main')


@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
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

<br>
<div class="row">
	<div class="col-md-7">
		<h1 class="page-title" style="margin-top: 0px;">
			{{$title}}
		</h1>
	</div>
	<div class="col-md-5" style="text-align: right">
		<a href="{{url('point-injection')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
	</div>
</div>

<div class="m-heading-1 border-green m-bordered">
	<p>This page is a list of users who received point injection.</p>
</div>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-blue ">
			<i class="icon-settings font-blue "></i>
			<span class="caption-subject bold uppercase">Information</span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-6">
				<div class="row static-info">
					<div class="col-md-5 name">Title</div>
					<div class="col-md-7 value">: {{$detail['title']}}</div>
				</div>
				<div class="row static-info">
					<div class="col-md-5 name">Send Type</div>
					<div class="col-md-7 value">: {{$detail['send_type']}}</div>
				</div>
				<div class="row static-info">
					<div class="col-md-5 name">Start Date</div>
					<div class="col-md-7 value">: {{date("d F Y", strtotime($detail['start_date']))}}</div>
				</div>
				<div class="row static-info">
					<div class="col-md-5 name">Send Time</div>
					<div class="col-md-7 value">: {{date("H:i", strtotime($detail['send_time']))}}</div>
				</div>
				<div class="row static-info">
					<div class="col-md-5 name">Total User</div>
					<div class="col-md-7 value">: {{$detail['count']}} Users</div>
				</div>
			</div>
			<div class="col-md-6">
				@if ($detail['send_type'] == 'Daily')
					<div class="row static-info">
						<div class="col-md-5 name">Duration</div>
						<div class="col-md-7 value">: {{$detail['duration']}} Days</div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 name">Point / Day</div>
						<div class="col-md-7 value">: {{number_format($detail['point'])}} Point</div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 name">Total Point / User</div>
						<div class="col-md-7 value">: {{number_format($detail['total_point'])}} Point</div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 name">Total Point All</div>
						<div class="col-md-7 value">: {{number_format($detail['count']*($detail['duration']*$detail['point']))}} Point</div>
					</div>
				@else
					<div class="row static-info">
						<div class="col-md-5 name">Total Point / User</div>
						<div class="col-md-7 value">: {{number_format($detail['total_point'])}} Point</div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 name">Total Point All</div>
						<div class="col-md-7 value">: {{number_format($detail['count'] * $detail['total_point'])}} Point</div>
					</div>
				@endif
				<div class="row static-info">
					<div class="col-md-5 name">Created by</div>
					<div class="col-md-7 value">: {{$detail['user']['name']}}</div>
				</div>
				<div class="row static-info">
					<div class="col-md-5 name">Created at</div>
					<div class="col-md-7 value">: {{date("d F Y", strtotime($detail['created_at']))}}&nbsp;{{date("H:i", strtotime($detail['created_at']))}}</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$date_start = '';
	$date_end = '';

	if(Session::has('filter-point-inject')){
		$search_param = Session::get('filter-point-inject');
		if(isset($search_param['date_start'])){
			$date_start = $search_param['date_start'];
		}

		if(isset($search_param['date_end'])){
			$date_end = $search_param['date_end'];
		}

		if(isset($search_param['rule'])){
			$rule = $search_param['rule'];
		}

		if(isset($search_param['conditions'])){
			$conditions = $search_param['conditions'];
		}
	}
?>

<form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
	{{ csrf_field() }}
	@include('pointinjection::report_filter')
</form>

<div @if(!empty($data)) style="text-align: right;" @else style="text-align: right;display: none" @endif>
	<a class="btn blue" href="{{url()->current()}}?export=1"><i class="fa fa-download"></i> Export to Excel</a>
</div>
<br>

<div class="table-scrollable">
	<table class="table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th scope="col"> Name </th>
			<th scope="col"> Phone </th>
			<th scope="col"> Email </th>
			<th scope="col"> Date Send </th>
			<th scope="col"> Status </th>
			<th scope="col"> Total Point </th>
			<th scope="col"> Total Point Received </th>
		</tr>
		</thead>
		<tbody>
			@if(!empty($data))
				@foreach($data as $val)
					<tr>
						<td>{{$val['name']}}</td>
						<td>{{$val['phone']}}</td>
						<td>{{$val['email']}}</td>
						<td>{{date('d F Y H:i', strtotime($val['created_at']))}}</td>
						<td>{{$val['status']}}</td>
						<td>{{number_format($val['point'])}}</td>
						<td>{{number_format($val['total_point'])}}</td>
					</tr>
				@endforeach
			@else
				<tr style="text-align: center"><td colspan="10">Data No Available</td></tr>
			@endif
		</tbody>
	</table>
</div>
@endsection