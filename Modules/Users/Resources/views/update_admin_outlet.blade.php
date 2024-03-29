<?php
    use App\Lib\MyHelper;
	$configs    		= session('configs');
 ?>
 @extends('layouts.main')

@section('page-style')
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.css?x=1') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-typeahead.min.js') }}" type="text/javascript"></script>
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
    </div><br>
@include('layouts.notifications')
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Update Admin Outlet</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Outlet
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Outlet penempatan admin" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" value="{{$details['outlet_name']}}" readonly />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Phone
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon admin" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" value="{{$details['phone']}}" readonly />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Name
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Nama admin" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="name" placeholder="User Name (Required)" class="form-control" value="{{$details['name']}}" required />
							</div>
						</div>

						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Email
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Email admin, contoh: andi@mail.com" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="email" placeholder="Email (Required & Unique)" class="form-control" value="{{$details['email']}}" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Type
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Fitur yang dapat diakses oleh admin, bisa lebih dari satu" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="type[]" class="form-control input-sm select2-multiple" multiple data-placeholder="Select at Least 1 Type (Required)" required>
									{{-- cek config enquiry dulu baru cek admin enquiry--}}
									@if(MyHelper::hasAccess([56], $configs))
										@if(MyHelper::hasAccess([9], $configs))
											<option @if($details['enquiry'] == "1") selected @endif value="enquiry">Enquiry</option>
										@endif
									@endif
									{{-- cek config pickup order dulu baru cek admin pickup--}}
									@if(MyHelper::hasAccess([12], $configs))
										@if(MyHelper::hasAccess([6], $configs))
											<option @if($details['pickup_order'] == "1") selected @endif value="pickup_order">Pickup Order</option>
										@endif
									@endif
									{{-- cek config delivery order dulu baru cek admin delivery --}}
									@if(MyHelper::hasAccess([13,15], $configs))
										@if(MyHelper::hasAccess([7], $configs))
											<option @if($details['delivery'] == "1") selected @endif value="delivery">Delivery</option>
										@endif
									@endif
									{{-- cek config manual payment dulu baru cek admin finance --}}
									@if(MyHelper::hasAccess([17], $configs))
										@if(MyHelper::hasAccess([8], $configs))
											<option @if($details['payment'] == "1") selected @endif value="delivery">Payment</option>
										@endif
									@endif
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center;">
						<input hidden name="level" value="Admin Outlet">
						{{ csrf_field() }}
						<button type="submit" class="btn blue">Update</button>
						<a href="{{url()->previous().'#admin'}}" class="btn default">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection