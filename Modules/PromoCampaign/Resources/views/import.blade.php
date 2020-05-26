@extends('layouts.main')
<?php
use App\Lib\MyHelper;
$configs    		= session('configs');
$grantedFeature     = session('granted_features');
?>
@section('page-style')

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .text-color-blue {

        }
        .text-color-red {

        }
    </style>
@endsection

@section('page-script')

    <!-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script>
    	$('#promo-code-checkbox').on('switchChange.bootstrapSwitch',function(){
	        var state=$(this).bootstrapSwitch('state');
	        if(state){
	            $('#promo-code-true').show();
	            $('#promo-code-false').hide();
	        }else{
	            $('#promo-code-true').hide();
	            $('#promo-code-false').show();
	        }
	    });
	    $('#voucher-online-checkbox').on('switchChange.bootstrapSwitch',function(){
	        var state=$(this).bootstrapSwitch('state');
	        if(state){
	            $('#voucher-online-true').show();
	            $('#voucher-online-false').hide();
	        }else{
	            $('#voucher-online-true').hide();
	            $('#voucher-online-false').show();
	        }
	    });
	    $('#voucher-offline-checkbox').on('switchChange.bootstrapSwitch',function(){
	        var state=$(this).bootstrapSwitch('state');
	        if(state){
	            $('#voucher-offline-true').show();
	            $('#voucher-offline-false').hide();
	        }else{
	            $('#voucher-offline-true').hide();
	            $('#voucher-offline-false').show();
	        }
	    });
	    $('#promo-code-checkbox').trigger('switchChange.bootstrapSwitch');
	    $('#voucher-online-checkbox').trigger('switchChange.bootstrapSwitch');
	    $('#voucher-offline-checkbox').trigger('switchChange.bootstrapSwitch');

	    $(".form_datetime").datetimepicker({
	        format: "d-M-yyyy hh:ii",
	        autoclose: true,
	        todayBtn: true,
	        minuteStep:1
	    });

	    /* EXPIRY */
        $('.expiry').click(function() {
            var nilai = $(this).val();

            $('#times').show();

            $('.voucherTime').hide();

            $('#'+nilai).show();
            $('.'+nilai).prop('required', true);
            $('.'+nilai+'Opp').removeAttr('required');
            $('.'+nilai+'Opp').val('');
        });

        $("#start_date").datetimepicker({
			format: "d-M-yyyy hh:ii",
			autoclose: true,
			startDate: new Date(),
			minuteStep: 5,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('#end_date').datetimepicker('setStartDate', minDate);
		});
		$("#end_date").datetimepicker({
			format: "d-M-yyyy hh:ii",
			autoclose: true,
			minuteStep: 5,
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('#start_date').datetimepicker('setEndDate', minDate);
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
					<span class="caption-subject font-dark sbold uppercase font-green">{{$sub_title}}</span>
				</div>
			</div>
			<div class="portlet-body form">
				<div class="m-heading-1 border-green m-bordered">
					<p style="white-space: pre-wrap;">This menu is used to import Promo Campaign Config.</p>
					<p style="white-space: pre-wrap;">When importing Config, please note that:</p>
					<ul>
						<li>Selected excel file is exported from the system</li>
						<li>Don't change data with a yellow background.</li>
					</ul>
					<p style="white-space: pre-wrap;">Please click <span class="badge">Import</span> to start importing</p>
				</div>
				<div id="upload-form">
					<form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data" id="form-upload">
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Start Date
								<span class="required" aria-required="true"> * </span>
		                        <i class="fa fa-question-circle tooltips" data-original-title="Waktu dimulai berlakunya promo" data-container="body"></i></label>
		                        <div class="col-md-4">
									<div class="input-group date bs-datetime">
										<input required autocomplete="off" id="start_date" type="text" class="form-control" name="date_start" placeholder="Start Date" @if(isset($result['date_start']) && $result['date_start'] != "") value="{{date('d F Y - H:i', strtotime($result['date_start']))}}" @elseif(old('date_start') != "") value="{{old('date_start')}}" @endif>
										<span class="input-group-addon">
											<button class="btn default date-set" type="button">
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">End Date
								<span class="required" aria-required="true"> * </span>
		                        <i class="fa fa-question-circle tooltips" data-original-title="Waktu selesai berlakunya promo" data-container="body"></i></label>
		                        <div class="col-md-4">
									<div class="input-group date bs-datetime">
										<input required autocomplete="off" id="end_date" type="text" class="form-control" name="date_end" placeholder="End Date" @if(isset($result['date_end']) && $result['date_end'] != "") value="{{date('d F Y - H:i', strtotime($result['date_end']))}}" @elseif(old('date_end') != "") value="{{old('date_end')}}" @endif>
										<span class="input-group-addon">
											<button class="btn default date-set" type="button">
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label"> Import config <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="File import berasal dari menu promo campaign" data-container="body"></i> </label>
								<div class="col-md-4"> 	
									<div class="fileinput fileinput-new text-left" data-provides="fileinput">
										<div class="input-group">
											<div class="form-control input-fixed" data-trigger="fileinput">
												<i class="fa fa-file fileinput-exists"></i>&nbsp;
												<span class="fileinput-filename"> </span>
											</div>
											<span class="input-group-addon btn default btn-file">
												<span class="fileinput-new"> Select file </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
											</span>
											<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions" style="padding-bottom: 5px">
								{{ csrf_field() }}
								<div class="row">
                                <div class="col-md-offset-5 col-md-7">
                                    <button type="submit" class="btn green">Import</button>
                                    <!-- <button type="button" class="btn default">Cancel</button> -->
                                </div>
                            </div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
@endsection