<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
 ?>
 @extends('layouts.main-closed')
@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/table-datatables-buttons.js') }}" type="text/javascript"></script>

	@php
		$is_all_outlet 		= null;
		$is_all_product 	= null;
		$outlet			 	= null;
		$product 			= null;
		if (isset($result['is_all_outlet']) && $result['is_all_outlet'] == "0") {
			$is_all_outlet = $result['is_all_outlet'];
			$outlet = [];
			for ($i=0; $i < count($result['outlet_filter']); $i++) {
				$outlet[] = $result['outlet_filter'][$i]['id_outlet'];
			}
		}
		if (isset($result['product_discount_rule']['is_all_product']) && $result['product_discount_rule']['is_all_product'] == "0") {
			$is_all_product = $result['product_discount_rule']['is_all_product'];
			$product = [];
			for ($i=0; $i < count($result['product_discount']); $i++) {
				$product[] = $result['product_discount'][$i]['id_product'];
			}
		}
	@endphp
	<script>
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

	function showDisableInput(input) {
		$(input).collapse('show').find("input, textarea, select").each(function() {
			$(this).prop('disabled', true);
		});
	}

	$(document).ready(function() {
		if($('#pushNotif').is(':checked')) {
			showDisableInput('#formPushNotif')
			$('#pushNotif').prop('disabled', true);
		}
	});
	</script>
	@yield('child-script')
	@yield('child-script2')
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
				<div class="col-md-6 mt-step-col first">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Info</div>
					<div class="mt-step-content font-grey-cascade">Point Injection Detail & Rule</div>
				</div>
				<div class="col-md-6 mt-step-col last active">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Review & Summary</div>
					<div class="mt-step-content font-grey-cascade">Point Injection Finalization</div>
				</div>
			</div>
		</div>
	</div>
	<form role="form" action="" method="POST" enctype="multipart/form-data">
		<div class="col-md-12">
			<div class="col-md-5">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Information</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row static-info">
							<div class="col-md-5 name">Title</div>
							<div class="col-md-7 value">: {{$result['title']}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">Send Type</div>
							<div class="col-md-7 value">: {{$result['send_type']}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">Start Date</div>
							<div class="col-md-7 value">: {{date("d F Y", strtotime($result['start_date']))}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">Send Time</div>
							<div class="col-md-7 value">: {{date("H:i", strtotime($result['send_time']))}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">Total User</div>
							<div class="col-md-7 value">: {{$count}} Users</div>
						</div>
						@if ($result['send_type'] == 'Daily')
						<div class="row static-info">
							<div class="col-md-5 name">Duration</div>
							<div class="col-md-7 value">: {{$result['duration']}} Days</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">Point / Day</div>
							<div class="col-md-7 value">: {{number_format($result['point'])}} Point</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">Total Point / User</div>
							<div class="col-md-7 value">: {{number_format($result['total_point'])}} Point</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">Total Point All</div>
							<div class="col-md-7 value">: {{number_format($count*($result['duration']*$result['point']))}} Point</div>
						</div>
						@else
						<div class="row static-info">
							<div class="col-md-5 name">Total Point / User</div>
							<div class="col-md-7 value">: {{number_format($result['total_point'])}} Point</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">Total Point All</div>
							<div class="col-md-7 value">: {{number_format($count * $result['total_point'])}} Point</div>
						</div>
						@endif
						<div class="row static-info">
							<div class="col-md-5 name">Created by</div>
							<div class="col-md-7 value">: {{$result['user']['name']}}</div>
						</div>
						<div class="row static-info">
							<div class="col-md-5 name">Created at</div>
							<div class="col-md-7 value">: {{date("d F Y", strtotime($result['created_at']))}}&nbsp;{{date("H:i", strtotime($result['created_at']))}}</div>
						</div>
						@if ($result['start_date'] >= date("Y-m-d") && $result['send_time'] > date("H:i"))
						<div class="row static-info">
							<div class="col-md-12 value">
								<a class="btn blue col-md-12" href="{{url('/')}}/point-injection/edit/{{$result['id_point_injection']}}">Edit Point Injection</a>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-7">
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
												<th>Total Point</th>
											</tr>
										</thead>
										<tbody>
											@foreach($result['point_injection_users'] as $res)
												<tr>
													<td>{{ $res['user']['name'] }}</td>
													<td>{{ $res['user']['phone'] }}</td>
													<td>{{ number_format($res['total_point']) }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								@else
									No User List
								@endif
								<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px; right: 0px;">
									@if($page <= 1) <li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
									@else <li class="page-first"><a href="{{url('point-injection')}}/review/{{$result['id_point_injection']}}/page/{{$page-1}}">«</a></li>
									@endif

									@if($last == $count) <li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
									@else <li class="page-last"><a href="{{url('point-injection')}}/review/{{$result['id_point_injection']}}/page/{{$page+1}}">»</a></li>
									@endif
								</ul>
							</div>
							<!-- END: Comments -->
						</div>
					</div>
				</div>
			</div>
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
									<input disabled id="pushNotif" type="checkbox" value="Push Notification" name="point_injection_media[]" @if(isset($result['point_injection_media_push']) && $result['point_injection_media_push'] == 1) checked @elseif(old('point_injection_media_push') != "" && old('point_injection_media_push') == "Yes") checked @endif />
									<span></span>
								</label>
							</div>
						</div>
						<div class="row">
							<div id="formPushNotif" class="collapse">
								<div class="form-group" style="margin-bottom:30px">
									<label class="col-md-2 control-label">Subject</label>
									<div class="col-md-10">
										<input type="text" placeholder="Push Notification Subject" class="form-control" name="point_injection_push_subject" id="point_injection_push_subject" @if(isset($result['point_injection_push_subject']) && $result['point_injection_push_subject'] != "") value="{{$result['point_injection_push_subject']}}" @endif>
										<br>
									</div>
								</div>
								<div class="form-group" style="margin-bottom:30px">
									<label for="multiple" class="control-label col-md-2">Content</label>
									<div class="col-md-10">
										<textarea name="point_injection_push_content" id="point_injection_push_content" class="form-control">@if(isset($result['point_injection_push_content']) && $result['point_injection_push_content'] != ""){{$result['point_injection_push_content']}}@endif</textarea>
										<br>
									</div>
								</div>
								<div class="form-group">
									<label for="point_injection_push_clickto" class="control-label col-md-2">Gambar</label>
									<div class="col-md-10">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
												@if(isset($result['point_injection_push_image']) && $result['point_injection_push_image'] != "")
													<img src="{{env('S3_URL_API')}}{{$result['point_injection_push_image']}}" id="point_injection_push_image" />
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
											<option value="Home" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Home") selected @endif>Home</option>
											<option value="News" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "New") selected @endif>News</option>
											<!-- <option value="Product" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Product") selected @endif>Product</option> -->
											<option value="Order" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Order") selected @endif>Order</option>
											<!-- <option value="Transaction" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Transaction") selected @endif>History</option> -->
											<option value="History On Going" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "History On Going") selected @endif>History On Going</option>
											<option value="History Transaksi" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "History Transaksi") selected @endif>History Transaksi</option>
											<option value="History Point" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "History Point") selected @endif>History Point</option>
											<option value="Outlet" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Outlet") selected @endif>Outlet</option>
											<option value="Voucher" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Voucher") selected @endif>Voucher</option>
											<!-- <option value="Voucher Detail" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Voucher Detail") selected @endif>Voucher Detail</option> -->
											<option value="Profil" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Profil") selected @endif>Profil</option>
											<option value="Inbox" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Inbox") selected @endif>Inbox</option>
											<option value="About" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "About") selected @endif>About</option>
											<option value="FAQ" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "FAQ") selected @endif>FAQ</option>
											<option value="TOS" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "TOS") selected @endif>TOS</option>
											<option value="Contact Us" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Contact Us") selected @endif>Contact Us</option>
											<option value="Link" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Link") selected @endif>Link</option>
											<option value="Logout" @if(isset($result['point_injection_push_clickto']) && $result['point_injection_push_clickto'] == "Logout") selected @endif>Logout</option>

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
										<input type="text" placeholder="https://" class="form-control" name="point_injection_push_link" id="point_injection_push_link" @if(isset($result['point_injection_push_link'])) value="{{$result['point_injection_push_link']}}" @endif>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{-- <div class="col-md-12" style="text-align:center;">
			<div class="form-actions">
				{{ csrf_field() }}
				<button type="submit" class="btn blue">Save Campaign</button>
			</div>
		</div> --}}
	</form>
</div>
@endsection