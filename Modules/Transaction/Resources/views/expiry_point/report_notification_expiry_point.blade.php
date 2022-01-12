<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.middle-center {
			vertical-align: middle!important;
			text-align: center;
		}
	</style>
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
</div>
@include('layouts.notifications')

<form role="form" action="{{ url('transaction/report/expiry-point/filter') }}" method="post">
	@include('transaction::expiry_point.filter')
</form>

@if (!empty($search))
	<div class="alert alert-block alert-info fade in">
		<button type="button" class="close" data-dismiss="alert"></button>
		<h4 class="alert-heading">Displaying search result :</h4>
		<p>{{ $count }}</p><br>
		<a href="{{ url('transaction/report/expiry-point') }}" class="btn btn-sm btn-warning">Reset</a>
		<br>
	</div>
@endif

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Notification Expiry List</span>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_1">
					<thead>
					<tr>
						<th>No</th>
						<th>Send At</th>
						<th>Total Customer</th>
						<th>Media Sent</th>
						<th width=10%>Actian</th>
					</tr>
					</thead>
					<tbody>
					@if(!empty($data))
						@foreach($data as $key => $value)
							<tr>
								<td>{{($page - 1) * 25 + $key + 1}}</td>
								<td>{{date('d F Y', strtotime($value['notification_expiry_point_date_sent']))}}</td>
								<td>{{number_format($value['total_customer'])}}</td>
								<td>
									<ul>
										@if(!empty($value['email_count_sent']))<li> Email = {{$value['email_count_sent']}}</li>@endif
										@if(!empty($value['sms_count_sent']))<li> SMS = {{$value['sms_count_sent']}}</li>@endif
										@if(!empty($value['push_count_sent']))<li> Push = {{$value['push_count_sent']}}</li>@endif
										@if(!empty($value['inbox_count_sent']))<li> Inbox = {{$value['inbox_count_sent']}}</li>@endif
										@if(!empty($value['whatsapp_count_sent']))<li> WhatsApp = {{$value['whatsapp_count_sent']}}</li>@endif
									</ul>
								</td>
								<td>
									<div class="btn-group pull-right">
										<button class="btn blue btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Detail
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu pull-right">
											@if(!empty($value['email_count_sent']))
												<li>
													<a href="{{ url('transaction/report/expiry-point/email-outbox') }}/{{ $value['id_notification_expiry_point_sent'] }}">Email Outbox </a>
												</li>
											@endif
											@if(!empty($value['sms_count_sent']))
												<li>
													<a href="{{ url('transaction/report/expiry-point/sms-outbox') }}/{{ $value['id_notification_expiry_point_sent'] }}">SMS Outbox </a>
												</li>
											@endif
											@if(!empty($value['push_count_sent']))
												<li>
													<a href="{{ url('transaction/report/expiry-point/push-outbox') }}/{{ $value['id_notification_expiry_point_sent'] }}">Push Outbox </a>
												</li>
											@endif
											@if(!empty($value['inbox_count_sent']))
												<li>
													<a href="{{ url('transaction/report/expiry-point/inbox-outbox') }}/{{ $value['id_notification_expiry_point_sent'] }}">Inbox Outbox </a>
												</li>
											@endif
											@if(!empty($value['whatsapp_count_sent']))
												<li>
													<a href="{{ url('transaction/report/expiry-point/whatsapp-outbox') }}/{{ $value['id_notification_expiry_point_sent'] }}">Whatsapp Outbox </a>
												</li>
											@endif
										</ul>
									</div>
								</td>
							</tr>
						@endforeach
					@else
						<tr style="text-align: center"><td colspan="10">No Data Available</td></tr>
					@endif
					</tbody>
				</table>
				<br>
				<div style="text-align: right">
					@if ($dataPaginator)
						{{ $dataPaginator->links() }}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection