@extends('layouts.main')

@section('page-style')
@endsection

@section('page-plugin')
@endsection

@section('page-script')
	<script>
		$('.table-scrollable').on('show.bs.dropdown', function () {
			$('.table-scrollable').css( "overflow", "inherit" );
		});

		$('.table-scrollable').on('hide.bs.dropdown', function () {
			$('.table-scrollable').css( "overflow", "auto" );
		})
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
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Campaign List</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:20px;margin-bottom:15px">
					<div class="col-md-6" style="padding: 0px;">
						<form action="" method="POST">
						<input type="text" class="form-control" name="campaign_title" placeholder="Search Campaign Title" @if(isset($post['campaign_title']) && $post['campaign_title'] != "") value = "{{$post['campaign_title']}}" @endif>
					</div>
					<div class="col-md-1" style="padding: 0px;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Search</button>
						</form>
					</div>
					<div class="col-md-1" style="padding: 0px;">
						@if(isset($post['campaign_title']) && $post['campaign_title'] != "")<a href="{{url('campaign')}}" class="btn red">Reset Search</a>@endif
					</div>
					<div class="col-md-4" style="padding: 0px;">
						<div class="pull-right pagination" style="margin-top: 0px;margin-bottom: 0px;">
							<ul class="pagination" style="margin-top: 0px;margin-bottom: 0px;">
							@if(isset($post['campaign_title']) && $post['campaign_title'] != "")
							@else
								@if($post['skip'] > 0)
									<li class="page-first"><a href="{{url('campaign')}}/page/{{(($post['skip'] + $post['take'])/$post['take'])-1}}">«</a></li>
								@else
									<li class="page-first disabled"><a href="javascript:void(0)">«</a></li>
								@endif
								
								@if(isset($count) && $count > (($post['skip']+1) * $post['take']))
									<li class="page-last"><a href="{{url('campaign')}}/page/{{(($post['skip'] + $post['take'])/$post['take'])+1}}">»</a></li>
								@else
									<li class="page-last disabled"><a href="javascript:void(0)">»</a></li>
								@endif
							
							@endif
							</ul>
						</div>
					</div>
				</div>
				<div class="table-scrollable">
					@if(isset($result) && $result != '')
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Title</th>
								<th>Send At</th>
								<th>Media (All | Sent)</th>
								<th width=10%>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $key => $data)
							<tr>
								<td>{{(($post['skip'] + $post['take']) - $post['take'])+($key+1)}}</td>
								<td>{{$data['campaign_title']}}</td>
								<td>@if($data['campaign_send_at'] != "")
										{{date('d F Y - H:i', strtotime($data['campaign_send_at']))}}
									@else
										{{date('d F Y - H:i', strtotime($data['created_at']))}}
									@endif</td>
								<td>
									<ul>
										@if($data['campaign_media_email'] == 'Yes')<li> Email ({{$data['campaign_email_count_all']}} | {{$data['campaign_email_count_sent']}}) </li> @endif
										@if($data['campaign_media_sms'] == 'Yes')<li> SMS ({{$data['campaign_sms_count_all']}} | {{$data['campaign_sms_count_sent']}})</li> @endif
										@if($data['campaign_media_push'] == 'Yes')<li> Push ({{$data['campaign_push_count_all']}} | {{$data['campaign_push_count_sent']}})</li> @endif
										@if($data['campaign_media_inbox'] == 'Yes')<li> Inbox ({{$data['campaign_inbox_count']}})</li> @endif
										@if($data['campaign_media_whatsapp'] == 'Yes')<li> WhatsApp ({{$data['campaign_whatsapp_count_all']}})</li> @endif
									</ul>
								</td>
								<td>
									<div class="btn-group pull-right">
										<button class="btn blue btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Actions
										<i class="fa fa-angle-down"></i>
										</button> 
										<ul class="dropdown-menu pull-right">
											@if($data['campaign_is_sent'] != 'Yes')
											<li>
												<a href="{{ url('campaign/step1') }}/{{ $data['id_campaign'] }}">
												<i class="fa fa-edit"></i> Edit Information </a>
											</li>
											<li>
												<a href="{{ url('campaign/step2') }}/{{ $data['id_campaign'] }}">
												<i class="fa fa-edit"></i> Edit Receipient </a>
											</li>
											@endif
											<li>
												<a href="{{ url('campaign/step3') }}/{{ $data['id_campaign'] }}">
												<i class="fa fa-gear"></i> Summary </a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
						No User found with such conditions
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection