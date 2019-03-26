@extends('layouts.main')

@section('page-style')
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" /> 
@endsection

@section('page-plugin')
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kopikenangan-view-asset/public/assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
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

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">{{$title}}</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:20px;margin-bottom:15px">
					<div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
						<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
							@if($post['skip'] > 0)
								<li class="page-first"><a href="{{url('campaign')}}/whatsapp/outbox/page/{{(($post['skip'] + $post['take'])/$post['take'])-1}}">«</a></li>
							@else
								<li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
							@endif
							
							@if(isset($count) && $count > (($post['skip']+1) * $post['take']))
								<li class="page-last"><a href="{{url('campaign')}}/whatsapp/outbox/page/{{(($post['skip'] + $post['take'])/$post['take'])+1}}">»</a></li>
							@else
								<li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
							@endif
						</ul>
					</div>
				</div>
				<div class="table-scrollable">
					@if(isset($result) && $result != '')
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Camapign Title</th>
								<th>To</th>
								<th>Send At</th>
								<th width=10%>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $key => $data)
							<tr>
								<td>{{(($post['skip'] + $post['take']) - $post['take'])+($key+1)}}</td>
								<td>{{$data['campaign_title']}}</td>
								<td>{{$data['whatsapp_'.$type.'_to']}}</td>
								<td>@if($data['whatsapp_'.$type.'_send_at'] != "")
										{{date('d F Y - H:i', strtotime($data['whatsapp_'.$type.'_send_at']))}}
									@else
										{{date('d F Y - H:i', strtotime($data['created_at']))}}
									@endif</td>
								<td>
									@if($type == 'sent')
									<a class="btn btn-block green btn-xs" href="{{ url('campaign/whatsapp/outbox/detail') }}/{{ $data['id_campaign_whatsapp_sent'] }}"><i class="icon-magnifier"></i> Detail </a>
									@else
									<a class="btn btn-block green btn-xs" href="{{ url('campaign/whatsapp/queue/detail') }}/{{ $data['id_campaign_whatsapp_queue'] }}"><i class="icon-magnifier"></i> Detail </a>
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
						No WhatsApp Outbox Found
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection