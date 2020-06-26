<div class="tab-pane" id="featured_deals">
    <div style="margin:20px 0">
        <a class="btn blue btn-outline sbold" data-toggle="modal" href="#modalFeaturedDeals"> New Featured Deals
        	<i class="fa fa-question-circle tooltips" data-original-title="Membuat featured deals di halaman home aplikasi mobile" data-container="body"></i>
        </a>
    </div>

	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">List Featured Deals</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="alert alert-warning">
					    <p> To arrange the order of deal, drag and drop on the deal in the order of the desired image.</p>
					</div>
					@if(!empty($featured_deals))
					<form action="{{ url('setting/featured_deal/reorder') }}" method="POST">
						<div class="clearfix" id="sortable2">
							@foreach ($featured_deals as $key => $featured_deal)
				 			<div class="portlet portlet-sortable light bordered col-md-3">
				 				<div class="portlet-title">
									<div class="row">
										<div class="col-md-2">
				 				  			<span class="caption-subject bold" style="font-size: 12px !important;">{{ $key + 1 }}</span>
										</div>
										<div class="col-md-10 text-right">
												<a class="btn blue btn-circle btn-edit" href="#modalFeaturedDealUpdate" data-toggle="modal" data-start-date="{{ date('d M Y H:i',strtotime($featured_deal['start_date'])) }}" data-end-date="{{ date('d M Y H:i',strtotime($featured_deal['end_date'])) }}" data-id-deals="{{ $featured_deal['id_deals'] }}" data-deals-title="{{ $featured_deal['deals']['deals_title'] }}" data-id="{{ $featured_deal['id_featured_deals'] }}"><i class="fa fa-pencil"></i> </a>
												<a class="btn red-mint btn-circle btn-delete" data-id="{{ $featured_deal['id_featured_deals'] }}"><i class="fa fa-trash-o"></i> </a>
										</div>
									</div>
				 				</div>
				 			 	<div class="portlet-body">
				 			   		<input type="hidden" name="id_featured_deals[]" value="{{ $featured_deal['id_featured_deals'] }}">
				 			   		<center><img src="{{ $featured_deal['deals']['url_deals_image'] }}" alt="FeaturedDeal Image" width="150"></center>
				 			 	</div>
				 			 	<div class="click-to text-center">
				 			 		<div>{{ $featured_deal['deals']['deals_title'] }}</div>
				 			 		<div>{!! date('d M Y H:i:s',strtotime($featured_deal['start_date']))."<br> - <br>".date('d M Y H:i:s',strtotime($featured_deal['end_date'])) !!}</div>
				 			 	</div>
				 			</div>
				 			@endforeach
						</div>
						<div class="text-center">
							{{ csrf_field() }}
							<input type="submit" value="Update Sorting" class="btn blue">
						</div>
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFeaturedDealUpdate" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Featured Deal</h4>
			</div>
			<div class="modal-body form">
				<br>
				<form role="form" action="{{url('setting/featured_deal/update')}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id_featured_deals" id="id_featured_deals">
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Deals</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<select class="select2 form-control" name="id_deals" id="id_deals" style="width: 100%">
									<option></option>
									@foreach($deals as $deal)
									<option value="{{$deal['id_deals']}}">{{$deal['id_deals'].' - '.$deal['deals_title']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Start Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="start_date" id="start_date">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>End Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="end_date" id="end_date">
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

<div class="modal fade" id="modalFeaturedDeals" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Create Featured Deal</h4>
			</div>
			<div class="modal-body form">
				<br>
				<form role="form" action="{{url('setting/featured_deal/create')}}" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Deals</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<select class="select2 form-control" name="id_deals" style="width: 100%">
									<option></option>
									@foreach($deals as $deal)
									<option value="{{$deal['id_deals']}}">{{$deal['id_deals'].' - '.$deal['deals_title']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Start Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="start_date">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>End Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="end_date">
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