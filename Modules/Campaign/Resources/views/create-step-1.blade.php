<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
 ?>
 @extends('layouts.main-closed')


 @section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

	<script>

	$('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one Campaign Media.");
        return false;
      }

    });
    $(document).ready(function(){
    	$('#manualFilter').show();
    });
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

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="mt-element-step">
			<div class="row step-line">
				<div class="col-md-4 mt-step-col first active">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Info</div>
					<div class="mt-step-content font-grey-cascade">Campaign Detail & Rule</div>
				</div>
				<div class="col-md-4 mt-step-col ">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Receipient & Content</div>
					<div class="mt-step-content font-grey-cascade">Review Campaign Content</div>
				</div>
				<div class="col-md-4 mt-step-col last">
					<div class="mt-step-number bg-white">3</div>
					<div class="mt-step-title uppercase font-grey-cascade">Review & Summary</div>
					<div class="mt-step-content font-grey-cascade">Campaign Finalization</div>
				</div>
			</div>
		</div>
	</div>

	<form role="form" action="" method="POST">
		<div class="col-md-4">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Detail</span>
					</div>
				</div>
				<div class="portlet-body form">
					<div class="form-body">
						<div class="form-group">
							<label>Campaign Title</label>
							<input type="text" class="form-control" placeholder="Campaign Title" name="campaign_title" required @if(isset($result['campaign_title']) && $result['campaign_title'] != "") value="{{$result['campaign_title']}}" @endif>
						</div>
						<div class="form-group">
							<label class="control-label">Date Time to Send</label>
							<div class="input-group date form_datetime form_datetime bs-datetime">
								<input type="text" size="16" class="form-control" name="campaign_send_at" placeholder="Now" @if(isset($result['campaign_title']) && $result['campaign_send_at'] != "") value="{{date('d F Y - H:i', strtotime($result['campaign_send_at']))}}" @endif>
								<span class="input-group-addon">
									<button class="btn default date-set" type="button">
										<i class="fa fa-calendar"></i>
									</button>
								</span>
							</div>
						</div>

						<div class="form-group">
							<label>Campaign Media</label>
							<div class="mt-checkbox-list">
								@if(MyHelper::hasAccess([51], $configs))
									<label class="mt-checkbox mt-checkbox-outline"> Email
										<input type="checkbox" value="Email" name="campaign_media[]" @if(isset($result['campaign_media_email']) && $result['campaign_media_email'] == "Yes") checked @endif/>
										<span></span>
									</label>
								@endif
								@if(MyHelper::hasAccess([52], $configs))
									<label class="mt-checkbox mt-checkbox-outline"> SMS
										<input type="checkbox" value="SMS" name="campaign_media[]" @if(isset($result['campaign_media_sms']) && $result['campaign_media_sms'] == "Yes") checked @endif/>
										<span></span>
									</label>
								@endif
								@if(MyHelper::hasAccess([53], $configs))
									<label class="mt-checkbox mt-checkbox-outline"> Push Notification
										<input type="checkbox" value="Push Notification" name="campaign_media[]" @if(isset($result['campaign_media_push']) && $result['campaign_media_push'] == "Yes") checked @endif />
										<span></span>
									</label>
								@endif
								@if(MyHelper::hasAccess([54], $configs))
									<label class="mt-checkbox mt-checkbox-outline"> Inbox
										<input type="checkbox" value="Inbox" name="campaign_media[]" @if(isset($result['campaign_media_inbox']) && $result['campaign_media_inbox'] == "Yes") checked @endif />
										<span></span>
									</label>
								@endif
								@if(MyHelper::hasAccess([75], $configs))
									@if(!$api_key_whatsapp)
										<div class="alert alert-warning deteksi-trigger">
											<p> To use WhatsApp channel you have to set the api key in <a href="{{url('setting/whatsapp')}}">WhatsApp Setting</a>. </p>
										</div>
									@endif
									<label class="mt-checkbox mt-checkbox-outline"  @if(!$api_key_whatsapp) style="cursor:not-allowed;" @endif/> WhatsApp
										<input type="checkbox" value="Whatsapp" name="campaign_media[]" @if($api_key_whatsapp) @if(isset($result['campaign_media_whatsapp']) && $result['campaign_media_whatsapp'] == "Yes") checked @endif @else disabled @endif/>
										<span></span>
									</label>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			{{ csrf_field() }}
			@if(isset($result['campaign_rule_parents']))
				<?php
					$search_param = $result['campaign_rule_parents'];
					$search_param = array_filter($search_param);
					$conditions = $search_param;
				?>
			@else

				<?php
				//@if(isset($result['rules']))
				// @else
					$conditions = "";
				?>
			@endif
			<?php $tombolsubmit = 'hidden'; ?>
			@include('filter')
		</div>
		<div class="col-md-8">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">When to generate Receipient?</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="form-group">
							<div class="mt-radio-list">
								<label class="mt-radio mt-radio-outline"> NOW
									<input type="radio" value="Now" name="campaign_generate_receipient" <input type="checkbox" value="Inbox" @if(isset($result['campaign_generate_receipient']) && $result['campaign_generate_receipient'] == "Now") checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline"> At the date time to send
									<input type="radio" value="Send At Time" name="campaign_generate_receipient" @if(isset($result['campaign_generate_receipient']) && $result['campaign_generate_receipient'] == "Send At Time") checked @endif required/>
									<span></span>
								</label>
							</div>
						</div>
				</div>
			</div>
		</div>
		@if(isset($result['campaign_is_sent']) && $result['campaign_is_sent'] != 'Yes')
		<div class="col-md-12" style="text-align:center;">
			<div class="form-actions">
				{{ csrf_field() }}
				<button type="submit" class="btn blue" id="checkBtn">Next Step ></button>
			</div>
		</div>
		@endif
	</form>
</div>
@endsection