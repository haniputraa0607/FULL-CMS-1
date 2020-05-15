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
					<p style="white-space: pre-wrap;">This menu is used to import Deals Config.</p>
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
							@php //$deals_type = 'Deals' @endphp
							@if ( $deals_type == "Deals" )
		                    <div class="form-group">
		                        <label class="col-md-3 control-label"> Deals Periode <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Periode deals dimulai dan berakhir" data-container="body"></i> </label>
		                        <div class="col-md-4">
		                            <div class="input-icon right">
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control" name="deals_start" value="{{ !empty($deals['deals_start']) || old('deals_start') ? date('d-M-Y H:i', strtotime(old('deals_start')??$deals['deals_start'])) : ''}}" required autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-md-4">
		                            <div class="input-icon right">
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control" name="deals_end" value="{{ !empty($deals['deals_end']) || old('deals_end') ? date('d-M-Y H:i', strtotime(old('deals_end')??$deals['deals_end'])) : ''}}" required autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    @endif

		                    @if ($deals_type == "Deals")
		                    <div class="form-group">
		                        <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Periode deals dipublish dimulai dan berakhir" data-container="body"></i> </label>
		                        <div class="col-md-4">
		                            <div class="input-icon right">
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control" name="deals_publish_start" value="{{ !empty($deals['deals_publish_start']) || old('deals_publish_start') ? date('d-M-Y H:i', strtotime(old('deals_publish_start')??$deals['deals_publish_start'])) : '' }}" required autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-md-4">
		                            <div class="input-icon right">
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control" name="deals_publish_end" value="{{ !empty($deals['deals_publish_end']) || old('deals_publish_end') ? date('d-M-Y H:i', strtotime(old('deals_publish_end')??$deals['deals_publish_end'])) : '' }}" required autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    @endif

		                    <div class="form-group">
		                        <div class="input-icon right">
		                            <label class="col-md-3 control-label">
		                            Voucher Start Date
		                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan, kosongkan bila voucher tidak memiliki minimal tanggal penggunaan" data-container="body"></i>
		                            </label>
		                        </div>
		                        <div class="col-md-4">
		                            <div class="input-icon right">
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control" name="deals_voucher_start" value="{{ ($start_date=old('deals_voucher_start',($deals['deals_voucher_start']??false)))?date('d-M-Y H:i',strtotime($start_date)):'' }}" autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan" data-container="body"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="form-group">
		                        <div class="input-icon right">
		                            <label class="col-md-3 control-label">
		                            Voucher Expiry
		                            <span class="required" aria-required="true"> * </span>
		                            <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
		                            </label>
		                        </div>
		                        <div class="col-md-3">
		                            <div class="md-radio-inline">
		                                <div class="md-radio">
		                                    <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required
		                                    	@if ( old('duration') ) checked
		                                    		@if ( old('duration') == "dates" ) checked
		                                    		@endif
		                                    	@elseif (!empty($deals['deals_voucher_expired'])) checked
		                                    	@endif>
		                                    <label for="radio9">
		                                        <span></span>
		                                        <span class="check"></span>
		                                        <span class="box"></span> By Date </label>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-md-3">
		                            <div class="md-radio-inline">
		                                <div class="md-radio">
		                                    <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required
		                                    	@if ( old('duration') ) checked
		                                    		@if ( old('duration') == "duration" ) checked
		                                    		@endif
		                                    	@elseif ( !empty($deals['deals_voucher_duration']) ) checked
		                                    	@endif>
		                                    <label for="radio10">
		                                        <span></span>
		                                        <span class="check"></span>
		                                        <span class="box"></span> Duration </label>
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="form-group" id="times"
		                    	@if (old('duration') || (!empty($deals['deals_voucher_expired']) || !empty($deals['deals_voucher_duration'])) ) style="display: block;"
		                    	@else
		                    		style="display: none;"
		                    	@endif>
		                        <label class="col-md-3 control-label"></label>
		                        <div class="col-md-9">
		                            <div class="col-md-3">
		                                <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
		                            </div>
		                            <div class="col-md-9 voucherTime" id="dates"
		                            	@if (old('duration') == "dates") style="display: block;"
		                            	@elseif (empty($deals['deals_voucher_expired'])) style="display: none;"
		                            	@endif>
		                                <div class="input-group">
		                                    <input type="text" class="form_datetime form-control dates durationOpp" name="deals_voucher_expired" @if (old('deals_voucher_expired') || !empty($deals['deals_voucher_expired'])) value="{{ date('d-M-Y H:i', strtotime(old('deals_voucher_expired')??$deals['deals_voucher_expired'])) }}" @endif autocomplete="off">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
		                            </div>
		                            <div class="col-md-9 voucherTime" id="duration"
		                            	@if (old('duration') == "duration") style="display: block;"
		                            	@elseif (empty($deals['deals_voucher_duration'])) style="display: none;"
		                            	@endif>
		                                <div class="input-group">
		                                    <input type="text" min="1" class="form-control duration datesOpp digit-mask" name="deals_voucher_duration" value="{{ old('deals_voucher_duration')??$deals['deals_voucher_duration']??'' }}" autocomplete="off">
		                                    <span class="input-group-addon">
		                                        day after claimed
		                                    </span>
		                                </div>

		                            </div>
		                        </div>
		                    </div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Import config <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="File import berasal dari menu deals" data-container="body"></i> </label>
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
							<input type="hidden" name="deals_type" value="{{ $deals['deals_type']??$deals_type??'' }}">
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