<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
 @extends('layouts.main-closed')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>

	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery.input-ip-address-control-1.0.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-input-mask.min.js') }}" type="text/javascript"></script>
	<script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
	});
	$('.timepicker').timepicker();
    </script>

	<script>
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

		@if(count($result['contents']) > 0)
			@if($result['promotion_series'] > 0)
				@for($x = 1;$x <= $result['promotion_series']; $x++)
				var clickto 	 = null;
				var clicktoInbox = null;
				var idref 		 = null;
				var idrefInbox 	 = null;

				@if(isset($result['contents'][$x-1]['promotion_push_clickto']))
					clickto 	 = "{{$result['contents'][$x-1]['promotion_push_clickto']}}";
				@endif
				@if(isset($result['contents'][$x-1]['promotion_inbox_clickto']))
					clicktoInbox = "{{$result['contents'][$x-1]['promotion_inbox_clickto']}}";
				@endif
				@if(isset($result['contents'][$x-1]['promotion_push_id_reference']))
					idref 		 = "{{$result['contents'][$x-1]['promotion_push_id_reference']}}";
				@endif
				@if(isset($result['contents'][$x-1]['promotion_inbox_id_reference']))
					var idrefInbox 	 = "{{$result['contents'][$x-1]['promotion_inbox_id_reference']}}";
				@endif

				if(clickto != null) {
					if(idref != null){
						fetchDetail("{{$x}}", "push", clickto, idref);
					}else{
						fetchDetail("{{$x}}", "push", clickto, 0);
					}
				}
				if(clicktoInbox != null) {
					if(idrefInbox != null){
						fetchDetail("{{$x}}", "inbox", clicktoInbox, idrefInbox);
					}else{
						fetchDetail("{{$x}}", "inbox", clicktoInbox, 0);
					}
				}
				@endfor
			@else
				var clickto 	 = null;
				var clicktoInbox = null;
				var idref 		 = null;
				var idrefInbox 	 = null;

				@if(isset($result['contents'][0]['promotion_push_clickto']))
					clickto 	 = "{{$result['contents'][0]['promotion_push_clickto']}}";
				@endif
				@if(isset($result['contents'][0]['promotion_inbox_clickto']))
					clicktoInbox = "{{$result['contents'][0]['promotion_inbox_clickto']}}";
				@endif
				@if(isset($result['contents'][0]['promotion_push_id_reference']))
					idref 		 = "{{$result['contents'][0]['promotion_push_id_reference']}}";
				@endif
				@if(isset($result['contents'][0]['promotion_inbox_id_reference']))
					var idrefInbox 	 = "{{$result['contents'][0]['promotion_inbox_id_reference']}}";
				@endif

				if(clickto != null) {
					if(idref != null){
						fetchDetail("0", "push", clickto, idref);
					}else{
						fetchDetail("0", "push", clickto, 0);
					}
				}
				if(clicktoInbox != null) {
					if(idrefInbox != null){
						fetchDetail("0", "inbox", clicktoInbox, idrefInbox);
					}else{
						fetchDetail("0", "inbox", clicktoInbox, 0);
					}
				}
			@endif
		@endif

		var _URL = window.URL || window.webkitURL;

		$('.price').each(function() {
			var input = $(this).val();
			var input = input.replace(/[\D\s\._\-]+/g, "");
			input = input ? parseInt( input, 10 ) : 0;

			$(this).val( function() {
				return ( input === 0 ) ? "" : input.toLocaleString( "id" );
			});
		});
		token = '<?php echo csrf_token();?>';

		/*$('.summernote').summernote({
			placeholder: 'Deals Content Long',
			tabsize: 2,
			height: 120
		});*/
	});

	function dealsPromoType(channel, series){
		var checkboxStatus = document.getElementById('radio_'+series+'_dealstype_'+channel+'').checked;
		if(channel == 'promoid') var antichannel = 'nominal'; else var antichannel = 'promoid';
		document.getElementById('deals_promo_id_'+channel+'_'+series+'').style.display = 'block';
		document.getElementById('deals_promo_id_'+antichannel+'_'+series+'').style.display = 'none';
	}

	function dealsVoucherExpiry(channel, series){
		var checkboxStatus = document.getElementById('voucher_expiry_'+channel+'_'+series+'').checked;
		if(channel == 'bydate') var antichannel = 'duration'; else var antichannel = 'bydate';
		document.getElementById('voucher_'+channel+'_'+series+'').style.display = 'block';
		document.getElementById('voucher_'+antichannel+'_'+series+'').style.display = 'none';
	}

	function dealsVoucherType(channel, series){
		var checkboxStatus = document.getElementById('voucher_type_'+channel+'_'+series+'').checked;
		if(channel == 'unlimited'){
			document.getElementById('vouchertype_autogenerated_'+series+'').style.display = 'none';
			document.getElementById('vouchertype_listvoucher_'+series+'').style.display = 'none';
			document.getElementById('vouchertype_autogenerated_input_'+series+'').value = '';
			document.getElementById('vouchertype_listvoucher_input_'+series+'').value = '';
		} else {
			if(channel == 'autogenerated'){
				var antichannel = 'listvoucher';
			}else {
				var antichannel = 'autogenerated';
			}
			document.getElementById('vouchertype_'+channel+'_'+series+'').style.display = 'block';
			document.getElementById('vouchertype_'+antichannel+'_'+series+'').style.display = 'none';
			document.getElementById('vouchertype_'+antichannel+'_input_'+series+'').value = '';
		}
	}

	function campaignChannel(channel, series){
		var checkboxStatus = document.getElementById('checkbox_'+series+'_'+channel+'').checked;
		if(checkboxStatus == true){
			document.getElementById('content_'+channel+'_'+series+'').style.display = 'block';
		} else {
			document.getElementById('content_'+channel+'_'+series+'').style.display = 'none';
		}
	}

	function addEmailSubject(series,param){
		var textvalue = $('#promotion_email_subject_'+series+'').val();
		var textvaluebaru = textvalue+" "+param;
		$('#promotion_email_subject_'+series+'').val(textvaluebaru);
    }

	function addEmailContent(series,param){
		var textvalue = $('#promotion_email_content_'+series+'').val();

		var textvaluebaru = textvalue+" "+param;
		$('#promotion_email_content_'+series+'').val(textvaluebaru);
		$('#promotion_email_content_'+series+'').summernote('editor.saveRange');
		$('#promotion_email_content_'+series+'').summernote('editor.restoreRange');
		$('#promotion_email_content_'+series+'').summernote('editor.focus');
		$('#promotion_email_content_'+series+'').summernote('editor.insertText', param);
    }

	function addSmsContent(series,param){
		var textvalue = $('#promotion_sms_content_'+series+'').val();
		var textvaluebaru = textvalue+" "+param;
		$('#promotion_sms_content_'+series+'').val(textvaluebaru);
    }

	function addPushSubject(series,param){
		var textvalue = $('#promotion_push_subject_'+series+'').val();
		var textvaluebaru = textvalue+" "+param;
		$('#promotion_push_subject_'+series+'').val(textvaluebaru);
    }

	function addPushContent(series,param){
		var textvalue = $('#promotion_push_content_'+series+'').val();
		var textvaluebaru = textvalue+" "+param;
		$('#promotion_push_content_'+series+'').val(textvaluebaru);
    }

	function addInboxSubject(series,param){
		var textvalue = $('#promotion_inbox_subject_'+series+'').val();
		var textvaluebaru = textvalue+" "+param;
		$('#promotion_inbox_subject_'+series+'').val(textvaluebaru);
    }

	function addInboxContent(series,param){
		var textvalue = $('#promotion_inbox_content_'+series+'').val();

		var textvaluebaru = textvalue+" "+param;
		$('#promotion_inbox_content_'+series+'').val(textvaluebaru);
		$('#promotion_inbox_content_'+series+'').summernote('editor.saveRange');
		$('#promotion_inbox_content_'+series+'').summernote('editor.restoreRange');
		$('#promotion_inbox_content_'+series+'').summernote('editor.focus');
		$('#promotion_inbox_content_'+series+'').summernote('editor.insertText', param);
    }

	function fetchDetail(series, type, det, idref){
		let token  = "{{ csrf_token() }}";

		if(det == 'Product'){
			$.ajax({
				type : "GET",
				url : "{{ url('product/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type+'_'+series).style.display = 'block';
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_product']){
							$('#promotion_'+type+'_id_reference_'+series).text(result[x]['product_name'])
						}
					}
				}
			});
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			if(type=="inbox") document.getElementById(type+'_content_'+series).style.display = 'none';
		}

		if(det == 'Outlet'){
			$.ajax({
				type : "GET",
				url : "{{ url('outlet/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type+'_'+series).style.display = 'block';
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_outlet']){
							$('#promotion_'+type+'_id_reference_'+series).text(result[x]['outlet_name'])
						}
					}
				}
			});
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			if(type=="inbox") document.getElementById(type+'_content_'+series).style.display = 'none';
		}

		if(det == 'News'){
			$.ajax({
				type : "GET",
				url : "{{ url('news/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type+'_'+series).style.display = 'block';
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_news']){
							$('#promotion_'+type+'_id_reference_'+series).text(result[x]['news_title'])
						}
					}
				}
			});
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			if(type=="inbox") document.getElementById(type+'_content_'+series).style.display = 'none';
		}

		if(det == 'Home' || det == 'Inbox' || det == 'Voucher' || det == 'Voucher Detail' || det == 'Contact Us' || det == 'Logout'){
			document.getElementById('atd_'+type+'_'+series).style.display = 'none';
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			if(type=="inbox") document.getElementById(type+'_content_'+series).style.display = 'none';
		}

		if(det == 'Link'){
			document.getElementById('atd_'+type+'_'+series).style.display = 'none';
			document.getElementById('link_'+type+'_'+series).style.display = 'block';
			if(type=="inbox"){
				document.getElementById(type+'_content_'+series).style.display = 'none';
			}

		}

		if(det == 'Content'){
			document.getElementById('atd_'+type+'_'+series).style.display = 'none';
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			document.getElementById(type+'_content_'+series).style.display = 'block';
		}
	}

	function modalSentList(type, id, page = null){
		var link = "{{Url('promotion/sent/list')}}/"+id+"/"+page
		if(type == 'email_link') link = "{{Url('promotion/linkclicked/list')}}/"+id+"/"+page+'/email'
		else if(type == 'sms_link') link = "{{Url('promotion/linkclicked/list')}}/"+id+"/"+page+'/sms'
		else if(type == 'whatsapp_link') link = "{{Url('promotion/linkclicked/list')}}/"+id+"/"+page+'/whatsapp'
		else if(type == 'voucher') link = "{{Url('promotion/voucher/list')}}/"+id+"/"+page
		else if(type == 'voucher_give') link = "{{Url('promotion/voucher/list')}}/"+id+"/"+page+"/given"
		else if(type == 'voucher_used') link = "{{Url('promotion/voucher/list')}}/"+id+"/"+page+"/used"
		else if(type == 'nominal_trx') link = "{{Url('promotion/voucher/trx')}}/"+id+"/"+page
		else link = link +"/"+type

		$('#theadSentList').empty()
		$('#tbodySentList').empty()

		$.get(link, function(result){
			if(type == 'email' || type == 'email_read'){
				$('.modal-title').text('List Email Sent')
				if(type == 'email_read') $('.modal-title').text('List Email Read')
				$('#theadSentList').append(
					'<tr><th>No</th><th>Name</th><th>Email</th><th>Send At</th><th>Status</th></tr>'
				)
			}else if(type == 'sms' || type == 'push' || type == 'inbox' || type == 'whatsapp'){
				$('#theadSentList').append(
					'<tr><th>No</th><th>Name</th><th>Phone</th><th>Send At</th></tr>'
				)
				if(type == 'sms') $('.modal-title').text('List SMS Sent')
				if(type == 'push') $('.modal-title').text('List Push Notification Sent')
				if(type == 'inbox') $('.modal-title').text('List Inbox Sent')
				if(type == 'whatsapp') $('.modal-title').text('List Whatsapp Sent')
			}else if(type.indexOf('link') > 0 ){
				if(type == 'email_link') $('.modal-title').text('Email Link List')
				if(type == 'sms_link') $('.modal-title').text('SMS Link List')
				if(type == 'whatsapp_link') $('.modal-title').text('WhatsApp Link List')
				$('#theadSentList').append(
					'<tr><th>No</th><th>Original Link</th><th>Shorten Link</th><th>Clicked</th><th>Unique Clicked</th></tr>'
				)
			}else if(type == 'voucher'){
				$('.modal-title').text('Voucher List')
				$('#theadSentList').append(
					'<tr><th>No</th><th>Voucher Code</th><th>Status</th><th>User name</th></tr>'
				)
			}else if(type == 'voucher_give'){
				$('.modal-title').text('Voucher Given List')
				$('#theadSentList').append(
					'<tr><th>No</th><th>Voucher Code</th><th>User name</th><th>Claimed At</th><th>Redeemed At</th><th>Used At</th></tr>'
				)
			}else if(type == 'voucher_used'){
				$('.modal-title').text('Voucher Used List')
				$('#theadSentList').append(
					'<tr><th>No</th><th>Voucher Code</th><th>User name</th><th>Claimed At</th><th>Redeemed At</th><th>Used At</th></tr>'
				)
			}else if(type == 'nominal_trx'){
				$('.modal-title').text('Voucher Transaction List')
				$('#theadSentList').append(
					'<tr><th>No</th><th>Voucher Code</th><<th>User name</th><th>Receipt Number</th><th>Transaction Date</th><th>Outlet</th><th>Grand Total</th></tr>'
				)
			}

			if(result.data && result.data.length > 0){
				var no = result.from
				$.each(result.data, function(i,data){
					var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']

					if(type == 'email' || type == 'email_read'){
						if(data.email_read == "1"){
							var status = "Read"
						}else{
							var status = "Unread"
						}
						var date = new Date(data.send_at)
						var minute = date.getMinutes()
						if(date.getMinutes() < 10) minute = '0'+date.getMinutes()
						$('#tbodySentList').append(
							'<tr>'+
								'<td>'+no+'</td>'+
								'<td>'+data.user.name+'</td>'+
								'<td>'+data.user.email+'</td>'+
								'<td>'+date.getDate()+' '+months[date.getMonth()]+' '+date.getFullYear()+' '+date.getHours()+':'+minute+'</td>'+
								'<td>'+status+'</td>'+
							'<tr>'
						)
					}else if(type == 'sms' || type == 'push' || type == 'inbox'){
						var date = new Date(data.send_at)
						var minute = date.getMinutes()
						if(date.getMinutes() < 10) minute = '0'+date.getMinutes()
						$('#tbodySentList').append(
							'<tr>'+
								'<td>'+no+'</td>'+
								'<td>'+data.user.name+'</td>'+
								'<td>'+data.user.phone+'</td>'+
								'<td>'+date.getDate()+' '+months[date.getMonth()]+' '+date.getFullYear()+' '+date.getHours()+':'+minute+'</td>'+
							'<tr>'
						)
					}else if(type.indexOf('link') > 0 ){
						$('#tbodySentList').append(
							'<tr>'+
								'<td>'+no+'</td>'+
								'<td>'+data.original_link+'</td>'+
								'<td>'+data.short_link+'</td>'+
								'<td>'+data.link_clicked+'</td>'+
								'<td>'+data.link_unique_clicked+'</td>'+
							'<tr>'
						)
					}else if(type == 'voucher'){
						if(data.name == null) data.name = ""
						$('#tbodySentList').append(
							'<tr>'+
								'<td>'+no+'</td>'+
								'<td>'+data.voucher_code+'</td>'+
								'<td>'+data.deals_voucher_status+'</td>'+
								'<td>'+data.name+'</td>'+
							'<tr>'
						)
					}else if(type == 'voucher_give' || type == 'voucher_used'){
						var redeem_date = ""
						if(data.redeemed_at != null){
							redeem_date = new Date(data.redeemed_at)
							var redeem_minute = redeem_date.getMinutes()
							if(redeem_date.getMinutes() < 10) redeem_minute = '0'+redeem_date.getMinutes()

							redeem_date = redeem_date.getDate()+' '+months[redeem_date.getMonth()]+' '+redeem_date.getFullYear()+' '+redeem_date.getHours()+':'+redeem_minute
						}
						var used_date = ""
						if(data.redeemed_at != null){
							used_date = new Date(data.used_at)
							var used_minute = used_date.getMinutes()
							if(used_date.getMinutes() < 10) used_minute = '0'+used_date.getMinutes()

							used_date = used_date.getDate()+' '+months[used_date.getMonth()]+' '+used_date.getFullYear()+' '+used_date.getHours()+':'+used_minute
						}
						var claim_date = ""
						if(data.claimed_at != null){
							claim_date = new Date(data.claimed_at)
							var claim_minute = claim_date.getMinutes()
							if(claim_date.getMinutes() < 10) claim_minute = '0'+claim_date.getMinutes()

							claim_date = claim_date.getDate()+' '+months[claim_date.getMonth()]+' '+claim_date.getFullYear()+' '+claim_date.getHours()+':'+claim_minute
						}
						$('#tbodySentList').append(
							'<tr>'+
								'<td>'+no+'</td>'+
								'<td>'+data.voucher_code+'</td>'+
								'<td>'+data.name+'</td>'+
								'<td>'+claim_date+'</td>'+
								'<td>'+redeem_date+'</td>'+
								'<td>'+used_date+'</td>'+
							'<tr>'
						)
					}else if(type == 'nominal_trx'){
						var trx_date = new Date(data.transaction_date)
						var minute = trx_date.getMinutes()
						var url = "{{url('')}}"
						if(trx_date.getMinutes() < 10) minute = '0'+trx_date.getMinutes()
						$('#tbodySentList').append(
							'<tr>'+
								'<td>'+no+'</td>'+
								'<td>'+data.voucher_code+'</td>'+
								'<td>'+data.user.name+'</td>'+
								'<td><a href="'+url+'/transaction/detail/'+data.transaction_receipt_number+'/'+data.trasaction_type+'")}}">'+data.transaction_receipt_number+'</td>'+
								'<td>'+trx_date.getDate()+' '+months[trx_date.getMonth()]+' '+trx_date.getFullYear()+' '+trx_date.getHours()+':'+minute+'</td>'+
								'<td>'+data.outlet.outlet_name+'</td>'+
								'<td>'+data.transaction_grandtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>'+
							'<tr>'
						)
					}
					no++;
				})

				if(result.prev_page_url == null){
					$('.page-first').addClass('disabled')
					$('.page-first').attr('onclick', null)
				}else{
					$('.page-first').removeClass('disabled')
					var prev_page = result.current_page - 1;
					$('.page-first').attr('onclick', "modalSentList('"+type+"',"+id+","+prev_page+")");
				}

				if(result.next_page_url == null){
					$('.page-last').addClass('disabled')
					$('.page-last').attr('onclick', null)
				}else{
					$('.page-last').removeClass('disabled')
					var next_page = result.current_page + 1;
					$('.page-last').attr('onclick', "modalSentList('"+type+"',"+id+","+next_page+")");
				}
			}else{
				$('#tbodySentList').append(
					'<tr>'+
						'<td colspan="10" style="text-align:center">No data available in table</td>'+
					'<tr>'
				)
				$('.page-first').addClass('disabled')
				$('.page-first').attr('onclick', null)
				$('.page-last').addClass('disabled')
				$('.page-last').attr('onclick', null)
			}
		})
		$('#modalSentList').modal('show');
	}
	</script>
	{{--
	<script type="text/javascript">

		$(function() {
			$('body').on('click', '.pagination-recipient .pagination a', function(e) {
				e.preventDefault();

				var url = $(this).attr('href');
				getArticles(url);
				window.history.pushState("", "", url);
			});

			function getArticles(url) {
				$.ajax({
					url : url
				}).done(function (data) {
					$('.recipient').html(data);
				}).fail(function () {
					alert('recipient could not be loaded.');
				});
			}
		});

		</script>
		--}}
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
		<div class="mt-element-step">
			<div class="row step-line">
				<div class="col-md-4 mt-step-col first">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Info</div>
					<div class="mt-step-content font-grey-cascade">Promotion Setup</div>
				</div>
				<div class="col-md-4 mt-step-col">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Content</div>
					<div class="mt-step-content font-grey-cascade">Promotion Content</div>
				</div>
				<div class="col-md-4 mt-step-col last active">
					<div class="mt-step-number bg-white">3</div>
					<div class="mt-step-title uppercase font-grey-cascade">Summary</div>
					<div class="mt-step-content font-grey-cascade">Promotion Result</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="col-md-8">
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i>Promotion Info </div>
				</div>
				<div class="portlet-body form">
					<form class="form-horizontal" role="form">
						<div class="form-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<div class="col-md-12">
											<p class="form-control-static">Name</p>
										</div>
										<div class="col-md-12">
											<p class="form-control-static"><b>{{$result['promotion_name']}}</b></p>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="col-md-12">
											<p class="form-control-static">Type</p>
										</div>
										<div class="col-md-12">
											<p class="form-control-static"><b>{{$result['promotion_type']}}
											@if($result['promotion_type'] == 'Campaign Series')
											(Series of {{$result['promotion_series']}} campaigns)
											@endif
											</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<div class="col-md-12">
											<p class="form-control-static">Promotion User Limit</p>
										</div>
										<div class="col-md-12">
											<p class="form-control-static"><b>@if($result['promotion_user_limit'] == '0') Every user can receive continuously @else Each user can only receive 1 time @endif</b></p>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="col-md-12">
											@if(isset($users) && count($users) > 0 && isset($result['promotion_type']) && $result['promotion_type'] == "Instant Campaign")
												<p class="form-control-static">Promotion has been sent:</p>
											@else
												<p class="form-control-static">Promotion will be sent:</p>
											@endif
										</div>
									@if(isset($result['promotion_type']) && $result['promotion_type'] == "Instant Campaign")
										<div class="col-md-12">
											@if(isset($users) && count($users) > 0)
											<p class="form-control-static"><b>On
													{{date('d F Y', strtotime($result['schedules'][0]['schedule_exact_date']))}} at {{substr($result['schedules'][0]['schedule_time'],0,-3)}}</b></p>
											@else
												<p class="form-control-static"><b>NOW (Immidiately)</b></p>
											@endif
										</div>
									@endif
									@if(isset($result['promotion_type']) && $result['promotion_type'] == "Scheduled Campaign")
										<div class="col-md-12">
											<p class="form-control-static"><b>On
											{{date('d F Y', strtotime($result['schedules'][0]['schedule_exact_date']))}} at {{substr($result['schedules'][0]['schedule_time'],0,-3)}}</b></p>
										</div>
									@endif

									@if(isset($result['promotion_type']) && ($result['promotion_type'] == "Recurring Campaign" || $result['promotion_type'] == "Campaign Series"))
										@if(isset($result['schedules'][0]['schedule_date_month']) && $result['schedules'][0]['schedule_date_month'] != "")
											<?php
												$year = date('Y');
												$x = explode('-',$result['schedules'][0]['schedule_date_month']);
											?>
											<div class="col-md-12">
												<p class="form-control-static"><b>Every {{date('F', strtotime($year.'-'.$x[1].'-'.$x[0]))}}{{$x[0]}} each year at {{substr($result['schedules'][0]['schedule_time'],0,-3)}}</b></p>
											</div>
										@endif
										@if(isset($result['schedules'][0]['schedule_date_every_month']) && $result['schedules'][0]['schedule_date_every_month'] != "")
											<?php
												$ends = array('th','st','nd','rd','th','th','th','th','th','th');
												if (($result['schedules'][0]['schedule_date_every_month'] %100) >= 11 && ($result['schedules'][0]['schedule_date_every_month']%100) <= 13)
												   $abbreviation = $result['schedules'][0]['schedule_date_every_month']. 'th';
												else
												   $abbreviation = $result['schedules'][0]['schedule_date_every_month']. $ends[$result['schedules'][0]['schedule_date_every_month'] % 10];
											?>
											<div class="col-md-12">
												<p class="form-control-static"><b>Every {{$abbreviation}} each month at {{substr($result['schedules'][0]['schedule_time'],0,-3)}}</b></p>
											</div>
										@endif

										@if(isset($result['schedules'][0]['schedule_day_every_week']) && $result['schedules'][0]['schedule_day_every_week'] != "")
											<?php
												$ends = array('th','st','nd','rd','th','th','th','th','th','th');
												if (($result['schedules'][0]['schedule_week_in_month'] %100) >= 11 && ($result['schedules'][0]['schedule_week_in_month']%100) <= 13)
												   $abbreviation = $result['schedules'][0]['schedule_week_in_month']. 'th';
												else
												   $abbreviation = $result['schedules'][0]['schedule_week_in_month']. $ends[$result['schedules'][0]['schedule_week_in_month'] % 10];
											?>
											<div class="col-md-12">
												<p class="form-control-static"><b>Every {{$result['schedules'][0]['schedule_day_every_week']}}

												@if($result['schedules'][0]['schedule_week_in_month'] != 0)
													on {{$abbreviation}} week
												@else
													every week
												@endif
												at {{substr($result['schedules'][0]['schedule_time'],0,-3)}}</b></p>
											</div>

										@endif

										@if(isset($result['schedules'][0]['schedule_everyday']) && $result['schedules'][0]['schedule_everyday'] == 'Yes')
											<div class="col-md-12">
												<p class="form-control-static"><b>Every Day at {{substr($result['schedules'][0]['schedule_time'],0,-3)}}</b></p></b></p>
											</div>
										@endif
									@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<div class="col-md-12">
											<p class="form-control-static">Promotion Creator & Created Time</p>
										</div>
										<div class="col-md-12">
											<p class="form-control-static"><b>By {{$result['user']['name']}} at {{date('d F Y H:i', strtotime($result['created_at']))}}</b></p>
										</div>
									</div>
								</div>
								@if ($result['promotion_type'] == 'Recurring Campaign' || $result['promotion_type'] == 'Campaign Series')
								<div class="col-md-6">
									<div class="form-group">
										<div class="col-md-12">
											<p class="form-control-static">Promotion Periode</p>
										</div>
										<div class="col-md-12">
											@if( isset($result['schedules'][0]['date_start']) && isset($result['schedules'][0]['date_end']) )
												<p class="form-control-static"><b>{{ date('d M Y H:i', strtotime($result['schedules'][0]['date_start'])) }} - {{ date('d M Y H:i', strtotime($result['schedules'][0]['date_end'])) }}</b></p>
											@else
												<p class="form-control-static"><b>-</b></p>
											@endif
										</div>
									</div>
								</div>
								@endif
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i>Promotion Target </div>
				</div>
				<div class="portlet-body form">
					<form class="form-horizontal" role="form">
						<div class="form-body">
							<div class="row">
								<div class="col-md-12">
									@if(count($result['promotion_rule_parents']) > 0)
									<div class="form-group">
										<div class="row static-info">
											<div class="col-md-12">
												<p class="form-control-static" style="padding-left: 15px;">Users with this criteria:</p>
											</div>
										</div>
										@php $i=0; @endphp
										@foreach($result['promotion_rule_parents'] as $ruleParent)
											<div class="portlet light bordered" style="margin-bottom:10px">
												@foreach($ruleParent['rules'] as $rule)
												<div class="row static-info">
													@if($rule['subject'] != 'trx_outlet' && $rule['subject'] != 'trx_product')
														<div class="col-md-12 value"><li>{{ucwords(str_replace("_", " ", $rule['subject']))}} @if(empty($rule['operator']))=@else{{$rule['operator']}}@endif
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
											@if(count($result['promotion_rule_parents']) > 1 && $i < count($result['promotion_rule_parents']) - 1)
											<div class="row static-info" style="text-align:center">
												<div class="col-md-11 value">
													{{strtoupper($ruleParent['rule_next'])}}
												</div>
											</div>
											@endif
											@php $i++; @endphp
										@endforeach
									</div>
									@else
										All User
									@endif
								</div>

								<a href="{{url('promotion/recipient/'.$result['id_promotion'])}}" target="_blank" class="btn blue" style="margin-left: 15px;">Show Recipient List</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
		@if($result['promotion_type'] == 'Campaign Series')
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>Promotion Content </div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<form role="form" action="" method="POST">
						<div class="col-md-2 col-sm-2 col-xs-2">
							<ul class="nav nav-tabs tabs-left">
								@for($x = 1;$x <= $result['promotion_series']; $x++)
									<li @if($x == 1) class="active" @endif>
										<a href="#tab_{{$x}}" data-toggle="tab"> Campaign {{$x}} </a>
									</li>
								@endfor
							</ul>
						</div>
						<div class="col-md-10 col-sm-10 col-xs-10">
							<div class="tab-content">
								@for($x = 1;$x <= $result['promotion_series']; $x++)
								@if(isset($result['contents'][$x-1]))
									<div @if($x == 1) class="tab-pane active" @else class="tab-pane" @endif id="tab_{{$x}}">
										@if($x > 1)
										<div class="col-md-12">
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">Campaign Series Setting</span>
													</div>
												</div>
												<div class="portlet-body">
													<div class="form-group">
															Campaign no {{$x}} will be send
															{{$result['contents'][$x-1]['promotion_series_days']}} days after previous campaign (campaign no {{$x-1}})
													</div>
												</div>
											</div>
										</div>
										@else
											<input type="hidden" required name="promotion_series_days[]" id="promotion_series_days_{{$x}}" value=0>
										@endif
										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_email'] == '1')
												<div class="col-md-10" style="display:block;" id="content_email_{{$x}}">
											@else
												<div class="col-md-10" style="display:none;" id="content_email_{{$x}}">
											@endif
										@else
											<div class="col-md-10" style="display:none;" id="content_email_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">Email Content</span>
													</div>
												</div>
												<div class="portlet-body">
													<div class="row">
														<div class="col-md-3" style="margin-bottom:30px">Subject</div>
														<div class="col-md-9" style="margin-bottom:30px">
															{{$result['contents'][$x-1]['promotion_email_subject']}}
														</div>
														<div class="col-md-3" style="margin-bottom:30px">Content</div>
														<div class="col-md-12" style="padding-left:0; overflow-x:auto">
															<?php
															$html_message = $result['contents'][$x-1]['promotion_email_content'];
															?>
															@include('emails.test')
														</div>
													</div>
												</div>
											</div>
										</div>
										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_email'] == '1')
												<div class="col-md-2" style="display:block; padding:0" id="content_email_{{$x}}">
											@else
												<div class="col-md-2" style="display:none;" id="content_email_{{$x}}">
											@endif
										@else
											<div class="col-md-2" style="display:none;" id="content_email_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">Email Result</span>
													</div>
												</div>
												<div class="row list-separated">
													<div class="col-md-12" style="margin-bottom:15px">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_email_sent'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('email',{{$result['contents'][$x-1]['id_promotion_content']}})"> Email Sent </a></div>
													</div>
													<div class="col-md-12" style="margin-bottom:15px">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_email_read'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('email_read',{{$result['contents'][$x-1]['id_promotion_content']}})"> Email Read </a></div>
													</div>
													<div class="col-md-12">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_email_link_clicked'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('email_link',{{$result['contents'][$x-1]['id_promotion_content']}})"> Link Clicked </a></div>
													</div>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_sms'] == '1')
												<div class="col-md-10" style="display:block;" id="content_sms_{{$x}}">
											@else
												<div class="col-md-10" style="display:none;" id="content_sms_{{$x}}">
											@endif
										@else
											<div class="col-md-10" style="display:none;" id="content_sms_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">SMS Content</span>
													</div>
												</div>
												<div class="portlet-body">
													<div class="row">
														<div class="col-md-3" style="margin-bottom:30px">Content</div>
														<div class="col-md-9" style="margin-bottom:30px">
															"{{$result['contents'][$x-1]['promotion_sms_content']}}"
														</div>
													</div>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_sms'] == '1')
												<div class="col-md-2" style="display:block; padding:0" id="result_sms_{{$x}}">
											@else
												<div class="col-md-2" style="display:none;" id="result_sms_{{$x}}">
											@endif
										@else
											<div class="col-md-2" style="display:none;" id="result_sms_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">SMS Result</span>
													</div>
												</div>
												<div class="row list-separated">
													<div class="col-md-12" style="margin-bottom:15px">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_sms_sent'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('sms',{{$result['contents'][$x-1]['id_promotion_content']}})"> SMS Sent </a></div>
													</div>
													<div class="col-md-12">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_sms_link_clicked'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('sms_link',{{$result['contents'][$x-1]['id_promotion_content']}})"> Link Clicked </a></div>
													</div>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_push'] == '1')
												<div class="col-md-10" style="display:block;" id="content_push_{{$x}}">
											@else
												<div class="col-md-10" style="display:none;" id="content_push_{{$x}}">
											@endif
										@else
											<div class="col-md-10" style="display:none;" id="content_push_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">Push Notification Content</span>
													</div>
												</div>
												<div class="portlet-body">
													<div class="row">
														<div class="col-md-3" style="margin-bottom:30px">Subject</div>
														<div class="col-md-9" style="margin-bottom:30px">
															{{$result['contents'][$x-1]['promotion_push_subject']}}
														</div>

														<div class="col-md-3" style="margin-bottom:30px">Content</div>
														<div class="col-md-9" style="margin-bottom:30px">
															{{$result['contents'][$x-1]['promotion_push_content']}}
														</div>

														<div for="promotion_push_image" class="col-md-3" style="margin-bottom:30px">Gambar</div>
														<div class="col-md-9" style="margin-bottom:30px">
															<div class="fileinput fileinput-new" data-provides="fileinput">
																<div class="fileinput-new thumbnail" style="width: 200px; height: auto; max-height:150px; padding:0">
																	@if(isset($result['contents'][$x-1]['promotion_push_image']) && $result['contents'][$x-1]['promotion_push_image'] != "")
																		<img src="{{ env('S3_URL_API')}}/{{$result['contents'][$x-1]['promotion_push_image']}}" id="autocrm_push_image" style="padding:5px;max-height:150px" />
																	@else
																		<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="autocrm_push_image" style="height:150px"/>
																	@endif
																</div>
															</div>
														</div>

														<div for="promotion_push_clickto" class="col-md-3" style="margin-bottom:30px">Click Action</div>
														<div class="col-md-9" style="margin-bottom:30px">
															@if(isset($result['contents'][$x-1]['promotion_push_clickto'])) {{$result['contents'][$x-1]['promotion_push_clickto']}}
															@endif
														</div>

														<div class="form-group" id="atd_push_{{$x}}" style="display:none;">
															<div for="promotion_push_id_reference_{{$x}}" class="col-md-3" style="margin-bottom:30px">Action to Detail</div>
															<div class="col-md-9"  style="margin-bottom:30px" id="promotion_push_id_reference_{{$x}}" >
															</div>
														</div>

														<div id="link_push_{{$x}}" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
															<div for="promotion_push_link" class="col-md-3">Link</div>
															<div class="col-md-9" style="margin-bottom:30px" id="promotion_push_link_{{$x}}">
																@if(isset($result['contents'][$x-1]['promotion_push_link'])) {{$result['contents'][$x-1]['promotion_push_link']}} @endif
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_push'] == '1')
												<div class="col-md-2" style="display:block; padding:0" id="result_push_{{$x}}">
											@else
												<div class="col-md-2" style="display:none;" id="result_push_{{$x}}">
											@endif
										@else
											<div class="col-md-2" style="display:none;" id="result_push_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">Push Notif Result</span>
													</div>
												</div>
												<div class="row list-separated">
													<div class="col-md-12">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_push'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('push',{{$result['contents'][$x-1]['id_promotion_content']}})"> Push Notification Count </a></div>
													</div>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_inbox'] == '1')
												<div class="col-md-10" style="display:block;" id="content_inbox_{{$x}}">
											@else
												<div class="col-md-10" style="display:none;" id="content_inbox_{{$x}}">
											@endif
										@else
											<div class="col-md-10" style="display:none;" id="content_inbox_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">Inbox Content</span>
													</div>
												</div>
												<div class="portlet-body">
													<div class="row">
														<div class="col-md-3" style="margin-bottom:30px">Subject</div>
														<div class="col-md-9" style="margin-bottom:30px">
															{{$result['contents'][$x-1]['promotion_inbox_subject']}}
														</div>

														<div for="promotion_inbox_clickto" class="col-md-3" style="margin-bottom:30px">Click Action</div>
														<div class="col-md-9" style="margin-bottom:30px">
															@if(isset($result['contents'][$x-1]['promotion_inbox_clickto']))
																{{$result['contents'][$x-1]['promotion_inbox_clickto']}}
															@endif
														</div>

														<div id="atd_inbox_{{$x}}" style="display:none;">
															<div for="promotion_push_id_reference_{{$x}}" class="col-md-3" style="margin-bottom:30px">Action to Detail</div>
															<div class="col-md-9" id="promotion_inbox_id_reference_{{$x}}" style="margin-bottom:30px"></div>
														</div>

														<div id="link_inbox_{{$x}}" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
															<div for="promotion_inbox_link" class="col-md-3" style="margin-bottom:30px">Link</div>
															<div class="col-md-9" style="margin-bottom:30px" id="promotion_inbox_link_0" >
																@if(isset($result['contents'][$x-1]['promotion_inbox_link'])) {{$result['contents'][$x-1]['promotion_inbox_link']}} @endif
															</div>
														</div>

														<div id="inbox_content_{{$x}}" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
															<div class="col-md-3" style="margin-bottom:30px">Content</div>
															<div class="col-md-9" style="margin-bottom:30px">
																@if(isset($result['contents'][$x-1])) @if($result['contents'][$x-1]['promotion_inbox_content']) <?php echo $result['contents'][$x-1]['promotion_inbox_content'] ?> @endif @endif
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_inbox'] == '1')
												<div class="col-md-2" style="display:block; padding:0" id="result_inbox_{{$x}}">
											@else
												<div class="col-md-2" style="display:none;" id="result_inbox_{{$x}}">
											@endif
										@else
											<div class="col-md-2" style="display:none;" id="result_inbox_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">Inbox Result</span>
													</div>
												</div>
												<div class="row list-separated">
													<div class="col-md-12">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_inbox'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('inbox',{{$result['contents'][$x-1]['id_promotion_content']}})"> Inbox Count </a></div>
													</div>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_whatsapp'] == '1')
												<div class="col-md-10" style="display:block;" id="content_whatsapp_{{$x}}">
											@else
												<div class="col-md-10" style="display:none;" id="content_whatsapp_{{$x}}">
											@endif
										@else
											<div class="col-md-10" style="display:none;" id="content_whatsapp_{{$x}}">
										@endif
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
															@foreach($result['contents'][$x-1]['whatsapp_content'] as $index => $content)
															<div class="form-group row">
																<label class="col-md-3">Content {{$index+1}}</label>
																<div class="col-md-9">
																	@if($content['content_type'] == 'text')
																		{{$content['content']}}
																	@elseif($content['content_type'] == 'image')
																		<div class="fileinput-new thumbnail" style="width: 200px; height: auto; margin-bottom:0">
																			<img src="{{$content['content']}}" alt="" style="max-height:190px">
																		</div>
																	@elseif($content['content_type'] == 'file')
																		@php $file = explode('/', $content['content']) @endphp
																		<a href= "{{$content['content']}}"> <i class="fa fa-file-pdf-o"></i> {{end($file)}} </a>
																	@endif
																</div>
															</div>
															@endforeach
														</div>
													</form>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_whatsapp'] == '1')
												<div class="col-md-2" style="display:block; padding:0" id="result_whatsapp_{{$x}}">
											@else
												<div class="col-md-2" style="display:none;" id="result_whatsapp_{{$x}}">
											@endif
										@else
											<div class="col-md-2" style="display:none;" id="result_whatsapp_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">WhatsApp Result</span>
													</div>
												</div>
												<div class="row list-separated">
													<div class="col-md-12" style="margin-bottom:15px">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_whatsapp'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('whatsapp',{{$result['contents'][$x-1]['id_promotion_content']}})"> WhatsApp Count </a></div>
													</div>
													<div class="col-md-12">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_whatsapp'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('whatsapp_link',{{$result['contents'][$x-1]['id_promotion_content']}})"> WhatsApp Link Clicked </a></div>
													</div>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['id_deals'] != '')
												<div class="col-md-10" style="display:block;" id="content_deals_{{$x}}">
											@else
												<div class="col-md-10" style="display:none;" id="content_deals_{{$x}}">
											@endif
										@else
											<div class="col-md-10" style="display:none;" id="content_deals_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">Deals Setting</span>
													</div>
												</div>
												<div class="portlet-body">
													<div class="row">
														<div class="col-md-3 " style="margin-bottom:30px">Deals Title</div>
														<div class="col-md-9" style="margin-bottom:30px">
															{{$result['contents'][$x-1]['deals']['deals_title']}}
														</div>

														<div class="col-md-3 " style="margin-bottom:30px">Deals Type</div>
														<div class="col-md-9" style="margin-bottom:30px">
															@php
																$deals['is_offline'] = $result['contents'][$x-1]['deals']['is_offline'];
																$deals['is_online'] = $result['contents'][$x-1]['deals']['is_online'];
															@endphp
															@if (!empty($deals['is_online']) && !empty($deals['is_offline']))
							                        			{{'Online, Offline'}}
							                        		@elseif (!empty($deals['is_online']))
							                        			{{'Online'}}
							                        		@elseif (!empty($deals['is_offline']))
							                        			{{'Offline'}}
							                        		@endif
														</div>

														<div class="col-md-3 " style="margin-bottom:30px">Promo Type</div>
														<div class="col-md-9" style="margin-bottom:30px">
															@if($result['contents'][$x-1]['deals']['deals_promo_id_type'] == 'promoid')Promo ID @else Nominal @endif
															@if(isset($result['contents'][$x-1]['deals']['deals_promo_id_type']))
																	= {{$result['contents'][$x-1]['deals']['deals_promo_id']}}
															@endif
														</div>

														<div class="col-md-3 " style="margin-bottom:30px">Nominal Voucher</div>
														<div class="col-md-9" style="margin-bottom:30px">
															{{number_format($result['contents'][$x-1]['voucher_value'])}}
														</div>

														{{-- <div class="col-md-3 " style="margin-bottom:30px"> Deals Periode </div>
														<div class="col-md-9" style="margin-bottom:30px">
															@if(isset($result['contents'][$x-1]['deals']['deals_start']))
																@if($result['contents'][$x-1]['deals']['deals_start'] != '')
																{{date('d M Y H:i',strtotime($result['contents'][$x-1]['deals']['deals_start']))}}
																@endif
															@endif

															@if(isset($result['contents'][$x-1]['deals']['deals_end']))
																@if($result['contents'][$x-1]['deals']['deals_end'] != '')
																	-  {{date('d M Y H:i',strtotime($result['contents'][$x-1]['deals']['deals_end']))}}
																@endif
															@endif
														</div> --}}

														<div class="col-md-3 "style="margin-bottom:30px"> Outlet Available </div>
														<div class="col-md-9" style="margin-bottom:30px">
															@if (!empty($outlets))
																@if($result['contents'][$x-1]['deals']['is_all_outlet'])
																	All Outlets
																@else
																	<?php $ou = array(); $jmlOutlet = count($outlets); $jmlOutletSelected = 0?>
																	@if(isset($result['contents'][$x-1]['deals']['outlets']))
																		@foreach($result['contents'][$x-1]['deals']['outlets'] as $o)
																			<?php
																			array_push($ou, $o['id_outlet']);
																			?>
																		@endforeach
																		@php
																			$jmlOutletSelected = count($ou);
																		@endphp
																	@endif

																	@if ($jmlOutlet == $jmlOutletSelected)
																		All Outlets
																	@else
																		@foreach($outlets as $suw)
																			@if(in_array($suw['id_outlet'], $ou)) {{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }} <br> @endif
																		@endforeach
																	@endif
																@endif
															@endif
														</div>

														<div class="col-md-3 " style="margin-bottom:30px"> Voucher Expiry </div>
														<div class="col-md-9" style="margin-bottom:30px">
															@if(isset($result['contents'][$x-1]['deals']['deals_voucher_expired']))
																@if($result['contents'][$x-1]['deals']['deals_voucher_expired'] != '')
																	By Date: {{date('d M Y H:i',strtotime($result['contents'][$x-1]['deals']['deals_voucher_expired']))}}
																@endif
															@elseif(isset($result['contents'][$x-1]['deals']['deals_voucher_duration']))
																@if($result['contents'][$x-1]['deals']['deals_voucher_duration'] != '')
																	By Duration: {{$result['contents'][$x-1]['deals']['deals_voucher_duration']}} days
																@endif
															@else
															-
															@endif
														</div>

														<div class="col-md-3 " style="margin-bottom:30px"> Voucher Type  </div>
														<div class="col-md-9" style="margin-bottom:30px">
															@if(isset($result['contents'][$x-1]['deals']['deals_voucher_type']))
																@if($result['contents'][$x-1]['deals']['deals_voucher_type'] == 'Auto generated')
																	Auto Generated, total {{$result['contents'][$x-1]['deals']['deals_total_voucher']}} voucher
																@endif
															@endif

															@if(isset($result['contents'][$x-1]['deals']['deals_voucher_type']))
																@if($result['contents'][$x-1]['deals']['deals_voucher_type'] == 'List Vouchers')
																	List Vouchers:<br>
																	@foreach($result['contents'][$x-1]['deals']['deals_vouchers'] as $vouchers){{$vouchers['voucher_code']}}&#13;&#10;@endforeach
																@endif
															@endif

															@if(isset($result['contents'][$x-1]['deals']['deals_voucher_type']))
																@if($result['contents'][$x-1]['deals']['deals_voucher_type'] == 'Unlimited')
																	Unlimited
																@endif
															@endif
														</div>

														<div class="col-md-3" style="margin-bottom:30px">Every User Receives</div>
														<div class="col-md-9" style="margin-bottom:30px">
															{{number_format($result['contents'][$x-1]['voucher_given'])}} @if($result['contents'][$x-1]['voucher_given'] > 1) Vouchers @else Voucher @endif
														</div>
														@php
															$deals_slug = MyHelper::createSlug($result['contents'][$x-1]['deals']['id_deals'], $result['contents'][$x-1]['deals']['created_at']);
														@endphp
														<div class="col-md-3" style="margin-bottom:30px">
															<a href="{{ url('promotion-deals/'.$deals_slug) }}" class="btn blue">detail</i></a>
														</div>
													</div>
												</div>
											</div>
										</div>

										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['id_deals'] != '')
												<div class="col-md-10" style="display:block;" id="result_deals_{{$x}}">
											@else
												<div class="col-md-10" style="display:none;" id="result_deals_{{$x}}">
											@endif
										@else
											<div class="col-md-10" style="display:none;" id="result_deals_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">Deals Result</span>
													</div>
												</div>
												<div class="row list-separated">
													<div class="col-md-6" style="margin-bottom:15px">
														<div class="uppercase profile-stat-title font-red bold" @if($result['contents'][$x-1]['deals']['deals_voucher_type'] == 'Unlimited') style="font-size: 20px;padding-bottom:5px"> Unlimited @else > {{number_format($result['contents'][$x-1]['deals']['deals_total_voucher'])}} @endif</div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('voucher',{{$result['contents'][$x-1]['id_promotion_content']}})"> Total Voucher </a></div>
													</div>
													<div class="col-md-6" style="margin-bottom:15px">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['deals']['deals_total_used'] * $result['contents'][$x-1]['voucher_value'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('voucher_used',{{$result['contents'][$x-1]['id_promotion_content']}})"> Total Nominal Voucher Used </a></div>
													</div>
													<div class="col-md-6" style="margin-bottom:15px">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_count_voucher_give'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('voucher_give',{{$result['contents'][$x-1]['id_promotion_content']}})"> Total Voucher Given </a></div>
													</div>
													<div class="col-md-6" style="margin-bottom:15px">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['promotion_sum_transaction'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('nominal_trx',{{$result['contents'][$x-1]['id_promotion_content']}})"> Total Nominal Transaction </a></div>
													</div>
													<div class="col-md-6" style="margin-bottom:15px">
														<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][$x-1]['deals']['deals_total_used'])}} </div>
														<div class="uppercase profile-stat-text"><a onclick="modalSentList('voucher_used',{{$result['contents'][$x-1]['id_promotion_content']}})"> Total Voucher Used </a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<input type="hidden"
									name="id_deals[]"
									id="id_deals_{{$x}}"
									@if(isset($result['contents'][$x-1]['deals']['id_deals']))
										value={{$result['contents'][$x-1]['deals']['id_deals']}}
									@endif>
									<input type="hidden"
									name="id_promotion_content[]"
									id="id_promotion_content_{{$x}}"
									@if(isset($result['contents'][$x-1]['id_promotion_content']))
										value={{$result['contents'][$x-1]['id_promotion_content']}}
									@endif>
								@endif
								@endfor
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		@else
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>Promotion Content </div>
			</div>
			<div class="portlet-body">
				<div class="row">
					@if(isset($result['contents'][0]) && count($result['contents'][0]) > 0)
					<form role="form" action="" method="POST">
						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_email'] == '1')
								<div class="col-md-10" style="display:block;" id="content_email_0">
							@else
								<div class="col-md-10" style="display:none;" id="content_email_0">
							@endif
						@else
							<div class="col-md-10" style="display:none;" id="content_email_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Email Content</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="portlet-body">
										<div class="row">
											<div class="col-md-2" style="margin-bottom:30px">Subject</div>
											<div class="col-md-10" style="margin-bottom:30px">
												{{$result['contents'][0]['promotion_email_subject']}}
											</div>
											<div for="multiple" class="col-md-2" style="margin-bottom:30px">Content</div>
											<div class="col-md-10" style="margin-bottom:30px">
											<div class="col-md-12" style="padding-left:0; overflow-x:auto">
												<?php
												$html_message = $result['contents'][0]['promotion_email_content'];
												?>
												@include('emails.test')
											</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_email'] == '1')
								<div class="col-md-2" style="display:block; padding-left:0;" id="result_email_0">
							@else
								<div class="col-md-2" style="display:none;" id="result_email_0">
							@endif
						@else
							<div class="col-md-2" style="display:none;" id="result_email_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Email Result</span>
									</div>
								</div>
								<div class="row list-separated">
									<div class="col-md-12" style="margin-bottom:15px">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_email_sent'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('email',{{$result['contents'][0]['id_promotion_content']}})"> Email Sent </a></div>
									</div>
									<div class="col-md-12" style="margin-bottom:15px">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_email_read'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('email_read',{{$result['contents'][0]['id_promotion_content']}})"> Email Read </a></div>
									</div>
									<div class="col-md-12">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_email_link_clicked'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('email_link',{{$result['contents'][0]['id_promotion_content']}})"> Link Clicked </a></div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_sms'] == '1')
								<div class="col-md-10" style="display:block;" id="content_sms_0">
							@else
								<div class="col-md-10" style="display:none;" id="content_sms_0">
							@endif
						@else
							<div class="col-md-10" style="display:none;" id="content_sms_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">SMS Content</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="row">
										<div class="col-md-2" style="margin-bottom:30px">Content</div>
										<div class="col-md-10" style="margin-bottom:30px">
											"{{$result['contents'][0]['promotion_sms_content']}}"
										</div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_sms'] == '1')
								<div class="col-md-2" style="display:block;  padding-left:0;" id="result_sms_0">
							@else
								<div class="col-md-2" style="display:none;" id="result_sms_0">
							@endif
						@else
							<div class="col-md-2" style="display:none;" id="result_sms_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">SMS Result</span>
									</div>
								</div>
								<div class="row list-separated">
									<div class="col-md-12" style="margin-bottom:15px">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_sms_sent'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('sms',{{$result['contents'][0]['id_promotion_content']}})"> SMS Sent </a></div>
									</div>
									<div class="col-md-12">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_sms_link_clicked'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('sms_link',{{$result['contents'][0]['id_promotion_content']}})"> Link Clicked </a></div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_push'] == '1')
								<div class="col-md-10" style="display:block;" id="content_push_0">
							@else
								<div class="col-md-10" style="display:none;" id="content_push_0">
							@endif
						@else
							<div class="col-md-10" style="display:none;" id="content_push_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Push Notification Content</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="row">
										<div class="col-md-2" style="margin-bottom:30px">Subject</div>
										<div class="col-md-10" style="margin-bottom:30px">
											{{$result['contents'][0]['promotion_push_subject']}}
										</div>

										<div class="col-md-2" style="margin-bottom:30px">Content</div>
										<div class="col-md-10" style="margin-bottom:30px">
											@if(isset($result['contents'][0])) @if($result['contents'][0]['promotion_push_content']){{$result['contents'][0]['promotion_push_content']}}@endif @endif
										</div>

										<div for="promotion_push_image" class="col-md-2">Gambar</div>
										<div class="col-md-10" style="margin-bottom:30px">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 200px; height: auto; max-height:150px; padding:0">
													@if(isset($result['contents'][0]['promotion_push_image']) && $result['contents'][0]['promotion_push_image'] != "")
														<img src="{{ env('S3_URL_API')}}/{{$result['contents'][0]['promotion_push_image']}}" id="autocrm_push_image" style="padding:5px;max-height:150px" />
													@else
														<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="autocrm_push_image" style="height:150px"/>
													@endif
												</div>
											</div>
										</div>

										<div for="promotion_push_clickto" class="col-md-2" style="margin-bottom:30px">Click Action</div>
										<div class="col-md-10" style="margin-bottom:30px">
											@if(isset($result['contents'][0]['promotion_push_clickto']))
												{{$result['contents'][0]['promotion_push_clickto']}}
											@endif
										</div>

										<div id="atd_push_0" style="display:none;">
											<div for="promotion_push_id_reference_0" class="col-md-2" style="margin-bottom:30px">Action to Detail</div>
											<div class="col-md-10" id="promotion_push_id_reference_0" style="margin-bottom:30px"></div>
										</div>

										<div id="link_push_0" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
											<div for="promotion_push_link" class="col-md-2" style="margin-bottom:30px">Link</div>
											<div class="col-md-10" style="margin-bottom:15px" id="promotion_push_link_0" >
												@if(isset($result['contents'][0]['promotion_push_link'])) {{$result['contents'][0]['promotion_push_link']}} @endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_push'] == '1')
								<div class="col-md-2" style="display:block;  padding-left:0;" id="result_push_0">
							@else
								<div class="col-md-2" style="display:none;" id="result_push_0">
							@endif
						@else
							<div class="col-md-2" style="display:none;" id="result_push_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Push Notif Result</span>
									</div>
								</div>
								<div class="row list-separated">
									<div class="col-md-12">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_push'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('push',{{$result['contents'][0]['id_promotion_content']}})"> Push Count </a></div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_inbox'] == '1')
								<div class="col-md-10" style="display:block;" id="content_inbox_0">
							@else
								<div class="col-md-10" style="display:none;" id="content_inbox_0">
							@endif
						@else
							<div class="col-md-10" style="display:none;" id="content_inbox_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Inbox Content</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="row">
										<div class="col-md-2" style="margin-bottom:30px">Subject</div>
										<div class="col-md-10" style="margin-bottom:30px">
											{{$result['contents'][0]['promotion_inbox_subject']}}
										</div>

										<div for="promotion_inbox_clickto" class="col-md-2" style="margin-bottom:30px">Click Action</div>
										<div class="col-md-10" style="margin-bottom:30px">
											@if(isset($result['contents'][0]['promotion_inbox_clickto']))
												{{$result['contents'][0]['promotion_inbox_clickto']}}
											@endif
										</div>

										<div id="atd_inbox_0" style="display:none;">
											<div for="promotion_push_id_reference_0" class="col-md-2" style="margin-bottom:30px">Action to Detail</div>
											<div class="col-md-10" id="promotion_inbox_id_reference_0" style="margin-bottom:30px"></div>
										</div>

										<div id="link_inbox_0" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
											<div for="promotion_inbox_link" class="col-md-2" style="margin-bottom:30px">Link</div>
											<div class="col-md-10" style="margin-bottom:30px" id="promotion_inbox_link_0" >
												@if(isset($result['contents'][0]['promotion_inbox_link'])) {{$result['contents'][0]['promotion_inbox_link']}} @endif
											</div>
										</div>

										<div id="inbox_content_0" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
											<div class="col-md-2" style="margin-bottom:30px">Content</div>
											<div class="col-md-10" style="margin-bottom:30px">
												@if(isset($result['contents'][0])) @if($result['contents'][0]['promotion_inbox_content']) <?php echo $result['contents'][0]['promotion_inbox_content'] ?> @endif @endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_inbox'] == '1')
								<div class="col-md-2" style="display:block; padding-left:0;" id="result_inbox_0">
							@else
								<div class="col-md-2" style="display:none;" id="result_inbox_0">
							@endif
						@else
							<div class="col-md-2" style="display:none;" id="result_inbox_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Inbox Result</span>
									</div>
								</div>
								<div class="row list-separated">
									<div class="col-md-12">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_inbox'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('inbox',{{$result['contents'][0]['id_promotion_content']}})"> Inbox Count </a></div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_whatsapp'] == '1')
								<div class="col-md-10" style="display:block;" id="content_whatsapp_0">
							@else
								<div class="col-md-10" style="display:none;" id="content_whatsapp_0">
							@endif
						@else
							<div class="col-md-10" style="display:none;" id="content_whatsapp_0">
						@endif
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
											@foreach($result['contents'][0]['whatsapp_content'] as $index => $content)
											<div class="form-group">
												<label class="col-md-3">Content {{$index+1}}</label>
												<div class="col-md-9">
													@if($content['content_type'] == 'text')
														{{$content['content']}}
													@elseif($content['content_type'] == 'image')
														<div class="fileinput-new thumbnail" style="width: 200px; height: 200px; margin-bottom:0">
															<img src="{{$content['content']}}" alt="" style="max-height:190px">
														</div>
													@elseif($content['content_type'] == 'file')
														@php $file = explode('/', $content['content']) @endphp
														<a href= "{{$content['content']}}"> <i class="fa fa-file-pdf-o"></i> {{end($file)}} </a>
													@endif
												</div>
											</div>
											@endforeach
										</div>
									</form>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_whatsapp'] == '1')
								<div class="col-md-2" style="display:block; padding:0" id="result_whatsapp_0">
							@else
								<div class="col-md-2" style="display:none;" id="result_whatsapp_0">
							@endif
						@else
							<div class="col-md-2" style="display:none;" id="result_whatsapp_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">WhatsApp Result</span>
									</div>
								</div>
								<div class="row list-separated">
									<div class="col-md-12" style="margin-bottom:15px">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_whatsapp'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('whatsapp',{{$result['contents'][0]['id_promotion_content']}})"> WhatsApp Count </a></div>
									</div>
									<div class="col-md-12">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_whatsapp'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('whatsapp_link',{{$result['contents'][0]['id_promotion_content']}})"> WhatsApp Link Clicked </a></div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['id_deals'] != '')
								<div class="col-md-10" style="display:block;" id="content_deals_0">
							@else
								<div class="col-md-10" style="display:none;" id="content_deals_0">
							@endif
						@else
							<div class="col-md-10" style="display:none;" id="content_deals_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Deals Setting</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="row">
										<div class="col-md-3" style="margin-bottom:30px">Promo Type</div>
										<div class="col-md-9" style="margin-bottom:30px">
											<div class="input-icon right">
												@if($result['contents'][0]['deals']['deals_promo_id_type'] == 'promoid')Promo ID @else Nominal @endif
												@if(isset($result['contents'][0]['deals']['deals_promo_id_type']))
														= {{$result['contents'][0]['deals']['deals_promo_id']}}
												@endif
											</div>
										</div>

										<div class="col-md-3" style="margin-bottom:30px">Nominal Voucher</div>
										<div class="col-md-9" style="margin-bottom:30px">
											{{number_format($result['contents'][0]['voucher_value'])}}
										</div>

										{{-- <div class="col-md-3" style="margin-bottom:30px"> Deals Periode </div>
										<div class="col-md-9" style="margin-bottom:30px">
											@if(isset($result['contents'][0]['deals']['deals_start']))
												@if($result['contents'][0]['deals']['deals_start'] != '')
												{{date('d M Y H:i',strtotime($result['contents'][0]['deals']['deals_start']))}}
												@endif
											@endif

											@if(isset($result['contents'][0]['deals']['deals_end']))
												@if($result['contents'][0]['deals']['deals_end'] != '')
													-  {{date('d M Y H:i',strtotime($result['contents'][0]['deals']['deals_end']))}}
												@endif
											@endif
										</div> --}}
										<div class="col-md-3" style="margin-bottom:30px"> Outlet Available </div>
										<div class="col-md-9" style="margin-bottom:30px">
											@if (!empty($outlets))
												<?php $ou = array(); $jmlOutlet = count($outlets); $jmlOutletSelected = 0?>
												@if(isset($result['contents'][0]['deals']['outlets']))
													@foreach($result['contents'][0]['deals']['outlets'] as $o)
														<?php
														array_push($ou, $o['id_outlet']);
														?>
													@endforeach
													@php
														$jmlOutletSelected = count($ou);
													@endphp
												@endif

												@if ($jmlOutlet == $jmlOutletSelected)
													All Outlets
												@else
													@foreach($outlets as $suw)
														@if(in_array($suw['id_outlet'], $ou)) {{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }} <br> @endif
													@endforeach
												@endif
											@endif
										</div>

										@if(!empty($result['contents'][0]['deals']['deals_voucher_start']))
										<div class="col-md-3" style="margin-bottom:30px"> Voucher Start  </div>
										<div class="col-md-9" style="margin-bottom:30px">
												By Date: {{date('d M Y H:i',strtotime($result['contents'][0]['deals']['deals_voucher_start']))}}
										</div>
										@endif

										<div class="col-md-3" style="margin-bottom:30px"> Voucher Expiry  </div>
										<div class="col-md-9" style="margin-bottom:30px">
											@if(isset($result['contents'][0]['deals']['deals_voucher_expired']))
												@if($result['contents'][0]['deals']['deals_voucher_expired'] != '')
													By Date: {{date('d M Y H:i',strtotime($result['contents'][0]['deals']['deals_voucher_expired']))}}
												@endif
											@endif

											@if(isset($result['contents'][0]['deals']['deals_voucher_duration']))
												@if($result['contents'][0]['deals']['deals_voucher_duration'] != '')
													By Duration: {{$result['contents'][0]['deals']['deals_voucher_duration']}} days
												@endif
											@endif
										</div>
										<div class="col-md-3" style="margin-bottom:30px"> Voucher Type  </div>
										<div class="col-md-9" style="margin-bottom:30px">
											@if(isset($result['contents'][0]['deals']['deals_voucher_type']))
												@if($result['contents'][0]['deals']['deals_voucher_type'] == 'Auto generated')
													Auto Generated, total {{$result['contents'][0]['deals']['deals_total_voucher']}} voucher
												@endif
											@endif

											@if(isset($result['contents'][0]['deals']['deals_voucher_type']))
												@if($result['contents'][0]['deals']['deals_voucher_type'] == 'List Vouchers')
													List Vouchers:<br>
													@foreach($result['contents'][0]['deals']['deals_vouchers'] as $vouchers){{$vouchers['voucher_code']}}&#13;&#10;@endforeach
												@endif
											@endif

											@if(isset($result['contents'][0]['deals']['deals_voucher_type']))
												@if($result['contents'][0]['deals']['deals_voucher_type'] == 'Unlimited')
													Unlimited
												@endif
											@endif
										</div>

										<div class="col-md-3" style="margin-bottom:30px">Every User Receives</div>
										<div class="col-md-9" style="margin-bottom:30px">
											{{number_format($result['contents'][0]['voucher_given'])}} @if($result['contents'][0]['voucher_given'] > 1) Vouchers @else Voucher @endif
										</div>

										@php
											$deals_slug = MyHelper::createSlug($result['contents'][0]['deals']['id_deals'],$result['contents'][0]['deals']['created_at']);
										@endphp
										<div class="col-md-3" style="margin-bottom:30px">
											<a href="{{ url('promotion-deals/'.$deals_slug) }}" class="btn blue">Detail</i></a>
										</div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['id_deals'] != '')
								<div class="col-md-10" style="display:block;" id="result_deals_0">
							@else
								<div class="col-md-10" style="display:none;" id="result_deals_0">
							@endif
						@else
							<div class="col-md-10" style="display:none;" id="result_deals_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Deals Result</span>
									</div>
								</div>
								<div class="row list-separated">
									<div class="col-md-6" style="margin-bottom:15px">
										<div class="uppercase profile-stat-title font-red bold" @if($result['contents'][0]['deals']['deals_voucher_type'] == 'Unlimited') style="font-size: 20px; padding-bottom:5px"> Unlimited @else > {{number_format($result['contents'][0]['deals']['deals_total_voucher'])}} @endif</div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('voucher',{{$result['contents'][0]['id_promotion_content']}})"> Total Voucher </a></div>
									</div>
									<div class="col-md-6" style="margin-bottom:15px">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['deals']['deals_total_used'] * $result['contents'][0]['voucher_value'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('voucher_used',{{$result['contents'][0]['id_promotion_content']}})"> Total Nominal Voucher Used </a></div>
									</div>
									<div class="col-md-6" style="margin-bottom:15px">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_count_voucher_give'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('voucher_give',{{$result['contents'][0]['id_promotion_content']}})"> Total Voucher Given </a></div>
									</div>
									<div class="col-md-6" style="margin-bottom:15px">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['promotion_sum_transaction'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('nominal_trx',{{$result['contents'][0]['id_promotion_content']}})"> Total Nominal Transaction </a></div>
									</div>
									<div class="col-md-6" style="margin-bottom:15px">
										<div class="uppercase profile-stat-title font-red bold"> {{number_format($result['contents'][0]['deals']['deals_total_used'])}} </div>
										<div class="uppercase profile-stat-text"><a onclick="modalSentList('voucher_used',{{$result['contents'][0]['id_promotion_content']}})"> Total Voucher Used </a></div>
									</div>
								</div>
							</div>
						</div>

					</form>
					@endif
				</div>
			</div>
		</div>
		@endif

	{{--
		<div class="recipient">
			@include('promotion::recipient')
		</div>
	--}}

	</div>
	<div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
			<div class="portlet light bordered">
				<div class="form-actions">
					<div class="row">
						<div class="col-md-offset-5 col-md-7">
							<a href="{{url('promotion/step2').'/'.$result['id_promotion']}}" class="btn default">Previous Step</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade bs-modal-lg" id="modalSentList" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Sent List</h4>
				</div>
				<div class="modal-body">
					<table class="table table-striped table-bordered table-hover dt-responsive tablesData" id="tablesDataComplaint" width="100%">
						<thead id="theadSentList">

						</thead>
						<tbody id="tbodySentList">

						</tbody>
					</table>
					<div class="col-md-12" style="padding-left:0px;padding-right:0px;">
						<div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
							<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
								<li class="page-first"><a href="javascript:void(0)">«</a></li>
								<li class="page-last"><a href="javascript:void(0)">»</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="modal-footer" style="margin-top:35px">
					<button type="button" data-dismiss="modal" class="btn default">Close</button>
				</div>
			</div>
		</div>
	</div>
@endsection