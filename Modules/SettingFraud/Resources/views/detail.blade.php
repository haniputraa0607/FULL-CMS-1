<?php
    use App\Lib\MyHelper;
    $grantedFeature = session('granted_features');
    $configs     	= session('configs');
 ?>

@extends('layouts.main')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
        $(document).ready(function() {
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};

			$('.summernote').summernote({
				placeholder: 'Email Content',
				tabsize: 2,
				height: 120,
				toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['misc', ['fullscreen', 'codeview', 'help']]
                ],
				callbacks: {
					onImageUpload: function(files){
						sendFile(files[0], $(this).attr('id'));
					},
					onMediaDelete: function(target){
						var name = target[0].src;
						token = "<?php echo csrf_token(); ?>";
						$.ajax({
							type: 'post',
							data: 'filename='+name+'&_token='+token,
							url: "{{url('summernote/picture/delete/fraud-setting')}}",
							success: function(data){
								// console.log(data);
							}
						});
					},
					onPaste: function (e) {
						var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				}
			});

			function sendFile(file, id){
                token = "<?php echo csrf_token(); ?>";
                var data = new FormData();
                data.append('image', file);
                data.append('_token', token);
                // document.getElementById('loadingDiv').style.display = "inline";
                $.ajax({
                    url : "{{url('summernote/picture/upload/fraud-setting')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
							$('#'+id).summernote('editor.saveRange');
							$('#'+id).summernote('editor.restoreRange');
							$('#'+id).summernote('editor.focus');
                            $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                        }
                        // document.getElementById('loadingDiv').style.display = "none";
                    },
                    error: function(data){
                        // document.getElementById('loadingDiv').style.display = "none";
                    }
                })
            }

			@if (!empty(old('email_toogle')))
				visibleDiv('email', "{{old('email_toogle')}}" )
				$('#email_toogle').val('1')
			@else
				@if (isset($result['email_toogle']))
					visibleDiv('email', "{{$result['email_toogle']}}")
					$('#email_toogle').val("{{$result['email_toogle']}}")
				@endif
			@endif

			@if (!empty(old('sms_toogle')))
				visibleDiv('sms', "{{old('sms_toogle')}}")
			@else
				@if (isset($result['sms_toogle']))
					visibleDiv('sms', "{{$result['sms_toogle']}}")
				@endif
			@endif

			@if (!empty(old('whatsapp_toogle')))
				visibleDiv('whatsapp', "{{old('whatsapp_toogle')}}")
			@else
				@if (isset($result['whatsapp_toogle']))
					visibleDiv('whatsapp', "{{$result['whatsapp_toogle']}}")
				@endif
			@endif

        });

	function addEmailContent(param){
		var textvalue = $('#email_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#email_content').val(textvaluebaru);
		$('#email_content').summernote('editor.saveRange');
		$('#email_content').summernote('editor.restoreRange');
		$('#email_content').summernote('editor.focus');
		$('#email_content').summernote('editor.insertText', param);
    }

    function addEmailSubject(param){
		var textvalue = $('#email_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#email_subject').val(textvaluebaru);
    }

	function addSmsContent(param){
		var textvalue = $('#sms_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#sms_content').val(textvaluebaru);
    }

	function addWhatsappContent(param){
		var textvalue = $('#whatsapp_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#whatsapp_content').val(textvaluebaru);
    }

	function visibleDiv(apa,nilai){
		if(apa == 'email'){
			@if(MyHelper::hasAccess([38], $configs))
				if(nilai=='1'){
					document.getElementById('div_email_recipient').style.display = 'block';
					document.getElementById('div_email_subject').style.display = 'block';
					document.getElementById('div_email_content').style.display = 'block';
					$('.field_email').prop('required', true);
				} else {
					document.getElementById('div_email_recipient').style.display = 'none';
					document.getElementById('div_email_subject').style.display = 'none';
					document.getElementById('div_email_content').style.display = 'none';
					$('.field_email').prop('required', false);
				}
			@endif
		}
		if(apa == 'sms'){
			@if(MyHelper::hasAccess([39], $configs))
				if(nilai=='1'){
					document.getElementById('div_sms_content').style.display = 'block';
					document.getElementById('div_sms_recipient').style.display = 'block';
					$('.field_sms').prop('required', true);
				} else {
					document.getElementById('div_sms_content').style.display = 'none';
					document.getElementById('div_sms_recipient').style.display = 'none';
					$('.field_sms').prop('required', false);
				}
			@endif
		}

		if(apa == 'whatsapp'){
			@if(MyHelper::hasAccess([74], $configs))
				@if($api_key_whatsapp)
					if(nilai=='1'){
						document.getElementById('div_whatsapp_content').style.display = 'block';
						document.getElementById('div_whatsapp_recipient').style.display = 'block';
						$('.field_whatsapp').prop('required', true);
					} else {
						document.getElementById('div_whatsapp_content').style.display = 'none';
						document.getElementById('div_whatsapp_recipient').style.display = 'none';
						$('.field_whatsapp').prop('required', false);
					}
				@endif
			@endif
		}
	}

    </script>

