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
<h1 class="page-title" style="margin-top: 0px;">
	{{$sub_title}}
</h1>

<?php
$date_start = '';
$date_end = '';

if(Session::has('filter-report-sms')){
	$search_param = Session::get('filter-report-sms');
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
	@include('report::sms_report.sms_report_filter')
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
			<th width="30%"> Request URL </th>
			<th scope="col"> Request Body </th>
			<th scope="col"> Response </th>
			<th scope="col"> Date Send </th>
		</tr>
		</thead>
		<tbody>
			@if(!empty($data))
				@foreach($data as $val)
					<tr>
						<td>{{$val['name']}}</td>
						<td>{{$val['phone']}}</td>
						<td>{{$val['email']}}</td>
						<td>{{$val['request_url']}}</td>
						<?php
							$decode = json_decode($val['request_body']);
						?>
						<td width="30%">{{json_encode($decode, JSON_PRETTY_PRINT)}}</td>
						<?php
							$statusCodes = [
									1  => 'Success',
									2  => 'Missing Parameter',
									3  => 'Invalid User Id or Password',
									4  => 'Invalid Message',
									5  => 'Invalid MSISDN',
									6  => 'Invalid Sender',
									7  => 'Client’s IP Address is not allowed',
									8  => 'Internal Server Error',
									9  => 'Invalid division',
									20 => 'Invalid Channel',
									21 => 'Token Not Enough',
									22 => 'Token Not Available',
							];

							$code = substr($val['response'], strpos($val['response'], "=") + 1);
							echo '<td>'.$val['response'].'<br>('.$statusCodes[$code].')</td>';
						?>
						<td>{{date('d F Y H:i', strtotime($val['created_at']))}}</td>
					</tr>
				@endforeach
			@else
				<tr style="text-align: center"><td colspan="10">Data No Available</td></tr>
			@endif
		</tbody>
	</table>
</div>
@endsection