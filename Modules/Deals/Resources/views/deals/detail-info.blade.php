@section('detail-info')
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
<div class="row">
    <div class="col-md-5">
        <div class="portlet profile-info portlet light bordered">
            <div class="portlet sale-summary">
                <div class="portlet-body">
                    <ul class="list-unstyled">
                        <li>
                            <span class="sale-info"> Status 
                                <i class="fa fa-img-up"></i>
                            </span>
                            @if( empty($deals['step_complete']) )
                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #F4D03F;padding: 5px 12px;color: #fff;">Not Complete</span>
                            @elseif(!empty($deals['deals_end']) && strtotime($deals['deals_end']) < strtotime($datenow))
                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;">Ended</span>
                            @elseif(!empty($deals['deals_start']) && strtotime($deals['deals_start']) <= strtotime($datenow))
                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
                            @elseif(!empty($deals['deals_start']) && strtotime($deals['deals_start']) > strtotime($datenow))
                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Not Started</span>
                            @else
                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
                            @endif
                        </li>
                        <li>
                            <span class="sale-info"> Creator 
                                <i class="fa fa-img-up"></i>
                            </span>
                            <span class="font-black sale-num sbold">
                                {{$deals['created_by_user']['name']??''}}
                            </span>
                        </li>
                        <li>
                            <span class="sale-info"> Level
                                <i class="fa fa-img-up"></i>
                            </span>
                            <span class="sale-num font-black">
                                {{$deals['created_by_user']['level']??''}}
                            </span>
                        </li>
                        @if($deals_type == 'Deals')
                        <li>
                            <span class="sale-info"> Deals Price
                                <i class="fa fa-img-up"></i>
                            </span>
                            <span class="sale-num font-black">
                            	@if($deals['deals_voucher_price_type'] == 'free')
                            		{{ $deals['deals_voucher_price_type'] }}
                            	@elseif(!empty($deals['deals_voucher_price_point']))
                            		{{ number_format($deals['deals_voucher_price_point']).' Points' }}
                            	@elseif(!empty($deals['deals_voucher_price_cash']))
                            		{{ 'IDR'.number_format($deals['deals_voucher_price_cash']) }}
                            	@endif
                            </span>
                        </li>
                        @endif
                        <li>
                            <span class="sale-info"> Deals Type
                                <i class="fa fa-img-up"></i>
                            </span>
                            <span class="sale-num font-black">
                            	@if (!empty($deals['is_online']) && !empty($deals['is_offline']))
                        			{{'Online, Offline'}}
                        		@elseif (!empty($deals['is_online']))
                        			{{'Online'}}
                        		@elseif (!empty($deals['is_offline']))
                        			{{'Offline'}}
                        		@endif
                            	<ul>
                            	</ul>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="portlet-body">
            @if($deals_type != 'WelcomeVoucher' && $deals_type != 'Promotion')
                @if(isset($deals['deals_start']))
                <div class="row static-info">
                    <div class="col-md-4 name">Start</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($deals['deals_start']))}}&nbsp;{{date("H:i", strtotime($deals['deals_start']))}}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">End</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($deals['deals_end']))}}&nbsp;{{date("H:i", strtotime($deals['deals_end']))}}</div>
                </div>
                @endif
                @if($deals_type != 'Hidden')
                @if(isset($deals['deals_end']))
                <div class="row static-info">
                    <div class="col-md-4 name">Publish Start</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($deals['deals_publish_start']))}}&nbsp;{{date("H:i", strtotime($deals['deals_publish_start']))}}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Publish End</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($deals['deals_publish_end']))}}&nbsp;{{date("H:i", strtotime($deals['deals_publish_end']))}}</div>
                </div>
                @endif
                @endif
            @endif
                <div class="row static-info">
                    <div class="col-md-4 name">Created</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($deals['created_at']))}}&nbsp;{{date("H:i", strtotime($deals['created_at']))}}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Product Type</div>
                    <div class="col-md-8 value">: {{ $deals['product_type']??'' }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Total Voucher</div>
                    <div class="col-md-8 value">: {{ !empty($deals['deals_total_voucher']) ? number_format($deals['deals_total_voucher']).' Vouchers' : (isset($deals['deals_total_voucher']) ? 'unlimited' : '') }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Used Voucher</div>
                    <div class="col-md-8 value">: {{ number_format($deals['deals_total_used']??0).' Vouchers' }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">User Limit</div>
                    <div class="col-md-8 value">: {{ $deals['user_limit']??false ? number_format($deals['user_limit']).' Times usage' : 'Unlimited' }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Voucher Expiry</div>
                    <div class="col-md-8 value">: {{ ($deals['deals_voucher_duration']??false) ? 'By Duration ( '.number_format($deals['deals_voucher_duration']).' Days )' : (($deals['deals_voucher_expired']??false) ? 'By Date ( '.date("d M Y", strtotime($deals['deals_voucher_expired'])).' '.date("H:i", strtotime($deals['deals_voucher_expired'])).' )' : '-') }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Voucher Start</div>
                    <div class="col-md-8 value">: {{ $deals['deals_voucher_start']??false ? date("d M Y", strtotime($deals['deals_voucher_start'])) : '-' }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Image</div>
                    <div class="col-md-8 value">
                    	<span style="float: left;margin-right: 5px">:</span> 
                    	<div><img src="{{ env('S3_URL_VIEW').$deals['deals_image'] }}" style="width: 100px"></div>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Warning Image</div>
                    <div class="col-md-8 value">
                    	<span style="float: left;margin-right: 5px">:</span> 
                    	<div>@if(empty($deals['deals_warning_image'])) Use Global @else <img src="{{ env('S3_URL_VIEW').$deals['deals_warning_image'] }}" style="width: 100px">@endif</div>
                	</div>
                </div>
                
            @if( $deals_type == 'Promotion' || $deals['deals_total_claimed'] == 0 )
            <div class="row static-info text-center">
                <div class="col-md-11 value">
                    <a class="btn blue" href="{{ url('/'.$rpage)}}/step1/{{$deals['id_deals']}}">Edit Detail</a>
                </div>
            </div>
            @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-7 profile-info">
    	@if (!empty($deals['is_offline']))
	    	<div class="profile-info portlet light bordered">
	            <div class="portlet-title"> 
	            <span class="caption font-blue sbold uppercase"> Voucher Offline Rules </span>
	            </div>
	            @if ( !empty($deals['deals_promo_id_type']) )
	                
	                <div class="row static-info">
	                    <div class="col-md-4 name">
	                    	@if ($deals['deals_promo_id_type'] == 'promoid')
	                    		{{ 'Promo Id' }}
	                    	@else
	                    		{{ 'Nominal' }}
	                    	@endif
	                    </div>
	                    <div class="col-md-8 value">: 
	                    	@if (isset($deals['deals_promo_id']))
	                    		@if (is_integer($deals['deals_promo_id']))
	                    			{{ number_format($deals['deals_promo_id']) }}
	                    		@else
	                    			{{ $deals['deals_promo_id'] }}
	                    		@endif
	                    		{{-- expr --}}
	                    	@endif
	                    </div>
	                </div>

	                @if( $deals_type == 'Promotion' || $deals['deals_total_claimed'] == 0 )
	                <div class="row static-info">
	                    <div class="col-md-11 value">
	                        <a class="btn blue" href="{{ url('/'.$rpage)}}/step2/{{$deals['id_deals']}}">Edit Rule</a>
	                    </div>
	                </div>
	                @endif
	            @else
	            <span class="sale-num font-red sbold">
	                No Deals Rules
	            </span>
	            @if( $deals_type == 'Promotion' || $deals['deals_total_claimed'] == 0 )
	            <div class="row static-info">
	                <div class="col-md-11 value">
	                    <a class="btn blue" href="{{ url('/'.$rpage)}}/step2/{{$deals['id_deals']}}">Create Rule</a>
	                </div>
	            </div>
	            @endif
	            @endif
	        </div>
    	@endif

    	@if (!empty($deals['is_online']))
        <div class="profile-info portlet light bordered">
            <div class="portlet-title"> 
            <span class="caption font-blue sbold uppercase">Voucher Online Rules : {{ $deals['promo_type']??'' }}</span>
            </div>
            @if ( 
            		!empty($deals['deals_product_discount_rules']) || 
            		!empty($deals['deals_tier_discount_rules']) || 
            		!empty($deals['deals_buyxgety_rules']) ||
            		!empty($deals['deals_promotion_product_discount_rules']) || 
            		!empty($deals['deals_promotion_tier_discount_rules']) || 
            		!empty($deals['deals_promotion_buyxgety_rules']) 
            	)
                @if (isset($deals['deals_product_discount_rules']) && $deals['deals_product_discount_rules'] != null)
                    <div class="row static-info">
                        <div class="col-md-4 name">Product Requirement</div>
                        <div class="col-md-8 value">: 
                            @if ($deals['deals_product_discount_rules'] != null)
                                @if ($deals['deals_product_discount_rules']['is_all_product'] == '1')
                                    All Product
                                @elseif ($deals['deals_product_discount_rules']['is_all_product'] == '0')
                                    Selected Product
                                @else
                                    No Product Requirement
                                @endif
                            @elseif ($deals['deals_tier_discount_rules'] != null)
                                {{$deals['deals_tier_discount_product']['product']['product_name']}}
                            @elseif ($deals['deals_buyxgety_rules'] != null)
                                {{$deals['deals_buyxgety_product_requirement']['product']['product_name']??''}}
                            @endif
                        </div>
                    </div>
                    @if ($deals['deals_product_discount_rules'] != null)
                    <div class="row static-info">
                        <div class="col-md-4 name">Discount</div>
                        <div class="col-md-8 value">: 
                            @if ($deals['deals_product_discount_rules']['discount_type'] == 'Percent')
                                {{$deals['deals_product_discount_rules']['discount_value']}} % {{ !empty($deals['deals_product_discount_rules']['max_percent_discount']) ? '(Max : IDR '.number_format($deals['deals_product_discount_rules']['max_percent_discount']).') ' : '' }}
                            @elseif ($deals['deals_product_discount_rules']['discount_type'] == 'Nominal')
                                {{ 'IDR '.number_format($deals['deals_product_discount_rules']['discount_value']) }}
                            @else
                                No discount
                            @endif
                        </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-4 name">Max Product</div>
                        <div class="col-md-8 value">: 
                                {{ ($deals['deals_product_discount_rules']['max_product'] == 0) ? 'no limit' : number_format($deals['deals_product_discount_rules']['max_product']).' item' }}
                        </div>
                    </div>
                    @endif
                    <div class="mt-comments">
                        @if ($deals['deals_product_discount_rules'] != null)
                            @if(isset($deals['deals_product_discount_rules']['is_all_product']) && $deals['deals_product_discount_rules']['is_all_product'] == '0')
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($deals['deals_product_discount'] as $res)
                                            <tr>
                                                <td>{{ $res['product']['product_code']??$res['product_group']['product_group_code']??'' }}</td>
                                                <td>
                                                @if (!empty($res['product_group']))
                                                	<a href="{{ url('product-variant/group/'.($res['product_group']['id_product_group']??'')) }}">{{ $res['product_group']['product_group_name']??'' }}</a>
                                                @else
                                                	<a href="{{ url('product/detail/'.($res['product']['product_code']??'')) }}">{{ $res['product']['product_name']??'' }}</a>	
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endif
                    </div>
                @elseif (isset($deals['deals_tier_discount_rules']) && $deals['deals_tier_discount_rules'] != null)
                    <div class="row static-info">
                        <div class="col-md-4 name">Product Requirement</div>
                        <div class="col-md-8 value">: 
                            @if ( isset($deals['deals_tier_discount_product']) )
                            	@if (!empty($deals['deals_tier_discount_product']['product_group']))
                                	<a href="{{ url('product-variant/group/'.$deals['deals_tier_discount_product']['product_group']['id_product_group']??'') }}">{{ ($deals['deals_tier_discount_product']['product_group']['product_group_code']??'').' - '.($deals['deals_tier_discount_product']['product_group']['product_group_name']??'') }}</a>
                                @else
                            		<a href="{{ url('product/detail/'.$deals['deals_tier_discount_product']['product']['product_code']??'') }}">{{ ($deals['deals_tier_discount_product']['product']['product_code']??'').' - '.($deals['deals_tier_discount_product']['product']['product_name']??'') }}</a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_6">
                        <thead>
                            <tr>
                                <th>Min Qty</th>
                                <th>Max Qty</th>
                                <th>{{ ($deals['deals_tier_discount_rules'][0]['discount_type']??'').' Discount' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deals['deals_tier_discount_rules'] as $res)
                                <tr>
                                    <td>{{ number_format($res['min_qty']) }}</td>
                                    <td>{{ number_format($res['max_qty']) }}</td>
                                    <td>{{ ($deals['deals_tier_discount_rules'][0]['discount_type'] == 'Percent') ? ( $res['discount_value'].' % (Max : IDR '.number_format($res['max_percent_discount']).')' ) : ('IDR '.number_format($res['discount_value'])) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif (isset($deals['deals_buyxgety_rules']) && $deals['deals_buyxgety_rules'] != null)
                    <div class="row static-info">
                        <div class="col-md-4 name">Product Requirement</div>
                        <div class="col-md-8 value">: 
                            @if ( isset($deals['deals_buyxgety_product_requirement']) )
                            	@if (!empty($deals['deals_buyxgety_product_requirement']['product_group']))
                                	<a href="{{ url('product-variant/group/'.$deals['deals_buyxgety_product_requirement']['product_group']['id_product_group']??'') }}">{{ ($deals['deals_buyxgety_product_requirement']['product_group']['product_group_code']??'').' - '.($deals['deals_buyxgety_product_requirement']['product_group']['product_group_name']??'') }}</a>
                                @else
                            		<a href="{{ url('product/detail/'.$deals['deals_buyxgety_product_requirement']['product']['product_code']??'') }}">{{ ($deals['deals_buyxgety_product_requirement']['product']['product_code']??'').' - '.$deals['deals_buyxgety_product_requirement']['product']['product_name']??'' }}</a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_7">
                        <thead>
                            <tr>
                                <th>Min Qty</th>
                                <th>Max Qty</th>
                                <th>Product Benefit</th>
                                <th>Benefit Qty</th>
                                <th>Benefit Discount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deals['deals_buyxgety_rules'] as $res)
                                <tr>
                                    <td>{{ $res['min_qty_requirement'] }}</td>
                                    <td>{{ $res['max_qty_requirement'] }}</td>
                                    <td>
                                    	<a href="{{ url('product/detail/'.$res['product']['product_code']??'') }}">{{ $res['product']['product_code'].' - '.$res['product']['product_name'] }}</a>
                                    <td>{{ $res['benefit_qty'] }}</td>
                                    <td>
                                    @if( ($res['discount_type']??false) == 'nominal' )
                                    	{{'IDR '.number_format($res['discount_value'])}}
                                    @elseif( ($res['discount_type']??false) == 'percent' )
                                    	@if( ($res['discount_value']??false) == 100 )
                                    		Free
                                		@else
                                    		{{ ($res['discount_value']??false).'% (Max : IDR '.number_format($res['max_percent_discount']).')' }}
                                    	@endif
                                    @endif
	                                    </td>
	                                    <td>
	                                    {{ ( ($res['discount_percent']??'') == 100) ? 'Free' : ( ($res['discount_percent']??false) ? $res['discount_percent'].' % (Max : IDR '.number_format($res['max_percent_discount']).')' : (($res['discount_nominal']??false) ? 'IDR '.number_format($res['discount_nominal']) : '' ) ) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @elseif (isset($deals['deals_discount_global_rule']) && $deals['deals_discount_global_rule'] != null) 
                                        @if ($deals['deals_discount_global_rule'] != null)
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Discount</div>
                                            <div class="col-md-8 value">: 
                                                @if ($deals['deals_discount_global_rule']['discount_type'] == 'Percent')
                                                    {{ $deals['deals_discount_global_rule']['discount_value'] }} %
                                                @elseif ($deals['deals_discount_global_rule']['discount_type'] == 'Nominal')
                                                    {{ 'IDR '.number_format($deals['deals_discount_global_rule']['discount_value']) }}
                                                @else
                                                    No discount
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                    @if( $deals_type == 'Promotion' || $deals['deals_total_claimed'] == 0 )
                                    <div class="row static-info">
                                        <div class="col-md-11 value">
                                            <a class="btn blue" href="{{ url('/'.$rpage)}}/step2/{{$deals['id_deals']}}">Edit Rule</a>
                                        </div>
                                    </div>
                                    @endif
            @else
            <span class="sale-num font-red sbold">
                No Deals Rules
            </span>
            <div class="row static-info">
                <div class="col-md-11 value">
                    <a class="btn blue" href="{{ url('/'.$rpage)}}/step2/{{$deals['id_deals']}}">Create Rule</a>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
    
</div>
@endsection

@section('detail-style')
	<style type="text/css">
	    #sample_1_filter label, #sample_5_filter label, #sample_4_filter label, .pagination, .dataTables_filter label {
	        float: right;
	    }
	    
	    .cont-col2{
	        margin-left: 30px;
	    }
        .page-container-bg-solid .page-content {
            background: #fff!important;
        }
        .v-align-top {
            vertical-align: top;
        }
        .width-voucher-img {
            max-width: 150px;
        }
        .custom-text-green {
            color: #28a745!important;
        }
        .font-black {
            color: #333!important;
        }
	</style>
@endsection

@section('detail-script')
	<script>
		$('.sample_5, .sample_6, .sample_7').dataTable({
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
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

    $('#sample_3').dataTable({
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
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_4').dataTable({
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
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
	</script>
@endsection