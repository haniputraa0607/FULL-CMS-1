@extends('layouts.main')

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
	<link href="{{ secure_url('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ secure_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" /> 
@endsection

@section('page-plugin')
	<script src="{{ secure_url('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ secure_url('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script>
	$(document).ready(function(){
		$('.datatables').DataTable();
	});
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
</div><br>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">User Favorite</span>
				</div>
			</div>
			<div class="portlet-body form">
				<table class="table">
					<thead>
						<tr>
							<th>Created at</th>
							<th>Outlet</th>
							<th>Product</th>
							<th>Modifiers</th>
							<th>Notes</th>
						</tr>
					</thead>
					<tbody>
						@if($favorites['data']??false)
						@foreach($favorites['data'] as $favorite)
						<tr>
							<td>{{date('d M Y H:i',strtotime($favorite['created_at']))}}</td>
							<td>{{$favorite['outlet']['outlet_code']}} - {{$favorite['outlet']['outlet_name']}}</td>
							<td>{{$favorite['product']['product_code']}} - {{$favorite['product']['product_name']}}</td>
							<td>@if($favorite['modifiers'])<ul><li>{!!implode('</li><li>',array_column($favorite['modifiers'],'text'))!!}</li></ul>@else None @endif</td>
							<td>{{$favorite['notes']}}</td>
						</tr>
						@endforeach
						@else
						<tr>
							<td class="text-center text-muted" colspan="6"><em>No Favorites</em></td>
						</tr>
						@endif
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-offset-8 col-md-4 text-right" style="padding-left:0px;padding-right:0px;">
						<div class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
							<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
								<li class="page-first {{$favorites['prev_page_url']?'':'disabled'}}"><a href="{{$favorites['prev_page_url']?url()->current().'?page='.($favorites['current_page']-1):'javascript:void(0)'}}">«</a></li>
								<li class="page-last {{$favorites['next_page_url']?'':'disabled'}}"><a href="{{$favorites['next_page_url']?url()->current().'?page='.($favorites['current_page']+1):'javascript:void(0)'}}">»</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection