@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		$('.select2').select2();
		$('#outlet_selector').on('change',function(){
			var value = $(this).val();
            if(value == '0'){
                value = '';
            }
			window.location.href = "{{url('user-rating')}}/"+value;
		});
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">List Rating</span>
            </div>
            <div class="actions">
                <div class="btn-group" style="width: 300px">
                   <select class="form-control select2-multiple select2" name="outlet_code" id="outlet_selector" data-placeholder="Select Outlet">
                   	<option></option>
                   	<option value="0" @if(!$key) selected @endif>All Outlet</option>
		            @if ($outlets??false)
		                @foreach($outlets as $outlet)
		                    <option value="{{ $outlet['outlet_code'] }}" @if ($outlet['outlet_code'] == $key) selected @endif>{{ $outlet['outlet_code'] }} - {{ $outlet['outlet_name'] }}</option>
		                @endforeach
		            @endif
				    </select>
                </div>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="rating_table">
                <thead>
                    <tr>
                        <th> Create Rating Date </th>
                        <th> Receipt Number </th>
                        <th> User </th>
                        <th> Grand Total </th>
                        <th> Star </th>
                        <th> Selected Options </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                	@if($ratingData['data'])
                	@foreach($ratingData['data'] as $rating)
                	<tr>
                		<td>{{date('d M Y',strtotime($rating['created_at']))}}</td>
                		<td><a href="{{url('transaction/detail'.'/'.$rating['transaction']['id_transaction'].'/'.strtolower($rating['transaction']['trasaction_type']))}}">{{$rating['transaction']['transaction_receipt_number']}}</a></td>
                		<td><a href="{{url('user/detail'.'/'.$rating['user']['phone'])}}">{{$rating['user']['name']}}</a></td>
                		<td>Rp {{number_format($rating['transaction']['transaction_grandtotal'],0,',','.')}}</td>
                		<td>{{$rating['rating_value']}}</td>
                        <td>{{$rating['option_value']}}</td>
                		<td><a href="{{url('user-rating/detail/'.$rating['id_user_rating'])}}" class="btn blue">Detail</a></td>
                	</tr>
                	@endforeach
                	@else
                	<tr>
                		<td colspan="6" class="text-center"><em class="text-muted">No Rating Found</em></td>
                	</tr>
                	@endif
                </tbody>
            </table>
            <div class="col-md-offset-8 col-md-4 text-right">
                <div class="pagination">
                    <ul class="pagination">
                         <li class="page-first{{$prev_page?'':' disabled'}}"><a href="{{$prev_page?:'javascript:void(0)'}}">«</a></li>
                        
                         <li class="page-last{{$next_page?'':' disabled'}}"><a href="{{$next_page?:'javascript:void(0)'}}">»</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection