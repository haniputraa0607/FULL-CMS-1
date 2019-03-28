@extends('layouts.main')

@section('page-style')
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" /> 
@endsection

@section('page-plugin')
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{Cdn::asset('kk-ass/public/assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
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
<a href="{{url('campaign/email/outbox')}}" class="btn blue" style="margin-left:15px;margin-bottom:20px">< Back</a><br>
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Campaign Email Outbox Detail</span>
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					<div class="form-group">
						<label>Receipient</label>
						<input type="text" class="form-control" value="{{$result['email_sent_to']}}" readonly> 
					</div>
					<div class="form-group">
						<label>Campaign Title</label>
						<input type="text" class="form-control" value="{{$result['campaign_title']}}" readonly> 
					</div>
					<div class="form-group">
						<label>Send At</label>
						<input type="text" class="form-control" value="{{date('d F Y H:i', strtotime($result['email_sent_send_at']))}}" readonly> 
					</div>
					<div class="form-group">
						<label>Subject</label>
						<input type="text" class="form-control" value="{{$result['email_sent_subject']}}" readonly> 
					</div>
					<div class="form-group">
						<label>Message</label>
						<div style="background-color: #eef1f5;width:100%;padding-left:15px;padding-top:10px;padding-bottom:5px"><?php echo $result['email_sent_message'];?></div> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection