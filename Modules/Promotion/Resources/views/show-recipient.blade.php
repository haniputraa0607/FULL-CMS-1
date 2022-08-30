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
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" /> 
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
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/table-datatables-buttons.js') }}" type="text/javascript"></script>
	
	<script type="text/javascript">
	$(document).ready(function() {
	  
		$('#tableUsers').DataTable( {
		    serverSide: true,
		    responsive: true,
		    lengthMenu: [[5,10, 25, 50,100], [5,10, 25, 50,100]],
            pageLength: 10,
            dom: "<'row' <'col-md-12'>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-12 text-center col-sm-12'i><'col-md-12 text-center col-sm-12'p>>",
		    orderMulti: false,
            buttons: [ {
              extend: "copy",
              className: "btn blue btn-outline",
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
            searchDelay: 1000,
		    ajax: {
		        url: '{{url()->current()}}?ajax=1',
		        type: 'GET'
		    }
		} );
	});
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
		<div class="mt-element-step">
			<div class="row step-line">
				<div class="col-md-4 mt-step-col first">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Info</div>
					<div class="mt-step-content font-grey-cascade">Promotion Setup</div>
				</div>
				<div class="col-md-4 mt-step-col">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Content</div>
					<div class="mt-step-content font-grey-cascade">Promotion Content</div>
				</div>
				<div class="col-md-4 mt-step-col last active">
					<div class="mt-step-number bg-white">3</div>
					<div class="mt-step-title uppercase font-grey-cascade">Summary</div>
					<div class="mt-step-content font-grey-cascade">Promotion Result</div>
				</div>
			</div>
		</div>
	</div>
	
	<form role="form" action="" method="POST" enctype="multipart/form-data">
		<div class="col-md-12">
			<table class="table table-striped table-bordered table-hover" id="tableUsers" style="width:100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Gender</th>
						<th>City</th>
						<th>Birthday</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Gender</th>
						<th>City</th>
						<th>Birthday</th>
					</tr>
				</tfoot>
				<tbody>
				</tbody>
			</table>
		</div>
	</form>
</div>
@endsection