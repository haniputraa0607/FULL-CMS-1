@section('detail-info-content')
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
<div class="row">
	<div class="col-md-12">
		@if( $deals['deals_total_claimed'] == 0 )
	    <div class="row static-info">
	        <div class="col-md-11 value">
	            <a class="btn blue" href="{{ url('/'.$rpage)}}/step3/{{$deals['id_deals']}}">Edit Content</a>
	        </div>
	    </div>
	    @endif
		<div class="profile-info portlet light bordered">
		    <div class="row static-info">
	            <div class="col-md-4 name"> Description :</div>
	            <div class="col-md-8 value"></div>
	        </div>
	        <div class="row static-info">
	            <div class="col-md-6 value">{!! $deals['deals_description'] !!}</div>
	        </div>
	    </div>

		<div class="profile-info portlet light bordered">
	        <div class="row static-info">
	            <div class="col-md-4 name"> Content :</div>
	            <div class="col-md-8 value"></div>
	        </div>
			@php 
				$i = 1; 
				$count_content = count($deals['deals_content']); 
			@endphp
			@foreach ($deals['deals_content'] as $content)
				@if ($i == 1 || $i%3 == 1)
					<div class="row">
				@endif
				    <div class="col-md-4">
				        <div class="portlet portlet light bordered">
				        	<div class="portlet-title"> 
					        <span class="caption font-blue sbold uppercase">{{$content['title']}}</span>
					        @if ($content['is_active'] == 1)
					        	<span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;float: right;">Visible</span>
					        @else
					        	<span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;float: right;">Hidden</span>
					        @endif
					        </div>
				            <div class="portlet-body">
				            	@foreach ($content['deals_content_details'] as $content_detail)
					                <div class="row static-info">
					                    <div class="col-md-2 name">{{$content_detail['order']}}</div>
					                    <div class="col-md-10 value">{{$content_detail['content']}}</div>
					                </div>
				            	@endforeach
				            </div>
				        </div>
				    </div>
				@if ($i%3 == 0 || $count_content == $i)
					</div>
				@endif
				@php $i++ @endphp
			@endforeach
		</div>
	</div>
</div>
@endsection