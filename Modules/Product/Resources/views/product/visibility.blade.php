@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        var idVisibility = [];
        // get selected from session
        @foreach($id_visibility as $idVis)
            @if($idVis != "")
                idVisibility.push("{{$idVis}}")
            @endif
        @endforeach

        // action for product checked
		function checkProduct(element){
			if(element.checked == true){
				idVisibility.push(element.value)
			}else{
				const index = idVisibility.indexOf(element.value);
				if (index !== -1) {
					idVisibility.splice(index, 1);
				}
			}
		}

        // action for checkbox all
		function checkAll(element, type = null){
            var checked = element.checked
			$('.check-visibility').each(function(index, item) {
				item.checked = checked
				checkProduct(item)
            })

            // for select all product in 1 outlet
			if(type == 'allProduct'){
                $('.btn-submit').prop('disabled', true);
                $('input').prop('disabled', true);
                $('#checkboxAll').prop('checked', checked);
                if(!checked) $('#allOutlet').prop('checked', checked);

                // add all product to session
                var token  = "{{ csrf_token() }}";
                $.ajax({
                    type : "POST",
                    url : "{{ url('product/id_visibility') }}",
                    data : "_token="+token+"&key={{$key}}&allProduct=true&visibility={{$visibility}}&checked="+checked,
                    success : function(result) {
                        console.log(result)
                        $('.btn-submit').prop('disabled', false);
                        $('input').prop('disabled', false);
                    }
                });
            }

            // for select all product in all outlet
			else if(type == 'allOutlet'){
                $('.btn-submit').prop('disabled', true);
                $('input').prop('disabled', true);
                $('#checkboxAll').prop('checked', checked);
                $('#allProduct').prop('checked', checked);

                // add all product to session
                var token  = "{{ csrf_token() }}";
                $.ajax({
                    type : "POST",
                    url : "{{ url('product/id_visibility') }}",
                    data : "_token="+token+"&key={{$key}}&allOutlet=true&visibility={{$visibility}}&checked="+checked,
                    success : function(result) {
                        $('.btn-submit').prop('disabled', false);
                        $('input').prop('disabled', false);
                    }
                });
            }
            // for select all product in this page
            else{
                if(!checked) {
                    $('#allOutlet').prop('checked', checked);
                    $('#allproduct').prop('checked', checked);
                }
            }
		}

        // action for change outlet
		$("#multiple").change(function() {
        	var id = $(this).val();
            var url = '{{ url("product/".lcfirst($visibility)) }}/'+id;
            var token  = "{{ csrf_token() }}";

            // add selected product to session
				$.ajax({
					type : "POST",
					url : "{{ url('product/id_visibility') }}",
					data : "_token="+token+"&id_visibility="+idVisibility+"&key={{$key}}&page={{$page}}&checked=true",
					success : function(result) {
                        // redirect after success
						window.location = url;
					}
				});
		});

        // action for change page
        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var token  = "{{ csrf_token() }}";

            // add selected product to session
            $.ajax({
                type : "POST",
                url : "{{ url('product/id_visibility') }}",
                data : "_token="+token+"&id_visibility="+idVisibility+"&key={{$key}}&page={{$page}}&checked=true",
                success : function(result) {
                    // redirect after success
                    window.location = url;
                }
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
                <span class="caption-subject sbold uppercase font-blue">{{ucfirst($visibility)}} Product List</span>
            </div>
            <div class="actions">
                <div class="btn-group" style="width: 300px">
                   <select id="multiple" class="form-control select2-multiple" name="id_outlet" data-placeholder="select outlet">
				        <optgroup label="Outlet List">
				            @if (!empty($outlet))
				                @foreach($outlet as $suw)
				                    <option value="{{ $suw['id_outlet'] }}" @if ($suw['id_outlet'] == $key) selected @endif>{{ $suw['outlet_name'] }}</option>
				                @endforeach
				            @endif
				        </optgroup>
				    </select>
                </div>
            </div>
        </div>
        @if (!empty($outlet))
        	@foreach ($outlet as $row => $data)
        		@if ($data['id_outlet'] == $key)
        			<div class="portlet-body form">
			            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
                            @if (!empty($product))

							<input type="hidden" name="page" value="{{$page}}">
                            <input type="hidden" name="visibility" value="{{$visibility}}">
							<input type="hidden" name="key" value="{{$key}}">
							<div class="form-group">
								<label class="col-md-5 control-label" style="padding:0">Select All Product in All Outlet</label>
								<div class="col-md-1">
									<div class="md-checkbox">
										<input type="checkbox" id="allOutlet" onclick="checkAll(this, 'allOutlet')" class="md-checkboxbtn" @if(isset($allOutlet) && $allOutlet == true) checked @endif>
										<label for="allOutlet">
											<span></span>
											<span class="check"></span>
											<span class="box"></span></label>
											</label>
									</div>
								</div>
								<label class="col-md-3 control-label" style="padding:0">Select All Product in This Outlet</label>
								<div class="col-md-1">
									<div class="md-checkbox">
										<input type="checkbox" id="allProduct" onclick="checkAll(this, 'allProduct')" class="md-checkboxbtn" @if((isset($allOutlet) && $allOutlet == true) || (isset($allProduct) && $allProduct == true)) checked @endif>
										<label for="allProduct">
											<span></span>
											<span class="check"></span>
											<span class="box"></span></label>
											</label>
									</div>
								</div>
								<label class="col-md-1 control-label" style="padding:0">Select All</label>
								<div class="col-md-1">
									<div class="md-checkbox">
										<input type="checkbox" id="checkboxAll" onclick="checkAll(this)" class="md-checkboxbtn" @if(count($id_visibility) >= 10 ||count($id_visibility) == $total) checked @endif>
										<label for="checkboxAll">
											<span></span>
											<span class="check"></span>
											<span class="box"></span></label>
											</label>
									</div>
								</div>
                            </div>
                            @endif
							<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
								<thead>
									<tr>
										<th> Code </th>
										<th> Category </th>
										<th> Name </th>
										<th>

										</th>
									</tr>
								</thead>
								<tbody>
									@if (!empty($product))
										@foreach ($product as $col => $pro)
											<tr>
                                                <td> {{ $pro['product_code'] }} </td>
                                                @if (empty($pro['category']))
                                                    <td>Uncategorize</td>
                                                @else
                                                    <td>{{ $pro['category'][0]['product_category_name'] }}</td>
                                                @endif
                                                <td> {{ $pro['product_name'] }} </td>
                                                <td style="width:10px">
                                                    <div class="md-checkbox">
                                                        <input type="checkbox" id="checkbox{{$pro['id_product']}}" name="id_visibility[]" onchange="checkProduct(this)" class="md-checkboxbtn check-visibility" value="{{$pro['id_product'].'/'.$key}}" @if(in_array($pro['id_product'].'/'.$key,$id_visibility)) checked @endif>
                                                        <label for="checkbox{{$pro['id_product']}}">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span></label>
                                                        </label>
                                                    </div>
                                                </td>
											</tr>
										@endforeach
                                    @else
                                        <tr><td colspan="4" style="text-align: center">There is no {{lcfirst($visibility)}} product in this outlet</td></tr>
                                    @endif
								</tbody>
							</table>
							{{ csrf_field() }}
							<div class="row">
                                @if (!empty($product))
                                <div class="col-md-10">
                                @if ($paginator)
                                    {{ $paginator->links() }}
                                @endif
                                </div>
                                <div class="col-md-2">
                                    @if($visibility == 'Visible')
                                    <button type="submit" class="btn blue btn-submit" style="margin:10px 0">Hide Product</button>
                                    @else
                                    <button type="submit" class="btn blue btn-submit" style="margin:10px 0">Show Product</button>
                                    @endif
                                </div>
                                @endif
                            </div>
						</form>
			        </div>
        		@endif
        	@endforeach
        @endif
    </div>
@endsection
