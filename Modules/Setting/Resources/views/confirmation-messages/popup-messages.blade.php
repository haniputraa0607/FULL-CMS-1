
@extends('layouts.main')

@section('page-script')
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('.appender').on('click','.appender-btn',function(){
    			var value=$(this).data('value');
    			var target=$(this).parents('.appender').data('target');
    			var newValue=$(target).val()+" "+value;
    			$(target).val(newValue);
    			$(target).focus();
    		});
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
			<a href="javascript:;">Popup Messages</a>
		</li>
	</ul>
</div>
<br>

@include('layouts.notifications')

    <div class="tab-pane" id="user-profile">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Popup Messages</span>
						</div>
					</div>
					<div class="portlet-body">

						<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">New Phone Popup
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil saat user memasukan nomor yang belum terdaftar pada sistem" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" id="message_phone_check" name="message_phone_check" value="{{ old('message_phone_check',$msg['message_phone_check']??'') }}" required><br/>
										<div class="row appender" data-target="#message_phone_check">
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%deals_title%' with user phone" data-value="%phone%">%phone%</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">OTP Sent via Missed Call
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil apabila otp dikirim melalui Missed Call" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" name="message_send_otp_miscall" value="{{ old('message_send_otp_miscall',$msg['message_send_otp_miscall']??'') }}" id="message_send_otp_miscall" required><br>
										<div class="row appender" data-target="#message_send_otp_miscall">
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%deals_title%' with user phone" data-value="%phone%">%phone%</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">OTP Sent via Whatsapp
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil apabila otp dikirim melalui Whatsapp" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" name="message_send_otp_wa" value="{{ old('message_send_otp_wa',$msg['message_send_otp_wa']??'') }}" id="message_send_otp_wa" required><br>
										<div class="row appender" data-target="#message_send_otp_wa">
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%deals_title%' with user phone" data-value="%phone%">%phone%</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">OTP Sent via SMS
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil apabila otp dikirim melalui SMS" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" name="message_send_otp_sms" value="{{ old('message_send_otp_sms',$msg['message_send_otp_sms']??'') }}" id="message_send_otp_sms" required><br>
										<div class="row appender" data-target="#message_send_otp_sms">
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%deals_title%' with user phone" data-value="%phone%">%phone%</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>

@endsection