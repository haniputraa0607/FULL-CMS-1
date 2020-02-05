<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />

	<style type="text/css">
		.click-to{
			margin-top: 10px;
		}
		.modal .click-to-type .form-control,
		.modal .click-to-type .select2-container{
			display: none;
		}
		.modal .select2-selection{
			position: relative;
		}
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>
	function hapus1(value){
		swal({
		  title: "Are you sure want to delete greeting ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it",
		  closeOnConfirm: false
		},
		function(){
			document.getElementById('txtvalue1').value = value;
			frmdelete1.submit();
		});
	}
	function hapus2(value){
		swal({
		  title: "Are you sure want to delete background image ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it",
		  closeOnConfirm: false
		},
		function(){
			document.getElementById('txtvalue2').value = value;
			frmdelete2.submit();
		});
	}
	function checkUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = true;
		}
	}

	function uncheckUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = false;
		}
	}

	function addGreetingReplace(param){
		var textvalue = $('#txt_greeting').val();
		var textvaluebaru = textvalue+" "+param;
		$('#txt_greeting').val(textvaluebaru.substring(0,25));
    }

	function addGreetingReplace2(param){
		var textvalue = $('#txt_greeting_2').val();
		var textvaluebaru = textvalue+" "+param;
		$('#txt_greeting_2').val(textvaluebaru);
    }

    // banner: select click to
    $('.click-to-radio').change(function(){
        if (this.checked && this.value == 'news') {
            $('.click-to-news').show();
            $('.click-to-type').find('.select2-container').show();
            $('.click-to-url').val('');
            $('.click-to-url').hide();
        }
        else if(this.checked && this.value == 'url') {
        	$('.click-to-news').val(null).trigger('change');
        	$('.click-to-news').hide();
            $('.click-to-type').find('.select2-container').hide();
            $('.click-to-url').show();
        }
        else {
        	$('.click-to-news').val(null).trigger('change');
        	$('.click-to-news').hide();
            $('.click-to-type').find('.select2-container').hide();
            $('.click-to-url').val('');
            $('.click-to-url').hide();
        }
    });
    // banner: re-order image
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    // featured deals
    $( "#sortable2" ).sortable();
    $( "#sortable2" ).disableSelection();

    $(document).ready(function() {
    	$('#txt_greeting').on('keyup',function(){
    		$(this).val($(this).val().substring(0,25));
    	});
		/* on chrome */
    	$('#modalBanner').on('shown.bs.modal', function () {
    		$('#modalBanner .select2').select2({ dropdownParent: $("#modalBanner .modal-body") });
    	});

    	// upload & delete image on summernote
    	$('.summernote').summernote({
	        placeholder: 'Success Page Content',
	        tabsize: 2,
	        height: 180,
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
	                sendFile(files[0]);
	            },
	            onMediaDelete: function(target){
	                var name = target[0].src;
	                token = "{{ csrf_token() }}";
	                $.ajax({
	                    type: 'post',
	                    data: 'filename='+name+'&_token='+token,
	                    url: "{{url('summernote/picture/delete/user-profile')}}",
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
    });

    // upload & delete image on summernote
    function sendFile(file){
        token = "{{ csrf_token() }}";
        var data = new FormData();
        data.append('image', file);
        data.append('_token', token);
        // document.getElementById('loadingDiv').style.display = "inline";
        $.ajax({
            url : "{{url('summernote/picture/upload/user-profile')}}",
            data: data,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(url) {
                if (url['status'] == "success") {
                    $('#field_content_long').summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                }
                // document.getElementById('loadingDiv').style.display = "none";
            },
            error: function(data){
                // document.getElementById('loadingDiv').style.display = "none";
            }
        })
    }

    // banner: edit
    $('#banner .btn-edit').click(function() {
		var id      = $(this).data('id');
		var id_news = $(this).data('news');
		var url     = $(this).data('url');
		var image   = $(this).data('img');
		var type    = $(this).data('type');
		var banner_start	= $(this).data('start');
		var banner_end		= $(this).data('end');

    	$('#modalBannerUpdate').on('shown.bs.modal', function () {
			$('#id_banner').val('');
			$('#modalBannerUpdate .click-to-news').val('').trigger('change');
			$('#modalBannerUpdate .click-to-url').val('');
			$('#edit-banner-img').attr('src', '');
			// hide all click to input
			$('#modalBannerUpdate .click-to-type').children().hide();
    		// on chrome
    		$('#modalBannerUpdate .select2').select2({ dropdownParent: $("#modalBannerUpdate .modal-body") });

    		// assign value to form
    		$('#id_banner').val(id);
			$('#modalBannerUpdate .click-to-news').val(id_news).trigger('change');
			$('#modalBannerUpdate .click-to-url').val(url);
			$('#edit-banner-img').attr('src', image);
			$('#banner_start').val(banner_start);
			$('#banner_end').val(banner_end);

			if (url != "") {
				if (type == 'general') {
					$('#modalBannerUpdate .click-to-radio[value="url"]').prop("checked", true);
	            	$('.click-to-url').show();
				} else {
					$('#modalBannerUpdate .click-to-radio[value="gofood"]').prop("checked", true);
				}
			}
			else if(id_news != "") {
				$('#modalBannerUpdate .click-to-radio[value="news"]').prop("checked", true);
	            $('.click-to-type').find('.select2-container').show();
			}
			else {
				$('#modalBannerUpdate .click-to-radio[value="none"]').prop("checked", true);
			}

			// reset var
			url = "";
    	});

    });

    $('#featured_deals .btn-edit').click(function() {
		var id         = $(this).data('id');
		var end_date   = $(this).data('end-date');
		var start_date = $(this).data('start-date');
		var id_deals   = $(this).data('id-deals');
		var deals_title   = $(this).data('deals-title');

		// assign value to form
		$('#id_featured_deals').val(id);
		$('#end_date').val(end_date).datetimepicker({
	        format: "dd M yyyy hh:ii",
	        autoclose: true,
	        todayBtn: true,
	        minuteStep:1
	    });
		$('#start_date').val(start_date).datetimepicker({
	        format: "dd M yyyy hh:ii",
	        autoclose: true,
	        todayBtn: true,
	        minuteStep:1
	    });
		$('#id_deals').find('option').first().attr('value',id_deals).text(deals_title);
		$('#id_deals').select2().trigger('change');
    });

	$('.datetime').datetimepicker({
        format: "dd M yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep:1
    });

    // clear banner edit form when modal close
 //    $('#modalBannerUpdate').on('hide.bs.modal', function () {
	// 	$('#id_banner').val('');
	// 	$('#modalBannerUpdate .click-to-news').val('').trigger('change');
	// 	$('#modalBannerUpdate .click-to-url').val('');
	// 	$('#edit-banner-img').attr('src', '');
	// 	// hide all click to input
	// 	$('#modalBannerUpdate .click-to-type').children().hide();
	// });

    // banner: delete
    $('#banner .btn-delete').click(function() {
		var id 		= $(this).data('id');
		var link 	= "{{ url('setting/banner/delete') }}/" + id;
		swal({
		  title: "Are you sure want to delete banner image ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it",
		  closeOnConfirm: false
		},
		function(){
			window.location = link;
		});
    });

    // banner: delete
    $('#featured_deals .btn-delete').click(function() {
		var id 		= $(this).data('id');
		var link 	= "{{ url('setting/featured_deal/delete') }}/" + id;
		swal({
		  title: "Are you sure want to delete this featured deals ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it",
		  closeOnConfirm: false
		},
		function(){
			window.location = link;
		});
    });

	$(".file-splash").change(function(e) {
		var widthImg  = 1080;
		var heightImg = 1920;
		var widthImg2  = 540;
		var heightImg2 = 960;

		var _URL = window.URL || window.webkitURL;
		var image, file;

		if ((file = this.files[0])) {
			image = new Image();

			image.onload = function() {
				if ((this.width == widthImg && this.height == heightImg)||(this.width == widthImg2 && this.height == heightImg2)) {
					// image.src = _URL.createObjectURL(file);
				}
				else {
					toastr.warning("Please check dimension of your image.");
					$(this).val("");
					// $('#remove_square').click()
					// image.src = _URL.createObjectURL();

					$('#field_splash').val("");
					$('#div_splash').children('img').attr('src', 'https://www.placehold.it/500x250/EFEFEF/AAAAAA&amp;text=no+image');

					console.log($(this).val())
					// console.log(document.getElementsByName('news_image_luar'))
				}
			};

			image.src = _URL.createObjectURL(file);
		}

	});


	$('.nav-tabs a').on('shown.bs.tab', function(){
		var href=$(this).attr('href');
	    window.history.pushState(href, href, "{{url()->current()}}"+href);
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
			<a href="javascript:;">Setting</a>
		</li>
	</ul>
</div>
<br>
@include('layouts.notifications')
<div class="tabbable-line">
	<ul class="nav nav-tabs">
	@if(MyHelper::hasAccess([30], $configs))
		@if(MyHelper::hasAccess([31], $configs))
        <li>
            <a href="#greeting" data-toggle="tab">Greeting</a>
        </li>
		@endif
<!--         <li>
            <a href="#home-background" data-toggle="tab">Home Background</a>
        </li> -->
	@endif
        <li class="active">
            <a href="#splash-screen" data-toggle="tab">Splash Screen</a>
        </li>
		@if(MyHelper::hasAccess([144], $grantedFeature))
        <li>
            <a href="#banner" data-toggle="tab">Banner</a>
        </li>
		@endif
        <li>
            <a href="#featured_deals" data-toggle="tab">Featured Deals</a>
        </li>
        <!-- <li>
            <a href="#app-logo" data-toggle="tab">Application Logo</a>
        </li> -->
        <!-- <li>
            <a href="#app-navigation" data-toggle="tab">App Navigation Text</a>
        </li> -->
    </ul>
</div>

<div class="tab-content">
	@if(MyHelper::hasAccess([30], $configs))
	{{-- greeting --}}
        <div class="tab-pane" id="greeting">
			@if(MyHelper::hasAccess([31], $configs))

                @if(MyHelper::hasAccess([30], $configs))
			        <div style="margin:20px 0">
                    	<a class="btn blue btn-outline sbold" data-toggle="modal" href="#modalTimeSetting"> Time Setting
                    		<i class="fa fa-question-circle tooltips" data-original-title="Konfigurasi waktu dalam empat kategori, yaitu Morning, Afternoon, Evening, dan Late Night" data-container="body"></i>
                    	</a>
                    	@if(MyHelper::hasAccess([16], $grantedFeature))
                    		@if(MyHelper::hasAccess([31], $configs))
                    			<a class="btn blue btn-outline sbold" data-toggle="modal" href="#modalGreeting"> New Greeting
                    				<i class="fa fa-question-circle tooltips" data-original-title="Membuat kalimat greeting baru" data-container="body"></i>
                    			</a>
                    		@endif
                    		@if(MyHelper::hasAccess([32], $configs))
                    <!-- 			<a class="btn blue btn-outline sbold" data-toggle="modal" href="#modalBackground"> New Background
                    				<i class="fa fa-question-circle tooltips" data-original-title="Background home dapat disesuaikan dengan teks greeting" data-container="body"></i>
                    			</a> -->
                    		@endif
                    	@endif
                	</div>
                @endif

				<div class="row" style="margin-top:20px">
					<div class="col-md-12">
						<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-blue ">
									<i class="icon-settings font-blue "></i>
									<span class="caption-subject bold uppercase">List Greeting</span>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
									<thead>
										<tr>
											<th class="all" width="4%">No</th>
											<th class="all" width="20%">When to Display</th>
											<th class="all">Title</th>
<!-- 											<th class="all">Subtitle</th> -->
											@if(MyHelper::hasAccess([18], $grantedFeature))
												<th class="noExport" width="10%">Actions</th>
											@endif
										</tr>
									</thead>
									<tbody>

									@if(!empty($greetings))
										<?php $x = 1; ?>
										@foreach($greetings as $key=>$row)
										<tr>
											<td> {{ $x }} </td>
											<td> {{ str_replace('_',' ', $row['when']) }} </td>
											<td> {{ $row['greeting'] }} </td>
<!-- 											<td> || $row['greeting2'] || </td> -->
											@if(MyHelper::hasAccess([18], $grantedFeature))
												<td class="noExport">
													<a onClick="hapus1('{{$row['id_greetings']}}')" class="btn red uppercase" >Delete</a>
												</td>
											@endif
										</tr>
										<?php $x++; ?>
										@endforeach
									@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<form id="frmdelete1" method="post" action="{{URL::to('setting/greeting/delete')}}">
					{{csrf_field()}}
					<input type="hidden" name="id_greetings" id="txtvalue1">
				</form>
			@endif
		</div>

	{{-- background login/ not login --}}
<!--         <div class="tab-pane" id="home-background">
			@if(MyHelper::hasAccess([32], $configs))
				<div class="row" style="margin-top:20px">
					<div class="col-md-12">
						<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-blue ">
									<i class="icon-settings font-blue "></i>
									<span class="caption-subject bold uppercase">List Home Background</span>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
									<thead>
										<tr>
											<th class="all" width="4%">No</th>
											<th class="all" width="20%">When to Display</th>
											<th class="all">Image</th>
											@if(MyHelper::hasAccess([18], $grantedFeature))
												<th class="noExport" width="10%">Actions</th>
											@endif
										</tr>
									</thead>
									<tbody>

									@if(!empty($background))
										<?php $x = 1; ?>
										@foreach($background as $key=>$row)
										<tr>
											<td> {{ $x }} </td>
											<td> {{ str_replace('_',' ', $row['when']) }} </td>
											<td> <img src="{{ $row['picture'] }}" width="200px"> </td>
											@if(MyHelper::hasAccess([18], $grantedFeature))
												<td class="noExport">
													<a onClick="hapus2('{{$row['id_home_background']}}')" class="btn red uppercase" >Delete</a>
												</td>
											@endif
										</tr>
										<?php $x++; ?>
										@endforeach
									@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			@endif
			<div class="row" style="margin-top:20px">
				<div class="col-md-12">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue ">
								<i class="icon-settings font-blue "></i>
								<span class="caption-subject bold uppercase">Default Home Background Not Login</span>
							</div>
						</div>
						<div class="portlet-body">
							<form role="form" class="form-horizontal" action="{{url('setting/default_home')}}" method="POST" enctype="multipart/form-data">
								<div class="form-body">
									<div class="form-group col-md-12">
										<label class="control-label col-md-3">Text 1 </label>
										<div class="col-md-8">
											<input type="text" name="default_home_text1" placeholder="Default home text 1" class="form-control" value="@if(isset($default_home['default_home_text1'])) {{$default_home['default_home_text1']}} @endif">
										</div>
									</div>
									<div class="form-group col-md-12">
										<label class="control-label col-md-3">Text 2 </label>
										<div class="col-md-8">
											<input type="text" name="default_home_text2" placeholder="Default home text 2" class="form-control" value="@if(isset($default_home['default_home_text2'])) {{$default_home['default_home_text2']}} @endif">
										</div>
									</div>
									<div class="form-group col-md-12">
										<label class="control-label col-md-3">Text 3 </label>
										<div class="col-md-8">
											<input type="text" name="default_home_text3" placeholder="Default home text 3" class="form-control" value="@if(isset($default_home['default_home_text3'])) {{$default_home['default_home_text3']}} @endif">
										</div>
									</div>
									<div class="form-group col-md-12">
											<label class="control-label col-md-3">Background Image
												<br>
												<span class="required" aria-required="true"> (1080*270) </span>
											</label><br>
											<div class="fileinput fileinput-new col-md-4" data-provides="fileinput">
												<div class="fileinput-new thumbnail">
													@if(isset($default_home['default_home_image']))
														<img src="{{ env('S3_URL_API')}}{{$default_home['default_home_image']}}" alt="">
													@else
														<img src="https://www.placehold.it/200x100/EFEFEF/AAAAAA&amp;text=no+image" alt="">
													@endif
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail" id="div_background_default" style="max-width: 500px; max-height: 250px;"></div>
												<div>
													<span class="btn default btn-file">
													<span class="fileinput-new"> Select image </span>
													<span class="fileinput-exists"> Change </span>
													<input type="file" class="file" id="background_default" accept="image/*" name="default_home_image">
													</span>
													<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
												</div>
											</div>
										</div>
								</div>
								<div class="form-actions" style="text-align:center">
									{{ csrf_field() }}
									<button type="submit" class="btn blue" id="checkBtn">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<form id="frmdelete2" method="post" action="{{URL::to('setting/background/delete')}}">
				{{csrf_field()}}
				<input type="hidden" name="id_home_background" id="txtvalue2">
			</form>
		</div> -->
	@endif

	{{-- splash screen --}}
    <div class="tab-pane active" id="splash-screen">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Default Splash Screen</span>
						</div>
					</div>
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url('setting/default_home')}}" method="POST" enctype="multipart/form-data">
							<div class="form-body">
								<div class="form-group col-md-12">
									<label class="text-right col-md-4">Splash Screen Duration
										<span class="required" aria-required="true"> * </span>
									</label>
									<div class="col-md-4">
										<input type="number" class="form-control" name="default_home_splash_duration" value="{{$default_home['default_home_splash_duration']??''}}" min="1">
									</div>
								</div>
								<div class="form-group col-md-12">
										<label class="control-label col-md-4">Splash Screen
											<br>
											<span class="required" aria-required="true"> (1080*1920)/(540*960) </span>
										</label><br>
										<div class="fileinput fileinput-new col-md-4" data-provides="fileinput">
											<div class="fileinput-new thumbnail">
												@if(isset($default_home['default_home_splash_screen']))
													<img src="{{ env('S3_URL_API')}}{{$default_home['default_home_splash_screen']}}?" alt="">
												@else
													<img src="https://www.placehold.it/200x100/EFEFEF/AAAAAA&amp;text=no+image" alt="">
												@endif
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" id="div_splash" style="max-width: 500px; max-height: 250px;"></div>
											<div>
												<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file" class="file file-splash" id="field_splash" accept="image/*" name="default_home_splash_screen">
												</span>
												<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
											</div>
										</div>
									</div>
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn blue" id="checkBtn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- banner --}}
	@if(MyHelper::hasAccess([144], $grantedFeature))
    <div class="tab-pane" id="banner">
        @if(MyHelper::hasAccess([145], $grantedFeature))
        <div style="margin:20px 0">
        	<a class="btn blue btn-outline sbold" data-toggle="modal" href="#modalBanner"> New Banner
        		<i class="fa fa-question-circle tooltips" data-original-title="Membuat banner di halaman home aplikasi mobile" data-container="body"></i>
        	</a>
    	</div>
        @endif

    	<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">List Banner</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="alert alert-warning">
						    <p> To arrange the order of images, drag and drop on the image in the order of the desired image.</p>
						</div>
						@if(!empty($banners))
						<form action="{{ url('setting/banner/reorder') }}" method="POST">
							<div class="clearfix" id="sortable">
								@foreach ($banners as $key => $banner)
					 			<div class="portlet portlet-sortable light bordered col-md-3">
					 				<div class="portlet-title">
										<div class="row">
											<div class="col-md-2">
					 				  			<span class="caption-subject bold" style="font-size: 12px !important;">{{ $key + 1 }}</span>
											</div>
											<div class="col-md-10 text-right">
												@if(MyHelper::hasAccess([146], $grantedFeature))
												<a class="btn blue btn-circle btn-edit" href="#modalBannerUpdate" data-toggle="modal" data-id="{{ $banner['id_banner'] }}" data-img="{{$banner['image_url']}}" data-news="{{$banner['id_news']}}" data-url="{{$banner['url']}}" data-type="{{ $banner['type'] }}" data-start="{{ ($banner['banner_start']??false)?date("d F Y - H:i", strtotime(implode(' ',[explode(' ', $banner['banner_start'])[0], explode(' ', $banner['banner_start'])[1]]))):'' }}" data-end="{{ ($banner['banner_start']??false)?date("d F Y - H:i", strtotime(implode(' ',[explode(' ', $banner['banner_start'])[0], explode(' ', $banner['banner_start'])[1]]))):''}}"><i class="fa fa-pencil"></i> </a>
												@endif
												@if(MyHelper::hasAccess([147], $grantedFeature))
												<a class="btn red-mint btn-circle btn-delete" data-id="{{ $banner['id_banner'] }}"><i class="fa fa-trash-o"></i> </a>
												@endif
											</div>
										</div>
					 				</div>
					 			 	<div class="portlet-body">
					 			   		<input type="hidden" name="id_banners[]" value="{{ $banner['id_banner'] }}">
					 			   		<center><img src="{{ $banner['image_url'] }}" alt="Banner Image" width="150"></center>
					 			 	</div>
					 			 	<div class="click-to">
					 			 		@php
					 			 			if ($banner['news_title'] != null) {
					 			 				$click_to = str_limit($banner['news_title'], 20);
					 			 			}
					 			 			elseif ($banner['url'] != null) {
					 			 				if ($banner['type'] == 'general') {
					 			 					$click_to = str_limit($banner['url'], 20);
					 			 				} else {
					 			 					$click_to = "GO-FOOD";
					 			 				}
					 			 			}
					 			 			else {
				 			 					$click_to = "-";
					 			 			}
					 			 		@endphp

					 			 		<div>Click to:</div>
										<div>{{ $click_to }}</div><br>
										<div>Date Start:</div>
										<div>{{ ($banner['banner_start']??false)?date("d F Y H:i", strtotime(implode(' ',[explode(' ', $banner['banner_start'])[0], explode(' ', $banner['banner_start'])[1]]))):'-' }}</div><br>
										<div>Date End:</div>
					 			 		<div>{{ ($banner['banner_start']??false)?date("d F Y H:i", strtotime(implode(' ',[explode(' ', $banner['banner_end'])[0], explode(' ', $banner['banner_end'])[1]]))):'-' }}</div>
					 			 	</div>
					 			</div>
					 			@endforeach
							</div>
							@if(MyHelper::hasAccess([146], $grantedFeature))
							<div class="text-center">
								{{ csrf_field() }}
								<input type="submit" value="Update Sorting" class="btn blue">
							</div>
							@endif
						</form>
						@endif
					</div>
				</div>
			</div>
		</div>
    </div>
	@endif
	@include('setting::featured_deals')

	{{-- app logo --}}
    <div class="tab-pane" id="app-logo">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Application Logo</span>
						</div>
					</div>
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url('setting/app_logo')}}" method="POST" enctype="multipart/form-data">
							<div class="form-body">
								<div class="form-group col-md-12">
									<label class="control-label col-md-3">Logo
										<br>
										<span class="required" aria-required="true"> (433*318) </span>
									</label><br>
									<div class="fileinput fileinput-new col-md-4" data-provides="fileinput">
										<div class="fileinput-new thumbnail">
											@if(isset($app_logo['app_logo_3x']))
												<img src="{{ env('S3_URL_API')}}{{$app_logo['app_logo_3x']}}" alt="">
											@else
												<img src="https://www.placehold.it/200x100/EFEFEF/AAAAAA&amp;text=no+image" alt="">
											@endif
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" id="div_background_default" style="max-width: 433px; max-height: 318px;"></div>
										<div>
											<span class="btn default btn-file">
											<span class="fileinput-new"> Select image </span>
											<span class="fileinput-exists"> Change </span>
											<input type="file" class="file" id="logo" accept="image/*" name="app_logo">
											</span>
											<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn blue" id="checkBtn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- app navigation --}}
    <div class="tab-pane" id="app-navigation">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">App Top Navigation Text</span>
						</div>
					</div>
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url('setting/app_navbar')}}" method="POST">
							<div class="form-body">
								@foreach($app_navbar as $key => $value)
								<div class="form-group col-md-12">
									<label class="control-label col-md-3">{{ucwords(str_replace('app_navbar_','', $key))}} </label>
									<div class="col-md-8">
										<input type="text" name="{{$key}}" placeholder="{{$value}}" class="form-control" value="{{$value}}">
									</div>
								</div>
								@endforeach
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn blue" id="checkBtn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">App Side Navigation Text</span>
						</div>
					</div>
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url('setting/app_sidebar')}}" method="POST">
							<div class="form-body">
								@foreach($app_sidebar as $key => $value)
								<div class="form-group col-md-12">
									<label class="control-label col-md-3">{{ucwords(str_replace('app_sidebar_','', $key))}} </label>
									<div class="col-md-8">
										<input type="text" name="{{$key}}" placeholder="{{$value}}" class="form-control" value="{{$value}}">
									</div>
								</div>
								@endforeach
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn blue" id="checkBtn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="modal fade" id="modalTimeSetting" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Time Setting</h4>
			</div>
			<div class="modal-body form">
				<form role="form" action="{{url('setting/home')}}" method="POST">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label">Morning <span class="required" aria-required="true"> * </span></label>
							<input type="text" name="greetings_morning" value="{{$timesetting['greetings_morning']}}" class="form-control timepicker timepicker-default" >
						</div>
						<div class="form-group">
							<label class="control-label">Afternoon <span class="required" aria-required="true"> * </span></label>
							<input type="text" name="greetings_afternoon" value="{{$timesetting['greetings_afternoon']}}" class="form-control timepicker timepicker-default" >
						</div>
						<div class="form-group">
							<label class="control-label">Evening <span class="required" aria-required="true"> * </span></label>
							<input type="text" name="greetings_evening" value="{{$timesetting['greetings_evening']}}" class="form-control timepicker timepicker-default" >
						</div>
						<div class="form-group">
							<label class="control-label">Late Night <span class="required" aria-required="true"> * </span></label>
							<input type="text" name="greetings_late_night" value="{{$timesetting['greetings_late_night']}}" class="form-control timepicker timepicker-default" >
						</div>
					</div>
					<div class="form-actions" style="text-align:center">
						{{ csrf_field() }}
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalGreeting" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">New Greeting</h4>
			</div>
			<div class="modal-body form">
				<form role="form" action="{{url('setting/greeting/create')}}" method="POST">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label">When to Display <span class="required" aria-required="true"> * </span></label>
							<div class="radio-list" style="padding-left:20px"><br>
								<label class="radio-inline">
									<input type="radio" name="when" id="optionsRadios4" value="morning" checked> Morning </label><br>
								<label class="radio-inline">
									<input type="radio" name="when" id="optionsRadios5" value="afternoon"> Afternoon </label><br>
								<label class="radio-inline">
									<input type="radio" name="when" id="optionsRadios6" value="evening"> Evening </label><br>
								<label class="radio-inline">
									<input type="radio" name="when" id="optionsRadios7" value="late_night"> Late Night </label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Title <span class="required" aria-required="true"> * </span></label>
							<input type="text" name="greeting" id="txt_greeting" class="form-control" maxlength="25">
							<div class="row" style="margin-top:30px">
								@foreach($textreplaces as $key=>$row)
									<div class="col-md-3" style="margin-bottom:5px;">
										<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addGreetingReplace('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
									</div>
								@endforeach
							</div>
						</div>
<!-- 						<div class="form-group">
							<label class="control-label">Subtitle <span class="required" aria-required="true"> * </span></label>
							<input type="text" name="greeting2" id="txt_greeting_2" class="form-control">
							<div class="row" style="margin-top:30px">
								@ foreach($textreplaces as $key=>$row)
									<div class="col-md-3" style="margin-bottom:5px;">
										<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{ { $row['keyword'] } }' with user's { { $row['reference'] } }" onClick="addGreetingReplace2('{ { $row['keyword'] } }');">{ { str_replace('_',' ',$row['keyword']) } }</span>
									</div>
								@ endforeach
							</div>
						</div> -->
					</div>
					<div class="form-actions" style="text-align:center">
						{{ csrf_field() }}
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<button type="submit" class="btn blue" id="checkBtn">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalBackground" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">New Background</h4>
			</div>
			<div class="modal-body form">
				<form role="form" action="{{url('setting/background/create')}}" method="POST" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label">When to Display <span class="required" aria-required="true"> * </span></label>
							<div class="radio-list" style="padding-left:20px">
								<label>
									<input type="radio" name="when" id="optionsRadios4" value="morning" checked> Morning </label>
								<label>
									<input type="radio" name="when" id="optionsRadios5" value="afternoon"> Afternoon </label>
								<label>
									<input type="radio" name="when" id="optionsRadios6" value="evening"> Evening </label>
								<label>
									<input type="radio" name="when" id="optionsRadios7" value="late_night"> Late Night </label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Background Image <span class="required" aria-required="true"> * </span></label><br>
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px;">
									<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
								<div>
									<span class="btn default btn-file">
									<span class="fileinput-new"> Select image </span>
									<span class="fileinput-exists"> Change </span>
									<input type="file" accept="image/*" name="background">
									</span>
									<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center">
						{{ csrf_field() }}
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<button type="submit" class="btn blue" id="checkBtn">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@if(MyHelper::hasAccess([145], $grantedFeature))
<div class="modal fade" id="modalBanner" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">New Banner</h4>
			</div>
			<div class="modal-body form">
				<form role="form" action="{{url('setting/banner/create')}}" method="POST" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label">Banner Image <span class="required" aria-required="true"> * (750*375)</span></label><br>
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 200px;">
									<img src="https://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=750+x+375" alt="">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
								<div>
									<span class="btn default btn-file">
									<span class="fileinput-new"> Select image </span>
									<span class="fileinput-exists"> Change </span>
									<input type="file" accept="image/*" name="banner_image" required>
									</span>
									<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
								</div>
							</div>
						</div>

						<div class="form-group clearfix">
                            <label class="control-label">
                                Click To
                            </label>
							<div class="row" style="padding-left: 20px;">
	                            <div class="col-md-2">
                                    <label class="radio-inline">
										<input class="click-to-radio" type="radio" name="click_to" value="news"> News
									</label>
	                            </div>
	                            <div class="col-md-2">
                                    <label class="radio-inline">
										<input class="click-to-radio" type="radio" name="click_to" value="url"> Link
									</label>
	                            </div>
	                            <div class="col-md-2">
                                    <label class="radio-inline">
										<input class="click-to-radio" type="radio" name="click_to" value="none" checked> None
									</label>
	                            </div>
	                            <div class="col-md-4">
                                    <label class="radio-inline">
										<input class="click-to-radio" type="radio" name="click_to" value="gofood"> GO-FOOD
									</label>
	                            </div>
                            </div>

                            <div class="col-md-12 click-to-type" style="margin-top: 10px;">
                            	<select class="form-control select2 click-to-news" name="id_news" data-placeholder="Select News">
                            		<option></option>
                                    @if (!empty($news))
                                        @foreach ($news as $item)
                                        <option value="{{ $item['id_news'] }}">{{ $item['news_title'] }}</option>
                                        @endforeach
                                    @endif
                                </select>

								<input class="form-control click-to-url" type="text" name="url" placeholder="https://www.google.com">
                            </div>
						</div>
					</div>

					<div class="form-group clearfix">
						<label class="col-md-3 control-label">Date Start</label>
						<div class="col-md-6">
							<div class="input-group date form_datetime form_datetime bs-datetime">
								<input type="text" autocomplete="off" name="banner_start" size="16" class="form-control">
								<span class="input-group-addon">
									<button class="btn default date-set" type="button">
										<i class="fa fa-calendar"></i>
									</button>
								</span>
							</div>
						</div>
					</div>

					<div class="form-group clearfix">
						<label class="col-md-3 control-label">Date End</label>
						<div class="col-md-6">
							<div class="input-group date form_datetime form_datetime bs-datetime">
								<input type="text" autocomplete="off" name="banner_end" size="16" class="form-control">
								<span class="input-group-addon">
									<button class="btn default date-set" type="button">
										<i class="fa fa-calendar"></i>
									</button>
								</span>
							</div>
						</div>
					</div>

					<div class="form-actions" style="text-align:center">
						{{ csrf_field() }}
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<button type="submit" class="btn blue" id="checkBtn">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endif

@if(MyHelper::hasAccess([146], $grantedFeature))
<div class="modal fade" id="modalBannerUpdate" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Banner</h4>
			</div>
			<div class="modal-body form">
				<form role="form" action="{{url('setting/banner/update')}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id_banner" id="id_banner">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label">Banner Image <span class="required" aria-required="true"> * (750*375)</span></label><br>
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 200px;">
									<img src="https://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=750+x+375" alt="" id="edit-banner-img">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
								<div>
									<span class="btn default btn-file">
									<span class="fileinput-new"> Select image </span>
									<span class="fileinput-exists"> Change </span>
									<input type="file" accept="image/*" name="banner_image">
									</span>
									<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
								</div>
							</div>
						</div>

						<div class="form-group clearfix">
                            <label class="control-label">
                                Click To
                            </label>
							<div class="row" style="padding-left: 20px;">
	                            <div class="col-md-2">
                                    <label class="radio-inline">
										<input class="click-to-radio" type="radio" name="click_to" value="news"> News
									</label>
	                            </div>
	                            <div class="col-md-2">
                                    <label class="radio-inline">
										<input class="click-to-radio" type="radio" name="click_to" value="url"> Link
									</label>
	                            </div>
	                            <div class="col-md-2">
                                    <label class="radio-inline">
										<input class="click-to-radio" type="radio" name="click_to" value="none" checked> None
									</label>
	                            </div>
	                            <div class="col-md-4">
                                    <label class="radio-inline">
										<input class="click-to-radio" type="radio" name="click_to" value="gofood"> GO-FOOD
									</label>
	                            </div>
                            </div>

                            <div class="col-md-12 click-to-type" style="margin-top: 10px;">
                            	<select class="form-control select2 click-to-news" name="id_news" data-placeholder="Select News">
                            		<option></option>
                                    @if (!empty($news))
                                        @foreach ($news as $item)
                                        <option value="{{ $item['id_news'] }}">{{ $item['news_title'] }}</option>
                                        @endforeach
                                    @endif
                                </select>

								<input class="form-control click-to-url" type="text" name="url" placeholder="https://www.google.com">
                            </div>
						</div>

					</div>

					<div class="form-group clearfix">
						<label class="col-md-3 control-label">Date Start</label>
						<div class="col-md-6">
							<div class="input-group date form_datetime form_datetime bs-datetime">
								<input type="text" autocomplete="off" id="banner_start" name="banner_start" size="16" class="form-control">
								<span class="input-group-addon">
									<button class="btn default date-set" type="button">
										<i class="fa fa-calendar"></i>
									</button>
								</span>
							</div>
						</div>
					</div>

					<div class="form-group clearfix">
						<label class="col-md-3 control-label">Date End</label>
						<div class="col-md-6">
							<div class="input-group date form_datetime form_datetime bs-datetime">
								<input type="text" autocomplete="off" id="banner_end" name="banner_end" size="16" class="form-control">
								<span class="input-group-addon">
									<button class="btn default date-set" type="button">
										<i class="fa fa-calendar"></i>
									</button>
								</span>
							</div>
						</div>
					</div>

					<div class="form-actions" style="text-align:center">
						{{ csrf_field() }}
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endif
@endsection