@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/">Home</a>
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
<br>
@include('layouts.notifications')
	<div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">{{ $sub_title }}</span>
            </div>
        </div>
		<div class="portlet-body form">
			<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST" enctype="multipart/form-data" id="form">
				<div class="portlet light bordered" id="trigger">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-dark sbold uppercase font-yellow">Parameter</span>
						</div>
					</div>
					<div class="portlet-body form">
						<div class="form-group">
							<label class="col-md-3 control-label" >Fraud Detection Parameter</label>
							<div class="col-md-9">
                                <input type="text" class="form-control" name="parameter_detail" value="{{$result['parameter']}}" disabled>
							</div>
						</div>

						<div class="form-group" id="type-detail" @if(strpos($result['parameter'], 'transaction') === false) style="display:none" @endif>
							<label class="col-md-3 control-label" ></label>
							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon">
										>=
									</span>
									<input type="number" class="form-control price" min="1" name="parameter_detail" value="{{$result['parameter_detail']}}">
									<span class="input-group-addon">
										Transactions / @if(strpos($result['parameter'], 'week') !== false) Week @elseif(strpos($result['parameter'], 'day') !== false) Day @endif
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-dark sbold uppercase font-yellow">Action</span>
						</div>
					</div>
					<div class="portlet-body form">
						<div class="form-body">
							@if(MyHelper::hasAccess([38], $configs))
								<h4>Email</h4>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Status
											<i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan email sebagai media pengiriman laporan fraud detection" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="email_toogle" id="email_toogle" class="form-control select2" onChange="visibleDiv('email',this.value)">
											<option value="0" @if(old('email_toogle') == '0') selected @else @if(isset($result['email_toogle']) && $result['email_toogle'] == "0") selected @endif @endif>Disabled</option>
											<option value="1" @if(old('email_toogle') == '1') selected @else @if(isset($result['email_toogle']) && $result['email_toogle'] == "1") selected @endif @endif>Enabled</option>
										</select>
									</div>
								</div>

								<div class="form-group" id="div_email_recipient" style="display:none">
									<div class="input-icon right">
										<label for="multiple" class="control-label col-md-3">
											Email Recipient
											<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan alamat email admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<textarea name="email_recipient" id="email_recipient" class="form-control field_email" placeholder="Email address recipient">@if(isset($result['email_recipient'])){{ $result['email_recipient'] }}@endif</textarea>
										<p class="help-block">Comma ( , ) separated for multiple emails</p>
									</div>
								</div>

								<div class="form-group" id="div_email_subject" style="display:none">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Subject
											<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan subjek email, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<input type="text" placeholder="Email Subject" class="form-control field_email" name="email_subject" id="email_subject" @if(!empty(old('email_subject'))) value="{{old('email_subject')}}" @else @if(isset($result['email_subject']) && $result['email_subject'] != '') value="{{$result['email_subject']}}" @endif @endif>
										<br>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row">
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
									</div>
								</div>
								<div class="form-group" id="div_email_content" style="display:none">
									<div class="input-icon right">
										<label for="multiple" class="control-label col-md-3">
											Content
											<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten email, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<textarea name="email_content" id="email_content" class="form-control summernote">@if(!empty(old('email_content'))) <?php echo old('email_content'); ?> @else @if(isset($result['email_content']) && $result['email_content'] != '') <?php echo $result['email_content'];?> @endif @endif</textarea>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row" >
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
									</div>
								</div>
								<hr>
							@endif
							@if(MyHelper::hasAccess([39], $configs))
								<h4>SMS</h4>
								<div class="form-group" >
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Status
											<i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan sms sebagai media pengiriman auto crm ini" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="sms_toogle" id="sms_toogle" class="form-control select2" onChange="visibleDiv('sms',this.value)">
											<option value="0" @if(old('sms_toogle') == '0') selected @else @if(isset($result['sms_toogle']) && $result['sms_toogle'] == "0") selected @endif @endif>Disabled</option>
											<option value="1" @if(old('sms_toogle') == '1') selected @else @if(isset($result['sms_toogle']) && $result['sms_toogle'] == "1") selected @endif @endif>Enabled</option>
										</select>

									</div>
								</div>
								<div class="form-group" id="div_sms_recipient" style="display:none">
									<div class="input-icon right">
										<label for="multiple" class="control-label col-md-3">
											SMS Recipient
											<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no handphone admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<textarea name="sms_recipient" id="sms_recipient" class="form-control field_sms" placeholder="Phone number recipient">@if(isset($result['sms_recipient'])){{ $result['sms_recipient'] }}@endif</textarea>
										<p class="help-block">Comma ( , ) separated for multiple phone number</p>
									</div>
								</div>
								<div class="form-group" id="div_sms_content" style="display:none">
									<div class="input-icon right">
										<label for="multiple" class="control-label col-md-3">
											SMS Content
											<i class="fa fa-question-circle tooltips" data-original-title="isi pesan sms, tambahkan text replacer bila perlu" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<textarea name="sms_content" id="sms_content" class="form-control field_sms" placeholder="SMS Content">@if(!empty(old('sms_content'))) {{old('sms_content')}} @else @if(isset($result['sms_content']) && $result['sms_content'] != '') {{$result['sms_content']}} @endif @endif</textarea>
										<br>
										You can use this variables to display user personalized information:
										<br><br>
										<div class="row">
											@foreach($textreplaces as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
												</div>
											@endforeach
										</div>
									</div>
								</div>
								<hr>
							@endif

							@if(MyHelper::hasAccess([74], $configs))
								@if(!$api_key_whatsapp)
									<div class="alert alert-warning deteksi-trigger">
										<p> To use WhatsApp channel you have to set the api key in <a href="{{url('setting/whatsapp')}}">WhatsApp Setting</a>. </p>
									</div>
								@endif
								<h4>WhatsApp</h4>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Status
											<i class="fa fa-question-circle tooltips" data-original-title="pilih enabled untuk mengaktifkan whatsApp sebagai media pengiriman auto crm ini" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<select name="whatsapp_toogle" id="whatsapp_toogle" class="form-control select2 field_whatsapp" onChange="visibleDiv('whatsapp',this.value)" @if(!$api_key_whatsapp) disabled @endif>
											<option value="0" @if(old('whatsapp_toogle') == '0') selected @else @if(isset($result['whatsapp_toogle']) && $result['whatsapp_toogle'] == "0") selected @endif @endif>Disabled</option>
											<option value="1" @if($api_key_whatsapp) @if(old('whatsapp_toogle') == '1') selected @else @if(isset($result['whatsapp_toogle']) && $result['whatsapp_toogle'] == "1") selected @endif @endif @endif>Enabled</option>
										</select>
									</div>
								</div>
								@if($api_key_whatsapp)
									<div class="form-group" id="div_whatsapp_recipient" style="display:none">
										<div class="input-icon right">
											<label for="multiple" class="control-label col-md-3">
												WhatsApp Recipient
												<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan no WhatsApp admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
											</label>
										</div>
										<div class="col-md-9">
											<textarea name="whatsapp_recipient" id="whatsapp_recipient" class="form-control field_whatsapp" placeholder="WhatsApp number recipient">@if(isset($result['whatsapp_recipient'])){{ $result['whatsapp_recipient'] }}@endif</textarea>
											<p class="help-block">Comma ( , ) separated for multiple whatsApp number</p>
										</div>
									</div>
									<div class="form-group" id="div_whatsapp_content" style="display:none">
										<div class="input-icon right">
											<label for="multiple" class="control-label col-md-3">
												WhatsApp Content
												<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp, tambahkan text replacer bila perlu" data-container="body"></i>
											</label>
										</div>
										<div class="col-md-9">
											<textarea id="whatsapp_content" name="whatsapp_content" rows="3" style="white-space: normal" class="form-control whatsapp-content" placeholder="WhatsApp Content">{{$result['whatsapp_content']}}</textarea>
											<br>
											You can use this variables to display user personalized information:
											<br><br>
											<div class="row">
												@foreach($textreplaces as $key=>$row)
													<div class="col-md-3" style="margin-bottom:5px;">
														<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal; height:40px" data-toogle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
													</div>
												@endforeach
											</div>
										</div>
									</div>
								@endif
							@endif

						</div>
					</div>
                    <div class="form-actions">
						{{ csrf_field() }}
						<input type="hidden" value="{{$result['id_fraud_setting']}}" name="id_fraud_setting">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn blue" id="checkBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
			</form>
		</div>
	</div>
@endsection