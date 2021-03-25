
<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};

			@if($data['autocrm_push_toogle'] == '1')
				var clickto = "{{$data['autocrm_push_clickto']}}";
				var to = "{{$data['autocrm_push_id_reference']}}";
				if(clickto != "") fetchDetail(clickto, 'push', to);
			@endif

			@if($data['autocrm_inbox_toogle'] == '1')
				var clicktoInbox = "{{$data['autocrm_inbox_clickto']}}";
				var toInbox = "{{$data['autocrm_inbox_id_reference']}}";

				if(clicktoInbox != "") fetchDetail(clicktoInbox, 'inbox', toInbox);
			@endif

        });

		function viewEmail(id){
			var subject = document.getElementById('autocrm_email_subject_'+id).value;
			var content = document.getElementById('autocrm_email_content_'+id).value;

			document.getElementById('autocrm_email_subject').value = subject;
			document.getElementById('id_autocrm_email').value = id;

			$('#autocrm_email_content').summernote('code', content);
		}

		function viewSms(id){
			var messages = document.getElementById('autocrm_sms_content_'+id).value;

			document.getElementById('autocrm_sms_content').value = messages;
			document.getElementById('id_autocrm_sms').value = id;
		}

		function viewPush(id){
			function sleep(ms) {
		  return new Promise(resolve => setTimeout(resolve, ms));
		}


			var subject 	= document.getElementById('autocrm_push_subject_'+id).value;
			var content 	= document.getElementById('autocrm_push_content_'+id).value;
			var clickto 	= document.getElementById('autocrm_push_clickto_'+id).value;
			var link 		= document.getElementById('autocrm_push_link_'+id).value;
			var idreference = document.getElementById('autocrm_push_id_reference_'+id).value;
			var image 		= document.getElementById('autocrm_push_image_'+id).value;

			document.getElementById('autocrm_push_subject').value = subject;
			document.getElementById('autocrm_push_content').value = content;
			$('#autocrm_push_clickto').val(clickto).trigger('change');

			document.getElementById('autocrm_push_link').value = link;
			document.getElementById('autocrm_push_image').src = "{{ env('S3_URL_API') }}"+image;
			document.getElementById('id_autocrm_push').value = id;
			setTimeout(function(){
				$('#autocrm_push_id_reference').val(idreference).trigger('change');
			}, 1000);

		}

		function viewInbox(id){
			var subject = document.getElementById('autocrm_inbox_subject_'+id).value;
			var content = document.getElementById('autocrm_inbox_content_'+id).value;

			document.getElementById('autocrm_inbox_subject').value = subject;
			$('#autocrm_inbox_content').summernote('code', content);
			document.getElementById('id_autocrm_inbox').value = id;
		}

		function viewForward(id){
			var forward = document.getElementById('autocrm_forward_email_'+id).value;
			var subject = document.getElementById('autocrm_forward_email_subject_'+id).value;
			var content = document.getElementById('autocrm_forward_email_content_'+id).value;

			document.getElementById('autocrm_forward_email').value = forward;
			document.getElementById('autocrm_forward_email_subject').value = subject;
			$('#autocrm_forward_email_content').summernote('code', content);
			document.getElementById('id_autocrm_forward').value = id;
		}

	function addEmailContent(param){
		var textvalue = $('#autocrm_email_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_email_content').val(textvaluebaru);
		$('#autocrm_email_content').summernote('editor.saveRange');
		$('#autocrm_email_content').summernote('editor.restoreRange');
		$('#autocrm_email_content').summernote('editor.focus');
		$('#autocrm_email_content').summernote('editor.insertText', param);
    }

    function addEmailSubject(param){
		var textvalue = $('#autocrm_email_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_email_subject').val(textvaluebaru);
    }

	function addSmsContent(param){
		var textvalue = $('#autocrm_sms_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_sms_content').val(textvaluebaru);
    }

	function addPushSubject(param){
		var textvalue = $('#autocrm_push_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_push_subject').val(textvaluebaru);
    }

	function addPushContent(param){
		var textvalue = $('#autocrm_push_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_push_content').val(textvaluebaru);
    }

	function addInboxSubject(param){
		var textvalue = $('#autocrm_inbox_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_inbox_subject').val(textvaluebaru);
    }

	function addInboxContent(param){
		var textvalue = $('#autocrm_inbox_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_inbox_content').val(textvaluebaru);
		$('#autocrm_inbox_content').summernote('editor.saveRange');
		$('#autocrm_inbox_content').summernote('editor.restoreRange');
		$('#autocrm_inbox_content').summernote('editor.focus');
		$('#autocrm_inbox_content').summernote('editor.insertText', param);
    }

	function addForwardSubject(param){
		var textvalue = $('#autocrm_forward_email_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_forward_email_subject').val(textvaluebaru);
    }

	function addForwardContent(param){
		var textvalue = $('#autocrm_forward_email_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#autocrm_forward_email_content').val(textvaluebaru);
		$('#autocrm_forward_email_content').summernote('editor.saveRange');
		$('#autocrm_forward_email_content').summernote('editor.restoreRange');
		$('#autocrm_forward_email_content').summernote('editor.focus');
		$('#autocrm_forward_email_content').summernote('editor.insertText', param);
    }

	function addWhatsappContent(param, element){
		var textarea = $(element).closest('.col-md-3').closest('.row').closest('.col-md-8').find('.whatsapp-content')
		var textvalue = $(textarea).val();
		var textvaluebaru = textvalue+" "+param;
		$(textarea).val(textvaluebaru);
    }

	function fetchDetail(det, type, idref=null){
		let token  = "{{ csrf_token() }}";

		if(det == 'Product'){
			$.ajax({
				type : "GET",
				url : "{{ url('product/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
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
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'Outlet' || det == 'Order'){
			$.ajax({
				type : "GET",
				url : "{{ url('outlet/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
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
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'News'){
			$.ajax({
				type : "GET",
				url : "{{ url('news/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
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
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'Link'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'block';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'Content'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'block';
		}

		else {
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('autocrm_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}
	}

	function visibleDiv(apa,nilai){
		if(apa == 'email'){
			if(nilai=='1'){
				document.getElementById('div_email_subject').style.display = 'block';
				document.getElementById('div_email_content').style.display = 'block';
			} else {
				document.getElementById('div_email_subject').style.display = 'none';
				document.getElementById('div_email_content').style.display = 'none';
			}
		}
		if(apa == 'sms'){
			if(nilai=='1'){
				document.getElementById('div_sms_content').style.display = 'block';
			} else {
				document.getElementById('div_sms_content').style.display = 'none';
			}
		}

		if(apa == 'push'){
			if(nilai=='1'){
				document.getElementById('div_push_subject').style.display = 'block';
				document.getElementById('div_push_content').style.display = 'block';
				document.getElementById('div_push_image').style.display = 'block';
				document.getElementById('div_push_clickto').style.display = 'block';
			} else {
				document.getElementById('div_push_subject').style.display = 'none';
				document.getElementById('div_push_content').style.display = 'none';
				document.getElementById('div_push_image').style.display = 'none';
				document.getElementById('div_push_clickto').style.display = 'none';
				document.getElementById('atd_push').style.display = 'none';
				document.getElementById('link_push').style.display = 'none';
			}
		}

		if(apa == 'inbox'){
			if(nilai=='1'){
				document.getElementById('div_inbox_subject').style.display = 'block';
				document.getElementById('div_inbox_clickto').style.display = 'block';
			} else {
				document.getElementById('div_inbox_subject').style.display = 'none';
				document.getElementById('div_inbox_content').style.display = 'none';
				document.getElementById('div_inbox_clickto').style.display = 'none';
				document.getElementById('atd_inbox').style.display = 'none';
				document.getElementById('link_inbox').style.display = 'none';
			}
		}

		if(apa == 'forward'){
			if(nilai=='1'){
				document.getElementById('div_forward_address').style.display = 'block';
				document.getElementById('div_forward_subject').style.display = 'block';
				document.getElementById('div_forward_content').style.display = 'block';
			} else {
				document.getElementById('div_forward_address').style.display = 'none';
				document.getElementById('div_forward_subject').style.display = 'none';
				document.getElementById('div_forward_content').style.display = 'none';
			}
		}

		if(apa == 'whatsapp'){
			if(nilai=='1'){
				document.getElementById('div_whatsapp_content').style.display = 'block';
				$('.field_whatsapp').prop('required', true);
			} else {
				document.getElementById('div_whatsapp_content').style.display = 'none';
				$('.field_whatsapp').prop('required', false);
			}
		}
	}

	//for change whatsapp content type
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

	// form repeater whatsapp content
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

	$(document).ready(function() {
		$('.summernote').summernote({
			placeholder: 'Auto Response',
			tabsize: 2,
			height: 120,
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
						url: "{{url('summernote/picture/delete/autoresponse')}}",
						success: function(data){
							// console.log(data);
						}
					});
				}
			}
		});
    });


 	function sendFile(file, id){
        token = "<?php echo csrf_token(); ?>";
        var data = new FormData();
        data.append('image', file);
        data.append('_token', token);
        // document.getElementById('loadingDiv').style.display = "inline";
        $.ajax({
            url : "{{url('summernote/picture/upload/autoresponse')}}",
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
		@if($title == 'Auto Response Enquiry partnership') @php $title = 'Auto Response Enquiry Karir'; @endphp @endif
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
</div><br>

@include('layouts.notifications')

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			@if($subject == 'enquiry-partnership') @php $subject = 'enquiry-karir'; @endphp @endif
			<span class="caption-subject font-dark sbold uppercase font-blue">Auto Response {{ucfirst(str_replace('-',' ',$subject))}}</span>
		</div>
	</div>
	<div class="portlet-body form">
		<form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
			<div class="form-body">
				@if ($subject != 'cron-transaction' && !($forwardOnly??false))
					@if(MyHelper::hasAccess([38], $configs))
						<h4>Email</h4>
						<div class="form-group">
							<div class="input-icon right">
								<label class="col-md-3 control-label">
								Status
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Pilih enabled untuk mengedit template email auto response ketika {{strtolower(str_replace('-',' ',$subject))}}" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<select name="autocrm_email_toogle" id="autocrm_email_toogle" class="form-control select2" id="email_toogle" onChange="visibleDiv('email',this.value)">
									<option value="0" @if($data['autocrm_email_toogle'] == 0) selected @endif>Disabled</option>
									<option value="1" @if($data['autocrm_email_toogle'] == 1) selected @endif>Enabled</option>
								</select>
							</div>
						</div>

						<div class="form-group" id="div_email_subject" @if($data['autocrm_email_toogle'] == 0) style="display:none;" @endif>
							<div class="input-icon right">
								<label class="col-md-3 control-label">
								Subject
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Diisi dengan subjek email, tambahkan text replacer bila perlu" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<input type="text" placeholder="Email Subject" class="form-control" name="autocrm_email_subject" id="autocrm_email_subject" value="{{$data['autocrm_email_subject']}}">
								<br>
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row">
									@foreach($textreplaces as $key=>$row)
										<div class="col-md-3" style="margin-bottom:5px;">
											<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
										</div>
									@endforeach
									@if (isset($custom))
										@foreach($custom as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}' with {{ $type }}{{ str_replace('%', '', $custom[$key]) }}" onClick="addEmailSubject('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
											</div>
										@endforeach
									@endif
								</div>
							</div>
						</div>
						<div class="form-group" id="div_email_content" @if($data['autocrm_email_toogle'] == 0) style="display:none;" @endif>
							@if(isset($attachment))
								<label class="col-md-3 control-label">
								Send Attachment
								<i class="fa fa-question-circle tooltips" data-original-title="Jika diaktifkan maka email akan melampirkan file" data-container="body"></i>
								</label>
								<div class="col-md-9" style="margin-bottom: 10px">
									<input type="checkbox" name="attachment_mail" class="make-switch" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" data-off-text="Inactive" value="1" @if($data['attachment_mail']) checked @endif >
								</div>
							@endif
							<div class="input-icon right">
								<label class="col-md-3 control-label">
								Content
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Diisi dengan konten email, tambahkan text replacer bila perlu" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<textarea name="autocrm_email_content" id="autocrm_email_content" class="form-control summernote"><?php echo $data['autocrm_email_content'];?></textarea>
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row" >
									@foreach($textreplaces as $key=>$row)
										<div class="col-md-3" style="margin-bottom:5px;">
											<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addEmailContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
										</div>
									@endforeach
									@if (isset($custom))
										@foreach($custom as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}' with {{ $type }}{{ str_replace('%', '', $custom[$key]) }}" onClick="addEmailContent('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
											</div>
										@endforeach
									@endif
								</div>
							</div>
						</div>
					@else
						<input hidden name="autocrm_email_toogle" value="0">
					@endif

					@if($subject != 'email-verify')
						<hr>
						@if(MyHelper::hasAccess([39], $configs))
							<h4>SMS</h4>
							<div class="form-group" >
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Status
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Pilih enabled untuk mengedit template sms auto response ketika {{strtolower(str_replace('-',' ',$subject))}}" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<select name="autocrm_sms_toogle" id="autocrm_sms_toogle" class="form-control select2" id="sms_toogle" onChange="visibleDiv('sms',this.value)">
										<option value="0" @if($data['autocrm_sms_toogle'] == 0) selected @endif>Disabled</option>
										<option value="1" @if($data['autocrm_sms_toogle'] == 1) selected @endif>Enabled</option>
									</select>

								</div>
							</div>
							<div class="form-group" id="div_sms_content" @if($data['autocrm_sms_toogle'] == 0) style="display:none;" @endif>
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Description
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Isi pesan sms, tambahkan text replacer bila perlu" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<textarea name="autocrm_sms_content" id="autocrm_sms_content" class="form-control" placeholder="SMS Content @if($subject == 'pin-sent') maximum 120 character @endif" @if($subject == 'pin-sent') maxlength="120" @endif><?php echo $data['autocrm_sms_content'];?></textarea>
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addSmsContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
										@if (isset($custom))
											@foreach($custom as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}' with {{ $type }}{{ str_replace('%', '', $custom[$key]) }}" onClick="addSmsContent('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
												</div>
											@endforeach
										@endif
									</div>
								</div>
							</div>
							<hr>
						@else
							<input hidden name="autocrm_sms_toogle" value="0">
						@endif
						@if(MyHelper::hasAccess([36], $configs))
							<h4>Push Notification</h4>
							<div class="form-group">
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Status
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Pilih enabled untuk mengedit template push notification ketika {{strtolower(str_replace('-',' ',$subject))}}" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<select name="autocrm_push_toogle" id="autocrm_push_toogle" class="form-control select2" id="push_toogle" onChange="visibleDiv('push',this.value)">
										<option value="0" @if($data['autocrm_push_toogle'] == 0) selected @endif>Disabled</option>
										<option value="1" @if($data['autocrm_push_toogle'] == 1) selected @endif>Enabled</option>
									</select>

								</div>
							</div>
							<div class="form-group" id="div_push_subject" @if($data['autocrm_push_toogle'] == 0) style="display:none;" @endif>
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Subject
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Subjek/ judul push notification, tambahkan text replacer bila perlu" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9" >
									<input type="text" placeholder="Push Notification Subject" class="form-control" name="autocrm_push_subject" id="autocrm_push_subject" value="{{$data['autocrm_push_subject']}}">
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
										@if (isset($custom))
											@foreach($custom as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}' with {{ $type }}{{ str_replace('%', '', $custom[$key]) }}" onClick="addPushSubject('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
												</div>
											@endforeach
										@endif
									</div>
									<input type="hidden" id="id_autocrm_push" name="id_autocrm">
								</div>
							</div>
							<div class="form-group" id="div_push_content" @if($data['autocrm_push_toogle'] == 0) style="display:none;" @endif>
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Content
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Konten push notification, tambahkan text replacer bila perlu" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<textarea name="autocrm_push_content" id="autocrm_push_content" class="form-control" placeholder="Push Notification Content"><?php echo $data['autocrm_push_content'];?></textarea>
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
										@if (isset($custom))
											@foreach($custom as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}' with {{ $type }}{{ str_replace('%', '', $custom[$key]) }}" onClick="addPushContent('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
												</div>
											@endforeach
										@endif
									</div>
								</div>
							</div>
							<div class="form-group" id="div_push_image" @if($data['autocrm_push_toogle'] == 0) style="display:none;" @endif>
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Gambar
									<i class="fa fa-question-circle tooltips" data-original-title="Sertakan gambar jika ada" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
											@if($data['autocrm_push_image'] == null)
											<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="autocrm_push_image" />
											@else
											<img src="{{ env('S3_URL_API')}}{{$data['autocrm_push_image']}}" id="autocrm_push_image" />
											@endif
										</div>

										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
										<div>
											<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file"  accept="image/*" name="autocrm_push_image"> </span>
											<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group" id="div_push_clickto" @if($data['autocrm_push_toogle'] == 0) style="display:none;" @endif>
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Click Action
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Action/ menu yang terbuka saat user membuka push notification" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<select name="autocrm_push_clickto" id="autocrm_push_clickto" class="form-control select2" onChange="fetchDetail(this.value, 'push')">
										@foreach($click_notification as $val)
											<option value="{{$val['value']}}" @if(isset($data['autocrm_push_clickto']) && $data['autocrm_push_clickto'] == $val['value']) selected @endif>{{$val['title']}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group" id="atd_push" style="display:none;">
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Action to Detail
									<i class="fa fa-question-circle tooltips" data-original-title="Detail action/ menu yang akan terbuka saat user membuka push notification" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<select name="autocrm_push_id_reference" id="autocrm_push_id_reference" class="form-control select2">
									</select>
								</div>
							</div>
							<div class="form-group" id="link_push" style="display:none;">
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Link
									<i class="fa fa-question-circle tooltips" data-original-title="Jika action berupa link, masukkan alamat link nya disini" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<input type="text" placeholder="https://" class="form-control" name="autocrm_push_link" value="{{$data['autocrm_push_link']}}">
								</div>
							</div>
						<hr>
						@else
							<input hidden name="autocrm_push_toogle" value="0">
						@endif
						@if(MyHelper::hasAccess([37], $configs))
							<h4>Inbox</h4>
							<div class="form-group">
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Status
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Pilih enabled untuk mengedit template inbox ketika {{strtolower(str_replace('-',' ',$subject))}}" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<select name="autocrm_inbox_toogle" id="autocrm_inbox_toogle" class="form-control select2" id="autocrm_inbox_toogle" class="form-control select2" id="inbox_toogle" onChange="visibleDiv('inbox',this.value)">
										<option value="0" @if($data['autocrm_inbox_toogle'] == 0) selected @endif>Disabled</option>
										<option value="1" @if($data['autocrm_inbox_toogle'] == 1) selected @endif>Enabled</option>
									</select>

								</div>
							</div>
							<div class="form-group" id="div_inbox_subject" @if($data['autocrm_inbox_toogle'] == 0) style="display:none;" @endif>
								<div class="input-icon right">
									<label class="col-md-3 control-label">
									Subject
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Subjek/ judul pesan inbox, tambahkan text replacer bila perlu" data-container="body"></i>
									</label>
								</div>
								<div class="col-md-9">
									<input type="text" placeholder="Inbox Subject" class="form-control" name="autocrm_inbox_subject" id="autocrm_inbox_subject" value="{{$data['autocrm_inbox_subject']}}">
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
										@if (isset($custom))
											@foreach($custom as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}' with {{ $type }}{{ str_replace('%', '', $custom[$key]) }}" onClick="addInboxSubject('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
												</div>
											@endforeach
										@endif
									</div>
									<input type="hidden" id="id_autocrm_inbox" name="id_autocrm">
								</div>
							</div>
							<div class="form-group" id="div_inbox_clickto" @if($data['autocrm_inbox_toogle'] == 0) style="display:none;" @endif>
								<label for="autocrm_inbox_clickto" class="control-label col-md-3">Click Action</label>
								<div class="col-md-9">
									<select name="autocrm_inbox_clickto" id="autocrm_inbox_clickto" class="form-control select2" onChange="fetchDetail(this.value, 'inbox')">
										@foreach($click_inbox as $val)
											<option value="{{$val['value']}}" @if(isset($data['autocrm_inbox_clickto']) && $data['autocrm_inbox_clickto'] == $val['value']) selected @endif>{{$val['title']}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group" id="atd_inbox" style="display:none;">
								<label for="autocrm_inbox_id_reference" class="control-label col-md-3">Action to Detail</label>
								<div class="col-md-9">
									<select name="autocrm_inbox_id_reference" id="autocrm_inbox_id_reference" class="form-control select2">
									</select>
								</div>
							</div>
							<div class="form-group" id="link_inbox" @if(isset($data['autocrm_inbox_clickto']) && $data['autocrm_inbox_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
								<label for="autocrm_inbox_link" class="control-label col-md-3">Link</label>
								<div class="col-md-9" >
									<input type="text" placeholder="https://" class="form-control" name="autocrm_inbox_link" id="autocrm_inbox_link" @if(isset($data['autocrm_inbox_link'])) value="{{$data['autocrm_inbox_link']}}" @endif>
								</div>
							</div>
							<div class="form-group" id="div_inbox_content" style="margin-bottom:30px; display:none">
								<label for="multiple" class="control-label col-md-3">Content</label>
								<div class="col-md-9">
									<textarea name="autocrm_inbox_content" id="autocrm_inbox_content" class="form-control summernote">@if(isset($data['autocrm_inbox_content']) && $data['autocrm_inbox_content'] != ""){{$data['autocrm_inbox_content']}}@endif</textarea>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
										@if (isset($custom))
											@foreach($custom as $key=>$row)
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}' with {{ $type }}{{ str_replace('%', '', $custom[$key]) }}" onClick="addInboxContent('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
												</div>
											@endforeach
										@endif
									</div>
								</div>
							</div>
							<hr>
						@else
							<input hidden name="autocrm_inbox_toogle" value="0">
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
									<select name="autocrm_whatsapp_toogle" id="autocrm_whatsapp_toogle" class="form-control select2 field_whatsapp" onChange="visibleDiv('whatsapp',this.value)" @if(!$api_key_whatsapp) disabled @endif>
										<option value="0" @if(old('autocrm_whatsapp_toogle') == '0') selected @else @if(isset($dataf['autocrm_whatsapp_toogle']) && $data['autocrm_whatsapp_toogle'] == "0") selected @endif @endif>Disabled</option>
										<option value="1" @if($api_key_whatsapp) @if(old('autocrm_whatsapp_toogle') == '1') selected @else @if(isset($data['autocrm_whatsapp_toogle']) && $data['autocrm_whatsapp_toogle'] == "1") selected @endif @endif @endif>Enabled</option>
									</select>
								</div>
							</div>
							@if($api_key_whatsapp)
								<div class="form-group" id="div_whatsapp_content" @if($data['autocrm_whatsapp_toogle'] == 0) style="display:none" @endif>
									<div class="repeat">
										<div data-repeater-list="whatsapp_content">
											@if(isset($data['whatsapp_content']) && count($data['whatsapp_content']) > 0)
												@foreach($data['whatsapp_content'] as $content)
													<div data-repeater-item="" class="item-repeat portlet light bordered" style="margin:15px">
														<input type="hidden" name="id_whatsapp_content" value="{{$content['id_whatsapp_content']}}">
														<div class="form-group row" style="">
															<div class="input-icon right">
																<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																	Content Type
																	<i class="fa fa-question-circle tooltips" data-original-title="Tipe konten pesan untuk media whatsapp" data-container="body"></i>
																</label>
															</div>
															<div class="col-md-4" style="padding-left:5px">
																<select name="content_type" class="form-control select content-type field_whatsapp" style="width:100%">
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
															<div class="input-icon right">
																<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																	Content
																	<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp, tambahkan text replacer bila perlu" data-container="body"></i>
																</label>
															</div>
															<div class="col-md-8" style="padding-left:5px">
																<textarea name="content" rows="3" style="white-space: normal" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if($content['content_type'] == 'text') {{$content['content']}} @endif</textarea>
																<br>
																You can use this variables to display user personalized information:
																<br><br>
																<div class="row">
																	@foreach($textreplaces as $key=>$row)
																		<div class="col-md-3" style="margin-bottom:5px;">
																			<span class="btn dark btn-xs btn-block btn-outline var"  style="white-space: normal" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addWhatsappContent('{{ $row['keyword'] }}', this);">{{ str_replace('_',' ',$row['keyword']) }}</span>
																		</div>
																	@endforeach
																</div>
															</div>
														</div>
														<div class="form-group type_file row" @if($content['content_type'] != 'file') style="display:none" @endif>
															<div class="input-icon right">
																<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																	Content File
																	<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp berupa gambar" data-container="body"></i>
																</label>
															</div>
															<div class="col-md-8" style="padding-left:5px">
																@if($content['content_type'] == 'file')
																	<div class="form-group filename">
																	@php $file = explode('/', $content['content']) @endphp
																	<label class="control-label" style="padding-left:15px"><a href= "{{$content['content']}}"> <i class="fa fa-file-pdf-o"></i> {{end($file)}} </a> </label>
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
															<div class="input-icon right">
																<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																	Content Image
																	<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp berupa gambar" data-container="body"></i>
																</label>
															</div>
															<div class="col-md-8" style="padding-left:5px">
																<div class="fileinput fileinput-new" data-provides="fileinput">
																	<div class="fileinput-new thumbnail" style="width: auto; height: auto;">
																	@if($content['content_type'] == 'image')
																		<img src="{{$content['content']}}" alt="Whatsapp content image" style="max-width: 190px; max-height:190px">
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
													<div class="form-group row">
														<div class="input-icon right">
															<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																Content Type
																<i class="fa fa-question-circle tooltips" data-original-title="Pilih salah satu tipe konten untuk whatsApp" data-container="body"></i>
															</label>
														</div>
														<div class="col-md-4" style="padding-left:5px">
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
														<div class="input-icon right">
															<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																Content
																<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp, tambahkan text replacer bila perlu" data-container="body"></i>
															</label>
														</div>
														<div class="col-md-8" style="padding-left:5px">
															<textarea name="content" rows="3" class="form-control whatsapp-content" placeholder="WhatsApp Content">@if(isset($data['campaign_whatsapp_content']) && $data['campaign_whatsapp_content'] != ""){{$data['campaign_whatsapp_content']}}@endif</textarea>
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
														</div>
													</div>
													<div class="form-group type_file row" style="display:none">
														<div class="input-icon right">
															<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																Content File
																<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp berupa file pdf" data-container="body"></i>
															</label>
														</div>
														<div class="col-md-8" style="padding-left:5px">
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
														<div class="input-icon right">
															<label for="multiple" class="control-label col-md-3" style="padding-right:25px">
																Content Image
																<i class="fa fa-question-circle tooltips" data-original-title="diisi dengan konten whatsapp berupa gambar" data-container="body"></i>
															</label>
														</div>
														<div class="col-md-8" style="padding-left:5px">
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
										<label class="col-md-3 control-label" style="margin-left:15px"></label>
										<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
											<i class="fa fa-plus"></i> Add Content</a>
										<br>
										<br>
									</div>
								</div>
							@endif
							<hr>
						@endif
					@endif
				@endif

				@if($subject != 'email-verify')
					<h4>Forward</h4>
					<div class="form-group">
						<div class="input-icon right">
							<label class="col-md-3 control-label">
								Status
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Pilih enabled untuk mengedit auto response forward ketika {{strtolower(str_replace('-',' ',$subject))}}" data-container="body"></i>
							</label>
						</div>
						<div class="col-md-9">
							<select name="autocrm_forward_toogle" id="autocrm_forward_toogle" class="form-control select2" class="form-control select2" onChange="visibleDiv('forward',this.value)">
								<option value="0" @if($data['autocrm_forward_toogle'] == 0) selected @endif>Disabled</option>
								<option value="1" @if($data['autocrm_forward_toogle'] == 1) selected @endif>Enabled</option>
							</select>

						</div>
					</div>
					<div class="form-group" id="div_forward_address" @if($data['autocrm_forward_toogle'] == 0) style="display:none;" @endif>
						<div class="input-icon right">
							<label class="col-md-3 control-label">
								Forward Address
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Masukkan alamat email tujuan forward untuk setiap auto response sistem" data-container="body"></i>
							</label>
						</div>
						<div class="col-md-9">
							<textarea name="autocrm_forward_email" id="autocrm_forward_email" class="form-control" placeholder="Forward Email Address, Example:admin1@mail.com;admin2@mail.com"><?php echo $data['autocrm_forward_email']; ?></textarea>
						</div>
					</div>
					<div class="form-group" id="div_forward_subject" @if($data['autocrm_forward_toogle'] == 0) style="display:none;" @endif>
						<div class="input-icon right">
							<label class="col-md-3 control-label">
								Subject
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Subjek pesan yang akan diforward, tambahkan text replacer bila perlu" data-container="body"></i>
							</label>
						</div>
						<div class="col-md-9">
							<input type="text" placeholder="Forward Subject" class="form-control" name="autocrm_forward_email_subject" id="autocrm_forward_email_subject" value="{{$data['autocrm_forward_email_subject']}}">
							<br>
							@if ($subject != 'cron-transaction' && !($noUser??false))
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row">
									@foreach($textreplaces as $key=>$row)
										<div class="col-md-3" style="margin-bottom:5px;">
											<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addForwardSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
										</div>
									@endforeach
									@if (isset($custom))
										@foreach($custom as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}' with {{ $type }}{{ str_replace('%', '', $custom[$key]) }}" onClick="addForwardSubject('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
											</div>
										@endforeach
									@endif
								</div>
							@endif
						</div>
					</div>
					<div class="form-group" id="div_forward_content" @if($data['autocrm_forward_toogle'] == 0) style="display:none;" @endif>
						@if(isset($attachment))
							<label class="col-md-3 control-label">
								Send Attachment
								<i class="fa fa-question-circle tooltips" data-original-title="Jika diaktifkan maka email akan melampirkan file" data-container="body"></i>
							</label>
							<div class="col-md-9" style="margin-bottom: 10px">
								<input type="checkbox" name="attachment_forward" class="make-switch" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" data-off-text="Inactive" @if($data['attachment_forward']) checked @endif >
							</div>
						@endif
						<div class="input-icon right">
							<label class="col-md-3 control-label">
								Content
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Konten pesan, tambahkan text replacer bila perlu" data-container="body"></i>
							</label>
						</div>
						<div class="col-md-9">
							<textarea name="autocrm_forward_email_content" id="autocrm_forward_email_content" class="form-control summernote"><?php echo $data['autocrm_forward_email_content']; ?></textarea>
							@if ($subject != 'cron-transaction' && !($noUser??false))
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row">
									@foreach($textreplaces as $key=>$row)
										<div class="col-md-3" style="margin-bottom:5px;">
											<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addForwardContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
										</div>
									@endforeach
									@if (isset($custom))
										@foreach($custom as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}' with {{ $type }}{{ str_replace('%', '', $custom[$key]) }}" onClick="addForwardContent('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
											</div>
										@endforeach
									@endif
								</div>
							@elseif(!($forwardOnly??false))
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row">
									<div class="col-md-3" style="margin-bottom:5px;">
										<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%table_trx%'" onClick="addForwardContent('%table_trx%');">{{ str_replace('_',' ','%table_trx%') }}</span>
									</div>
								</div>
							@endif
							@if($customNotes??false)
							<span class="help-block">{{$customNotes}}</span>
							@endif
						</div>
					</div>
				@endif

				<div class="form-actions">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-offset-5 col-md-5">
						<input type="hidden" name="id_autocrm" value="{{$data['id_autocrm']}}">
							<button type="submit" class="btn green">Update</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection