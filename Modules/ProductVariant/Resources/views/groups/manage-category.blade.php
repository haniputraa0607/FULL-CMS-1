<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');

 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('.sample_1').dataTable({
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
                order: [2, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('product/delete') }}",
                data : "_token="+token+"&id_product="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Product has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete discount.");
                    }
                }
            });
        });

        $('#sample_1').on('switchChange.bootstrapSwitch', '.changeStatus', function(event, state) {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');
            var nama     = $(this).data('nama');

            if (state) {
              var change = "Visible";
            }
            else {
              var change = "Hidden";
            }

            $.ajax({
                type : "POST",
                url : "{{ url('product/update') }}",
                data : "_token="+token+"&id_product="+id+"&product_visibility="+change,
                success : function(result) {
                    if (result == "success") {
                        toastr.info("Product "+ nama +" has been updated.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to update data product.");
                    }
                }
            });
        });

        $('#sample_1').on('draw.dt', function() {
            $(".changeStatus").bootstrapSwitch();
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
                <span class="caption-subject sbold uppercase font-blue">List Product By Category</span>
            </div>
        </div>
        <div class="portlet-body">
			<div class="row">
			<form action="{{ url()->current() }}" method="post">
				<div class="col-md-3 col-sm-3 col-xs-3">
					<ul class="nav nav-tabs tabs-left">
						<li class="active">
							<a href="#tab_X" data-toggle="tab"> Uncategorized </a>
						</li>
						@foreach($categories??[] as $key => $cat)
							@if(empty($cat['child']))
								<li>
									<a href="#tab_{{$key}}" data-toggle="tab"> {{$cat['product_category_name']}} </a>
								</li>
							@else
							<li class="dropdown">
								<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> {{$cat['product_category_name']}}
									<i class="fa fa-angle-down"></i>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a href="#tab_{{$key}}" tabindex="-1" data-toggle="tab"> {{$cat['product_category_name']}} </a>
									</li>
									@foreach($cat['child'] as $keyC => $child)
									<li>
										<a href="#tab_{{$key}}_{{$keyC}}" tabindex="-1" data-toggle="tab"> {{$child['product_category_name']}} </a>
									</li>
									@endforeach
								</ul>
							</li>
							@endif
						@endforeach
					</ul>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
					<div class="tab-content">
						<div class="tab-pane active" id="tab_X">
							<table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
								<thead>
									<tr>
										<th> Code </th>
										<th> Name </th>
										<th> Category </th>
									</tr>
								</thead>
								<tbody>
									@foreach($products as $value)
										@if(!in_array($value['id_product_category'],$all_category))
										<tr>
											<td>{{ $value['product_group_code'] }}</td>
											<td>{{ $value['product_group_name'] }}</td>
											<td style="width: 150px;">
												<select id="multiple" class="form-control select2-multiple" name="id_product_category[{{ $value['id_product_group'] }}]" data-placeholder="select category" required>
													<optgroup label="Category List">
														<option value="0">Uncategorize</option>
														@foreach($categories??[] as $suw)
															<option value="{{ $suw['id_product_category'] }}">{{ $suw['product_category_name'] }}</option>
															@foreach ($suw['child']??[] as $child)
																<option value="{{ $child['id_product_category'] }}" data-ampas="{{ $child['product_category_name'] }}">&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
															@endforeach
														@endforeach
													</optgroup>
												</select>
											</td>
										</tr>
										@endif
									@endforeach
								</tbody>
							</table>
						</div>
						@foreach($categories??[] as $key => $cat)
							@if(empty($cat['child']))
								<div class="tab-pane" id="tab_{{$key}}">
									<table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
										<thead>
											<tr>
												<th> Code </th>
												<th> Name </th>
												<th> Category </th>
											</tr>
										</thead>
										<tbody>
											@foreach($products??[] as $value)
												@if ($value['id_product_category'] == $cat['id_product_category'])
												<tr>
													<td>{{ $value['product_group_code'] }}</td>
													<td>{{ $value['product_group_name'] }}</td>
													<td style="width: 150px;">
														<input name="id_product_group[]" value="{{ $value['id_product_group'] }}" type="hidden">
														<select id="multiple" class="form-control select2-multiple" name="id_product_category[{{ $value['id_product_group'] }}]" data-placeholder="select category" required>
															<optgroup label="Category List">
																<option value="0">Uncategorize</option>
																@foreach($categories as $suw)
																	@if ($suw['id_product_category'] == $value['id_product_category'])
																		<option value="{{ $suw['id_product_category'] }}" selected>{{ $suw['product_category_name'] }}</option>
																	@else
																		<option value="{{ $suw['id_product_category'] }}">{{ $suw['product_category_name'] }}</option>
																	@endif
																	@if (!empty($suw['child']))
																		@foreach ($suw['child'] as $child)
																			@if ($child['id_product_category'] == $value['id_product_category'])
																			<option value="{{ $child['id_product_category'] }}" data-ampas="{{ $child['product_category_name'] }}" selected>&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
																			@else
																			<option value="{{ $child['id_product_category'] }}" data-ampas="{{ $child['product_category_name'] }}">&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
																			@endif
																		@endforeach
																	@endif
																@endforeach
															</optgroup>
														</select>
													</td>
												</tr>
												@endif
											@endforeach
										</tbody>
									</table>
								</div>
							@else
								<div class="tab-pane" id="tab_{{$key}}">
									<table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
										<thead>
											<tr>
												<th> Code </th>
												<th> Name </th>
												<th> Category </th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($product))
												@foreach($product as $value)
													@if (($value['category'][0]['id_product_category']??false) == $cat['id_product_category'])
													<tr>
														<td>{{ $value['product_group_code'] }}</td>
														<td>{{ $value['product_group_name'] }}</td>

														@if(MyHelper::hasAccess([49,51,52], $grantedFeature))
															<td style="width: 150px;">
																<input name="id_product_group[]" value="{{ $value['id_product_group'] }}" type="hidden">
																<select id="multiple" class="form-control select2-multiple" name="id_product_category[{{ $value['id_product_group'] }}]" data-placeholder="select category" required>
																	<optgroup label="Category List">
																		<option value="0">Uncategorize</option>
																		@if (!empty($categories))
																			@foreach($categories as $suw)
																				@if ($suw['id_product_category'] == ($value['category'][0]['id_product_category']??false))
																					<option value="{{ $suw['id_product_category'] }}" selected>{{ $suw['product_category_name'] }}</option>
																				@else
																					<option value="{{ $suw['id_product_category'] }}">{{ $suw['product_category_name'] }}</option>
																				@endif
																				@if (!empty($suw['child']))
																					@foreach ($suw['child'] as $child)
																						@if ($child['id_product_category'] == ($value['category'][0]['id_product_category']??false))
																						<option value="{{ $child['id_product_category'] }}" data-ampas="{{ $child['product_category_name'] }}" selected>&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
																						@else
																						<option value="{{ $child['id_product_category'] }}" data-ampas="{{ $child['product_category_name'] }}">&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
																						@endif
																					@endforeach
																				@endif
																			@endforeach
																		@endif
																	</optgroup>
																</select>
															</td>
														@endif
													</tr>
													@endif
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
								@foreach($cat['child'] as $keyC => $child)
								<div class="tab-pane" id="tab_{{$key}}_{{$keyC}}">
									<table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
										<thead>
											<tr>
												<th> Code </th>
												<th> Name </th>
												<th> Category </th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($product))
												@foreach($product as $value)
													@if (($value['category'][0]['id_product_category']??false) == $child['id_product_category'])
													<tr>
														<td>{{ $value['product_group_code'] }}</td>
														<td>{{ $value['product_group_name'] }}</td>

														@if(MyHelper::hasAccess([49,51,52], $grantedFeature))
															<td style="width: 150px;">
																<input name="id_product_group[]" value="{{ $value['id_product_group'] }}" type="hidden">
																<select id="multiple" class="form-control select2-multiple" name="id_product_category[{{ $value['id_product_group'] }}]" data-placeholder="select category" required>
																	<optgroup label="Category List">
																		<option value="0">Uncategorize</option>
																		@if (!empty($category))
																			@foreach($category as $suw)
																				@if ($suw['id_product_category'] == ($value['category'][0]['id_product_category']??false))
																					<option value="{{ $suw['id_product_category'] }}" selected>{{ $suw['product_category_name'] }}</option>
																				@else
																					<option value="{{ $suw['id_product_category'] }}">{{ $suw['product_category_name'] }}</option>
																				@endif
																				@if (!empty($suw['child']))
																					@foreach ($suw['child'] as $child)
																						@if ($child['id_product_category'] == ($value['category'][0]['id_product_category']??false))
																						<option value="{{ $child['id_product_category'] }}" data-ampas="{{ $child['product_category_name'] }}" selected>&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
																						@else
																						<option value="{{ $child['id_product_category'] }}" data-ampas="{{ $child['product_category_name'] }}">&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
																						@endif
																					@endforeach
																				@endif
																			@endforeach
																		@endif
																	</optgroup>
																</select>
															</td>
														@endif
													</tr>
													@endif
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
								@endforeach
							@endif
						@endforeach
					</div>
				</div>
			</div>
			<div class="row">
			{{ csrf_field() }}
				<div class="col-md-offset-5 col-md-6">
					<button type="submit" class="btn blue">Update Data</button>
				</div>
			</div>
			</form>
		</div>
	</div>


@endsection