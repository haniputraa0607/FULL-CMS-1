<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
	$grantedFeature     = session('granted_features');
 ?>
 @extends('layouts.main-closed')

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

	<style type="text/css">
	    #sample_1_filter label, #sample_5_filter label, #sample_4_filter label, .pagination, .dataTables_filter label {
	        float: right;
	    }

	    .cont-col2{
	        margin-left: 30px;
	    }
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script>
	function checkAll(var1,var2){
		for(x=1;x<=var2;x++){
			var value = document.getElementById('module_'+var1).checked;
			if(value == true){
				document.getElementById(var1+'_'+x).checked = true;
			} else {
				document.getElementById(var1+'_'+x).checked = false;
			}
		}
	}

	function checkSingle(var1,var2){
		var compare=0;
		var2 = $('.checkbox'+var1).length;
		for(x=1;x<=var2;x++){
			var value = document.getElementById(var1+'_'+x).checked;
			if(value == true){
				compare = compare + 1;
			}
		}
		console.log(var2+ ' ' +compare)
		if(compare == var2){
			document.getElementById('module_'+var1).checked = true;
		} else {
			document.getElementById('module_'+var1).checked = false;
		}
	}

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
	$('#sample_1').dataTable({
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

    $('#sample_2').dataTable({
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
                order: [2, "desc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

    $('#sample_5').dataTable({
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

    $('.datatable').dataTable({
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
                order: [2, "desc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

	$(document).ready(function() {
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	});

	function scheduleIdStore(id_outlet){
		document.getElementById('id_outlet_schedule').value = id_outlet;
	}

	function centang(no){
		alert(no);
	}

	function checkUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = true;
		}
	}

	function uncheckUsers(){
		var slides = document.getElementsByClassName("md-check");
		for(var i = 0; i < slides.length; i++)
		{
		   slides[i].checked = false;
		}
	}

	// function viewLogDetail(url, status, request, response, ip, useragent){
	function viewLogDetail(id_log, log_type){
		$.get("{{url('user/ajax/log')}}"+'/'+id_log+'/'+log_type, function(result){
			if(result){
				document.getElementById("log-url").value = result.url;
				document.getElementById("log-status").value = result.response_status;
				document.getElementById("log-request").innerHTML = JSON.stringify(JSON.parse(result.request), null, 4);
				document.getElementById("log-response").innerHTML = JSON.stringify(JSON.parse(result.response), null, 4);
				document.getElementById("log-ip").value = result.ip;
				document.getElementById("log-useragent").value = result.useragent;
				$('#logModal').modal('show');
			}
		})
	}

	function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

	$('[data-toggle=confirmation]').confirmation({ btnOkClass: 'btn btn-sm btn-success submit', btnCancelClass: 'btn btn-sm btn-danger'});
    $('[data-toggle=confirmationx]').confirmation({ btnOkClass: 'btn btn-sm btn-success', btnCancelClass: 'btn btn-sm btn-danger'});

	$(document).on('click', '.submit', function() {
		if ($('#pinUser').val() == ''){
			$('#pinUser').focus();
		}else{
			$('#formSuspend').submit();
		}
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
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{$profile['phone']}}</span>
        </li>
	</ul>
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="profile">
			<div class="tabbable-line tabbable-full-width">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#overview" data-toggle="tab"> Account Overview </a>
					</li>
					<li>
						<a href="#profileupdate" data-toggle="tab"> Account Update </a>
					</li>
					<li>
						<a href="#permission" data-toggle="tab"> Access Permission </a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="overview">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4 profile-info">
										<h1 class="font-blue sbold uppercase">{{$profile['name']}}</h1>
										<div class="portlet sale-summary">
											<div class="portlet-title">
												<div class="caption font-blue sbold"> {{$profile['level']}} </div>
											</div>
											<div class="portlet-body">
												<ul class="list-unstyled">
													<li>
														<span class="sale-info"> Level
															<i class="fa fa-img-up"></i>
														</span>
														@if($profile['level'] == 'Super Admin')
															<span class="sale-num font-red sbold">Super Admin</span>
														@endif
														@if($profile['level'] == 'Admin')
															<span class="sale-num font-red sbold">Admin</span>
														@endif
														@if($profile['level'] == 'Customer')
															<span class="sale-num font-blue sbold">Customer</span>
														@endif
														@if($profile['level'] == 'Admin Outlet')
															<span class="sale-num font-blue sbold">Admin Outlet</span>
														@endif
													</li>
													<li>
														<span class="sale-info"> Phone
															<i class="fa fa-img-up"></i>
														</span>
														@if($profile['phone_verified']==1)
															<span class="sale-num font-blue">verified</span>
														@else
															<span class="sale-num font-red">not verified</span>
														@endif
													</li>
													<li>
														<span class="sale-info"> Email
															<i class="fa fa-img-down"></i>
														</span>
														@if($profile['email_verified']==1)
															<span class="sale-num font-blue">verified</span>
														@else
															<span class="sale-num font-red">not verified</span>
														@endif
													</li>
												</ul>
											</div>
										</div>
										<ul class="list-group">
											<li class="list-group-item" style="padding: 5px !important;" title="User Phone number & Provider">
												<i class="fa fa-mobile-phone"></i> {{$profile['phone']}} ({{$profile['provider']}}) </li>
											<li class="list-group-item" style="padding: 5px !important;" title="User Email">
												<i class="fa fa-envelope-o"></i> {{$profile['email']}} </li>
											<li class="list-group-item" style="padding: 5px !important;" title="User Birthday">
												<i class="fa fa-birthday-cake"></i> @if($profile['birthday']){{date("d F Y", strtotime($profile['birthday']))}} @endif</li>
											<li class="list-group-item" style="padding: 5px !important;" title="User Gender">
												@if($profile['gender'] == 'Male')<i class="fa fa-male"></i> {{$profile['gender']}} </li>@else<i class="fa fa-female"></i> {{$profile['gender']}} </li>
												@endif
{{--                                            <li class="list-group-item" style="padding: 5px !important;" title="Users Celebrate">--}}
{{--                                                <i class="fa fa-calendar-check-o"></i> {{$profile['celebrate']}} </li>--}}
{{--                                            <li class="list-group-item" style="padding: 5px !important;" title="User's Job">--}}
{{--                                                <i class="fa fa-black-tie"></i> {{$profile['job']}} </li>--}}

{{--                                            @if(MyHelper::hasAccess([96], $configs))--}}
											<li class="list-group-item" style="padding: 5px !important;" title="User Province">
												<i class="fa fa-map"></i> @if(isset($profile['province_name'])){{$profile['province_name']}} @endif</li>
{{--                                            @else--}}
{{--                                            <li class="list-group-item" style="padding: 5px !important;" title="User City & Province">--}}
{{--                                                <i class="fa fa-map"></i> {{$profile['city_name']}}, {{$profile['province_name']}} </li>--}}
{{--                                            @endif--}}
{{--                                            <li class="list-group-item" style="padding: 5px !important;" title="User Address">--}}
{{--                                                <i class="fa fa-map-pin"></i> {{$profile['address']}} </li>--}}
{{--											<li class="list-group-item" style="padding: 5px !important;" title="User Register date & time">--}}
{{--												<i class="fa fa-registered"></i> {{date("d F Y", strtotime($profile['created_at']))}} </li>--}}
{{--											<li class="list-group-item" style="padding: 5px !important;" title="User Membership">--}}
{{--												<i class="icon-badge"></i> @if(isset($profile['user_membership']['membership_name'])){{$profile['user_membership']['membership_name']}} @endif</li>--}}
{{--                        					<!-- <li class="list-group-item" style="padding: 5px !important;" title="User Relationship">--}}
{{--												<i class="fa fa-heart"></i> { {$profile['relationship']} } </li> -->--}}
{{--											<li class="list-group-item" style="padding: 5px !important;" title="Total {{env('POINT_NAME', 'Points')}} Obtained By The User">--}}
{{--												<i class="fa fa-gift"></i> {{number_format($profile['balance_acquisition'], 0, ',', '.')}} </li>--}}
{{--											<li class="list-group-item" style="padding: 5px !important;" title="Remaining User {{env('POINT_NAME', 'Points')}}">--}}
{{--												<i class="fa fa-star"></i> {{number_format($profile['balance'], 0, ',', '.')}} </li>--}}
										</ul>
									</div>
									<!--end col-md-8-->
									<div class="col-md-8">
										@if(isset($log))
											<a href="{{url('user/log/'.$profile['phone'])}}" class="btn btn-sm yellow" type="button" style="float:right">
												Show All Activity
											</a>
    										<h4 class="font-blue sbold uppercase" style="margin-top: 0px;margin-bottom: 50px;font-size: 24px;">Latest Activity Log</h4>
										    <div class="tabbable-line tabbable-full-width">
												<ul class="nav nav-tabs">
													<li class="active">
														<a href="#log_mobile" data-toggle="tab"> Mobile </a>
													</li>
													<li>
														<a href="#log_backend" data-toggle="tab"> Backend </a>
													</li>
												</ul>
											</div>
											<div class="tab-content" style="margin-top:20px">
												<div class="tab-pane active" id="log_mobile">

    										        <div class="tabbable-line tabbable-custom-profile">

            											<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
            											    @if(count($log['mobile']) > 0)
            												<ul class="feeds">
            													@foreach($log['mobile'] as $logs)
            													<li>
            														<div class="col1">
            															<div class="cont">
            																<div class="cont-col1">
            																    @if(stristr($logs['useragent'],'iOS'))
            															            <i class="fa fa-apple"></i>
            																	@elseif(stristr($logs['useragent'],'okhttp'))
        																			<i class="fa fa-android"></i>
            																	@else
        																			<i class="fa fa-circle-o" style="color:white"></i>
        																		@endif

            																	@if($logs['response_status'] == 'fail')
            																		<div class="label label-danger">
            																			<i class="fa fa-exclamation-circle"></i>
            																		</div>
            																	@else
            																		<div class="label label-success">
            																			<i class="fa fa-check-square"></i>
            																		</div>
            																	@endif
            																</div>
            																<div class="cont-col2">
            																	<div class="desc"> {{$logs['subject']}}
            																		@if($logs['response_status'] == 'fail')
            																		<span class="label label-danger label-sm"> Failed
            																		</span>
            																		@else
            																		<span class="label label-success label-sm"> Success
            																		</span>
            																		@endif
            																		&nbsp;from IP {{$logs['ip']}}

            																		 <?php
            																		//  $request =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['request']))));

            																		//  $response =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['response']))));
            																		 ?>
            																		<span style="cursor: pointer;" class="label label-info label-sm" onClick="viewLogDetail('{{$logs['id_log_activities_apps']}}','apps')"> <i class="fa fa-info-circle"></i> Details

            																		</span>
            																	</div>
            																</div>
            															</div>
            														</div>
            														<div class="col2" style="width: 190px;margin-left: -190px;">
            															<div class="date"> {{date("d F Y H:i:s", strtotime($logs['created_at']))}} </div>
            														</div>
            													</li>
            													@endforeach
            												</ul>
            											    @else
            											    Activity Log is Empty
            												@endif
            											</div>
    										        </div>
										        </div>

												<div class="tab-pane" id="log_backend">

    										        <div class="tabbable-line tabbable-custom-profile">
            											<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
            											     @if(count($log['backend']) > 0)
            												<ul class="feeds">
            													@foreach($log['backend'] as $logs)
            													<li>
            														<div class="col1">
            															<div class="cont">
            																<div class="cont-col1">
																				<i class="fa fa-circle-o" style="color:white"></i>
            																	@if($logs['response_status'] == 'fail')
            																		<div class="label label-danger">
            																			<i class="fa fa-exclamation-circle"></i>
            																		</div>
            																	@else
            																		<div class="label label-success">
            																			<i class="fa fa-check-square"></i>
            																		</div>
            																	@endif
            																</div>
            																<div class="cont-col2">
            																	<div class="desc"> {{$logs['subject']}}
            																		@if($logs['response_status'] == 'fail')
            																		<span class="label label-danger label-sm"> Failed
            																		</span>
            																		@else
            																		<span class="label label-success label-sm"> Success
            																		</span>
            																		@endif
																					&nbsp;from IP {{$logs['ip']}}

            																		 <?php
            																		//  $request =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['request']))));

            																		//  $response =  str_replace('}','\r\n}',str_replace(',',',\r\n&emsp;',str_replace('{','{\r\n&emsp;',strip_tags($logs['response']))));
            																		 ?>
            																		<span style="cursor: pointer;" class="label label-info label-sm" onClick="viewLogDetail('{{$logs['id_log_activities_be']}}','be')"> <i class="fa fa-info-circle"></i> Details

            																		</span>
            																	</div>
            																</div>
            															</div>
            														</div>
            														<div class="col2" style="width: 190px;margin-left: -190px;">
            															<div class="date"> {{date("d F Y H:i:s", strtotime($logs['created_at']))}} </div>
            														</div>
            													</li>
            													@endforeach
            												</ul>
            												@else
            												 Activity Log is Empty
            												@endif
            											</div>
            										</div>
        										</div>
										    </div>

										@endif

									</div>

									<div class="col-md-12" style="margin-top:30px">
										<h4 class="font-blue sbold uppercase">HISTORY</h4>
											<div class="tabbable-line tabbable-full-width">
												<ul class="nav nav-tabs">
													<li class="active">
														<a href="#history_ongoing" data-toggle="tab"> On Going </a>
													</li>
													<li>
														<a href="#history_trx" data-toggle="tab"> Transaction </a>
													</li>
													<li>
														<a href="#history_balance" data-toggle="tab"> Point </a>
													</li>
													@if(MyHelper::hasAccess([18], $configs))
														<li>
															<a href="#portlet_comments_4" data-toggle="tab"> Point </a>
														</li>
													@endif
                                                    <li>
                                                        <a href="#user_inboxes" data-toggle="tab"> Inboxes </a>
                                                    </li>
												</ul>
											</div>
											<div class="tab-content" style="margin-top:20px">
												<div class="tab-pane active" id="history_ongoing">
													<!-- BEGIN: Comments -->
													<div class="mt-comments">
														@if(!empty($profile['on_going']))
															<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
																<thead>
																  <tr>
																	  <th>Date</th>
																	  <th>Outlet</th>
																	  <th>Type</th>
																	  <th>Receipt Number</th>
																	  <th>Total Price</th>
																	  <th>Order Status</th>
																	  <th>Actions</th>
																  </tr>
																</thead>
																<tbody>
																	@foreach($profile['on_going'] as $res)
																		<tr>
																			<td>{{ date('d F Y H:i', strtotime($res['transaction_date'])) }}</td>
																			<td>{{ $res['trasaction_type'] }}</td>
																			<td>{{ $res['transaction_receipt_number'] }}</td>
																			<td>{{ $res['outlet_name']['outlet_name'] }}</td>
																			<td>Rp {{ number_format($res['transaction_grandtotal']) }}</td>
																			<td>
																			    @if($res['reject_at'] != null)
																					<span class="label label-danger label-sm">
																			        Rejected
																					</span>
																			    @elseif($res['taken_at'] != null)
																					<span class="label label-sm" style="background-color:#28a745;">
																			        Taken
																					</span>
																			    @elseif($res['ready_at'] != null)
																					<span class="label label-success label-sm">
																			        Ready
																					</span>
																			    @elseif($res['receive_at'] != null)
																					<span class="label label-info label-sm">
																			        Accepted
																					</span>
																			    @else
																					<span class="label label-sm" style="background-color: #95A5A6">
																			        Pending
																					</span>
																			    @endif
																			</td>
																			<td>
																				<a class="btn btn-block yellow btn-xs" href="{{ url('transaction/detail/'.$res['id_transaction'].'/'.$res['trasaction_type']) }}"><i class="icon-pencil"></i> Detail </a>
																			</td>
																		</tr>
																	@endforeach
																</tbody>
															</table>
														@else
															Transaction is empty
														@endif
													</div>
													<!-- END: Comments -->
												</div>
												<div class="tab-pane" id="history_trx">
													<!-- BEGIN: Comments -->
													<div class="mt-comments">
														@if(!empty($profile['history_transactions']))
															<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
																<thead>
																  <tr>
																	  <th>Date</th>
																	  <th>Outlet</th>
																	  <th>Type</th>
																	  <th>Receipt Number</th>
																	  <th>Total Price</th>
																	  <th>Payment Status</th>
																	  <th>Actions</th>
																  </tr>
																</thead>
																<tbody>
																	@foreach($profile['history_transactions'] as $res)
																		<tr>
																			<td>{{ date('d F Y H:i', strtotime($res['transaction_date'])) }}</td>
																			<td>{{ $res['outlet_name']['outlet_name'] }}</td>
																			<td>{{ $res['trasaction_type'] }}</td>
																			<td>{{ $res['transaction_receipt_number'] }}</td>
																			<td>Rp {{ number_format($res['transaction_grandtotal']) }}</td>
																			<td>
																				@if($res['transaction_payment_status'] == 'Cancelled')
																					<span class="label label-danger label-sm">
																						{{$res['transaction_payment_status']}}
																					</span>
																				@elseif($res['transaction_payment_status'] == 'Completed')
																					<span class="label label-sm" style="background-color:#28a745;">
																						{{$res['transaction_payment_status']}}
																					</span>
																				@elseif($res['transaction_payment_status'] == 'Pending')
																					<span class="label label-sm" style="background-color: #95A5A6">
																						{{$res['transaction_payment_status']}}
																					</span>
																				@else
																					<span class="label label-primary label-sm">
																						{{$res['transaction_payment_status']}}
																					</span>
																				@endif
																			</td>
																			<td>
																				<a class="btn btn-block yellow btn-xs" href="{{ url('transaction/detail/'.$res['id_transaction'].'/'.$res['trasaction_type']) }}"><i class="icon-pencil"></i> Detail </a>
																			</td>
																		</tr>
																	@endforeach
																</tbody>
															</table>
														@else
															Transaction is empty
														@endif
													</div>
													<!-- END: Comments -->
												</div>
												@if(MyHelper::hasAccess([19], $configs))
													<div class="tab-pane" id="history_balance">
														<div class="row">
															<div class="col-lg-12 col-xs-12 col-sm-12">
																	<div class="mt-comments">
																		<!--<div class="row number-stats margin-bottom-30">-->
																		<!--	<div class="col-md-6 col-sm-6 col-xs-6">-->
																		<!--		<div class="stat-left">-->
																		<!--			<div class="stat-number">-->
																		<!--				<div class="title" style="color: red"> Voucher </div>-->
																		<!--				<div class="number"> Voucher </div>-->
																		<!--			</div>-->
																		<!--		</div>-->
																		<!--	</div>-->
																		<!--	<div class="col-md-6 col-sm-6 col-xs-6">-->
																		<!--		<div class="stat-right">-->
																		<!--			<div class="stat-number">-->
																		<!--				<div class="title" style="color: blue"> Transaction </div>-->
																		<!--				<div class="number"> Trx </div>-->
																		<!--			</div>-->
																		<!--		</div>-->
																		<!--	</div>-->
																		<!--</div>-->
																		<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_4">
																			<thead>
																				<tr class="uppercase">
																					<th> Source </th>
																					<th> Point </th>
																					<th> Date </th>
																					<th> Time </th>
																					<th> Detail </th>
																				</tr>
																			</thead>
																			@if(!empty($profile['history_balance_trx']))
																				@foreach ($profile['history_balance_trx'] as $balance)
																					<tr
																					{{--@if ($balance['source'] == 'voucher') style="color: red" @else style="color: blue" @endif --}}
																					>
																						<td> {{ ucwords($balance['source']) }} </td>
																						<td> {{ $balance['balance'] }} </td>
																						<td> {{ date('d F Y', strtotime($balance['created_at'])) }} </td>
																						<td> {{ date('H:i:s', strtotime($balance['created_at'])) }} </td>
																						@if ($balance['source'] != 'voucher' && $balance['source'] != 'Complete Profile' && $balance['source'] != 'Point Injection')
																							<td>
																							<a href="{{ url('transaction/detail/'.$balance['id_transaction'].'/'.$balance['trasaction_type']) }}">

																							    {{ $balance['transaction_receipt_number'] }}
																							</a>
																							</td>
																						@else
																							@if($balance['source'] == 'Point Injection' && MyHelper::hasAccess([245], $grantedFeature))
																								<td> <a target="_blank" href="{{ url('point-injection/report') }}/{{ $balance['id_reference'] }}"> Detail Point Injection </a> </td>
																							@else
																								<td> {{ $balance['detail_trx']['trx_id']??'' }} </td>
																							@endif
																						@endif

																					</tr>
																				@endforeach
																			@endif
																		</table>
																	</div>
																</div>
															</div>
													</div>
												@endif
                                                <div class="tab-pane" id="user_inboxes">
                                                    <table class="table table-hover table-striped datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Subject</th>
                                                                <th>Type</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($inboxes as $inbox)
                                                            @foreach($inbox['list'] as $it)
                                                            <tr>
                                                                <td>{{date('d/m/Y H:i',strtotime($it['created_at']))}}</td>
                                                                <td>{{$it['subject']}}</td>
                                                                <td>{{$it['type']}}</td>
                                                                <td>{{$it['status']}}</td>
                                                                <td>@if($it['type']=='private')<form action="#" method="POST">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" name="action" value="delete_inbox">
                                                                    <input type="hidden" name="id_inbox" value="{{$it['id_inbox']}}">
                                                                    <button class="btn btn-sm btn-danger" data-toggle="confirmationx"
                                                                    data-btn-ok-label="Delete" data-btn-ok-class="btn btn-danger"
                                                                    data-btn-ok-icon-class="material-icons" data-btn-ok-icon-content="check"
                                                                    data-btn-cancel-label="No" data-btn-cancel-class="btn-info"
                                                                    data-btn-cancel-icon-class="material-icons" data-btn-cancel-icon-content="close"
                                                                    data-title="Are you sure want to delete this inbox?"><i class="fa fa-trash"></i> Delete</button></form></td>@endif
                                                            </tr>
                                                            @endforeach
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
											</div>
										</div>

									<div class="col-md-12" style="margin-top:30px">
										<h4 class="font-blue sbold uppercase">Voucher</h4>
											<div class="tabbable-line tabbable-full-width">
												<ul class="nav nav-tabs">
													<li class="active">
														<a href="#vouche_not_invalidate" data-toggle="tab"> Not Invalidate Yet </a>
													</li>
													<li>
														<a href="#voucher_invalidate" data-toggle="tab"> Already Invalidate </a>
													</li>
													<li>
														<a href="#voucher_used" data-toggle="tab"> Used </a>
													</li>
													<li>
														<a href="#voucher_expired" data-toggle="tab"> Expired </a>
													</li>
												</ul>
											</div>
											<div class="tab-content" style="margin-top:20px">
												<div class="tab-pane active" id="vouche_not_invalidate">
													<!-- BEGIN: Comments -->
													<div class="mt-comments">
														@if(!empty($voucher))
															<table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
																<thead>
																  <tr>
																	  <th>Deals Title</th>
																	  <th>Promo Type</th>
																	  <th>Voucher Code</th>
																	  <th>Claimed</th>
																	  <th>Expired</th>
																  </tr>
																</thead>
																<tbody>
																	@foreach($voucher as $i => $vou)
																	    @if($vou['used_at'] == null && date('Y-m-d H:i', strtotime($vou['voucher_expired_at'])) > date('Y-m-d H:i') && $vou['redeemed_at'] == null )
																		<tr>
																			<td>{{ $vou['deals_voucher']['deals']['deals_title'] }} {{ $vou['deals_voucher']['deals']['deals_second_title'] }}</td>
																			<td>
																			    @if($vou['deals_voucher']['deals']['deals_promo_id_type'] == 'promoid')
																			        Promo ID : {{ $vou['deals_voucher']['deals']['deals_promo_id'] }}
																			    @else
																			        Nominal : {{number_format($vou['deals_voucher']['deals']['deals_promo_id'], 0, ',','.')}}
																			    @endif
																	        </td>
																			<td>{{ $vou['deals_voucher']['voucher_code'] }}</td>
																			<td>@if($vou['claimed_at']) {{ date('d F Y H:i', strtotime($vou['claimed_at'])) }} @endif</td>
																			<td>@if($vou['voucher_expired_at'])  {{ date('d F Y H:i', strtotime($vou['voucher_expired_at'])) }} @endif</td>
																		</tr>
																		@php unset($voucher[$i]); @endphp
																	    @endif
																	@endforeach
																</tbody>
															</table>
														@else
															Voucher is empty
														@endif
													</div>
													<!-- END: Comments -->
												</div>

												<div class="tab-pane" id="voucher_invalidate">
													<!-- BEGIN: Comments -->
													<div class="mt-comments">
														@if(!empty($voucher))
															<table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
																<thead>
																  <tr>
																	  <th>Deals Title</th>
																	  <th>Promo Type</th>
																	  <th>Voucher Code</th>
																	  <th>Outlet</th>
																	  <th>Claimed</th>
																	  <th>Redeemed</th>
																	  <th>Expired</th>
																  </tr>
																</thead>
																<tbody>
																	@foreach($voucher as $i => $vou)
																	    @if($vou['used_at'] == null && $vou['redeemed_at'] != null && date('Y-m-d H:i', strtotime($vou['voucher_expired_at'])) > date('Y-m-d H:i') )
																		<tr>
																			<td>{{ $vou['deals_voucher']['deals']['deals_title'] }} {{ $vou['deals_voucher']['deals']['deals_second_title'] }}</td>
																			<td>
																			    @if($vou['deals_voucher']['deals']['deals_promo_id_type'] == 'promoid')
																			        Promo ID : {{ $vou['deals_voucher']['deals']['deals_promo_id'] }}
																			    @else
																			        Nominal : {{number_format($vou['deals_voucher']['deals']['deals_promo_id'], 0, ',','.')}}
																			    @endif
																	        </td>
																			<td>{{ $vou['deals_voucher']['voucher_code'] }}</td>
																			<td>{{ $vou['outlet']['outlet_code'] }} - {{ $vou['outlet']['outlet_name'] }}</td>
																			<td>@if($vou['claimed_at']) {{ date('d F Y H:i', strtotime($vou['claimed_at'])) }} @endif</td>
																			<td>@if($vou['redeemed_at']) {{ date('d F Y H:i', strtotime($vou['redeemed_at'])) }} @endif</td>
																			<td>@if($vou['voucher_expired_at']) {{ date('d F Y H:i', strtotime($vou['voucher_expired_at'])) }} @endif</td>
																		</tr>
																		@php unset($voucher[$i]); @endphp
																	    @endif
																	@endforeach
																</tbody>
															</table>
														@else
															Voucher is empty
														@endif
													</div>
													<!-- END: Comments -->
												</div>

												<div class="tab-pane" id="voucher_used">
													<!-- BEGIN: Comments -->
													<div class="mt-comments">
														@if(!empty($voucher))
															<table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
																<thead>
																  <tr>
																	  <th>Deals Title</th>
																	  <th>Promo Type</th>
																	  <th>Voucher Code</th>
																	  <th>Outlet</th>
																	  <th>Claimed</th>
																	  <th>Redeemed</th>
																	  <th>Used</th>
																	  <th>Expired</th>
																  </tr>
																</thead>
																<tbody>
																	@foreach($voucher as $i => $vou)
																	    @if($vou['used_at'] != null )
																		<tr>
																			<td>{{ $vou['deals_voucher']['deals']['deals_title'] }} {{ $vou['deals_voucher']['deals']['deals_second_title'] }}</td>
																			<td>
																			    @if($vou['deals_voucher']['deals']['deals_promo_id_type'] == 'promoid')
																			        Promo ID : {{ $vou['deals_voucher']['deals']['deals_promo_id'] }}
																			    @else
																			        Nominal : {{number_format($vou['deals_voucher']['deals']['deals_promo_id'], 0, ',','.')}}
																			    @endif
																	        </td>
																			<td>{{ $vou['deals_voucher']['voucher_code'] }}</td>
																			<td>{{ $vou['outlet']['outlet_code'] }} - {{ $vou['outlet']['outlet_name'] }}</td>
																			<td>@if($vou['claimed_at']) {{ date('d F Y H:i', strtotime($vou['claimed_at'])) }} @endif</td>
																			<td>@if($vou['redeemed_at']) {{ date('d F Y H:i', strtotime($vou['redeemed_at'])) }} @endif</td>
																			<td>@if($vou['used_at']) {{ date('d F Y H:i', strtotime($vou['used_at'])) }} @endif</td>
																			<td>@if($vou['voucher_expired_at']) {{ date('d F Y H:i', strtotime($vou['voucher_expired_at'])) }} @endif</td>
																		</tr>
																		@php unset($voucher[$i]); @endphp
																	    @endif
																	@endforeach
																</tbody>
															</table>
														@else
															Voucher is empty
														@endif
													</div>
													<!-- END: Comments -->
												</div>

												<div class="tab-pane" id="voucher_expired">
													<!-- BEGIN: Comments -->
													<div class="mt-comments">
														@if(!empty($voucher))
															<table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
																<thead>
																  <tr>
																	  <th>Deals Title</th>
																	  <th>Promo Type</th>
																	  <th>Voucher Code</th>
																	  <th>Outlet</th>
																	  <th>Claimed At</th>
																	  <th>Redeemed At</th>
																	  <th>Expired At</th>
																  </tr>
																</thead>
																<tbody>
																	@foreach($voucher as $i => $vou)
																	    @if(date('Y-m-d H:i', strtotime($vou['voucher_expired_at'])) <= date('Y-m-d H:i') && $vou['used_at'] == null)
																		<tr>
																			<td>{{ $vou['deals_voucher']['deals']['deals_title'] }} {{ $vou['deals_voucher']['deals']['deals_second_title'] }}</td>
																			<td>
																			    @if($vou['deals_voucher']['deals']['deals_promo_id_type'] == 'promoid')
																			        Promo ID : {{ $vou['deals_voucher']['deals']['deals_promo_id'] }}
																			    @else
																			        Nominal : {{number_format($vou['deals_voucher']['deals']['deals_promo_id'], 0, ',','.')}}
																			    @endif
																	        </td>
																			<td>{{ $vou['deals_voucher']['voucher_code'] }}</td>
																			<td>{{ $vou['outlet']['outlet_code'] }} - {{ $vou['outlet']['outlet_name'] }}</td>
																			<td>@if($vou['claimed_at']) {{ date('d F Y H:i', strtotime($vou['claimed_at'])) }} @endif</td>
																			<td>@if($vou['redeemed_at']) {{ date('d F Y H:i', strtotime($vou['redeemed_at'])) }} @endif</td>
																			<td>@if($vou['voucher_expired_at']) {{ date('d F Y H:i', strtotime($vou['voucher_expired_at'])) }} @endif</td>
																		</tr>
																		@php unset($voucher[$i]); @endphp
																	    @endif
																	@endforeach
																</tbody>
															</table>
														@else
															Voucher is empty
														@endif
													</div>
													<!-- END: Comments -->
												</div>

											</div>
										</div>
								</div>
							</div>
						</div>
					</div>
					<!--tab_1_2-->
					<div class="tab-pane" id="profileupdate">
						<div class="row profile-account">
							<div class="col-md-3">
								<ul class="ver-inline-menu tabbable margin-bottom-10">
									<li class="active">
										<a data-toggle="tab" href="#tab_1-1">
											<i class="fa fa-cog"></i> Personal info </a>
										<span class="after"> </span>
									</li>
									<!-- <li>
										<a data-toggle="tab" href="#tab_2-2">
											<i class="fa fa-picture-o"></i> Change Photo </a>
									</li> -->
									<li>
										<a data-toggle="tab" href="#tab_3-3">
											<i class="fa fa-lock"></i> Change PIN </a>
									</li>
									<li>
										<a data-toggle="tab" href="#tab_4-4">
											<i class="fa fa-ban"></i> Suspend User </a>
									</li>
								</ul>
							</div>
							<div class="col-md-9">
								<div class="tab-content">
									<div id="tab_1-1" class="tab-pane active">
										<form role="form" action="{{url('user/detail')}}/{{$profile['phone']}}" method="POST">
										{{ csrf_field() }}
											<div class="form-group">
												<label class="control-label">Name</label>
												<input type="text" name="name" placeholder="User Name (Required)" class="form-control" value="{{$profile['name']}}" />
											</div>
											<div class="form-group">
												<label class="control-label">Phone</label>
												<input type="text" name="phone" placeholder="Phone Number(Required & Unique)" class="form-control" value="{{$profile['phone']}}" />
											</div>
											<div class="form-group">
												<label class="control-label">Email</label>
												<input type="text" name="email" placeholder="Email (Required & Unique)" class="form-control" value="{{$profile['email']}}" />
											</div>
{{--                                            @if(MyHelper::hasAccess([96], $configs))--}}
{{--                                            @else--}}
{{--											<div class="form-group">--}}
{{--												<label class="control-label">City</label>--}}
{{--												<select name="id_city" class="form-control input-sm select2" placeholder="Search City">--}}
{{--													<option value="">Select...</option>--}}
{{--													@if(isset($city))--}}
{{--														@foreach($city as $row)--}}
{{--															<option value="{{$row['id_city']}}" @if(isset($profile['id_city'])) @if($row['id_city'] == $profile['id_city']) selected @endif @endif>{{$row['city_name']}}</option>--}}
{{--														@endforeach--}}
{{--													@endif--}}
{{--												</select>--}}
{{--											</div>--}}
{{--                                            @endif--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label class="control-label">Address</label>--}}
{{--                                                <input type="text" name="address" placeholder="User Address" class="form-control" value="{{$profile['address']}}" />--}}
{{--                                            </div>--}}
{{--											<div class="form-group">--}}
{{--												<label class="control-label">Celebrate</label>--}}
{{--												<select name="celebrate" class="form-control input-sm select2" data-placeholder="Select Users Celebrate">--}}
{{--													<option value=""></option>--}}
{{--                                                    @php $was=false; @endphp--}}
{{--                                                    @foreach($celebrates??[] as $celebrate)--}}
{{--                                                    <option value="{{$celebrate}}" @if($celebrate==$profile['celebrate']) @php $was=true; @endphp selected @endif>{{$celebrate}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                    @if(!$was)--}}
{{--                                                    <option value="{{$profile['celebrate']}}" selected>{{$profile['celebrate']}}</option>--}}
{{--                                                    @endif--}}
{{--												</select>--}}
{{--											</div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label class="control-label">Job</label>--}}
{{--                                                <select name="job" class="form-control input-sm select2" data-placeholder="Select User's Job">--}}
{{--                                                    <option value=""></option>--}}
{{--                                                    @php $was=false; @endphp--}}
{{--                                                    @foreach($jobs??[] as $job)--}}
{{--                                                    <option value="{{$job}}" @if($job==$profile['job']) @php $was=true; @endphp selected @endif>{{$job}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                    @if(!$was)--}}
{{--                                                    <option value="{{$profile['job']}}" selected>{{$profile['job']}}</option>--}}
{{--                                                    @endif--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--											<!-- <div class="form-group">--}}
{{--												<label class="control-label">Relationship</label>--}}
{{--												<select name="relationship" class="form-control input-sm select2">--}}
{{--													<option value="">Select...</option>--}}
{{--						                            <option value="In a Relationship" {{ ($profile['relationship']=="In a Relationship" ? "selected" : "") }}>In a Relationship</option>--}}
{{--						                            <option value="Complicated" {{ ($profile['relationship']=="Complicated" ? "selected" : "") }}>Complicated</option>--}}
{{--						                            <option value="Jomblo" {{ ($profile['relationship']=="Jomblo" ? "selected" : "") }}>Jomblo</option>--}}
{{--												</select>--}}
{{--											</div> -->--}}
											<div class="form-group">
												<label class="control-label">Birthday</label>
												<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
													<input type="text" class="form-control form-filter input-sm date-picker" name="birthday" placeholder="From"  value="@if(!empty($profile['birthday'])){{date('d/m/Y', strtotime($profile['birthday']))}}@endif" data-date-format="dd/mm/yyyy">
													<span class="input-group-btn">
														<button class="btn btn-sm default" type="button">
															<i class="fa fa-calendar"></i>
														</button>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label">Gender</label>
												<select name="gender" class="form-control input-sm select2" data-placeholder="Search Gender">
													<option value="">Select Gender...</option>
													<option value="Male" @if($profile['gender'] == 'Male') selected @endif>Male</option>
													<option value="Female" @if($profile['gender'] == 'Female') selected @endif>Female</option>
												</select>
											</div>
											@if(MyHelper::hasAccess([96], $configs))
											<div class="form-group">
												<label class="control-label">Province</label>
												<select name="id_province" class="form-control input-sm select2" data-placeholder="Search Province">
													<option value="">Select Province...</option>
													@if(isset($provinces) && !empty($provinces))
														@foreach($provinces as $row)
															<option value="{{$row['id_province_custom']}}" @if(isset($profile['id_province'])) @if($row['id_province_custom'] == $profile['id_province']) selected @endif @endif>{{$row['province_name']}}</option>
														@endforeach
													@endif
												</select>
											</div>
											@else
											<div class="form-group">
												<label class="control-label">Province</label>
												<select name="id_province" class="form-control input-sm select2" data-placeholder="Search Province">
													<option value="">Select Province...</option>
													@if(isset($provinces) && !empty($provinces))
														@foreach($provinces as $row)
															<option value="{{$row['id_province']}}" @if(isset($profile['id_province'])) @if($row['id_province'] == $profile['id_province']) selected @endif @endif>{{$row['province_name']}}</option>
														@endforeach
													@endif
												</select>
											</div>
											@endif
											<div class="form-group">
												<label class="control-label">Level User</label>
												<select name="level" class="form-control input-sm select2" data-placeholder="Search Level">
													<option value="">Select Level...</option>
													<option value="Super Admin" @if($profile['level'] == 'Super Admin') selected @endif>Super Admin</option>
													<option value="Admin" @if($profile['level'] == 'Admin') selected @endif>Admin</option>
													<option value="Customer" @if($profile['level'] == 'Customer') selected @endif>Customer</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label">Phone Verified</label>
												<div class="mt-radio-inline">
													<label class="mt-radio">
														<input type="radio" name="phone_verified" id="optionsRadios1" value="1" @if($profile['phone_verified'] == '1') checked @endif > Verified
														<span></span>
													</label>
													<label class="mt-radio">
														<input type="radio" name="phone_verified" id="optionsRadios2" value="0" @if($profile['phone_verified'] == '0') checked @endif> Not Verified
														<span></span>
													</label>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label">OTP Request Status</label>
												<select name="otp_request_status" class="form-control input-sm select2" placeholder="Search Status">
													<option value="Can Request" @if($profile['otp_request_status'] == 'Can Request') selected @endif>Can Request</option>
													<option value="Can Not Request" @if($profile['otp_request_status'] == 'Can Not Request') selected @endif>Can Not Request</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label">Email Verified</label>
												<div class="mt-radio-inline">
													<label class="mt-radio">
														<input type="radio" name="email_verified" id="optionsRadios3" value="1" @if($profile['email_verified'] == '1') checked @endif > Verified
														<span></span>
													</label>
													<label class="mt-radio">
														<input type="radio" name="email_verified" id="optionsRadios4" value="0" @if($profile['email_verified'] == '0') checked @endif> Not Verified
														<span></span>
													</label>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label">Verify Email Request Status</label>
												<select name="email_verify_request_status" class="form-control input-sm select2" placeholder="Search Status">
													<option value="Can Request" @if($profile['email_verify_request_status'] == 'Can Request') selected @endif>Can Request</option>
													<option value="Can Not Request" @if($profile['email_verify_request_status'] == 'Can Not Request') selected @endif>Can Not Request</option>
												</select>
											</div>
											<div class="margiv-top-10">
												<button class="btn green"> Save Changes </button>
											</div>
										</form>
									</div>
									<!-- <div id="tab_2-2" class="tab-pane">
										<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" enctype="multipart/form-data" method="POST" >
										{{ csrf_field() }}
											<div class="margin-top-10">
												<button class="btn green"> Save Changes </button>
											</div>
										</form>
									</div> -->
									<div id="tab_3-3" class="tab-pane">
										<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" method="POST">
										{{ csrf_field() }}
											<div class="form-group">
												<label class="control-label">New PIN</label>
												<input type="password" class="form-control" name="password_new" maxLength="6" minLength="6" onkeypress="return isNumberKey(event)" autocomplete="new-password" /> </div>
											<div class="form-group">
												<label class="control-label">Re-type New PIN</label>
												<input type="password" class="form-control" name="password_new_confirmation" maxLength="6" minLength="6" onkeypress="return isNumberKey(event)"/> </div>
											<div class="margin-top-10">
												<button class="btn green"> Save Changes </button>
											</div>
										</form>
									</div>
									<div id="tab_4-4" class="tab-pane">
										<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" method="POST" id="formSuspend">
										{{ csrf_field() }}
											<div class="form-group">
												<label class="control-label">Suspend</label>
												<div class="mt-radio-inline">
													<label class="mt-radio">
														<input type="radio" name="is_suspended" id="optionsRadios3" value="1" @if($profile['is_suspended'] == '1') checked @endif > Yes
														<span></span>
													</label>
													<label class="mt-radio">
														<input type="radio" name="is_suspended" id="optionsRadios4" value="0" @if($profile['is_suspended'] == '0') checked @endif> No
														<span></span>
													</label>
												</div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-12">Your PIN</label>
												<div class="col-md-4">
													<input type="password" id="pinUser" class="form-control" width="30%" name="password_suspend" placeholder="Enter Your current PIN" required style="width: 91.3%;" maxLength="6" minLength="6" onkeypress="return isNumberKey(event)">
												</div>
												<div class="col-md-8"></div>
											</div>
											<div class="margin-top-10">
												<a type="button" data-toggle="confirmation" data-original-title="Are you sure to change the suspend status of this user ?" data-placement="bottom" data-popout="true" class="btn green">Save Changes</a>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!--end col-md-9-->
						</div>
					</div>
					<!--end tab-pane-->
					<div class="tab-pane" id="permission">
						<div class="row">
							<h1 style="text-align:center;">{{$profile['name']}} has access as <b>{{$profile['level']}}</b>.</h1>
							<h3 style="text-align:center;"><b>{{$profile['level']}}</b>
							@if($profile['level'] == 'Super Admin') has access to All Features.@endif
							@if($profile['level'] == 'Admin') has access to limited features.@endif
							@if($profile['level'] == 'Customer') has no access to backend.@endif
							@if($profile['level'] == 'Admin Outlet') has access to manage delivery, pickup and outlet enquiry @endif

							</h3>

							<h3 style="text-align:center;margin-bottom:50px">Do You want to change {{$profile['name']}}'s access level?</h3>

							@if($profile['level'] != 'Customer')
							<div class="col-md-4">
								<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" enctype="multipart/form-data" method="POST" style="text-align:center;">
								{{ csrf_field() }}
									<input type="password" class="form-control" width="30%" name="password_level" placeholder="Enter Your current PIN" required maxLength="6" minLength="6" onkeypress="return isNumberKey(event)">
									<input type="hidden" class="form-control" name="level" value="Customer">
									<button class="btn btn-lg green btn-block"> Yes! Be a Customer <i class="fa fa-user "></i> </button>
								</form>
							</div>
							@endif

							@if($profile['level'] != 'Admin')
							<div class="col-md-4">
								<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" enctype="multipart/form-data" method="POST" style="text-align:center;">
								{{ csrf_field() }}
									<input type="password" class="form-control" width="30%" name="password_level" placeholder="Enter Your current PIN" required maxLength="6" minLength="6" onkeypress="return isNumberKey(event)">
									<input type="hidden" class="form-control" name="level" value="Admin">
									<button class="btn btn-lg yellow btn-block"> Yes! Be an Admin <i class="fa fa-user-plus "></i> </button>
								</form>
							</div>
							@endif

							@if($profile['level'] != 'Super Admin' && Session::get('level') == 'Super Admin')
							<div class="col-md-4">
								<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" enctype="multipart/form-data" method="POST" style="text-align:center;">
								{{ csrf_field() }}
									<input type="password" class="form-control" width="30%" name="password_level" placeholder="Enter Your current PIN" required>
									<input type="hidden" class="form-control" name="level" value="Super Admin">
									<button class="btn btn-lg red btn-block"> Yes! Be a Super Admin <i class="fa fa-user-secret "></i> </button>
								</form>
							</div>
							@endif

@if($profile['level'] == 'Admin')
	<div class="col-md-12" style="margin-top:30px">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-dark sbold uppercase font-blue">Admin Access Permission</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form action="{{url('user/detail')}}/{{$profile['phone']}}" role="form" method="POST" class="form-horizontal" style="text-align:center;">
				{{ csrf_field() }}
					<div class="form-body">
						<?php
						$arrmodule = [];
						foreach($featuresall as $all){
							array_push($arrmodule, $all['feature_module']);
						}
						$arrmodule = array_unique($arrmodule);
						?>
						@foreach($arrmodule as $key => $module)
						<div class="form-group">
							<label class="col-md-3 control-label"  style="margin-top: 10px;">{{$module}}</label>
							<div class="md-checkbox-inline col-md-9" style="text-align:left">
								<?php $x = 1; $y=0?>
								@foreach($featuresall as $key2 => $feature)
									@if($feature['feature_module'] == $module)
										<?php
										$stat = false;
										foreach($features as $userfeature){
											if($feature['id_feature'] == $userfeature){
												$stat = true;
												$y++;
											}
										}
										?>
										<div class="md-checkbox">
											<input type="checkbox" id="{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}_{{$x}}" name="module[]" value="{{$feature['id_feature']}}" class="md-check checkbox{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}" onChange="checkSingle('{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}','{{$x}}')" @if($stat==true) checked @endif>
											<label for="{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}_{{$x}}">
												<span></span>
												<span class="check" style="margin-top: 10px;"></span>
												<span class="box" style="margin-top: 10px;"></span> {{$feature['feature_type']}}
											</label>
										</div>
										<?php $x++;?>
									@endif
								@endforeach
								<div class="md-checkbox">
									<input type="checkbox" class="md-check" onChange="checkAll('{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}','{{$x-1}}')" id="module_{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}" @if($y==$x-1) checked @endif>
									<label for="module_{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}">
										<span></span>
										<span class="check" style="margin-top: 10px;" onChange="checkAll('{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}','{{$x-1}}')"></span>
										<span class="box" style="margin-top: 10px;"></span> All {{$module}}
									</label>
								</div>
							</div>
						</div>
						@endforeach
						<div class="form-group">
							<label class="col-md-3 control-label">Your Password</label>
							<div class="col-md-4">
								<input type="password" class="form-control" width="30%" name="password_permission" placeholder="Enter Your current PIN" required style="width: 91.3%;">
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-4 col-md-5">
									<button class="btn btn-lg blue btn-block"> Change Permission <i class="fa fa-check-circle "></i> </button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="logModal" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Request & Response Detail</h4>
			</div>
			<div class="modal-body form">
				<form role="form">
					<div class="form-body">
						<div class="form-group">
							<label>URL</label>
							<input type="text" class="form-control" readonly id="log-url">
						</div>
						<div class="form-group">
							<label>Status</label>
							<input type="text" class="form-control" readonly id="log-status">
						</div>
						<div class="form-group">
							<label>IP Address</label>
							<input type="text" class="form-control" readonly id="log-ip">
						</div>
						<div class="form-group">
							<label>User Agent</label>
							<input type="text" class="form-control" readonly id="log-useragent">
						</div>
						<div class="form-group">
							<label>Request</label>
							<pre  id="log-request"></pre>
						</div>
						<div class="form-group">
							<label>Response</label>
							<pre id="log-response"></pre>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@endsection