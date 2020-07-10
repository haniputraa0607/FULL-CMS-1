<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');
?>
 @extends('layouts.main-closed')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
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
	<script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js') }}" type="text/javascript"></script>
	<script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
	$('.timepicker').timepicker();
	$(".form_datetime").datetimepicker({
        format: "d-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true
    });

    </script>

	<script>
	$(document).ready(function() {
		$('.summernote').summernote({
			placeholder: 'Content',
			tabsize: 2,
			height: 120,
        	fontNames: ['Open Sans'],
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
						url: "{{url('summernote/picture/delete/promotion')}}",
						success: function(data){
							// console.log(data);
						}
					});
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
				url : "{{url('summernote/picture/upload/promotion')}}",
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

		$('.summernote').summernote({
			placeholder: 'Deals Content Long',
			tabsize: 2,
        	fontNames: ['Open Sans'],
			height: 120
		});
	});

	function dealsPromoType(channel, series){
		var checkboxStatus = document.getElementById('radio_'+series+'_dealstype_'+channel+'').checked;
		if(channel == 'promoid'){
			var antichannel = 'nominal';
			document.getElementById('voucher_value_'+series).readOnly = false;
		} else {
			var antichannel = 'promoid';
			document.getElementById('voucher_value_'+series).readOnly = true;
			document.getElementById('voucher_value_'+series).value = "";
		}
		document.getElementById('deals_promo_id_'+channel+'_'+series+'').style.display = 'block';
		document.getElementById('deals_promo_id_'+antichannel+'_'+series+'').style.display = 'none';
	}

	function changeNominalVoucher(series){
		var value = document.getElementById('deals_promo_id_nominal_'+series).value
		document.getElementById('voucher_value_'+series).value = value;
	}

	function dealsVoucherExpiry(channel, series){
		var checkboxStatus = document.getElementById('voucher_expiry_'+channel+'_'+series+'').checked;
		if(channel == 'bydate') var antichannel = 'duration'; else var antichannel = 'bydate';
		document.getElementById('voucher_'+channel+'_'+series+'').style.display = 'block';
		document.getElementById('voucher_'+antichannel+'_'+series+'').style.display = 'none';
	}

	function dealsVoucherType(channel, series){
		console.log(('voucher_type_'+channel+'_'+series+''));
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
					var operator_value = document.getElementById('promotion_'+type+'_id_reference_'+series);
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_product']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product']);
						}
					}
				}
			});
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			if(type=="inbox") document.getElementById(type+'_content_'+series).style.display = 'none';
		}

		if(det == 'Outlet' || det == 'Order'){
			$.ajax({
				type : "GET",
				url : "{{ url('outlet/ajax/filter') }}"+'/'+det,
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type+'_'+series).style.display = 'block';
					var operator_value = document.getElementById('promotion_'+type+'_id_reference_'+series);
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_outlet']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet']);
						}
					}
				}
			});
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			if(type=="inbox") document.getElementById(type+'_content_'+series).style.display = 'none';
		}

		else if(det == 'News'){
			$.ajax({
				type : "GET",
				url : "{{ url('news/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type+'_'+series).style.display = 'block';
					var operator_value = document.getElementById('promotion_'+type+'_id_reference_'+series);
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_news']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news']);
						}
					}
				}
			});
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			if(type=="inbox") document.getElementById(type+'_content_'+series).style.display = 'none';
		}

		else if(det == 'Link'){
			document.getElementById('atd_'+type+'_'+series).style.display = 'none';
			var operator_value = document.getElementById('promotion_'+type+'_id_reference_'+series+'');
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type+'_'+series).style.display = 'block';
			if(type=="inbox") document.getElementById(type+'_content_'+series).style.display = 'none';
		}

		else if(det == 'Content'){
			document.getElementById('atd_'+type+'_'+series).style.display = 'none';
			var operator_value = document.getElementById('promotion_'+type+'_id_reference_'+series+'');
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			document.getElementById(type+'_content_'+series).style.display = 'block';
		}

		else {
			document.getElementById('atd_'+type+'_'+series).style.display = 'none';
			var operator_value = document.getElementById('promotion_'+type+'_id_reference_'+series+'');
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type+'_'+series).style.display = 'none';
			if(type=="inbox") document.getElementById(type+'_content_'+series).style.display = 'none';
		}
	}

	$('#form').submit(function() {
		@if(count($result['contents']) > 0)
			@if($result['promotion_series'] > 0)
				@for($x = 0;$x < $result['promotion_series']; $x++)
					checked = $(".channel_{{$x}}:checked").length;
					if(checked <= 0) {
						alert("You must check at least one Promotion Channel in Campaign {{$x+1}}");
						return false;
					}
				@endfor
			@else
				checked = $(".channel_0:checked").length;
				console.log(checked);
				if(checked <= 0) {
					alert("You must check at least one Promotion Channel.");
					return false;
				}
			@endif
		@endif
		return true
    });

	//for whatsapp content
	$(document).on('change','.content-type', function(){
		var val = $(this).val();
		if(val == 'text'){
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').show()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').find('.whatsapp-content').prop('required',true);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').find('.whatsapp-content').prop('required',false);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').find('.whatsapp-content').prop('required',false);
		}else if(val == 'image'){
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').show()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').find('.whatsapp-content').prop('required',true);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').find('.whatsapp-content').prop('required',false);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').find('.whatsapp-content').prop('required',false);
		}else if(val == 'file'){
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').show()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_file').find('.whatsapp-content').prop('required',true);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_image').find('.whatsapp-content').prop('required',false);
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').hide()
			$(this).closest('.col-md-4').closest('.row').closest('.item-repeat').find('.type_text').find('.whatsapp-content').prop('required',false);
		}
	})


	$('.repeat').repeater({
        show: function () {
			$(this).find('.type_image').hide()
			$(this).find('img').attr('src','https://www.placehold.it/500x500/EFEFEF/AAAAAA&text=no+image')
			$(this).find('.filename').remove()
			$(this).find('.type_file').hide()
			$(this).find('.type_text').hide()
            $(this).slideDown();
        },
		hide: function (remove) {
			if(confirm('Are you sure you want to remove this item?')) {
				$(this).slideUp(remove);
			}
		},
		defaultValues: {
			id_whatsapp_content : null
		}
    });

	function addWhatsappContent(param, element){
		var textarea = $(element).closest('.col-md-3').closest('.row').closest('.col-md-8').find('.whatsapp-content')
		var textvalue = $(textarea).val();
		var textvaluebaru = textvalue+" "+param;
		$(textarea).val(textvaluebaru);
    }
	//end whatsapp content
	$(function(){
		$('.select-deals').change(function(){
			var obj = '<?php echo json_encode($deals); ?>'
			var dealsList = JSON.parse(obj);

			var id = $("option:selected", this).attr('data-id');
			var x = $("option:selected", this).attr('data-x');

			if ($('input[name=promotion_type]').val() == 'Campaign Series')
			{
				var x = parseInt(x) + 1;
			}

			if(dealsList[id]['deals_voucher_type'] == 'Unlimited'){
				$('#voucher_type_unlimited_'+x).prop("checked", true);
				dealsVoucherType('unlimited', x)
			}else if(dealsList[id]['deals_voucher_type'] == 'List Vouchers'){
				$('#voucher_type_listvoucher_'+x).prop("checked", true);
				dealsVoucherType('listvoucher', x)
				$('#vouchertype_listvoucher_input_'+x).val(dealsList[id]['deals_list_voucher'].replace(/,/g,'\n'));
			}else if(dealsList[id]['deals_voucher_type'] == 'Auto generated'){
				$('#voucher_type_autogenerated_'+x).prop("checked", true);
				dealsVoucherType('autogenerated', x)
				$('#vouchertype_autogenerated_input_'+x).val(dealsList[id]['deals_total_voucher']);
			}

			console.log(dealsList[id]['deals_list_outlet'].split(','))
			console.log($('#voucher_type_unlimited_'+x))
		})
	});
	</script>

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
				<div class="col-md-4 mt-step-col active">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Content</div>
					<div class="mt-step-content font-grey-cascade">Promotion Content</div>
				</div>
				<div class="col-md-4 mt-step-col last">
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
											<p class="form-control-static">Promotion will be sent:</p>
										</div>
									@if(isset($result['promotion_type']) && $result['promotion_type'] == "Instant Campaign")
										<div class="col-md-12">
											<p class="form-control-static"><b>NOW (Immidiately)</b></p>
										</div>
									@endif
									@if(isset($result['promotion_type']) && $result['promotion_type'] == "Scheduled Campaign")
										<div class="col-md-12">
											<p class="form-control-static"><b>At
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
												<p class="form-control-static"><b>Every Day at {{substr($result['schedules'][0]['schedule_time'],0,-3)}}</b></p>
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
							</div>
						</div>
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
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>

	<form role="form" action="" method="POST" id="form" enctype="multipart/form-data" class="form-horizontal">
		<div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
			<input type="hidden" name="promotion_type" value="{{$result['promotion_type']}}">
			@if($result['promotion_type'] == 'Campaign Series')
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i>Promotion Content
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
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
												<div class="row">
														Campaign no {{$x}} will be send
														<input type="text"
															class="form-control"
															required
															style="display:inline !important;width:10%"
															name="promotion_series_days[]"
															id="promotion_series_days_{{$x}}"
														@if(isset($result['contents'][$x-1]))
															value={{$result['contents'][$x-1]['promotion_series_days']}}
														@endif
														> days after previous campaign (campaign no {{$x-1}})
												</div>
											</div>
										</div>
									</div>
									@else
										<input type="hidden" required name="promotion_series_days[]" id="promotion_series_days_{{$x}}" value=0>
									@endif
									<div class="col-md-12">
										<div class="portlet light bordered">
											<div class="portlet-title">
												<div class="caption font-blue ">
													<i class="icon-settings font-blue "></i>
													<span class="caption-subject bold uppercase">Promotion Channel</span>
												</div>
											</div>
											<div class="portlet-body">
											@if(MyHelper::hasAccess([75], $configs))
												@if(!$api_key_whatsapp)
													<div class="alert alert-warning deteksi-trigger">
														<p> To use WhatsApp channel you have to set the api key in <a href="{{url('setting/whatsapp')}}">WhatsApp Setting</a>. </p>
													</div>
												@endif
											@endif
												@if(MyHelper::hasAccess([26], $configs))
													@if(isset($result['contents'][$x-1]))
														@if($result['contents'][$x-1]['promotion_count_voucher_give'] > 0)
															<div class="alert alert-warning" role="alert">
																Hidden Deals & Voucher cannot be disabled because voucher have been sent to users
															</div>
														@endif
													@endif
												@endif
												<div class="form-md-checkboxes">
													<div class="md-checkbox-inline">
														<div class="md-checkbox">
															<input type="checkbox"
																id="checkbox_{{$x}}_email"
																name="promotion_channel[{{$x-1}}][]"
																value="email"
																class="md-check channel_{{$x-1}}"
																onClick="campaignChannel('email','{{$x}}')"
															@if(isset($result['contents'][$x-1]))
																@if($result['contents'][$x-1]['promotion_channel_email'] == '1')
																	checked
																@endif
															@endif
															>
															<label for="checkbox_{{$x}}_email">
																<span></span>
																<span class="check"></span>
																<span class="box"></span>Email</label>
														</div>
														<div class="md-checkbox">
															<input type="checkbox"
																id="checkbox_{{$x}}_sms"
																name="promotion_channel[{{$x-1}}][]"
																value="sms"
																class="md-check channel_{{$x-1}}"
																onClick="campaignChannel('sms','{{$x}}')"
															@if(isset($result['contents'][$x-1]))
																@if($result['contents'][$x-1]['promotion_channel_sms'] == '1')
																	checked
																@endif
															@endif
															>
															<label for="checkbox_{{$x}}_sms">
																<span></span>
																<span class="check"></span>
																<span class="box"></span>SMS</label>
														</div>
														<div class="md-checkbox">
															<input type="checkbox"
																id="checkbox_{{$x}}_push"
																name="promotion_channel[{{$x-1}}][]"
																value="push"
																class="md-check channel_{{$x-1}}"
																onClick="campaignChannel('push','{{$x}}')"
															@if(isset($result['contents'][$x-1]))
																@if($result['contents'][$x-1]['promotion_channel_push'] == '1')
																	checked
																@endif
															@endif
															>
															<label for="checkbox_{{$x}}_push">
																<span></span>
																<span class="check"></span>
																<span class="box"></span>Push Notification</label>
														</div>
														<div class="md-checkbox">
															<input type="checkbox"
																id="checkbox_{{$x}}_inbox"
																name="promotion_channel[{{$x-1}}][]"
																value="inbox"
																class="md-check channel_{{$x-1}}"
																onClick="campaignChannel('inbox','{{$x}}')"
															@if(isset($result['contents'][$x-1]))
																@if($result['contents'][$x-1]['promotion_channel_inbox'] == '1')
																	checked
																@endif
															@endif
															>
															<label for="checkbox_{{$x}}_inbox">
																<span></span>
																<span class="check"></span>
																<span class="box"></span>Inbox</label>
														</div>
														@if(MyHelper::hasAccess([75], $configs))
														<div class="md-checkbox">
															<input type="checkbox"
																id="checkbox_{{$x}}_whatsapp"
																name="promotion_channel[{{$x-1}}][]"
																value="whatsapp"
																class="md-check channel_{{$x-1}}"
																onClick="campaignChannel('whatsapp','{{$x}}')"
															@if(isset($result['contents'][$x-1]))
																@if($result['contents'][$x-1]['promotion_channel_whatsapp'] == '1')
																	checked
																@endif
															@endif
															@if(!$api_key_whatsapp)
															disabled
															@endif
															>
															<label for="checkbox_{{$x}}_whatsapp">
																<span></span>
																<span class="check"></span>
																<span class="box"></span>WhatsApp</label>
														</div>
														@endif
														<div class="md-checkbox">
															<input type="checkbox"
																id="checkbox_{{$x}}_deals"
																name="promotion_channel[{{$x-1}}][]"
																value="deals"
																class="md-check channel_{{$x-1}}"
																onClick="campaignChannel('deals','{{$x}}')"
															@if(isset($result['contents'][$x-1]))
																@if($result['contents'][$x-1]['id_deals'] != "")
																	checked
																@endif
															@endif
															@if(isset($result['contents'][$x-1]))
																@if($result['contents'][$x-1]['promotion_count_voucher_give'] > 0)
																	disabled
																@endif
															@endif
															>

															@if(MyHelper::hasAccess([26], $configs))
															<label for="checkbox_{{$x}}_deals">
																<span></span>
																<span class="check"></span>
																<span class="box"></span>Hidden Deals & Voucher</label>
															@endif
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									@if(isset($result['contents'][$x-1]))
										@if($result['contents'][$x-1]['promotion_channel_email'] == '1')
											<div class="col-md-12" style="display:block;" id="content_email_{{$x}}">
										@else
											<div class="col-md-12" style="display:none;" id="content_email_{{$x}}">
										@endif
									@else
										<div class="col-md-12" style="display:none;" id="content_email_{{$x}}">
									@endif
										<div class="portlet light bordered">
											<div class="portlet-title">
												<div class="caption font-blue ">
													<i class="icon-settings font-blue "></i>
													<span class="caption-subject bold uppercase">Email Content</span>
												</div>
											</div>
											<div class="portlet-body">
												<div class="form-body">
													<div class="form-group" style="margin-bottom:30px">
														<label class="col-md-2 control-label">Subject</label>
														<div class="col-md-10">
															<input type="text"
																placeholder="Email Subject"
																class="form-control"
																name="promotion_email_subject[]"
																id="promotion_email_subject_{{$x}}"
																@if(isset($result['contents'][$x-1]['promotion_email_subject']))
																	value="{{$result['contents'][$x-1]['promotion_email_subject']}}"
																@endif
															>
															<br>
															You can use this variables to display user personalized information:
															<br><br>
															<div class="row">
																@foreach($textreplaces as $key=>$row)
																	<div class="col-md-3" style="margin-bottom:5px;">
																		<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('{{$x}}','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
																	</div>
																@endforeach
															</div>
															<br><br>
														</div>
													</div>
													<div class="form-group" style="margin-bottom:30px">
														<label for="multiple" class="control-label col-md-2">Content</label>
														<div class="col-md-10">
															<textarea name="promotion_email_content[]" id="promotion_email_content_{{$x}}" class="form-control summernote">@if(isset($result['contents'][$x-1]['promotion_email_content'])){{$result['contents'][$x-1]['promotion_email_content']}}@endif</textarea>
															You can use this variables to display user personalized information:
															<br><br>
															<div class="row">
																@foreach($textreplaces as $key=>$row)
																	<div class="col-md-3" style="margin-bottom:5px;">
																		<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{$x}}','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
																	</div>
																@endforeach
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									@if(isset($result['contents'][$x-1]))
										@if($result['contents'][$x-1]['promotion_channel_sms'] == '1')
											<div class="col-md-12" style="display:block;" id="content_sms_{{$x}}">
										@else
											<div class="col-md-12" style="display:none;" id="content_sms_{{$x}}">
										@endif
									@else
										<div class="col-md-12" style="display:none;" id="content_sms_{{$x}}">
									@endif
										<div class="portlet light bordered">
											<div class="portlet-title">
												<div class="caption font-blue ">
													<i class="icon-settings font-blue "></i>
													<span class="caption-subject bold uppercase">SMS Content</span>
												</div>
											</div>
											<div class="portlet-body">
												<div class="form-body">
													<div class="form-group" style="margin-bottom:30px">
														<label class="col-md-2 control-label">Content</label>
														<div class="col-md-10">
															<textarea name="promotion_sms_content[]" id="promotion_sms_content_{{$x}}" class="form-control" placeholder="SMS Content">@if(isset($result['contents'][$x-1]['promotion_sms_content'])){{$result['contents'][$x-1]['promotion_sms_content']}}@endif</textarea>
															<br>
															You can use this variables to display user personalized information:
															<br><br>
															<div class="row">
																@foreach($textreplaces as $key=>$row)
																	<div class="col-md-3" style="margin-bottom:5px;">
																		<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('{{$x}}','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
																	</div>
																@endforeach
															</div>
															<br><br>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									@if(isset($result['contents'][$x-1]))
										@if($result['contents'][$x-1]['promotion_channel_push'] == '1')
											<div class="col-md-12" style="display:block;" id="content_push_{{$x}}">
										@else
											<div class="col-md-12" style="display:none;" id="content_push_{{$x}}">
										@endif
									@else
										<div class="col-md-12" style="display:none;" id="content_push_{{$x}}">
									@endif
										<div class="portlet light bordered">
											<div class="portlet-title">
												<div class="caption font-blue ">
													<i class="icon-settings font-blue "></i>
													<span class="caption-subject bold uppercase">Push Notification Content</span>
												</div>
											</div>
											<div class="portlet-body">
												<div class="form-body">
													<div class="form-group">
														<label class="col-md-2 control-label">Subject</label>
														<div class="col-md-10">
															<input type="text"
																placeholder="Push Notification Subject"
																class="form-control"
																name="promotion_push_subject[]"
																id="promotion_push_subject_{{$x}}"
																@if(isset($result['contents'][$x-1]['promotion_push_subject']))
																	value="{{$result['contents'][$x-1]['promotion_push_subject']}}"
																@endif>
															<br>
															You can use this variables to display user personalized information:
															<br><br>
															<div class="row">
																@foreach($textreplaces as $key=>$row)
																	<div class="col-md-3" style="margin-bottom:5px;">
																		<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushSubject('{{$x}}','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
																	</div>
																@endforeach
															</div>
															<br><br>
														</div>
													</div>
													<div class="form-group">
														<label for="multiple" class="control-label col-md-2">Content</label>
														<div class="col-md-10">
															<textarea name="promotion_push_content[]" id="promotion_push_content_{{$x}}" class="form-control">@if(isset($result['contents'][$x-1]['promotion_push_content'])){{$result['contents'][$x-1]['promotion_push_content']}}@endif</textarea>
															<br>
															You can use this variables to display user personalized information:
															<br><br>
															<div class="row">
																@foreach($textreplaces as $key=>$row)
																	<div class="col-md-3" style="margin-bottom:5px;">
																		<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushContent('{{$x}}','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
																	</div>
																@endforeach
															</div>
															<br><br>
														</div>
													</div>
													<div class="form-group">
														<label for="promotion_push_image" class="control-label col-md-2">Gambar</label>
														<div class="col-md-10">
															<div class="fileinput fileinput-new" data-provides="fileinput">
																<div class="fileinput-new thumbnail" style="width: 200px; height: auto; max-height:150px; padding:0">
																	@if(isset($result['contents'][$x-1]['promotion_push_image']) && $result['contents'][$x-1]['promotion_push_image'] != "")
																		<img src="{{env('S3_URL_API')}}{{$result['contents'][$x-1]['promotion_push_image']}}" id="autocrm_push_image" style="padding:5px;max-height:150px"/>
																	@else
																		<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="autocrm_push_image" style="height:150px"/>
																	@endif
																</div>

																<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
																<div>
																	<span class="btn default btn-file">
																		<span class="fileinput-new"> Select image </span>
																		<span class="fileinput-exists"> Change </span>
																		<input type="file"  accept="image/*" name="promotion_push_image[]"> </span>
																	<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label for="promotion_push_clickto" class="control-label col-md-2">Click Action</label>
														<div class="col-md-10">
															<select name="promotion_push_clickto[]" id="promotion_push_clickto_{{$x}}" class="form-control select2" onChange="fetchDetail('{{$x}}','push',this.value)">
																<option value="Home" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Home") selected @endif>Home</option>
																<option value="News" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "New") selected @endif>News</option>
																<!--<option value="Product" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Product") selected @endif>Product</option>-->
																<option value="Order" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Order") selected @endif>Order</option>
                												<option value="History On Going" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "History On Going") selected @endif>History On Going</option>
                												<option value="History Transaksi" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "History Transaksi") selected @endif>History Transaksi</option>
                												<option value="History Point" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "History Point") selected @endif>History Point</option>
                												<option value="Outlet" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Outlet") selected @endif>Outlet</option>
                												<option value="Voucher" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Voucher") selected @endif>Voucher</option>
                												<option value="Voucher Detail" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Voucher Detail") selected @endif>Voucher Detail</option>
                												<option value="Profil" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Profil") selected @endif>Profil</option>
                												<option value="Inbox" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Inbox") selected @endif>Inbox</option>
                												<option value="About" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "About") selected @endif>About</option>
                												<option value="FAQ" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "FAQ") selected @endif>FAQ</option>
                												<option value="TOS" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "TOS") selected @endif>TOS</option>
                												<option value="Contact Us" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Contact Us") selected @endif>Contact Us</option>
                												<option value="Link" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Link") selected @endif>Link</option>
                												<option value="Logout" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Logout") selected @endif>Logout</option>
                											</select>
														</div>
													</div>
													<div class="form-group" id="atd_push_{{$x}}" style="display:none;">
														<label for="promotion_push_id_reference_{{$x}}" class="control-label col-md-2">Action to Detail</label>
														<div class="col-md-10">
															<select name="promotion_push_id_reference[]" id="promotion_push_id_reference_{{$x}}" class="form-control select2">
															</select>
														</div>
													</div>
													<div class="form-group" id="link_push_{{$x}}" @if(isset($result['contents'][$x-1]['promotion_push_clickto']) && $result['contents'][$x-1]['promotion_push_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
														<label for="promotion_push_link" class="control-label col-md-2">Link</label>
														<div class="col-md-10">
															<input type="text" placeholder="https://" class="form-control" name="promotion_push_link" id="promotion_push_link_{{$x}}" @if(isset($result['contents'][$x-1]['promotion_push_link'])) value="{{$result['contents'][$x-1]['promotion_push_link']}}" @endif>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									@if(isset($result['contents'][$x-1]))
										@if($result['contents'][$x-1]['promotion_channel_inbox'] == '1')
											<div class="col-md-12" style="display:block;" id="content_inbox_{{$x}}">
										@else
											<div class="col-md-12" style="display:none;" id="content_inbox_{{$x}}">
										@endif
									@else
										<div class="col-md-12" style="display:none;" id="content_inbox_{{$x}}">
									@endif
										<div class="portlet light bordered">
											<div class="portlet-title">
												<div class="caption font-blue ">
													<i class="icon-settings font-blue "></i>
													<span class="caption-subject bold uppercase">Inbox Content</span>
												</div>
											</div>
											<div class="portlet-body">
												<div class="form-body">
													<div class="form-group">
														<label class="col-md-2 control-label">Subject</label>
														<div class="col-md-10">
															<input type="text"
																placeholder="Inbox Subject"
																maxlength="125"
																class="form-control"
																name="promotion_inbox_subject[]"
																id="promotion_inbox_subject_{{$x}}"
																@if(isset($result['contents'][$x-1]['promotion_inbox_subject']))
																	value="{{$result['contents'][$x-1]['promotion_inbox_subject']}}"
																@endif>
															<br>
															You can use this variables to display user personalized information:
															<br><br>
															<div class="row">
																@foreach($textreplaces as $key=>$row)
																	<div class="col-md-3" style="margin-bottom:5px;">
																		<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxSubject('{{$x}}','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
																	</div>
																@endforeach
															</div>
															<br><br>
														</div>
													</div>
													<div class="form-group">
														<label for="promotion_inbox_clickto" class="control-label col-md-2">Click Action</label>
														<div class="col-md-10">
															<select name="promotion_inbox_clickto[]" id="promotion_inbox_clickto_{{$x}}" class="form-control select2" onChange="fetchDetail('{{$x}}','inbox',this.value)">
																<option value="Home" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Home") selected @endif>Home</option>
																{{-- <option value="Content" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Content") selected @endif>Content</option> --}}
																<option value="News" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "New") selected @endif>News</option>
																<!--<option value="Product" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Product") selected @endif>Product</option>-->
																<option value="Order" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Order") selected @endif>Order</option>
																<option value="History On Going" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "History On Going") selected @endif>History On Going</option>
																<option value="History Transaksi" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "History Transaksi") selected @endif>History Transaksi</option>
																<option value="History Point" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "History Point") selected @endif>History Point</option>
																<option value="Outlet" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Outlet") selected @endif>Outlet</option>
																<!--<option value="Inbox" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Inbox") selected @endif>Inbox</option>-->
																<option value="Voucher" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Voucher") selected @endif>Voucher</option>
																<option value="Voucher Detail" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Voucher Detail") selected @endif>Voucher Detail</option>
																<option value="Profil" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Profil") selected @endif>Profil</option>
																<option value="About" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "About") selected @endif>About</option>
																<option value="FAQ" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "FAQ") selected @endif>FAQ</option>
																<option value="TOS" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "TOS") selected @endif>TOS</option>
																<option value="Contact Us" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Contact Us") selected @endif>Contact Us</option>
																<option value="Link" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Link") selected @endif>Link</option>
																<option value="Logout" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Logout") selected @endif>Logout</option>

															</select>
														</div>
													</div>
													<div class="form-group" id="inbox_content_{{$x}}" style="display:none;">
														<label for="multiple" class="control-label col-md-2">Content</label>
														<div class="col-md-10">
															<textarea name="promotion_inbox_content[]" id="promotion_inbox_content_{{$x}}" class="form-control summernote">@if(isset($result['contents'][$x-1]['promotion_inbox_content'])){{$result['contents'][$x-1]['promotion_inbox_content']}}@endif</textarea>
															You can use this variables to display user personalized information:
															<br><br>
															<div class="row">
																@foreach($textreplaces as $key=>$row)
																	<div class="col-md-3" style="margin-bottom:5px;">
																		<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxContent('{{$x}}','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
																	</div>
																@endforeach
															</div>
															<br><br>
														</div>
													</div>
													<div class="form-group" id="atd_inbox_{{$x}}" style="display:none;">
														<label for="promotion_inbox_id_reference_{{$x}}" class="control-label col-md-2">Action to Detail</label>
														<div class="col-md-10">
															<select name="promotion_inbox_id_reference[]" id="promotion_inbox_id_reference_{{$x}}" class="form-control select2">
															</select>
														</div>
													</div>
													<div class="form-group" id="link_inbox_{{$x}}" @if(isset($result['contents'][$x-1]['promotion_inbox_clickto']) && $result['contents'][$x-1]['promotion_inbox_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
														<label for="promotion_inbox_link" class="control-label col-md-2">Link</label>
														<div class="col-md-10">
															<input type="text" placeholder="https://" class="form-control" name="promotion_inbox_link" id="promotion_inbox_link_{{$x}}" @if(isset($result['contents'][$x-1]['promotion_inbox_link'])) value="{{$result['contents'][$x-1]['promotion_inbox_link']}}" @endif>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									@if(MyHelper::hasAccess([75], $configs))
										@if(isset($result['contents'][$x-1]))
											@if($result['contents'][$x-1]['promotion_channel_whatsapp'] == '1')
												<div class="col-md-12" style="display:block;" id="content_whatsapp_{{$x}}">
											@else
												<div class="col-md-12" style="display:none;" id="content_whatsapp_{{$x}}">
											@endif
										@else
											<div class="col-md-12" style="display:none;" id="content_whatsapp_{{$x}}">
										@endif
											<div class="portlet light bordered">
												<div class="portlet-title">
													<div class="caption font-blue ">
														<i class="icon-settings font-blue "></i>
														<span class="caption-subject bold uppercase">WhatsApp Content</span>
													</div>
												</div>
												<div class="portlet-body">
													<div class="form-body">
														<div class="repeat">
															<div data-repeater-list="promotion_whatsapp_content[{{$x-1}}]">
																@if(isset($result['contents'][$x-1]) && count($result['contents'][$x-1]['whatsapp_content']) > 0)
																	@foreach($result['contents'][$x-1]['whatsapp_content'] as $content)
																		<div data-repeater-item="" class="item-repeat portlet light bordered" style="margin:15px">
																			<input type="hidden" name="id_whatsapp_content" value="{{$content['id_whatsapp_content']}}">
																			<div class="form-group row" style="padding:0; margin-bottom:15px">
																				<label class="col-md-2 control-label" style="text-align:right">Content Type</label>
																				<div class="col-md-4">
																					<select name="content_type" class="form-control select content-type" style="width:100%">
																						<option value="" disabled>Select Content Type</option>
																						<option value="text" @if($content['content_type'] == 'text') selected @endif>Text</option>
																						<option value="image" @if($content['content_type'] == 'image') selected @endif>Image</option>
																						<option value="file" @if($content['content_type'] == 'file') selected @endif>File PDF</option>
																					</select>
																				</div>
																				<div class="col-md-1" style="float:right">
																					<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
																						<i class="fa fa-close"></i>
																					</a>
																				</div>
																			</div>
																			<div class="form-group type_text row" @if($content['content_type'] != 'text') style="display:none" @endif>
																				<label class="col-md-2 control-label" style="text-align:right">Content</label>
																				<div class="col-md-8">
																					<textarea name="content" rows="3" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if($content['content_type'] == 'text') {{$content['content']}} @endif</textarea>
																					<br>
																					You can use this variables to display user personalized information:
																					<br><br>
																					<div class="row">
																						@foreach($textreplaces as $key=>$row)
																							<div class="col-md-3" style="margin-bottom:5px;">
																								<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}', this);">{{ str_replace('_',' ',$row['keyword']) }}</span>
																							</div>
																						@endforeach
																					</div>
																					<br><br>
																				</div>
																			</div>
																			<div class="form-group type_file row" @if($content['content_type'] != 'file') style="display:none" @endif>
																				<label class="col-md-2 control-label" style="text-align:right">Content</label>
																				<div class="col-md-9">
																					@if($content['content_type'] == 'file')
																						<div class="form-group filename" style="margin-left:0">
																						@php $file = explode('/', $content['content']) @endphp
																						<label class="control-label"><a href= "{{$content['content']}}"> <i class="fa fa-file-pdf-o"></i> {{end($file)}} </a> </label>
																						</div>
																					@endif
																					<div class="fileinput fileinput-new" data-provides="fileinput">
																						<div class="input-group input-large">
																							<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
																								<i class="fa fa-file fileinput-exists"></i>&nbsp;
																								<span class="fileinput-filename"> </span>
																							</div>
																							<span class="input-group-addon btn default btn-file">
																								<span class="fileinput-new"> Select file </span>
																								<span class="fileinput-exists"> Change </span>
																								<input type="file" class="file whatsapp-content" accept="application/pdf" name="content_file">
																								</span>
																							<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																						</div>
																					</div>
																				</div>
																			</div>
																			<div class="form-group type_image row" @if($content['content_type'] != 'image') style="display:none" @endif>
																				<label class="col-md-2 control-label" style="text-align:right">Content</label>
																				<div class="col-md-9">
																					<div class="fileinput fileinput-new" data-provides="fileinput">
																						<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
																						@if($content['content_type'] == 'image')
																							<img src="{{$content['content']}}" alt="">
																						@else
																							<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
																						@endif
																						</div>
																						<div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
																						<div>
																							<span class="btn default btn-file">
																							<span class="fileinput-new"> Select image </span>
																							<span class="fileinput-exists"> Change </span>
																							<input type="file" class="file whatsapp-content" accept="image/*" name="content">

																							</span>

																							<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	@endforeach
																@else
																	<div data-repeater-item="" class="item-repeat portlet light bordered" style="margin:15px">
																		<input type="hidden" name="id_whatsapp_content" value="">
																		<div class="form-group row" style="padding:0; margin-bottom:15px">
																			<label class="col-md-2 control-label" style="text-align:right">Content Type</label>
																			<div class="col-md-4">
																				<select name="content_type" class="form-control select content-type" style="width:100%">
																					<option value="" disabled selected>Select Content Type</option>
																					<option value="text">Text</option>
																					<option value="image">Image</option>
																					<option value="file">File PDF</option>
																				</select>
																			</div>
																			<div class="col-md-1" style="float:right">
																				<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
																					<i class="fa fa-close"></i>
																				</a>
																			</div>
																		</div>
																		<div class="form-group type_text row" style="display:none">
																			<label class="col-md-2 control-label" style="text-align:right">Content</label>
																			<div class="col-md-8">
																				<textarea name="content" rows="3" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if(isset($result['campaign_whatsapp_content']) && $result['campaign_whatsapp_content'] != ""){{$result['campaign_whatsapp_content']}}@endif</textarea>
																				<br>
																				You can use this variables to display user personalized information:
																				<br><br>
																				<div class="row">
																					@foreach($textreplaces as $key=>$row)
																						<div class="col-md-3" style="margin-bottom:5px;">
																							<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}', this);">{{ str_replace('_',' ',$row['keyword']) }}</span>
																						</div>
																					@endforeach
																				</div>
																				<br><br>
																			</div>
																		</div>
																		<div class="form-group type_file row" style="display:none">
																			<label class="col-md-2 control-label" style="text-align:right">Content</label>
																			<div class="col-md-9">
																				<div class="fileinput fileinput-new" data-provides="fileinput">
																					<div class="input-group input-large">
																						<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
																							<i class="fa fa-file fileinput-exists"></i>&nbsp;
																							<span class="fileinput-filename"> </span>
																						</div>
																						<span class="input-group-addon btn default btn-file">
																							<span class="fileinput-new"> Select file </span>
																							<span class="fileinput-exists"> Change </span>
																							<input type="file" class="file whatsapp-content" accept="application/pdf" name="content_file">
																							</span>
																						<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="form-group type_image row" style="display:none">
																			<label class="col-md-2 control-label" style="text-align:right">Content Image</label>
																			<div class="col-md-9">
																				<div class="fileinput fileinput-new" data-provides="fileinput">
																					<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
																					<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
																					</div>
																					<div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
																					<div>
																						<span class="btn default btn-file">
																						<span class="fileinput-new"> Select image </span>
																						<span class="fileinput-exists"> Change </span>
																						<input type="file" class="file whatsapp-content" accept="image/*" name="content">

																						</span>

																						<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																@endif
															</div>
															<hr>
															<label class="col-md-2 control-label" style="text-align:right"></label>
															<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
																<i class="fa fa-plus"></i> Add Content</a>
															<br>
															<br>
														</div>
													</div>
												</div>
											</div>
										</div>
									@endif

									@if(isset($result['contents'][$x-1]))
										@if($result['contents'][$x-1]['id_deals'] != '')
											<div class="col-md-12" style="display:block;" id="content_deals_{{$x}}">
										@else
											<div class="col-md-12" style="display:none;" id="content_deals_{{$x}}">
										@endif
									@else
										<div class="col-md-12" style="display:none;" id="content_deals_{{$x}}">
									@endif
										<div class="portlet light bordered">
											<div class="portlet-title">
												<div class="caption font-blue ">
													<i class="icon-settings font-blue "></i>
													<span class="caption-subject bold uppercase">Deals Setting</span>
													@if($result['contents'][$x-1]['promotion_count_voucher_give'] > 0)
													<input type="hidden" name="id_deals_promotion_template[{{$x-1}}]" value="{{$result['contents'][$x-1]['id_deals_promotion_template']??''}}">
													<input type="hidden" name="promotion_channel[{{$x-1}}][]" value="deals">
													@endif
												</div>
											</div>
											<div class="portlet-body">
												<div class="form-body">
													<div class="form-group">
														<label class="col-md-2 control-label"> Select Deals <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-7">
															<div class="input-icon right">
																<select class="form-control select2 select-deals" data-placeholder="Select Deals" name="id_deals_promotion_template[{{$x-1}}]" 
																@if($result['contents'][$x-1]['promotion_count_voucher_give'] > 0)
																	disabled 
																@endif
																>
																<optgroup label="Deals List">
																	<option value="" disabled>Select Deals</option>
																	@if (!empty($deals))
																		@foreach($deals as $index=>$datadeals)
																			<option value="{{ $datadeals['id_deals_promotion_template'] }}" data-id="{{$index}}" data-x="{{$x-1}}"
																			@if ($datadeals['id_deals_promotion_template'] == ($result['contents'][$x-1]['id_deals_promotion_template']??false))
																				selected 
																			@endif
																			>{{ $datadeals['deals_title'] }} - @if($datadeals['deals_promo_id']){{ $datadeals['deals_promo_id'] }}@else {{ number_format($datadeals['deals_nominal']) }} @endif</option>
																		@endforeach
																	@endif
																</optgroup>
																</select>
															</div>
														</div>
													</div>

												<!-- <div class="form-group">
														<label class="col-md-2 control-label">Promo Type</label>
														<div class="col-md-10">
															<div class="input-icon right">
																<div class="col-md-3">
																	<div class="md-radio-inline">
																		<div class="md-radio">
																			<input type="radio" id="radio_{{$x}}_dealstype_promoid"  name="deals_promo_id_type[{{$x-1}}]" class="md-radiobtn" onClick="dealsPromoType('promoid','{{$x}}')" value="promoid"
																			@if(isset($result['contents'][$x-1]['deals']['id_deals']))
																				@if($result['contents'][$x-1]['deals']['deals_promo_id_type'] == 'promoid')
																					checked
																				@endif
																			@endif
																			>
																			<label for="radio_{{$x}}_dealstype_promoid">
																				<span></span>
																				<span class="check"></span>
																				<span class="box"></span> Promo ID </label>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="md-radio-inline">
																		<div class="md-radio">
																			<input type="radio" id="radio_{{$x}}_dealstype_nominal" name="deals_promo_id_type[{{$x-1}}]" class="md-radiobtn" onClick="dealsPromoType('nominal','{{$x}}')" value="nominal"
																			@if(isset($result['contents'][$x-1]['deals']['id_deals']))
																				@if($result['contents'][$x-1]['deals']['deals_promo_id_type'] == 'nominal')
																					checked
																				@endif
																			@endif
																			>
																			<label for="radio_{{$x}}_dealstype_nominal">
																				<span></span>
																				<span class="check"></span>
																				<span class="box"></span> Nominal </label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-2 control-label"></label>
														<div class="col-md-10">
															@if(isset($result['contents'][$x-1]['deals']['deals_promo_id_type']))
																@if($result['contents'][$x-1]['deals']['deals_promo_id_type'] == 'promoid')
																	<input type="text" class="form-control" name="deals_promo_id[]" id="deals_promo_id_promoid_{{$x}}" style="display:block;" value="{{$result['contents'][$x-1]['deals']['deals_promo_id']}}" placeholder="Input Promo ID">

																	<input type="text" class="form-control price" name="deals_nominal[]" id="deals_promo_id_nominal_{{$x}}" style="display:none;" value="" placeholder="Input Promo nominal" onchange="changeNominalVoucher('{{$x}}')">
																@elseif($result['contents'][$x-1]['deals']['deals_promo_id_type'] == 'nominal')
																	<input type="text" class="form-control" name="deals_promo_id[]" id="deals_promo_id_promoid_{{$x}}" style="display:none;" value="" placeholder="Input Promo ID">

																	<input type="text" class="form-control price" name="deals_nominal[]" id="deals_promo_id_nominal_{{$x}}" style="display:block;" value="{{$result['contents'][$x-1]['deals']['deals_promo_id']}}" placeholder="Input Promo nominal" onchange="changeNominalVoucher('{{$x}}')">
																@endif
															@else
																<input type="text" class="form-control" name="deals_promo_id[]" id="deals_promo_id_promoid_{{$x}}" style="display:none;" value="" placeholder="Input Promo ID">

																<input type="text" class="form-control price" name="deals_nominal[]" id="deals_promo_id_nominal_{{$x}}" style="display:none;" value="" placeholder="Input Promo nominal" onchange="changeNominalVoucher('{{$x}}')">
															@endif
														</div>
													</div>
												-->

													<div class="form-group">
														<label class="col-md-2 control-label">Nominal Voucher<span class="required" aria-required="true"> * </span></label>
														<div class="col-md-9">
															<div class="input-icon right">
					                                			<div class="input-group col-md-4">
																	<input type="text" class="form-control price" name="voucher_value[]" id="voucher_value_{{$x}}" style="display:block;" value="@if(isset($result['contents'][$x-1]['voucher_value'])) {{$result['contents'][$x-1]['voucher_value']}} @endif" @if(isset($result['contents'][$x-1]['deals']['deals_promo_id_type']) && $result['contents'][$x-1]['deals']['deals_promo_id_type'] == 'nominal') readonly @endif>
																</div>
															</div>
														</div>
													</div>

												<!--
													<div class="form-group">
														<label class="col-md-2 control-label"> Deals Periode </label>
														<div class="col-md-4">
															<div class="input-icon right">
																<div class="input-group">
																	<input type="text" class="form_datetime form-control" name="deals_start[]" id="deals_start_{{$x}}"
																	@if(isset($result['contents'][$x-1]['deals']['deals_start']))
																		@if($result['contents'][$x-1]['deals']['deals_start'] != '')
																			value = "{{date('d-M-Y H:i',strtotime($result['contents'][$x-1]['deals']['deals_start']))}}"
																		@endif
																	@endif
																	>
																	<span class="input-group-btn">
																		<button class="btn default" type="button">
																			<i class="fa fa-calendar"></i>
																		</button>
																		<button class="btn default" type="button">
																			<i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
																		</button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="input-icon right">
																<div class="input-group">
																	<input type="text" class="form_datetime form-control" name="deals_end[]" id="deals_end_{{$x}}"
																	@if(isset($result['contents'][$x-1]['deals']['deals_end']))
																		@if($result['contents'][$x-1]['deals']['deals_end'] != '')
																			value = "{{date('d-M-Y H:i',strtotime($result['contents'][$x-1]['deals']['deals_end']))}}"
																		@endif
																	@endif
																	>
																	<span class="input-group-btn">
																		<button class="btn default" type="button">
																			<i class="fa fa-calendar"></i>
																		</button>
																		<button class="btn default" type="button">
																			<i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
																		</button>
																	</span>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-2 control-label"> Outlet Available </label>
														<div class="col-md-10">
															<div class="input-icon right">
																<select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[{{$x-1}}][]" id="outlet_available_{{$x}}" multiple>
																<optgroup label="Outlet List">
																	<option value="">Select Outlet</option>
																	@if (!empty($outlets))
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
																			<option value="all" selected>All Outlets</option>
																			@foreach($outlets as $suw)
																				<option value="{{ $suw['id_outlet'] }}">{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
																			@endforeach
																		@else
																			<option value="all" @if (old('id_outlet')) @if(in_array('all', old('id_outlet'))) selected @endif @endif>All Outlets</option>
																			@foreach($outlets as $suw)
																				<option value="{{ $suw['id_outlet'] }}"
																					@if(in_array($suw['id_outlet'], $ou)) selected @endif
																				>{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
																			@endforeach
																		@endif
																	@endif
																</optgroup>
																</select>
															</div>
														</div>
													</div>
												-->
													<div class="form-group">
								                        <label class="col-md-2 control-label">Voucher Start Date</label>
								                        <div class="col-md-9">
								                            <div class="input-icon right">
								                                <div class="input-group col-md-5">
								                                    <input type="text" class="form_datetime form-control" name="deals_voucher_start[]" value="{{ ($start_date=old('deals_voucher_start',($result['contents'][$x-1]['deals']['deals_voucher_start']??false)))?date('d-M-Y H:i',strtotime($start_date)):'' }}" autocomplete="off">
								                                    <span class="input-group-btn">
								                                        <button class="btn default" type="button">
								                                            <i class="fa fa-calendar"></i>
								                                        </button>
								                                        <button class="btn default" type="button">
								                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan" data-container="body"></i>
								                                        </button>
								                                    </span>
								                                </div>
								                            </div>
								                        </div>
								                    </div>
								                    
													<div class="form-group">
														<label class="col-md-2 control-label"> Voucher Expiry <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-10">
															<div class="input-icon right">
																<div class="col-md-3">
																	<div class="md-radio-inline">
																		<div class="md-radio">
																			<input type="radio" name="duration[{{$x-1}}]" id="voucher_expiry_bydate_{{$x}}" value="dates" class="md-radiobtn" onClick="dealsVoucherExpiry('bydate','{{$x}}')"
																			@if(isset($result['contents'][$x-1]['deals']['deals_voucher_expired']))
																				@if($result['contents'][$x-1]['deals']['deals_voucher_expired'] != '')
																					checked
																				@endif
																			@endif
																			>
																			<label for="voucher_expiry_bydate_{{$x}}">
																				<span></span>
																				<span class="check"></span>
																				<span class="box"></span> By Date </label>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="md-radio-inline">
																		<div class="md-radio">
																			<input type="radio" name="duration[{{$x-1}}]" id="voucher_expiry_duration_{{$x}}" value="duration" class="md-radiobtn" onClick="dealsVoucherExpiry('duration','{{$x}}')"
																			@if(isset($result['contents'][$x-1]['deals']['deals_voucher_duration']))
																				@if($result['contents'][$x-1]['deals']['deals_voucher_duration'] != '')
																					checked
																				@endif
																			@endif
																			>
																			<label for="voucher_expiry_duration_{{$x}}">
																				<span></span>
																				<span class="check"></span>
																				<span class="box"></span> Duration (Days)</label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="form-group" style="display: block;">
														<label class="col-md-2 control-label"></label>
														<div class="col-md-10">
															@if(isset($result['contents'][$x-1]['deals']['deals_voucher_expired'])
																|| isset($result['contents'][$x-1]['deals']['deals_voucher_duration'])
															)
																@if($result['contents'][$x-1]['deals']['deals_voucher_expired'] != '')
																	<div class="input-group col-md-5" id="voucher_bydate_{{$x}}" style="display: block;">
																		<div class="input-group">
																			<input type="text" class="form_datetime form-control" name="deals_voucher_expiry_bydate[]" value="{{date('d-M-Y H:i',strtotime($result['contents'][$x-1]['deals']['deals_voucher_expired']))}}">
																			<span class="input-group-btn">
																				<button class="btn default" type="button">
																					<i class="fa fa-calendar"></i>
																				</button>
																			</span>
																		</div>
																	</div>

																	<div class="input-group col-md-3" id="voucher_duration_{{$x}}" style="display: none;">
																		<input type="number" min="1" class="form-control" name="deals_voucher_expiry_duration[]" placeholder="in day">
																	</div>
																@else
																	<div class="input-group col-md-5" id="voucher_bydate_{{$x}}" style="display: none;">
																		<div class="input-group">
																			<input type="text" class="form_datetime form-control" name="deals_voucher_expiry_bydate[]" >
																			<span class="input-group-btn">
																				<button class="btn default" type="button">
																					<i class="fa fa-calendar"></i>
																				</button>
																			</span>
																		</div>
																	</div>

																	<div class="input-group col-md-3" id="voucher_duration_{{$x}}" style="display: block;">
																		<input type="number" min="1" class="form-control" name="deals_voucher_expiry_duration[]" placeholder="in day" value="@if(isset($result['contents'][$x-1]['deals']['deals_voucher_duration'])){{$result['contents'][$x-1]['deals']['deals_voucher_duration']}}@endif">
																	</div>
																@endif
															@else
																<div class="input-group col-md-5" id="voucher_bydate_{{$x}}" style="display: none;">
																	<div class="input-group">
																		<input type="text" class="form_datetime form-control" name="deals_voucher_expiry_bydate[]" >
																		<span class="input-group-btn">
																			<button class="btn default" type="button">
																				<i class="fa fa-calendar"></i>
																			</button>
																		</span>
																	</div>
																</div>

																<div class="input-group col-md-3" id="voucher_duration_{{$x}}" style="display: none;">
																	<input type="number" min="1" class="form-control" name="deals_voucher_expiry_duration[]" placeholder="in day" value="@if(isset($result['contents'][$x-1]['deals']['deals_voucher_duration'])){{$result['contents'][$x-1]['deals']['deals_voucher_duration']}}@endif">
																</div>
															@endif
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-2 control-label"> Voucher Type <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-10">
															<div class="input-icon right">
																<div class="col-md-3">
																	<div class="md-radio-inline">
																		<div class="md-radio">
																			<input type="radio" name="deals_voucher_type[{{$x-1}}]" id="voucher_type_autogenerated_{{$x}}" value="Auto generated" onClick="dealsVoucherType('autogenerated','{{$x}}')"
																			@if(isset($result['contents'][$x-1]['deals']['deals_voucher_type']))
																				@if($result['contents'][$x-1]['deals']['deals_voucher_type'] == 'Auto generated')
																					checked
																				@endif
																			@endif
																			>
																			<label for="voucher_type_autogenerated_{{$x}}">
																				<span></span>
																				<span class="check"></span>
																				<span class="box"></span> Auto Generated </label>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="md-radio-inline">
																		<div class="md-radio">
																			<input type="radio" name="deals_voucher_type[{{$x-1}}]" id="voucher_type_listvoucher_{{$x}}" value="List Vouchers" OnClick="dealsVoucherType('listvoucher','{{$x}}')"
																			@if(isset($result['contents'][$x-1]['deals']['deals_voucher_type']))
																				@if($result['contents'][$x-1]['deals']['deals_voucher_type'] == 'List Vouchers')
																					checked
																				@endif
																			@endif
																			>
																			<label for="voucher_type_listvoucher_{{$x}}">
																				<span></span>
																				<span class="check"></span>
																				<span class="box"></span> List Voucher </label>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="md-radio-inline">
																		<div class="md-radio">
																			<input type="radio" name="deals_voucher_type[{{$x-1}}]" id="voucher_type_unlimited_{{$x}}" value="Unlimited" OnClick="dealsVoucherType('unlimited','{{$x}}')"
																			@if(isset($result['contents'][$x-1]['deals']['deals_voucher_type']))
																				@if($result['contents'][$x-1]['deals']['deals_voucher_type'] == 'Unlimited')
																					checked
																				@endif
																			@endif
																			>
																			<label for="voucher_type_unlimited_{{$x}}">
																				<span></span>
																				<span class="check"></span>
																				<span class="box"></span> Unlimited </label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													@if(isset($result['contents'][$x-1]['deals']['deals_voucher_type']))
														@if($result['contents'][$x-1]['deals']['deals_voucher_type'] == 'Auto generated')
															<div class="form-group" id="vouchertype_autogenerated_{{$x}}" style="display: block;">
																<label class="col-md-2 control-label"></label>
																<div class="col-md-10">
																	<div class="col-md-3">
																		<label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
																	</div>
																	<div class="col-md-3">
																		<input type="text" class="form-control" name="voucher_type_autogenerated[]" id="vouchertype_autogenerated_input_{{$x}}" value="{{$result['contents'][$x-1]['deals']['deals_total_voucher']}}" placeholder="Total Voucher">
																	</div>
																</div>
															</div>

															<div class="form-group" id="vouchertype_listvoucher_{{$x}}" style="display: none;">
																<label class="col-md-2 control-label"></label>
																<div class="col-md-10">
																	<div class="col-md-3">
																		<label class="control-label">Input Voucher
																			<br> <small> Separated by new line </small>
																		</label>
																	</div>
																	<div class="col-md-9">
																		<textarea name="voucher_type_listvoucher[]" id="vouchertype_listvoucher_input_{{$x}}" class="form-control" rows="10"></textarea>
																	</div>
																</div>
															</div>
														@elseif($result['contents'][$x-1]['deals']['deals_voucher_type'] == 'List Vouchers')
															<div class="form-group" id="vouchertype_autogenerated_{{$x}}" style="display: none;">
																<label class="col-md-2 control-label"></label>
																<div class="col-md-10">
																	<div class="col-md-3">
																		<label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
																	</div>
																	<div class="col-md-3">
																		<input type="text" class="form-control" name="voucher_type_autogenerated[]" id="vouchertype_autogenerated_input_{{$x}}" placeholder="Total Voucher">
																	</div>
																</div>
															</div>

															<div class="form-group" id="vouchertype_listvoucher_{{$x}}" style="display: block;">
																<label class="col-md-2 control-label"></label>
																<div class="col-md-10">
																	<div class="col-md-3">
																		<label class="control-label">Input Voucher
																			<br> <small> Separated by new line </small>
																		</label>
																	</div>
																	<div class="col-md-9">
																		<textarea name="voucher_type_listvoucher[]" id="vouchertype_listvoucher_input_{{$x}}" class="form-control" rows="10">@foreach($result['contents'][$x-1]['deals']['deals_vouchers'] as $vouchers){{$vouchers['voucher_code']}}&#13;&#10;@endforeach</textarea>
																	</div>
																</div>
															</div>
														@else
															<div class="form-group" id="vouchertype_autogenerated_{{$x}}" style="display: none;">
																<label class="col-md-2 control-label"></label>
																<div class="col-md-10">
																	<div class="col-md-3">
																		<label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
																	</div>
																	<div class="col-md-3">
																		<input type="text" class="form-control" name="voucher_type_autogenerated[]" id="vouchertype_autogenerated_input_{{$x}}" placeholder="Total Voucher">
																	</div>
																</div>
															</div>

															<div class="form-group" id="vouchertype_listvoucher_{{$x}}" style="display: none;">
																<label class="col-md-2 control-label"></label>
																<div class="col-md-10">
																	<div class="col-md-3">
																		<label class="control-label">Input Voucher
																			<br> <small> Separated by new line </small>
																		</label>
																	</div>
																	<div class="col-md-9">
																		<textarea name="voucher_type_listvoucher[]" id="vouchertype_listvoucher_input_{{$x}}" class="form-control listVoucher" rows="10"></textarea>
																	</div>
																</div>
															</div>
														@endif
													@else
														<div class="form-group" id="vouchertype_autogenerated_{{$x}}" style="display: none;">
															<label class="col-md-2 control-label"></label>
															<div class="col-md-10">
																<div class="col-md-3">
																	<label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
																</div>
																<div class="col-md-3">
																	<input type="text" class="form-control" name="voucher_type_autogenerated[]" id="vouchertype_autogenerated_input_{{$x}}" placeholder="Total Voucher">
																</div>
															</div>
														</div>

														<div class="form-group" id="vouchertype_listvoucher_{{$x}}" style="display: none;">
															<label class="col-md-2 control-label"></label>
															<div class="col-md-10">
																<div class="col-md-3">
																	<label class="control-label">Input Voucher
																		<br> <small> Separated by new line </small>
																	</label>
																</div>
																<div class="col-md-9">
																	<textarea name="voucher_type_listvoucher[]" id="vouchertype_listvoucher_input_{{$x}}" class="form-control" rows="10"></textarea>
																</div>
															</div>
														</div>
													@endif

													<div class="form-group">
														<label class="col-md-2 control-label">Every user receives<span class="required" aria-required="true"> * </span></label>
														<div class="col-md-3">
															<div class="input-group">
																<input type="text" class="form-control price" name="voucher_given[{{$x-1}}]" id="voucher_given_{{$x}}" value="@if(isset($result['contents'][$x-1]['voucher_given'])){{$result['contents'][$x-1]['voucher_given']}}@endif">
																<span class="input-group-addon">
																	vouchers
																</span>
															</div>
														</div>
													</div>

													@if ($x-1 === 0)
														<div class="form-group">
															<label class="col-md-2 control-label"> Send when Deals Expired <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-10">
																<div class="input-icon right">
																	<div class="col-md-3">
																		<div class="md-radio-inline">
																			<div class="md-radio">
																				<input type="radio" name="send_deals_expired[{{$x-1}}]" id="send_deals_expired_yes{{$x}}" value="1"
																				@if(isset($result['contents'][$x-1]['send_deals_expired']))
																					@if($result['contents'][$x-1]['send_deals_expired'] == '1')
																						checked
																					@endif
																				@endif
																				>
																				<label for="send_deals_expired_yes{{$x}}">
																					<span></span>
																					<span class="check"></span>
																					<span class="box"></span> Yes </label>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="md-radio-inline">
																			<div class="md-radio">
																				<input type="radio" name="send_deals_expired[{{$x-1}}]" id="send_deals_expired_no{{$x}}" value="0" 
																				@if(isset($result['contents'][$x-1]['send_deals_expired']))
																					@if($result['contents'][$x-1]['send_deals_expired'] == '0')
																						checked
																					@endif
																				@endif
																				>
																				<label for="send_deals_expired_no{{$x}}">
																					<span></span>
																					<span class="check"></span>
																					<span class="box"></span> No </label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													@endif

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
								@endfor
							</div>
						</div>

					</div>
				</div>
			</div>
			@else
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i>Promotion Content
					</div>
				</div>
				@if(isset($result['contents'][0]))
					<input type="hidden" name="id_promotion_content" value="{{$result['contents'][0]['id_promotion_content']}}">
				@endif
				@if(isset($result['contents'][0]['id_deals']))
					<input type="hidden" name="id_deals[]" value="{{$result['contents'][0]['id_deals']}}">
				@endif
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Promotion Channel</span>
									</div>
								</div>
								@if(MyHelper::hasAccess([75], $configs))
								@if(!$api_key_whatsapp)
									<div class="alert alert-warning deteksi-trigger">
										<p> To use WhatsApp channel you have to set the api key in <a href="{{url('setting/whatsapp')}}">WhatsApp Setting</a>. </p>
									</div>
								@endif
								@endif
								@if(MyHelper::hasAccess([26], $configs))
									@if(isset($result['contents'][0]))
										@if($result['contents'][0]['promotion_count_voucher_give'] > 0)
											<div class="alert alert-warning" role="alert">
												Hidden Deals & Voucher cannot be disabled because voucher have been sent to users
											</div>
										@endif
									@else
									@if(count($deals) <= 0)
											<div class="alert alert-warning" role="alert">
												<p> To use Hidden Deals & Voucher you have to create deals promotion first in <a href="{{url('promotion/deals/create')}}">New Deals Promotion</a>. </p>
											</div>
										@endif
									@endif
								@endif
								<div class="portlet-body form">
									<div class="form-md-checkboxes">
										<div class="md-checkbox-inline">
											<div class="md-checkbox">
												<input type="checkbox"
													id="checkbox_0_email"
													name="promotion_channel[0][]"
													value="email"
													class="md-check channel_0"
													onClick="campaignChannel('email','0')"
												@if(isset($result['contents'][0]))
													@if($result['contents'][0]['promotion_channel_email'] == '1')
														checked
													@endif
												@endif
												>
												<label for="checkbox_0_email">
													<span></span>
													<span class="check"></span>
													<span class="box"></span>Email</label>
											</div>
											<div class="md-checkbox">
												<input type="checkbox"
													id="checkbox_0_sms"
													name="promotion_channel[0][]"
													value="sms"
													class="md-check channel_0"
													onClick="campaignChannel('sms','0')"
												@if(isset($result['contents'][0]))
													@if($result['contents'][0]['promotion_channel_sms'] == '1')
														checked
													@endif
												@endif
												>
												<label for="checkbox_0_sms">
													<span></span>
													<span class="check"></span>
													<span class="box"></span>SMS</label>
											</div>
											<div class="md-checkbox">
												<input type="checkbox"
													id="checkbox_0_push"
													name="promotion_channel[0][]"
													value="push"
													class="md-check channel_0"
													onClick="campaignChannel('push','0')"
												@if(isset($result['contents'][0]))
													@if($result['contents'][0]['promotion_channel_push'] == '1')
														checked
													@endif
												@endif
												>
												<label for="checkbox_0_push">
													<span></span>
													<span class="check"></span>
													<span class="box"></span>Push Notification</label>
											</div>
											<div class="md-checkbox">
												<input type="checkbox"
													id="checkbox_0_inbox"
													name="promotion_channel[0][]"
													value="inbox"
													class="md-check channel_0"
													onClick="campaignChannel('inbox','0')"
												@if(isset($result['contents'][0]))
													@if($result['contents'][0]['promotion_channel_inbox'] == '1')
														checked
													@endif
												@endif
												>
												<label for="checkbox_0_inbox">
													<span></span>
													<span class="check"></span>
													<span class="box"></span>Inbox</label>
											</div>
											@if(MyHelper::hasAccess([75], $configs))
											<div class="md-checkbox">
												<input type="checkbox"
													id="checkbox_0_whatsapp"
													name="promotion_channel[0][]"
													value="inbox"
													class="md-check channel_0"
													onClick="campaignChannel('whatsapp','0')"
												@if(isset($result['contents'][0]))
													@if($result['contents'][0]['promotion_channel_whatsapp'] == '1')
														checked
													@endif
												@endif
												@if(!$api_key_whatsapp)
												disabled
												@endif
												>
												<label for="checkbox_0_whatsapp">
													<span></span>
													<span class="check"></span>
													<span class="box"></span>WhatsApp</label>
											</div>
											@endif
											<div class="md-checkbox">
												<input type="checkbox"
													id="checkbox_0_deals"
													name="promotion_channel[0][]"
													value="deals"
													class="md-check channel_0"
													onClick="campaignChannel('deals','0')"
												@if(isset($result['contents'][0]))
													@if($result['contents'][0]['id_deals'] != "")
														checked
													@endif
												@endif
												@if(count($deals) <= 0)
												disabled
												@endif
												>
												@if(MyHelper::hasAccess([26], $configs))
												<label for="checkbox_0_deals">
													<span></span>
													<span class="check"></span>
													<span class="box"></span>Hidden Deals & Voucher</label>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_email'] == '1')
								<div class="col-md-12" style="display:block;" id="content_email_0">
							@else
								<div class="col-md-12" style="display:none;" id="content_email_0">
							@endif
						@else
							<div class="col-md-12" style="display:none;" id="content_email_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Email Content</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="form-body">
										<div class="form-group" style="margin-bottom:30px">
											<label class="col-md-2 control-label">Subject</label>
											<div class="col-md-10">
												<input type="text"
													placeholder="Email Subject"
													class="form-control"
													name="promotion_email_subject[]"
													id="promotion_email_subject_0"
													@if(isset($result['contents'][0]))
														@if($result['contents'][0]['promotion_email_subject'])
															value={{$result['contents'][0]['promotion_email_subject']}}
														@endif
													@endif
												>
												<br>
												You can use this variables to display user personalized information:
												<br><br>
												<div class="row">
													@foreach($textreplaces as $key=>$row)
														<div class="col-md-3" style="margin-bottom:5px;">
															<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('0','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
														</div>
													@endforeach
												</div>
												<br><br>
											</div>
										</div>
										<div class="form-group" style="margin-bottom:30px">
											<label for="multiple" class="control-label col-md-2">Content</label>
											<div class="col-md-10">
												<textarea name="promotion_email_content[]" id="promotion_email_content_0" class="form-control summernote">@if(isset($result['contents'][0]))@if($result['contents'][0]['promotion_email_content']){{$result['contents'][0]['promotion_email_content']}}@endif @endif</textarea>
												You can use this variables to display user personalized information:
												<br><br>
												<div class="row">
													@foreach($textreplaces as $key=>$row)
														<div class="col-md-3" style="margin-bottom:5px;">
															<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('0','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
														</div>
													@endforeach
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_sms'] == '1')
								<div class="col-md-12" style="display:block;" id="content_sms_0">
							@else
								<div class="col-md-12" style="display:none;" id="content_sms_0">
							@endif
						@else
							<div class="col-md-12" style="display:none;" id="content_sms_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">SMS Content</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="form-body">
										<div class="form-group" style="margin-bottom:30px">
											<label class="col-md-2 control-label">Content</label>
											<div class="col-md-10">
												<textarea name="promotion_sms_content[]" id="promotion_sms_content_0" class="form-control" placeholder="SMS Content">@if(isset($result['contents'][0])) @if($result['contents'][0]['promotion_sms_content']){{$result['contents'][0]['promotion_sms_content']}}@endif @endif</textarea>
												<br>
												You can use this variables to display user personalized information:
												<br><br>
												<div class="row">
													@foreach($textreplaces as $key=>$row)
														<div class="col-md-3" style="margin-bottom:5px;">
															<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('0','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
														</div>
													@endforeach
												</div>
												<br><br>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_push'] == '1')
								<div class="col-md-12" style="display:block;" id="content_push_0">
							@else
								<div class="col-md-12" style="display:none;" id="content_push_0">
							@endif
						@else
							<div class="col-md-12" style="display:none;" id="content_push_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Push Notification Content</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="form-body">
										<div class="form-group">
											<label class="col-md-2 control-label">Subject</label>
											<div class="col-md-10">
												<input type="text"
												placeholder="Push Notification Subject"
												class="form-control"
												name="promotion_push_subject[]"
												id="promotion_push_subject_0"
												@if(isset($result['contents'][0]))
													@if($result['contents'][0]['promotion_push_subject'])
														value={{$result['contents'][0]['promotion_push_subject']}}
													@endif
													@endif>
												<br>
												You can use this variables to display user personalized information:
												<br><br>
												<div class="row">
													@foreach($textreplaces as $key=>$row)
														<div class="col-md-3" style="margin-bottom:5px;">
															<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushSubject('0','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
														</div>
													@endforeach
												</div>
												<br><br>
											</div>
										</div>
										<div class="form-group">
											<label for="multiple" class="control-label col-md-2">Content</label>
											<div class="col-md-10">
												<textarea name="promotion_push_content[]" id="promotion_push_content_0" class="form-control">@if(isset($result['contents'][0])) @if($result['contents'][0]['promotion_push_content']){{$result['contents'][0]['promotion_push_content']}}@endif @endif</textarea>
												<br>
												You can use this variables to display user personalized information:
												<br><br>
												<div class="row">
													@foreach($textreplaces as $key=>$row)
														<div class="col-md-3" style="margin-bottom:5px;">
															<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushContent('0','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
														</div>
													@endforeach
												</div>
												<br><br>
											</div>
										</div>
										<div class="form-group">
											<label for="promotion_push_image" class="control-label col-md-2">Gambar</label>
											<div class="col-md-10">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: auto; max-height:150px; padding:0">
														@if(isset($result['contents'][0]['promotion_push_image']) && $result['contents'][0]['promotion_push_image'] != "")
															<img src="{{ env('S3_URL_API')}}/{{$result['contents'][0]['promotion_push_image']}}" id="autocrm_push_image" style="padding:5px;max-height:150px"/>
														@else
															<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="autocrm_push_image" style="height:150px"/>
														@endif
													</div>

													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new"> Select image </span>
															<span class="fileinput-exists"> Change </span>
															<input type="file"  accept="image/*" name="promotion_push_image[]"> </span>
														<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="promotion_push_clickto" class="control-label col-md-2">Click Action</label>
											<div class="col-md-10">
												<select name="promotion_push_clickto[]" id="promotion_push_clickto_0" class="form-control select2" onChange="fetchDetail('0','push',this.value)">
													<option value="Home" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Home") selected @endif>Home</option>
													<option value="News" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "New") selected @endif>News</option>
													<!-- <option value="Product" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Product") selected @endif>Product</option> -->
													<option value="Order" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Order") selected @endif>Order</option>
													<option value="History On Going" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "History On Going") selected @endif>History On Going</option>
													<option value="History Transaksi" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "History Transaksi") selected @endif>History Transaksi</option>
													<option value="History Point" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "History Point") selected @endif>History Point</option>
													<option value="Outlet" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Outlet") selected @endif>Outlet</option>
													<option value="Voucher" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Voucher") selected @endif>Voucher</option>
													<option value="Voucher Detail" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Voucher Detail") selected @endif>Voucher Detail</option>
													<option value="Profil" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Profil") selected @endif>Profil</option>
													<option value="Inbox" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Inbox") selected @endif>Inbox</option>
													<option value="About" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "About") selected @endif>About</option>
													<option value="FAQ" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "FAQ") selected @endif>FAQ</option>
													<option value="TOS" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "TOS") selected @endif>TOS</option>
													<option value="Contact Us" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Contact Us") selected @endif>Contact Us</option>
													<option value="Link" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Link") selected @endif>Link</option>
													<option value="Logout" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Logout") selected @endif>Logout</option>
												</select>
											</div>
										</div>
										<div class="form-group" id="atd_push_0" style="display:none;">
											<label for="promotion_push_id_reference_0" class="control-label col-md-2">Action to Detail</label>
											<div class="col-md-10">
												<select name="promotion_push_id_reference[]" id="promotion_push_id_reference_0" class="form-control select2">
												</select>
											</div>
										</div>
										<div class="form-group" id="link_push_0" @if(isset($result['contents'][0]['promotion_push_clickto']) && $result['contents'][0]['promotion_push_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
											<label for="promotion_push_link" class="control-label col-md-2">Link</label>
											<div class="col-md-10">
												<input type="text" placeholder="https://" class="form-control" name="promotion_push_link[]" id="promotion_push_link_0" @if(isset($result['contents'][0]['promotion_push_link'])) value="{{$result['contents'][0]['promotion_push_link']}}" @endif>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['promotion_channel_inbox'] == '1')
								<div class="col-md-12" style="display:block;" id="content_inbox_0">
							@else
								<div class="col-md-12" style="display:none;" id="content_inbox_0">
							@endif
						@else
							<div class="col-md-12" style="display:none;" id="content_inbox_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Inbox Content</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="form-body">
										<div class="form-group" style="margin-bottom:30px">
											<label class="col-md-2 control-label">Subject</label>
											<div class="col-md-10">
												<input type="text"
												placeholder="Inbox Subject"
												maxlength="125"
												class="form-control"
												name="promotion_inbox_subject[]"
												id="promotion_inbox_subject_0"
												@if(isset($result['contents'][0]))
													@if($result['contents'][0]['promotion_inbox_subject'])
														value={{$result['contents'][0]['promotion_inbox_subject']}}
													@endif
												@endif>
												<br>
												You can use this variables to display user personalized information:
												<br><br>
												<div class="row">
													@foreach($textreplaces as $key=>$row)
														<div class="col-md-3" style="margin-bottom:5px;">
															<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxSubject('0','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
														</div>
													@endforeach
												</div>
												<br><br>
											</div>
										</div>
										<div class="form-group">
											<label for="promotion_inbox_clickto" class="control-label col-md-2">Click Action</label>
											<div class="col-md-10">
												<select name="promotion_inbox_clickto[]" id="promotion_inbox_clickto_0" class="form-control select2" onChange="fetchDetail('0','inbox',this.value)">
													<option value="Home" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Home") selected @endif>Home</option>
													{{-- <option value="Content" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Content") selected @endif>Content</option> --}}
													<option value="News" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "New") selected @endif>News</option>
													<!--<option value="Product" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Product") selected @endif>Product</option>-->
													<option value="Order" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Order") selected @endif>Order</option>
													<option value="History On Going" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "History On Going") selected @endif>History On Going</option>
													<option value="History Transaksi" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "History Transaksi") selected @endif>History Transaksi</option>
													<option value="History Point" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "History Point") selected @endif>History Point</option>
													<option value="Outlet" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Outlet") selected @endif>Outlet</option>
													<!--<option value="Inbox" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Inbox") selected @endif>Inbox</option>-->
													<option value="Voucher" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Voucher") selected @endif>Voucher</option>
													<option value="Voucher Detail" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Voucher Detail") selected @endif>Voucher Detail</option>
													<option value="Profil" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Profil") selected @endif>Profil</option>
													<option value="About" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "About") selected @endif>About</option>
													<option value="FAQ" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "FAQ") selected @endif>FAQ</option>
													<option value="TOS" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "TOS") selected @endif>TOS</option>
													<option value="Contact Us" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Contact Us") selected @endif>Contact Us</option>
													<option value="Link" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Link") selected @endif>Link</option>
													<option value="Logout" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Logout") selected @endif>Logout</option>

												</select>
											</div>
										</div>
										<div class="form-group" id="inbox_content_0" style="display:none; margin-bottom:30px">
											<label for="multiple" class="control-label col-md-2">Content</label>
											<div class="col-md-10">
												<textarea name="promotion_inbox_content[]" id="promotion_inbox_content_0" class="form-control summernote">@if(isset($result['contents'][0])) @if($result['contents'][0]['promotion_inbox_content']){{$result['contents'][0]['promotion_inbox_content']}}@endif @endif</textarea>
												You can use this variables to display user personalized information:
												<br><br>
												<div class="row">
													@foreach($textreplaces as $key=>$row)
														<div class="col-md-3" style="margin-bottom:5px;">
															<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxContent('0','{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
														</div>
													@endforeach
												</div>
											</div>
										</div>
										<div class="form-group" id="atd_inbox_0" style="display:none;">
											<label for="promotion_inbox_id_reference_0" class="control-label col-md-2">Action to Detail</label>
											<div class="col-md-10">
												<select name="promotion_inbox_id_reference[]" id="promotion_inbox_id_reference_0" class="form-control select2">
												</select>
											</div>
										</div>
										<div class="form-group" id="link_inbox_0" @if(isset($result['contents'][0]['promotion_inbox_clickto']) && $result['contents'][0]['promotion_inbox_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
											<label for="promotion_inbox_link" class="control-label col-md-2">Link</label>
											<div class="col-md-10">
												<input type="text" placeholder="https://" class="form-control" name="promotion_inbox_link[]" id="promotion_inbox_link_0" @if(isset($result['contents'][0]['promotion_inbox_link'])) value="{{$result['contents'][0]['promotion_inbox_link']}}" @endif>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@if(MyHelper::hasAccess([75], $configs))
							@if(isset($result['contents'][0]))
								@if($result['contents'][0]['promotion_channel_whatsapp'] == '1')
									<div class="col-md-12" style="display:block;" id="content_whatsapp_0">
								@else
									<div class="col-md-12" style="display:none;" id="content_whatsapp_0">
								@endif
							@else
								<div class="col-md-12" style="display:none;" id="content_whatsapp_0">
							@endif
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption font-blue ">
											<i class="icon-settings font-blue "></i>
											<span class="caption-subject bold uppercase">WhatsApp Content</span>
										</div>
									</div>
									<div class="portlet-body">
										<div class="row">
											<div class="repeat">
												<div data-repeater-list="promotion_whatsapp_content[0]">
													@if(isset($result['contents'][0]) && count($result['contents'][0]['whatsapp_content']) > 0)
														@foreach($result['contents'][0]['whatsapp_content'] as $content)
															<div data-repeater-item="" class="item-repeat portlet light bordered" style="margin:15px">
																<input type="hidden" name="id_whatsapp_content" value="{{$content['id_whatsapp_content']}}">
																<div class="form-group row" style="padding:0; margin-bottom:15px">
																	<label class="col-md-2 control-label" style="text-align:right">Content Type</label>
																	<div class="col-md-4">
																		<select name="content_type" class="form-control select content-type" style="width:100%" required>
																			<option value="" disabled>Select Content Type</option>
																			<option value="text" @if($content['content_type'] == 'text') selected @endif>Text</option>
																			<option value="image" @if($content['content_type'] == 'image') selected @endif>Image</option>
																			<option value="file" @if($content['content_type'] == 'file') selected @endif>File PDF</option>
																		</select>
																	</div>
																	<div class="col-md-1" style="float:right">
																		<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
																			<i class="fa fa-close"></i>
																		</a>
																	</div>
																</div>
																<div class="form-group type_text row" @if($content['content_type'] != 'text') style="display:none" @endif>
																	<label class="col-md-2 control-label" style="text-align:right">Content</label>
																	<div class="col-md-8">
																		<textarea name="content" rows="3" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if($content['content_type'] == 'text') {{$content['content']}} @endif</textarea>
																		<br>
																		You can use this variables to display user personalized information:
																		<br><br>
																		<div class="row">
																			@foreach($textreplaces as $key=>$row)
																				<div class="col-md-3" style="margin-bottom:5px;">
																					<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}', this);">{{ str_replace('_',' ',$row['keyword']) }}</span>
																				</div>
																			@endforeach
																		</div>
																		<br><br>
																	</div>
																</div>
																<div class="form-group type_file row" @if($content['content_type'] != 'file') style="display:none" @endif>
																	<label class="col-md-2 control-label" style="text-align:right">Content</label>
																	<div class="col-md-9">
																		@if($content['content_type'] == 'file')
																			<div class="form-group filename" style="margin-left:0">
																			@php $file = explode('/', $content['content']) @endphp
																			<label class="control-label"><a href= "{{$content['content']}}"> <i class="fa fa-file-pdf-o"></i> {{end($file)}} </a> </label>
																			</div>
																		@endif
																		<div class="fileinput fileinput-new" data-provides="fileinput">
																			<div class="input-group input-large">
																				<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
																					<i class="fa fa-file fileinput-exists"></i>&nbsp;
																					<span class="fileinput-filename"> </span>
																				</div>
																				<span class="input-group-addon btn default btn-file">
																					<span class="fileinput-new"> Select file </span>
																					<span class="fileinput-exists"> Change </span>
																					<input type="file" class="file whatsapp-content" accept="application/pdf" name="content_file">
																					</span>
																				<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="form-group type_image row" @if($content['content_type'] != 'image') style="display:none" @endif>
																	<label class="col-md-2 control-label" style="text-align:right">Content</label>
																	<div class="col-md-9">
																		<div class="fileinput fileinput-new" data-provides="fileinput">
																			<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
																			@if($content['content_type'] == 'image')
																				<img src="{{$content['content']}}" alt="">
																			@else
																				<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
																			@endif
																			</div>
																			<div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
																			<div>
																				<span class="btn default btn-file">
																				<span class="fileinput-new"> Select image </span>
																				<span class="fileinput-exists"> Change </span>
																				<input type="file" class="file whatsapp-content" accept="image/*" name="content">

																				</span>

																				<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														@endforeach
													@else
														<div data-repeater-item="" class="item-repeat portlet light bordered" style="margin:15px">
															<input type="hidden" name="id_whatsapp_content" value="">
															<div class="form-group row" style="padding:0;">
																<label class="col-md-2 control-label" style="text-align:right">Content Type</label>
																<div class="col-md-4">
																	<select name="content_type" class="form-control select content-type" style="width:100%">
																		<option value="" disabled selected>Select Content Type</option>
																		<option value="text">Text</option>
																		<option value="image">Image</option>
																		<option value="file">File PDF</option>
																	</select>
																</div>
																<div class="col-md-1" style="float:right">
																	<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
																		<i class="fa fa-close"></i>
																	</a>
																</div>
															</div>
															<div class="form-group type_text row" style="display:none">
																<label class="col-md-2 control-label" style="text-align:right">Content</label>
																<div class="col-md-8">
																	<textarea name="content" rows="3" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if(isset($result['campaign_whatsapp_content']) && $result['campaign_whatsapp_content'] != ""){{$result['campaign_whatsapp_content']}}@endif</textarea>
																	<br>
																	You can use this variables to display user personalized information:
																	<br><br>
																	<div class="row">
																		@foreach($textreplaces as $key=>$row)
																			<div class="col-md-3" style="margin-bottom:5px;">
																				<span class="btn dark btn-xs btn-block btn-outline var" style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}', this);">{{ str_replace('_',' ',$row['keyword']) }}</span>
																			</div>
																		@endforeach
																	</div>
																	<br><br>
																</div>
															</div>
															<div class="form-group type_file row" style="display:none">
																<label class="col-md-2 control-label" style="text-align:right">Content</label>
																<div class="col-md-9">
																	<div class="fileinput fileinput-new" data-provides="fileinput">
																		<div class="input-group input-large">
																			<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
																				<i class="fa fa-file fileinput-exists"></i>&nbsp;
																				<span class="fileinput-filename"> </span>
																			</div>
																			<span class="input-group-addon btn default btn-file">
																				<span class="fileinput-new"> Select file </span>
																				<span class="fileinput-exists"> Change </span>
																				<input type="file" class="file whatsapp-content" accept="application/pdf" name="content_file">
																				</span>
																			<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group type_image row" style="display:none">
																<label class="col-md-2 control-label" style="text-align:right">Content Image</label>
																<div class="col-md-9">
																	<div class="fileinput fileinput-new" data-provides="fileinput">
																		<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
																		<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
																		</div>
																		<div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
																		<div>
																			<span class="btn default btn-file">
																			<span class="fileinput-new"> Select image </span>
																			<span class="fileinput-exists"> Change </span>
																			<input type="file" class="file whatsapp-content" accept="image/*" name="content">

																			</span>

																			<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													@endif
												</div>
												<hr>
												<label class="col-md-2 control-label" style="text-align:right"></label>
												<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
													<i class="fa fa-plus"></i> Add Content</a>
												<br>
												<br>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endif

						@if(isset($result['contents'][0]))
							@if($result['contents'][0]['id_deals'] != '')
								<div class="col-md-12" style="display:block;" id="content_deals_0">
							@else
								<div class="col-md-12" style="display:none;" id="content_deals_0">
							@endif
						@else
							<div class="col-md-12" style="display:none;" id="content_deals_0">
						@endif
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue ">
										<i class="icon-settings font-blue "></i>
										<span class="caption-subject bold uppercase">Deals Setting</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="form_body">
										<div class="form-group">
											<label class="col-md-2 control-label"> Select Deals <span class="required" aria-required="true"> * </span></label>
											<div class="col-md-7">
												<div class="input-icon right">
													<select class="form-control select2 select-deals" data-placeholder="Select Deals" name="id_deals_promotion_template[0]">
													<optgroup label="Deals List">
														<option value="">Select Deals</option>
														@if (!empty($deals))
															@foreach($deals as $index=>$datadeals)
																<option value="{{ $datadeals['id_deals_promotion_template'] }}"  data-id="{{$index}}" data-x="0"  @if(isset($result['contents'][0]['id_deals_promotion_template']) && $result['contents'][0]['id_deals_promotion_template'] == $datadeals['id_deals_promotion_template']) selected @endif>
																	{{ $datadeals['deals_title'] }} - @if($datadeals['deals_promo_id']){{ $datadeals['deals_promo_id'] }}@else {{ number_format($datadeals['deals_nominal']) }} @endif
																</option>
															@endforeach
														@endif
													</optgroup>
													</select>
												</div>
											</div>
										</div>
										<!-- <div class="form-group">
											<label class="col-md-2 control-label">Promo Type</label>
											<div class="col-md-10">
												<div class="input-icon right">
													<div class="col-md-3">
														<div class="md-radio-inline">
															<div class="md-radio">
																<input type="radio" id="radio_0_dealstype_promoid"  name="deals_promo_id_type[0]" class="md-radiobtn" onClick="dealsPromoType('promoid','0')" value="promoid"
																@if(isset($result['contents'][0]['deals']['id_deals']))
																	@if($result['contents'][0]['deals']['deals_promo_id_type'] == 'promoid')
																		checked
																	@endif
																@endif
																>
																<label for="radio_0_dealstype_promoid">
																	<span></span>
																	<span class="check"></span>
																	<span class="box"></span> Promo ID </label>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="md-radio-inline">
															<div class="md-radio">
																<input type="radio" id="radio_0_dealstype_nominal" name="deals_promo_id_type[0]" class="md-radiobtn" onClick="dealsPromoType('nominal','0')" value="nominal"
																@if(isset($result['contents'][0]['deals']['id_deals']))
																	@if($result['contents'][0]['deals']['deals_promo_id_type'] == 'nominal')
																		checked
																	@endif
																@endif
																>
																<label for="radio_0_dealstype_nominal">
																	<span></span>
																	<span class="check"></span>
																	<span class="box"></span> Nominal </label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label"></label>
											<div class="col-md-10">
												@if(isset($result['contents'][0]['deals']['deals_promo_id_type']))
													@if($result['contents'][0]['deals']['deals_promo_id_type'] == 'promoid')
														<input type="text" class="form-control" name="deals_promo_id[]" id="deals_promo_id_promoid_0" style="display:block;" value="{{$result['contents'][0]['deals']['deals_promo_id']}}" placeholder="Input Promo ID">

														<input type="text" class="form-control price" name="deals_nominal[]" id="deals_promo_id_nominal_0" style="display:none;" value="" placeholder="Input Promo nominal" onchange="changeNominalVoucher('0')">
													@elseif($result['contents'][0]['deals']['deals_promo_id_type'] == 'nominal')
														<input type="text" class="form-control" name="deals_promo_id[]" id="deals_promo_id_promoid_0" style="display:none;" value="" placeholder="Input Promo ID">

														<input type="text" class="form-control price" name="deals_nominal[]" id="deals_promo_id_nominal_0" style="display:block;" value="{{$result['contents'][0]['deals']['deals_promo_id']}}" placeholder="Input Promo nominal" onchange="changeNominalVoucher('0')">
													@endif
												@else
													<input type="text" class="form-control" name="deals_promo_id[]" id="deals_promo_id_promoid_0" style="display:none;" value="" placeholder="Input Promo ID">

													<input type="text" class="form-control price" name="deals_nominal[]" id="deals_promo_id_nominal_0" style="display:none;" value="" placeholder="Input Promo nominal" onchange="changeNominalVoucher('0')">
												@endif
											</div>
										</div>
									-->

										<div class="form-group">
											<label class="col-md-2 control-label">Nominal Voucher<span class="required" aria-required="true"> * </span></label>
											<div class="col-md-9">
												<div class="input-icon right">
					                                <div class="input-group col-md-4">
														<input type="text" class="form-control price" name="voucher_value[]" id="voucher_value_0" style="display:block;" value="@if(isset($result['contents'][0]['voucher_value'])){{$result['contents'][0]['voucher_value']}}@endif">
													</div>
												</div>
											</div>
										</div>

									<!--
										<div class="form-group">
											<label class="col-md-2 control-label"> Deals Periode </label>
											<div class="col-md-4">
												<div class="input-icon right">
													<div class="input-group">
														<input type="text" class="form_datetime form-control" name="deals_start[]"
														@if(isset($result['contents'][0]['deals']['deals_start']))
															@if($result['contents'][0]['deals']['deals_start'] != '')
																value = "{{date('d-M-Y H:i',strtotime($result['contents'][0]['deals']['deals_start']))}}"
															@endif
														@endif
														>
														<span class="input-group-btn">
															<button class="btn default" type="button">
																<i class="fa fa-calendar"></i>
															</button>
															<button class="btn default" type="button">
																<i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
															</button>
														</span>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="input-icon right">
													<div class="input-group">
														<input type="text" class="form_datetime form-control" name="deals_end[]"
														@if(isset($result['contents'][0]['deals']['deals_end']))
															@if($result['contents'][0]['deals']['deals_end'] != '')
																value = "{{date('d-M-Y H:i',strtotime($result['contents'][0]['deals']['deals_end']))}}"
															@endif
														@endif
														>
														<span class="input-group-btn">
															<button class="btn default" type="button">
																<i class="fa fa-calendar"></i>
															</button>
															<button class="btn default" type="button">
																<i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
															</button>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label"> Outlet Available </label>
											<div class="col-md-10">
												<div class="input-icon right">
													<select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[0][]" id="outlet_available_0" style="width:100%" multiple>
													<optgroup label="Outlet List">
														<option value="">Select Outlet</option>
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
																<option value="all" selected>All Outlets</option>
																@foreach($outlets as $suw)
																	<option value="{{ $suw['id_outlet'] }}">{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
																@endforeach
															@else
																<option value="all" @if (old('id_outlet')) @if(in_array('all', old('id_outlet'))) selected @endif @endif>All Outlets</option>
																@foreach($outlets as $suw)
																	<option value="{{ $suw['id_outlet'] }}"
																		@if(in_array($suw['id_outlet'], $ou)) selected @endif
																	>{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
																@endforeach
															@endif
														@endif
													</optgroup>
													</select>
												</div>
											</div>
										</div>-->
										<div class="form-group">
					                        <label class="col-md-2 control-label">Voucher Start Date</label>
					                        <div class="col-md-9">
					                            <div class="input-icon right">
					                                <div class="input-group col-md-4">
					                                    <input type="text" class="form_datetime form-control" name="deals_voucher_start[]" value="{{ ($start_date=old('deals_voucher_start',($result['contents'][0]['deals']['deals_voucher_start']??false)))?date('d-M-Y H:i',strtotime($start_date)):'' }}" autocomplete="off">
					                                    <span class="input-group-btn">
					                                        <button class="btn default" type="button">
					                                            <i class="fa fa-calendar"></i>
					                                        </button>
					                                        <button class="btn default" type="button">
					                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan" data-container="body"></i>
					                                        </button>
					                                    </span>
					                                </div>
					                            </div>
					                        </div>
					                    </div>

										<div class="form-group">
											<label class="col-md-2 control-label"> Voucher Expiry <span class="required" aria-required="true"> * </span> </label>
											<div class="col-md-10">
												<div class="input-icon right">
													<div class="col-md-3">
														<div class="md-radio-inline">
															<div class="md-radio">
																<input type="radio" name="duration[0]" id="voucher_expiry_bydate_0" value="dates" class="md-radiobtn" onClick="dealsVoucherExpiry('bydate','0')"
																@if(isset($result['contents'][0]['deals']['deals_voucher_expired']))
																	@if($result['contents'][0]['deals']['deals_voucher_expired'] != '')
																		checked
																	@endif
																@endif
																>
																<label for="voucher_expiry_bydate_0">
																	<span></span>
																	<span class="check"></span>
																	<span class="box"></span> By Date </label>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="md-radio-inline">
															<div class="md-radio">
																<input type="radio" name="duration[0]" id="voucher_expiry_duration_0" value="duration" class="md-radiobtn" onClick="dealsVoucherExpiry('duration','0')"
																@if(isset($result['contents'][0]['deals']['deals_voucher_duration']))
																	@if($result['contents'][0]['deals']['deals_voucher_duration'] != '')
																		checked
																	@endif
																@endif
																>
																<label for="voucher_expiry_duration_0">
																	<span></span>
																	<span class="check"></span>
																	<span class="box"></span> Duration (Days) </label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group" style="display: block;">
											<label class="col-md-2 control-label"></label>
											<div class="col-md-9">
												@if(isset($result['contents'][0]['deals']['deals_voucher_expired']) 
													|| isset($result['contents'][0]['deals']['deals_voucher_duration'])
												)
													@if($result['contents'][0]['deals']['deals_voucher_expired'] != '')
														<div class="col-md-4" id="voucher_bydate_0" style="display: block;">
															<div class="input-group">
																<input type="text" class="form_datetime form-control" name="deals_voucher_expiry_bydate[]" value="{{date('d-M-Y H:i',strtotime($result['contents'][0]['deals']['deals_voucher_expired']))}}">
																<span class="input-group-btn">
																	<button class="btn default" type="button">
																		<i class="fa fa-calendar"></i>
																	</button>
																</span>
															</div>
														</div>

														<div class="input-group col-md-2" id="voucher_duration_0" style="display: none;">
															<input type="number" min="1" class="form-control" name="deals_voucher_expiry_duration[]" placeholder="in day">
														</div>
													@else
														<div class="col-md-4" id="voucher_bydate_0" style="display: none;">
															<div class="input-group">
																<input type="text" class="form_datetime form-control" name="deals_voucher_expiry_bydate[]" >
																<span class="input-group-btn">
																	<button class="btn default" type="button">
																		<i class="fa fa-calendar"></i>
																	</button>
																</span>
															</div>
														</div>

														<div class="input-group col-md-2" id="voucher_duration_0" style="display: block;">
															<input type="number" min="1" class="form-control" name="deals_voucher_expiry_duration[]" placeholder="in day" @if(isset($result['contents'][0]['deals']['deals_voucher_duration'])) value="{{$result['contents'][0]['deals']['deals_voucher_duration']}}"@endif>
														</div>
													@endif
												@else
													<div class="col-md-4" id="voucher_bydate_0" style="display: none;">
														<div class="input-group">
															<input type="text" class="form_datetime form-control" name="deals_voucher_expiry_bydate[]" >
															<span class="input-group-btn">
																<button class="btn default" type="button">
																	<i class="fa fa-calendar"></i>
																</button>
															</span>
														</div>
													</div>

													<div class="input-group col-md-2" id="voucher_duration_0" style="display: none;">
														<input type="number" min="1" class="form-control" name="deals_voucher_expiry_duration[]" placeholder="in day" @if(isset($result['contents'][0]['deals']['deals_voucher_duration']))  value="{{$result['contents'][0]['deals']['deals_voucher_duration']}}" @endif>
													</div>
												@endif
											</div>
										</div>
										<input type="hidden" name="deals_voucher_type" value="Auto generated">

										<div class="form-group">
											<label class="col-md-2 control-label"> Voucher Type <span class="required" aria-required="true"> * </span> </label>
											<div class="col-md-10">
												<div class="input-icon right">
													<div class="col-md-3">
														<div class="md-radio-inline">
															<div class="md-radio">
																<input type="radio" name="deals_voucher_type[]" id="voucher_type_autogenerated_0" value="Auto generated" onClick="dealsVoucherType('autogenerated','0')"
																@if(isset($result['contents'][0]['deals']['deals_voucher_type']))
																	@if($result['contents'][0]['deals']['deals_voucher_type'] == 'Auto generated')
																		checked
																	@endif
																@endif
																>
																<label for="voucher_type_autogenerated_0">
																	<span></span>
																	<span class="check"></span>
																	<span class="box"></span> Auto Generated </label>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="md-radio-inline">
															<div class="md-radio">
																<input type="radio" name="deals_voucher_type[]" id="voucher_type_listvoucher_0" value="List Vouchers" OnClick="dealsVoucherType('listvoucher','0')"
																@if(isset($result['contents'][0]['deals']['deals_voucher_type']))
																	@if($result['contents'][0]['deals']['deals_voucher_type'] == 'List Vouchers')
																		checked
																	@endif
																@endif
																>
																<label for="voucher_type_listvoucher_0">
																	<span></span>
																	<span class="check"></span>
																	<span class="box"></span> List Voucher </label>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="md-radio-inline">
															<div class="md-radio">
																<input type="radio" name="deals_voucher_type[]" id="voucher_type_unlimited_0" value="Unlimited" OnClick="dealsVoucherType('unlimited','0')"
																@if(isset($result['contents'][0]['deals']['deals_voucher_type']))
																	@if($result['contents'][0]['deals']['deals_voucher_type'] == 'Unlimited')
																		checked
																	@endif
																@endif
																>
																<label for="voucher_type_unlimited_0">
																	<span></span>
																	<span class="check"></span>
																	<span class="box"></span> Unlimited </label>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
										@if(isset($result['contents'][0]['deals']['deals_voucher_type']))
											@if($result['contents'][0]['deals']['deals_voucher_type'] == 'Auto generated')
												<div class="form-group" id="vouchertype_autogenerated_0" style="display: block;">
													<label class="col-md-2 control-label"></label>
													<div class="col-md-10">
														<div class="col-md-3">
															<label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
														</div>
														<div class="col-md-3">
															<input type="text" class="form-control" name="voucher_type_autogenerated[]" id="vouchertype_autogenerated_input_0" value="{{$result['contents'][0]['deals']['deals_total_voucher']}}" placeholder="Total Voucher">
														</div>
													</div>
												</div>

												<div class="form-group" id="vouchertype_listvoucher_0" style="display: none;">
													<label class="col-md-2 control-label"></label>
													<div class="col-md-10">
														<div class="col-md-3">
															<label class="control-label">Input Voucher
																<br> <small> Separated by new line </small>
															</label>
														</div>
														<div class="col-md-9">
															<textarea name="voucher_type_listvoucher[]" id="vouchertype_listvoucher_input_0" class="form-control" rows="10"></textarea>
														</div>
													</div>
												</div>
											@elseif($result['contents'][0]['deals']['deals_voucher_type'] == 'List Vouchers')
												<div class="form-group" id="vouchertype_autogenerated_0" style="display: none;">
													<label class="col-md-2 control-label"></label>
													<div class="col-md-10">
														<div class="col-md-3">
															<label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
														</div>
														<div class="col-md-3">
															<input type="text" class="form-control" name="voucher_type_autogenerated[]" id="vouchertype_autogenerated_input_0" placeholder="Total Voucher">
														</div>
													</div>
												</div>

												<div class="form-group" id="vouchertype_listvoucher_0" style="display: block;">
													<label class="col-md-2 control-label"></label>
													<div class="col-md-10">
														<div class="col-md-3">
															<label class="control-label">Input Voucher
																<br> <small> Separated by new line </small>
															</label>
														</div>
														<div class="col-md-9">
															<textarea name="voucher_type_listvoucher[]" id="vouchertype_listvoucher_input_0" class="form-control" rows="10">@foreach($result['contents'][0]['deals']['deals_vouchers'] as $vouchers){{$vouchers['voucher_code']}}&#13;&#10;@endforeach</textarea>
														</div>
													</div>
												</div>
											@else
												<div class="form-group" id="vouchertype_autogenerated_0" style="display: none;">
													<label class="col-md-2 control-label"></label>
													<div class="col-md-10">
														<div class="col-md-3">
															<label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
														</div>
														<div class="col-md-3">
															<input type="text" class="form-control" name="voucher_type_autogenerated[]" id="vouchertype_autogenerated_input_0" placeholder="Total Voucher">
														</div>
													</div>
												</div>

												<div class="form-group" id="vouchertype_listvoucher_0" style="display: none;">
													<label class="col-md-2 control-label"></label>
													<div class="col-md-10">
														<div class="col-md-3">
															<label class="control-label">Input Voucher
																<br> <small> Separated by new line </small>
															</label>
														</div>
														<div class="col-md-9">
															<textarea name="voucher_type_listvoucher[]" id="vouchertype_listvoucher_input_0" class="form-control listVoucher" rows="10"></textarea>
														</div>
													</div>
												</div>
											@endif
										@else
											<div class="form-group" id="vouchertype_autogenerated_0" style="display: none;">
												<label class="col-md-2 control-label"></label>
												<div class="col-md-10">
													<div class="col-md-3">
														<label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
													</div>
													<div class="col-md-3">
														<input type="text" class="form-control" name="voucher_type_autogenerated[]" id="vouchertype_autogenerated_input_0" placeholder="Total Voucher">
													</div>
												</div>
											</div>

											<div class="form-group" id="vouchertype_listvoucher_0" style="display: none;">
												<label class="col-md-2 control-label"></label>
												<div class="col-md-10">
													<div class="col-md-3">
														<label class="control-label">Input Voucher
															<br> <small> Separated by new line </small>
														</label>
													</div>
													<div class="col-md-9">
														<textarea name="voucher_type_listvoucher[]" id="vouchertype_listvoucher_input_0" class="form-control" rows="10"></textarea>
													</div>
												</div>
											</div>
										@endif

										<div class="form-group">
											<label class="col-md-2 control-label">Every user receives<span class="required" aria-required="true"> * </span></label>
											<div class="col-md-2">
												<div class="input-group">
													<input type="text" class="form-control price" name="voucher_given[]" id="voucher_given" value="@if(isset($result['contents'][0]['voucher_given'])){{$result['contents'][0]['voucher_given']}}@endif">
													<span class="input-group-addon">
														vouchers
													</span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label"> Send when Deals Expired <span class="required" aria-required="true"> * </span></label>
											<div class="col-md-10">
												<div class="input-icon right">
													<div class="col-md-3">
														<div class="md-radio-inline">
															<div class="md-radio">
																<input type="radio" name="send_deals_expired[0]" id="send_deals_expired_yes_0" value="1"
																@if(isset($result['contents'][0]['send_deals_expired']))
																	@if($result['contents'][0]['send_deals_expired'] == '1')
																		checked
																	@endif
																@endif
																>
																<label for="send_deals_expired_yes_0">
																	<span></span>
																	<span class="check"></span>
																	<span class="box"></span> Yes </label>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="md-radio-inline">
															<div class="md-radio">
																<input type="radio" name="send_deals_expired[0]" id="send_deals_expired_no_0" value="0" 
																@if(isset($result['contents'][0]['send_deals_expired']))
																	@if($result['contents'][0]['send_deals_expired'] == '0')
																		checked
																	@endif
																@endif
																>
																<label for="send_deals_expired_no_0">
																	<span></span>
																	<span class="check"></span>
																	<span class="box"></span> No </label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>

	@if($result['promotion_type'] == 'Instant Campaign')
	<div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-users"></i>Promotion Receipient
				</div>
			</div>
			<div class="portlet-body form scroller"  style="background-color: white;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
				<table class="table table-bordered table-hover" id="sample_1" >
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Gender</th>
							<th>City</th>
							<th>Birthday</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Gender</th>
							<th>City</th>
							<th>Birthday</th>
						</tr>
					</tfoot>
					<tbody>
						@if(isset($result['users']) && count($result['users']) > 0)
							@foreach($result['users'] as $key => $user)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$user['name']}}</td>
								<td>{{$user['phone']}}</td>
								<td>{{$user['email']}}</td>
								<td>{{$user['gender']}}</td>
								<td>{{$user['city_name']}}</td>
								<td>@if(isset($user['birthday'])){{date('d M Y', strtotime($user['birthday']))}}@endif</td>
							</tr>
							@endforeach
						@else
							<tr><td colspan="7" style="text-align:center">No User found with such conditions</td></tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@endif
	<div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
		<div class="portlet light bordered">
			<div class="form-actions">
				<div class="row">
				{{ csrf_field() }}
					<div class="col-md-offset-4 col-md-8">
						<a href="{{url('promotion/step1').'/'.$result['id_promotion']}}" class="btn default">Previous Step</a>
						@if($result['promotion_type'] == 'Instant Campaign' && isset($result['users']) && count($result['users']) > 0)
							<input hidden name="send" value="send">
							@if(MyHelper::hasAccess([112], $grantedFeature))
								<button type="submit" class="btn blue">Send Promotion</button>
							@endif
						@else
							@if(MyHelper::hasAccess([112], $grantedFeature))
								<button type="submit" class="btn blue">Next Step</button>
							@endif
						@endif

					</div>
				</div>
			</div>
		</div>
	</div>
</form>
</div>
@endsection