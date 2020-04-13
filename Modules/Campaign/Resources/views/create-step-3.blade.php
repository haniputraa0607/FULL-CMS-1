@extends('layouts.main-closed')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
	$(document).ready(function() {
	  $('.summernote').summernote({
		placeholder: 'Content',
		tabsize: 2,
		toolbar: [
          ['style', ['style']],
          ['style', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['misc', ['fullscreen', 'codeview', 'help']]
        ],
		height: 120
	  });
	});

	function addEmailContent(param){
		var textvalue = $('#campaign_email_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#campaign_email_content').val(textvaluebaru);
		$('#campaign_email_content').summernote('editor.saveRange');
		$('#campaign_email_content').summernote('editor.restoreRange');
		$('#campaign_email_content').summernote('editor.focus');
		$('#campaign_email_content').summernote('editor.insertText', param);
    }

    function addEmailSubject(param){
		var textvalue = $('#campaign_email_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_email_subject').val(textvaluebaru);
    }

	function addSmsContent(param){
		var textvalue = $('#campaign_sms_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_sms_content').val(textvaluebaru);
    }

	function addPushSubject(param){
		var textvalue = $('#campaign_push_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_push_subject').val(textvaluebaru);
    }

	function addPushContent(param){
		var textvalue = $('#campaign_push_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_push_content').val(textvaluebaru);
    }

	function addInboxSubject(param){
		var textvalue = $('#campaign_inbox_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_inbox_subject').val(textvaluebaru);
    }

	function addInboxContent(param){
		var textvalue = $('#campaign_inbox_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#campaign_inbox_content').val(textvaluebaru);
		$('#campaign_inbox_content').summernote('editor.saveRange');
		$('#campaign_inbox_content').summernote('editor.restoreRange');
		$('#campaign_inbox_content').summernote('editor.focus');
		$('#campaign_inbox_content').summernote('editor.insertText', param);
    }

	function addWhatsappContent(param){
		var textvalue = $('#campaign_whatsapp_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#campaign_whatsapp_content').val(textvaluebaru);
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
				<div class="col-md-4 mt-step-col first">
					<div class="mt-step-number bg-white"><a href="{{url('/')}}/campaign/step1/{{$result['id_campaign']}}">1</a></div>
					<div class="mt-step-title uppercase font-grey-cascade">Info</div>
					<div class="mt-step-content font-grey-cascade">Campaign Rule & Setting</div>
				</div>
				<div class="col-md-4 mt-step-col ">
					<div class="mt-step-number bg-white"><a href="{{url('/')}}/campaign/step2/{{$result['id_campaign']}}">2</a></div>
					<div class="mt-step-title uppercase font-grey-cascade">Receipient & Content</div>
					<div class="mt-step-content font-grey-cascade">Review Campaign Receipient</div>
				</div>
				<div class="col-md-4 mt-step-col active last">
					<div class="mt-step-number bg-white">3</div>
					<div class="mt-step-title uppercase font-grey-cascade">Review & Summary</div>
					<div class="mt-step-content font-grey-cascade">Campaign Finalization</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="col-md-4">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Information</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row static-info">
						<div class="col-md-4 name">Campaign</div>
						<div class="col-md-8 value">: {{$result['campaign_title']}}</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">Creator</div>
						<div class="col-md-8 value">: {{$result['user']['name']}}</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">Level</div>
						<div class="col-md-8 value">: {{$result['user']['level']}}</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">Media</div>
						<div class="col-md-8 value">: </div>
					</div>
					@if($result['campaign_media_email'] == "Yes")
					<div class="row static-info">
						<div class="col-md-1 name"></div>
						<div class="col-md-10 value">
							<li><i class="fa fa-envelope-o" title="Email"></i> Email</li>
						</div>
					</div>
					@endif
					@if($result['campaign_media_sms'] == "Yes")
					<div class="row static-info">
						<div class="col-md-1 name"></div>
						<div class="col-md-10 value">
							<li><i class="fa fa-commenting-o" title="SMS"></i> SMS</li>
						</div>
					</div>
					@endif
					@if($result['campaign_media_push'] == "Yes")
					<div class="row static-info">
						<div class="col-md-1 name"></div>
						<div class="col-md-10 value">
							<li><i class="fa fa-exclamation-circle" title="Push Notification"></i>Push Notification</li>
						</div>
					</div>
					@endif
					@if($result['campaign_media_inbox'] == "Yes")
					<div class="row static-info">
						<div class="col-md-1 name"></div>
						<div class="col-md-10 value">
							<li><i class="fa fa-download" title="Inbox"></i> Inbox</li>
						</div>
					</div>
					@endif
					@if($result['campaign_media_whatsapp'] == "Yes")
					<div class="row static-info">
						<div class="col-md-1 name"></div>
						<div class="col-md-10 value">
							<li><i class="fa fa-download" title="Inbox"></i> WhatsApp</li>
						</div>
					</div>
					@endif
					<div class="row static-info">
						<div class="col-md-4 name">Created</div>
						<div class="col-md-8 value">: {{date("d F Y", strtotime($result['created_at']))}}<br>&nbsp;&nbsp;{{date("H:i", strtotime($result['created_at']))}}</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">Send</div>
						<div class="col-md-8 value">: @if($result['campaign_send_at'] != ''){{date("d F Y", strtotime($result['campaign_send_at']))}}<br>&nbsp;&nbsp;{{date("H:i", strtotime($result['campaign_send_at']))}}@else Now @endif</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">Receipient generate</div>
						<div class="col-md-8 value">: {{$result['campaign_generate_receipient']}}</div>
					</div>
					@if(isset($result['campaign_rule_parents']))
						<div class="row static-info">
							<div class="col-md-4 name">Conditions</div>
							<div class="col-md-8 value">: </div>
						</div>
						@php $i=0; @endphp
						@foreach($result['campaign_rule_parents'] as $ruleParent)
						<div class="portlet light bordered" style="margin-bottom:10px">
							@foreach($ruleParent['rules'] as $rule)
							<div class="row static-info">
								<div class="col-md-1 name"></div>
								<div class="col-md-10 value"><li>
								@if($rule['subject'] != 'trx_outlet' && $rule['subject'] != 'trx_product')
									{{ucwords(str_replace("_", " ", $rule['subject']))}} @if($rule['subject'] != "all_user") @if(empty($rule['operator']))=@else{{$rule['operator']}}@endif @endif
								@endif
								@if($rule['subject'] == 'trx_outlet')
									{{ucwords(str_replace("_", " ", $rule['subject']))}}
									<?php $name = null; ?>
									@foreach($outlets as $outlet)
										@if($outlet['id_outlet'] == $rule['id'])
											<?php $name = $outlet['outlet_name']; ?>
										@endif
									@endforeach
									"{{$name}}" with outlet count {{$rule['operator']}} {{$rule['parameter']}}
								@elseif($rule['subject'] == 'trx_outlet_not')
									<?php $name = null; ?>
									@foreach($outlets as $outlet)
										@if($outlet['id_outlet'] == $rule['parameter'])
											<?php $name = $outlet['outlet_name']; ?>
										@endif
									@endforeach
									{{$name}}
								@elseif($rule['subject'] == 'trx_product')
									{{ucwords(str_replace("_", " ", $rule['subject']))}}
									<?php $name = null; ?>
									@foreach($products as $product)
										@if($product['id_product'] == $rule['id'])
											<?php $name = $product['product_name']; ?>
										@endif
									@endforeach
									"{{$name}}" with product count {{$rule['operator']}} {{$rule['parameter']}}
								@elseif($rule['subject'] == 'trx_product_not')
									<?php $name = null; ?>
									@foreach($products as $product)
										@if($product['id_product'] == $rule['parameter'])
											<?php $name = $product['product_name']; ?>
										@endif
									@endforeach
									{{$name}}
								@elseif($rule['subject'] == 'trx_product_tag' || $rule['subject'] == 'trx_product_tag_not')
									<?php $name = null; ?>
									@foreach($tags as $tag)
										@if($tag['id_tag'] == $rule['parameter'])
											<?php $name = $tag['tag_name']; ?>
										@endif
									@endforeach
									{{$name}}
								@elseif($rule['subject'] == 'membership')
									<?php $name = null; ?>
									@foreach($memberships as $membership)
										@if($membership['id_membership'] == $rule['parameter'])
											<?php $name = $membership['membership_name']; ?>
										@endif
									@endforeach
									{{$name}}
								@else
									{{$rule['parameter']}}
								@endif
								</li></div>
							</div>
							@endforeach
							<div class="row static-info">
								<div class="col-md-11 value">
									@if($ruleParent['rule'] == 'and')
										All conditions must valid
									@else
										Atleast one condition is valid
									@endif
								</div>
							</div>
						</div>
						@if(count($result['campaign_rule_parents']) > 1 && $i < count($result['campaign_rule_parents']) - 1)
						<div class="row static-info" style="text-align:center">
							<div class="col-md-11 value">
								{{strtoupper($ruleParent['rule_next'])}}
							</div>
						</div>
						@endif
						@php $i++; @endphp
						@endforeach
					@endif
					@if($result['campaign_is_sent'] != 'Yes')
					<div class="row static-info">
						<div class="col-md-11 value">
							<a class="btn blue" href="{{url('/')}}/campaign/step1/{{$result['id_campaign']}}">Edit Campaign Information</a>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Receipient</span>
					</div>
					@if($result['campaign_generate_receipient']=='Now')
					<div class="action-btn pull-right">
						<a href="{{url('campaign/recipient/'.$result['id_campaign'])}}" target="_blank" class="btn yellow btn-sm btn-flat">See generated recipient</a>
					</div>
					@endif
				</div>
				<div class="portlet-body form">
					<div class="form-group">
						@if($result['campaign_media_email'] == "Yes")
						<div class="form-group">
							<label>Email Receipient</label>
							<textarea class="form-control" rows="3" name="campaign_email_more_recipient" readonly>{{$result['campaign_email_more_recipient']}}</textarea>
						</div>
						@endif
						@if($result['campaign_media_sms'] == "Yes")
						<div class="form-group">
							<label>SMS Receipient</label>
							<textarea class="form-control" rows="3" name="campaign_sms_more_recipient" readonly>{{$result['campaign_email_more_recipient']}}</textarea>
						</div>
						@endif
						@if($result['campaign_media_push'] == "Yes")
						<div class="form-group">
							<label>Push Receipient</label>
							<textarea class="form-control" rows="3" name="campaign_push_more_recipient" readonly>{{$result['campaign_push_more_recipient']}}</textarea>
						</div>
						@endif
						@if($result['campaign_media_inbox'] == "Yes")
						<div class="form-group">
							<label>Inbox Receipient</label>
							<textarea class="form-control" rows="3" name="campaign_inbox_more_recipient" readonly>{{$result['campaign_inbox_more_recipient']}}</textarea>
						</div>
						@endif
						@if($result['campaign_media_whatsapp'] == "Yes")
						<div class="form-group">
							<label>WhatsApp Receipient</label>
							<textarea class="form-control" rows="3" name="campaign_whatsapp_more_recipient" readonly>{{$result['campaign_whatsapp_more_recipient']}}</textarea>
						</div>
						@endif
					</div>
				</div>
				@if($result['campaign_is_sent'] != 'Yes')
				<div class="row static-info" style="text-align:center;">
						<a class="btn blue" href="{{url('/')}}/campaign/step2/{{$result['id_campaign']}}">Edit Campaign Receipient & Content</a>
				</div>
				@endif
			</div>
		</div>
	</div>

		@if($result['campaign_media_email'] == "Yes")
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Email Content</span>
					</div>
				</div>
				<div class="portlet-body form">
					<form class="form-horizontal">
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-2 control-label">Subject</label>
								<div class="col-md-10">
									<input type="text" placeholder="Email Subject" class="form-control" name="campaign_email_subject" id="campaign_email_subject" required @if(isset($result['campaign_email_subject']) && $result['campaign_email_subject'] != "") value="{{$result['campaign_email_subject']}}" @endif readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="multiple" class="control-label col-md-2">Content</label>
								<div class="col-md-10">
									<?php $html_message = $result['campaign_email_content']; ?>
									@include('emails.test')
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endif

		@if($result['campaign_media_sms'] == "Yes")
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">SMS Content</span>
					</div>
				</div>
				<div class="portlet-body form">
					<form class="form-horizontal">
						<div class="form-body">
							<div class="form-group" style="margin-bottom:50px">
								<label class="col-md-2 control-label">Content</label>
								<div class="col-md-10">
									<textarea name="campaign_sms_content" id="campaign_sms_content" class="form-control" placeholder="SMS Content" required readonly>@if(isset($result['campaign_sms_content']) && $result['campaign_sms_content'] != ""){{$result['campaign_sms_content']}}@endif</textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endif

		@if($result['campaign_media_push'] == "Yes")
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Push Notification Content</span>
					</div>
				</div>
				<div class="portlet-body form">
					<form class="form-horizontal">
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-2 control-label">Subject</label>
								<div class="col-md-10">
									<input type="text" placeholder="Push Notification Subject" class="form-control" name="campaign_push_subject" id="campaign_push_subject" required @if(isset($result['campaign_push_subject']) && $result['campaign_push_subject'] != "") value="{{$result['campaign_push_subject']}}" @endif readonly>

								</div>
							</div>
							<div class="form-group">
								<label for="multiple" class="control-label col-md-2">Content</label>
								<div class="col-md-10">
									<textarea name="campaign_push_content" id="campaign_push_content" class="form-control" required readonly>@if(isset($result['campaign_push_content']) && $result['campaign_push_content'] != ""){{$result['campaign_push_content']}}@endif</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Click To</label>
								<div class="col-md-10">
									<input type="text" placeholder="Push Notification Click To" class="form-control" name="campaign_push_clickto" id="campaign_push_clickto" required @if(isset($result['campaign_push_clickto']) && $result['campaign_push_clickto'] != "") value="{{$result['campaign_push_clickto']}}" @endif readonly>
								</div>
							</div>
							@if(isset($result['campaign_push_name_reference']))
							<div class="form-group">
								<label class="col-md-2 control-label">Reference</label>
								<div class="col-md-10">
									<input type="text" placeholder="Push Notification Click To" class="form-control" name="campaign_push_name_reference" id="campaign_push_name_reference" required @if(isset($result['campaign_push_name_reference']) && $result['campaign_push_name_reference'] != "") value="{{$result['campaign_push_name_reference']}}" @endif readonly>
								</div>
							</div>
							@endif
							@if(isset($result['campaign_push_clickto']) && ($result['campaign_push_clickto'] == "Link"))
							<div class="form-group">
								<label for="multiple" class="control-label col-md-2">Link</label>
								<div class="col-md-10">
									<input name="campaign_push_content" id="campaign_push_content" class="form-control" required readonly value="@if(isset($result['campaign_push_link']) && $result['campaign_push_link'] != ""){{$result['campaign_push_link']}}@endif" >
								</div>
							</div>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
		@endif

		@if($result['campaign_media_inbox'] == "Yes")
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Inbox Content</span>
					</div>
				</div>
				<div class="portlet-body form">
					<form class="form-horizontal">
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-2 control-label">Subject</label>
								<div class="col-md-10">
									<input type="text" placeholder="Inbox Subject" class="form-control" name="campaign_inbox_subject" id="campaign_inbox_subject" required @if(isset($result['campaign_inbox_subject']) && $result['campaign_inbox_subject'] != "") value="{{$result['campaign_inbox_subject']}}" @endif readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Click To</label>
								<div class="col-md-10">
									<input type="text" placeholder="Inbox Click To" class="form-control" name="campaign_inbox_clickto" id="campaign_inbox_clickto" required @if(isset($result['campaign_inbox_clickto']) && $result['campaign_inbox_clickto'] != "") value="{{$result['campaign_inbox_clickto']}}" @endif readonly>
								</div>
							</div>
							@if(isset($result['campaign_inbox_name_reference']))
							<div class="form-group">
								<label class="col-md-2 control-label">Reference</label>
								<div class="col-md-10">
									<input type="text" placeholder="Push Notification Click To" class="form-control" name="campaign_inbox_name_reference" id="campaign_inbox_name_reference" required @if(isset($result['campaign_inbox_name_reference']) && $result['campaign_inbox_name_reference'] != "") value="{{$result['campaign_inbox_name_reference']}}" @endif readonly>
								</div>
							</div>
							@endif
							@if(isset($result['campaign_inbox_clickto']) && ($result['campaign_inbox_clickto'] == "Content"))
							<div class="form-group">
								<label for="multiple" class="control-label col-md-2">Content</label>
								<div class="col-md-10">
									<div class="col-md-12" style="border: 1px solid #c2cad8;background-color: #eef1f5; opacity: 1; padding: 6px 12px;">
										<?php echo $result['campaign_inbox_content']; ?>
									</div>
								</div>
							</div>
							@endif
							@if(isset($result['campaign_inbox_clickto']) && ($result['campaign_inbox_clickto'] == "Link"))
							<div class="form-group">
								<label for="multiple" class="control-label col-md-2">Link</label>
								<div class="col-md-10">
									<input name="campaign_inbox_content" id="campaign_inbox_content" class="form-control" required readonly value="@if(isset($result['campaign_inbox_link']) && $result['campaign_inbox_link'] != ""){{$result['campaign_inbox_link']}}@endif" >
								</div>
							</div>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
		@endif

		@if($result['campaign_media_whatsapp'] == "Yes")
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">WhatsApp Content</span>
					</div>
				</div>
				<div class="portlet-body form">
					<form class="form-horizontal">
						<div class="form-body">
							@foreach($result['whatsapp_content'] as $key => $content)
							<div class="form-group">
								<label class="col-md-2 control-label">Content {{$key+1}}</label>
								<div class="col-md-10">
									<div class="form-group">
									<label class="col-md-1 control-label">Type</label>
									<div class="col-md-3">
										<input class="form-control" value="{{ucfirst($content['content_type'])}}" readonly>
									</div>
									</div>
									<div class="form-group">
									<label class="col-md-1 control-label">Content</label>
									<div class="col-md-10">
										@if($content['content_type'] == 'text')
											<textarea class="form-control" placeholder="WhatsApp Content" required readonly>{{$content['content']}}</textarea>
										@elseif($content['content_type'] == 'image')
											<div class="fileinput-new thumbnail" style="width: 200px; height: auto; margin-bottom:0">
												<img src="{{$content['content']}}" alt="" style="max-height:190px">
											</div>
										@elseif($content['content_type'] == 'file')
										@php $file = explode('/', $content['content']) @endphp
											<label class="control-label"><a href= "{{$content['content']}}"> <i class="fa fa-file-pdf-o"></i> {{end($file)}} </a> </label>
										@endif
									</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</form>
				</div>
			</div>
		</div>
		@endif
	</div>
	<form role="form" action="" method="POST">
			@if($result['campaign_send_at'] == null && $result['campaign_is_sent'] == 'No')
			<div class="col-md-12" style="text-align:center;">
				<div class="form-actions">
					{{ csrf_field() }}
					<button type="submit" class="btn blue">Send Campaingn</button>
				</div>
			</div>
			@elseif($result['campaign_is_sent'] == 'Yes')
			<form role="form" action="" method="POST">
			<div class="col-md-12" style="text-align:center;">
				<div class="form-actions">
					This Campaign has already been sent
					<div class="col-md-12" style="text-align:center;">
						<div class="form-actions">
							{{csrf_field()}}
							<input type="hidden" name="resend" value="1">
							<button type="submit" class="btn blue">Re-Send Campaign</button>
						</div>
					</div>
				</div>
			</div>
			</form>
			@else
			<div class="col-md-12" style="text-align:center;">
				<div class="form-actions">
					This Campaign will be sent automatically at desired time ({{date("d F Y - H:i", strtotime($result['campaign_send_at']))}})
				</div>
			</div>
		@endif
	</form>
</div>
@endsection