<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
 ?>
 @extends('layouts.main-closed')


 @section('page-style')
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
@php
	$id_point_injection = null;
	$send_type = null;
	$duration = null;
	$point = null;
	$list_user = null;
	if (old()) {
		$send_type = old('send_type');
		$duration = old('duration');
		$point = old('point');
		$list_user = old('list_user');
	} elseif (isset($result)) {
		$id_point_injection = $result['id_point_injection'];
		$send_type = $result['send_type'];
		$duration = $result['duration'];
		$point = $result['point'];
	}
@endphp
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('AWS_ASSET_URL') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('assets/pages/scripts/table-datatables-buttons.js') }}" type="text/javascript"></script>
	<script src="{{ env('AWS_ASSET_URL') }}{{('js/prices.js')}}"></script>

	<script>
	Date.prototype.addHours = function(h) {
		this.setHours(this.getHours() + h);
		return this;
	}

	function addCommas(nStr)
	{
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

	function addPushSubject(param){
		var textvalue = $('#point_injection_push_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#point_injection_push_subject').val(textvaluebaru);
    }

	function addPushContent(param){
		var textvalue = $('#point_injection_push_content').val();
		var textvaluebaru = textvalue+" "+param;
		$('#point_injection_push_content').val(textvaluebaru);
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
					var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
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
				url : "{{ url('outlet/ajax/filter') }}"+'/'+det,
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
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
					var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
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

		else if(det == 'Home'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'Inbox'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'Voucher'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'Contact Us'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'Link'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'block';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'Logout'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		else if(det == 'Content'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'block';
		}

		else {
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('point_injection_'+type+'_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}
	}

	function hideDisableInput(input) {
		$(input).collapse('hide').find("input, textarea, select").each(function() {
			$(this).prop('required', false);
		});
	}

	function showEnableInput(input) {
		$(input).collapse('show').find("input, textarea, select").each(function() {
			$(this).prop('required', true);
		});
	}

	function getMonthFromString(mon){
		var d = Date.parse(mon + "1");
		if(!isNaN(d)){
			return new Date(d).getMonth() + 1;
		}
		return -1;
	}

	$(document).ready(function(){
		$('input[name=list_user]').change(function() {
			if (this.value == 'Upload CSV') {
				showEnableInput("#csvFilter");
				hideDisableInput("#textareaFilter");
				hideDisableInput("#manualFilter");
			} else if (this.value == 'Filter User') {
				showEnableInput("#manualFilter");
				hideDisableInput("#csvFilter");
				hideDisableInput("#textareaFilter");
			} else if (this.value == 'Filter Phone') {
				showEnableInput("#textareaFilter");
				hideDisableInput("#csvFilter");
				hideDisableInput("#manualFilter");
			}
		})
		$('input[name=send_type]').change(function() {
			$('.datetimepicker').datetimepicker('remove')
			if (this.value == 'One Time') {
				showEnableInput('#oneTimeSend');
				hideDisableInput("#dailyTimeSend");
				$(".datetimepicker").datetimepicker({
					format: "dd MM yyyy - hh:00",
					autoclose: true,
					startDate: new Date().addHours(1),
					minView: 1,
				})
			} else if (this.value == 'Daily') {
				hideDisableInput('#oneTimeSend');
				showEnableInput("#dailyTimeSend");
				$('#formTotalPoint').hide()
				$(".datetimepicker").datetimepicker({
					format: "dd MM yyyy",
					autoclose: true,
					startDate: new Date(),
					minView: 2
				}).on('change', function (event) {
					$('.timepicker').datetimepicker('remove')
					$('input[name=point_injection_send_time]').val('')
					if (Date.parse($('input[name=point_injection_send_at]').val()) < new Date()) {
						$('.timepicker').datetimepicker({
							format: "hh:00",
							autoclose: true,
							pickDate: false,
							startDate: new Date(),
							startView: 1,
							minView: 1
						}).on('click', function (event) {
							$('.datetimepicker-hours').find('thead').children().children().css("visibility", "hidden");
						})
					} else {
						$('.timepicker').datetimepicker({
							format: "hh:00",
							autoclose: true,
							pickDate: false,
							startView: 1,
							minView: 1
						}).on('click', function (event) {
							$('.datetimepicker-hours').find('thead').children().children().css("visibility", "hidden");
						})
					}
				})

				$('.timepicker').datetimepicker({
					format: "hh:00",
					autoclose: true,
					pickDate: false,
					startView: 1,
					minView: 1
				}).on('click', function (event) {
					$('.datetimepicker-hours').find('thead').children().children().css("visibility", "hidden");
				})
				$('input[name=point]').on('keyup change',function() {
					$('#formTotalPoint').show()
					var pointValue =  $( this ).val().replace(/[($)\s\._\-]+/g, '');
                    totalpoint = pointValue  * $('input[name=duration_day]').val()
					$('#totalPoint').replaceWith("<span id='totalPoint'>"+addCommas(totalpoint)+"</span>")
				})

				$('input[name=duration_day]').bind('keyup mousewheel',function(e) {
					$('#formTotalPoint').show()
					var pointValue =  $( 'input[name=point]' ).val().replace(/[($)\s\._\-]+/g, '');
					if(e.originalEvent.wheelDelta / 120 > 0) {
                    	totalpoint = pointValue  * (parseInt($(this).val()) + 1)
					} else if(e.originalEvent.wheelDelta / -120 > 0) {
                    	totalpoint = pointValue  * ($(this).val() - 1)
					} else {
                    	totalpoint = pointValue  * $(this).val()
					}
					$('#totalPoint').replaceWith("<span id='totalPoint'>"+addCommas(totalpoint)+"</span>")
				})
			}
		})
		$("input[name='point_injection_media[]']").change(function() {
			if($('#pushNotif').is(':checked')) {
				$('#formPushNotif').collapse('show')
			} else {
				hideDisableInput('#formPushNotif')
			}
		})

		point_injection = '{!!$id_point_injection!!}'
		point = '{!!$point!!}'
		duration = '{!!$duration!!}'
		list_user = '{!!$list_user!!}'

		if (point.length > 0) {
			$('#formTotalPoint').show()
			totaleditpoint = point * duration
			$('#totalPoint').replaceWith("<span id='totalPoint'>"+addCommas(totaleditpoint)+"</span>")
		}
		if (point_injection.length >= 0) {
			if($('#pushNotif').is(':checked')) {
				$('#formPushNotif').collapse('show')
			}
			send_type = '{!!$send_type!!}'
			if (send_type == 'One Time') {
				$('#oneTimeSend').collapse('show')
				$(".datetimepicker").datetimepicker({
					format: "dd MM yyyy - hh:00",
					autoclose: true,
					startDate: new Date().addHours(1),
					minView: 1
				})
			} else if (send_type == 'Daily') {
				$('#dailyTimeSend').collapse('show')
				$(".datetimepicker").datetimepicker({
					format: "dd MM yyyy",
					autoclose: true,
					startDate: new Date().addHours(1),
					minView: 2
				})

				$('.timepicker').datetimepicker({
					format: "hh:00",
					autoclose: true,
					pickDate: false,
					startView: 1,
					minView: 1
				})
			}
		}
		if (list_user == 'Upload CSV') {
			showEnableInput("#csvFilter");
			hideDisableInput("#textareaFilter");
			hideDisableInput("#manualFilter");
		} else if (list_user == 'Filter User') {
			showEnableInput("#manualFilter");
			hideDisableInput("#csvFilter");
			hideDisableInput("#textareaFilter");
		} else if (list_user == 'Filter Phone') {
			showEnableInput("#textareaFilter");
			hideDisableInput("#csvFilter");
			hideDisableInput("#manualFilter");
		} else {
			$("input[name=list_user]:first").click()
		}

    })
	</script>
	<style>
	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
	</style>

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
				<div class="col-md-6 mt-step-col first active">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Info</div>
					<div class="mt-step-content font-grey-cascade">Point Injection Detail & Rule</div>
				</div>
				<div class="col-md-6 mt-step-col last">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Review & Summary</div>
					<div class="mt-step-content font-grey-cascade">Point Injection Finalization</div>
				</div>
			</div>
		</div>
	</div>

	<form role="form" action="" method="POST" id="form" enctype="multipart/form-data">
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
							<label>Point Injection Title</label>
							<input type="text" class="form-control" placeholder="Point Injection Title" name="title" required @if(isset($result['title']) && $result['title'] != "") value="{{$result['title']}}" @elseif(old('title') != "") value="{{old('title')}}" @endif>
						</div>
						<div class="form-group" style="height: 50px;">
							<label>Point Injection Type Send</label>
							<div class="mt-radio-inline">
								<label class="mt-radio mt-radio-outline"> One Time
									<input type="radio" value="One Time" name="send_type" @if(isset($result['send_type']) && $result['send_type'] == "One Time") checked @elseif(old('send_type') != "" && old('send_type') == "One Time") checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline"> Daily
									<input type="radio" value="Daily" name="send_type" @if(isset($result['send_type']) && $result['send_type'] == "Daily") checked @elseif(old('send_type') != "" && old('send_type') == "Daily") checked @endif required/>
									<span></span>
								</label>
							</div>
						</div>
						<div id="oneTimeSend" class="collapse">
							<div class="form-group">
								<label class="control-label">Date Time to Send</label>
								<div class="input-group date bs-datetime">
									<input type="text" autocomplete="off" size="16" class="form-control datetimepicker" name="point_injection_one_time_send_at" placeholder="Now" @if(isset($result['start_date']) && $result['start_date'] != "") value="{{date('d F Y - H:i', strtotime($result['start_date'] . $result['send_time']))}}" @elseif(old('point_injection_one_time_send_at') != "") value="{{old('point_injection_one_time_send_at')}}" @endif>
									<span class="input-group-addon">
										<button class="btn default date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Total Point</label>
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Total point yang ingin diberikan" data-container="body"></i>
								<div class="input-group col-md-12">
									<input type="text" class="form-control price" name="total_point" placeholder="Total Point" @if(isset($result['total_point']) && $result['total_point'] != "") value="{{$result['total_point']}}" @elseif(old('total_point') != "") value="{{old('total_point')}}" @endif>
								</div>
							</div>
						</div>
						<div id="dailyTimeSend" class="form-group collapse">
							<div class="form-group">
								<label class="control-label">Start Date</label>
								<div class="input-group date bs-datetime">
									<input type="text" autocomplete="off" size="16" class="form-control datetimepicker" name="point_injection_send_at" placeholder="Start Date" @if(isset($result['start_date']) && $result['start_date'] != "") value="{{date('d F Y', strtotime($result['start_date']))}}" @elseif(old('point_injection_send_at') != "") value="{{old('point_injection_send_at')}}" @endif>
									<span class="input-group-addon">
										<button class="btn default date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Daily Time Send</label>
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Waktu pemberian point setiap hari" data-container="body"></i>
								<div class="input-group">
									<input type="text" autocomplete="off" class="form-control timepicker" name="point_injection_send_time" placeholder="Time Send" @if(isset($result['send_time']) && $result['send_time'] != "") value="{{date('H:i', strtotime($result['send_time']))}}" @elseif(old('point_injection_send_time') != "") value="{{old('point_injection_send_time')}}" @endif>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i class="fa fa-clock-o"></i>
										</button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Duration Day</label>
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Durasi pemberian point dalam hari" data-container="body"></i>
								<div class="input-group col-md-12">
									<input type="number" class="form-control" name="duration_day" min="1" placeholder="Duration Day" @if(isset($result['duration']) && $result['duration'] != "") value="{{$result['duration']}}" @elseif(old('duration_day') != "") value="{{old('duration_day')}}" @endif>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Injection Point / Day</label>
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Total point yang ingin diberikan setiap harinya" data-container="body"></i>
								<div class="input-group col-md-12">
									<input type="text" class="form-control price" name="point" placeholder="Total Point" @if(isset($result['point']) && $result['point'] != "") value="{{$result['point']}}" @elseif(old('point') != "") value="{{old('point')}}" @endif>
								</div>
							</div>
							<div class="form-group" id="formTotalPoint">
								<label class="control-label">Total Point Injection
								<i class="fa fa-question-circle tooltips" data-original-title="Contoh Kode yang digenerate secara otomatis" data-container="body"></i></label>
								<div class="input-group col-md-12">
									<span id="totalPoint"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if (isset($result))
		<div class="col-md-8">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">List Customer</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="tab-pane" id="code">
						<!-- BEGIN: Comments -->
						<div class="mt-comments">
							@if(isset($result['point_injection_users']))
								<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_4">
									<thead>
										<tr>
											<th>Name</th>
											<th>Phone</th>
										</tr>
									</thead>
									<tbody>
										@foreach($result['point_injection_users'] as $res)
											<tr>
												<td>{{ $res['user']['name'] }}</td>
												<td>{{ $res['user']['phone'] }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							@else
								No User List
							@endif
							<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px; right: 0px;">
								@if($page <= 1) <li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
								@else <li class="page-first"><a href="{{url('point-injection')}}/edit/{{$result['id_point_injection']}}/page/{{$page-1}}">«</a></li>
								@endif

								@if($last == $count) <li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
								@else <li class="page-last"><a href="{{url('point-injection')}}/edit/{{$result['id_point_injection']}}/page/{{$page+1}}">»</a></li>
								@endif
							</ul>
						</div>
						<!-- END: Comments -->
					</div>
					@php
						$show=true;
						$type='filter';
					@endphp
					@include('pointinjection::filter-textarea')
				</div>
			</div>
		</div>
		@else
		<div class="col-md-8">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Customer List</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="form-group" style="height: 50px;">
						<div class="mt-radio-inline">
							<label class="mt-radio mt-radio-outline"> Upload CSV
								<input type="radio" value="Upload CSV" name="list_user" @if(isset($result['list_user']) && $result['list_user'] == "Upload CSV") checked @elseif(old('list_user') != "" && old('list_user') == "Upload CSV") checked @endif required/>
								<span></span>
							</label>
							<label class="mt-radio mt-radio-outline"> Filter User
								<input type="radio" value="Filter User" name="list_user" @if(isset($result['list_user']) && $result['list_user'] == "Filter User") checked @elseif(old('list_user') != "" && old('list_user') == "Filter User") checked @endif required/>
								<span></span>
							</label>
							<label class="mt-radio mt-radio-outline"> Filter Phone
								<input type="radio" value="Filter Phone" name="list_user" @if(isset($result['list_user']) && $result['list_user'] == "Filter Phone") checked @elseif(old('list_user') != "" && old('list_user') == "Filter Phone") checked @endif required/>
								<span></span>
							</label>
						</div>
					</div>
					{{ csrf_field() }}
					@if(isset($result['conditions']) || old('conditions') != "")
						@php
							if (isset($result['conditions'])) {
								$search_param = $result['conditions'];
							} else {
								$search_param = old('conditions');
							}
							$search_param = array_filter($search_param);
							$conditions = $search_param;
						@endphp
					@else
						@php $conditions = ""; @endphp
					@endif
						@php $tombolsubmit = 'hidden'; @endphp
					@if ($conditions&&!empty($conditions)&&isset($conditions[0]['rules'])&&!empty($conditions[0]['rules']))
						@php $show=true; @endphp
						@if (strtoupper($conditions[0]['rules'][0]['operator'])=='WHERE IN')
							@php $type='csv'; @endphp
							@include('pointinjection::filter-csv')
						@else
							@php $type='filter'; @endphp
							@include('pointinjection::filter')
							@include('pointinjection::filter-textarea')
						@endif
					@else
						@php
							$show=false;
							$type='filter';
						@endphp
						@include('pointinjection::filter')
						@include('pointinjection::filter-csv')
						@include('pointinjection::filter-textarea')
					@endif
				</div>
			</div>
		</div>
		@endif
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Point Injection Media</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="form-group">
						<div class="mt-checkbox-list">
							<label class="mt-checkbox mt-checkbox-outline"> Push Notification
								<input id="pushNotif" type="checkbox" value="Push Notification" name="point_injection_media[]" @if(isset($result['point_injection_media_push']) && $result['point_injection_media_push'] == 1) checked @elseif(old('point_injection_media') != "" && old('point_injection_media')[0] == 'Push Notification') checked @endif />
								<span></span>
							</label>
						</div>
					</div>
					<div class="row">
						<div id="formPushNotif" class="collapse">
							<div class="form-group" style="margin-bottom:30px">
								<label class="col-md-2 control-label">Subject</label>
								<div class="col-md-10">
									<input type="text" placeholder="Push Notification Subject" class="form-control" name="point_injection_push_subject" id="point_injection_push_subject" @if(isset($result['point_injection_push_subject']) && $result['point_injection_push_subject'] != "") value="{{$result['point_injection_push_subject']}}" @elseif(old('point_injection_push_subject') != "")value="{{old('point_injection_push_subject')}}"@endif>
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
									<br><br>
								</div>
							</div>
							<div class="form-group" style="margin-bottom:30px">
								<label for="multiple" class="control-label col-md-2">Content</label>
								<div class="col-md-10">
									<textarea name="point_injection_push_content" id="point_injection_push_content" class="form-control">@if(isset($result['point_injection_push_content']) && $result['point_injection_push_content'] != ""){{$result['point_injection_push_content']}} @elseif(old('point_injection_push_content') != "") {{old('point_injection_push_content')}}@endif</textarea>
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addPushContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="point_injection_push_clickto" class="control-label col-md-2">Gambar</label>
								<div class="col-md-10">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
											@if(isset($result['point_injection_push_image']) && $result['point_injection_push_image'] != "")
												<img src="{{env('AWS_URL')}}{{$result['point_injection_push_image']}}" id="point_injection_push_image" />
											@else
												<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="point_injection_push_image" />
											@endif
										</div>

										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
										<div>
											<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file"  accept="image/*" id="point_injection_push_image" name="point_injection_push_image"> </span>
											<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="point_injection_push_clickto" class="control-label col-md-2" style="padding-top:30px">Click Action</label>
								<div class="col-md-10" style="padding-top:30px">
									<select name="point_injection_push_clickto" id="point_injection_push_clickto" class="form-control select2" onChange="fetchDetail(this.value, 'push')">
										<option value="Home" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Home") selected @elseif (old('point_injection_push_clickto') == "Home") selected @endif>Home</option>
										<option value="News" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "New") selected @elseif (old('point_injection_push_clickto') == "New") selected @endif>News</option>
										<!-- <option value="Product" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Product") selected @endif>Product</option> -->
										<option value="Order" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Order") selected @elseif (old('point_injection_push_clickto') == "Order") selected @endif>Order</option>
										<!-- <option value="Transaction" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Transaction") selected @endif>History</option> -->
										<option value="History On Going" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "History On Going") selected @elseif (old('point_injection_push_clickto') == "History On Going") selected @endif>History On Going</option>
										<option value="History Transaksi" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "History Transaksi") selected @elseif (old('point_injection_push_clickto') == "History Transaksi") selected @endif>History Transaksi</option>
										<option value="History Point" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "History Point") selected @elseif (old('point_injection_push_clickto') == "History Point") selected @endif>History Point</option>
										<option value="Outlet" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Outlet") selected @elseif (old('point_injection_push_clickto') == "Outlet") selected @endif>Outlet</option>
										<option value="Voucher" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Voucher") selected @elseif (old('point_injection_push_clickto') == "Voucher") selected @endif>Voucher</option>
										<!-- <option value="Voucher Detail" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Voucher Detail") selected @endif>Voucher Detail</option> -->
										<option value="Profil" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Profil") selected @elseif (old('point_injection_push_clickto') == "Profil") selected @endif>Profil</option>
										<option value="Inbox" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Inbox") selected @elseif (old('point_injection_push_clickto') == "Inbox") selected @endif>Inbox</option>
										<option value="About" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "About") selected @elseif (old('point_injection_push_clickto') == "About") selected @endif>About</option>
										<option value="FAQ" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "FAQ") selected @elseif (old('point_injection_push_clickto') == "FAQ") selected @endif>FAQ</option>
										<option value="TOS" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "TOS") selected @elseif (old('point_injection_push_clickto') == "TOS") selected @endif>TOS</option>
										<option value="Contact Us" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Contact Us") selected @elseif (old('point_injection_push_clickto') == "Contact Us") selected @endif>Contact Us</option>
										<option value="Link" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Link") selected @elseif (old('point_injection_push_clickto') == "Link") selected @endif>Link</option>
										<option value="Logout" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Logout") selected @elseif (old('point_injection_push_clickto') == "Logout") selected @endif>Logout</option>

									</select>
								</div>
							</div>
							<div class="form-group" id="atd_push" style="display:none;">
								<label for="point_injection_push_id_reference" class="control-label col-md-2" style="padding-top:30px;">Action to Detail</label>
								<div class="col-md-10" style="padding-top:30px;">
									<select name="point_injection_push_id_reference" id="point_injection_push_id_reference" class="form-control select2">
									</select>
								</div>
							</div>
							<div class="form-group" id="link_push" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Link") style="display:block;" @else style="display:none;" @endif>
								<label for="point_injection_push_link" class="control-label col-md-2" style="padding-top:30px;">Link</label>
								<div class="col-md-10" style="padding-top:30px;">
									<input type="text" placeholder="https://" class="form-control" name="point_injection_push_link" id="point_injection_push_link" @if(isset($result['point_injection_push_link'])) value="{{$result['point_injection_push_link']}}"@elseif(old('point_injection_push_link') != "") {{old('point_injection_push_link')}} @endif>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12" style="text-align:center;">
			<div class="form-actions">
				{{ csrf_field() }}
				<button type="submit" class="btn blue" id="checkBtn">Launch</button>
			</div>
		</div>
	</form>
</div>
@endsection