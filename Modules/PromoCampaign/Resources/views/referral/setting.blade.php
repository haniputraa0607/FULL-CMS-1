@php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
date_default_timezone_set('Asia/Jakarta');
@endphp
@extends('layouts.main')
@section('page-style')
<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
<style>
    .form-container.show-percent .percent-view{
        display: initial !important;
    }
    .form-container.show-percent div.percent-view{
        display: block !important;
    }
    .form-container.show-percent .input-group-addon.percent-view{
        display: table-cell !important;
    }
    .form-container.show-nominal .input-group-addon.nominal-view{
        display: table-cell !important;
    }
    .form-container.show-nominal .nominal-view{
        display: initial !important;
    }
    .form-container.show-discount .discount-view{
        display: initial !important;
    }
    .form-container.show-cashback .cashback-view{
        display: initial !important;
    }
    .percent-view,.nominal-view,.discount-view,.cashback-view{
        display: none;
    }
    .inactive .active_only{
        display: none !important;
    }
</style>
@endsection

@section('page-plugin')
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<!-- <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script> -->
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.form-toggler').on('change',function(){
        if($(this).val() == 'Percent'){
            $(this).parents('.form-container').addClass('show-percent');
            $(this).parents('.form-container').removeClass('show-nominal');
            $(this).parents('.form-container').find('.nominal-view input').attr('disabled','disabled');
            $(this).parents('.form-container').find('.percent-view input').removeAttr('disabled');
            //trigger change
            $('.percentable').change();
        }else if($(this).val() == 'Nominal'){
            $(this).parents('.form-container').addClass('show-nominal');
            $(this).parents('.form-container').removeClass('show-percent');
            $(this).parents('.form-container').find('.percent-view input').attr('disabled','disabled');
            $(this).parents('.form-container').find('.nominal-view input').removeAttr('disabled');
            //trigger change
            $('.percentable').change();
        }else if($(this).val() == 'Cashback'){
            $(this).parents('.form-container').addClass('show-cashback');
            $(this).parents('.form-container').removeClass('show-discount');
        }else if($(this).val() == 'Product Discount'){
            $(this).parents('.form-container').addClass('show-discount');
            $(this).parents('.form-container').removeClass('show-cashback');
        }else{
            $(this).parents('.form-container').removeClass('show-percent');
            $(this).parents('.form-container').removeClass('show-nominal');
            $(this).parents('.form-container').removeClass('show-discount');
            $(this).parents('.form-container').removeClass('show-cashback');
        }
    });
    $("#end_date").datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
        minuteStep: 5,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#start_date').datetimepicker('setEndDate', minDate);
    });
    $('.price').inputmask("numeric", {
        removeMaskOnSubmit: true,
        min:0,
        autoGroup: true,
        radixPoint: ",",
        groupSeparator: ".",
        rightAlign: false
    });
    $('#active_checkbox').on('switchChange.bootstrapSwitch',function(){
        var state=$(this).bootstrapSwitch('state');
        if(state){
            $('#super-container').removeClass('inactive');
        }else{
            $('#super-container').addClass('inactive');
        }
    });
    $('#super-container').on('keyup','.show-percent .percentable',function(){
        var value = parseInt($(this).val().replace('.',''));
        if(value > 100){
            $(this).val(100);
        }
    });
    $('.form-toggler').change();
    $('#active_checkbox').trigger('switchChange.bootstrapSwitch');
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
<form action="{{url()->current()}}" class="form-horizontal" method="post">
    @csrf
    <div id="super-container">
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue sbold uppercase">Referral Setting</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <label class="col-md-4 control-label">Status
                        <span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Status fitur referral" data-container="body"></i>
                    </label>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" id="active_checkbox" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" data-off-text="Inactive" value="1" name="referral_status" @if(old('referral_status')=='1' || $is_active) checked @endif>
                        </div>
                    </div>
                </div>
                <div class="active_only">
                    <div class="row">
                        <label class="col-md-4 control-label">Promo Name
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama yang akan ditampilkan saat penggunaan kode promo" data-container="body"></i>
                        </label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="promo_title" value="{{old('promo_title',$setting['promo_campaign']['promo_title'])}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-4 control-label">End Date
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Waktu selesainya promo referral" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group date bs-datetime">
                                    <input required autocomplete="off" id="end_date" type="text" class="form-control" name="date_end" placeholder="Start Date" value="{{ old('date_end',date('d F Y - H:i',strtotime($setting['promo_campaign']['date_end'])))}}">
                                    <span class="input-group-addon">
                                        <button class="btn default date-set" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-4 control-label">Minimum Total Transaction
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Total transaksi minimal yang diperlukan untuk mendapatkan bonus" data-container="body"></i>
                        </label>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group left-addon">
                                    <div class="input-group-addon">
                                        Rp
                                    </div>
                                    <input type="text" class="form-control price" name="referred_min_value" value="{{old('referred_min_value',$setting['referred_min_value'])}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet light portlet-fit bordered active_only">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue sbold uppercase">Recipient Bonus</span>
                </div>
            </div>
            <div class="portlet-body form-container">
                <div class="row">
                    <label class="col-md-4 control-label">Referred Bonus Type
                        <span class="required" aria-required="true"> *
                        </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Jenis bonus yang akan diterima pengguna baru" data-container="body"></i>
                    </label>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="referred_promo_type" id="referred-bonus-type" class="select2 form-control form-toggler" data-placeholder="Select one..." required>
                                <option value="Product Discount" @if(old('referred_promo_type',$setting['referred_promo_type'])=='Product Discount') selected @endif>Product Discount</option>
                                <option value="Cashback" @if(old('referred_promo_type',$setting['referred_promo_type'])=='Cashback') selected @endif>Cashback</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 control-label"><span class="discount-view">Discount</span><span class="cashback-view">Cashback</span> Type
                        <span class="required" aria-required="true"> *
                        </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Cara perhitungan bonus" data-container="body"></i>
                    </label>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="referred_promo_unit" id="referrer-promo-unit" class="select2 form-control form-toggler" required>
                                <option value="Percent" @if(old('referred_promo_unit',$setting['referred_promo_unit'])=='Percent') selected @endif>Percent</option>
                                <option value="Nominal" @if(old('referred_promo_unit',$setting['referred_promo_unit'])=='Nominal') selected @endif>Nominal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 control-label"><span class="discount-view">Discount</span><span class="cashback-view">Cashback</span> Value
                        <span class="required" aria-required="true"> *
                        </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Nilai bonus yang akan diberikan" data-container="body"></i>
                    </label>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon nominal-view">Rp</div>
                                <input type="text" class="form-control price percentable" data-reference="referred_promo_unit" name="referred_promo_value" value="{{old('referred_promo_value',$setting['referred_promo_value'])}}" required>
                                <div class="input-group-addon percent-view">%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row percent-view">
                    <label class="col-md-4 control-label">Maximum <span class="discount-view">Discount</span><span class="cashback-view">Cashback</span> Value
                        <span class="required" aria-required="true"> *
                        </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Nilai maksimum dari bonus yang dapat diperoleh" data-container="body"></i>
                    </label>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Rp</div>
                                <input type="text" class="form-control price" name="referred_promo_value_max" value="{{old('referred_promo_value_max',$setting['referred_promo_value_max'])}}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet light portlet-fit bordered active_only">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue sbold uppercase">Giver Bonus</span>
                </div>
            </div>
            <div class="portlet-body form-container">
                <div class="row">
                    <label class="col-md-4 control-label">Cashback Type
                        <span class="required" aria-required="true"> *
                        </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Cara perhitungan bonus" data-container="body"></i>
                    </label>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="referrer_promo_unit" id="referrer-promo-unit" class="select2 form-control form-toggler" required>
                                <option value="Percent" @if(old('referrer_promo_unit',$setting['referrer_promo_unit'])=='Percent') selected @endif>Percent</option>
                                <option value="Nominal" @if(old('referrer_promo_unit',$setting['referrer_promo_unit'])=='Nominal') selected @endif>Nominal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 control-label">Cashback Value
                        <span class="required" aria-required="true"> *
                        </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Nilai bonus yang akan diberikan" data-container="body"></i>
                    </label>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon nominal-view">Rp</div>
                                <input type="text" class="form-control price text-center percentable" data-reference="referrer_promo_unit" name="referrer_promo_value" value="{{old('referrer_promo_value',$setting['referrer_promo_value'])}}" required>
                                <div class="input-group-addon percent-view">%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row percent-view">
                    <label class="col-md-4 control-label">Maximum Cashback Value
                        <span class="required" aria-required="true"> *
                        </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Nilai maksimum dari bonus yang dapat diperoleh" data-container="body"></i>
                    </label>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Rp</div>
                                <input type="text" class="form-control price" name="referrer_promo_value_max" value="{{old('referrer_promo_value_max',$setting['referrer_promo_value_max'])}}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
        </div>
    </div>
</form>
@endsection